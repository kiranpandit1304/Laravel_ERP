<?php

namespace App\Http\Controllers\Api;

use App\Models\Module;
use App\Models\Module_has_permissions;
use App\Models\Send_invite;
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
use App\Exports\InviteExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Validator;
use Mail;
use Illuminate\Support\Facades\Crypt;

class InviteApiController extends Controller
{
   
    use ApiResponser;

    /*Module get api*/
    public function moduleList(Request $request)
    {
       $moduleList = Module::get(); 
        if(!empty($moduleList)){
                return response(['status'=>true,'message'=>'Module get successfully..','data'=>$moduleList]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*module_has_permissions get api*/
    public function module_has_permissions(Request $request)
    {
        $module_has_permissions = Module_has_permissions::get(); 
        if(!empty($module_has_permissions)){
                return response(['status'=>true,'message'=>'Permission get successfully..','data'=>$module_has_permissions]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*send_invite*/
    public function send_invite(Request $request)
    {

        $validatorArray = [
            'email' => ['required',Rule::unique('send_invite')
                    ->where('business_id',\Auth::user()->active_business_id)],
        ];
        $validator      = \Validator::make(
            $request->all(), $validatorArray
        );
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        if($request->only(['email']))
        {
           
            if(!empty($request->permission_id) && count($request->permission_id) > 0 && !empty($request->email))
            {
            $invitee = explode(',', $request->email);
              for($i = 0; $i < count($invitee); $i++)
                {
                    $sendInvite                 = new Send_invite();
                    $sendInvite->name  =    (!empty($request->name) ? $request->name : '');
                    $sendInvite->email          = (!empty($invitee[$i]) ? @$invitee[$i] : '');
                    $sendInvite->module_id      = (!empty($request->module_id) ? json_encode($request->module_id) : '');
                    $sendInvite->permission_id  = (!empty($request->permission_id) ?json_encode($request->permission_id) : '');
                    $sendInvite->created_by  =    (!empty(Auth::user()->id) ? Auth::user()->id : '');
                    $sendInvite->business_id   =    (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');
                    $sendInvite->save();

                    $invitee_url_env =  env('INVITEEURL');
                    $invitee_url =  (!empty($invitee_url_env) ? $invitee_url_env: 'http://127.0.0.1:8000/en/signup/');
                    //$user['link'] = '<a href="'.$invitee_url.$sendInvite->id.'">Click Here</a>';
                    $user['link'] = $invitee_url.encrypt($sendInvite->id);
                    $sendInviteupdate['link']  =    (!empty($user['link']) ? $user['link'] : '');

                    /*Link Update*/
                    Send_invite::where('id',$sendInvite->id)->update($sendInviteupdate);

                    $user['email'] = $invitee[$i];
                    $this->send_invite_mail($user);
            }

                return response(['status'=>true,'message'=>'Invite Sent successfully..','link' => @$user['link']]);
                
            }else{
                return response()->json(['status'=>false,'message'=>"Please select at least one module permission."]);
            }
        }else{
            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*send_invite_mail*/
    public function send_invite_mail($user)
    {
        $authKey_env =  env('AUTHKEY');
        $templateId_env =  env('EMAILTEMPLATENAME');

        $authKey =  (!empty($authKey_env) ? $authKey_env: '390501ASEMuj9OH63e9f096P1');
        $template_name =  (!empty($template_name) ? $templateId_env: 'unesync_email_decimalpoint');

        $fields =  '{   
                "to": [{"name": "Amit","email": "'.$user['email'].'"}],
                "from": {"name": "Joe","email": "support@mail.unesync.com"},
                "domain": "mail.unesync.com",
                "mail_type_id": "3",   
                "template_id":"'.$template_name.'",   
                "variables": { "URL": "'.$user['link'].'"}
                 }';  

        $curl = curl_init();
        curl_setopt_array($curl, [
          CURLOPT_URL => "http://control.msg91.com/api/v5/email/send",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $fields,
          CURLOPT_HTTPHEADER => [
            "accept: application/json",
            "content-type: application/json",
            "authkey:".$authKey
          ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        /*if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          echo $response;
        }
        exit;*/
        return;
    }

    public function get_user_modules($id)
    {
        $module_has_permissions = Module_has_permissions::where('module_has_permissions.user_id',$id);
        $module_has_permissions->leftjoin('module','module_has_permissions.module_id','module.id');
        $module_has_permissions->select('module_has_permissions.*','module.name as moduleName','module.slug');
        $module_has_permissions =$module_has_permissions->get(); 

        if(!empty($module_has_permissions)){
                return response(['status'=>true,'message'=>'User modules get successfully..','data'=>$module_has_permissions]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*inviteeUsersList*/
    public function inviteeUsersList($id)
    {
        $inviteeList = \App\Models\User::where('parent_id',$id)->get();
        if(!empty($inviteeList)){
                return response(['status'=>true,'message'=>'Invitee user get successfully..','data'=>$inviteeList]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*UserPermissonList*/
    public function UserPermissonList($id)
    {
        $module_has_permissions = \App\Models\Module_has_permissions::where('module_has_permissions.user_id',$id);
        $module_has_permissions->leftjoin('module','module_has_permissions.module_id','module.id');
        $module_has_permissions->select('module_has_permissions.*','module.name as moduleName');
        $module_has_permissions =$module_has_permissions->get();
        if(!empty($module_has_permissions)){
                return response(['status'=>true,'message'=>'User permisson get successfully..','data'=>$module_has_permissions]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*UserPermissonEdit*/
    public function UserPermissonEdit(Request $request)
    {
        $input = $request->all();
        if(!empty($input['user_id']))
        {
            $permission = $input['permission_id'];
            $permissionDelete = Module_has_permissions::where('user_id',$input['user_id'])->delete();
            for($i = 0; $i < count($permission); $i++)
            {
                    $updatePermisson            = new Module_has_permissions();
                    $updatePermisson->module_id      = (!empty($input['module_id'][$i]) ? $input['module_id'][$i] : '');
                    $updatePermisson->permission_id      = (!empty($input['permission_id'][$i]) ? $input['permission_id'][$i] : '');
                    $updatePermisson->user_id      = (!empty($input['user_id']) ? $input['user_id'] : '');
                    $updatePermisson->guard_name      = 'Model/User';
                    $updatePermisson->save();
            }
        }
        if(!empty($updatePermisson)){
                return response(['status'=>true,'message'=>'User permisson updated successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }

    }

    public function sendInviteList()
    {
        $inviteeList = Send_invite::where('created_by',\Auth::user()->id);
        $inviteeList->where('business_id',\Auth::user()->active_business_id);
        $inviteeList =  $inviteeList->get();

        if(!empty($inviteeList)){
                return response(['status'=>true,'message'=>'Invitee get successfully..','data' => $inviteeList]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    public function sendInviteShow($id)
    {
        $inviteeList = Send_invite::where('id',$id)->first();

        if(!empty($inviteeList)){
                return response(['status'=>true,'message'=>'Invitee get successfully..','data' => $inviteeList]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*sendInviteDelete*/
    public function destroy($id)
    {
        $inviteeList = Send_invite::find($id);
        if (empty($inviteeList)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }     
        $inviteeList->delete();

        if(!empty($inviteeList)){
                return response(['status'=>true,'message'=>'Invitee deleted successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*sendInviteMuilipleDelete*/
    public function sendInviteMuilipleDelete(Request $request)
    {
        $inviteeList = Send_invite::whereIn('id',$request->id)->delete();
        if (empty($inviteeList)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }     
        if(!empty($inviteeList)){
                return response(['status'=>true,'message'=>'Invitee deleted successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*sendInviteExport*/
    public function sendInviteExport(Request $request ,$id = '')
    {
        $request['user_id']   = Crypt::decrypt($id);
        $name = 'invite_' . date('Y-m-d i:h:s');
        $request = $request->all();
        $getBusinessId = \App\Models\User::where('id',$request['user_id'])->first();
        $request['business_id'] = $getBusinessId['active_business_id'];
        if(!empty($request) && $request['id'] != '')
        {
            $data = Excel::download(new InviteExport($request), $name . '.xlsx'); ob_end_clean();
        }else{

            $data = Excel::download(new InviteExport($request), $name . '.xlsx'); ob_end_clean();

        }

        return $data;
    }
}