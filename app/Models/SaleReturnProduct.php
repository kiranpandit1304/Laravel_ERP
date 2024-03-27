<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleReturnProduct extends Model
{
    protected $fillable = [
        'product_id',
        'sale_id',
        'quantity',
        'tax',
        'discount',
        'total',
    ];

    public function product()
    {
        return $this->hasOne('App\Models\ProductService', 'id', 'product_id')->first();
    }
}
