<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Business;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repositories\BusinessRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper;
use Mail;
use Response;

class BusinessApiController extends AppBaseController
{
   
    use ApiResponser;

    private $businessRepository;

    public function __construct(BusinessRepository $businessRepository)
    {
        $this->businessRepository = $businessRepository;
    }

    /* Business list api*/
    public function BusinesList()
    {
        $requestData = $this->businessRepository->busines_list();

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Busines retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }
    /*Business show id wise*/
    public function BusinesShow($id='')
    {       
        if(!empty($id) && $id == '0')
        {
            return response()->json(['status'=>false,'message'=>"Please select valid busines!"]);
        } 
        $requestData = $this->businessRepository->busines_show($id);
        if (empty($requestData)) {
            return response()->json(['status'=>false,'message'=>"Data not found!"]);
        }
        if(!is_null($requestData->business_logo)){
            $profile_image = CommonHelper::getS3FileUrl($requestData->business_logo);
            if($profile_image->status == "success"){
                $requestData->business_logo = $profile_image->fileUrl;
            }
        }
        
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Busines retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }

   /*Busines add api*/
    public function BusinesAdd(Request $request)
    {   
       
        $input = $request->all();
        $validatorArray = [
                'email' => 'required',              
                
        ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        $requestData = $this->businessRepository->busines_add($input);       

        $get_last_data = Business::orderBy('id','DESC')->first(); 
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Busines added successfully..','data' => $get_last_data]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*Busines update api*/
    public function BusinesEdit(Request $request)
    {   
       
        $input = $request->all();
        $requestData = $this->businessRepository->busines_edit($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Busines updated successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*delete api*/
    public function destroy($busines_id)
    {

        $busines = Business::find($busines_id);
        if (empty($busines)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }
        /*S3 delete code*/
        if(!empty($busines))
        {
            if(!empty($busines->business_logo) && $busines->business_logo != '')
            {
                $delete_media = explode('/',$busines->business_logo);
                $file = base64_decode($delete_media['2']);
                $media_delete = Storage::disk('s3')->delete($file);
            }
        }
        /*end s3 deletc code*/
        $busines->delete();      
        if(!empty($busines)){
                return response(['status'=>true,'message'=>'Busines Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

 }