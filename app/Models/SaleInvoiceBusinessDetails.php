<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceBusinessDetails extends Model
{
    public $table = 'sale_invoice_business_details';
    protected $fillable = [
        'invoice_id',
        'business_id',
        'business_name',
        /*'business_country_id',
        'business_state_id',
        'business_country_name',
        'business_state_name',*/
        'business_gst_in',
        'business_pan_no',
        'address_country_id',
        'address_state_id',
        'business_zip_code',
        'street_address',
        'business_email',
        'show_email_invoice',
        'business_phone',
        'show_phone_invoice',
        'current_changes_business',
        'created_by',
     ];

    
}
