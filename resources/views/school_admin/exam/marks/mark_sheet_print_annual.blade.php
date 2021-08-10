@php
    $grades = App\Models\ExamGrade::where('school_id', Auth::user()->school->id)->get();
@endphp
@include('school_admin.grade')
<div class="main-wrapper">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <style type="text/css">
        .main-wrapper{
            font-family: Helvetica Neue,Helvetica,Arial,sans-serif;
            width: 800px;
            height: 842px;
            padding-top: 10px;
        }
        .clear{
            clear:both;
        }
        .full-slogan{
            width: 100%;
            text-align: center;
            font-style: italic;
            font-size: 12px;
        }
        .header-group{
            width: 100%;
            padding: 0px 5px;
            height: 100px;
        }
        .logo{
            width: 130px;
            float: left;
        }
        .logo img{
            height: 70px;
        }
        .box-name{
            width: 220px;
            float: left;
            height: 30px;
            text-align: center;
            margin-left: 118px;
        }
        .box-name h2{
            margin: 0px 0px 5px;
            font-size: 20px;
            text-transform: uppercase;
        }
        .address{
            font-size: 12px;
            margin: 0px;
        }
        .contact{
            font-size: 12px;
            margin: 5px 0px 0px;
        }
        .box-text{
            border:1px solid #0000FF;
            border-radius: 5px;
            background: #A52A2A;
            color: #fff;
            font-size: 15px;
            padding: 3px;
            width: 150px;
            margin: 10px auto 0;
        }
        .student-details{
            width: 100%;
        }
        table{
            padding-right: 15px;
            padding-left: 15px;
            font-size: 14px;

        }
        table.table{
            width: 100%;
            font-size: 14px;
            line-height: 20px;
        }
        td.right-house{
            float: right;
        }
        .first-term{
            padding-right: 15px;
            padding-left: 15px;
        }
        table.table-one{
            text-align: center;
            width: 100%;
            border:1px solid #00000052;
            font-size: 14px;

        }
        table.table-two{
            border-collapse: collapse;
            width: 100%;
            border:1px solid #00000052;
            margin-top: 5px;
        }
        .table-two td{
            border: 1px solid #00000052;
            padding: 3px;
            border-bottom: none !important;
            border-top: none !important;
            font-size: 14px;

        }
        .total-right td{
            text-align: right;
        }
        table.table-three{
            text-align: center;
            margin-top: 5px;
            width: 100%;
            border:1px solid #00000052;
            border-collapse: collapse;
            font-size: 14px;
            line-height: 20px;

        }
        table.table-three td{
            border:1px solid #00000052;
        }
        table.table-four{
            width: 100%;
            text-align: center;
            margin-top: 5px;
            border:1px solid black;
            border-collapse: collapse;
            font-size: 14px;
            line-height: 17px;

        }
        table.table-four td{
            border:1px solid  #00000052;
        }
        table.one-gray{
            margin-top: 5px;
            border-collapse: collapse;
            width: 100%;
        }
        table.one-gray td{
            text-align: left;
            border:1px solid #00000052;
            font-size: 14px;
            line-height: 30px;
        }
        td.padding {
        }
        table.table-five{
            width: 100%;
            text-align: center;
            margin-top: 65px;
            border:1px solid  #00000052;
            border-collapse: collapse;
            line-height: 15px;
        }
        table.table-five td{
            border:1px solid  #00000052;
        }
        td.padding-btm{
            padding: 3px;
        }
        .thery{
            border-right: 1px solid #000;
            width: 50%;
            display: block;
            float: left;
        }
        .footer{
            margin-top:40px;
            font-size: 12px;
        }
        .table-three{
            font-size:9px;
        }
        .table-four{
            font-size:12px;
        }
    </style>
    <div class="header">
        <div class="full-slogan">
            <p style="margin-left:15px;margin-bottom:0px;">"Time Tested Education : Our Aspiration"</p>
        </div>
        <div class="header-group">
            <div class="logo">
                <img src="https://samayapathshala.edu.np/public/assets/uploads/school/logo/logo%20(1)1555144152.png">
            </div>
            <div class="box-name">
                <h2>{{ $school->name }}</h2>
                <p class="address">{{ $school->address }}</p>
                <p class="contact">Contact:{{ $school->contact_number }}</p>
                <p class="box-text">GRADE SHEET</p>
            </div>
        </div>
        <div  class="student-details clear">
            <table class="table">
                <tr>
                    <td><b>Name:</b>{{ $student->user->name }}</td>
                    <td class="right-house"><b>House:</b>{{ $student->house }}</td>
                </tr>

            </table>
            <table class="table">
                <tr>
                    <td><b>Class: {{ $class->name }}</b></td>
                    <td><b>Section: {{ $student->enroll->section->name }}</b></td>
                    <td class="right-house"><b>Roll No:</b> {{ $student->enroll->roll_number }}</td>
                </tr>
            </table>
            <div class="first-term">
                <table class="table-one">
                    <tr>
                        <td><b>{{ $exam->name }}</b></td>
                    </tr>
                </table>
                <table class="table-two">
                    <thead style="text-align: center">
                    <tr style="border-bottom: 1px solid #00000052;font-weight:bold;">
                        <td colspan="2"></td>
                        <td colspan="2">Annual Exam</td>
                        <td colspan="6">Final Evaluation</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #00000052;font-weight:bold;">
                        <td>S.N</td>
                        <td>Subjects</td>
                        <td>Full Marks</td>
                        <td>Obtained Grade</td>
                        <td>1st Term(10%)</td>
                        <td>2nd Term(10%)</td>
                        <td>3rd Term(10%)</td>
                        <td>Annual Exam (70%)</td>
                        <td>Obtained Grade</td>
                        <td>Grade Point</td>
                    </tr>
                    </thead>
                    @php
                        $total_marks = 0;
                        $total_full_marks = array();
                        $n = 0;
                        $total_grade_point = 0;
                    @endphp
                    <tbody style="font-size: 10px;">
                    @foreach($marks as $mark)
                        <tr>
                            <td>{{ ++$n }}</td>
                            <td>{{ $mark->subject->name }}</td>
                            <td style="text-align: center">
                                {{ $mark->subject->full_marks }}
                                @php array_push($total_full_marks, $mark->subject->full_marks) @endphp
                            </td>
                            <td style="text-align: center">
                                @include('school_admin.exam.marks.partials.annual')
                            </td>
                            @php
                                $exam_marks = \App\Models\ExamMark::whereIn('exam_id', $exams->pluck('id')->toArray())->where('subject_id', $mark->subject_id)->where('school_id', $school->id)->where('student_id', $mark->student_id)->get();
                            @endphp
                            @if(!is_null($exam_marks))
                                @foreach($exam_marks as $exam_mark)
                                    <td style="text-align: center">
                                        @if($exam_mark->exam_id == 1 || $exam_mark->exam_id == 2 || $exam_mark->exam_id == 3)
                                            @if($exam_mark->subject->type == 'is_none')
                                                @php
                                                    $grade = getGrade($exam_mark->marks_obtained / $exam_mark->subject->full_marks * 100, $grades);
                                                    echo $grade['name'];
                                                @endphp
                                            @else
                                                @php
                                                    $theory = $exam_mark->marks_obtained_theory  / $exam_mark->subject->full_marks * 100;
                                                    $practical = $exam_mark->marks_obtained_practical  / $exam_mark->subject->full_marks * 100;
                                                    if($mark->subject->full_marks == 50)
                                                    {
                                                        $mark_t_p = $theory + $practical / 100 * 100;
                                                    }else{
                                                        $mark_t_p = $theory + $practical / $mark->subject->full_marks * 100;
                                                    }
                                                    $grade = getGrade($mark_t_p, $grades);
                                                    echo $grade['name'];
                                                @endphp
                                            @endif
                                        @else
                                            @if($exam_mark->subject->type == 'is_none')
                                                @php
                                                    $grade = getGrade($exam_mark->marks_obtained / $exam_mark->subject->full_marks * 100, $grades);
                                                    echo $grade['name'];
                                                @endphp
                                            @else
                                                @php
                                                    $theory = $exam_mark->marks_obtained_theory  / $exam_mark->subject->full_marks * 100;
                                                    $practical = $exam_mark->marks_obtained_practical  / $exam_mark->subject->full_marks * 100;
                                                    if($mark->subject->full_marks == 50)
                                                    {
                                                        $mark_t_p = $theory + $practical / 100 * 100;
                                                    }else{
                                                        $mark_t_p = $theory + $practical / $mark->subject->full_marks * 100;
                                                    }
                                                    $grade = getGrade($mark_t_p, $grades);
                                                    echo $grade['name'];
                                                @endphp
                                            @endif
                                        @endif
                                    </td>
                                @endforeach
                            @endif
                            <td style="text-align: center">
                                @php
                                    $first_terminal = \App\Models\ExamMark::where('exam_id', 1)->where('subject_id', $mark->subject_id)->where('school_id', $school->id)->where('student_id', $mark->student_id)->first();
                                    $second_terminal = \App\Models\ExamMark::where('exam_id', 2)->where('subject_id', $mark->subject_id)->where('school_id', $school->id)->where('student_id', $mark->student_id)->first();
                                    $third_terminal = \App\Models\ExamMark::where('exam_id', 3)->where('subject_id', $mark->subject_id)->where('school_id', $school->id)->where('student_id', $mark->student_id)->first();
                                    $annual_terminal = \App\Models\ExamMark::where('exam_id', 4)->where('subject_id', $mark->subject_id)->where('school_id', $school->id)->where('student_id', $mark->student_id)->first();
                                @endphp
                                @if($first_terminal->subject->type == 'is_none' || $second_terminal->subject->type == 'is_none' || $third_terminal->subject->type == 'is_none' || $annual_terminal->subject->type == 'is_none')
                                    @php
                                        $first_terminal_mark_obtained = $first_terminal->marks_obtained/100 * 10;
                                        $second_terminal_mark_obtained = $second_terminal->marks_obtained/100 * 10;
                                        $third_terminal_mark_obtained = $third_terminal->marks_obtained/100 * 10;
                                        $annual_terminal_mark_obtained = $annual_terminal->marks_obtained/100 * 70;
                                        $total_mark_obtained = $first_terminal_mark_obtained + $second_terminal_mark_obtained + $third_terminal_mark_obtained + $annual_terminal_mark_obtained;
                                        $grade = getGrade($total_mark_obtained / $first_terminal->subject->full_marks * 100, $grades);
                                        echo $grade['name'];
                                    @endphp
                                @else
                                    @php
                                        $first_terminal_mark_obtained_theory = $first_terminal->marks_obtained_theory;
                                        $second_terminal_mark_obtained_theory = $second_terminal->marks_obtained_theory;
                                        $third_terminal_mark_obtained_theory = $third_terminal->marks_obtained_theory;
                                        $annual_terminal_mark_obtained_theory = $annual_terminal->marks_obtained_theory;
                                        $first_terminal_mark_obtained_practical = $first_terminal->marks_obtained_practical;
                                        $second_terminal_mark_obtained_practical = $second_terminal->marks_obtained_practical;
                                        $third_terminal_mark_obtained_practical = $third_terminal->marks_obtained_practical;
                                        $annual_terminal_mark_obtained_practical = $annual_terminal->marks_obtained_practical;
                                        $theory = $first_terminal_mark_obtained_theory + $second_terminal_mark_obtained_theory + $third_terminal_mark_obtained_theory + $annual_terminal_mark_obtained_theory;
                                        $practical = $first_terminal_mark_obtained_practical + $second_terminal_mark_obtained_practical + $third_terminal_mark_obtained_practical + $annual_terminal_mark_obtained_practical;
                                        $obtained_mark = ($theory/$first_terminal->subject->full_marks * 100) + ($practical/$first_terminal->subject->full_marks * 100);
                                        if($first_terminal->subject->full_marks == 50)
                                        {
                                          $mark_t_p = ($obtained_mark/4) / 100 * 100;
                                        }else{
                                          $mark_t_p = ($obtained_mark/4) / $first_terminal->subject->full_marks * 100;
                                        }
                                        $grade = getGrade($mark_t_p, $grades);
                                        echo $grade['name'];
                                    @endphp
                                @endif
                            </td>
                            <td style="text-align: center">
                                @php
                                    $first_terminal = \App\Models\ExamMark::where('exam_id', 1)->where('subject_id', $mark->subject_id)->where('school_id', $school->id)->where('student_id', $mark->student_id)->first();
                                    $second_terminal = \App\Models\ExamMark::where('exam_id', 2)->where('subject_id', $mark->subject_id)->where('school_id', $school->id)->where('student_id', $mark->student_id)->first();
                                    $third_terminal = \App\Models\ExamMark::where('exam_id', 3)->where('subject_id', $mark->subject_id)->where('school_id', $school->id)->where('student_id', $mark->student_id)->first();
                                    $annual_terminal = \App\Models\ExamMark::where('exam_id', 4)->where('subject_id', $mark->subject_id)->where('school_id', $school->id)->where('student_id', $mark->student_id)->first();
                                @endphp
                                @if($first_terminal->subject->type == 'is_none' || $second_terminal->subject->type == 'is_none' || $third_terminal->subject->type == 'is_none' || $annual_terminal->subject->type == 'is_none')
                                    @php
                                        $first_terminal_mark_obtained = $first_terminal->marks_obtained/100 * 10;
                                        $second_terminal_mark_obtained = $second_terminal->marks_obtained/100 * 10;
                                        $third_terminal_mark_obtained = $third_terminal->marks_obtained/100 * 10;
                                        $annual_terminal_mark_obtained = $annual_terminal->marks_obtained/100 * 70;
                                        $total_mark_obtained = $first_terminal_mark_obtained + $second_terminal_mark_obtained + $third_terminal_mark_obtained + $annual_terminal_mark_obtained;
                                        $grade = getGrade($total_mark_obtained / $first_terminal->subject->full_marks * 100, $grades);
                                        echo $grade['grade_point'];
                                        $total_grade_point += $grade['grade_point'];
                                    @endphp
                                @else
                                    @php
                                        $first_terminal_mark_obtained_theory = $first_terminal->marks_obtained_theory;
                                        $second_terminal_mark_obtained_theory = $second_terminal->marks_obtained_theory;
                                        $third_terminal_mark_obtained_theory = $third_terminal->marks_obtained_theory;
                                        $annual_terminal_mark_obtained_theory = $annual_terminal->marks_obtained_theory;
                                        $first_terminal_mark_obtained_practical = $first_terminal->marks_obtained_practical;
                                        $second_terminal_mark_obtained_practical = $second_terminal->marks_obtained_practical;
                                        $third_terminal_mark_obtained_practical = $third_terminal->marks_obtained_practical;
                                        $annual_terminal_mark_obtained_practical = $annual_terminal->marks_obtained_practical;
                                        $theory = $first_terminal_mark_obtained_theory + $second_terminal_mark_obtained_theory + $third_terminal_mark_obtained_theory + $annual_terminal_mark_obtained_theory;
                                        $practical = $first_terminal_mark_obtained_practical + $second_terminal_mark_obtained_practical + $third_terminal_mark_obtained_practical + $annual_terminal_mark_obtained_practical;
                                        $obtained_mark = ($theory/$first_terminal->subject->full_marks * 100) + ($practical/$first_terminal->subject->full_marks * 100);
                                        if($first_terminal->subject->full_marks == 50)
                                        {
                                          $mark_t_p = ($obtained_mark/4) / 100 * 100;
                                        }else{
                                          $mark_t_p = ($obtained_mark/4) / $first_terminal->subject->full_marks * 100;
                                        }
                                        $grade = getGrade($mark_t_p, $grades);
                                        echo $grade['grade_point'];
                                        $total_grade_point += $grade['grade_point'];
                                    @endphp
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr class="total-right" style="border-top: 1px solid #00000052; line-height: 20px;">
                        <td></td>
                        <td style="text-align: center;"><b> TOTAL:</b>
                        </td>
                        <td style="text-align: center;"><b> {{ array_sum($total_full_marks) }}</b>
                        </td>
                        <td colspan="6" style="text-align: right;"><b> GPA:
                            </b>
                        </td>
                        <td style="text-align: center">{{ round($total_grade_point/count($subjects),2) }}</td>
                        @php
                            $student->exam_results = round($total_grade_point/count($subjects),2);
                            $student->update()
                        @endphp
                    </tr>
                    </tbody>
                </table>
                <table style="text-align: center" width="100%">
                    <tr>
                        <th>Result</th>
                        <th>Attendance</th>
                        <th>Grading System</th>
                    </tr>
                    <tr>
                        <td>
                            <table class="table-three" border="1" style="text-align: center;">
                                <tr>
                                    <th style="padding: 30px">Overall Grade</th>
                                    <th>{{ getGradeFromGradePoint2(round($total_grade_point/count($subjects),2)) }}</th>
                                </tr>
                                <tr>
                                    <th style="padding: 30px">Result</th>
                                    <th>{{ getGradeFromGradePoint1(round($total_grade_point/count($subjects),2)) }}</th>
                                </tr>
                            </table>
                        </td>
                        <td>
                            @php
                                $attendance = \App\Models\ManualAttentace::whereIn('exam_id', $exams->pluck('id')->toArray())->where('class_id', $class->id)->where('year', $school->detail->running_session)->where('student_id', $student->id)->where('section_id', $student->enroll->section->id)->get();
                                $total_days = array();
                                $number_of_days = array();
                                foreach ($attendance as $attend){
                                    array_push($total_days, $attend->total_days);
                                    array_push($number_of_days, $attend->number_of_days);
                                }
                            @endphp
                            <table class="table-three" border="1" style="text-align: center">
                                <tr>
                                    <td style="padding: 10px">School Days</td>
                                    <td>{{ array_sum($total_days) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px">Present Days</td>
                                    <td>{{ array_sum($number_of_days) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px">Absent Days</td>
                                    <td>{{ array_sum($total_days) - array_sum($number_of_days) }}</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table class="table-four">
                                <tr>
                                    <td><b>Percent</b></td>
                                    <td><b>Grade</b></td>
                                    <td><b>Grade Point</b></td>
                                    <td><b>Description</b></td>
                                </tr>
                                @foreach($grades as $row)
                                    <tr>
                                        <td style="text-align: left;"><?php echo $row['mark_form'] ?>% to <?php echo $row['mark_upto'] ?>%</td>
                                        <td><?php echo $row['name'] ?></td>
                                        <td><?php echo $row['grade_point'] ?></td>
                                        <td style="text-align: left;"><?php echo $row['comment'] ?></td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                </table>
                <table class="one-gray">
                    <tr >
                        <td  colspan="3"><b>Remarks:
                                {{ getGradeFromGradePoint1(round($total_grade_point/count($subjects),2)) }} {{  getPromotionFromGradePoint2(round($total_grade_point/count($subjects),2), $class->id) }}.
                            </b>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="content-main">
        </div>
        <!-- content end -->

        <div class="footer">
            <table class="table-five">
                <tr>
                    <td class="padding-btm"><b>Class Teacher</b></td>
                    <td class="padding-btm"><b>Exam Coordinator</b></td>
                    <td class="padding-btm"><b>School Seal<br> Date:{{ $exam->result_date }}</b></td>
                    <td class="padding-btm"><b>Principal</b></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">

    jQuery(document).ready(function($)
    {
        var elem = $('.main-wrapper');
        PrintElem(elem);
        Popup(data);

    });

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'my div', 'height=600,width=800');
        var is_chrome = Boolean(mywindow.chrome);
        mywindow.document.write('<html><head><title></title>');
        mywindow.document.write('</head><body >');
        mywindow.document.write('<style>.main-wrapper{border : 2px solid #FFF;}</style>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        if (is_chrome) {
            setTimeout(function () { // wait until all resources loaded
                mywindow.document.close(); // necessary for IE >= 10
                mywindow.focus(); // necessary for IE >= 10
                mywindow.print();  // change window to winPrint
                mywindow.close();// change window to winPrint
            }, 800);
        }
        else {
            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10

            mywindow.print();
            mywindow.close();
        }

        return true;
    }
</script>
