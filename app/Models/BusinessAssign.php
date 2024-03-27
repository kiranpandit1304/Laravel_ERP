<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessAssign extends Model
{
    public $table = 'business_assign';
    protected $fillable = [
        'business_id',
        'team_id',
        'created_by',
     ];

    
}
