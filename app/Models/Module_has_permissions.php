<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module_has_permissions extends Model
{
    public $table = 'module_has_permissions';
    protected $fillable = [
        'module_id',
        'permission_id',
        'user_id',
        'guard_name',
     ];

    
}
