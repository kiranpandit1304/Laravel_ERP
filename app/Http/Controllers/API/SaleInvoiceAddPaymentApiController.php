<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\SaleInvoiceAddPayment;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Validator;
use App\Repositories\SaleInvoiceAddPaymentRepository;
use Mail;
use Response;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use XML;
use Illuminate\Support\Facades\Crypt;


class SaleInvoiceAddPaymentApiController extends AppBaseController
{
   
    use ApiResponser;

    private $saleInvoiceAddPaymentRepository;

    public function __construct(SaleInvoiceAddPaymentRepository $saleInvoiceAddPaymentRepository)
    {
        $this->saleInvoiceAddPaymentRepository = $saleInvoiceAddPaymentRepository;
    }

    /*SaleInvoiceAddPaymentList list api*/
    public function SaleInvoiceAddPaymentList($invoice_id)
    {
        $requestData = $this->saleInvoiceAddPaymentRepository->sale_invoice_add_payment_list($invoice_id);

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Add Payment retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }
    /*SaleInvoiceAddPaymentShow show id wise*/
    public function SaleInvoiceAddPaymentShow($id)
    {
        $requestData = $this->saleInvoiceAddPaymentRepository->sale_invoice_add_payment_show($id);
        
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Add Payment retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }

   /*SaleInvoiceAddPaymentAdd add api*/
    public function SaleInvoiceAddPaymentAdd(Request $request)
    {   
        $validatorArray = [
          'amount_received' => 'required',
            ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        $input = $request->all();
        $requestData = $this->saleInvoiceAddPaymentRepository->sale_invoice_add_payment_add($input);       
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Add Payment added successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*SaleInvoiceAddPaymentEdit update api*/
    public function SaleInvoiceAddPaymentEdit(Request $request)
    {   
       
        $input = $request->all();
        $requestData = $this->saleInvoiceAddPaymentRepository->sale_invoice_add_payment_edit($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Add Payment updated successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*delete api*/
    public function destroy($invoice_id)
    {

        $SaleInvoiceAddPayment = SaleInvoiceAddPayment::find($invoice_id);
        if (empty($SaleInvoiceAddPayment)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }
        $SaleInvoiceAddPayment->delete();      
        if(!empty($SaleInvoiceAddPayment)){
                return response(['status'=>true,'message'=>'Sale Invoice Add Payment Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    //SaleInvoiceGetPayment
    public function SaleInvoiceGetPayment($invoice_id)
    {
        $amount_recived = \App\Models\SaleInvoiceAddPayment::where('invoice_id',@$invoice_id)->sum('amount_received');

        $total_tcs_amount = \App\Models\SaleInvoiceAddPayment::where('invoice_id',@$invoice_id)->sum('tcs_amount');
        $total_tds_amount = \App\Models\SaleInvoiceAddPayment::where('invoice_id',@$invoice_id)->sum('tds_amount');
        $total_transaction_charge = \App\Models\SaleInvoiceAddPayment::where('invoice_id',@$invoice_id)->sum('transaction_charge');

        $SaleInvoice= \App\Models\SaleInvoice::where('id',@$invoice_id)->select('sale_invoice.invoice_no','sale_invoice.customer_name','sale_invoice.final_total','sale_invoice.final_amount')->first();
        
        $last_amount_recived = \App\Models\SaleInvoiceAddPayment::where('invoice_id',@$invoice_id)->orderBy('id',"DESC")->first();
        $data['invoice_no'] = @$SaleInvoice->invoice_no;
        $data['customer_name'] = @$SaleInvoice->customer_name;
        $data['final_total'] = @$SaleInvoice->final_total;
        $data['total_pay_amount'] = @$amount_recived;
        $data['last_paid_amount'] =  @$last_amount_recived->amount_received;
        $data['total_amount'] =  @$SaleInvoice->final_amount;

        $data['total_tcs_amount'] =  @$total_tcs_amount;
        $data['total_tds_amount'] =  @$total_tds_amount;
        $data['total_transaction_charge'] =  @$total_transaction_charge;

        $data['grand_total_paid'] = $data['total_pay_amount'] + $data['total_tcs_amount'] + $data['total_tds_amount'] +$data['total_transaction_charge'];
        $due_amount =  @$SaleInvoice->final_total - $data['grand_total_paid'];
        $data['due_amount'] = $due_amount > 0 ? $due_amount : 0;

        $data['amount_received'] =  @$last_amount_recived->amount_received;
        $data['transaction_charge'] =  @$last_amount_recived->transaction_charge;
        $data['tds_percentage'] =  @$last_amount_recived->tds_percentage;
        $data['tds_amount'] =  @$last_amount_recived->tds_amount;
        $data['tcs_percentage'] =  @$last_amount_recived->tcs_percentage;
        $data['tcs_amount'] =  @$last_amount_recived->tcs_amount;
        $data['amount_to_settle'] =  @$last_amount_recived->amount_to_settle;
        $data['payment_date'] =  @$last_amount_recived->payment_date;
        $data['payment_method'] =  @$last_amount_recived->payment_method;
        $data['additional_notes'] =  @$last_amount_recived->additional_notes;
        $data['payment_status'] =  @$last_amount_recived->payment_status;

        if(!empty($data)){
                return response(['status'=>true,'message'=>'Sale invoice payment data get successfully..','data' => @$data]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }

    }
    
}