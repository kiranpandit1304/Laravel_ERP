<?php

namespace App\Repositories;

use App\Models\User;
use App\Http\Requests;
use File;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper; 


/**
 * Class Profilepository
 */
class ProfileRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'last_name',
        'created_at',
    ];

    /**
     * @var string[]
     */
    protected $allowedFields = [
        'name',
        'last_name',
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
        return User::class;
    }

    public function updateProfile($input)
    {
      try {
                
            $pan_card = substr($input['gst_no'], 2, -3);
            $requestData =  User::find($input['id']);
            $requestData->name  =    (!empty($input['first_name']) ? $input['first_name'] : $requestData['name']);
            $requestData->last_name  =    (!empty($input['last_name']) ? $input['last_name'] : $requestData['last_name']);
            $requestData->email  =    (!empty($input['email']) ? $input['email'] : $requestData['email']);
            $requestData->gst_no  =    (!empty($input['gst_no']) ? $input['gst_no'] : $requestData['gst_no']);
            $requestData->pan_card  =    (!empty($pan_card) ? $pan_card : $requestData['pan_card']);
            $requestData->business_name  =    (!empty($input['business_name']) ? $input['business_name'] : $requestData['business_name']);
            $requestData->brand_name  =    (!empty($input['brand_name']) ? $input['brand_name'] :'');
            $requestData->address  =    (!empty($input['address']) ? $input['address'] : $requestData['address']);
            $requestData->country_id  =    (!empty($input['country_id']) ? $input['country_id'] : $requestData['country_id']);
            $requestData->state_id  =    (!empty($input['state_id']) ? $input['state_id'] : $requestData['state_id']);
            $requestData->avatar  =    (!empty($input['avatar']) ? $input['avatar'] : $requestData['avatar']);
            $requestData->save();


            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
