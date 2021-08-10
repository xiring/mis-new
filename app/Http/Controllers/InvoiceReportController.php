<?php

namespace App\Http\Controllers;

use App\Models\ClassW;
use App\Models\Enroll;
use App\Models\Fee;
use App\Models\Invoice;
use App\Models\InvoiceItems;
use App\Models\InvoiceTransportItems;
use App\Models\School;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $system_settings = School::where('user_id', Auth::user()->id)->first();
            view()->share('system_settings', $system_settings);

            return $next($request);

        });
    }

    public function previousByClassId(Request $request)
    {
        $page = 'Previous';
        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active',1)->orderBy('numeric_name','ASC')->get();
        if($request::get('class_id')) {
            $class_id = $request::get('class_id');
            $class = ClassW::where('id', $class_id)->first();
            $invoices = Invoice::where('year', Auth::user()->school->detail->running_session)->where('status', 0)->where('previous_or_not', 1)->where('class_id', $class_id)->where('is_active', 1)->get();
        }else{
            $invoices = array();
            $class = '';
        }

        return view('school_admin.reports.previous', compact('page', 'invoices', 'classes', 'class'));
    }

    public function dueByClassId(Request $request)
    {
        $page = 'Due';
        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active',1)->orderBy('numeric_name','ASC')->get();

        if($request::get('class_id')) {
            $class_id = $request::get('class_id');
            $class = ClassW::where('id', $class_id)->first();
            $invoices = Invoice::where('year', Auth::user()->school->detail->running_session)->where('due', '>', 0)->where('class_id', $class->id)->where('status', 0)->where('previous_or_not', 0)->where('is_active', 1)->get();

            $total = array();
            foreach ($invoices as $invoice) {

                array_push($total, $invoice->due);
            }
        }else{
            $invoices = array();
            $class = '';
            $total = '';
        }

        return view('school_admin.reports.due', compact('page','invoices', 'classes', 'class', 'total'));

    }

    public function dueByClassAndStudentId(Request $request)
    {
        $page = 'By Student';
        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active',1)->orderBy('numeric_name','ASC')->get();
        if($request::get('class_id') && $request::get('student_id')) {
            $class_id = $request::get('class_id');
            $class = ClassW::where('id', $class_id)->first();
            $student_id = $request::get('student_id');
            $student = Student::where('id', $student_id)->first();
            $invoices = Invoice::orderBy('created_at', 'ASC')->where('student_id', $student_id)->where('class_id', $class->id)->where('year', Auth::user()->school->detail->running_session)->where('previous_or_not', 0)->where('is_active', 1)->get();
        }else{

            $invoices = array();
            $class = '';
            $student = '';
        }

        return view('school_admin.reports.student', compact('page','invoices', 'classes', 'class', 'student'));
    }

    public function allByClassAndDate(Request $request)
    {
        $page = 'By Date And Class';
        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active',1)->orderBy('numeric_name','ASC')->get();
        if($request::get('class_id') && $request::get('from') && $request::get('to')){
            $from = Carbon::parse($request::get('from'));
            $to = Carbon::parse($request::get('to'));
            $class_id = $request::get('class_id');
            $class = ClassW::where('id', $class_id)->first();
            $invoices = Invoice::orderBy('created_at', 'ASC')->where('year', Auth::user()->school->detail->running_session)->where('previous_or_not', 0)->where('class_id', $class->id)->where('is_active',1)->whereBetween('invoice_date', [$from, $to])->get();
        }else{
            $invoices = array();
            $class = "";
            $from = "";
            $to = "";
        }

        return view('school_admin.reports.date', compact('page','invoices', 'classes', 'class', 'from', 'to'));

    }

    public function allByDate(Request $request)
    {
        $page = 'By Date';
        $system_settings = School::where('user_id', Auth::user()->id)->first();
        if($request::get('from') && $request::get('to')){
            $from = Carbon::parse($request::get('from'));
            $to = Carbon::parse($request::get('to'));
            $invoices = Invoice::orderBy('created_at', 'ASC')->where('year', Auth::user()->school->detail->running_session)->where('previous_or_not', 0)->where('is_active',1)->where('status', 1)->whereBetween('invoice_date', [$from, $to])->get();
        }else{
            $invoices = array();
            $from = "";
            $to = "";
        }

        return view('school_admin.reports.date1', compact('page','invoices', 'from', 'to'));
    }

    public function paymentReceivedDate(Request $request)
    {
        $page = 'By Payment Received Date';
        if($request::get('from') && $request::get('to')){
            $from = Carbon::parse($request::get('from'));
            $to = Carbon::parse($request::get('to'));
            $invoices = Invoice::orderBy('updated_at', 'ASC')->where('year', Auth::user()->school->detail->running_session)->where('previous_or_not', 0)->where('is_active',1)->where('status', 1)->whereBetween('updated_at', [$from, $to])->get();
        }else{
            $invoices = array();
            $from = "";
            $to = "";
        }

        return view('school_admin.reports.received_date', compact('page','invoices', 'from', 'to'));
    }

    public function reportByClassParticularId(Request $request)
    {
        $page = 'By Class Particular';
        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active',1)->orderBy('numeric_name','ASC')->get();
        if($request::get('class_id') && $request::get('fee_category_id')) {
            $class_id = $request::get('class_id');
            $class = ClassW::where('id', $class_id)->first();
            $invoice_ids = Invoice::where('class_id',$class->id)->where('year', Auth::user()->school->detail->running_session)->pluck('id')->toArray();
            $fee_category_id = $request::get('fee_category_id');
            $fee = Fee::find($fee_category_id);
            $invoice_items = InvoiceItems::where('fee_category_id', $fee->id)->whereIn('invoice_id', $invoice_ids)->get();
        }else{
            $invoice_items = array();
            $class = "";
            $fee = "";
        }

        return view('school_admin.reports.class_particular', compact('page','invoice_items','class', 'classes', 'fee'));

    }

    public function reportByPartiularId(Request $request)
    {
        $page = 'By Particular';

        $class_ids = ClassW::where('school_id', Auth::user()->school->id)->where('is_active',1)->pluck('id');
        $fee_categories = Fee::whereIn('class_id', $class_ids)->where('is_active',1)->orderBy('created_at', 'ASC')->get();

        if($request::get('fee_category_id'))
        {
            $category_ids = $request::get('fee_category_id');
            $invoices = Invoice::where('year', Auth::user()->school->detail->running_session)->where('due',0)->where('previous_or_not', 0)->where('status', 1)->pluck('id');
            $invoice_items =  InvoiceItems::whereIn('fee_category_id', $category_ids)->whereIn('invoice_id', $invoices)->get();

        }else{
            $invoice_items = array();
        }
        return view('school_admin.reports.particular', compact('page','invoice_items', 'fee_categories'));
    }

    public function reportOfDueByDate(Request $request)
    {
        $page = 'Summary Of Due';

        if($request::get('from') && $request::get('to')){
            $from = Carbon::parse($request::get('from'));
            $to = Carbon::parse($request::get('to'));
            $invoices = Invoice::orderBy('created_at', 'ASC')->where('year', Auth::user()->school->detail->running_session)->where('previous_or_not', 0)->where('due','>', 0)->where('status', 0)->where('is_active',1)->whereBetween('invoice_date', [$from, $to])->get();
        }else{

            $invoices = array();
            $from = '';
            $to = '';
        }

        return view('school_admin.reports.summary_due', compact('page','invoices', 'from', 'to'));
    }

    public function reportByTransport()
    {
        $page = 'Summary Of Transport';
        $class_ids = ClassW::where('school_id', Auth::user()->school->id)->where('is_active',1)->pluck('id');
        $invoice_ids = Invoice::whereIn('class_id', $class_ids)->where('is_active',1)->where('previous_or_not',0)->Where('due',0)->where('status',1)->where('year', Auth::user()->school->detail->running_session)->pluck('id');
        $invoice_items = InvoiceTransportItems::whereIn('invoice_id', $invoice_ids)->get();

        return view('school_admin.reports.transport', compact('page','invoice_items'));
    }

    public function reportByScholarship()
    {
        $page = 'Summary Of Scholarship';
        $class_ids = ClassW::where('school_id', Auth::user()->school->id)->where('is_active',1)->pluck('id');
        $invoice_ids = Invoice::whereIn('class_id', $class_ids)->where('is_active',1)->where('year', Auth::user()->school->detail->running_session)->where('previous_or_not',0)->Where('due',0)->where('status',1)->pluck('id');
        $invoice_items = InvoiceItems::whereIn('invoice_id', $invoice_ids)->where('discounted_or_not', 1)->get();
        $monthly_fee_category = Fee::whereIn('class_id', $class_ids)->where('name', 'Monthly Fee')->first();
        return view('school_admin.reports.scholarship', compact('page','invoice_items', 'monthly_fee_category'));
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

    public function invoiceSummary()
    {
        $page = 'Summary Of Income';

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

        return view('school_admin.reports.summary', compact('page', 'monthly_fee', 'annual_fee', 'id_card_fee', 'exam_fee'
        ,'stationary', 'computer_fee', 'belt', 'calendar', 'diary', 'bow_tie', 'tie_short', 'tie_long', 'book_lkg', 'book_ukg', 'book_nursery', 'trac', 'trac_extra_tution', 'day_boarders',
            'h_w_copy_set', 'extrac_coaching', 'sweater', 'cap', 'muffler', 'transport','hostel_fee', 'total', 'stocking_socks', 'festival_kids_h_w_copy', 'copy' , 'school_copy' , 'pencil', 'sharpner', 'tie_belt_sweater_track_suit', 'eraser_pencil_sharpener', 'eraser', 'book', 'stationery_half_year', 'mask'));
    }
}
