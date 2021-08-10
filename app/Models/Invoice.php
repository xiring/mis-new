<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public  function  school()
    {
        return $this->belongsTo('App\Models\School', 'school_id', 'id');
    }

    public  function  student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id', 'id');
    }

    public  function classW()
    {
        return $this->belongsTo('App\Models\ClassW', 'class_id', 'id');
    }

    public function prevInv()
    {
        return $this->belongsTo('App\Models\Invoice', 'previous_invoice_id', 'id');
    }

    public  function invoiceItems()
    {
        return $this->hasMany('App\Models\InvoiceItems', 'invoice_id', 'id');
    }

    public  function invoiceTransport()
    {
        return $this->belongsTo('App\Models\InvoiceTransportItems', 'id', 'invoice_id');
    }
}
