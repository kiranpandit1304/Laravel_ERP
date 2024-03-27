<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\ProductServiceCategory;
use File;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class Profilepository
 */
class CategoryRepository extends BaseRepository
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
        return ProductServiceCategory::class;
    }

    public function category_list()
    {
        $categoryList = ProductServiceCategory::where('created_by', \Auth::user()->id)
            ->where('business_id',\Auth::user()->active_business_id)
            //->where('platform', \Auth::user()->platform)
            //->where('guard', \Auth::user()->guard)
            ->get();

        $auth_user = \Auth::user();
        $team_id=  $auth_user->parent_id;
        if ($auth_user->parent_id == 0) {
            $team_id = $auth_user->id;
            $has_edit_permission = true;
        }

        $categoryList = ProductServiceCategory::with('subcategories')->where('parent_id', '0')
        ->where('business_id',\Auth::user()->active_business_id)
        ->where("product_service_categories.team_id", $team_id)->orderBy('product_service_categories.id', 'DESC')->get();


        return $categoryList;
    }
    public function category_show($id)
    {
        $categoryList = ProductServiceCategory::where('id', $id)->first();

        return $categoryList;
    }

    public function category_add($input)
    {
        try {
            $requestData = new ProductServiceCategory;
            $requestData->name  =    (!empty($input['name']) ? $input['name'] : '');
            $requestData->parent_id  =    (!empty($input['parent_id']) ? $input['parent_id'] : 0);
            $requestData->type  =    (!empty($input['type']) ? $input['type'] : '');
            $requestData->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
            $requestData->guard  =    (!empty($input['guard']) ? $input['guard'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            $requestData->business_id   =    (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');
            /*add team id*/
            if (!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0) {
                $requestData->team_id = \Auth::user()->parent_id;
            } else {
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
    public function category_edit($input)
    {
        try {
            $requestData =  ProductServiceCategory::find($input['id']);
            $requestData->name  =    (!empty($input['name']) ? $input['name'] : '');
            if (!empty($input['parent_id'])) {
                $requestData->parent_id  =  (!empty($input['parent_id']) ? $input['parent_id'] : '');
            }
            $requestData->type  =  (!empty($input['type']) ? $input['type'] : '');
            $requestData->save();
            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
