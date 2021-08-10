<?php

namespace App\Http\Controllers;

use App\Models\ClassW;
use App\Models\Fee;
use App\Models\Invoice;
use App\Models\InvoiceItems;
use App\Models\InvoiceTransportItems;
use App\Models\School;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NepaliCalender;
use NumberToWords\NumberToWords;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $system_settings = School::where('user_id', Auth::user()->id)->first();
            view()->share('system_settings', $system_settings);

            return $next($request);

        });
    }

    public function index()
    {
        $page = 'All Invoices';
        $invoices = Invoice::orderBy('created_at', 'ASC')->where('year', Auth::user()->school->detail->running_session)->where('school_id', Auth::user()->school->id)->where('previous_or_not', 0)->where('is_active',1)->get();

        return view('school_admin.accounting.invoice.index', compact('page', 'invoices'));
    }

    public function create()
    {
        $page = 'Create Student Invoice';

        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active',1)->orderBy('numeric_name', 'ASC')->get();

        return view('school_admin.accounting.invoice.create', compact('page', 'classes'));
    }

    public function view($id)
    {
        $page = 'View';

        $invoice = Invoice::find($id);
        $monthly_fee_category = Fee::where('class_id', $invoice->class_id)->where('name', 'Monthly Fee')->first();

        return view('school_admin.accounting.invoice.view', compact('page', 'invoice', 'monthly_fee_category'));
    }

    public function store(Request $request)
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
            //dd('its_haft');
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
        //dd('not_half');
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
        $invoice->year =  Auth::user()->school->detail->running_session;
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

    public function takePayment(Request $request)
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

    public function delete($id)
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
}
