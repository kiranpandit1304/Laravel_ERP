<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariationAssign extends Model
{
    public $table = 'product_variation_assign';
    protected $fillable = [
        'variation_id',
        'product_id',
        'created_by',
     ];

    
}
