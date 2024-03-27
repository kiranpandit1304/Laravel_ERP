<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceProductImage extends Model
{
    public $table = 'sale_invoice_product_image';
    protected $fillable = [
        'invoice_id',
        'product_id',
        'invoice_product_image',
        'invoice_product_image_name',
        'product_row_index',
        'created_by',
     ];

    
}
