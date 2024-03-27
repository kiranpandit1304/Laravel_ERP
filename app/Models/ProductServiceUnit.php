<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductServiceUnit extends Model
{
    protected $fillable = [
        'name',
        'short_name',
        'base_unit_id',
        'created_by',
    ];
    
}
