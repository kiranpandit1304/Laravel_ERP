<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    public $table = 'module';
    protected $fillable = [
        'slug',
        'name',
     ];

    
}
