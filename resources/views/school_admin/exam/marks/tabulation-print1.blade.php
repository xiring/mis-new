<div class="main-wrapper">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <p style="text-align:center"><strong>Class :</strong> {{ $class->name }}</p>
    <p style="text-align:center"><strong>Section :</strong> {{ $section->name }}</p>
    <p style="text-align:center"><strong>Exam :</strong> {{ $exam->name }}</p>
    <table width="100%" border="1" style="border-collapse: collapse;">
        <thead>
            <tr>
                <td>Name</td>
                @foreach ($class->subjects as $subject)
                    @php
                        $marks = \App\Models\ExamMark::where('school_id', $school->id)->where('year', $school->detail->running_session)->where('class_id', $class->id)->where('section_id', $section->id)->Where('exam_id', $exam->id)->where('subject_id', $subject->id)->pluck('subject_id')->toArray();
                    @endphp
                    @if(in_array($subject->id, $marks))
                        <td>{{ $subject->name }} ({{ $subject->full_marks }})</td>
                    @endif
                @endforeach
                <td>Total</td>
            </tr>
        </thead>
        <tbody>
            @foreach($enrolls as $enroll)
            <tr>
                <td>{{ $enroll->student->user->name }}</td>
                @php $total = array() @endphp
                @foreach($class->subjects as $subject)
                    @php
                        $marks = \App\Models\ExamMark::where('student_id', $enroll->student->id)->where('school_id', $school->id)->where('year', $school->detail->running_session)->where('class_id', $class->id)->where('section_id', $section->id)->Where('exam_id', $exam->id)->where('subject_id', $subject->id)->get();
                    @endphp
                    @foreach($marks as $mark)
                        <td>
                            @if($mark->subject->type == 'is_none')
                                {{ $mark->marks_obtained }}
                                @php array_push($total,$mark->marks_obtained ) @endphp
                            @else
                                {{ $mark->marks_obtained_theory + $mark->marks_obtained_practical }}
                                @php array_push($total,$mark->marks_obtained_theory + $mark->marks_obtained_practicald ) @endphp
                            @endif
                        </td>
                    @endforeach
                @endforeach
                <td>{{ array_sum($total) }}</td>
            </tr>
            @endforeach

        </tbody>
    </table>
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
        mywindow.document.write('<html><head><title></title>');
        mywindow.document.write('</head><body >');
        mywindow.document.write('<style>.main-wrapper{border : 2px solid #FFF;}</style>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }
</script>
