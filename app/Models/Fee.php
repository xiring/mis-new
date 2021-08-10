<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    public  function  school()
    {
        return $this->belongsTo('App\Models\School', 'school_id', 'id');
    }

    public  function  class()
    {
        return $this->belongsTo('App\Models\ClassW', 'class_id', 'id');
    }
}
