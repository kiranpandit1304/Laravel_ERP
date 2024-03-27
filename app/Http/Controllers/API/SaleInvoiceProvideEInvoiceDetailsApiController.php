<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\SaleInvoiceProvideEinvoiceDetails;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Validator;
use App\Repositories\SaleInvoiceProvideEinvoiceDetailsRepository;
use Mail;
use Response;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use XML;
use Illuminate\Support\Facades\Crypt;


class SaleInvoiceProvideEInvoiceDetailsApiController extends AppBaseController
{
   
    use ApiResponser;

    private $saleInvoiceProvideEinvoiceDetailsRepository;

    public function __construct(SaleInvoiceProvideEinvoiceDetailsRepository $saleInvoiceProvideEinvoiceDetailsRepository)
    {
        $this->saleInvoiceProvideEinvoiceDetailsRepository = $saleInvoiceProvideEinvoiceDetailsRepository;
    }

    /*SaleInvoiceProvideEInvoiceDetailsList list api*/
    public function SaleInvoiceProvideEInvoiceDetailsList($invoice_id)
    {
        $requestData = $this->saleInvoiceProvideEinvoiceDetailsRepository->sale_invoice_provide_einvoice_details_list($invoice_id);

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Add Details retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }
    /*SaleInvoiceProvideEInvoiceDetailsShow show id wise*/
    public function SaleInvoiceProvideEInvoiceDetailsShow($id)
    {
        $requestData = $this->saleInvoiceProvideEinvoiceDetailsRepository->sale_invoice_provide_einvoice_details_show($id);
        
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Add Details retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }

   /*SaleInvoiceProvideEInvoiceDetailsAdd add api*/
    public function SaleInvoiceProvideEInvoiceDetailsAdd(Request $request)
    {   
        $validatorArray = [
          'gstin' => 'required',
            ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        $input = $request->all();
        $requestData = $this->saleInvoiceProvideEinvoiceDetailsRepository->sale_invoice_provide_einvoice_details_add($input);       
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Add Details added successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*SaleInvoiceProvideEInvoiceDetailsEdit update api*/
    public function SaleInvoiceProvideEInvoiceDetailsEdit(Request $request)
    {   
       
        $input = $request->all();
        $requestData = $this->saleInvoiceProvideEinvoiceDetailsRepository->sale_invoice_add_payment_edit($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Add Payment updated successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*delete api*/
    public function destroy($invoice_id)
    {

        $SaleInvoiceProvideEInvoiceDetails = SaleInvoiceProvideEInvoiceDetails::find($invoice_id);
        if (empty($SaleInvoiceProvideEInvoiceDetails)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }
        $SaleInvoiceProvideEInvoiceDetails->delete();      
        if(!empty($SaleInvoiceProvideEInvoiceDetails)){
                return response(['status'=>true,'message'=>'Sale Invoice Add Details Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    
}