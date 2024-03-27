<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpensePos extends Model
{
    protected $table = 'expenses_pos';
    protected $fillable = [
        'title',
        'date',
        'warehouse_id',
        'expense_category_id',
        'amount',
        'reference_code',
        'payment_status',
        'payment_type',
        'details',
    ];
    public function expenseCategory (){
        return $this->belongsTo('App\Models\ExpenseCategory', 'expense_category_id', 'id');

    }
    public function warehouse (){
        return $this->hasone('App\Models\warehouse', 'id', 'warehouse_id');

    }

}
