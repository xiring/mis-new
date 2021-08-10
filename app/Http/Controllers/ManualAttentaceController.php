<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Enroll;
use App\Models\School;
use App\Models\ClassW;
use App\Models\Student;
use Carbon\Carbon;
use App\Models\ClassSection;
use Illuminate\Http\Request;
use App\Models\ManualAttentace;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ManualAttentaceController extends Controller
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
        $page = 'Attendance';

        $school = School::where('user_id', Auth::user()->id)->first();

        $classes = ClassW::where('is_active',1)->where('school_id', $school->id)->get();
        $exams = Exam::where('is_active',1)->where('school_id', $school->id)->where('year', $school->detail->running_session)->get();
        /*$exams = Exam::orderBy('created_at', 'ASC')->get();*/
        if(Input::get('exam_id') && Input::get('class_id') && Input::get('section_id')){
        	$exam = Exam::find(Input::get('exam_id'));
        	$class = ClassW::find(Input::get('class_id'));
            $section = ClassSection::find(Input::get('section_id'));

        	$enrolls = Enroll::where('school_id', $school->id)->where('class_id', $class->id)->where('section_id',$section->id)->where('year', $school->detail->running_session)->where('is_active',1)->orderBy('roll_number', 'ASC')->get();
        	//$students = Student::whereIn('enroll_id', $enroll_ids)->orderBy('id', 'ASC')->get();
        	$atteds = ManualAttentace::where('exam_id', $exam->id)->where('class_id', $class->id)->where('section_id', $section->id)->where('year', $school->detail->running_session)->whereIn('student_id', $enrolls->pluck('id'))->get();
            /*$atteds = array();*/
        }else{

	        $exam = '';
	        $class = '';
            $section = '';
	        $enrolls = array();
	        $atteds = array();
        }


        return view('school_admin.manual-attendance.index', compact('exams', 'page', 'classes', 'school', 'exam', 'class', 'enrolls', 'atteds', 'section'));
    }

    public function store(Request $request)
    {
        $number_of_days = $request->number_of_days;

    	foreach ($request->student_ids as $k => $student_id) {
    		$school = School::where('id', $request->school_id)->first();
    		$attend = new ManualAttentace();
    		$attend->school_id = $request->school_id;
    		$attend->year = $school->detail->running_session;
    		$attend->class_id = $request->class_id;
            $attend->section_id = $request->section_id;
    		$attend->exam_id = $request->exam_id;
    		$attend->student_id = $student_id;
    		$attend->number_of_days = $number_of_days[$k];
    		$attend->total_days = $request->total_days;

    		$attend->save();
    	}

    	flash('Attendance has been successfully added.' ,'success');
        return redirect()->back();
    }

    public function update(Request $request)
    {
    	$number_of_days = $request->number_of_days;

    	foreach ($request->student_ids as $k => $student_id) {
    		$school = School::where('id', $request->school_id)->first();
            $attend = ManualAttentace::where('school_id', $school->id)->where('class_id', $request->class_id)->where('exam_id', $request->exam_id)->where('section_id', $request->section_id)->where('student_id', $student_id)->first();
            if($attend){
                $attend->number_of_days = $number_of_days[$k];
                $attend->total_days = $request->total_days;

                $attend->update();
            }else{
                $new = new ManualAttentace();
                $new->school_id = $school->id;
                $new->year = $school->detail->running_session;
                $new->class_id = $request->class_id;
                $new->section_id = $request->section_id;
                $new->exam_id = $request->exam_id;
                $new->student_id = $student_id;
                $new->number_of_days = $number_of_days[$k];
                $new->total_days = $request->total_days;
                $new->save();
            }
    	}

    	flash('Attendance has been successfully updated.' ,'success');
        return redirect()->back();
    }
}
