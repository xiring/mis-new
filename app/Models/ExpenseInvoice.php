<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseInvoice extends Model
{
    public  function  school()
    {
        return $this->belongsTo('App\Models\School', 'school_id', 'id');
    }

    public  function  category()
    {
        return $this->belongsTo('App\Models\ExpenseCategory', 'expense_category_id', 'id');
    }
}
