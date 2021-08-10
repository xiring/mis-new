<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    //
    public function admin()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function schoolLicense()
    {
        return $this->belongsTo('App\Models\SchoolLicense','id', 'school_id');
    }

    public function detail()
    {
        return $this->belongsTo('App\Models\SchoolDetail','id', 'school_id');
    }

    public function teacher()
    {
        return $this->hasMany('App\Models\Teacher', 'school_id', 'id');
    }

    public function enroll()
    {
        return $this->hasMany('App\Models\Enroll', 'school_id', 'id');
    }

    public function parent()
    {
        return $this->hasMany('App\Models\Parents', 'school_id', 'id');
    }
}
