<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    protected $fillable = [
        'name', 'url', 'created_by','team_id','platform','guard','business_id',
    ];

    protected $hidden = [

    ];
}
