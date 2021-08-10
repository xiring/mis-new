<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class SchoolSettingController extends Controller
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
        $page = 'General Settings';
        $school = School::where('user_id', Auth::user()->id)->where('is_active',1)->first();
        return view('school_admin.settings.index', compact('school', 'page')) ;
    }

    public function update(Request $request)
    {
        $school = School::findOrFail($request->id);

        $school->name = $request->name;
        $school->email = $request->email;
        $school->address = $request->address;
        $school->contact_number = $request->contact_number;

        $detail = $school->detail;

        $detail->currency = $request->currency;
        $detail->running_session = $request->running_session;
        $detail->update();

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

        if($school->update()):
            flash('System settings was updated successfully.','success');
            return redirect()->back();
        endif;
    }
}
