<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    public  function  school()
    {
        return $this->belongsTo('App\Models\School', 'school_id', 'id');
    }

    public function students()
    {
        return $this->hasMany('App\Models\Student', 'scholarship_id', 'id');
    }
}
