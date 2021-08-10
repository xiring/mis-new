<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Models\ExpenseInvoice;
use App\Models\School;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseInvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $system_settings = School::where('user_id', Auth::user()->id)->first();
            view()->share('system_settings', $system_settings);

            return $next($request);

        });
    }

    public function  index()
    {
        $page = 'Expense Invoice';

        $categories = ExpenseCategory::orderBy('created_at', 'ASC')->where('school_id', Auth::user()->school->id)->where('is_active',1)->get();
        $invoices = ExpenseInvoice::orderBy('created_at', 'ASC')->where('school_id',Auth::user()->school->id)->get();

        return view('school_admin.accounting.expense.invoice', compact('page', 'categories', 'invoices'));
    }

    public function store(Request $request)
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

    public function update(Request $request)
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

    public function delete($id)
    {
        $invoice = ExpenseInvoice::find($id);
        $invoice->is_active = 0;

        if($invoice->update()):
            flash('Invoice for ' . $invoice->category->name. ' has been successfully updated.' ,'warning');
            return redirect()->back();
        endif;
    }

    public function restore($id)
    {
        $invoice = ExpenseInvoice::find($id);
        $invoice->is_active = 1;

        if($invoice->update()):
            flash('Invoice for ' . $invoice->category->name. ' has been successfully restored.' ,'success');
            return redirect()->back();
        endif;
    }

    public function reportSumary()
    {
        $page = 'Summary Of Expense';
        $categories = ExpenseCategory::orderBy('created_at', 'ASC')->where('school_id', Auth::user()->school->id)->where('is_active',1)->get();
        return view('school_admin.accounting.expense.summary', compact('page', 'categories'));
    }

    public function report(\Illuminate\Support\Facades\Request $request)
    {
        $page = 'Expense Report';
        $categories = ExpenseCategory::orderBy('created_at', 'ASC')->where('school_id', Auth::user()->school->id)->where('is_active',1)->get();

        if($request::get('expense_category_id')){
            $category_id = $request::get('expense_category_id');
            $category = ExpenseCategory::where('id', $category_id)->first();
            $invoices = ExpenseInvoice::where('expense_category_id', $category->id)->where('is_active',1)->where('year', Auth::user()->school->detail->running_session)->get();
        }else{
            $invoices = array();
        }

        return view('school_admin.accounting.expense.report', compact('page', 'categories', 'invoices', 'category'));
    }
}
