<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenderBankDetails extends Model
{
    public $table = 'venders_bank_details';
    protected $fillable = [
        'vendor_id',
        'bank_name',
        'ifsc_code',
        'account_no',
        'branch_address',
        'country_id',
        'state_id',
        'upi',
        'payment_terms_days',
        'country_name',
        'state_name',
        'zip_code',
     ];

    
}
