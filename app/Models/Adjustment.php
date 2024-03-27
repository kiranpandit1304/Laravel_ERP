<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Adjustment
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $date
 * @property string|null $reference_code
 * @property int $warehouse_id
 * @property int $total_products
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 *  * @property-read \App\Models\Warehouse $warehouse
 * @property-read int|null $media_count
 *  * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdjustmentItem[] $adjustmentItems
 *
 * @mixin \Eloquent
 */
class Adjustment extends Model 
{
    use HasFactory;

    protected $table = 'adjustments';

    public const JSON_API_TYPE = 'adjustments';

    protected $fillable = [
        'reference_code',
        'vendor_id',
        'custome_field',
        'adjust_reason',
        'date',
        'warehouse_id',
        'total_products',
    ];

   /* public static $rules = [
        'reference_code' => 'nullable',
        'date'           => 'date|required',
        'warehouse_id'   => 'required|exists:warehouses,id',
    ];*/

    public $casts = [
        'date' => 'date',
    ];

    /**
     * @return array
     */
    function prepareLinks(): array
    {
        return [
            "self" => route('adjustments.show', $this->id),
        ];
    }

    function prepareAttributes(): array
    {
        $fields = [
            'reference_code'   => $this->reference_code,
            'date'             => $this->date,
            'warehouse_id'     => $this->warehouse_id,
            'warehouse_name'   => $this->warehouse->name,
            'total_products'   => $this->total_products,
            'created_at'       => $this->created_at,
            'adjustment_items' => $this->adjustmentItems,
        ];

        return $fields;
    }

    /**
     * @return BelongsTo
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(warehouse::class, 'warehouse_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function adjustmentItems(): HasMany
    {
        return $this->hasMany(AdjustmentItem::class, 'adjustment_id', 'id');
    }
}
