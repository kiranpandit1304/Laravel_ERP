<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceSetting extends Model
{
    public $table = 'sale_invoice_setting';
    protected $fillable = [
        'user_id', 
        'business_id',
        'due_days',
        'signature_url',
        's3_signature_url',
        'signature_name',
        'signature_labed_name',
        'is_bank_detail_show_onInv',
        'is_upi_detail_show_onInv',
        'is_upi_detail_show_onInv',
        'last_active_bank_id',
        'last_active_upi_id',        
        'created_by',
     ];

    
}
