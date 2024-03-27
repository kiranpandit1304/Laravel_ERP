<?php

namespace App\Http\Controllers\Api;

use App\Models\ProjectUser;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\AssignProject;
use App\Models\Project;
use App\Models\Utility;
use App\Models\Tag;
use App\Models\ProjectTask;
use App\Models\TimeTracker;
use App\Models\TrackPhoto;
use App\Models\Module_has_permissions;
use App\Models\Send_invite;
use App\Models\BusinessAssign;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;



class AuthApiController extends Controller
{
   
    use ApiResponser;

    /*Register api*/
     public function register(Request $request)
    {
        if(empty($request->invitee_id) &&  $request->invitee_id == ''){
            $validatorArray = [
                'mobile_no' => 'required|unique:users',
            ];
        }else{
            $validatorArray = [
                'mobile_no' => 'required',
            ];
        }
        $validator      = \Validator::make(
            $request->all(), $validatorArray
        );
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        if($request->only(['mobile_no']))
        {
           
                $settings              = Utility::settings(auth()->user()->id);
                $settings = [
                    'shot_time'=> isset($settings['interval_time'])?$settings['interval_time']:0.5,
                ];

                $requestData['mobile_no']= $request->mobile_no;
                $requestData['lang']= "en";
                $requestData['is_active']= "1";
                $requestData['platform']= @$request->platform;
                $requestData['guard']= @$request->guard;
                if(!empty($request->invitee_id) &&  $request->invitee_id != ''){                    
                    $invitee_id   = Crypt::decrypt($request->invitee_id);
                    $requestData['invitee_id']  =    (!empty($invitee_id) ? $invitee_id : '');
                }
                if(!empty($request->guard) && $requestData['guard'] != 'APP' && empty($request->invitee_id) &&  $request->invitee_id == '')
                {
                    $this->sendOtp($request->mobile_no);
                }
                if(empty($request->invitee_id) &&  $request->invitee_id == ''){   
                    $user = User::create($requestData);
                }

                if((!empty($request->invitee_id) &&  $request->invitee_id != ''))
                {
                    $invitee_id   = Crypt::decrypt($request->invitee_id);
                    $get_data = \App\Models\Send_invite::where('id',$invitee_id)->get()->toArray();
                    if(!empty($get_data) && count($get_data) > 0)
                    {
                        /*Invitee status update*/
                        if(!empty($request->invitee_id) &&  $request->invitee_id != '')
                        {
                            $check_mobile = User::where('mobile_no',$request->mobile_no)->first();
                            if(empty($check_mobile))
                            {
                                $this->sendOtp($request->mobile_no);
                                $user = User::create($requestData);
                                $invitee_id   = Crypt::decrypt($request->invitee_id);
                                $updateStatus = \App\Models\Send_invite::where('id',$invitee_id)
                                                                ->update(['invitee_status' => 'Accepted']);
                                $get_invitee = \App\Models\Send_invite::where('id',$invitee_id)->first();
                                /*business assign*/
                                $BusinessAssign = new BusinessAssign();
                                /*add team id*/
                                
                                $user_last = User::orderBy('id','DESC')->first();                          
                                $BusinessAssign->team_id = $user_last->id;
                                $BusinessAssign->created_by  =    (!empty($get_invitee->created_by) ?  $get_invitee->created_by : '');
                                $BusinessAssign->business_id   =    (!empty($get_invitee->business_id) ?  $get_invitee->business_id : '');
                                $BusinessAssign->save();
                                /*and business assign*/
                            }else{
                                $get_invitee = \App\Models\Send_invite::where('id',$invitee_id)->first();
                                /*business assign*/
                                $BusinessAssign = new BusinessAssign();
                                /*add team id*/
                                $BusinessAssign->team_id = $check_mobile->id;
                                $BusinessAssign->created_by  =    (!empty($get_invitee->created_by) ?  $get_invitee->created_by : '');
                                $BusinessAssign->business_id   =    (!empty($get_invitee->business_id) ?  $get_invitee->business_id : '');
                                $BusinessAssign->save();
                                /*and business assign*/
                            }
                            return response()->json(['status'=>true,'message'=>"Business assigin successfully..",'mobile_no' => @$request->mobile_no]);
                        }
                    }else{
                        return response()->json(['status'=>false,'message'=>"Link is deleted.."]);
                    }
                }
                // Add business code
                $requestData = new \App\Models\Business;
                $requestData->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
                $requestData->guard  =    (!empty($input['guard']) ? $input['guard'] : '');
                $requestData->bussiness_phone  =    (!empty($request->mobile_no) ? $request->mobile_no : '');
                $requestData->team_id  =    (!empty($user->id) ? $user->id : '');
                $requestData->created_by  =    (!empty($user->id) ? $user->id : '');
                $requestData->business_name  =    (!empty($request->mobile_no) ? $request->mobile_no : '');
                $requestData->save();

                $active_business_id = User::where('id',$user->id)->update(['active_business_id'=>$requestData->id]);
                
                return response(['status'=>true,'message'=>'Register successfully..','token'=>$user->createToken('API Token')->plainTextToken,'id'=> @$user->id,'mobile_no' =>$request->mobile_no,'settings'=>$settings]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*Mobile send otp*/
    public function mobile_send_otp(Request $request)
    {
         $validatorArray = [
            'mobile_no' => 'required',
        ];
        $validator      = \Validator::make(
            $request->all(), $validatorArray
        );
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        $check_mobile = User::where('mobile_no',$request->mobile_no)->first();
        if(empty($check_mobile))
        {
            if($request->only(['mobile_no']))
            {
                    $this->sendOtp($request->mobile_no);
                    return response(['status'=>true,'message'=>'Otp send successfully..']);
            }else{

                return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
            }
        }else{
            return response()->json(['status'=>false,'message'=>"The mobile no has already been taken"]);
        }
    }

    /*update_password api*/
    public function update_password(Request $request)
    {
        $validatorArray = [
             'password' => 'required',
        ];
        $validator      = \Validator::make(
            $request->all(), $validatorArray
        );
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        if($request->only(['password','mobile_no']))
        {
            $password  = Hash::make($request->password);
            $user = User::where('mobile_no',$request->mobile_no)->update(['password'=>$password]);
            $user_data = User::where('mobile_no',$request->mobile_no)->first();
            if(!empty($user_data->invitee_id) && $user_data->invitee_id != '')
            {
                $invite = Send_invite::where('id',$user_data->invitee_id)->first();
                $parent_id_update = User::where('mobile_no',$request->mobile_no)->update(['parent_id'=>$invite->created_by]);
                $module_id = json_decode($invite->module_id);
                $permission_id = json_decode($invite->permission_id);
                for($i = 0; $i < count($module_id); $i++)
                {
                    $req_data                 = new Module_has_permissions();
                    $req_data->module_id = $module_id[$i];
                    $req_data->permission_id = $permission_id[$i];
                    $req_data->user_id = $user_data->id;
                    $req_data->guard_name  = "Model/User";
                    $req_data->save();
                 }
            }

            return response(['status'=>true,'message'=>'Password Added successfully..','user'=>$user_data,'token'=>$user_data->createToken('API Token')->plainTextToken,'user_id' => encrypt(@$user_data->id)]);
        }
        else
        {
            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }

    }
    /*login_via_otp_send api*/
    public function login_via_otp_send(Request $request)
    {
         $validatorArray = [
             'mobile_no' => 'required',
        ];
        $validator      = \Validator::make(
            $request->all(), $validatorArray
        );
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        if($request->only(['mobile_no']))
        {
            $check_mobile = User::where('mobile_no',$request->mobile_no)->first();
            if(!empty($check_mobile))
            {
                $this->sendOtp($request->mobile_no);
                return response(['status'=>true,'message'=>'Otp send successfully..']);             
                
            }
            else
            {
                return response()->json(['status'=>false,'message'=>"Mobile number not found.."]);

            }
        }
        else
        {
            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }

        
    }
    /*sendOtp api*/
    public function sendOtp($mobile_no)
    {
        
        $authKey_env =  env('AUTHKEY');
        $senderId_env =  env('SENDERID');
        $templateId_env =  env('TEMPLATEID');

        $authKey =  (!empty($authKey_env) ? $authKey_env: '390501ASEMuj9OH63e9f096P1');
        $senderId =  (!empty($senderId_env) ? $senderId_env: 'ANCRAT');
        $templateId =  (!empty($templateId_env) ? $templateId_env: '63f6f70ed6fc05261e16d2d3');
     
        $otp = mt_rand(1000, 9999);
        if (isset($mobile_no)){

            $mobileNumber = $mobile_no;
            $message = 'Your OTP for Anchal rathi app is '.$otp.'.Please do not share it.Team:- Anchal Rathi msg91 ';
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://control.msg91.com/api/v5/otp?invisible=1&otp=".$otp."&authkey=".$authKey."&mobile=".$mobileNumber."&template_id=".$templateId,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/json"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
            return;

            /*if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                echo $response;
            }
            exit;*/

        }
    }
    /*login_via_otp*/
    public function login_via_otp(Request $request)
    {
        $validatorArray = [
            'mobile_no' => 'required',
            'otp' => 'required',
        ];
        $validator      = \Validator::make(
            $request->all(), $validatorArray
        );
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        if($request->only(['mobile_no', 'otp']))
        {
            $check_data = $this->login_via_otp_send_msg($request->mobile_no,$request->otp);
            //echo "<pre>"; print_r($check_data->type); exit;
            if(!empty($check_data) && $check_data->type != 'error')
            {
                $user_data = User::where('mobile_no',$request->mobile_no)->first();
                return response(['status'=>true,'message'=>'Login successfully..','token'=>$user_data->createToken('API Token')->plainTextToken,'mobile_no' =>$request->mobile_no,'user_id' => encrypt(@$user_data['id'])]);         
            }else{

                return response()->json(['status'=>false,'message'=>"Invalid OTP, Please try again"]);
            }
         }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*login_via_otp_send*/
    public function login_via_otp_send_msg($mobile_no ,$otp)
    {
        if(!empty($mobile_no) && $otp)
        {
            $authKey_env =  env('AUTHKEY');
            $senderId_env =  env('SENDERID');
            $templateId_env =  env('TEMPLATEID');

            $authKey =  (!empty($authKey_env) ? $authKey_env: '390501ASEMuj9OH63e9f096P1');
            $senderId =  (!empty($senderId_env) ? $senderId_env: 'ANCRAT');
            $templateId =  (!empty($templateId_env) ? $templateId_env: '63f6f70ed6fc05261e16d2d3');

                $mobileNumber = $mobile_no;
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://control.msg91.com/api/v5/otp/verify?otp=".$otp."&authkey=".$authKey."&mobile=".$mobileNumber,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_HTTPHEADER => array(
                        "content-type: application/json"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                $check = json_decode($response);
                return $check;                                     
             }   

    }

    /*verify_otp api*/
    public function verify_otp(Request $request)
    {
        if($request->only(['otp','mobile_no']))
        {
            $authKey_env =  env('AUTHKEY');
            $senderId_env =  env('SENDERID');
            $templateId_env =  env('TEMPLATEID');

            $authKey =  (!empty($authKey_env) ? $authKey_env: '390501ASEMuj9OH63e9f096P1');
            $senderId =  (!empty($senderId_env) ? $senderId_env: 'ANCRAT');
            $templateId =  (!empty($templateId_env) ? $templateId_env: '63f6f70ed6fc05261e16d2d3');

            if (!empty($request->mobile_no)){
                $mobileNumber = $request->mobile_no;
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://control.msg91.com/api/v5/otp/verify?otp=".$request->otp."&authkey=".$authKey."&mobile=".$mobileNumber,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_HTTPHEADER => array(
                        "content-type: application/json"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);

                $check = json_decode($response);
                                            
            }
            if(!empty($check) && $check->type != 'error')
            {
                return response(['status'=>true,'message'=> $check->message,'user'=>$user_data]);
            }else{
                return response()->json(['status'=>false,'message'=>$check->message]);
            }
        }
        else
        {
            return response()->json(['status'=>false,'message'=>"Invalid OTP, Please try again"]);
        }

    }
    /*resend_otp api*/
    public function resend_otp(Request $request)
    {
        if($request->only(['mobile_no']))
        {
        $authKey =  (!empty(env('AUTHKEY') ? env('AUTHKEY') : '390501ASEMuj9OH63e9f096P1' ));
        $senderId =  (!empty(env('SENDERID') ? env('SENDERID') : 'ANCRAT' ));
        $templateId =  (!empty(env('TEMPLATEID') ? env('TEMPLATEID') : '63f6f70ed6fc05261e16d2d3' ));
            if (isset($request->mobile_no)){

                $mobile = explode('+', $request->mobile_no);
                $mobileNumber = $mobile[1];
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://control.msg91.com/api/v5/otp/retry?authkey=".$authKey."&retrytype=&mobile=".$mobileNumber,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_HTTPHEADER => array(
                        "content-type: application/json"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                /*if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    echo $response;
                }*/

            }
            if(!empty($response))
            {
                return response(['status'=>true,'message'=>'Resend Otp successfully..','user'=>$user_data]);
            }else{
                return response()->json(['status'=>false,'message'=>"Invalid OTP"]);
            }
        }
        else
        {
            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }

    }
    /*login api*/
    public function login(Request $request)
    {
        $attr = $request->validate([
            'mobile_no' => 'required|string|',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($attr)) {
            return response()->json(['status'=>false,'message'=>"Credentials not match"]);
        }
        if($request->only(['mobile_no', 'password']))
        {

            $settings              = Utility::settings(auth()->user()->id);
            $settings = [
                'shot_time'=> isset($settings['interval_time'])?$settings['interval_time']:0.5,
            ];
            return response(['status'=>true,'message'=>'Login successfully..','token'=>auth()->user()->createToken('API Token')->plainTextToken,'user' =>auth()->user(),'user_id' => encrypt(auth()->user()->id)]);
         }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
        
    }

    /*reset_password_send_otp api*/
    public function reset_password_send_otp(Request $request)
    {
        if($request->only(['mobile_no']))
        {
            $check_mobile = User::where('mobile_no',$request->mobile_no)->first();
            if(!empty($check_mobile))
            {
                    $authKey_env =  env('AUTHKEY');
                    $senderId_env =  env('SENDERID');
                    $templateId_env =  env('TEMPLATEID');

                    $authKey =  (!empty($authKey_env) ? $authKey_env: '390501ASEMuj9OH63e9f096P1');
                    $senderId =  (!empty($senderId_env) ? $senderId_env: 'ANCRAT');
                    $templateId =  (!empty($templateId_env) ? $templateId_env: '63f6f70ed6fc05261e16d2d3');

                    $otp = mt_rand(1000, 9999);
                    if (isset($request->mobile_no)){

                        $mobileNumber = $request->mobile_no;
                        $message = 'Your OTP for Anchal rathi app is '.$otp.'.Please do not share it.Team:- Anchal Rathi msg91 ';
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => "https://control.msg91.com/api/v5/otp?invisible=1&otp=".$otp."&authkey=".$authKey."&mobile=".$mobileNumber."&template_id=".$templateId,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_SSL_VERIFYHOST => 0,
                            CURLOPT_SSL_VERIFYPEER => 0,
                            CURLOPT_HTTPHEADER => array(
                                "content-type: application/json"
                            ),
                        ));

                        $response = curl_exec($curl);
                        $err = curl_error($curl);
                        curl_close($curl);

                    }
                    if(!empty($response))
                    {
                        return response(['status'=>true,'message'=>'Otp Send successfully..']);
                    }else{
                        return response()->json(['status'=>false,'message'=>"Invalid OTP"]);
                    }
                }
                else
                {
                    return response()->json(['status'=>false,'message'=>"Mobile number not found.."]);
                }
        }
        else
        {

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }

    }

    /*reset_password api*/
    public function reset_password(Request $request)
    {
        if($request->only(['mobile_no','password']))
        {
            $validatorArray = [
                 'mobile_no' => 'required',
                 'password' => 'required',
            ];
            $validator      = \Validator::make(
                $request->all(), $validatorArray
            );
            if($validator->fails())
            {
                return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
            }
            $password  = Hash::make($request->password);
            $user = User::where('mobile_no',$request->mobile_no)->update(['password'=>$password]);
            $user_data = User::where('mobile_no',$request->mobile_no)->first();
            if(!empty($user_data))
            {
                return response(['status'=>true,'message'=>'Password updated successfully..','user'=>$user_data]);
            }else{
                return response()->json(['status'=>false,'message'=>"Something went wrong.."]);
            }

        }else{

            return response()->json(['status'=>false,'Message'=>"Something went wrong.Please try later!"]);
        }
        
    }
    /*logout api*/
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->success([],'Tokens Revoked');
    }

    public function testUserDelete(Request $request)
    {
        $user = User::where('mobile_no',$request->mobile_no)->delete();
        return $this->success([],'Delete data..');
    }

   

}