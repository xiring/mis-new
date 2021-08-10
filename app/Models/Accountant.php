<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accountant extends Model
{
    public  function  user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public  function  school()
    {
        return $this->belongsTo('App\Models\School', 'school_id', 'id');
    }
}
