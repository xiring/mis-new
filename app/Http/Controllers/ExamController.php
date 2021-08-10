<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\School;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NepaliCalender;

class ExamController extends Controller
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
        $page = 'Exam List';

        $exams = Exam::where('year',Auth::user()->school->detail->running_session)->orderBy('created_at', 'ASC')->get();

        return view('school_admin.exam.index', compact('exams', 'page'));
    }

    public function store(Request $request)
    {
        $calendar = new NepaliCalender();

        $form_date = $request->date;
        $month = date("m",strtotime($form_date));
        $year = date("Y",strtotime($form_date));
        $day = date("d",strtotime($form_date));
        $cal = $calendar->eng_to_nep($year, $month, $day);
        $date = $cal['year'] . '-' . $cal['month'] . '-' . $cal['date'];

        $calendar1 = new NepaliCalender();
        $date_result = $request->result_date;
        $month1 = date("m",strtotime($date_result));
        $year1 = date("Y",strtotime($date_result));
        $day1 = date("d",strtotime($date_result));
        $cal1 = $calendar1->eng_to_nep($year1, $month1, $day1);
        $result_date = $cal1['year'] . '-' . $cal1['month'] . '-' . $cal1['date'];

        $exam = new Exam();
        $exam->school_id = $request->school_id;
        $exam->name = $request->name;
        $exam->date = Carbon::parse($date);
        $exam->result_date = Carbon::parse($result_date);
        $exam->year = Auth::user()->school->detail->running_session;

        if($exam->save()){

            flash('Exam ' . $exam->name. 'has been successfully added.' ,'success');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        $calendar = new NepaliCalender();

        /* $form_date = $request->date;
        $month = date("m",strtotime($form_date));
        $year = date("Y",strtotime($form_date));
        $day = date("d",strtotime($form_date));
        $cal = $calendar->eng_to_nep($year, $month, $day);
        $date = $cal['year'] . '-' . $cal['month'] . '-' . $cal['date']; */

        $calendar1 = new NepaliCalender();
        $date_result = $request->result_date;
        $month1 = date("m",strtotime($date_result));
        $year1 = date("Y",strtotime($date_result));
        $day1 = date("d",strtotime($date_result));
        $cal1 = $calendar1->eng_to_nep($year1, $month1, $day1);
        $result_date = $cal1['year'] . '-' . $cal1['month'] . '-' . $cal1['date'];


        $exam = Exam::find($request->id);
        $exam->name = $request->name;
        $exam->date = $request->date;
        $exam->result_date = Carbon::parse($result_date);
        $exam->year = Auth::user()->school->detail->running_session;

        if($exam->update()){

            flash('Exam ' . $exam->name. 'has been successfully updated.' ,'success');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        $exam = Exam::find($id);
        $exam->is_active = 0;

        if($exam->update()):
            flash('Exam  ' .$exam->name . ' was deleted successfully.','warning');
            return redirect()->back();
        endif;
    }

    public function restore($id)
    {
        $exam = Exam::find($id);
        $exam->is_active = 1;

        if($exam->update()):
            flash('Exam  ' .$exam->name . ' was restored successfully.','warning');
            return redirect()->back();
        endif;
    }
}
