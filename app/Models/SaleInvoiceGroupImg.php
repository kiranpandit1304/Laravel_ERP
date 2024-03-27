<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceGroupImg extends Model
{
    public $table = 'sale_invoice_group_img';
    protected $fillable = [
        'invoice_id', 
        'group_id',
        'invoice_group_image',
        'invoice_group_image_name',
        'created_by',
     ];

    
}
