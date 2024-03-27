<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    public $table = 'product_image';
    protected $fillable = [
        'product_id',
        'product_image',
        'product_image_name',
     ];

    
}
