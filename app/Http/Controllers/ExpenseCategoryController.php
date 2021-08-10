<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseCategoryController extends Controller
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
        $page = 'Expense Category';

        $categories = ExpenseCategory::orderBy('created_at', 'ASC')->where('school_id', Auth::user()->school->id)->get();

        return view('school_admin.accounting.expense.index', compact('page', 'categories'));
    }

    public function store(Request $request)
    {
        $category = new ExpenseCategory();
        $category->name = $request->name;
        $category->school_id = $request->school_id;

        if($category->save()){

            flash('Expense category' . $category->name. 'has been successfully added.' ,'success');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        $category = ExpenseCategory::find($request->id);
        $category->name = $request->name;

        if($category->update()){

            flash('Expense category' . $category->name. 'has been successfully updated.' ,'success');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        $category = ExpenseCategory::find($id);
        $category->is_active = 0;

        if($category->update()):
            flash('Expense category  ' .$category->name . ' was deleted successfully.','warning');
            return redirect()->back();
        endif;
    }

    public function restore($id)
    {
        $category = ExpenseCategory::find($id);
        $category->is_active = 1;

        if($category->update()):
            flash('Expense category  ' .$category->name . ' was restored successfully.','warning');
            return redirect()->back();
        endif;
    }
}
