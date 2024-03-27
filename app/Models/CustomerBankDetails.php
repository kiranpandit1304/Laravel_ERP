<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerBankDetails extends Model
{
    public $table = 'customer_bank_details';
    protected $fillable = [
        'client_id',
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
