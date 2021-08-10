<?php

namespace App\Http\Controllers;

use App\Models\ClassW;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ClassController extends Controller
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
        $page = 'Class';

        $classess = ClassW::where('school_id', Auth::user()->school->id)->orderBy('created_at', 'ASC')->get();

        return view('school_admin.class.index', compact('classess', 'page')) ;
    }

    public function bulkImport()
    {
        $page = 'Class';

        return view('school_admin.class.import', compact('page')) ;
    }

    public function bulkImportStore(Request $request)
    {
        $file  =   Input::file('file');
        $ext = $file->getClientOriginalExtension();
        $filename = basename($request->file('file')->getClientOriginalName(), '.' . $request->file('file')->getClientOriginalExtension()). "." . $ext;
        $dest = 'assets/uploads/import/';
        $file->move($dest, $filename);

        $csv = array_map('str_getcsv', file('assets/uploads/import/class.csv'));
        $count = 1;
        $array_size = sizeof($csv);
        foreach ($csv as $row) {
            if ($count == 1) {
               $count++;
               continue;
            }

            $class = new ClassW();
            $class->school_id = Auth::user()->school->id;
            $class->name = $row[0];
            $class->numeric_name = $row[1];
            $class->save();
        }
        flash('Classes were added successfully.','success');
        return redirect()->route('class.index');
    }

    public function store(Request $request)
    {
        $class = new ClassW();
        $class->school_id = Auth::user()->school->id;
        $class->name = $request->name;
        $class->numeric_name = $request->numeric_name;

        if($class->save()):
            flash('Class  ' .$class->name . ' was added successfully.','success');
            return redirect()->back();
        endif;
    }

    public function update(Request $request)
    {
        $class = ClassW::find($request->id);
        $class->name = $request->name;
        $class->numeric_name = $request->numeric_name;

        if($class->update()):
            flash('Class  ' .$class->name . ' was updated successfully.','success');
            return redirect()->back();
        endif;
    }

    public function delete($id)
    {
        $class = ClassW::find($id);
        $class->is_active = 0;

        if($class->update()):
            flash('Class  ' .$class->name . ' was deleted successfully.','warning');
            return redirect()->back();
        endif;
    }
    public function restore($id)
    {
        $class = ClassW::find($id);
        $class->is_active = 1;

        if($class->update()):
            flash('Class  ' .$class->name . ' was restored successfully.','success');
            return redirect()->back();
        endif;
    }
}
