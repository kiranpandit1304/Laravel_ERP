<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceProduct extends Model
{
    public $table = 'sale_invoice_product';
    protected $fillable = [
            'platform',
            'guard',
            'invoice_id',
            'invoice_group_id',
            'tax_type',
            'product_id',
            'variation_id',
            'product_hsn_code',
            'product_gst_rate',
            'product_quantity',
            'product_rate',
            'product_amount',
            'product_discount',
            'product_discount_type',
            'product_igst',
            'product_cgst',
            'product_sgst',
            'product_total',
            'product_name',
            'product_invoice_details',
            'description',
            'product_description',
            'product_row_index',
            'created_by',
     ];

    
}
