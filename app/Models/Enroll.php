<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enroll extends Model
{
    public function student()
    {
        return $this->belongsTo('App\Models\Student', 'id', 'enroll_id');
    }

    public  function  school()
    {
        return $this->belongsTo('App\Models\School', 'school_id', 'id');
    }

    public  function  class()
    {
        return $this->belongsTo('App\Models\ClassW', 'class_id', 'id');
    }

    public  function  section()
    {
        return $this->belongsTo('App\Models\ClassSection', 'section_id', 'id');
    }
}
