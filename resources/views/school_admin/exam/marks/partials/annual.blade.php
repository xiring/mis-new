@if(!is_null($mark))
    @if($mark->subject->type == 'is_none')
        @php
            $grade = getGrade($mark->marks_obtained / $mark->subject->full_marks * 100, $grades);
            echo $grade['name'];
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
        @endphp
    @endif
@else
    0
@endif
