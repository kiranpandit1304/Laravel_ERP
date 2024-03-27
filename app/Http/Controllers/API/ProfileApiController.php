<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\State;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ProfileRepository;
use Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper; 


class ProfileApiController extends AppBaseController
{
   
    use ApiResponser;

    private $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }
    /*stateList get api*/
    public function stateList(Request $request, $id ='')
    {
        if(!empty($id) && $id != '')
        {
            $stateList = State::where('country_id',@$id)->get(); 
        }else{
            $stateList = State::get(); 
        }
        if(!empty($stateList)){
                return response(['status'=>true,'message'=>'State get successfully..','data'=>$stateList]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*profileUpdate*/
    public function profileUpdate(Request $request)
    {   
        $input = $request->all();
        $validatorArray = [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
               // 'gst_no' => 'required',
                'business_name' => 'required',
                'address' => 'required',
                'country_id' => 'required',
                'state_id' => 'required',
        ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        /**S3 file upload code */
        $errorMessages = array();
        if($request->hasfile('profile'))
        {     
           $imgResponse = CommonHelper::s3UploadFiles($request, 'profile', PROFILE_IMG);
           if($imgResponse->status == "success"){
                $input['avatar'] = $imgResponse->fileUrl;
           }else{
                $errorMessages[]= $imgResponse->message;
           }
        }
        /*echo "<pre>";
        print_r($input['avatar']); exit;*/
        $requestData = $this->profileRepository->updateProfile($input);       

        if(!empty($requestData)){
                $user_data = User::where('id',$request->id)->first();
                if(!is_null($user_data->avatar)){
                    $profile_image = CommonHelper::getS3FileUrl($user_data->avatar);
                    if($profile_image->status == "success"){
                        $user_data->avatar = $profile_image->fileUrl;
                    }
                }
                return response(['status'=>true,'message'=>'Profile updated successfully..','data'=>$user_data]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    public function getGstDetails(Request $request)
    { 
        // $validatorArray = ['gst_no' => 'required'];
        // $validator      = \Validator::make($request->all(), $validatorArray);
        // if($validator->fails())
        // {
        //     return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        // }
        if(!empty($request->gst_no))
        {
            $curl = curl_init();
            curl_setopt_array($curl, [
              CURLOPT_URL => "https://www.fynamics.co.in/api/gst/search-taxpayer/TP/".$request->gst_no,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Bearer a691040ca275c1395e1d336cd2f9aa7c4411d491df6620f7f55093adbf9ed627d9dc04a6683fea306dc6246d65d10dd09233b377a54753d6acea983a2f53854ba9fff2761cb6c58fb8ee18e1d7fefd9548ee08e9833d8959830ff6e32f4a2f6ddf778ec9bf47c808760dffb4a33f65d3c021dc56125a4ec3"
              ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            $check = json_decode($response);
            
            if(!empty($check) && $check->type != 'error')
            {
                return response(['status'=>true,'message'=> $check->message,'data'=>$check]);
            }else{
                return response()->json(['status'=>false,'message'=>$check->message]);
            }
        }
        else
        {
            return response()->json(['status'=>false,'message'=>"GST number is not registered."]);
        }
    }

    /*teamMemberUserDetail*/
    public function teamMemberUserDetail($user_id)
    {
        $userDetails = \App\Models\User::where('invitee_id',$user_id)->first();

        $permissonData = \App\Models\Module_has_permissions::where('user_id',$userDetails['id'])->get();
        if(!empty($userDetails)){
                return response(['status'=>true,'message'=>'User details get successfully..','data'=>$userDetails,'permisson' => $permissonData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*activeBusinessIdUpdate*/
    public function activeBusinessIdUpdate(Request $request)
    {
        $update_business_id = \App\Models\User::where('id',\Auth::user()->id)
                             ->update(['active_business_id' => $request->business_id]);
        if(!empty($update_business_id)){
                return response(['status'=>true,'message'=>'Business updated successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
}