<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceGroup extends Model
{
    public $table = 'sale_invoice_group';
    protected $fillable = [
        'invoice_id', 
        'group_name',
        'created_by',
     ];

    
}
