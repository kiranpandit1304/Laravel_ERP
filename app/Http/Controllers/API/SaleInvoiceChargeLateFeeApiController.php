<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\SaleInvoiceChargeLateFee;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Validator;
use App\Repositories\SaleInvoiceChargeLateFeeRepository;
use Mail;
use Response;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use XML;
use Illuminate\Support\Facades\Crypt;


class SaleInvoiceChargeLateFeeApiController extends AppBaseController
{
   
    use ApiResponser;

    private $saleInvoiceChargeLateFeeRepository;

    public function __construct(SaleInvoiceChargeLateFeeRepository $saleInvoiceChargeLateFeeRepository)
    {
        $this->saleInvoiceChargeLateFeeRepository = $saleInvoiceChargeLateFeeRepository;
    }

    /*SaleInvoiceChargeLateFee list api*/
    public function SaleInvoiceChargeLateFeeList($invoice_id)
    {
        $requestData = $this->saleInvoiceChargeLateFeeRepository->sale_invoice_charge_late_fee_list($invoice_id);

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Add Payment retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }
    /*SaleInvoiceChargeLateFeeShow show id wise*/
    public function SaleInvoiceChargeLateFeeShow($id)
    {
        $requestData = $this->saleInvoiceChargeLateFeeRepository->sale_invoice_charge_late_fee_show($id);
        
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Charge Late Fee retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }

   /*SaleInvoiceChargeLateFeeAdd add api*/
    public function SaleInvoiceChargeLateFeeAdd(Request $request)
    {   
        $validatorArray = [
          'fee_type' => 'required',
            ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        $input = $request->all();
        $requestData = $this->saleInvoiceChargeLateFeeRepository->sale_invoice_charge_late_fee_add($input);       
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Charge Late Fee added successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*SaleInvoiceChargeLateFeeEdit update api*/
    public function SaleInvoiceChargeLateFeeEdit(Request $request)
    {   
       
        $input = $request->all();
        $requestData = $this->saleInvoiceChargeLateFeeRepository->sale_invoice_charge_late_fee_edit($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Charge Late Fee updated successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*delete api*/
    public function destroy($invoice_id)
    {

        $SaleInvoiceChargeLateFee = SaleInvoiceChargeLateFee::find($invoice_id);
        if (empty($SaleInvoiceChargeLateFee)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }
        $SaleInvoiceChargeLateFee->delete();      
        if(!empty($SaleInvoiceChargeLateFee)){
                return response(['status'=>true,'message'=>'Sale Invoice Charge Late Fee Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    
}