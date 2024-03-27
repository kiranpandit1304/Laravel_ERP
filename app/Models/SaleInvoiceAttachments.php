<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceAttachments extends Model
{
    public $table = 'sale_invoice_attachments';
    protected $fillable = [
        'invoice_id',
        'invoice_attachments',
        'invoice_attachments_name',
        //'team_id',
        'created_by',
     ];

    
}
