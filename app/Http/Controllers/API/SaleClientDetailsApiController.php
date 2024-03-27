<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\SaleInvoiceClientDetails;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Validator;
use App\Repositories\SaleInvoiceClientDetailsRepository;
use Mail;
use Response;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use XML;
use Illuminate\Support\Facades\Crypt;


class SaleClientDetailsApiController extends AppBaseController
{
   
    use ApiResponser;

    private $saleInvoiceClientDetailsRepository;

    public function __construct(SaleInvoiceClientDetailsRepository $saleInvoiceClientDetailsRepository)
    {
        $this->saleInvoiceClientDetailsRepository = $saleInvoiceClientDetailsRepository;
    }

    /*SaleInvoiceClientDetailsRepository list api*/
    public function SaleClientDetailsList($invoice_id)
    {
        $requestData = $this->saleInvoiceClientDetailsRepository->sale_client_details_list($invoice_id);

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice client Details retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }
    /*saleInvoiceClientDetailsRepositoryShow show id wise*/
    public function SaleClientDetailsShow($id)
    {
        $requestData = $this->saleInvoiceClientDetailsRepository->sale_client_details_show($id);
        
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice client Details retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Data not found!"]);
        } 
    }

   /*saleInvoiceClientDetailsRepositoryAdd add api*/
    public function SaleClientDetailsAdd(Request $request)
    {   
        $validatorArray = [
          'name' => 'required',
            ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        $input = $request->all();
        $requestData = $this->saleInvoiceClientDetailsRepository->sale_client_details_add($input);       
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice client Details added successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*saleInvoiceClientDetailsRepositoryEdit update api*/
    public function SaleClientDetailsEdit(Request $request)
    {   
       
        $input = $request->all();
        $requestData = $this->saleInvoiceClientDetailsRepository->sale_client_details_edit($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice client Details updated successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*delete api*/
    public function destroy($invoice_id)
    {

        $saleInvoiceClientDetailsRepository = saleInvoiceClientDetailsRepository::find($invoice_id);
        if (empty($saleInvoiceClientDetailsRepository)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }
        $saleInvoiceClientDetailsRepository->delete();      
        if(!empty($saleInvoiceClientDetailsRepository)){
                return response(['status'=>true,'message'=>'Sale Invoice client Details Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    
}