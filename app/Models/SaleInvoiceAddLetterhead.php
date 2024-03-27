<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceAddLetterhead extends Model
{
    public $table = 'sale_invoice_add_letterhead';
    protected $fillable = [
        'invoice_id', 
        'letterhead_img',
        'letterhead_on_first_page',
        'created_by',
     ];

    
}
