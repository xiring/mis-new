<?php

namespace App\Http\Controllers;

use App\Models\ClassSection;
use App\Models\School;
use App\Models\Teacher;
use App\Models\ClassW;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassSectionController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $system_settings = School::where('user_id', Auth::user()->id)->first();
            view()->share('system_settings', $system_settings);

            return $next($request);

        });
    }

    public function sectionByClassId($id)
    {
        $page = 'Section';
        $class = ClassW::where('id', $id)->first();
        $sections = ClassSection::where('class_id', $class->id)->orderBy('created_at', 'ASC')->get();
        $teachers = Teacher::where('school_id', Auth::user()->school->id)->get();
        return view('school_admin.class.section', compact('sections', 'page', 'class', 'teachers')) ;
    }

    public function store(Request $request)
    {
        $section = new ClassSection();
        $section->school_id = $request->school_id;
        $section->class_id = $request->class_id;
        $section->name = $request->name;
        $section->teacher_id = $request->teacher_id;

        if($section->save()):
            flash('Section  ' .$section->name . ' was added successfully.','success');
            return redirect()->back();
        endif;
    }

    public function update(Request $request)
    {
        $section  =  ClassSection::find($request->id);
        $section->name = $request->name;

        if($section->update()):
            flash('Section  ' .$section->name . ' was updated successfully.','success');
            return redirect()->back();
        endif;
    }

    public function delete($id)
    {
        $section = ClassSection::find($id);
        $section->is_active = 0;

        if($section->update()):
            flash('Section  ' .$section->name . ' was deleted successfully.','warning');
            return redirect()->back();
        endif;
    }

    public function restore($id)
    {
        $section = ClassSection::find($id);
        $section->is_active = 1;

        if($section->update()):
            flash('Section  ' .$section->name . ' was restored successfully.','success');
            return redirect()->back();
        endif;
    }
}
