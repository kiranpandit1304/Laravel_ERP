<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\ProductBrand;
use File;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class Profilepository
 */
class BrandRepository extends BaseRepository
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
        return ProductBrand::class;
    }

    public function brand_list()
    {
        $brandrList = ProductBrand::where('created_by',\Auth::user()->id)
                    ->where('business_id',\Auth::user()->active_business_id)
                   /* ->where('platform',\Auth::user()->platform)
                    ->where('guard',\Auth::user()->guard)*/
                    ->get();

        return $brandrList;
    }
    public function brand_show($id)
    {
        $brandrList = ProductBrand::where('id',$id)->first();

        return $brandrList;
    }

    public function brand_add($input)
    {
        try {
            $requestData = new ProductBrand;
            $requestData->name  =    (!empty($input['name']) ? $input['name'] : '');
            $requestData->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
            $requestData->guard  =    (!empty($input['guard']) ? $input['guard'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            $requestData->business_id   =    (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');
            /*add team id*/
            if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
            {
                $requestData->team_id = \Auth::user()->parent_id;
            }else{
                $requestData->team_id = \Auth::user()->id;
            }
            /*end*/
            $requestData->save();

            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
    public function brand_edit($input)
    {
        try {
            $requestData =  ProductBrand::find($input['id']);
            $requestData->name  =    (!empty($input['name']) ? $input['name'] : '');
            $requestData->save();
            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
