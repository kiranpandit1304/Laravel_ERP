<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxChargesType extends Model
{
    protected $fillable = [
        'name', 'slug'
    ];
}
