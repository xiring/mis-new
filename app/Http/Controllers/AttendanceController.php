<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassSection;
use App\Models\ClassW;
use App\Models\Enroll;
use App\Models\School;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class AttendanceController extends Controller
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
        $page = 'Daily Attendance';

        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active',1)->orderBy('numeric_name', 'ASC')->get();

        $attendance = Attendance::where('school_id', Auth::user()->school->id)->where('year', Auth::user()->school->detail->running_session)->orderBy('created_at', 'DESC')->where('date', Carbon::now()->format('Y-m-d'))->get();

        return view('school_admin.attendance.index', compact('page', 'classes', 'attendance'));
    }

    public function form()
    {
        $page = 'Daily Attendance';

        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active',1)->orderBy('numeric_name', 'ASC')->get();

        $enrolls = array();

        $attendances = array();

        return view('school_admin.attendance.create', compact('page', 'classes', 'enrolls', 'attendances'));
    }


    public function attendnceReportByClassAndDate()
    {

        $page = 'Attendance Report';

        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active',1)->orderBy('numeric_name', 'ASC')->get();

        $attendances = array();

        $date = '';

        $class = '';

        if(Input::get('class_id') && Input::get('date'))
        {
            $date = Input::get('date');
            $class_id = Input::get('class_id');
            $class = ClassW::find($class_id);
            $attendances = Attendance::where('school_id', Auth::user()->school->id)->where('year', Auth::user()->school->detail->running_session)->orderBy('created_at', 'DESC')->where('class_id', Input::get('class_id'))->where('date', Input::get('date'))->get();
        }

        return view('school_admin.attendance.report', compact('page', 'classes', 'attendances', 'date', 'class'));
    }

    public function create(\Illuminate\Support\Facades\Request $request)
    {
        $page = 'Daily Attendance';
        $class_id = $request::get('class_id');
        $section_id = $request::get('section_id');
        $class_routine_id = $request::get('class_routine_id');
        $date = $request::get('date');

        $class =  ClassW::find($class_id);
        $section = ClassSection::find($section_id);
        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active',1)->orderBy('numeric_name', 'ASC')->get();
        $enrolls = Enroll::where('class_id', $class->id)->where('is_active',1)->where('section_id', $section->id)->where('school_id', Auth::user()->school->id)->where('year', Auth::user()->school->detail->running_session)->orderBy('roll_number', 'ASC')->get();
        $attendances = array();
        return view('school_admin.attendance.create', compact('page', 'classes', 'date', 'class_routine_id', 'enrolls', 'class_id', 'class', 'section', 'attendances'));
    }

    public function view($class_id, $section_id, $date)
    {
        $page = 'Daily Attendance';

        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active',1)->orderBy('numeric_name', 'ASC')->get();
        $class = ClassW::find($class_id);
        $request_date = Carbon::parse($date)->toDateTimeString();
        //dd($request_date);
        $section = ClassSection::find($section_id);
        $dates = Attendance::where('class_id', $class->id)->where('section_id', $section->id)->where('school_id', Auth::user()->school->id)->where('year', Auth::user()->school->detail->running_session)->pluck('date')->toArray();

        $converted_date = array();
        foreach ($dates as $d)
        {
            array_push($converted_date, Carbon::parse($d)->toDateTimeString());
        }
        //dd($converted_date);
        if(in_array($request_date, $converted_date)) {
            $enrolls = array();
            $attendances = Attendance::where('class_id', $class->id)->where('section_id', $section->id)->where('school_id', Auth::user()->school->id)->where('year', Auth::user()->school->detail->running_session)->orderBy('created_at', 'DESC')->get();
            return view('school_admin.attendance.create', compact('page', 'classes', 'date', 'enrolls', 'class_id', 'class', 'section', 'attendances'));

        }

    }

    public function reportView($class_id, $section_id, $date)
    {
        $page = 'Attendance Report';

        $date = $date;
        $class_id = $class_id;
        $class = ClassW::find($class_id);
        $attendances = Attendance::where('school_id', Auth::user()->school->id)->where('year', Auth::user()->school->detail->running_session)->orderBy('created_at', 'DESC')->where('class_id', $class->id)->where('section_id', $section_id)->where('date', $date)->get();

        return view('school_admin.attendance.report-view', compact('page', 'date', 'class', 'attendances'));
    }

    public function store(Request $request)
    {
        $student_ids = $request->student_ids;
        $status = $request->status;

        foreach ($student_ids as $k => $student_id)
        {
            $attendance = new Attendance();
            $attendance->school_id = Auth::user()->school->id;
            $attendance->year = Auth::user()->school->detail->running_session;
            $attendance->class_id = $request->class_id;
            $attendance->section_id = $request->section_id;
            $attendance->class_routine_id = $request->class_routine_id;
            $attendance->date = Carbon::parse($request->date);
            $attendance->student_id = $student_id;
            $attendance->status = $status[$k];
            $attendance->save();
        }

        flash('Attendance for class ' .$attendance->classW->name. ' has been created successfully','success');
        return redirect()->route('attendance.form');
    }

    public function update(Request $request)
    {
        $student_ids = $request->student_ids;
        $status = $request->status;

        foreach ($student_ids as $k => $student_id)
        {
            $attendance = Attendance::where('student_id', $student_id)->first();
            $attendance->class_id = $request->class_id;
            $attendance->section_id = $request->section_id;
            $attendance->class_routine_id = $request->class_routine_id;
            $attendance->date = Carbon::parse($request->date);
            $attendance->status = $status[$k];
            $attendance->update();
        }

        flash('Attendance for class ' .$attendance->classW->name. ' has been updated successfully','success');
        return redirect()->route('attendance.form');
    }

    public function attendnceReportByClassAndMonth()
    {

        $page = 'Attendance Report Month';

        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active',1)->orderBy('numeric_name', 'ASC')->get();

        $attendances = array();

        $date = '';

        $class = '';

        $section_id = '';

        if(Input::get('class_id') && Input::get('date'))
        {
            $month = Carbon::parse(Input::get('date'));
            $from = $month->startOfMonth()->toDateTimeString();
            $to = $month->endOfMonth()->toDateTimeString();
            $date = Input::get('date');
            $class_id = Input::get('class_id');
            $section_id = Input::get('section_id');
            $class = ClassW::find($class_id);
            $attendances = Attendance::where('school_id', Auth::user()->school->id)->where('year', Auth::user()->school->detail->running_session)->where('section_id', $section_id)->orderBy('created_at', 'DESC')->where('class_id', Input::get('class_id'))->where('date', '>=' , $from)->where('date', '<=' , $to)->get();
        }

        return view('school_admin.attendance.report-month', compact('page', 'classes', 'attendances', 'date', 'class', 'section_id'));
    }

}
