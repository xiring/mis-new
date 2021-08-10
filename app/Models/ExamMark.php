<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamMark extends Model
{
    public  function  school()
    {
        return $this->belongsTo('App\Models\School', 'school_id', 'id');
    }

    public  function  student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id', 'id');
    }

    public  function classW()
    {
        return $this->belongsTo('App\Models\ClassW', 'class_id', 'id');
    }

    public  function section()
    {
        return $this->belongsTo('App\Models\ClassSection', 'section_id', 'id');
    }

    public  function subject()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id', 'id');
    }

    public  function exam()
    {
        return $this->belongsTo('App\Models\Exam', 'exam_id', 'id');
    }

}
