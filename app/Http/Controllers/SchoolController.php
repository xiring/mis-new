<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\SchoolDetail;
use App\Models\SchoolLicense;
use App\User;
use App\Models\School;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::orderBy('created_at', 'ASC')->get();
        $licenses = License::where('is_active',1)->get();

        return view('master.school.index', compact('schools', 'licenses')) ;
    }

    public function store(Request $request)
    {
        $user = new User();

        $user->name = $request->contact_person;
        $user->email = $request->email;
        $user->password = Hash::make('admin123');
        $user->user_type = 2;

        $user->save();

        $school = new School();

        $school->user_id = $user->id;
        $school->name = $request->name;
        $school->email = $request->email;
        $school->address = $request->address;
        $school->contact_number = $request->contact_number;
        $school->contact_person = $request->contact_person;

        $image  =   Input::file('logo');

        if($request->hasFile('logo')) {
            if ($image->isValid()) {

                $ext = $image->getClientOriginalExtension();
                $filename = basename($request->file('logo')->getClientOriginalName(), '.' . $request->file('logo')->getClientOriginalExtension()) . time() . "." . $ext;
                $dest = 'assets/uploads/school/logo';
                $image->move($dest, $filename);
                $school->logo = $dest . '/' . $filename;
            }
        }

        if($school->save()):

            $school_license = new SchoolLicense();
            $school_license->school_id = $school->id;
            $school_license->save();

            $school_detail = new SchoolDetail();
            $school_detail->school_id = $school->id;
            $school_detail->save();

            flash('School  ' .$school->name . ' was created successfully.','success');
            return redirect()->back();
        endif;

    }

    public function delete($id)
    {
        $school = School::findOrFail($id);

        $admin = $school->admin;

        $admin->is_active = 0;
        $admin->update();

        $school->is_active = 0;

        if($school->update()):
            flash('School  ' .$school->name . ' was deleted successfully.','warning');
            return redirect()->back();
        endif;
    }

    public function restore($id)
    {
        $school = School::findOrFail($id);

        $admin = $school->admin;

        $admin->is_active = 1;
        $admin->update();

        $school->is_active = 1;

        if($school->update()):
            flash('School  ' .$school->name . ' was restored successfully.','success');
            return redirect()->back();
        endif;
    }

    public function licenseUpdate(Request $request)
    {
        $school_license = SchoolLicense::where('id', $request->school_license_id)->where('school_id', $request->school_id)->first();

        $school_license->license_id = $request->licens_id;

        $school_license->valid_till = Carbon::now()->addYear(1);

        if($school_license->update()):
            flash('School license for   ' .$school_license->school->name . ' was updated successfully.','success');
            return redirect()->back();
        endif;
    }
}
