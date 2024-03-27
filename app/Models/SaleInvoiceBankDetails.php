<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceBankDetails extends Model
{
    public $table = 'sale_invoice_bank_details';
    protected $fillable = [
        'invoice_id', 
        'business_id',
        'ifsc',
        'account_no',
        'bank_name',
        'country_id',
        'iban',
        'swift_code',
        'currency',
        'account_type',
        'account_holder_name',
        'mobile_no',
        'custom_bank_details',
        'upi_id',
        'is_show',
        'team_id',
        'created_by',
     ];

    
}
