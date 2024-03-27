<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Send_invite extends Model
{
    public $table = 'send_invite';
    protected $fillable = [
        'business_id',
        'name',
        'email',
        'module_id',
        'permission_id',
        'invitee_status',
        'link',
     ];

    
}
