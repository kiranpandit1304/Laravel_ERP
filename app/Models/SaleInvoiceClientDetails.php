<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceClientDetails extends Model
{
    public $table = 'sale_invoice_client_details';
    protected $fillable = [
        'invoice_id',
        'client_id',
        'name',
        'client_gst_in',
        'client_pan_no',
        'address_country_id',
        'address_state_id',
        'address_zip_code',
        'street_address',
        'client_email',
        'show_email_invoice',
        'client_phone',
        'show_phone_invoice',
        'current_changes_business',
        'created_by',
     ];

    
}
