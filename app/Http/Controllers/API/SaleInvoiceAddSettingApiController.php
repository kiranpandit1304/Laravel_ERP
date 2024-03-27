<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\SaleInvoiceSetting;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repositories\SaleInvoiceSettingRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper;
use Mail;
use Response;

class SaleInvoiceAddSettingApiController extends AppBaseController
{
   
    use ApiResponser;

    private $saleInvoiceSettingRepository;

    public function __construct(SaleInvoiceSettingRepository $saleInvoiceSettingRepository)
    {
        $this->saleInvoiceSettingRepository = $saleInvoiceSettingRepository;
    }

    /*saleInvoiceSettingRepository show id wise*/
    public function SaleInvoiceAddSettingShow($id='')
    {        
        $requestData = $this->saleInvoiceSettingRepository->sale_invoice_setting_show($id);
        if (empty($requestData)) {
            return response()->json(['status'=>false,'message'=>"Data not found!"]);
        }
        if(!is_null($requestData->signature_url)){
            $profile_image = CommonHelper::getS3FileUrl($requestData->signature_url);
            if($profile_image->status == "success"){
                $requestData->signature_url = $profile_image->fileUrl;
            }
        }
        
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Signature_url retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }

   /*signature add api*/
    public function SaleInvoiceAddSetting(Request $request)
    {   
        $input = $request->all();
        $validatorArray = [
                'signature_url' => 'required',              
                
        ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
    
        $SaleInvoiceSetting = SaleInvoiceSetting::where('created_by',\Auth::user()->id);
        $SaleInvoiceSetting->where('business_id',\Auth::user()->active_business_id);
        $SaleInvoiceSetting = $SaleInvoiceSetting->delete();
        $SaleInvoiceSetting = SaleInvoiceSetting::where('created_by',\Auth::user()->id);
            $SaleInvoiceSetting->where('business_id',\Auth::user()->active_business_id);
            $SaleInvoiceSetting = $SaleInvoiceSetting->delete();
            /**/
            $requestData = new SaleInvoiceSetting;

            $requestData->user_id  =    \Auth::user()->id;
            $requestData->business_id  =    \Auth::user()->active_business_id;            
            $requestData->created_by  =    \Auth::user()->id;
            $requestData->signature_labed_name  =    (!empty($input['signature_labed_name']) ? $input['signature_labed_name'] : '');;
            if (!empty($input['signature_url']) && $input['signature_url'] != 'undefined') 
            {
                $errorMessages = array();            
                $imgResponse = CommonHelper::s3UploadFilesSingel($input['signature_url'], 'signature_url', SIGNATURE);
                if($imgResponse->status == "success"){
                     $requestData->s3_signature_url = $imgResponse->fileUrl;
                     //$requestData->signature_name = @$input['signature_url']->getClientOriginalName();
                }else{
                    $errorMessages[]= $imgResponse->message;
                }
            }
             if($request->hasfile('signature_url'))
            {
                $image = $request->file('signature_url');
                $extension = $image->getClientOriginalExtension(); // getting image extension
                $filename ='signature/'. time().'.'.$base64 = base64_encode($image->getClientOriginalName());
                $path = public_path('/signature/');
                $image->move($path, $filename);
                $requestData->signature_url = $filename;
            }
            else
            {
                $requestData->signature_url = '';
            } 
            $requestData->save();

        
        //$requestData = $this->saleInvoiceSettingRepository->sale_invoice_add_setting($input);       
        $SaleInvoiceSetting = SaleInvoiceSetting::where('created_by',\Auth::user()->id);
        $SaleInvoiceSetting->where('business_id',\Auth::user()->active_business_id);
        $SaleInvoiceSetting = $SaleInvoiceSetting->first();
        $SaleInvoiceSetting->signature_url = env('APP_URL').$SaleInvoiceSetting->signature_url;
        //$authKey_env =  env('AUTHKEY')
        if(!is_null($SaleInvoiceSetting->s3_signature_url)){
            $profile_image = CommonHelper::getS3FileUrl($SaleInvoiceSetting->s3_signature_url);
            if($profile_image->status == "success"){
                $SaleInvoiceSetting->s3_signature_url = $profile_image->fileUrl;
            }
        }
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Signature_url added successfully..','data' => $SaleInvoiceSetting]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

     /*signature reset api*/
    public function SaleInvoiceResetSetting()
    {   
        $SaleInvoiceSetting = \App\Models\SaleInvoiceSetting::where('created_by',\Auth::user()->id);
        $SaleInvoiceSetting->where('business_id',\Auth::user()->active_business_id);
        $SaleInvoiceSetting = $SaleInvoiceSetting->first();
       if(!empty($SaleInvoiceSetting))
        {
            if(!empty($SaleInvoiceSetting->s3_signature_url) && $SaleInvoiceSetting->s3_signature_url != '')
            {
                $delete_media = explode('/',$SaleInvoiceSetting->s3_signature_url);
                $file = base64_decode($delete_media['2']);
                $media_delete = Storage::disk('s3')->delete($file);
            }
        }
        $SaleInvoiceSettingUpdate = SaleInvoiceSetting::where('created_by',\Auth::user()->id)->where('business_id',\Auth::user()->active_business_id)->update(['signature_url' => '','s3_signature_url' => '']);

        $SaleInvoiceSettingGet = SaleInvoiceSetting::where('created_by',\Auth::user()->id);
        $SaleInvoiceSettingGet->where('business_id',\Auth::user()->active_business_id);
        $SaleInvoiceSettingGet = $SaleInvoiceSettingGet->first();

        if(!empty($SaleInvoiceSettingGet)){
                return response(['status'=>true,'message'=>'Signature url added successfully..','data' => $SaleInvoiceSettingGet]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    //SaleInvoiceSetDueDate
    public function SaleInvoiceSetDueDate(Request $request)
    {   
        $SaleInvoiceSettingUpdate = SaleInvoiceSetting::where('created_by',\Auth::user()->id)->where('business_id',\Auth::user()->active_business_id)->update(['due_days' => $request->due_days]);

        $SaleInvoiceSettingGet = SaleInvoiceSetting::where('created_by',\Auth::user()->id);
        $SaleInvoiceSettingGet->where('business_id',\Auth::user()->active_business_id);
        $SaleInvoiceSettingGet = $SaleInvoiceSettingGet->first();

        if(!empty($SaleInvoiceSettingGet)){
                return response(['status'=>true,'message'=>'Due days added successfully..','data' => $SaleInvoiceSettingGet]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    
    public function SaleInvoiceBankAndUpiStatus(Request $request)
    {   
        $SaleInvoiceSettingGet = SaleInvoiceSetting::where('created_by',\Auth::user()->id);
        $SaleInvoiceSettingGet->where('business_id',\Auth::user()->active_business_id);
        $SaleInvoiceSettingGet = $SaleInvoiceSettingGet->first();

        if(!empty($SaleInvoiceSettingGet))
        {
            if($request->is_bank_detail_show_onInv !='')
            {
                $updateBankStaus = SaleInvoiceSetting::where('created_by',\Auth::user()->id)->where('business_id',\Auth::user()->active_business_id)
                ->update(['is_bank_detail_show_onInv' => $request->is_bank_detail_show_onInv,'last_active_bank_id' => @$request->last_active_bank_id]);
                $SaleInvoiceBankDetails = \App\Models\SaleInvoiceBankDetails::where('id',@$request->last_active_bank_id)->update(['is_show' => $request->is_bank_detail_show_onInv]);
            }else if($request->is_bank_detail_show_onInv == 0){
                $SaleInvoiceBankDetails = \App\Models\SaleInvoiceBankDetails::where('invoice_id',@$request->invoice_id)->update(['is_show' => $request->is_bank_detail_show_onInv]);
            }

            if($request->is_upi_detail_show_onInv !='')
            {
                $updateUpiStaus = SaleInvoiceSetting::where('created_by',\Auth::user()->id)->where('business_id',\Auth::user()->active_business_id)
                ->update(['is_upi_detail_show_onInv' => $request->is_upi_detail_show_onInv,'last_active_upi_id' => @$request->last_active_upi_id]);
                $SaleInvoiceBankUpi = \App\Models\SaleInvoiceBankUpi::where('id',@$request->last_active_upi_id)->update(['is_active' => $request->is_upi_detail_show_onInv]);
            }else if($request->is_upi_detail_show_onInv == 0){
                $SaleInvoiceBankUpi = \App\Models\SaleInvoiceBankUpi::where('id',@$request->invoice_id)->update(['is_active' => $request->is_upi_detail_show_onInv]);
            }
            
        }else{
            $requestData = new SaleInvoiceSetting;

            $requestData->user_id  =    \Auth::user()->id;
            $requestData->business_id  =    \Auth::user()->active_business_id;            
            $requestData->created_by  =    \Auth::user()->id;
            $requestData->is_bank_detail_show_onInv  =   (!empty($request->is_bank_detail_show_onInv) ? $request->is_bank_detail_show_onInv : '');
            $requestData->is_upi_detail_show_onInv  =   (!empty($request->is_upi_detail_show_onInv) ? $request->is_upi_detail_show_onInv : '');
            $requestData->save();
        }
        $SaleInvoiceSettingGet = SaleInvoiceSetting::where('created_by',\Auth::user()->id);
        $SaleInvoiceSettingGet->where('business_id',\Auth::user()->active_business_id);
        $SaleInvoiceSettingGet = $SaleInvoiceSettingGet->first();
        if(!empty($SaleInvoiceSettingGet)){
                return response(['status'=>true,'message'=>'Status updated successfully..','data' => $SaleInvoiceSettingGet]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    

 }