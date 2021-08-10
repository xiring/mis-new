<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\School;
use App\Models\ClassW;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeeController extends Controller
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
        $page = 'Fee Category';

        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active',1)->get();
        $categories = Fee::orderBy('created_at', 'ASC')->get();

        return view('school_admin.accounting.fee_category.index', compact('page', 'categories', 'classes'));
    }

    public function store(Request $request)
    {
        $category = new Fee();
        $category->school_id = $request->school_id;
        $category->class_id = $request->class_id;
        $category->name = $request->name;
        $category->amount = $request->amount;
        $category->has_half_amount = $request->has_half_amount;
        $category->half_amount = $request->half_amount;

        if($category->save()){

            flash('Fee category' . $category->name. 'has been successfully added.' ,'success');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        $category = Fee::find($request->id);
        $category->class_id = $request->class_id;
        $category->name = $request->name;
        $category->amount = $request->amount;
        $category->has_half_amount = $request->has_half_amount;
        $category->half_amount = $request->half_amount;

        if($category->update()){

            flash('Fee category' . $category->name. 'has been successfully updated.' ,'success');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        $category = Fee::find($id);
        $category->is_active = 0;

        if($category->update()):
            flash('Fee category  ' .$category->name . ' was deleted successfully.','warning');
            return redirect()->back();
        endif;
    }

    public function restore($id)
    {
        $category = Fee::find($id);
        $category->is_active = 1;

        if($category->update()):
            flash('Fee category  ' .$category->name . ' was restored successfully.','success');
            return redirect()->back();
        endif;
    }
}
