<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolLicense extends Model
{
    public function school()
    {
        return $this->hasOne('App\Models\School', 'id', 'school_id');
    }

    public function license()
    {
        return $this->hasOne('App\Models\License', 'id', 'license_id');
    }
}
