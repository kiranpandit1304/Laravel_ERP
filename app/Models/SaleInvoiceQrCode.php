<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceQrCode extends Model
{
    public $table = 'sale_invoice_qr_code';
    protected $fillable = [
        "invoice_id",
        "upi_id",
        "amount",
        "qr_color",
        "qr_background_color",
        "qr_logo",
        "qr_image",
        "created_by",
     ];

    
}
