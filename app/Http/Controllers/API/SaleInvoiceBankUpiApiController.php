<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\SaleInvoiceBankUpi;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Repositories\SaleInvoiceBankUpiRepository;
use Mail;
use Response;



class SaleInvoiceBankUpiApiController extends AppBaseController
{
   
    use ApiResponser;

    private $saleInvoiceBankUpiRepository;

    public function __construct(SaleInvoiceBankUpiRepository $saleInvoiceBankUpiRepository)
    {
        $this->saleInvoiceBankUpiRepository = $saleInvoiceBankUpiRepository;
    }
    /*Sale Invioce bank Upi list api*/
    public function SaleInvoiceBankUpiList()
    {
        $requestData = $this->saleInvoiceBankUpiRepository->sale_invoice_bank_upi_list();
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sele invoice bank Upi retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }
    /*Invoice bank Upi show id wise*/
    public function SaleInvoiceBankUpiShow($id)
    {
        $requestData = $this->saleInvoiceBankUpiRepository->sale_invoice_bank_upi_show($id);
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale invoice bank upi retrieved successfully..','data' => $requestData]);
        }else{
            return response()->json(['status'=>false,'message'=>"Data not found!"]);
        } 
    }

   /* SaleInvoice bank Upi add api*/
    public function SaleInvoiceBankUpiAdd(Request $request)
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
        
        $requestData = $this->saleInvoiceBankUpiRepository->sale_invoice_bank_upi_add($input);       
        $getUser =  \App\Models\User::where('id',\Auth::user()->id)->first();
        $team_id =  $getUser->parent_id;
        if ($getUser->parent_id == 0) {
            $team_id = $getUser->id;
        }
        
        $get_data = SaleInvoiceBankUpi::where('team_id',$team_id)->where('business_id',\Auth::user()->active_business_id)->get();
        
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale invoice bank Upi added successfully..','data' =>$get_data]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*SaleInvoice bank Upi update api*/
    public function SaleInvoiceBankUpiEdit(Request $request)
    {   
        $input = $request->all();
        $requestData = $this->saleInvoiceBankUpiRepository->sale_invoice_bank_upi_edit($input);       

        $get_data = SaleInvoiceBankUpi::where('invoice_id',$input['invoice_id'])->get();
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale invoice bank Upi updated successfully..','data'=>$get_data]);
        }else{
            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*delete api*/
    public function destroy($id)
    {
        $SaleInvoiceBankUpi = SaleInvoiceBankUpi::find($id);
        if (empty($SaleInvoiceBankUpi)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }
        $SaleInvoiceBankUpi->delete();      
        if(!empty($SaleInvoiceBankUpi)){
                return response(['status'=>true,'message'=>'Sale Invoice Bank Upi Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    } 
    /*SaleInvoiceBankUpiActive*/
    public function SaleInvoiceBankUpiActive(Request $request)
    {
       
       $get_invoice = SaleInvoiceBankUpi::where('id',$request->id)->first();

       $SaleInvoiceBankDetails = SaleInvoiceBankUpi::where('invoice_id',$get_invoice->invoice_id)->update(['is_active' => '0']);
       if(!empty($request->is_active) && $request->is_active == 'true' )
        {
            $is_active=$request->is_active = 1;
        } else{
            $is_active= $request->is_active = 0;
        }
        //echo $request->id; exit;
       $SaleInvoiceBankUpi = SaleInvoiceBankUpi::where('id',$request->id)->update(['is_active' => $is_active]);
   
        if(!empty($SaleInvoiceBankUpi)){
                return response(['status'=>true,'message'=>'Bank Upi active successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Bank Upi not active"]);
        }
    }   
}
