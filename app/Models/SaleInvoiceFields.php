<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceFields extends Model
{
    public $table = 'sale_invoice_fields';
    protected $fillable = [
        'invoice_id', 
        'filed_data',
        'created_by',
     ];

    
}
