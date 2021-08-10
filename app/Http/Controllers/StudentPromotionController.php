<?php

namespace App\Http\Controllers;

use App\Models\ClassSection;
use App\Models\ClassW;
use App\Models\Enroll;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentPromotionController extends Controller
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
        $page = 'Student Promotion';
        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active',1)->orderBy('numeric_name', 'ASC')->get();

        return view('school_admin.student.promotion.index',compact('page', 'classes'));
    }

    public function store(Request $request)
    {
        $enroll_ids = $request->enroll_ids;
        $class_ids = $request->class_ids;
        $section_ids = $request->section_ids;

        $promotion_from_class = ClassW::where('id', $request->promotion_from_class)->first();
        $class = ClassW::where('id', $request->promotion_to_class)->first();
        $section_a = $class->sections->where('name', 'A')->first();
        $section_b = $class->sections->where('name', 'B')->first();
        $secion_A = $promotion_from_class->sections->where('name', 'A')->first();
        $section_B = $promotion_from_class->sections->where('name', 'B')->first();

        foreach ($enroll_ids as $k=>$id)
        {
            $enroll = Enroll::find($id);
            $enroll->class_id = $class_ids[$k];
            $enroll->year = $request->promote_to_session;
            if($promotion_from_class->id == $class_ids[$k]){
                if($section_ids[$k] == 'A')
                {
                    $enroll->section_id = $secion_A->id;
                }else{
                    $enroll->section_id = ($section_B) ? $section_B->id : $section_B->id;
                }
            }else{
                if($section_ids[$k] == 'A')
                {
                    $enroll->section_id = $section_a->id;
                }else{
                    $enroll->section_id = ($section_b) ? $section_b->id : $section_a->id;
                }
            }
            $enroll->update();
        }

        flash('Students has been promted successfully','success');
        return redirect()->back();
    }
}
