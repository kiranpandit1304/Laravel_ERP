<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerFiles extends Model
{
    public $table = 'customer_files';
    protected $fillable = [
        'client_id',
        'customer_doc_name',
        'customer_doc',
     ];

    
}
