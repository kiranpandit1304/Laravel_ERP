<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceShare extends Model
{
    public $table = 'sale_invoice_share';
    protected $fillable = [
        'invoice_id', 
        'mesg_type', 
        'recipient',
        'mobile_no',
        'created_by',
     ];

    
}
