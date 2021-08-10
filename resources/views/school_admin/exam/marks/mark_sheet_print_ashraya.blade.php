@php
    $grades = App\Models\ExamGrade::where('school_id', Auth::user()->school->id)->get();
@endphp
@include('school_admin.grade')
<div class="main-wrapper">
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
            width: 140px;
            float: left;
        }
        .logo img{
            height: 80px;
        }
        .box-name{
            width: 300px;
            float: left;
            height: 30px;
            text-align: center;
            margin-left: 78px;
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
          /*  border-bottom: 1px !important;
            border-top: none !important;*/
            font-size: 14px;

        }
        .table-two tbody td{
            border: 1px solid #00000052;
            padding: 3px;
          /*  border-bottom: 1px !important;
            border-top: none !important;*/
            font-size: 14px;
            line-height: 30px;

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
            line-height: 14px;

        }
        table.table-four td{
            border:1px solid  #00000052;
        }
        table.table-left{
            width: 100%;
            text-align: center;
             border:1px solid black;
             border-collapse: collapse;
            font-size: 14px;
             line-height: 12px;
             font-weight: bold;
        }
        table.table-left td{
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
            margin-top: 150px;
            /*border:1px solid  #00000052;
            border-collapse: collapse;*/
            line-height: 15px;
        }
        table.table-five td{
           /* border:1px solid  #00000052;*/
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
            margin-top:50px;
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
            <p style="margin-left:15px;margin-bottom:0px;">"Education Aggrandizes Everyone"</p>
        </div>
        <div class="header-group">
            <div class="logo">
                <img src="http://cmbs.com.np/avs_logo.jpg">
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
                    <td class="right-house">{{-- <b>House:</b>__________ --}}</td>
                </tr>

            </table>
            <table class="table">
                <tr>
                    <td><b>Class: {{ $class->name }}</b></td>
                    <td>{{-- <b>Section: {{ $student->enroll->section->name }}</b> --}}</td>
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
                                <p style="text-align: center;margin: 0px;">Obtained Marks</p>
                                <p style="margin:4px 0px 0px 0px;font-size: 12px; text-align: center;"><b>TH+PR(100%)</b></p>
                            </td>
                            <td>
                                <p style="text-align: center;margin: 0px;">Obtained Grade</p>
                                <p style="margin:4px 0px 0px 0px;font-size: 12px; text-align: center;"><b>TH+PR(100%)</b></p>
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
                        @endphp
                        @foreach($marks as $mark)
                            <tr>
                                @if($mark->subject->mark_optional == 1)
                                    <td>{{ ++$n }}</td>
                                    <td>{{ $mark->subject->name }}</td>
                                    <td>
                                        {{{ ($mark->subject->full_marks == 100) ? '4' : '2'}}}
                                    </td>
                                    <td>
                                        @if($mark->subject->type == 'is_none')
                                            @if($mark->subject->full_marks == 50)
                                                @php
                                                    echo  '<b class=""style="">'.$mark->marks_obtained.'</b>';
                                                @endphp
                                            @else
                                                @php
                                                    
                                                    echo  '<b class=""style="">'.$mark->marks_obtained.'</b>';
                                                @endphp
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if($mark->subject->type == 'is_none')
                                            @php
                                                $marks_obtained = $mark->marks_obtained / $mark->subject->full_marks * 100;
                                                 $grade = getGrade($marks_obtained, $grades);
                                                 echo  '<b class=""style="">'.$grade['name'].'</b>';
                                                 $total_marks += $marks_obtained;
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
                                        @endif
                                    </td>
                                    <td>
                                        @if($mark->subject->type == 'is_none')
                                            @php
                                                $marks_obtained = $mark->marks_obtained / $mark->subject->full_marks * 100;
                                                 $grade = getGrade($marks_obtained, $grades);
                                                 echo $grade['grade_point'];
                                            @endphp
                                        @endif
                                    </td>
                                @endif    
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <table class="one-gray">
                    <tr >
                        <td>Attendance : {{ @$attend->number_of_days }} / {{ @$attend->total_days }} </td>
                        <td>Remarks : <b>{{ getGradeFromGradePoint1(round($total_grade_point/count($primary_subjects),2)) }}</b></td>
                        <td style="text-align: right;">GPA : <b>{{ round($total_grade_point/count($primary_subjects),2) }}</b></td>
                    </tr>
                </table>
                <div style="width: 100%; margin-bottom: 10px;">
                    <div style="float: left;width: 55%; font-size: 12px;">
                        <p><b>Class Teacher's Obeservation</b></p>
                        <p><i>(The highlightes remarks bear the connection to the individual.)</i></p>
                        <p><b>Conduct</b></p>
                        <table class="table-left">
                            <tr>
                                <td>Polite</td>
                                <td>Punctual</td>
                                <td>Co-operative</td>
                                <td>Neat & Tidy</td>
                                <td>Active</td>
                            </tr>
                            <tr>
                                <td>Shy</td>
                                <td>Talkative</td>
                                <td>Careless</td>
                                <td>Untity</td>
                                <td>Passive</td>
                            </tr>
                        </table>
                        <p><b>Studies</b></p>
                        <table class="table-left">
                            <tr>
                                <td>Regular with HW</td>
                                <td>Diligent</td>
                                <td>Interested</td>
                            </tr>
                            <tr>
                                <td>Good Handwriting</td>
                                <td>Quiet in Class</td>
                                <td>Poor Writing</td>
                            </tr>
                            <tr>
                                <td>Disinterested</td>
                                <td>Degrading</td>
                                <td>Careless</td>
                            </tr>
                        </table>
                        @if(count($optional_subjects)>0 && count($optional_marks)>0)
                            <br />
                            <table class="table-left">
                                <tr>
                                    @foreach($optional_marks as $optional_mark)
                                        <td>{{ $optional_mark->subject->name }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($optional_marks as $optional_mark)
                                        <td>{{ $optional_mark->grade_obtained }}</td>
                                    @endforeach
                                </tr>
                            </table>
                        @endif    
                    </div>
                    <div style="float: right; width: 45%">
                        <table class="table-four">
                            <tr>
                                <td colspan="4" style="text-align: left;"><b>Details of Grade Sheet</b></td>
                            </tr>
                            <tr>
                                <td><b>Percent</b></td>
                                <td><b>Grade</b></td>
                                <td><b>Grade Point</b></td>
                                <td><b>Description</b></td>
                            </tr>
                            @foreach($grades as $row)
                                <tr>
                                    <td style="text-align: left;"><?php echo $row['mark_form'] ?> - <?php echo $row['mark_upto'] ?></td>
                                    <td><?php echo $row['name'] ?></td>
                                    <td><?php echo $row['grade_point'] ?></td>
                                    <td style="text-align: left;"><?php echo $row['comment'] ?></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- content end -->
        <div class="footer">
            <table class="table-five">
                <tr style="height: 70px;">
                    <td class="padding-btm" style="border-bottom: 1px solid">&nbsp;</td>
                    <td class="padding-btm" style="border-bottom: 1px solid">&nbsp;</td>
                    <td class="padding-btm" style="border-bottom: 1px solid">&nbsp;</td>
                    <td class="padding-btm" style="border-bottom: 1px solid">&nbsp;</td>
                </tr>
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
            }, 400);
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