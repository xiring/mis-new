<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassW extends Model
{
    protected  $table = 'classes';

    public function sections()
    {
        return $this->hasMany('App\Models\ClassSection', 'class_id', 'id');
    }

    public function enroll()
    {
        return $this->hasMany('App\Models\Enroll', 'class_id', 'id');
    }

    public function subjects()
    {
        return $this->hasMany('App\Models\Subject', 'class_id', 'id')->where('is_active',1 );
    }
}