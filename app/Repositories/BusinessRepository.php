<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Business;
use File;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class Profilepository
 */
class BusinessRepository extends BaseRepository
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
        return Business::class;
    }

    public function busines_list()
    {
        $businesList = Business::get();
        $count =0;
        foreach ($businesList as $value) {
            if(!is_null($value->business_logo)){
                    $profile_image = CommonHelper::getS3FileUrl($value->business_logo);
                    if($profile_image->status == "success"){
                        $value->business_logo = $profile_image->fileUrl;
                    }
                }
         $businesList[$count] = $value; 
         $count++;
        }


        return $businesList;
    }
    public function busines_show($id)
    {
        $businesList = Business::where('business.id',$id)
                    ->leftjoin('states','business.state_id','states.id')
                    ->leftjoin('countries','business.country_id','countries.id')
                    ->select('business.*','countries.name as country','states.name as state','states.gst_code')
                    ->first();
        return $businesList;
    }

    public function busines_add($input)
    {
        try {
            $requestData = new Business;
            $requestData->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
            $requestData->guard  =    (!empty($input['guard']) ? $input['guard'] : '');
            $requestData->email  =    (!empty($input['email']) ? $input['email'] : '');
            $requestData->is_gst  =    (!empty($input['is_gst']) ? $input['is_gst'] : '');
            $requestData->gst_no  =    (!empty($input['gst_no']) ? $input['gst_no'] : '');
            $requestData->business_name  =    (!empty($input['business_name']) ? $input['business_name'] : '');
            $requestData->brand_name  =    (!empty($input['brand_name']) ? $input['brand_name'] : '');
            $requestData->street_address  =    (!empty($input['street_address']) ? $input['street_address'] : '');
            $requestData->country_id  =    (!empty($input['country_id']) ? $input['country_id'] : '');
            $requestData->state_id  =    (!empty($input['state_id']) ? $input['state_id'] : '');
            $requestData->pan_no  =    (!empty($input['pan_no']) ? $input['pan_no'] : '');
            $requestData->zip_code  =    (!empty($input['zip_code']) ? $input['zip_code'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            $requestData->bussiness_gstin  = (!empty($input['bussiness_gstin']) ? $input['bussiness_gstin'] : '');
            $requestData->bussiness_phone  = (!empty($input['bussiness_phone']) ? $input['bussiness_phone'] : '');
            if (!empty($input['business_logo'])) {
                $errorMessages = array();            
                $imgResponse = CommonHelper::s3UploadFilesSingel($input['business_logo'], 'business_logo', BUSINESLOGO);
                if($imgResponse->status == "success"){
                     $requestData->business_logo = $imgResponse->fileUrl;
                     $requestData->business_logo_name =  @$input['business_logo']->getClientOriginalName();
                }else{
                    $errorMessages[]= $imgResponse->message;
                }
            }
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
    public function busines_edit($input)
    {
        try {
            /*echo "<pre>";
            print_r($input); exit;*/
            $requestData =  Business::find($input['id']);
            if(!empty($input['email']))
            {
                $requestData->email  =    (!empty($input['email']) ? $input['email'] : '');
            }
            if(@$input['is_gst'] != '')
            {
                $requestData->is_gst  =   @$input['is_gst'];
            }
            if(!empty($input['gst_no']))
            {
                $requestData->gst_no  =    (!empty($input['gst_no']) ? $input['gst_no'] : '');
            }
            if(!empty($input['business_name']))
            {
                $requestData->business_name  =    (!empty($input['business_name']) ? $input['business_name'] : '');
            }
            if(!empty($input['brand_name']))
            {
                $requestData->brand_name  =    (!empty($input['brand_name']) ? $input['brand_name'] : '');
            }
            if(!empty($input['street_address']))
            {
                $requestData->street_address  =    (!empty($input['street_address']) ? $input['street_address'] : '');
            }
            if(!empty($input['country_id']))
            {
                $requestData->country_id  =    (!empty($input['country_id']) ? $input['country_id'] : '');
            }
            if(!empty($input['state_id']))
            {
                $requestData->state_id  =    (!empty($input['state_id']) ? $input['state_id'] : '');
            }
            if(!empty($input['pan_no']))
            {
                $requestData->pan_no  =    (!empty($input['pan_no']) ? $input['pan_no'] : '');
            }
            if(!empty($input['zip_code']))
            {
                $requestData->zip_code  =    (!empty($input['zip_code']) ? $input['zip_code'] : '');
            }
            if(!empty($input['bussiness_gstin']))
            {
                $requestData->bussiness_gstin  = (!empty($input['bussiness_gstin']) ? $input['bussiness_gstin'] : '');
            }
            if(!empty($input['bussiness_phone']))
            {
                $requestData->bussiness_phone  = (!empty($input['bussiness_phone']) ? $input['bussiness_phone'] : '');
            }
            $requestData->created_by  =    \Auth::user()->id;
            if (!empty($input['business_logo'])) {
                $errorMessages = array();            
                $imgResponse = CommonHelper::s3UploadFilesSingel($input['business_logo'], 'business_logo', BUSINESLOGO);
                if($imgResponse->status == "success"){
                     $requestData->business_logo = $imgResponse->fileUrl;
                     $requestData->business_logo_name =  @$input['business_logo']->getClientOriginalName();
                }else{
                    $errorMessages[]= $imgResponse->message;
                }
            }
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
}
