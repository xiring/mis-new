<?php

namespace App\Http\Controllers;

use App\Models\ExamGrade;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamGradeController extends Controller
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
        $page = 'Exam Grade';

        $grades = ExamGrade::orderBy('created_at', 'ASC')->get();

        return view('school_admin.exam.grade', compact('grades', 'page'));
    }

    public function store(Request $request)
    {
        $grade = new ExamGrade();
        $grade->school_id = $request->school_id;
        $grade->name = $request->name;
        $grade->grade_point = $request->grade_point;
        $grade->mark_form = $request->mark_form;
        $grade->mark_upto = $request->mark_upto;
        $grade->comment = $request->comment;

        if($grade->save()){

            flash('Grade ' . $grade->name. 'has been successfully added.' ,'success');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        $grade = ExamGrade::find($request->id);
        $grade->name = $request->name;
        $grade->grade_point = $request->grade_point;
        $grade->mark_form = $request->mark_form;
        $grade->mark_upto = $request->mark_upto;
        $grade->comment = $request->comment;

        if($grade->update()){

            flash('Grade ' . $grade->name. 'has been successfully updated.' ,'success');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        $grade = ExamGrade::find($id);
        $grade->is_active = 0;

        if($grade->update()):
            flash('Grade  ' .$grade->name . ' was deleted successfully.','warning');
            return redirect()->back();
        endif;
    }

    public function restore($id)
    {
        $grade = ExamGrade::find($id);
        $grade->is_active = 1;

        if($grade->update()):
            flash('Grade  ' .$grade->name . ' was restored successfully.','success');
            return redirect()->back();
        endif;
    }
}
