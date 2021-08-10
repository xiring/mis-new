<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Teacher;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class TeacherController extends Controller
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
        $page = 'Teacher';

        $teachers = Teacher::where('school_id', Auth::user()->school->id)->orderBy('created_at', 'ASC')->get();

        return view('school_admin.teacher.index', compact('teachers', 'page')) ;
    }

    public function bulkImport()
    {
        $page = 'Teacher';

        return view('school_admin.teacher.import', compact('page')) ;
    }

    public function bulkImportStore(Request $request)
    {
        $file  =   Input::file('file');
        $ext = $file->getClientOriginalExtension();
        $filename = basename($request->file('file')->getClientOriginalName(), '.' . $request->file('file')->getClientOriginalExtension()). "." . $ext;
        $dest = 'assets/uploads/import/';
        $file->move($dest, $filename);

        $csv = array_map('str_getcsv', file('assets/uploads/import/teacher.csv'));
        $count = 1;
        $array_size = sizeof($csv);
        foreach ($csv as $row) {
            if ($count == 1) {
               $count++;
               continue;
            }

            $user = new User();
            $user->name = $row[0];
            $user->email = $row[5];
            $user->user_type = 3;
            $user->password = Hash::make('admin123');
            $user->save();


            $teacher = new Teacher();
            $teacher->school_id = Auth::user()->school->id;
            $teacher->user_id = $user->id;
            $teacher->designation = $row[6];
            $teacher->date_of_birth = Carbon::parse($row[1]);
            $teacher->gender = $row[2];
            $teacher->addresss = $row[3];
            $teacher->phone = $request[4];
            $teacher->save();
        }
        flash('Teachers  were imported successfully.','success');
        return redirect()->route('teacher.index');
    }

    public function store(Request $request)
    {
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type = 3;
        $user->password = Hash::make('admin123');

        $user->save();

        $teacher = new Teacher();

        $teacher->school_id = Auth::user()->school->id;
        $teacher->user_id = $user->id;
        $teacher->designation = $request->designation;
        $teacher->hired_date = Carbon::parse($request->hired_date);
        $teacher->date_of_birth = Carbon::parse($request->date_of_birth);
        $teacher->gender = $request->gender;
        $teacher->addresss = $request->address;
        $teacher->phone = $request->phone;

        $image  =   Input::file('photo');

        if($request->hasFile('photo')) {
            if ($image->isValid()) {

                $ext = $image->getClientOriginalExtension();
                $filename = basename($request->file('photo')->getClientOriginalName(), '.' . $request->file('photo')->getClientOriginalExtension()) . time() . "." . $ext;
                $dest = 'assets/uploads/school/employee';
                $image->move($dest, $filename);
                $teacher->photo = $dest . '/' . $filename;
            }
        }

        if($teacher->save()):
            flash('Teacher  ' .$teacher->name . ' was added successfully.','success');
            return redirect()->back();
        endif;
    }

    public function update(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();

        $user->name = $request->name;

        $user->update();

        $teacher = Teacher::where('user_id', $user->id)->first();

        $teacher->designation = $request->designation;
        $teacher->hired_date = Carbon::parse($request->hired_date);
        $teacher->date_of_birth = Carbon::parse($request->date_of_birth);
        $teacher->gender = $request->gender;
        $teacher->addresss = $request->address;
        $teacher->phone = $request->phone;

        $image  =   Input::file('photo');

        if($request->hasFile('photo')) {
            if ($image->isValid()) {

                $ext = $image->getClientOriginalExtension();
                $filename = basename($request->file('photo')->getClientOriginalName(), '.' . $request->file('photo')->getClientOriginalExtension()) . time() . "." . $ext;
                $dest = 'assets/uploads/school/employee';
                $image->move($dest, $filename);
                $teacher->photo = $dest . '/' . $filename;
            }
        }

        if($teacher->update()):
            flash('Teacher  ' .$teacher->name . ' was updated successfully.','success');
            return redirect()->back();
        endif;
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->is_active = 0;

        if($user->update()):
            flash('Teacher  ' .$user->name . ' was deleted successfully.','warning');
            return redirect()->back();
        endif;
    }

    public function restore($id)
    {
        $user = User::find($id);
        $user->is_active = 1;

        if($user->update()):
            flash('Teacher  ' .$user->name . ' was restored successfully.','success');
            return redirect()->back();
        endif;
    }
}
