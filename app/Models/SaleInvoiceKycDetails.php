<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceKycDetails extends Model
{
    public $table = 'sale_invoice_kyc_details';
    protected $fillable = [
        'invoice_id', 
        'document_number',
        'document_type',
        'evidence_type',
        'created_by',
     ];

    
}
