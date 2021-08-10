<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public  function  school()
    {
        return $this->belongsTo('App\Models\School', 'school_id', 'id');
    }

    public  function  class()
    {
        return $this->belongsTo('App\Models\Classw', 'class_id', 'id');
    }

    public  function  teacher()
    {
        return $this->belongsTo('App\Models\Teacher', 'teacher_id', 'id');
    }
}
