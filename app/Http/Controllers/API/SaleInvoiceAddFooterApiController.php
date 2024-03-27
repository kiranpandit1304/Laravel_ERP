<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\SaleInvoiceAddFooter;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repositories\SaleInvoiceAddFooterRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper;
use Mail;
use Response;

class SaleInvoiceAddFooterApiController extends AppBaseController
{
   
    use ApiResponser;

    private $saleInvoiceAddFooterRepository;

    public function __construct(SaleInvoiceAddFooterRepository $saleInvoiceAddFooterRepository)
    {
        $this->saleInvoiceAddFooterRepository = $saleInvoiceAddFooterRepository;
    }

    /*saleInvoiceAddFooterRepository show id wise*/
    public function SaleInvoiceAddFooterShow($id)
    {        
        $requestData = $this->saleInvoiceAddFooterRepository->sale_invoice_add_footer_show($id);
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
    public function SaleInvoiceAddFooter(Request $request)
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
        $requestData = $this->saleInvoiceAddFooterRepository->sale_invoice_add_footer($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Add Footer added successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    

 }