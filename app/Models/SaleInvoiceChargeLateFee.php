<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceChargeLateFee extends Model
{
    public $table = 'sale_invoice_charge_late_fee';
    protected $fillable = [
        'invoice_id', 
        'enable_late',
        'show_in_invoice',
        'fee_type',
        'fee_amount',
        'days_after_due_date',
        'tax_rate',
        'hsn_code',
        'created_by',
     ];

    
}
