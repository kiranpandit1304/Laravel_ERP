<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = [
        'name', 'created_by', 'description','team_id',
    ];


    protected $hidden = [

    ];
}
