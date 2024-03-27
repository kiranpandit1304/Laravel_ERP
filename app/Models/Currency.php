<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{

    public $table = 'currency';

    protected $fillable = [
        'name', 
        'type',
        'unit',
        'minimun_rupees',
     ];
}
