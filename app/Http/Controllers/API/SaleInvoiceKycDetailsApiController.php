<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\SaleInvoiceKycDetails;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Validator;
use App\Repositories\SaleInvoiceKycDetailsRepository;
use Mail;
use Response;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use XML;
use Illuminate\Support\Facades\Crypt;


class SaleInvoiceKycDetailsApiController extends AppBaseController
{
   
    use ApiResponser;

    private $saleInvoiceKycDetailsRepository;

    public function __construct(SaleInvoiceKycDetailsRepository $saleInvoiceKycDetailsRepository)
    {
        $this->saleInvoiceKycDetailsRepository = $saleInvoiceKycDetailsRepository;
    }

    /*SaleInvoiceKycDetails list api*/
    public function SaleInvoiceKycDetailsList($invoice_id)
    {
        $requestData = $this->saleInvoiceKycDetailsRepository->sale_invoice_kyc_list($invoice_id);

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Add Payment retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }
    /*SaleInvoiceKycDetailsShow show id wise*/
    public function SaleInvoiceKycDetailsShow($id)
    {
        $requestData = $this->saleInvoiceKycDetailsRepository->sale_invoice_kyc_show($id);
        
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Kyc Details retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }

   /*SaleInvoiceKycDetailsAdd add api*/
    public function SaleInvoiceKycDetailsAdd(Request $request)
    {   
        $validatorArray = [
          'document_number' => 'required',
            ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        $input = $request->all();
        $requestData = $this->saleInvoiceKycDetailsRepository->sale_invoice_kyc_add($input);       
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Kyc Details added successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*SaleInvoiceKycDetailsEdit update api*/
    public function SaleInvoiceKycDetailsEdit(Request $request)
    {   
       
        $input = $request->all();
        $requestData = $this->saleInvoiceKycDetailsRepository->sale_invoice_kyc_edit($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Kyc Details updated successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*delete api*/
    public function destroy($invoice_id)
    {

        $SaleInvoiceKycDetails = SaleInvoiceKycDetails::find($invoice_id);
        if (empty($SaleInvoiceKycDetails)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }
        $SaleInvoiceKycDetails->delete();      
        if(!empty($SaleInvoiceKycDetails)){
                return response(['status'=>true,'message'=>'Sale Invoice Kyc Details Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    
}