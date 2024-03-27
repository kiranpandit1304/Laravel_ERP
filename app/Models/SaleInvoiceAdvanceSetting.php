<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceAdvanceSetting extends Model
{
    public $table = 'sale_invoice_advance_setting';
    protected $fillable = [
        'invoice_id', 
        'number_format',
        'invoice_country',
        'decimal_digit_format',
        'hide_place_of_supply',
        'hsn_column_view',
        'show_hsn_summary',
        'add_original_images',
        'show_description_in_full_width',
        'created_by',
     ];

    
}
