<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceTransportItems extends Model
{
    public  function  invoice()
    {
        return $this->belongsTo('App\Models\Invoice', 'invoice_id', 'id');
    }
}
