<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Student;
use App\Models\Transport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransportController extends Controller
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
        $page = 'Transports';

        $transports = Transport::where('school_id', Auth::user()->school->id)->orderBy('created_at', 'ASC')->get();

        return view('school_admin.transport.index', compact('transports', 'page')) ;
    }

    public function store(Request $request)
    {
        $transport = new Transport();
        $transport->school_id = $request->school_id;
        $transport->name = $request->name;
        $transport->number_of_vehicle = $request->number_of_vehicle;
        $transport->fare = $request->fare;

        if($transport->save()):
            flash('Transport route  ' .$transport->name . ' was added successfully.','success');
            return redirect()->back();
        endif;
    }

    public function update(Request $request)
    {
        $transport = Transport::find($request->id);
        $transport->name = $request->name;
        $transport->number_of_vehicle = $request->number_of_vehicle;
        $transport->fare = $request->fare;

        if($transport->update()):
            flash('Transport route  ' .$transport->name . ' was updated successfully.','success');
            return redirect()->back();
        endif;
    }

    public function delete($id)
    {
        $transport = Transport::find($id);
        $transport->is_active = 0;

        if($transport->update()):
            flash('Transport route  ' .$transport->name . ' was deleted successfully.','warning');
            return redirect()->back();
        endif;
    }

    public function restore($id)
    {
        $transport = Transport::find($id);
        $transport->is_active = 1;

        if($transport->update()):
            flash('Transport route  ' .$transport->name . ' was restored successfully.','success');
            return redirect()->back();
        endif;
    }

    public function students($id)
    {
        $page = 'Transports';
        $transport = Transport::find($id);
        $students = Student::where('transport_id', $id)->get();

        return view('school_admin.transport.students', compact('transport', 'page', 'students')) ;
    }

    public function studentRemove($id)
    {
        $student = Student::find($id);

        $student->transport_id = 0;

        if($student->update()):
            flash('Student ' .$student->user->name . ' was has been successfully removed.','warning');
            return redirect()->back();
        endif;
    }
}
