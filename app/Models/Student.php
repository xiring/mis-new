<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public  function  user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public  function  transport()
    {
        return $this->belongsTo('App\Models\Transport', 'transport_id', 'id');
    }

    public  function  enroll()
    {
        return $this->belongsTo('App\Models\Enroll', 'enroll_id', 'id');
    }

    public  function  parent()
    {
        return $this->belongsTo('App\Models\Parents', 'parent_id', 'id');
    }

    public  function  scholarship()
    {
        return $this->belongsTo('App\Models\Scholarship', 'scholarship_id', 'id');
    }
}
