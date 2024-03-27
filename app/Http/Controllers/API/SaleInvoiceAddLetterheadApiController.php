<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\SaleInvoiceAddLetterhead;
use App\Models\SaleInvoiceAddFooter;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repositories\SaleInvoiceAddLetterheadRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper;
use Mail;
use Response;

class SaleInvoiceAddLetterheadApiController extends AppBaseController
{
   
    use ApiResponser;

    private $saleInvoiceAddLetterheadRepository;

    public function __construct(SaleInvoiceAddLetterheadRepository $saleInvoiceAddLetterheadRepository)
    {
        $this->saleInvoiceAddLetterheadRepository = $saleInvoiceAddLetterheadRepository;
    }

   /*saleInvoiceAddLetterheadRepository show id wise*/
    public function SaleInvoiceAddLetterheadShow($id)
    {        
        $requestData = $this->saleInvoiceAddLetterheadRepository->sale_invoice_add_letterhead_show($id);
        if (empty($requestData)) {
            return response()->json(['status'=>false,'message'=>"Data not found!"]);
        }
        if(!is_null($requestData->letterhead_img)){
            $profile_image = CommonHelper::getS3FileUrl($requestData->letterhead_img);
            if($profile_image->status == "success"){
                $requestData->letterhead_img = $profile_image->fileUrl;
            }
        }
        
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Add Letterhead retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }

   /*SaleInvoiceAddLetterheadAdd add api*/
    public function SaleInvoiceAddLetterheadAdd(Request $request)
    {   
        $input = $request->all();
        $validatorArray = [
                'letterhead_img' => 'required',              
                
        ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        $requestData = $this->saleInvoiceAddLetterheadRepository->sale_invoice_add_letterhead_add($input); 
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Add Letterhead added successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*saleInvoiceAddLetterheadRepository show id wise*/
    public function SaleInvoiceAddFooterShow($id)
    {        
        $requestData = $this->saleInvoiceAddLetterheadRepository->sale_invoice_add_footer_show($id);
        if (empty($requestData)) {
            return response()->json(['status'=>false,'message'=>"Data not found!"]);
        }
        if(!is_null($requestData->footer_img)){
            $profile_image = CommonHelper::getS3FileUrl($requestData->footer_img);
            if($profile_image->status == "success"){
                $requestData->footer_img = $profile_image->fileUrl;
            }
        }        
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Add Footer retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }

   /*Footer add api*/
    public function SaleInvoiceAddFooterAdd(Request $request)
    {   
       
        $input = $request->all();
        $validatorArray = [
                'footer_img' => 'required',              
                
        ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        $requestData = $this->saleInvoiceAddLetterheadRepository->sale_invoice_add_footer_add($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Add Footer added successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    

 }