<?php


namespace App\Helpers;


use Illuminate\Support\Facades\DB;

class GradeHelper
{
    public function getGrade($mark_obtained)
    {
        $query = DB::table('exam_grades')->get();

        foreach ($query as $row)
        {
            if ($mark_obtained >= $row->mark_from && $mark_obtained <= $row->mark_upto)
                return $row;
        }
    }
}