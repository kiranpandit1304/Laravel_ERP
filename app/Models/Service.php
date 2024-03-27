<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public $table = 'service';
    protected $fillable = [
        'name',
        'price',
        'unit_id',
        'text_include',
        'sac_code',
        'gst_text',
        'service_image',
        'service_image_name',
        'created_by',
        'platform',
        'guard',
        'team_id',
     ];

    
}
