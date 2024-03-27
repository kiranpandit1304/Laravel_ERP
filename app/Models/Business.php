<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    public $table = 'business';
    protected $fillable = [
        'platform',
        'guard',
        'business_logo',
        'business_logo_name',
        'email',
        'is_gst',
        'gst_no',
        'business_name',
        'brand_name',
        'street_address',
        'country_id',
        'state_id',
        'pan_no',
        'bussiness_gstin',
        'bussiness_phone',
        'zip_code',
        'team_id',
        'created_by',
     ];

    
}
