<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceAddPayment extends Model
{
    public $table = 'sale_invoice_add_payment';
    protected $fillable = [
        'amount_received',
        'transaction_charge',
        'tds_percentage',
        'tds_amount',
        'tcs_percentage',
        'tcs_amount',
        'amount_to_settle',
        'payment_date', 
        'payment_method',
        'additional_notes',
        'payment_status',
        'created_by', 
     ];

    
}
