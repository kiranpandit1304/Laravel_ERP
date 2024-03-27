<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceBankUpi extends Model
{
    public $table = 'sale_invoice_bank_upi';
    protected $fillable = [
        'invoice_id', 
        'business_id', 
        'upi_id',
        'show_invoice',
        'is_active',
        'team_id',
        'created_by',
     ];

    
}
