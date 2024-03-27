<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\SaleInvoiceBankDetails;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Repositories\SaleInvoiceBankDetailsRepository;
use Mail;
use Response;



class SaleInvoiceBankDetailsApiController extends AppBaseController
{
   
    use ApiResponser;

    private $saleInvoiceBankDetailsRepository;

    public function __construct(SaleInvoiceBankDetailsRepository $saleInvoiceBankDetailsRepository)
    {
        $this->saleInvoiceBankDetailsRepository = $saleInvoiceBankDetailsRepository;
    }
    /*Sale Invioce bank details list api*/
    public function SaleInvoiceBankDetailsList()
    {
        $requestData = $this->saleInvoiceBankDetailsRepository->sale_invoice_bank_details_list();
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sele invoice bank details retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }
    /*Invoice bank details show id wise*/
    public function SaleInvoiceBankDetailsShow($id)
    {
        $requestData = $this->saleInvoiceBankDetailsRepository->sale_invoice_bank_details_show($id);
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale invoice bank retrieved successfully..','data' => $requestData]);
        }else{
            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }

   /* SaleInvoice bank details add api*/
    public function SaleInvoiceBankDetailsAdd(Request $request)
    {   
        /*add team id*/
        if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
        {
            $team_id = \Auth::user()->parent_id;
        }else{
            $team_id = \Auth::user()->id;
        }
        /*end*/
        $input = $request->all();
        $validatorArray = [
               'ifsc'=>'required',
               'account_no'=>'required',
               'bank_name'=>'required',
               'country_id'=>'required',
               //'iban'=>'required',
               //'swift_code'=>'required',
               'currency'=>'required',
               'account_type'=>'required',
               'account_holder_name'=>'required',
               'mobile_no'=>'required',
               //'upi_id'=>'required',
                            
        ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        
        $requestData = $this->saleInvoiceBankDetailsRepository->sale_invoice_bank_details_add($input);       
        $getUser =  \App\Models\User::where('id',\Auth::user()->id)->first();
        $team_id =  $getUser->parent_id;
        if ($getUser->parent_id == 0) {
            $team_id = $getUser->id;
        }
        
        $get_data = SaleInvoiceBankDetails::where('team_id',$team_id)->where('business_id',\Auth::user()->active_business_id)->get();
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale invoice bank details added successfully..','data'=>$get_data]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*SaleInvoice bank details update api*/
    public function SaleInvoiceBankDetailsEdit(Request $request)
    {   
        $input = $request->all();
        $requestData = $this->saleInvoiceBankDetailsRepository->sale_invoice_bank_details_edit($input);       

        $get_data = SaleInvoiceBankDetails::where('invoice_id',$input['invoice_id'])->get();
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale invoice bank details updated successfully..','data'=>$get_data]);
        }else{
            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*delete api*/
    public function destroy($id)
    {
        $SaleInvoiceBankDetails = SaleInvoiceBankDetails::find($id);
        if (empty($SaleInvoiceBankDetails)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }
        $SaleInvoiceBankDetails->delete();      
        if(!empty($SaleInvoiceBankDetails)){
                return response(['status'=>true,'message'=>'Sale Invoice Bank Details Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*SaleInvoiceBankDetailsActive*/
    public function SaleInvoiceBankDetailsActive(Request $request)
    {

        $get_invoice = SaleInvoiceBankDetails::where('id',$request->id)->first();
        $SaleInvoiceBankDetails = SaleInvoiceBankDetails::where('invoice_id',$get_invoice->invoice_id)->update(['is_show' => '0']);
        if(!empty($request->is_show) && $request->is_show == 'true' )
        {
            $is_show=$request->is_show = 1;
        } else{
            $is_show= $request->is_show = 0;
        }
        //echo $request->is_show; exit;
        $SaleInvoiceBankDetails = SaleInvoiceBankDetails::where('id',$request->id)->update(['is_show' => $is_show]);
       
        $get_data = SaleInvoiceBankDetails::where('invoice_id',$get_invoice->invoice_id)->where('id',$request->id)->where('is_show','1')->first();
        if(!empty($SaleInvoiceBankDetails)){
                return response(['status'=>true,'message'=>'Bank details show status updated successfully..','data' => $get_data]);
        }else{

            return response()->json(['status'=>false,'message'=>"Bank details show status not updated"]);
        }
    } 
        
}