<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScholarshipController extends Controller
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
        $page = 'Scholarships';

        $scholarships = Scholarship::orderBy('created_at', 'ASC')->where('school_id', Auth::user()->school->id)->get();

        return view('school_admin.accounting.scholarship.index', compact('page', 'scholarships'));
    }

    public function store(Request $request)
    {
        $scholarship = new Scholarship();
        $scholarship->school_id = $request->school_id;
        $scholarship->name = $request->name;
        $scholarship->percentage = $request->percentage;

        if($scholarship->save()){

            flash('Scholarship category' . $scholarship->name. 'has been successfully added.' ,'success');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        $scholarship = Scholarship::find($request->id);
        $scholarship->name = $request->name;
        $scholarship->percentage = $request->percentage;

        if($scholarship->update()){

            flash('Scholarship category' . $scholarship->name. 'has been successfully updated.' ,'success');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        $scholarship = Scholarship::find($id);
        $scholarship->is_active = 0;

        if($scholarship->update()):
            flash('Scholarship category  ' .$scholarship->name . ' was deleted successfully.','warning');
            return redirect()->back();
        endif;
    }

    public function restore($id)
    {
        $scholarship = Scholarship::find($id);
        $scholarship->is_active = 1;

        if($scholarship->update()):
            flash('Scholarship category  ' .$scholarship->name . ' was restored successfully.','warning');
            return redirect()->back();
        endif;
    }

    public function students($id)
    {
        $page = 'Scholarships';
        $scholarship = Scholarship::where('id', $id)->first();

        $students = Student::where('scholarship_id', $scholarship->id)->get();


        return view('school_admin.accounting.scholarship.students', compact('page', 'students', 'scholarship'));
    }

    public function studentRemove($id)
    {
        $student = Student::find($id);

        $student->scholarship_id = 0;

        if($student->update()):
            flash('Student ' .$student->user->name . ' was has been successfully removed.','warning');
            return redirect()->back();
        endif;
    }
}
