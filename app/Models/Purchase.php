<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'vender_id',
        'warehouse_id',
        'purchase_date',
        'purchase_number',
        'discount_apply',
        'discount',
        'description',
        'status',
        'category_id',
        'created_by',
    ];
    public static $statues = [
        'Draft',
        'Sent',
        'Unpaid',
        'Partialy Paid',
        'Paid',
    ];
    public function vender()
    {
        return $this->hasOne('App\Models\Vender', 'id', 'vender_id');
    }

    public function tax()
    {
        return $this->hasOne('App\Models\Tax', 'id', 'tax_id');
    }

    public function items()
    {
        return $this->hasMany('App\Models\PurchaseProduct', 'purchase_id', 'id');
    }
    public function taxCharges()
    {
        return $this->hasMany('App\Models\TaxChargesHasValues', 'purchase_sale_id', 'id')->where(
            'module',
            'purchase'
        );
    }
    public function payments()
    {
        return $this->hasMany('App\Models\PurchasePayment', 'purchase_id', 'id');
    }
    public function category()
    {
        return $this->hasOne('App\Models\ProductServiceCategory', 'id', 'category_id');
    }
    public function warehouse()
    {
        return $this->hasOne('App\Models\warehouse', 'id', 'warehouse_id');
    }
    public function stock()
    {
        return $this->hasMany('App\Models\WarehouseProduct', 'warehouse_id', 'warehouse_id');
    }

    public function getTotalstock()
    {
        $totalStock = 0;
        foreach ($this->stock as $stock) {
            //$taxes = App\Models\WarehouseProduct($stock->warehouse_id);

            $totalStock += ($stock->quantity);
        }

        return $totalStock;
    }
    public function StatusType()
    {
        return $this->hasOne('App\Models\StatusType', 'id', 'status');
    }
    public function getSubTotal()
    {
        $subTotal = 0;
        foreach ($this->items as $product) {
            $subTotal += ($product->price * $product->quantity);
        }

        return $subTotal;
    }
    public function getTotal()
    {
        return ($this->getSubTotal() + $this->getTotalTax()) - $this->getTotalDiscount();
    }
    public function getTotalTax()
    {
        $totalTax = 0;
        $ship_rate = 0;
        $tax_in_pertage = 0;
        foreach ($this->taxCharges as $item) {
            if ($item->module == 'purchase') {

                if ($item->slug == 'shipping'){
                    $ship_rate  = (!empty($item->tax_rate) ? $item->tax_rate : 0);
                }
                $sub_total = $this->getSubTotal();
                if ($item->slug == 'tax') {
                    $tax_rate = (!empty($item->tax_rate) ? $item->tax_rate : 0);
                    $tax_in_pertage = ($sub_total / 100) * $tax_rate;
                }
            }
        }
        $totalTax += $ship_rate + $tax_in_pertage;

        return $totalTax;
    }

    public function getTotalTax_old()
    {
        $totalTax = 0;
        foreach ($this->items as $product) {
            $taxes = Utility::totalTaxRate($product->tax);

            $totalTax += ($taxes / 100) * ($product->price * $product->quantity);
        }

        return $totalTax;
    }
    public function getTotalDiscount()
    {
        $totalDiscount = ($this->getSubTotal() / 100) *  $this->discount;

        return $totalDiscount;
    }
    public function getDue()
    {
        $due = 0;
        foreach ($this->payments as $payment) {
            $due += $payment->amount;
        }

        return ($this->getTotal() - $due);
    }
    public function lastPayments()
    {
        return $this->hasOne('App\Models\PurchasePayment', 'id', 'purchase_id');
    }

    public function taxes()
    {
        return $this->hasOne('App\Models\Tax', 'id', 'tax');
    }
}
