<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\BaseUnit;
use App\Models\ProductServiceUnit;
use File;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class Profilepository
 */
class UnitRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        
    ];

    /**
     * @var string[]
     */
    protected $allowedFields = [
        'name',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return ProductServiceUnit::class;
    }

    public function unit_list()
    {
        $unitList = ProductServiceUnit::get();

        return $unitList;
    }
    public function unit_show($id)
    {
        $unitList = ProductServiceUnit::where('id',$id)->first();

        return $unitList;
    }

    public function unit_add($input)
    {
        try {
            $requestData = new ProductServiceUnit;
            $requestData->name  =    (!empty($input['name']) ? $input['name'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            $requestData->save();

            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
    public function unit_edit($input)
    {
        try {
            $requestData =  ProductServiceUnit::find($input['id']);
            $requestData->name  =    (!empty($input['name']) ? $input['name'] : '');
            $requestData->save();
            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
