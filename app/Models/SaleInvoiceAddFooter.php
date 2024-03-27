<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceAddFooter extends Model
{
    public $table = 'sale_invoice_add_footer';
    protected $fillable = [
        'invoice_id', 
        'footer_img',
        'footer_on_last_page',
        'created_by',
     ];

    
}
