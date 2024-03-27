<?php

namespace App\Repositories;

use App\Models\BaseUnit;

/**
 * Class ShippingTypeRepository
 */
class BaseUnitRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'short_name',
        'created_at',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BaseUnit::class;
    }


}
