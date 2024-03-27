<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxChargesHasValues extends Model
{
    protected $fillable = [
        'charges_type_id', 'charges_type_name', 'purchase_sale_id', 'slug', 'tax_rate', 'tax_rate', 'total','module'
    ];
}
