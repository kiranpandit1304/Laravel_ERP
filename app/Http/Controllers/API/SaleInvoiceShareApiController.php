<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\SaleInvoiceShare;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Repositories\SaleInvoiceShareRepository;
use Mail;
use Response;
use App\Helpers\CommonHelper;
use Illuminate\Support\Str; 


class SaleInvoiceShareApiController extends AppBaseController
{
   
    use ApiResponser;

    private $saleInvoiceShareRepository;

    public function __construct(SaleInvoiceShareRepository $saleInvoiceShareRepository)
    {
        $this->saleInvoiceShareRepository = $saleInvoiceShareRepository;
    }
    /*Sale Invioce share list api*/
    public function SaleInvoiceShareList($invoice_id)
    {
        $requestData = $this->saleInvoiceShareRepository->sale_invoice_share_list($invoice_id);
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sele invoice share retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }
    /*Invoice share show id wise*/
    public function SaleInvoiceShareShow($id)
    {
        $requestData = $this->saleInvoiceShareRepository->sale_invoice_share_show($id);
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale invoice share retrieved successfully..','data' => $requestData]);
        }else{
            return response()->json(['status'=>false,'message'=>"Data not found!"]);
        } 
    }

   /* SaleInvoice share add api*/
    public function SaleInvoiceShareAdd(Request $request)
    {   
        $input = $request->all();
        $validatorArray = [
               'mesg_type'=>'required',
                            
        ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        $invoice = \App\Models\SaleInvoice::where('sale_invoice.id',$input['invoice_id']);
        $invoice->leftjoin('business','sale_invoice.business_id','business.id');
        $invoice->select('sale_invoice.id','sale_invoice.business_logo','sale_invoice.customer_id','sale_invoice.customer_name','sale_invoice.invoice_no','business.business_name','sale_invoice.final_total','sale_invoice.invoice_date','sale_invoice.due_date','sale_invoice.payment_status','sale_invoice.invoice_pdf');
        $invoice=$invoice->first();


       // $saleInvoice = \App\Models\SaleInvoice::where('id',$input['invoice_id'])->select('id','customer_id')->first();
        $GetCustData = \App\Models\Customer::where('id',$invoice->customer_id)->select('id','email','billing_phone')->first();
        
        $requestData = $this->saleInvoiceShareRepository->sale_invoice_share_add($input,$invoice,$GetCustData); 
        $last_inserted_row = SaleInvoiceShare::orderBy('id','DESC')->first();
        $last_inserted['user_id'] = \Auth::user()->id;
        $last_inserted['invoice_id'] = @$last_inserted_row->invoice_id;
        $last_inserted['mesg_type'] = @$last_inserted_row->mesg_type;
        $last_inserted['recipient'] = @$last_inserted_row->recipient;
        $last_inserted['mobile_no'] = @$last_inserted_row->mobile_no;
        $last_inserted['created_at'] = !empty($last_inserted_row->created_at) ? date('F d, Y' , strtotime(@$last_inserted_row->created_at)) : '';
       // echo $GetCustData->id; exit;
        if(!empty($input['mesg_type']) && $input['mesg_type'] == 'email')
        {
            if(!empty($GetCustData) && $GetCustData->email != '')
            {
                if(empty($invoice->invoice_pdf) && $invoice->invoice_pdf == '')
                {
                    CommonHelper::CreateInvoicePdf($invoice);
                }

                $this->sendEmailLink($GetCustData->email,$input['invoice_id']);
                return response(['status'=>true,'message'=>'Email send successfully..','data' =>$last_inserted]);               
            }else{
                return response()->json(['status'=>false,'message'=>"Customer email is not added.."]);
            }

        } 
        if(!empty($input['mesg_type']) && $input['mesg_type'] == 'sms')
        {
            if(!empty($GetCustData) && $GetCustData->billing_phone != '')
            {
               $this->sendSmsInvoice($input,$invoice,$GetCustData->billing_phone);
               return response(['status'=>true,'message'=>'Sms send successfully..','data' =>$last_inserted]);               
            }else{
                return response()->json(['status'=>false,'message'=>"Customer phone no is not added.."]);
            }
            
        } 
        if(!empty($input['mesg_type']) && $input['mesg_type'] == 'whatsup')
        {
            if(!empty($GetCustData) && $GetCustData->billing_phone != '')
            {
               $inv_url  =  urlencode(route('fn.invoice_with_shorturl', [$input['invoice_id']]));
               $link  = '<a href="' . $inv_url . '"> click here</a>';
               $whats_text = ' Dear ' . @$invoice->customer_name . ', kindly note that Invoice no: ' . $invoice->invoice_no . ' from ' . @$invoice->business_name . ' remains outstanding.Link to access invoice: ' . $inv_url;
               //return \Redirect::to('https://wa.me/'.@$GetCustData->billing_phone.'/?text='.$whats_text);
               return response(['status'=>true,'message'=>'whatsup send successfully..','whats_text' => @$whats_text,'customeer_number' =>@$GetCustData->billing_phone,'data' =>$last_inserted]);               
            }else{
                return response()->json(['status'=>false,'message'=>"Customer phone no is not added.."]);
            }
            
        } 
        //exit;      
       // $get_data = SaleInvoiceShare::where('invoice_id',$input['invoice_id'])->get();
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale invoice share added successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    //Send email link
    public function sendEmailLink($email,$invoice_id)
    {
        //echo $email; exit;
        $authKey_env =  env('AUTHKEY');
        $templateId_env =  env('INVOICEEMAILTEMPLATENAME');

        $authKey =  (!empty($authKey_env) ? $authKey_env: '390501ASEMuj9OH63e9f096P1');
        $template_name =  (!empty($template_name) ? $templateId_env: 'Invoice_Email_Template');
        //get invoice send mail details
        $invoice = \App\Models\SaleInvoice::where('sale_invoice.id',$invoice_id);
        $invoice->leftjoin('business','sale_invoice.business_id','business.id');
        $invoice->leftjoin('currency','sale_invoice.currency','currency.id');
        $invoice->select('sale_invoice.business_logo','sale_invoice.customer_name','sale_invoice.invoice_no','business.business_name','sale_invoice.final_total','sale_invoice.invoice_date','sale_invoice.due_date','sale_invoice.payment_status','sale_invoice.invoice_pdf','currency.unit');
        $invoice=$invoice->first();
        if(!is_null($invoice->business_logo)){
            $profile_image = CommonHelper::getS3FileUrl($invoice->business_logo);
            if($profile_image->status == "success"){
                $invoice->business_logo = $profile_image->fileUrl;
            }
        }  
        if(!is_null($invoice->invoice_pdf)){
            $profile_image = CommonHelper::getS3FileUrl($invoice->invoice_pdf);
            if($profile_image->status == "success"){
                $invoice->invoice_pdf = $profile_image->fileUrl;
            }
        }
        if(empty($invoice->business_logo) && $invoice->business_logo == '')
        {
            $logo = "<tr><td align='center'><img src='https://erp.unesync.com/unsync_assets/assets/images/logo_email.png' alt='' style='width:200px !important;' height='auto'></td></tr>";
        }else{
            $logo = "<tr><td align='center'><img src='".$invoice->business_logo."' alt='' style='width:200px !important;' height='auto'></td></tr>";;
        }

        $invoiceDate = date('F d, Y', strtotime($invoice->invoice_date));
        $invoiceDueDate = date('F d, Y', strtotime($invoice->due_date));

        $getUser =  \App\Models\User::where('id',\Auth::user()->id)->first();
        $team_id =  $getUser->parent_id;
        if ($getUser->parent_id == 0) {
            $team_id = $getUser->id;
        }
        $SaleInvoiceBankDetails = \App\Models\SaleInvoiceBankDetails::where('team_id',$team_id)->where('business_id',$getUser->active_business_id)->where('is_show',1)->first();
        
        $SaleInvoiceBankUpi = \App\Models\SaleInvoiceBankUpi::where('team_id',$team_id)->where('business_id',$getUser->active_business_id)->where('is_active',1)->first();
        if(!empty($SaleInvoiceBankDetails->account_holder_name) || !empty($SaleInvoiceBankDetails->account_no) || !empty($SaleInvoiceBankDetails->bank_name))
        {
            $paymentBank = "Account Transfer";
        }
        if(!empty($SaleInvoiceBankUpi->upi_id)) 
        {
            $paymentUpi = "UPI ";
        }
        $paymentMethod = @$paymentBank.'-'.@$paymentUpi;
        $final_total = @$invoice->unit.@$invoice->final_total;
        
       /* $shortUrl = $invoice->invoice_pdf;
        echo $shortUrl; exit;*/
        //$email = "amit@unesync.com";
        $fields =  '{
                "smtp_hostname" : "smtp.mailer91.com",
                "smtp_port" : 587,
                "smtp_username" :"smtp.mailer91.com",
                "smtp_password" : "B1f9hfwVz9yMjxNF",
                "to": [{"name": "Amit","email": "'.@$email.'"}],
                "from": {"name": "Joe","email": "support@mail.unesync.com"},
                "domain": "mail.unesync.com",
                "mail_type_id": "3",   
                "template_id":"'.@$template_name.'",   
                "variables": { "Business_name": "'.@$invoice->business_name.'","URL": "'.@$invoice->invoice_pdf.'","inv_logo": "'.@$logo.'","recipient_name": "'.@$invoice->customer_name.'","inv_no": "'.@$invoice->invoice_no.'","business_name": "'.@$invoice->business_name.'","inv_total": "'.@$final_total.'","inv_date": "'.@$invoiceDate.'","inv_due_date": "'.@$invoiceDueDate.'","inv_payment_method": "'.@$paymentMethod.'"}
                 }';  

        $curl = curl_init();
        curl_setopt_array($curl, [
          CURLOPT_URL => "http://control.msg91.com/api/v5/email/send",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $fields,
          CURLOPT_HTTPHEADER => [
            "accept: application/json",
            "content-type: application/json",
            "authkey:".$authKey
          ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

       /* if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          echo $response;
        }
        exit;*/
        return;
    }
    //sendSmsInvoice
    public function sendSmsInvoice($input,$invoice,$mobile)
    {
        $authKey_env =  env('AUTHKEY');
        $senderId_env =  env('SENDERID');
        $templateId_env =  env('TEMPLATEID');

        $authKey =  (!empty($authKey_env) ? $authKey_env: '390501ASEMuj9OH63e9f096P1');
        $senderId =  (!empty($senderId_env) ? $senderId_env: 'ANCRAT');
        $templateId =  (!empty($templateId_env) ? $templateId_env: '63f6f70ed6fc05261e16d2d3');
     
        $mobile_no = '919558436763';
        if(!is_null($invoice->invoice_pdf)){
            $profile_image = CommonHelper::getS3FileUrl($invoice->invoice_pdf);
            if($profile_image->status == "success"){
                $invoice->invoice_pdf = $profile_image->fileUrl;
            }
        }
        if (isset($mobile_no)){

            $mobileNumber = $mobile_no;
            $message = 'Dear '.@$invoice->customer_name.',Kindly note that Invoice# '.@$invoice->invoice_no.' from '.@$invoice->business_name.' remains outstanding.Following is the invoice:'.@$invoice->invoice_pdf.' Powered By Uneminded';
           // $message = 'Your OTP for Anchal rathi app is '.$otp.'.Please do not share it.Team:- Anchal Rathi msg91 ';
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://control.msg91.com/api/v5/otp?invisible=1&otp=".$otp."&authkey=".$authKey."&mobile=".$mobileNumber."&template_id=".$templateId,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/json"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
            return;

            /*if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                echo $response;
            }
            exit;*/

         }
    }

    /*SaleInvoice share update api*/
    public function SaleInvoiceShareEdit(Request $request)
    {   
        $input = $request->all();
        $requestData = $this->saleInvoiceShareRepository->sale_invoice_share_edit($input);       

        //$get_data = SaleInvoiceShare::where('invoice_id',$input['invoice_id'])->get();
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale invoice share updated successfully..']);
        }else{
            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*delete api*/
    public function destroy($id)
    {
        $SaleInvoiceShare = SaleInvoiceShare::find($id);
        if (empty($SaleInvoiceShare)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }
        $SaleInvoiceShare->delete();      
        if(!empty($SaleInvoiceShare)){
                return response(['status'=>true,'message'=>'Sale Invoice share Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    } 
    
}
