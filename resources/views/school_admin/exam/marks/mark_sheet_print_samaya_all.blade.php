@php
    $grades = App\Models\ExamGrade::where('school_id', Auth::user()->school->id)->get();
@endphp
@include('school_admin.grade')
<div class="main-wrapper" id="invoice_print1">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <style type="text/css">
        .main-wrapper{
            font-family: Helvetica Neue,Helvetica,Arial,sans-serif;
            width: 595px;
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
    @foreach($student_ids as $student_id)
        <div style="page-break-after: always;">
            @php
                $student = App\Models\Student::where('enroll_id',$student_id)->first();
            @endphp
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
                            <thead style="border-bottom: 1px solid #00000052;font-weight:bold;">
                                <tr>
                                    <td>S.N</td>
                                    <td>Subjects</td>
                                    <td>Credit Hour</td>
                                    <td>
                                        <p style="text-align: center;margin: 0px;">Obtained Grade</p>
                                        <p style="margin:4px 0px 0px 0px;font-size: 12px;"><b>TH</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b style="float:right;">PR</b></p>
                                    </td>
                                    <td>Final Grade</td>
                                    <td>Grade Point</td>
                                </tr>
                            </thead>
                            <tbody style="font-size: 10px;">
                                @php
                                    $total_marks = 0;
                                    $n = 0;
                                    $total_grade_point = 0;
                                    $marks = App\Models\ExamMark::where('school_id', $school->id)->where('year', $school->detail->running_session)->where('class_id', $class->id)->Where('exam_id', $exam->id)->where('student_id', $student->id)->get();
                                @endphp
                                @foreach($marks as $mark)
                                    <tr>
                                        <td>{{ ++$n }}</td>
                                        <td>{{ $mark->subject->name }}</td>
                                        <td>
                                            {{{ ($mark->subject->full_marks == 100) ? '4' : '2'}}}
                                        </td>
                                        <td>
                                            @if($mark->subject->type == 'is_none')
                                                @php
                                                    $marks_obtained = $mark->marks_obtained / $mark->subject->full_marks * 100;
                                                     $grade = getGrade($marks_obtained, $grades);
                                                     echo  '<b class="thery"style="">'.$grade['name'].'</b>';
                                                     echo ' <b style="float:right;">0</b>';
                                                     $total_marks += $marks_obtained;
                                                @endphp
                                            @else
                                                @php
                                                    $theory = $mark->marks_obtained_theory  / $mark->subject->full_marks_theory * 100;
                                                    $grade = getGrade($theory, $grades);
                                                    echo  '<b class="thery"style="">'.$grade['name'].'</b>';
                                                    $practical = $mark->marks_obtained_practical  / $mark->subject->full_marks_practical * 100;
                                                    $grade = getGrade($practical, $grades);
                                                    echo '<b style="float:right;">'.$grade['name'].'</b>';
                                                    $mark_t_p = $mark->marks_obtained_theory + $mark->marks_obtained_practical / $mark->subject->full_marks * 100;
                                                    $total_marks += $mark_t_p;
                                                @endphp
                                            @endif
                                        </td>
                                        <td>
                                            @if($mark->subject->type == 'is_none')
                                                @php
                                                    $marks_obtained = $mark->marks_obtained / $mark->subject->full_marks * 100;
                                                     $grade = getGrade($marks_obtained, $grades);
                                                     echo $grade['name'];
                                                     $total_grade_point += $grade['grade_point'];
                                                @endphp
                                            @else
                                                @php
                                                    $theory = $mark->marks_obtained_theory  / $mark->subject->full_marks * 100;
                                                    $practical = $mark->marks_obtained_practical  / $mark->subject->full_marks * 100;
                                                    if($mark->subject->full_marks == 50)
                                                    {
                                                        $mark_t_p = $theory + $practical / 100 * 100;
                                                    }else{
                                                        $mark_t_p = $theory + $practical / $mark->subject->full_marks * 100;
                                                    }
                                                    $grade = getGrade($mark_t_p, $grades);
                                                    echo $grade['name'];
                                                    $total_grade_point += $grade['grade_point'];
                                                @endphp
                                            @endif
                                        </td>
                                        <td>
                                            @if($mark->subject->type == 'is_none')
                                                @php
                                                    $marks_obtained = $mark->marks_obtained / $mark->subject->full_marks * 100;
                                                     $grade = getGrade($marks_obtained, $grades);
                                                     echo $grade['grade_point'];
                                                @endphp
                                            @else
                                                @php
                                                    $theory = $mark->marks_obtained_theory  / $mark->subject->full_marks * 100;
                                                    $practical = $mark->marks_obtained_practical  / $mark->subject->full_marks * 100;
                                                    if($mark->subject->full_marks == 50)
                                                    {
                                                        $mark_t_p = $theory + $practical / 100 * 100;
                                                    }else{
                                                        $mark_t_p = $theory + $practical / $mark->subject->full_marks * 100;
                                                    }
                                                    $grade = getGrade($mark_t_p, $grades);
                                                    echo $grade['grade_point'];
                                                @endphp
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="total-right" style="border-top: 1px solid #00000052; line-height: 20px;">
                                    <td colspan="3" style="text-align: left;"><b> GRADE:
                                        {{ getGradeFromGradePoint2(round($total_grade_point/count($subjects),2)) }}
                                        </b>
                                    </td>
                                    <td colspan="3" style="text-align: right;"><b> GPA:
                                        {{ round($total_grade_point/count($subjects),2) }}
                                        </b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table-three">
                            <tr>
                                <td colspan="3"><b>Attendence</b></td>
                            </tr>
                            <tr>
                                <td class="padding"><b>School Days</b></td>
                                <td class="padding"><b>Present Days</b></td>
                                <td class="padding"><b>Absent Days</b></td>
                            </tr>
                            <tr>
                                @php
                                    $attend = App\Models\ManualAttentace::where('exam_id', $exam->id)->where('class_id', $class->id)->where('year', $school->detail->running_session)->where('student_id', $student->id)->where('section_id', $student->enroll->section->id)->first();
                                @endphp
                                <td class="padding"><b>{{ @$attend->total_days }}</b></td>
                                <td class="padding"><b>{{ @$attend->number_of_days }}</b></td>
                                <td class="padding"><b>{{ @$attend->total_days - @$attend->number_of_days }}</b></td>
                            </tr>
                        </table>
                        <table class="table-four">
                            <tr>
                                <td colspan="4"><b>Grading System</b></td>
                            </tr>
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
                        <table class="one-gray">
                            <tr >
                                <td  colspan="3"><b>Remarks:
                                    {{ getGradeFromGradePoint1(round($total_grade_point/count($subjects),2)) }}
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
    @endforeach
</div>

<script type="text/javascript">

    jQuery(document).ready(function($)
    {
        var elem = $('#invoice_print1');
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
