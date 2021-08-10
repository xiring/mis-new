<?php

namespace App\Http\Controllers;

use App\Models\ClassSection;
use App\Models\Attendance;
use App\Models\ClassW;
use App\Models\Enroll;
use App\Models\ExpenseCategory;
use App\Models\ExpenseInvoice;
use App\Models\Fee;
use App\Models\Invoice;
use App\Models\Scholarship;
use App\Models\School;
use App\Models\Student;
use App\Models\Transport;
use App\Models\InvoiceTransportItems;
use App\Models\InvoiceItems;
use Carbon\Carbon;
use App\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Helpers\NepaliCalender;
use NumberToWords\NumberToWords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

class AccountantDashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $system_settings = School::where('id', Session::get('school_id'))->first();
            view()->share('system_settings', $system_settings);

            return $next($request);

        });
    }

    public function nepaliCaledar()
    {
        $page = 'Nepali Calendar';
        return view('account_admin.nepali_calendar', compact('page'));
    }

    public function getStudents($id)
    {
        $class = ClassW::find($id);

        $school = School::find(Session::get('school_id'));

        $enrolls = Enroll::where('class_id', $class->id)->where('school_id', $school->id)->where('year', $school->detail->running_session)->where('is_active',1)->get();

        foreach ($enrolls as $row)
        {
            echo '<option></option>';
            echo '<option value="'. $row->student->id .'">'.$row->student->user->name.'</option>';
        }
    }

    public function getClassFee($id)
    {
        $class = ClassW::find($id);

        $school = School::find(Session::get('school_id'));

        $fee_categories = Fee::where('class_id', $class->id)->where('school_id', $school->id)->where('is_active',1)->where('has_half_amount', 0)->get();

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
        $school = School::find(Session::get('school_id'));

        $class = ClassW::find($id);

        $fee_categories = Fee::where('class_id', $class->id)->where('school_id', $school->id)->where('is_active',1)->where('has_half_amount', 1)->get();

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
        $school = School::find(Session::get('school_id'));
        $invoice = Invoice::where('student_id',$student->id)->where('due','>',0)->where('status', 0)->where('is_active',1)->where('previous_or_not',0)->where('year', $school->detail->running_session)->where('school_id', $school->id)->first();
        if($invoice){
            echo '<div class="form-group"><label class="col-form-label">Previous Invoice Id</label><input type="number" class="form-control" name="previous_invoice_id" value="'.$invoice->id.'"></div><div class="form-group"><label class="col-form-label">Amount</label><input type="number" class="form-control" value="'.  $invoice->due .'" disabled></div>';
        }
        echo '<div class="form-group"><label class="col-form-label">Previous Year Amount</label><input type="number" class="form-control" min="0" name="previous_year_amount"></div>';
    }

    private function getFeeByCategoryName($name)
    {
        $school = School::where('id', Session::get('school_id'))->first();
        $fee_category = Fee::where('name','like', '%'.$name.'%')->where('is_active',1)->pluck('id');
        $invoice_ids = Invoice::where('school_id',$school->id)->where('is_active',1)->where('previous_or_not',0)->Where('due',0)->where('status',1)->where('year',$school->detail->running_session)->pluck('id');
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
        $school = School::where('id', Session::get('school_id'))->first();
        $invoice_ids = Invoice::where('school_id', $school->id)->where('is_active',1)->where('previous_or_not',0)->Where('due',0)->where('status',1)->where('year', $school->detail->running_session)->pluck('id');
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

    public function index(){

        $page = 'Dashboard';
        $school = School::where('id', Session::get('school_id'))->first();
        $unpaid_invoices =  Invoice::where('year', $school->detail->running_session)->where('school_id', $school->id)->where('status',0)->where('previous_or_not',0)->where('is_active',1)->count();
       /* $paid_invoices = Invoice::where('year', $school->detail->running_session)->where('school_id', $school->id)->where('status',1)->Where('due',0)->where('previous_or_not',0)->where('is_active',1)->get();*/
        $expenses = ExpenseInvoice::where('year', $school->detail->running_session)->where('school_id',$school->id)->where('is_active',1)->get();
        $total_income = $total_income = $this->invoiceSummary();;
        /*foreach ($paid_invoices as $invoice)
        {
            array_push($total_income, $invoice->amount);
        }*/

        $total_expense = array();
        foreach ($expenses as $exp)
        {
            array_push($total_expense, $exp->amount);
        }

        $teacher_ids = Teacher::where('school_id', $school->id)->pluck('user_id')->toArray();

        $number_of_teachers = User::whereIn('id', $teacher_ids)->where('is_active',1)->count();

        $today_attendace_present = Attendance::where('school_id',$school->id)->where('status', 1)->where('year',$school->detail->running_session)->where('date', Carbon::now()->format('Y-m-d'))->count();

        $system_settings = School::where('user_id', Auth::user()->id)->first();
        $students = Enroll::where('is_active',1)->where('year', $system_settings->detail->running_session)->get();

        return view('account_admin.index', compact('page', 'unpaid_invoices', 'total_income', 'total_expense', 'number_of_teachers', 'today_attendace_present', 'students'));

    }


    ///Transport Methods

    public function transport()
    {
        $page = 'Transports';

        $transports = Transport::where('school_id', Session::get('school_id'))->orderBy('created_at', 'ASC')->get();

        return view('account_admin.transport.index', compact('transports', 'page')) ;
    }

    public function transportStore(Request $request)
    {
        $transport = new Transport();
        $transport->school_id = $request->school_id;
        $transport->name = $request->name;
        $transport->number_of_vehicle = $request->number_of_vehicle;
        $transport->fare = $request->fare;

        if($transport->save()):
            flash('Transport route  ' .$transport->name . ' was added successfully.','success');
            return redirect()->back();
        endif;
    }

    public function transportUpdate(Request $request)
    {
        $transport = Transport::find($request->id);
        $transport->name = $request->name;
        $transport->number_of_vehicle = $request->number_of_vehicle;
        $transport->fare = $request->fare;

        if($transport->update()):
            flash('Transport route  ' .$transport->name . ' was updated successfully.','success');
            return redirect()->back();
        endif;
    }

    public function transportDelete($id)
    {
        $transport = Transport::find($id);
        $transport->is_active = 0;

        if($transport->update()):
            flash('Transport route  ' .$transport->name . ' was deleted successfully.','warning');
            return redirect()->back();
        endif;
    }

    public function transportRestore($id)
    {
        $transport = Transport::find($id);
        $transport->is_active = 1;

        if($transport->update()):
            flash('Transport route  ' .$transport->name . ' was restored successfully.','success');
            return redirect()->back();
        endif;
    }

    public function transportStudents($id)
    {
        $page = 'Transports';
        $transport = Transport::find($id);
        $students = Student::where('transport_id', $id)->get();

        return view('account_admin.transport.students', compact('transport', 'page', 'students')) ;
    }

    public function transportStudentRemove($id)
    {
        $student = Student::find($id);

        $student->transport_id = 0;

        if($student->update()):
            flash('Student ' .$student->user->name . ' was has been successfully removed.','warning');
            return redirect()->back();
        endif;
    }

    //Expense Category Crud
    public function expense()
    {
        $page = 'Expense Category';

        $categories = ExpenseCategory::where('school_id', Session::get('school_id'))->orderBy('created_at', 'ASC')->get();

        return view('account_admin.accounting.expense.index', compact('categories', 'page')) ;
    }

    public function expenseStore(Request $request)
    {
        $category = new ExpenseCategory();
        $category->name = $request->name;
        $category->school_id = $request->school_id;

        if($category->save()){

            flash('Expense category' . $category->name. 'has been successfully added.' ,'success');
            return redirect()->back();
        }
    }

    public function expenseUpdate(Request $request)
    {
        $category = ExpenseCategory::find($request->id);
        $category->name = $request->name;

        if($category->update()){

            flash('Expense category' . $category->name. 'has been successfully updated.' ,'success');
            return redirect()->back();
        }
    }

    public function expenseDelete($id)
    {
        $category = ExpenseCategory::find($id);
        $category->is_active = 0;

        if($category->update()):
            flash('Expense category  ' .$category->name . ' was deleted successfully.','warning');
            return redirect()->back();
        endif;
    }

    public function expenseRestore($id)
    {
        $category = ExpenseCategory::find($id);
        $category->is_active = 1;

        if($category->update()):
            flash('Expense category  ' .$category->name . ' was restored successfully.','warning');
            return redirect()->back();
        endif;
    }

    public function  expenseInvoice()
    {
        $page = 'Expense Invoice';

        $categories = ExpenseCategory::orderBy('created_at', 'ASC')->where('school_id', Session::get('school_id'))->where('is_active',1)->get();
        $invoices = ExpenseInvoice::orderBy('created_at', 'ASC')->where('school_id',Session::get('school_id'))->get();

        return view('account_admin.accounting.expense.invoice', compact('page', 'categories', 'invoices'));
    }

    public function expenseInvoiceStore(Request $request)
    {
        $invoice = new ExpenseInvoice();
        $invoice->school_id = $request->school_id;
        $invoice->expense_category_id = $request->expense_category_id;
        $invoice->title = $request->title;
        $invoice->description = $request->description;
        $invoice->amount = $request->amount;
        $invoice->date = Carbon::parse($request->date);
        $invoice->year = Auth::user()->school->detail->running_session;

        if($invoice->save()){

            flash('Invoice for ' . $invoice->category->name. ' has been successfully added.' ,'success');
            return redirect()->back();
        }
    }

    public function expenseInvoiceUpdate(Request $request)
    {
        $invoice = ExpenseInvoice::find($request->id);
        $invoice->expense_category_id = $request->expense_category_id;
        $invoice->title = $request->title;
        $invoice->description = $request->description;
        $invoice->amount = $request->amount;
        $invoice->date = Carbon::parse($request->date);

        if($invoice->update()){

            flash('Invoice for ' . $invoice->category->name. ' has been successfully updated.' ,'success');
            return redirect()->back();
        }
    }

    public function expenseInvoiceDelete($id)
    {
        $invoice = ExpenseInvoice::find($id);
        $invoice->is_active = 0;

        if($invoice->update()):
            flash('Invoice for ' . $invoice->category->name. ' has been successfully updated.' ,'warning');
            return redirect()->back();
        endif;
    }

    public function expenseInvoiceRestore($id)
    {
        $invoice = ExpenseInvoice::find($id);
        $invoice->is_active = 1;

        if($invoice->update()):
            flash('Invoice for ' . $invoice->category->name. ' has been successfully restored.' ,'success');
            return redirect()->back();
        endif;
    }

    public function fee()
    {
        $page = 'Fee Category';

        $classes = ClassW::where('school_id', Session::get('school_id'))->where('is_active',1)->get();
        $categories = Fee::orderBy('created_at', 'ASC')->get();

        return view('account_admin.accounting.fee_category.index', compact('page', 'categories', 'classes'));
    }

    public function store(Request $request)
    {
        $category = new Fee();
        $category->school_id = $request->school_id;
        $category->class_id = $request->class_id;
        $category->name = $request->name;
        $category->amount = $request->amount;

        if($category->save()){

            flash('Fee category' . $category->name. 'has been successfully added.' ,'success');
            return redirect()->back();
        }
    }

    public function feeUpdate(Request $request)
    {
        $category = Fee::find($request->id);
        $category->class_id = $request->class_id;
        $category->name = $request->name;
        $category->amount = $request->amount;

        if($category->update()){

            flash('Fee category' . $category->name. 'has been successfully updated.' ,'success');
            return redirect()->back();
        }
    }

    public function feeDelete($id)
    {
        $category = Fee::find($id);
        $category->is_active = 0;

        if($category->update()):
            flash('Fee category  ' .$category->name . ' was deleted successfully.','warning');
            return redirect()->back();
        endif;
    }

    public function feeRestore($id)
    {
        $category = Fee::find($id);
        $category->is_active = 1;

        if($category->update()):
            flash('Fee category  ' .$category->name . ' was restored successfully.','success');
            return redirect()->back();
        endif;
    }

    public function scholarship()
    {
        $page = 'Scholarships';

        $scholarships = Scholarship::orderBy('created_at', 'ASC')->where('school_id', Session::get('school_id'))->get();

        return view('account_admin.accounting.scholarship.index', compact('page', 'scholarships'));
    }

    public function scholarshipStore(Request $request)
    {
        $scholarship = new Scholarship();
        $scholarship->school_id = $request->school_id;
        $scholarship->name = $request->name;
        $scholarship->percentage = $request->percentage;

        if($scholarship->save()){

            flash('Scholarship category' . $scholarship->name. 'has been successfully added.' ,'success');
            return redirect()->back();
        }
    }

    public function scholarshipUpdate(Request $request)
    {
        $scholarship = Scholarship::find($request->id);
        $scholarship->name = $request->name;
        $scholarship->percentage = $request->percentage;

        if($scholarship->update()){

            flash('Scholarship category' . $scholarship->name. 'has been successfully updated.' ,'success');
            return redirect()->back();
        }
    }

    public function scholarshipDelete($id)
    {
        $scholarship = Scholarship::find($id);
        $scholarship->is_active = 0;

        if($scholarship->update()):
            flash('Scholarship category  ' .$scholarship->name . ' was deleted successfully.','warning');
            return redirect()->back();
        endif;
    }

    public function scholarshipRestore($id)
    {
        $scholarship = Scholarship::find($id);
        $scholarship->is_active = 1;

        if($scholarship->update()):
            flash('Scholarship category  ' .$scholarship->name . ' was restored successfully.','warning');
            return redirect()->back();
        endif;
    }

    public function scholarshipStudents($id)
    {
        $page = 'Scholarships';
        $scholarship = Scholarship::where('id', $id)->first();

        $students = Student::where('scholarship_id', $scholarship->id)->get();

        return view('account_admin.accounting.scholarship.students', compact('page', 'students', 'scholarship'));
    }

    public function scholarshipStudentRemove($id)
    {
        $student = Student::find($id);

        $student->scholarship_id = 0;

        if($student->update()):
            flash('Student ' .$student->user->name . ' was has been successfully removed.','warning');
            return redirect()->back();
        endif;
    }

    public function invoice()
    {
        $page = 'All Invoices';
        $school = School::find(Session::get('school_id'));
        $invoices = Invoice::orderBy('created_at', 'ASC')->where('year', $school->detail->running_session)->where('school_id', $school->id)->where('previous_or_not', 0)->where('is_active',1)->get();

        return view('account_admin.accounting.invoice.index', compact('page', 'invoices'));
    }

    public function invoiceView($id)
    {
        $page = 'View';

        $invoice = Invoice::find($id);
        $monthly_fee_category = Fee::where('class_id', $invoice->class_id)->where('name', 'Monthly Fee')->first();

        return view('account_admin.accounting.invoice.view', compact('page', 'invoice', 'monthly_fee_category'));
    }

    public function invoiceCreate()
    {
        $page = 'Create Student Invoice';

        $classes = ClassW::where('school_id', Session::get('school_id'))->where('is_active',1)->orderBy('numeric_name', 'ASC')->get();

        return view('account_admin.accounting.invoice.create', compact('page', 'classes'));
    }

    public function invoiceStore(Request $request)
    {
        $invoice = new Invoice();
        $invoice->school_id = $request->school_id;
        $invoice->class_id = $request->class_id;
        $invoice->student_id = $request->student_id;

        $monthly_cat = Fee::where('class_id', $request->class_id)->where('school_id',$request->school_id)->where('name', 'like', '%Monthly Fee%')->first();

        if($request->previous_invoice_id) {

            $previous_invoice = Invoice::where('id', $request->previous_invoice_id)->first();
            $previous_invoice_id = $previous_invoice->id;
            $previous_invoice_amount = $previous_invoice->due;

        }else{

            $previous_invoice_id = 0;
            $previous_invoice_amount = 0;

        }


        $student = Student::find($request->student_id);

        if($student->scholarship_id != 0)
        {
            $scholarship_percentage = $student->scholarship->percentage;
        }else{
            $scholarship_percentage = 0;
        }

        if(!is_null($request->transport_qty)){
            $tranport_qty = $request->transport_qty;
            $transport_fee = $request->transport_amount;
            $transport_total = $transport_fee * $tranport_qty;

        }else{
            $transport_total = 0;
        }

        $quantities = $request->quantity;
        $fee_ids = $request->fee_ids;
        $amts = $request->fee_amount;
        $total = array();
        array_push($total, $transport_total);

        foreach ($quantities as $k =>$quantity){

            $amt = $quantity * $amts[$k];
            array_push($total, $amt);
        }

        //if(!is_null($request->half_fee_ids) && is_null($request->half_particulars) && is_null($request->half_quantity)){

            if($request->half_fee_ids && $request->half_particulars && $request->half_quantity && $request->half_fee_amount)
            {
                $hal_fee_ids = $request->half_fee_ids;
                $half_particulars = $request->half_particulars;
                $half_quantity = $request->half_quantity;
                $half_fee_amount = $request->half_fee_amount;

                foreach ($half_quantity as $l =>$half){
                    $h_amt = $half * $half_fee_amount[$l];
                    array_push($total, $h_amt);
                }
            }
        //}

        if($student->scholarship_id != 0 && in_array($monthly_cat->id, $fee_ids)){
            $month_fee_qty = 0;
            foreach ($request->discount as $l =>$dis){

                if($dis == 1){
                    $month_fee_qty += $quantities[$l];
                }
            }
            $amount_to_be_paid = array_sum($total) - ($scholarship_percentage/100 * ($month_fee_qty * $monthly_cat->amount)) + $previous_invoice_amount + $request->previous_year_amount;
        }else{
            $amount_to_be_paid = array_sum($total) + $previous_invoice_amount + $request->previous_year_amount;
        }

        $calendar = new NepaliCalender();
        $english_date = $request->invoice_date;
        $month = date("m",strtotime($english_date));
        $year = date("Y",strtotime($english_date));
        $day = date("d",strtotime($english_date));
        $cal = $calendar->eng_to_nep($year, $month, $day);
        $nepali_date = $cal['year'] . '-' . $cal['month'] . '-' . $cal['date'];

        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en');


        $invoice->amount = $amount_to_be_paid;
        $invoice->amount_paid = $request->amount;
        $invoice->due = $amount_to_be_paid - $request->amount;
        $invoice->amount_in_words = $numberTransformer->toWords($amount_to_be_paid);
        $invoice->remarks = $request->remarks;
        $invoice->status = $request->status;
        $invoice->invoice_date = Carbon::parse($request->invoice_date);
        $invoice->invoice_date_nepali = Carbon::parse($nepali_date);
        $invoice->year =  Auth::user()->accountant->school->detail->running_session;
        $invoice->previous_invoice_id = $previous_invoice_id;
        $invoice->previous_year_amount = $request->previous_year_amount;

        if($request->previous_invoice_id){
            $previous_invoice = Invoice::where('id', $request->previous_invoice_id)->first();
            $previous_invoice->previous_or_not = 1;
            $previous_invoice->update();
        }

        $invoice->previous_or_not = 0;

        if($invoice->save()) {

            if (!is_null($request->transport_qty)) {

                $transport = new InvoiceTransportItems();
                $transport->invoice_id = $invoice->id;
                $transport->quantity = $request->transport_qty;
                $transport->save();
            }


            foreach ($quantities as $k => $qty) {
                $invoice_item = new InvoiceItems();
                $invoice_item->invoice_id = $invoice->id;
                $invoice_item->fee_category_id = $fee_ids[$k];
                $invoice_item->quantity = intval($qty);
                if ($scholarship_percentage != 0 && $monthly_cat->id == $fee_ids[$k]) {
                    $invoice_item->discounted_or_not = 1;
                }
                $invoice_item->save();
            }

            if($request->half_fee_ids && $request->half_particulars && $request->half_quantity && $request->half_fee_amount)
            {
                $hal_fee_qtys = $request->half_quantity;
                $hal_fee_ids = $request->half_fee_ids;
                foreach ($hal_fee_qtys as $ui => $hal_fee_qty) {
                    $invoice_item1 = new InvoiceItems();
                    $invoice_item1->invoice_id = $invoice->id;
                    $invoice_item1->fee_category_id = $hal_fee_ids[$ui];
                    $invoice_item1->quantity = $hal_fee_qty;
                    $invoice_item1->is_half = 1;
                    $invoice_item1->save();
                }

            }

            flash('Invoice for ' .$invoice->student->user->name. ' has been created successfully','success');
            return redirect()->back();
        }
    }

    public function invoiceSearch()
    {
        $page = 'View';

        $invoice = Invoice::where('id',Input::get('inovice_id'))->first();
        $class_ids = ClassW::where('school_id', Session::get('school_id'))->where('is_active',1)->pluck('id');
        $monthly_fee_category = Fee::where('class_id', $invoice->class_id)->where('name', 'Monthly Fee')->first();

        return view('account_admin.accounting.invoice.view', compact('page', 'invoice', 'monthly_fee_category'));
    }

    public function invoiceDelete($id)
    {
        $invoice = Invoice::where('id', $id)->first();
        $invoice->is_active = 0;

        $invoice->invoiceItems()->delete();
        if($invoice->student->transport_id != 0 && !is_null($invoice->invoiceTransport)){

            $invoice->invoiceTransport->delete();
        }

        $invoice->update();

        flash('Invoice number ' .$invoice->id. ' has been deleted successfully','warning');
        return redirect()->back();

    }

    public function invoiceTakePayment(Request $request)
    {
        $invoice = Invoice::where('id', $request->id)->first();
        if($request->amount == $invoice->due)
        {
            $invoice->due = 0;
            $invoice->amount_paid = $invoice->amount;
            $invoice->status = 1;
        }else{

            $amount = $invoice->due - $request->amount;
            $invoice->amount_paid = $request->amount;
            $invoice->due = $amount;
            $invoice->status = 0;
        }

        $invoice->payment_date = Carbon::parse($request->payment_date);

        $calendar = new NepaliCalender();
        $english_date = $request->payment_date;
        $month = date("m",strtotime($english_date));
        $year = date("Y",strtotime($english_date));
        $day = date("d",strtotime($english_date));
        $cal = $calendar->eng_to_nep($year, $month, $day);
        $nepali_date = $cal['year'] . '-' . $cal['month'] . '-' . $cal['date'];
        $invoice->payment_date_nepali = Carbon::parse($nepali_date);

        $invoice->update();

        flash('Payment of Invoice of ' .$invoice->student->user->name. ' has been taken successfully','success');
        return redirect()->back();

    }

    public function getClassSectionInDropDown($id)
    {
        $class = ClassW::find($id);

        $class_sections = ClassSection::where('class_id', $class->id)->where('school_id', Session::get('school_id'))->get();

        foreach ($class_sections as $row)
        {
            echo '<option></option>';
            echo '<option value="'.$row->id.'">'.$row->name.'</option>';
        }
    }

    public function invoicePrintBulk()
    {
        $page = 'Print Bulk';
        $school = School::find(Session::get('school_id'));

        $classes = ClassW::where('school_id', $school->id)->where('is_active',1)->get();
        $invoices = array();
        $class = array();

        if(Input::get('class_id')){
            $class = ClassW::find(Input::get('class_id'));
            $invoices = Invoice::orderBy('created_at', 'DESC')->where('year', $school->detail->running_session)->where('school_id', $school->id)->where('class_id', $class->id)->where('previous_or_not', 0)->where('is_active',1)->where('status',0)->get();
        }
        return view('account_admin.accounting.invoice.print', compact('page', 'classes', 'class', 'invoices'));
    }

    public function invoicePrintBulkAll(Request $request, $class_id)
    {
        if($request->invoice_ids){
            $invoice_ids = $request->invoice_ids;

            $page = 'Print Bulk';

            $invoices = Invoice::whereIn('id',$invoice_ids)->get();
            $monthly_fee_category = Fee::where('class_id', $class_id)->where('name', 'Monthly Fee')->first();

            return view('account_admin.accounting.invoice.view-all', compact('page', 'invoices', 'monthly_fee_category'));
        }else{
            flash('Please select at least one invoice.', 'danger')->important();
            return redirect()->back();
        }
    }

}
