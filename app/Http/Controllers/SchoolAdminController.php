<?php

namespace App\Http\Controllers;

use App\Models\ClassRoutine;
use App\Models\ClassSection;
use App\Models\ClassW;
use App\Models\Enroll;
use App\Models\ExpenseInvoice;
use App\Models\Fee;
use App\Models\Invoice;
use App\Models\InvoiceItems;
use App\Models\Scholarship;
use App\Models\School;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Transport;
use App\Models\Teacher;
use App\User;
use Carbon\Carbon;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\InvoiceTransportItems;
use App\Helpers\NepaliCalender;
use Illuminate\Support\Facades\Auth;

class SchoolAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $system_settings = School::where('user_id', Auth::user()->id)->first();
            view()->share('system_settings', $system_settings);

            return $next($request);

        });
    }

    private function getFeeByCategoryName($name)
    {
        $fee_category = Fee::where('name','like', '%'.$name.'%')->where('is_active',1)->pluck('id');
        $invoice_ids = Invoice::where('school_id', Auth::user()->school->id)->where('is_active',1)->where('previous_or_not',0)->Where('due',0)->where('status',1)->where('year', Auth::user()->school->detail->running_session)->pluck('id');
        $invoice_items = InvoiceItems::whereIn('fee_category_id', $fee_category)->whereIn('invoice_id', $invoice_ids)->get();
        $total = array();
        foreach ($invoice_items as $item)
        {
            if($item->is_half == 1)
            {
                array_push($total, $item->quantity * $item->halfFee->half_amount);
            }else{
                array_push($total, $item->quantity * $item->fee->amount);
            }
        }

        return array_sum($total);
    }

    private function transportation()
    {
        $invoice_ids = Invoice::where('school_id', Auth::user()->school->id)->where('is_active',1)->where('previous_or_not',0)->Where('due',0)->where('status',1)->where('year', Auth::user()->school->detail->running_session)->pluck('id');
        $tranport_items = InvoiceTransportItems::whereIn('invoice_id', $invoice_ids)->get();
        $amount = array();
        foreach ($tranport_items as $items)
        {
            $amt = $items->invoice->student->transport->fare * $items->quantity;
            array_push($amount, $amt);
        }
        return array_sum($amount);
    }

    private function invoiceSummary()
    {
        $monthly_fee = $this->getFeeByCategoryName('Monthly Fee');
        $annual_fee = $this->getFeeByCategoryName('Annual Fee');
        $id_card_fee = $this->getFeeByCategoryName('ID Card');
        $exam_fee = $this->getFeeByCategoryName('Exam Fee');
        $stationary = $this->getFeeByCategoryName('Stationery (Whole Year)');
        $computer_fee = $this->getFeeByCategoryName('Computer Fee');
        $belt = $this->getFeeByCategoryName('Belt');
        $calendar = $this->getFeeByCategoryName('Calendar');
        $diary = $this->getFeeByCategoryName('Diary');
        $bow_tie = $this->getFeeByCategoryName('Bow Tie');
        $tie_short = $this->getFeeByCategoryName('Short Tie');
        $tie_long = $this->getFeeByCategoryName('Tie Long');
        $book_lkg = $this->getFeeByCategoryName('LKG Book Set');
        $book_ukg = $this->getFeeByCategoryName('UKG Book Set');
        $book_nursery = $this->getFeeByCategoryName('Nursery Book Set');
        $stocking_socks = $this->getFeeByCategoryName('Stocking Socks');
        $trac = $this->getFeeByCategoryName('Track-Suit(16/24)') + $this->getFeeByCategoryName('Track-Suit(18/28)') + $this->getFeeByCategoryName('Track-Suit(20/30)') + $this->getFeeByCategoryName('Track-Suit(22/32)') + $this->getFeeByCategoryName('Track-Suit(24/34)') +  $this->getFeeByCategoryName('Track-Suit(26/38)') + $this->getFeeByCategoryName('Track-Suit(28/40)');
        $trac_extra_tution = $this->getFeeByCategoryName('Extra Tuition Class (Monthly)');
        $day_boarders = $this->getFeeByCategoryName('Day Boader\'s Fee');
        $h_w_copy_set = $this->getFeeByCategoryName('H/W Copy Set') + $this->getFeeByCategoryName('H/W Copy');
        //$book_set = $this->getFeeByCategoryName('Book Set');
        $extrac_coaching = $this->getFeeByCategoryName('Extra Coaching Class(Monthly)');
        $hostel_fee = $this->getFeeByCategoryName('Hostel Fee');
        $sweater = $this->getFeeByCategoryName('Sweater(24)') + $this->getFeeByCategoryName('Sweater(26)') + $this->getFeeByCategoryName('Sweater(28)') + $this->getFeeByCategoryName('Sweater(30)')  + $this->getFeeByCategoryName('Sweater(32)') + $this->getFeeByCategoryName('Sweater(34)') + $this->getFeeByCategoryName('Sweater(36)') + $this->getFeeByCategoryName('Sweater(38)') + $this->getFeeByCategoryName('Sweater(42)');
        $festival_kids_h_w_copy = $this->getFeeByCategoryName('Festival Kids H/W Copy');
        $cap = $this->getFeeByCategoryName('Cap');
        $muffler = $this->getFeeByCategoryName('Muffler');
        $copy = $this->getFeeByCategoryName('copy');
        $school_copy = $this->getFeeByCategoryName('School  copy');
        $pencil = $this->getFeeByCategoryName('pencil');
        $sharpner = $this->getFeeByCategoryName('Sharpener');
        $tie_belt_sweater_track_suit = $this->getFeeByCategoryName('tie/belt/sweater/track/suit');
        $eraser_pencil_sharpener = $this->getFeeByCategoryName('Eraser/pencil/sharpener');
        $eraser = $this->getFeeByCategoryName('eraser');
        $book = $this->getFeeByCategoryName('book');
        $stationery_half_year = $this->getFeeByCategoryName('stationery(half year)');
        $mask = $this->getFeeByCategoryName('mask');
        // $long_tie = $this->getFeeByCategoryName('Long Tie');
        $transport = $this->transportation();

        //$sweater = 0;
        // $cap = 0;
        // $muffler = 0;

        $total = $monthly_fee + $annual_fee + $id_card_fee + $exam_fee + $stationary + $computer_fee + $belt + $calendar + $diary + $bow_tie + $tie_short + $tie_long + $book_lkg + $book_ukg + $book_nursery + $trac + $trac_extra_tution + $day_boarders + $h_w_copy_set /*+ $book_set*/ + $extrac_coaching + $sweater + $cap + $muffler + $transport + $hostel_fee + $stocking_socks + $festival_kids_h_w_copy + $copy + $school_copy + $pencil + $sharpner + $tie_belt_sweater_track_suit + $eraser_pencil_sharpener + $eraser + $book + $stationery_half_year + $mask;

        return $total;
    }

    public function index()
    {
        $page = 'Dashboard';
        $unpaid_invoices =  Invoice::where('year', Auth::user()->school->detail->running_session)->where('school_id', Auth::user()->school->id)->where('status',0)->where('previous_or_not',0)->where('is_active',1)->count();

        // $invoices = Invoice::where('year', Auth::user()->school->detail->running_session)->whereBetween('invoice_date', ['2020-11-16', '2020-11-24'])->get();

        // $calendar = new NepaliCalender();
        // $english_date = '2020-02-20';
        // $month = date("m",strtotime($english_date));
        // $year = date("Y",strtotime($english_date));
        // $day = date("d",strtotime($english_date));
        // $cal = $calendar->eng_to_nep($year, $month, $day);
        // $nepali_date = $cal['year'] . '-' . $cal['month'] . '-' . $cal['date'];

        // foreach ($invoices as $invoice) {

        //     $update_date = Invoice::find($invoice->id);
        //     $update_date->invoice_date = $english_date;
        //     $update_date->invoice_date_nepali = $nepali_date;
        //     $update_date->update();
        // }
        // dd($invoices);
        /*$paid_invoices = Invoice::where('school_id', Auth::user()->school->id)->where('is_active',1)->where('previous_or_not',0)->Where('due',0)->where('status',1)->where('year', Auth::user()->school->detail->running_session)->get();*/
        $total_income = $this->invoiceSummary();
        $expenses = ExpenseInvoice::where('year', Auth::user()->school->detail->running_session)->where('school_id', Auth::user()->school->id)->where('is_active',1)->get();
        /*$total_income = array();
        foreach ($paid_invoices as $invoice)
        {
            array_push($total_income, $invoice->amount);
        }*/

        $total_expense = array();
        foreach ($expenses as $exp)
        {
            array_push($total_expense, $exp->amount);
        }

        $teacher_ids = Teacher::where('school_id', Auth::user()->school->id)->pluck('user_id')->toArray();

        $number_of_teachers = User::whereIn('id', $teacher_ids)->where('is_active',1)->count();

        $today_attendace_present = Attendance::where('school_id',Auth::user()->school->id)->where('status', 1)->where('year', Auth::user()->school->detail->running_session)->where('date', Carbon::now()->format('Y-m-d'))->count();

        $system_settings = School::where('user_id', Auth::user()->id)->first();
        $students = Enroll::where('is_active',1)->where('year', $system_settings->detail->running_session)->get();

        return view('school_admin.index', compact('page', 'unpaid_invoices', 'total_income', 'total_expense', 'number_of_teachers', 'today_attendace_present', 'students'));
    }

    public function nepaliCaledar()
    {
        $page = 'Nepali Calendar';
        return view('school_admin.nepali_calendar', compact('page'));
    }

    public function getStudents($id)
    {
        $class = ClassW::find($id);

        $enrolls = Enroll::where('class_id', $class->id)->where('school_id', Auth::user()->school->id)->where('year', Auth::user()->school->detail->running_session)->where('is_active',1)->get();

        foreach ($enrolls as $row)
        {
            echo '<option></option>';
            echo '<option value="'. $row->student->id .'">'.$row->student->user->name.'</option>';
        }
    }

    public function getClassFee($id)
    {
        $class = ClassW::find($id);

        $fee_categories = Fee::where('class_id', $class->id)->where('school_id', Auth::user()->school->id)->where('is_active',1)->where('has_half_amount', 0)->get();

        foreach ($fee_categories as $row)
        {
            if($row->name == 'Monthly Fee'){
                echo '<tr><td><input type="hidden" name="fee_ids[]" value="'.$row->id.'"><input type="hidden" name="discount[]" value="1"><input type="text" name="particulars[]" class="form-control" value="'.$row->name.'"></td><td><input name="quantity[]" type="number" min="0" class="form-control"></td><td><input type="text" class="form-control" value="'.$row->amount.'" name="fee_amount[]" readonly></td><td><input type="button" class="btn btn-sm btn-rounded btn-outline-danger" value="Delete" onclick="deleteRow(this.parentNode.parentNode.rowIndex)"></td></tr>';
            }else{
                echo '<tr><td><input type="hidden" name="fee_ids[]" value="'.$row->id.'"><input type="hidden" name="discount[]" value="0"><input type="text" name="particulars[]" class="form-control" value="'.$row->name.'"></td><td><input name="quantity[]" type="number" min="0" class="form-control"></td><td><input type="text" class="form-control" value="'.$row->amount.'" name="fee_amount[]" readonly></td><td><input type="button" class="btn btn-sm btn-rounded btn-outline-danger" value="Delete" onclick="deleteRow(this.parentNode.parentNode.rowIndex)"></td></tr>';
            }
        }
    }

    public function getClassFeeHalf($id)
    {
        $class = ClassW::find($id);

        $fee_categories = Fee::where('class_id', $class->id)->where('school_id', Auth::user()->school->id)->where('is_active',1)->where('has_half_amount', 1)->get();

        foreach ($fee_categories as $row)
        {

            echo '<tr><td><input type="hidden" name="half_fee_ids[]" value="'.$row->id.'"><input type="text" name="half_particulars[]" class="form-control" value="'.$row->name.'"></td><td><input name="half_quantity[]" type="number" min="0" class="form-control"></td><td><input type="text" class="form-control" value="'.$row->half_amount.'" name="half_fee_amount[]" readonly></td><td><input type="button" class="btn btn-sm btn-rounded btn-outline-danger" value="Delete" onclick="deleteRow1(this.parentNode.parentNode.rowIndex)"></td></tr>';
        }
    }

    public function getStudentTransport($id)
    {
        $student = Student::find($id);

        $transport = Transport::where('id', $student->transport_id)->first();

        if($transport){
            echo '<div class="form-group"><label class="col-form-label">Transportation Amount</label><input type="number" class="form-control" name="transport_amount" value="'.$transport->fare.'"></div><div class="form-group"><label class="col-form-label">Transportation Quantity</label><input type="number" class="form-control" name="transport_qty" min="0"></div>';
        }
    }

    public function getStudentScholarship($id)
    {
        $student = Student::find($id);
        $scholarship = Scholarship::where('id', $student->scholarship_id)->first();
        if($scholarship)
        {
            echo '<i>This student has '.$scholarship->percentage.'% scholarship which will be deducted brom monthly feee.</i>';
            echo '<br />';
            echo '<i>Please first set the amount to be paid to zero and save invoice and take payment for that from all invoices section.</i>';
        }
    }

    public function getStudentPreviousInvoice($id)
    {
        $student = Student::find($id);
        $invoice = Invoice::where('student_id',$student->id)->where('due','>',0)->where('status', 0)->where('is_active',1)->where('school_id', Auth::user()->school->id)->where('previous_or_not',0)->where('year', Auth::user()->school->detail->running_session)->first();
        if($invoice){
            echo '<div class="form-group"><label class="col-form-label">Previous Invoice Id</label><input type="number" class="form-control" name="previous_invoice_id" value="'.$invoice->id.'"></div><div class="form-group"><label class="col-form-label">Amount</label><input type="number" class="form-control" value="'.  $invoice->due .'" disabled></div>';
        }
        echo '<div class="form-group"><label class="col-form-label">Previous Year Amount</label><input type="number" class="form-control" min="0" name="previous_year_amount"></div>';
    }

    public function getClassFeeInDropDown($id)
    {
        $class = ClassW::find($id);

        $fee_categories = Fee::where('class_id', $class->id)->where('school_id', Auth::user()->school->id)->where('is_active',1)->get();

        foreach ($fee_categories as $row)
        {
            echo '<option></option>';
            echo '<option value="'.$row->id.'">"'.$row->name.'"</option>';
        }
    }

    public function getClassSectionInDropDown($id)
    {
        $class = ClassW::find($id);

        $class_sections = ClassSection::where('class_id', $class->id)->where('school_id', Auth::user()->school->id)->get();

        foreach ($class_sections as $row)
        {
            echo '<option></option>';
            echo '<option value="'.$row->id.'">'.$row->name.'</option>';
        }
    }

    public function getSectionRoutineInDropDown($id)
    {
        $section = ClassSection::find($id);

        $routines = ClassRoutine::where('section_id', $section->id)->where('year', Auth::user()->school->detail->running_session)->get();

        foreach ($routines as $row)
        {
            echo '<option></option>';
            echo '<option value="'.$row->id.'">'.$row->day.'</option>';
        }
    }

    function getClassSubjectInDropDown($id)
    {
        $class = ClassW::find($id);

        $subjects = Subject::where('class_id', $class->id)->where('school_id', Auth::user()->school->id)->where('mark_optional',1)->where('is_active',1)->get();

        foreach ($subjects as $row)
        {
            echo '<option></option>';
            echo '<option value="'.$row->id.'">'.$row->name.'</option>';
        }
    }

    public function getClassOptionalSubjectInDropDown($id)
    {
        $class = ClassW::find($id);

        $subjects = Subject::where('class_id', $class->id)->where('school_id', Auth::user()->school->id)->where('mark_optional',0)->where('is_active',1)->get();

        foreach ($subjects as $row)
        {
            echo '<option></option>';
            echo '<option value="'.$row->id.'">'.$row->name.'</option>';
        }
    }

    public function get_students_to_promote($from_class_id, $to_class_id, $running_year, $promotion_year)
    {
        $from_class_id = $from_class_id;
        $to_class_id = $to_class_id;
        $running_year = $running_year;
        $promotion_year = $promotion_year;
        $class = ClassW::find($from_class_id);
        $to_class = ClassW::find($to_class_id);
        $enrolls = Enroll::where('class_id', $class->id)->where('year', Auth::user()->school->detail->running_session)->where('is_active',1)->get();

        return view('school_admin.student.promotion.selector', compact('from_class_id', 'to_class_id', 'running_year', 'promotion_year', 'class', 'enrolls', 'to_class'));
    }
}
