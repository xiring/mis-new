<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ExpenseCategory extends Model
{
    public  function  school()
    {
        return $this->belongsTo('App\Models\School', 'school_id', 'id');
    }

    public  function  invoices()
    {
        return $this->hasMany('App\Models\ExpenseInvoice', 'expense_category_id', 'id')->where('year', Auth::user()->school->detail->running_session);
    }
}
