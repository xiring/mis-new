<?php

namespace App\Http\Controllers;

use App\Helpers\NepaliCalender;
use App\Models\ClassSection;
use App\Models\ClassW;
use App\Models\Enroll;
use App\Models\Exam;
use App\Models\ExamMark;
use App\Models\School;
use App\Models\Student;
use App\Models\Subject;
use Carbon\Carbon;
use App\Models\OpttionalMark;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\ManualAttentace;
use Illuminate\Support\Facades\Auth;

class ExamMarkController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $system_settings = School::where('user_id', Auth::user()->id)->first();
            view()->share('system_settings', $system_settings);

            return $next($request);
        });
    }

    public function  manage()
    {
        $page = 'Manage Marks';

        $exams = Exam::where('school_id', Auth::user()->school->id)->where('is_active', 1)->where('year', Auth::user()->school->detail->running_session)->orderBy('created_at', 'ASC')->get();
        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active', 1)->orderBy('numeric_name', 'ASC')->get();
        $marks = array();
        return view('school_admin.exam.marks.index', compact('classes', 'page', 'exams', 'marks'));
    }

    public function  manageOptional()
    {
        $page = 'Manage Marks Optional';

        $exams = Exam::where('school_id', Auth::user()->school->id)->where('is_active', 1)->where('year', Auth::user()->school->detail->running_session)->orderBy('created_at', 'ASC')->get();
        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active', 1)->orderBy('numeric_name', 'ASC')->get();
        $marks = array();
        return view('school_admin.exam.marks.optional.index', compact('classes', 'page', 'exams', 'marks'));
    }

    public function create(\Illuminate\Support\Facades\Request $request)
    {
        $page = 'Manage Marks';
        $school_id = $request::get('school_id');
        $class_id = $request::get('class_id');
        $section_id = $request::get('section_id');
        $subject_id = $request::get('subject_id');
        $exam_id = $request::get('exam_id');

        $class = ClassW::find($class_id);
        $section = ClassSection::find($section_id);
        $subject = Subject::find($subject_id);
        $school = School::find($school_id);
        $exam = Exam::find($exam_id);

        $exams = Exam::where('school_id', $school->id)->where('is_active', 1)->where('year', $school->detail->running_session)->orderBy('created_at', 'ASC')->get();
        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active', 1)->orderBy('numeric_name', 'ASC')->get();

        $enrolls = Enroll::where('school_id', $school->id)->where('year', $school->detail->running_session)->where('class_id', $class->id)->where('section_id', $section->id)->where('is_active', 1)->get();

        //dd($enrolls);

        $enrolls_asc = Enroll::where('school_id', $school->id)->where('year', $school->detail->running_session)->where('class_id', $class->id)->where('section_id', $section->id)->where('is_active', 1)->orderBy('roll_number', 'ASC')->get();

        $marks = ExamMark::whereIn('student_id', $enrolls->pluck('id'))->where('school_id', $school->id)->where('year', $school->detail->running_session)->where('class_id', $class->id)->where('section_id', $section->id)->Where('exam_id', $exam->id)->where('subject_id', $subject->id)->get();

        //dd($marks);

        if ($school_id && $class_id && $section_id && $subject_id && $exam_id) {

            if (count($marks) == 0) {
                $marks_array = array();
                foreach ($enrolls as $enroll) {
                    if ($subject->mark_optional == 1) {
                        $marks_save = new ExamMark();
                        $marks_save->school_id = $school->id;
                        $marks_save->class_id = $class->id;
                        $marks_save->section_id = $section->id;
                        $marks_save->subject_id = $subject->id;
                        $marks_save->exam_id = $exam->id;
                        $marks_save->student_id = $enroll->id;
                        $marks_save->year = $school->detail->running_session;

                        $marks_save->save();
                        array_push($marks_array, $marks_save);
                    }
                }
                $marks = $marks_array;
                if ($school_id == 1) {
                    return view('school_admin.exam.marks.index-samaya', compact('enrolls_asc', 'school', 'classes', 'page', 'exams', 'marks', 'class', 'subject', 'section', 'school', 'exam'));
                } else {
                    return view('school_admin.exam.marks.index', compact('classes', 'page', 'exams', 'marks', 'class', 'subject', 'section', 'school', 'exam'));
                }
            } else {
                if ($school_id == 1) {
                    foreach($enrolls as $enroll){
                        $mark = ExamMark::where('school_id', $school->id)->where('student_id', $enroll->id)->where('year', $school->detail->running_session)->where('class_id', $class->id)->where('section_id', $section->id)->Where('exam_id', $exam->id)->where('subject_id', $subject->id)->first();
                        if($mark){
                           // echo $mark->student_id.'<br/>';
                        }else{
                            $marks_save = new ExamMark();
                            $marks_save->school_id = $school->id;
                            $marks_save->class_id = $class->id;
                            $marks_save->section_id = $section->id;
                            $marks_save->subject_id = $subject->id;
                            $marks_save->exam_id = $exam->id;
                            $marks_save->student_id = $enroll->id;
                            $marks_save->year = $school->detail->running_session;

                            $marks_save->save();
                        }
                    }
                    $marks = ExamMark::whereIn('student_id', $enrolls->pluck('id'))->where('school_id', $school->id)->where('year', $school->detail->running_session)->where('class_id', $class->id)->where('section_id', $section->id)->Where('exam_id', $exam->id)->where('subject_id', $subject->id)->get();
                    return view('school_admin.exam.marks.update-samaya', compact('enrolls_asc', 'school', 'classes', 'page', 'exams', 'marks', 'class', 'subject', 'section', 'school', 'exam'));
                } else {
                    return view('school_admin.exam.marks.update', compact('classes', 'page', 'exams', 'marks', 'class', 'subject', 'section', 'school', 'exam'));
                }
            }
        }
    }

    public function createOptional(\Illuminate\Support\Facades\Request $request)
    {
        $page = 'Manage Marks Optional';
        $school_id = $request::get('school_id');
        $class_id = $request::get('class_id');
        $section_id = $request::get('section_id');
        $subject_id = $request::get('subject_id');
        $exam_id = $request::get('exam_id');

        $class = ClassW::find($class_id);
        $section = ClassSection::find($section_id);
        $subject = Subject::find($subject_id);
        $school = School::find($school_id);
        $exam = Exam::find($exam_id);

        $exams = Exam::where('school_id', $school->id)->where('is_active', 1)->where('year', $school->detail->running_session)->orderBy('created_at', 'ASC')->get();
        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active', 1)->orderBy('numeric_name', 'ASC')->get();

        $enrolls = Enroll::where('school_id', $school->id)->where('year', $school->detail->running_session)->where('class_id', $class->id)->where('section_id', $section->id)->where('is_active', 1)->get();

        //dd($enrolls);

        $marks = OpttionalMark::whereIn('student_id', $enrolls->pluck('id'))->where('school_id', $school->id)->where('year', $school->detail->running_session)->where('class_id', $class->id)->where('section_id', $section->id)->Where('exam_id', $exam->id)->where('subject_id', $subject->id)->get();

        //dd($marks);

        if ($school_id && $class_id && $section_id && $subject_id && $exam_id) {
            if (count($marks) == 0) {
                $marks_array = array();
                foreach ($enrolls as $enroll) {
                    $marks_save = new OpttionalMark();
                    $marks_save->school_id = $school->id;
                    $marks_save->class_id = $class->id;
                    $marks_save->section_id = $section->id;
                    $marks_save->subject_id = $subject->id;
                    $marks_save->exam_id = $exam->id;
                    $marks_save->student_id = $enroll->id;
                    $marks_save->year = $school->detail->running_session;

                    $marks_save->save();
                    array_push($marks_array, $marks_save);
                }
                $marks = $marks_array;
                return view('school_admin.exam.marks.optional.index', compact('classes', 'page', 'exams', 'marks', 'class', 'subject', 'section', 'school', 'exam'));
            } else {
                return view('school_admin.exam.marks.optional.update', compact('classes', 'page', 'exams', 'marks', 'class', 'subject', 'section', 'school', 'exam'));
            }
        }
    }

    public function update(Request $request)
    {
        $page = 'Manage Marks';
        $school_id = $request->school_id;
        $class_id = $request->class_id;
        $section_id = $request->section_id;
        $subject_id = $request->subject_id;
        $exam_id = $request->exam_id;
        $student_ids = $request->student_ids;
        $marks_obtained = $request->marks_obtained;
        $marks_obtained_theory = $request->marks_obtained_theory;
        $marks_obtained_practical = $request->marks_obtained_practical;

        $class = ClassW::find($class_id);
        $section = ClassSection::find($section_id);
        $subject = Subject::find($subject_id);
        $school = School::find($school_id);
        $exam = Exam::find($exam_id);

        $exams = Exam::where('school_id', $school->id)->where('is_active', 1)->where('year', $school->detail->running_session)->orderBy('created_at', 'ASC')->get();
        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active', 1)->orderBy('numeric_name', 'ASC')->get();
        $marks = ExamMark::whereIn('student_id', $student_ids)->where('school_id', $school->id)->where('year', $school->detail->running_session)->where('class_id', $class->id)->where('section_id', $section->id)->Where('exam_id', $exam->id)->where('subject_id', $subject->id)->get();
        $enrolls_asc = Enroll::where('school_id', $school->id)->where('year', $school->detail->running_session)->where('class_id', $class->id)->where('section_id', $section->id)->where('is_active', 1)->orderBy('roll_number', 'ASC')->get();
        if ($school->id == 1) {

            foreach ($student_ids as $k => $student_id) {
                $om = ExamMark::where('student_id', $student_id)->where('subject_id', $subject->id)->where('exam_id', $exam->id)->where('school_id', $school->id)->first();
                if ($request->marks_obtained) {
                    $om->marks_obtained = $marks_obtained[$k];
                } else {
                    $om->marks_obtained_theory = $marks_obtained_theory[$k];
                    $om->marks_obtained_practical = $marks_obtained_practical[$k];
                }

                $om->update();
            }
        } else {
            foreach ($marks as  $k => $mark) {
                $mark = ExamMark::find($mark->id);
                if ($request->marks_obtained) {
                    $mark->marks_obtained = $marks_obtained[$k];
                } else {
                    $mark->marks_obtained_theory = $marks_obtained_theory[$k];
                    $mark->marks_obtained_practical = $marks_obtained_practical[$k];
                }

                $mark->update();
            }
        }
        flash('Marks Updated Successfully.', 'success');
        if ($school_id == 1) {
            return view('school_admin.exam.marks.update-samaya', compact('enrolls_asc', 'school', 'classes', 'page', 'exams', 'marks', 'class', 'subject', 'section', 'school', 'exam'));
        } else {
            return view('school_admin.exam.marks.update', compact('classes', 'page', 'exams', 'marks', 'class', 'subject', 'section', 'school', 'exam'));
        }
    }

    public function updateOptional(Request $request)
    {
        $page = 'Manage Marks Optional';
        $school_id = $request->school_id;
        $class_id = $request->class_id;
        $section_id = $request->section_id;
        $subject_id = $request->subject_id;
        $exam_id = $request->exam_id;
        $student_ids = $request->student_ids;
        $grade_obtained = $request->grade_obtained;

        $class = ClassW::find($class_id);
        $section = ClassSection::find($section_id);
        $subject = Subject::find($subject_id);
        $school = School::find($school_id);
        $exam = Exam::find($exam_id);

        $exams = Exam::where('school_id', $school->id)->where('is_active', 1)->where('year', $school->detail->running_session)->orderBy('created_at', 'ASC')->get();
        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active', 1)->orderBy('numeric_name', 'ASC')->get();
        $marks = OpttionalMark::whereIn('student_id', $student_ids)->where('school_id', $school->id)->where('year', $school->detail->running_session)->where('class_id', $class->id)->where('section_id', $section->id)->Where('exam_id', $exam->id)->where('subject_id', $subject->id)->get();
        foreach ($marks as  $k => $mark) {
            $mark = OpttionalMark::find($mark->id);
            $mark->grade_obtained = $grade_obtained[$k];

            $mark->update();
        }
        flash('Marks Updated Successfully.', 'success');
        return view('school_admin.exam.marks.optional.update', compact('classes', 'page', 'exams', 'marks', 'class', 'subject', 'section', 'school', 'exam'));
    }

    public function tabulationSheet(\Illuminate\Support\Facades\Request $request)
    {
        $page = 'Tabulation Sheet';

        $exams = Exam::where('school_id', Auth::user()->school->id)->where('is_active', 1)->where('year', Auth::user()->school->detail->running_session)->orderBy('created_at', 'ASC')->get();
        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active', 1)->orderBy('numeric_name', 'ASC')->get();

        if ($request::get('school_id') && $request::get('exam_id') && $request::get('class_id') && $request::get('exam_id')) {
            $school_id = $request::get('school_id');
            $class_id = $request::get('class_id');
            $exam_id = $request::get('exam_id');

            $class = ClassW::find($class_id);
            $school = School::find($school_id);
            $exam = Exam::find($exam_id);
            $subjects = Subject::where('class_id', $class->id)->where('is_active', 1)->get();

            $enroll_ids = Enroll::where('is_active', 1)->where('school_id', $school->id)->where('class_id', $class->id)->where('year', $school->detail->running_session)->pluck('id');

            $students = Student::whereIn('enroll_id', $enroll_ids)->orderBy('id', 'ASC')->get();
        } else {
            $students = array();
            $class = '';
            $exam = '';
            $subjects = '';
            $school = School::find(Auth::user()->school->id);
        }
        if ($request::get('school_id') == 1) {
            return view('school_admin.exam.marks.tabulation-samaya', compact('classes', 'page', 'exams', 'students', 'class', 'school', 'exam', 'subjects'));
        } else {
            return view('school_admin.exam.marks.tabulation', compact('classes', 'page', 'exams', 'students', 'class', 'school', 'exam', 'subjects'));
        }
    }

    public function updateMark(Request $request)
    {
        $mark_ids = $request->mark_ids;
        $marks_obtaineds = $request->mark_obtained;

        if (Auth::user()->school->id == 1) {
            $marks_obtained_none = $request->mark_obtained;
            $marks_obtained_practicals = $request->marks_obtained_practical;
            $marks_obtained_theorys = $request->marks_obtained_theory;

            foreach ($mark_ids as  $k => $mark_id) {
                $mark = ExamMark::find($mark_id);
                if ($request->mark_obtained) {
                    $mark->marks_obtained = $marks_obtained_none[$k];
                } else {

                    $mark->marks_obtained_theory = $marks_obtained_theorys[$k];
                    $mark->marks_obtained_practical = $marks_obtained_practicals[$k];
                }

                $mark->update();
            }

            flash('Marks Updated Successfully.', 'success');
            return redirect()->back();
        } else {

            foreach ($mark_ids as $k => $mark_id) {
                $mark = ExamMark::find($mark_id);
                $mark->marks_obtained = $mark_obtaineds[$k];
                $mark->update();
            }

            flash('Marks Updated Successfully.', 'success');
            return redirect()->back();
        }
    }

    public function markSheet(\Illuminate\Support\Facades\Request $request)
    {
        $page = 'Marksheet';

        $exams = Exam::where('school_id', Auth::user()->school->id)->where('is_active', 1)->where('year', Auth::user()->school->detail->running_session)->orderBy('created_at', 'ASC')->get();
        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active', 1)->orderBy('numeric_name', 'ASC')->get();

        if ($request::get('school_id') && $request::get('exam_id') && $request::get('class_id') && $request::get('exam_id')) {
            $school_id = $request::get('school_id');
            $class_id = $request::get('class_id');
            $exam_id = $request::get('exam_id');

            $class = ClassW::find($class_id);
            $school = School::find($school_id);
            $exam = Exam::find($exam_id);

            $marks = ExamMark::where('school_id', $school->id)->where('year', $school->detail->running_session)->where('class_id', $class->id)->Where('exam_id', $exam->id)->get();
            return view('school_admin.exam.marks.mark_sheet', compact('classes', 'page', 'exams', 'marks', 'class', 'exam'));
        } else {
            $marks = array();
            $class = '';
            $school = '';
            $exam = '';
            return view('school_admin.exam.marks.mark_sheet', compact('classes', 'page', 'exams', 'marks', 'class', 'exam'));
        }
    }

    public function markSheetView($exam_id, $class_id, $student_id)
    {
        $class = ClassW::find($class_id);
        $school = Auth::user()->school;
        $exam = Exam::where('id',$exam_id)->where('year', $school->detail->running_session)->first();
        $exams = Exam::where('is_active',1)->where('year', $school->detail->running_session)->get();
        $student = Student::where('enroll_id', $student_id)->first();

        if ($school->id == 2) {
            $primary_subjects = Subject::where('class_id', $class->id)->where('mark_optional', 1)->where('is_active', 1)->get();
            $optional_subjects = Subject::where('class_id', $class->id)->where('mark_optional', 0)->where('is_active', 1)->get();
        } else {
            $subjects = Subject::where('class_id', $class->id)->where('is_active', 1)->orderBy('name', 'ASC')->get();
        }

        $marks = ExamMark::where('school_id', $school->id)->where('year', $school->detail->running_session)->where('class_id', $class->id)->Where('exam_id', $exam->id)->where('class_id', $class->id)->where('student_id', $student->id)->get();

        if ($school->id == 1) {
            $attend = ManualAttentace::where('exam_id', $exam->id)->where('class_id', $class->id)->where('year', $school->detail->running_session)->where('student_id', $student->id)->where('section_id', $student->enroll->section->id)->first();
            if($exam->id == 4){
                return view(
                    'school_admin.exam.marks.mark_sheet_print_annual',
                    compact('class', 'school', 'exam', 'student', 'marks', 'subjects', 'attend', 'exams')
                );
            }else {
                return view(
                    'school_admin.exam.marks.mark_sheet_print',
                    compact('class', 'school', 'exam', 'student', 'marks', 'subjects', 'attend')
                );
            }
        } else {
            $attend = ManualAttentace::where('exam_id', $exam->id)->where('class_id', $class->id)->where('year', $school->detail->running_session)->where('student_id', $student->id)->first();
            $optional_marks = OpttionalMark::where('school_id', $school->id)->where('year', $school->detail->running_session)->where('class_id', $class->id)->Where('exam_id', $exam->id)->where('class_id', $class->id)->where('student_id', $student->id)->get();
            return view('school_admin.exam.marks.mark_sheet_print_ashraya', compact('class', 'school', 'exam', 'student', 'marks', 'primary_subjects', 'attend', 'optional_subjects', 'optional_marks'));
        }
    }

    public function markSheetPrintAll(Request $request)
    {
        //dd($request->all());
        $class = ClassW::find($request->class_id);
        $school = Auth::user()->school;
        $exam = Exam::find($request->exam_id);
        $student_ids = $request->studentids;
        $subjects = Subject::where('class_id', $class->id)->where('is_active', 1)->get();

        if ($school->id == 1) {
            return view('school_admin.exam.marks.mark_sheet_print_samaya_all', compact('class', 'school', 'exam', 'student_ids', 'subjects'));
        } else {
            $primary_subjects = Subject::where('class_id', $class->id)->where('mark_optional', 1)->where('is_active', 1)->get();
            $optional_subjects = Subject::where('class_id', $class->id)->where('mark_optional', 0)->where('is_active', 1)->get();
            return view('school_admin.exam.marks.mark_sheet_print_ashraya_all', compact('class', 'school', 'exam', 'student_ids', 'primary_subjects', 'optional_subjects'));
        }
    }

    public function tabulationSheetPrint(\Illuminate\Support\Facades\Request $request)
    {
        $page = 'Tabulation Sheet';

        $exams = Exam::where('school_id', Auth::user()->school->id)->where('is_active', 1)->where('year', Auth::user()->school->detail->running_session)->orderBy('created_at', 'ASC')->get();
        $classes = ClassW::where('school_id', Auth::user()->school->id)->where('is_active', 1)->orderBy('numeric_name', 'ASC')->get();

        if ($request::get('school_id') && $request::get('exam_id') && $request::get('class_id') && $request::get('exam_id')) {
            $school_id = $request::get('school_id');
            $class_id = $request::get('class_id');
            $exam_id = $request::get('exam_id');

            $class = ClassW::find($class_id);
            $school = School::find($school_id);
            $exam = Exam::find($exam_id);
            //$subjects = Subject::where('class_id', $class->id)->where('is_active', 1)->get();

            //$enroll_ids = Enroll::where('is_active', 1)->where('school_id', $school->id)->where('class_id', $class->id)->where('year', $school->detail->running_session)->pluck('id');

            //$students = Student::whereIn('enroll_id', $enroll_ids)->orderBy('id', 'ASC')->get();
        } else {
            $students = array();
            $class = '';
            $exam = '';
            //$subjects = '';
            $school = School::find(Auth::user()->school->id);
        }
        return view('school_admin.exam.marks.tabulation-print', compact('classes', 'page', 'exams', 'class', 'school', 'exam'));
        /* if ($request::get('school_id') == 1) {
            return view('school_admin.exam.marks.tabulation-samaya', compact('classes', 'page', 'exams', 'students', 'class', 'school', 'exam', 'subjects'));
        } else {
            return view('school_admin.exam.marks.tabulation', compact('classes', 'page', 'exams', 'students', 'class', 'school', 'exam', 'subjects'));
        } */
    }

    public function tabulationSheetCSV($exam_id, $class_id, $section_id)
    {
        //dd($exam_id);

        $school = School::find(Auth::user()->school->id);

        $enrolls = Enroll::where('school_id', $school->id)->where('year', $school->detail->running_session)->where('class_id', $class_id)->where('section_id', $section_id)->where('is_active', 1)->orderBy('roll_number', 'ASC')->get();

        $section = ClassSection::find($section_id);
        $class = ClassW::find($class_id);
        $exam = Exam::find($exam_id);
        $school = School::find(Auth::user()->school->id);

        $subject_ids = $class->subjects->pluck('id')->toArray();
        //$marks = ExamMark::whereIn('student_id', $enrolls->pluck('id'))->where('school_id', $school->id)->where('year', $school->detail->running_session)->where('class_id', $class->id)->where('section_id', $section->id)->Where('exam_id', $exam->id)->where('subject_id', $subject_ids)->get();
        return view('school_admin.exam.marks.tabulation-print1', compact('enrolls', 'section', 'class', 'exam', 'school'));
    }
}
