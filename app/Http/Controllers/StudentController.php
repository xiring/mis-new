<?php

namespace App\Http\Controllers;

use App\Models\ClassSection;
use App\Models\ClassW;
use App\Models\Enroll;
use App\Models\Parents;
use App\Models\Scholarship;
use App\Models\School;
use App\Models\Student;
use App\Models\Transport;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $system_settings = School::where('user_id', Auth::user()->id)->first();
            view()->share('system_settings', $system_settings);

            return $next($request);

        });
    }

    public function admit()
    {
        $page = 'Admit';

        $parents = Parents::where('school_id', Auth::user()->school->id)->where('is_active',1)->get();
        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active',1)->orderBy('numeric_name', 'ASC')->get();
        $sections = ClassSection::where('school_id', Auth::user()->school->id)->where('is_active',1)->get();
        $transport = Transport::where('school_id', Auth::user()->school->id)->where('is_active',1)->get();

        return view('school_admin.student.admit.form',compact('page', 'parents', 'classes', 'sections', 'transport'));
    }

    public function admitBulk()
    {
        $page = 'Admit Bulk';

        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active',1)->orderBy('numeric_name', 'ASC')->get();

        return view('school_admin.student.admit.bulk',compact('page', 'classes'));
    }

    public function downladCsv()
    {
        $path =  'assets/uploads/import.csv';

        return response()->download($path);

    }

    private function generateRandomString($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString.'@gmail.com';
    }


    public function admitBulkStore(Request $request)
    {
        $file  =   Input::file('uploaded_file');
        $ext = $file->getClientOriginalExtension();
        $filename = basename($request->file('uploaded_file')->getClientOriginalName(), '.' . $request->file('uploaded_file')->getClientOriginalExtension()). "." . $ext;
        $dest = 'assets/uploads/import/';
        $file->move($dest, $filename);

        $csv = array_map('str_getcsv', file('assets/uploads/import/'.$filename));
        $count = 1;
        $array_size = sizeof($csv);
        foreach ($csv as $row) {
            if ($count == 1) {
               $count++;
               continue;
            }

            $user = new User();
            $user->name = $row[0];
            $user->email = ($row[2]) ? $row[2] : $this->generateRandomString();
            $user->password = Hash::make('admin123');
            $user->user_type = 5;
            $user->save();

            $enroll = new Enroll();
            $enroll->enroll_code = $request->school_id.$row[1].$row[3].$request->class_id;
            $enroll->school_id = $request->school_id;
            $enroll->class_id = $request->class_id;
            $enroll->section_id = $request->section_id;
            $enroll->roll_number = $row[1];
            $enroll->year = Auth::user()->school->detail->running_session;
            $enroll->save();

            $student = new Student();
            $student->enroll_id = $enroll->id;
            $student->user_id = $user->id;
            $student->address = $row[4];
            $student->parent_id = $row[3];
            $student->save();

        }

        if($student->save()):
            flash('Students were imported successfully.','success');
            return redirect()->back();
        endif;
    }

    public function admitStore(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make('admin123');
        $user->user_type = 5;
        $user->save();

        $enroll = new Enroll();
        $enroll->enroll_code = $request->school_id.$request->roll_number.$request->parent_id.$request->class_id;
        $enroll->school_id = $request->school_id;
        $enroll->class_id = $request->class_id;
        $enroll->section_id = $request->section_id;
        $enroll->roll_number = $request->roll_number;
        $enroll->year = Auth::user()->school->detail->running_session;
        $enroll->save();

        $student = new Student();
        $student->enroll_id = $enroll->id;
        $student->user_id = $user->id;
        $student->date_of_birth = Carbon::parse($request->date_of_birth);
        $student->gender = $request->gender;
        $student->religion = $request->religion;
        $student->address = $request->address;
        $student->transport_id = $request->transport_id;
        $student->parent_id = $request->parent_id;

        if($student->save()):
            flash('Student  ' .$student->user->name . ' was added successfully.','success');
            return redirect()->back();
        endif;
    }

    public function update(Request $request)
    {
        $enroll = Enroll::find($request->id);
        $user = $enroll->student->user;
        $user->name = $request->name;
        $user->update();

        $enroll->class_id = $request->class_id;
        $enroll->section_id = $request->section_id;
        $enroll->roll_number = $request->roll_number;
        $enroll->update();

        $student = $enroll->student;
        $student->date_of_birth = Carbon::parse($request->date_of_birth);
        $student->gender = $request->gender;
        $student->religion = $request->religion;
        $student->address = $request->address;
        $student->transport_id = $request->transport_id;
        $student->parent_id = $request->parent_id;
        $student->dob_nepali = $request->dob_nepali;
        $student->house = $request->house;

        if($student->update()):
            flash('Student  ' .$student->user->name . ' was added successfully.','success');
            return redirect()->back();
        endif;
    }

    public function studentByClassId($id)
    {
        $page = 'Student Information';

        $class = ClassW::where('id', $id)->first();
        $enrolls = $class->enroll()->where('is_active',1)->orderBy('created_at', 'ASC')->where('year', Auth::user()->school->detail->running_session)->get();

        $parents = Parents::where('school_id', Auth::user()->school->id)->where('is_active',1)->get();
        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active',1)->get();
        $sections = ClassSection::where('school_id', Auth::user()->school->id)->where('is_active',1)->get();
        $transport = Transport::where('school_id', Auth::user()->school->id)->where('is_active',1)->get();
        $enroll_sections = $class->enroll()->orderBy('created_at', 'ASC')->where('is_active',1)->where('year', Auth::user()->school->detail->running_session);
        $scholarships = Scholarship::where('school_id', Auth::user()->school->id)->where('is_active',1)->get();

        return view('school_admin.student.list.index',compact('page', 'enrolls', 'class', 'parents', 'classes', 'sections', 'transport', 'enroll_sections', 'scholarships'));
    }

    public function leftStudentByClass($id)
    {
        $page = 'Student Information';

        $class = ClassW::where('id', $id)->first();
        $enrolls = $class->enroll()->where('is_active',0)->orderBy('created_at', 'ASC')->where('year', Auth::user()->school->detail->running_session)->get();
        $enroll_sections = $class->enroll()->orderBy('created_at', 'ASC')->where('year', Auth::user()->school->detail->running_session);

        return view('school_admin.student.list.left',compact('page', 'enrolls', 'class', 'enroll_sections'));

    }

    public function studentByClassAndSectionId($class_id, $section_id)
    {
        $page = 'Student Information';

        $class = ClassW::where('id', $class_id)->first();
        $parents = Parents::where('school_id', Auth::user()->school->id)->where('is_active',1)->get();
        $enrolls = $class->enroll()->orderBy('created_at', 'ASC')->where('year', Auth::user()->school->detail->running_session)->where('is_active',1)->get();
        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active',1)->get();
        $sections = ClassSection::where('school_id', Auth::user()->school->id)->where('is_active',1)->get();
        $transport = Transport::where('school_id', Auth::user()->school->id)->where('is_active',1)->get();
        $enroll_sections = $class->enroll()->orderBy('created_at', 'ASC')->where('year', Auth::user()->school->detail->running_session)->where('section_id', $section_id)->where('is_active',1)->get();
        $scholarships = Scholarship::where('school_id', Auth::user()->school->id)->where('is_active',1)->get();
        $section = ClassSection::where('id', $section_id)->first();

        return view('school_admin.student.list.section',compact('page', 'enrolls', 'class', 'parents', 'classes', 'sections', 'transport', 'enroll_sections', 'scholarships' ,'section_id', 'section'));
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->is_active = 0;

        if($user->update()):
            flash('Student  ' .$user->name . ' was deleted successfully.','warning');
            return redirect()->back();
        endif;
    }

    public function restore($id)
    {
        $user = User::find($id);
        $user->is_active = 1;

        if($user->update()):
            flash('Student  ' .$user->name . ' was restored successfully.','success');
            return redirect()->back();
        endif;
    }

    public function updateScholarship(Request $request)
    {
        $student = Student::find($request->id);
        $student->scholarship_id = $request->scholarship_id;

        if($student->update()):
            flash('Scholarship for student  ' .$student->user->name . ' was updated successfully.','success');
            return redirect()->back();
        endif;
    }

    public function markLeft($id)
    {
        $enroll = Enroll::find($id);
        $enroll->is_active = 0;

        $user = $enroll->student->user;
        $user->is_active = 0;

        if($user->update() && $enroll->update()):
            flash('Student  ' .$user->name . ' was marked left the school successfully.','success');
            return redirect()->back();
        endif;
    }

    public function markUnLeft($id)
    {
        $enroll = Enroll::find($id);
        $enroll->is_active = 1;

        $user = $enroll->student->user;
        $user->is_active = 1;

        if($user->update() && $enroll->update()):
            flash('Student  ' .$user->name . ' was marked un-left the school successfully.','success');
            return redirect()->back();
        endif;
    }

    public function demote($id)
    {
        $enroll = Enroll::find($id);

        $class = ClassW::where('id', $enroll->class_id)->first();
        $demotion_class_id = $class->id - 1;
        $demotion_class = ClassW::where('id', $demotion_class_id)->first();

        $section_a = $demotion_class->sections->where('name', 'A')->first();
        $section_b = $demotion_class->sections->where('name', 'B')->first();


        $enroll->class_id = $demotion_class->id;
        $enroll->year = $enroll->year;
        if($enroll->section->name == 'A')
        {
            $enroll->section_id = $section_a->id;
        }else{
            $enroll->section_id = $section_b->id;
        }
        $enroll->update();

        flash('Students has been demoted successfully','success');
        return redirect()->back();
    }

    public function jump($id)
    {
        $enroll = Enroll::find($id);

        $class = ClassW::where('id', $enroll->class_id)->first();
        $jumping_class_id = $class->id + 1;
        $jumping_class = ClassW::where('id', $jumping_class_id)->first();

        $section_a = $jumping_class->sections->where('name', 'A')->first();
        $section_b = $jumping_class->sections->where('name', 'B')->first();

        $enroll->class_id = $jumping_class->id;
        $enroll->year = $enroll->year;
        if($enroll->section->name == 'A')
        {
            $enroll->section_id = $section_a->id;
        }else{
            $enroll->section_id = $section_b->id;
        }
        $enroll->update();

        flash('Students has been jumped to another class successfully','success');
        return redirect()->back();
    }

    public function searchStudent()
    {
        $page = 'Student Information';

        $user_ids = User::where('name', 'like', '%' . Input::get('student_name') . '%')->pluck('id')->toArray();

        $students = Student::whereIn('user_id', $user_ids)->get();

        return view('school_admin.student.list.search_results',compact('page','students'));
    }

    public function viewStudent($id)
    {
        $page = 'Student Information';

        $enroll = Enroll::find($id);
        return view('school_admin.student.list.view',compact('page','enroll'));
    }

    public function report()
    {
        $page = 'Student Report';
        $classes = ClassW::where('school_id', Auth::user()->school->id)->get();
        $enrolls = array();

        return view('school_admin.student.report.index',compact('page','classes', 'enrolls'));
    }

    public function reportByClassId()
    {
        $page = 'Student Report';
        $classes = ClassW::where('school_id', Auth::user()->school->id)->get();
        $class = Classw::find(Input::get('class_id'));
        $enrolls = Enroll::where('class_id', Input::get('class_id'))->where('is_active',1)->orderBy('roll_number', 'ASC')->get();

        return view('school_admin.student.report.index',compact('page','classes', 'class', 'enrolls'));
    }
}
