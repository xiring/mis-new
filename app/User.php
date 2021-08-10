<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $appends = ['avatar'];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public  function getAvatar(){
        return 'https://gravatar.com/avatar/'.md5($this->email).'/?s=45&d=mm';
    }
    public function getAvatarAttribute(){
        return $this->getAvatar();
    }

    public function school()
    {
        return $this->belongsTo('App\Models\School','id', 'user_id');
    }

    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher','id', 'user_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Parents','id', 'user_id');
    }

    public function student()
    {
        return $this->belongsTo('App\Models\Student','id', 'user_id');
    }

    public function accountant()
    {
        return $this->belongsTo('App\Models\Accountant','id', 'user_id');
    }
}
