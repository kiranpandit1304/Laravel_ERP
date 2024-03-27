<?php

namespace App\Models;

use App\Models\Contracts\JsonResourceful;
use App\Traits\HasJsonResourcefulData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdjustmentItem
 *
 * @property int $id
 * @property int $adjustment_id
 * @property int $product_id
 * @property float|null $quantity
 * @property int $method_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AdjustmentItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdjustmentItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdjustmentItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdjustmentItem whereAdjustmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdjustmentItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdjustmentItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdjustmentItem whereMethodType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdjustmentItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdjustmentItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdjustmentItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdjustmentItem extends Model implements JsonResourceful
{
    use HasFactory, HasJsonResourcefulData;

    protected $table = 'adjustment_items';

    public const JSON_API_TYPE = 'adjustment_items';

    const METHOD_ADDITION = 1;
    const METHOD_SUBTRACTION = 2;

    protected $fillable = [
        'group_id',
        'is_group',
        'adjustment_id',
        'product_id',
        'variation_id',
        'stock_alert',
        'method_type',
        'quantity',
        'custome_field',
        'vendor_id',
        'adjust_reason',
        'created_by',
        'team_id',
        'vendor_client_name',
        'user_type',
        'platform',
        'guard',
    ];

    public static $rules = [
        'product_id'  => 'required|exists:products,id',
        'method_type' => 'required',
        'quantity'    => 'nullable|numeric',
    ];

    public $casts = [
        'quantity' => 'double',
    ];

  //  protected $appends = ['sale_unit'];

    /**
     * @return array
     */
    function prepareLinks(): array
    {
        return [

        ];
    }

    /**
     * @return array
     */
    function prepareAttributes(): array
    {
        $fields = [
            'product_id'  => $this->product_id,
            'product'  => $this->ProductService(),
            'method_type' => $this->method_type,
            'quantity'    => $this->quantity,
        ];

        return $fields;
    }

    /**
     * @return BelongsTo
     */
    public function adjustment(): BelongsTo
    {
        return $this->belongsTo(Adjustment::class, 'adjustment_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function ProductService(): BelongsTo
    {
        return $this->belongsTo(ProductService::class, 'product_id', 'id');
    }

    public function getSaleUnitAttribute()
    {
        $saleUnitId = ProductService::whereId($this->product_id)->value('sale_unit');

        $saleUnit = Unit::whereId($saleUnitId)->value('short_name');

        return $saleUnit;
    }


}
