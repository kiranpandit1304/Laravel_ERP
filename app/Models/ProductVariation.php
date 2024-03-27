<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    public $table = 'product_variation';
    protected $fillable = [
        'product_id',
        'business_id',
        'variation_name',
        'sku',
        'purchase_price',
        'sale_price',
        'tax_rate',
        'hsn',
        'unit_id',
        'created_by',
        'team_id',
        'platform',
        'guard',
        
     ];


    
}
