<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenderFiles extends Model
{
    public $table = 'venders_files';
    protected $fillable = [
        'vendor_id',
        'vendor_doc_name',
        'vendor_doc',
     ];

    
}
