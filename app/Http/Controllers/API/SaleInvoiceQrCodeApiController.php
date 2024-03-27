<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\SaleInvoiceQrCode;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Repositories\SaleInvoiceQrCodeRepository;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper;
use Mail;
use Response;



class SaleInvoiceQrCodeApiController extends AppBaseController
{
   
    use ApiResponser;

    private $saleInvoiceQrCodeRepository;

    public function __construct(SaleInvoiceQrCodeRepository $saleInvoiceQrCodeRepository)
    {
        $this->saleInvoiceQrCodeRepository = $saleInvoiceQrCodeRepository;
    }
    /*Sale Invioce qr code list api*/
    public function SaleInvoiceQrCodeList($invoice_id)
    {
        $requestData = $this->saleInvoiceQrCodeRepository->sale_invoice_qr_code_list($invoice_id);
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sele invoice qr code retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }
    /*Invoice qr code show id wise*/
    public function SaleInvoiceQrCodeShow($id)
    {
        $requestData = $this->saleInvoiceQrCodeRepository->sale_invoice_qr_code_show($id);
        if (empty($requestData)) {
            return response()->json(['status'=>false,'message'=>"Data not found!"]);
        }
        if(!is_null($requestData->qr_logo)){
            $profile_image = CommonHelper::getS3FileUrl($requestData->qr_logo);
            if($profile_image->status == "success"){
                $requestData->qr_logo = $profile_image->fileUrl;
            }
        }
        if(!is_null($requestData->qr_image)){
            $profile_image = CommonHelper::getS3FileUrl($requestData->qr_image);
            if($profile_image->status == "success"){
                $requestData->qr_image = $profile_image->fileUrl;
            }
        }

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale invoice qr code retrieved successfully..','data' => $requestData]);
        }else{
            return response()->json(['status'=>false,'message'=>"Data not found!"]);
        } 
    }

   /* SaleInvoice qr code add api*/
    public function SaleInvoiceQrCodeAdd(Request $request)
    {   
        $input = $request->all();
        $validatorArray = [
               'upi_id'=>'required',
                            
        ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        
        $requestData = $this->saleInvoiceQrCodeRepository->sale_invoice_qr_code_add($input);       
        //$get_data = SaleInvoiceQrCode::where('invoice_id',$input['invoice_id'])->get();
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale invoice qr code added successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*SaleInvoice qr code update api*/
    public function SaleInvoiceQrCodeEdit(Request $request)
    {   
        $input = $request->all();
        $requestData = $this->saleInvoiceQrCodeRepository->sale_invoice_qr_code_edit($input);       

        //$get_data = SaleInvoiceQrCode::where('invoice_id',$input['invoice_id'])->get();
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale invoice qr code updated successfully..']);
        }else{
            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*delete api*/
    public function destroy($id)
    {
        $SaleInvoiceQrCode = SaleInvoiceQrCode::find($id);
        if (empty($SaleInvoiceQrCode)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }
        $SaleInvoiceQrCode->delete();      
        if(!empty($SaleInvoiceQrCode)){
                return response(['status'=>true,'message'=>'Sale Invoice qr code Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    } 
   
}
