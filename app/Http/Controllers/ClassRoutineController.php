<?php

namespace App\Http\Controllers;

use App\Models\ClassRoutine;
use App\Models\ClassSection;
use App\Models\ClassW;
use App\Models\School;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassRoutineController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $system_settings = School::where('user_id', Auth::user()->id)->first();
            view()->share('system_settings', $system_settings);

            return $next($request);

        });
    }

    public function routineByClassId($id)
    {
        $page = 'Class Routine';
        $class = ClassW::where('id', $id)->first();
        $sections = ClassSection::where('class_id', $class->id)->where('is_active',1)->get();
        $subjects = Subject::where('class_id', $class->id)->where('is_active',1)->get();
        $class_routines = ClassRoutine::where('class_id', $class->id)->where('year', Auth::user()->school->detail->running_session)->where('day', 'sunday');
        $monday_class_routines = ClassRoutine::where('class_id', $class->id)->where('year', Auth::user()->school->detail->running_session)->where('day', 'monday');
        $tuesday_class_routines = ClassRoutine::where('class_id', $class->id)->where('year', Auth::user()->school->detail->running_session)->where('day', 'tuesday');
        $wed_class_routines = ClassRoutine::where('class_id', $class->id)->where('year', Auth::user()->school->detail->running_session)->where('day', 'wednesday');
        $thu_class_routines = ClassRoutine::where('class_id', $class->id)->where('year', Auth::user()->school->detail->running_session)->where('day', 'thursday');
        $fri_class_routines = ClassRoutine::where('class_id', $class->id)->where('year', Auth::user()->school->detail->running_session)->where('day', 'friday');
        return view('school_admin.class.routine', compact('sections', 'page', 'class', 'subjects', 'class_routines', 'monday_class_routines', 'tuesday_class_routines', 'wed_class_routines', 'thu_class_routines', 'fri_class_routines')) ;
    }

    public function store(Request $request)
    {
        $routine = new ClassRoutine();
        $routine->class_id = $request->class_id;
        $routine->subject_id = $request->subject_id;
        $routine->section_id = $request->section_id;
        $routine->time_start = $request->time_start;
        $routine->time_start_min = $request->time_start_min;
        $routine->start_am_pm = $request->start_am_pm;
        $routine->time_end = $request->time_end;
        $routine->time_end_min = $request->time_end_min;
        $routine->end_am_pm = $request->end_am_pm;
        $routine->day = $request->day;
        $routine->year = Auth::user()->school->detail->running_session;

        if($routine->save()):
            flash('Class routine was added successfully.','success');
            return redirect()->back();
        endif;

    }

    public function update(Request $request)
    {
        $routine = ClassRoutine::find($request->id);
        $routine->subject_id = $request->subject_id;
        $routine->section_id = $request->section_id;
        $routine->time_start = $request->time_start;
        $routine->time_start_min = $request->time_start_min;
        $routine->start_am_pm = $request->start_am_pm;
        $routine->time_end = $request->time_end;
        $routine->time_end_min = $request->time_end_min;
        $routine->end_am_pm = $request->end_am_pm;
        $routine->day = $request->day;

        if($routine->update()):
            flash('Class routine was updated successfully.','success');
            return redirect()->back();
        endif;

    }

    public function delete($id)
    {
        ClassRoutine::find($id)->delete();
        flash('Class routine was deleted successfully.','danger');
        return redirect()->back();
    }

    public function print($id)
    {
        $section = ClassSection::where('id', $id)->first();
        $class = ClassW::where('id',$section->class_id)->first();
        $routines = ClassRoutine::where('class_id', $class->id)->where('section_id', $section->id)->where('year', Auth::user()->school->detail->running_session)->where('day', 'sunday')->get();
        $monday_routines = ClassRoutine::where('class_id', $class->id)->where('section_id', $section->id)->where('year', Auth::user()->school->detail->running_session)->where('day', 'monday')->get();
        $tue_routines = ClassRoutine::where('class_id', $class->id)->where('section_id', $section->id)->where('year', Auth::user()->school->detail->running_session)->where('day', 'tuesday')->get();
        $wed_routines = ClassRoutine::where('class_id', $class->id)->where('section_id', $section->id)->where('year', Auth::user()->school->detail->running_session)->where('day', 'wednesday')->get();
        $thu_routines = ClassRoutine::where('class_id', $class->id)->where('section_id', $section->id)->where('year', Auth::user()->school->detail->running_session)->where('day', 'thursday')->get();
        $fri_routines = ClassRoutine::where('class_id', $class->id)->where('section_id', $section->id)->where('year', Auth::user()->school->detail->running_session)->where('day', 'thursday')->get();
        $system_settings = School::where('user_id', Auth::user()->id)->first();

        return view('school_admin.class.routine_print', compact('section', 'class', 'routines', 'system_settings', 'monday_routines', 'tue_routines', 'wed_routines', 'thu_routines', 'fri_routines')) ;
    }

}
