<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\School;
use App\Models\Teacher;
use App\Models\ClassW;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $system_settings = School::where('user_id', Auth::user()->id)->first();
            view()->share('system_settings', $system_settings);

            return $next($request);

        });
    }

    public function subjectByClassId($id)
    {
        $page = 'Subjects';
        $class = ClassW::where('id', $id)->first();
        $subjects = Subject::where('class_id', $class->id)->orderBy('created_at', 'ASC')->get();
        $teachers = Teacher::where('school_id', Auth::user()->school->id)->get();
        return view('school_admin.class.subject', compact('subjects', 'page', 'class', 'teachers')) ;
    }

    public function store(Request $request)
    {
        $subject = new Subject();
        $subject->school_id = $request->school_id;
        $subject->class_id = $request->class_id;
        $subject->teacher_id = $request->teacher_id;
        $subject->name = $request->name;
        $subject->type = $request->type;
        $subject->full_marks = $request->full_marks;
        $subject->full_marks_theory = $request->full_marks_theory;
        $subject->full_marks_practical = $request->full_marks_practical;
        if($request->school_id == 2){
            $subject->mark_optional = $request->mark_optional;
        }

        if($subject->save()):
            flash('Subject  ' .$subject->name . ' was added successfully.','success');
            return redirect()->back();
        endif;
    }

    public function update(Request $request)
    {
        $subject = Subject::find($request->id);
        $subject->name = $request->name;
        $subject->type = $request->type;
        $subject->full_marks = $request->full_marks;
        $subject->full_marks_theory = $request->full_marks_theory;
        $subject->full_marks_practical = $request->full_marks_practical;
        if($request->school_id == 2){
            $subject->mark_optional = $request->mark_optional;
        }

        if($subject->update()):
            flash('Subject  ' .$subject->name . ' was updated successfully.','success');
            return redirect()->back();
        endif;
    }

    public function delete($id)
    {
        $subject = Subject::find($id);
        $subject->is_active = 0;

        if($subject->update()):
            flash('Subject  ' .$subject->name . ' was deleted successfully.','warning');
            return redirect()->back();
        endif;
    }

    public function restore($id)
    {
        $subject = Subject::find($id);
        $subject->is_active = 1;

        if($subject->update()):
            flash('Subject  ' .$subject->name . ' was restored successfully.','success');
            return redirect()->back();
        endif;
    }
}
