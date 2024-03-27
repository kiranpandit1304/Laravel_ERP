<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceProvideEinvoiceDetails extends Model
{
    public $table = 'sale_invoice_provide_e_invoice_details';
    protected $fillable = [
        'invoice_id', 
        'gstin',
        'gsp_username',
        'gsp_password',
        'save_credentials_browser_only',
        'save_credentials_across_all',
        'created_by',
     ];

    
}
