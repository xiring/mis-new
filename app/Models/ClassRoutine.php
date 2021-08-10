<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassRoutine extends Model
{
    public  function  class()
    {
        return $this->belongsTo('App\Models\Classw', 'class_id', 'id');
    }

    public  function  subject()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id', 'id');
    }
}
