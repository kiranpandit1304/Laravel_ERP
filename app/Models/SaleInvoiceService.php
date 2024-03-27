<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceService extends Model
{
    public $table = 'sale_invoice_service';
    protected $fillable = [
        'platform', 
        'guard',
        'invoice_id',
        'business_id',
        'service_id',
        'service_name',
        'service_sale_price',
        'service_item_discount',
        'service_final_price',
        'created_by',
     ];

    
}
