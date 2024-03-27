<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductGroupItems extends Model
{
    public $table = 'product_group_items';
    protected $fillable = [
        "group_id",
        "product_id",
        "variation_id",
        "bundle_quantity",
        "total_cost_price",
        "total_selling_price",
        "created_by",
        "team_id",
     ];

    
}
