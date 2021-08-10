<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItems extends Model
{
    public  function  invoice()
    {
        return $this->belongsTo('App\Models\Invoice', 'invoice_id', 'id');
    }

    public  function  fee()
    {
        return $this->belongsTo('App\Models\Fee', 'fee_category_id', 'id');
    }

    public  function halfFee()
    {
        return $this->belongsTo('App\Models\Fee', 'fee_category_id', 'id')->where('has_half_amount', 1);
    }
}
