<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Service;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ServiceRepository;
use Mail;
use Response;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper; 


class ServiceApiController extends AppBaseController
{
   
    use ApiResponser;

    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    /*Service list api*/
    public function ServiceList()
    {
        $requestData = $this->serviceRepository->service_list();

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Service retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }
    /*Service show id wise*/
    public function ServiceShow($id)
    {
        $requestData = $this->serviceRepository->service_show($id);
        if(!is_null($requestData->service_image)){
            $profile_image = CommonHelper::getS3FileUrl($requestData->service_image);
            if($profile_image->status == "success"){
                $requestData->service_image = $profile_image->fileUrl;
            }
        }
        
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Service retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }

   /*Service add api*/
    public function ServiceAdd(Request $request)
    {   
        /*add team id*/
        if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
        {
            $team_id = \Auth::user()->parent_id;
        }else{
            $team_id = \Auth::user()->id;
        }
        /*end*/
        $input = $request->all();
        $validatorArray = [
               'name' =>'required',        
               'price' =>'required',        
                            
        ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        $requestData = $this->serviceRepository->service_add($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Service added successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*Service update api*/
    public function ServiceEdit(Request $request)
    {   
       
        $input = $request->all();
        $requestData = $this->serviceRepository->service_edit($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Service updated successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*delete api*/
    public function destroy($service_id)
    {

        $service = Service::find($service_id);
        if (empty($service)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }
        $service->delete();      
        if(!empty($service)){
                return response(['status'=>true,'message'=>'Service Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

   

    
}