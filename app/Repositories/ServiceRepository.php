<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Service;
use File;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper; 

/**
 * Class Profilepository
 */
class ServiceRepository extends BaseRepository
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
        return Service::class;
    }

    public function service_list()
    {
        $serviceList = Service::where('service.created_by',\Auth::user()->id);
        $serviceList->leftjoin('product_service_units','service.unit_id','product_service_units.id');
        //$serviceList->where('service.platform',\Auth::user()->platform);
        // $serviceList->where('service.guard',\Auth::user()->guard);
        $serviceList->select('service.*','product_service_units.name as unitName');
        $serviceList= $serviceList->get();

        $count =0;
        foreach ($serviceList as $value) {
        if(!is_null($value->service_image)){
                $profile_image = CommonHelper::getS3FileUrl($value->service_image);
                if($profile_image->status == "success"){
                    $value->service_image = $profile_image->fileUrl;
                }
            }
         $serviceList_data[$count] = $value; 
         $count++;
        }

        return $serviceList_data;
    }
    public function service_show($id)
    {
        $serviceList = Service::where('service.id',$id);
        $serviceList->leftjoin('product_service_units','service.unit_id','product_service_units.id');
        //$serviceList->where('service.platform',\Auth::user()->platform);
        //$serviceList->where('service.guard',\Auth::user()->guard);
        $serviceList->select('service.*','product_service_units.name as unitName');
        $serviceList= $serviceList->first();

        return $serviceList;
    }

    public function service_add($input)
    {
        try {
            $requestData = new Service;
            $requestData->name  =    (!empty($input['name']) ? $input['name'] : '');
            $requestData->price  =    (!empty($input['price']) ? $input['price'] : '');
            $requestData->unit_id  =    (!empty($input['unit_id']) ? $input['unit_id'] : '');
            $requestData->text_include  =    (!empty($input['text_include']) ? $input['text_include'] : '0');
            $requestData->sac_code  =    (!empty($input['sac_code']) ? $input['sac_code'] : '');
            $requestData->gst_text  =    (!empty($input['gst_text']) ? $input['gst_text'] : '');
            $requestData->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
            $requestData->guard  =    (!empty($input['guard']) ? $input['guard'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            /*add team id*/
            if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
            {
                $requestData->team_id = \Auth::user()->parent_id;
            }else{
                $requestData->team_id = \Auth::user()->id;
            }
            /*end*/
             if (!empty($input['service_image'])) {
                $errorMessages = array();
            
                $imgResponse = CommonHelper::s3UploadFilesSingel($input['service_image'], 'service_image', SERVICE);
                if($imgResponse->status == "success"){
                     $requestData->service_image = $imgResponse->fileUrl;
                     $requestData->service_image_name = @$input['service_image']->getClientOriginalName();
                }else{
                    $errorMessages[]= $imgResponse->message;
                }
            }
            $requestData->save();

            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
    public function service_edit($input)
    {
        try {
            $requestData =  Service::find($input['id']);
            $requestData->name  =    (!empty($input['name']) ? $input['name'] : '');
            $requestData->price  =    (!empty($input['price']) ? $input['price'] : '');
            $requestData->unit_id  =    (!empty($input['unit_id']) ? $input['unit_id'] : '');
            $requestData->text_include  =    (!empty($input['text_include']) ? $input['text_include'] : '0');
            $requestData->sac_code  =    (!empty($input['sac_code']) ? $input['sac_code'] : '');
            $requestData->gst_text  =    (!empty($input['gst_text']) ? $input['gst_text'] : '');
            $requestData->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
            $requestData->guard  =    (!empty($input['guard']) ? $input['guard'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            /*add team id*/
            if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
            {
                $requestData->team_id = \Auth::user()->parent_id;
            }else{
                $requestData->team_id = \Auth::user()->id;
            }
            /*end*/
             if (!empty($input['service_image'])) {
                $errorMessages = array();
            
                $imgResponse = CommonHelper::s3UploadFilesSingel($input['service_image'], 'service_image', SERVICE);
                if($imgResponse->status == "success"){
                     $requestData->service_image = $imgResponse->fileUrl;
                }else{
                    $errorMessages[]= $imgResponse->message;
                }
            }
            $requestData->service_image_name = @$input['service_image']->getClientOriginalName();
            $requestData->save();
            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
