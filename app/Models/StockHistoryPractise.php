<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockHistoryPractise extends Model
{
    public $table = 'stock_history_practise';
    protected $fillable = [
        'vendor_id',
        'vendor_client_name',
        'product_id',
        'variation_id',
        'variation_name',
        'stock',
        'method_type',
        'created_by',
        'custome_field',
        'adjust_reason',
        'stock_date',
        'user_type',
        'platform',
        'guard',
     ];

    
}