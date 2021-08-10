<?php
    if(!function_exists('getGrade')){
        function getGrade($marks_obtained, $grades)
        {
            foreach ($grades as $row) {
                if ($marks_obtained >= $row['mark_form'] && $marks_obtained <= $row['mark_upto'])
                    return $row;
            }
        }
    }

    if(!function_exists('getGradeFromGradePoint')){
        function getGradeFromGradePoint($grade_point, $grades)
        {
            foreach ($grades as $row) {
                if ($grade_point >= $row['grade_point'])
                    return $row;
            }
        }
    }

    if(!function_exists('getGradeFromGradePoint1')){
        function getGradeFromGradePoint1($grade_point)
        {
            if($grade_point > 3.6 && $grade_point <= 4.0){
                echo 'Outstanding';
            }elseif($grade_point > 3.2 && $grade_point <= 3.6){
                echo 'Excellent';
            }elseif($grade_point > 2.8 && $grade_point <= 3.2){
                echo 'Very Good';
            }elseif($grade_point > 2.4 && $grade_point <= 2.8){
                echo 'Good';
            }elseif($grade_point > 2.0 && $grade_point <= 2.4){
                echo 'Satisfactory';
            }elseif($grade_point > 1.6 && $grade_point <= 2.0){
                echo 'Acceptable';
            }elseif($grade_point > 1.2 && $grade_point <= 1.6){
                echo 'Partially Acceptable';
            }else{
                echo 'Insufficient / Very Insufficient';
            }
        }
    }

    if(!function_exists('getGradeFromGradePoint2')){
        function getGradeFromGradePoint2($grade_point)
        {
            if($grade_point > 3.6 && $grade_point <= 4.0){
                echo 'A+';
            }elseif($grade_point > 3.2 && $grade_point <= 3.6){
                echo 'A';
            }elseif($grade_point > 2.8 && $grade_point <= 3.2){
                echo 'B+';
            }elseif($grade_point > 2.4 && $grade_point <= 2.8){
                echo 'B';
            }elseif($grade_point > 2.0 && $grade_point <= 2.4){
                echo 'C+';
            }elseif($grade_point > 1.6 && $grade_point <= 2.0){
                echo 'C';
            }elseif($grade_point > 1.2 && $grade_point <= 1.6){
                echo 'D+';
            }else{
                echo 'E';
            }
        }
    }

    if(!function_exists('getPromotionFromGradePoint2')){
        function getPromotionFromGradePoint2($grade_point, $class_id)
        {
            $class = \App\Models\ClassW::find($class_id);
            if($class_id == 12){
                $upper_class = \App\Models\ClassW::find(14);
            }else{
                $upper_class = \App\Models\ClassW::find($class_id + 1);
            }
            if($grade_point > 3.6 && $grade_point <= 4.0){
                echo 'You are promoted to Class ' . $upper_class->name;
            }elseif($grade_point > 3.2 && $grade_point <= 3.6){
                echo 'You are promoted to Class ' . $upper_class->name;
            }elseif($grade_point > 2.8 && $grade_point <= 3.2){
                echo 'You are promoted to Class ' . $upper_class->name;
            }elseif($grade_point > 2.4 && $grade_point <= 2.8){
                echo 'You are promoted to Class ' . $upper_class->name;
            }elseif($grade_point > 2.0 && $grade_point <= 2.4){
                echo 'You are promoted to Class ' . $upper_class->name;
            }elseif($grade_point > 1.6 && $grade_point <= 2.0){
                echo 'You are promoted to Class ' . $upper_class->name;
            }elseif($grade_point > 1.2 && $grade_point <= 1.6){
                echo 'You are promoted to Class ' . $upper_class->name;
            }else{
                echo 'You are detained';;
            }
        }
    }
?>
