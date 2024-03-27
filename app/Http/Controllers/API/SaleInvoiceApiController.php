<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\SaleInvoice;
use App\Models\SaleInvoiceAttachments;
use App\Models\SaleInvoiceProduct;
use App\Models\SaleInvoiceProductImage;
use App\Models\SaleInvoiceService;
use App\Models\SaleInvoiceGroup;
use App\Models\SaleInvoiceGroupImg;
use App\Models\SaleInvoiceLabelChange;
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
use App\Repositories\SaleInvoiceRepository;
use App\Exports\SaleInvoiceExport;
use Maatwebsite\Excel\Facades\Excel;
use Mail;
use Response;
use PDF;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper; 


class SaleInvoiceApiController extends AppBaseController
{
   
    use ApiResponser;

    private $saleInvoiceRepository;

    public function __construct(SaleInvoiceRepository $saleInvoiceRepository)
    {
        $this->saleInvoiceRepository = $saleInvoiceRepository;
    }

    /*SaleInvoiceCheckNo*/
    public function SaleInvoiceCheckNo(Request $request)
    {
        $checkExist = SaleInvoice::where('sale_invoice.business_id',\Auth::user()->active_business_id);
        $checkExist->where('sale_invoice.created_by',\Auth::user()->id);
        $checkExist->where('sale_invoice.invoice_no',$request['invoice_no']);
        $checkExist->select('id','invoice_no');
        $checkExist = $checkExist->first();

        if(!empty($checkExist) && $checkExist->invoice_no !='')
        {
            return response()->json(['status'=>false,'message'=>"Invoice No is already exist"]);
        }
    }

    /*Sale Invioce list api*/
    public function SaleInvoiceList()
    {

        $requestData = $this->saleInvoiceRepository->sale_invoice_list();

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sele invoice retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }
    /*Invoice show id wise*/
    public function SaleInvoiceShow($id)
    {
        $requestData = $this->saleInvoiceRepository->sale_invoice_show($id);
        if(!is_null($requestData['business_logo'])){
            $profile_image = CommonHelper::getS3FileUrl($requestData['business_logo']);
            if($profile_image->status == "success"){
                $requestData->business_logo = $profile_image->fileUrl;
            }
        }  
        if(!is_null($requestData['signature'])){
            $profile_image = CommonHelper::getS3FileUrl($requestData['signature']);
            if($profile_image->status == "success"){
                $requestData->signature = $profile_image->fileUrl;
            }
        } 
        /*SaleInvoiceAttachments*/ 
        $SaleInvoiceAttachments_data = SaleInvoiceAttachments::where('invoice_id',$id)->get();     
        foreach ($SaleInvoiceAttachments_data as $key => $Attachments) {
            if(!is_null($Attachments->invoice_attachments)){
                $profile_image = CommonHelper::getS3FileUrl($Attachments->invoice_attachments);
                if($profile_image->status == "success"){
                    $Attachments->invoice_attachments = $profile_image->fileUrl;
                }
            } 
        }
        $SaleInvoiceProduct = SaleInvoiceProduct::where('invoice_id',$id)->get();     
        $SaleInvoiceProductImage = SaleInvoiceProductImage::where('invoice_id',$id)->get();     
        $SaleInvoiceService = SaleInvoiceService::where('invoice_id',$id)->get(); 
        $SaleInvoiceGroup = SaleInvoiceGroup::where('invoice_id',$id)->get();
        $SaleInvoiceGroupImg = SaleInvoiceGroupImg::where('invoice_id',$id)->get();    
        foreach ($SaleInvoiceProductImage as $key => $ProductImage) {
            if(!is_null($ProductImage->invoice_product_image)){
                $profile_image = CommonHelper::getS3FileUrl($ProductImage->invoice_product_image);
                if($profile_image->status == "success"){
                    $ProductImage->invoice_product_image = $profile_image->fileUrl;
                }
            } 
        }

        /*step - 3*/
        /*$SaleInvoiceAdvanceSetting = \App\Models\SaleInvoiceAdvanceSetting::where('invoice_id',$id)->get();
        $SaleInvoiceFields = \App\Models\SaleInvoiceFields::where('invoice_id',$id)->get();
        $SaleInvoiceAddFooter = \App\Models\SaleInvoiceAddFooter::where('invoice_id',$id)->get();
        $SaleInvoiceAddLetterhead = \App\Models\SaleInvoiceAddLetterhead::where('invoice_id',$id)->get();
        $SaleInvoiceAddPayment = \App\Models\SaleInvoiceAddPayment::where('invoice_id',$id)->get();
        $SaleInvoiceBankUpi = \App\Models\SaleInvoiceBankUpi::where('invoice_id',$id)->get();
        $SaleInvoiceBusinessDetails = \App\Models\SaleInvoiceBusinessDetails::where('invoice_id',$id)->get();
        $SaleInvoiceChargeLateFee = \App\Models\SaleInvoiceChargeLateFee::where('invoice_id',$id)->get();
        $SaleInvoiceClientDetails = \App\Models\SaleInvoiceClientDetails::where('invoice_id',$id)->get();
        $SaleInvoiceKycDetails = \App\Models\SaleInvoiceKycDetails::where('invoice_id',$id)->get();
        $SaleInvoiceLabelChange = \App\Models\SaleInvoiceLabelChange::where('invoice_id',$id)->get();
        $SaleInvoiceProvideEinvoiceDetails = \App\Models\SaleInvoiceProvideEinvoiceDetails::where('invoice_id',$id)->get();
        $SaleInvoiceQrCode = \App\Models\SaleInvoiceQrCode::where('invoice_id',$id)->get();
        $SaleInvoiceShare = \App\Models\SaleInvoiceShare::where('invoice_id',$id)->get();*/         


        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale invoice retrieved successfully..','data' => $requestData,'SaleInvoiceAttachments_data' => $SaleInvoiceAttachments_data,'SaleInvoiceProduct' => $SaleInvoiceProduct,'SaleInvoiceProductImage' => $SaleInvoiceProductImage,'SaleInvoiceService' => $SaleInvoiceService,'SaleInvoiceGroup'=>$SaleInvoiceGroup,'SaleInvoiceGroupImg'=>$SaleInvoiceGroupImg]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }
    /*SaleInvoiceGetLastRecord*/
    public function SaleInvoiceGetLastRecord()
    {
        $requestData = $this->saleInvoiceRepository->sale_invoice_last_record_show();
            if(!is_null($requestData->business_logo)){
                $profile_image = CommonHelper::getS3FileUrl($requestData->business_logo);
                if($profile_image->status == "success"){
                    $requestData->business_logo = $profile_image->fileUrl;
                }
            }  
            if(!is_null($requestData->signature)){
                $profile_image = CommonHelper::getS3FileUrl($requestData->signature);
                if($profile_image->status == "success"){
                    $requestData->signature = $profile_image->fileUrl;
                }
            } 
        /*SaleInvoiceAttachments*/ 
        $SaleInvoiceAttachments_data = SaleInvoiceAttachments::where('invoice_id',$id)->get();     
        foreach ($SaleInvoiceAttachments_data as $key => $Attachments) {
            if(!is_null($Attachments->invoice_attachments)){
                $profile_image = CommonHelper::getS3FileUrl($Attachments->invoice_attachments);
                if($profile_image->status == "success"){
                    $Attachments->invoice_attachments = $profile_image->fileUrl;
                }
            } 
        }
        $SaleInvoiceProduct = SaleInvoiceProduct::where('invoice_id',$id)->get();     
        $SaleInvoiceProductImage = SaleInvoiceProductImage::where('invoice_id',$id)->get();
        $SaleInvoiceService = SaleInvoiceService::where('invoice_id',$id)->get();     
        foreach ($SaleInvoiceProductImage as $key => $ProductImage) {
            if(!is_null($ProductImage->invoice_product_image)){
                $profile_image = CommonHelper::getS3FileUrl($ProductImage->invoice_product_image);
                if($profile_image->status == "success"){
                    $ProductImage->invoice_product_image = $profile_image->fileUrl;
                }
            } 
        }
        $SaleInvoiceGroup = SaleInvoiceGroup::where('invoice_id',$id)->get();
        $SaleInvoiceGroupImg = SaleInvoiceGroupImg::where('invoice_id',$id)->get();    
        foreach ($SaleInvoiceProductImage as $key => $ProductImage) {
            if(!is_null($ProductImage->invoice_product_image)){
                $profile_image = CommonHelper::getS3FileUrl($ProductImage->invoice_product_image);
                if($profile_image->status == "success"){
                    $ProductImage->invoice_product_image = $profile_image->fileUrl;
                }
            } 
        }
            
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale invoice retrieved successfully..','data' => $requestData,'SaleInvoiceAttachments_data' => $SaleInvoiceAttachments_data,'SaleInvoiceProduct' => $SaleInvoiceProduct,'SaleInvoiceProductImage' => $SaleInvoiceProductImage,'SaleInvoiceService' => $SaleInvoiceService,'SaleInvoiceGroup' => $SaleInvoiceGroup,'SaleInvoiceGroupImg' => $SaleInvoiceGroupImg]);
        }else{

            return response()->json(['status'=>false,'message'=>"No data found!"]);
        } 
    }

   /* SaleInvoice add api*/
    public function SaleInvoiceAdd(Request $request)
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
               //'invoice_title' =>'required',        
               'invoice_date' =>'required',        
                            
        ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        $checkExist = SaleInvoice::where('sale_invoice.business_id',\Auth::user()->active_business_id);
        $checkExist->where('sale_invoice.created_by',\Auth::user()->id);
        $checkExist->where('sale_invoice.invoice_no',$input['invoice_no']);
        $checkExist->select('id','invoice_no');
        $checkExist = $checkExist->first();

        if(!empty($checkExist) && $checkExist->invoice_no !='')
        {
            return response()->json(['status'=>false,'message'=>"Invoice No is already exist"]);
        }
        $requestData = $this->saleInvoiceRepository->sale_invoice_add($input);       

        $invoice = SaleInvoice::orderBy('id','DESC')->first();

        $getUser =  \App\Models\User::where('id',\Auth::user()->id)->first();
        $team_id =  $getUser->parent_id;
        if ($getUser->parent_id == 0) {
            $team_id = $getUser->id;
        }
        $SaleInvoiceAllBankDetails = \App\Models\SaleInvoiceBankDetails::where('team_id',$team_id)->where('business_id',$getUser->active_business_id)->get();
        if(!empty($SaleInvoiceAllBankDetails) && count($SaleInvoiceAllBankDetails) > 0)
        {
            $have_bank_detail = true; 
        }else{
            $have_bank_detail = false;
        }
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale invoice added successfully..','invoice_id' => @$invoice['id'],'have_bank_detail' => @$have_bank_detail]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /* SaleInvoiceDuplicate add api*/
    public function SaleInvoiceDuplicate(Request $request)
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
               'invoice_id' =>'required',        
                            
        ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        $requestData = $this->saleInvoiceRepository->sale_invoice_duplicate_add($input);    

        $invoice = SaleInvoice::orderBy('id','DESC')->first();
        if(!empty($requestData)){
             return response(['status'=>true,'message'=>'Sale invoice duplicate added successfully..','invoice_id' => @$invoice['id']]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*SaleInvoice update api*/
    public function SaleInvoiceEdit(Request $request)
    {   
       
        $input = $request->all();
        $requestData = $this->saleInvoiceRepository->sale_invoice_edit($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice updated successfully..','invoice_id' => @$input['id']]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*soft delete*/
    public function destroy($id)
    {
        $SaleInvoiceDelete = SaleInvoice::where('id',$id)->update(['is_delete' => 1]);
        
        // add stock for cancel invoice
        $this->cancelInvoiceStockAdd($id);

        if(!empty($SaleInvoiceDelete)){
                return response(['status'=>true,'message'=>'Sale invoice deleted successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Sale invoice not deleted"]);
        }
    }
    //SaleInvoiceRecover
     public function SaleInvoiceRecover($id)
    {
        $SaleInvoiceDelete = SaleInvoice::where('id',$id)->update(['is_delete' => 0]);        
        $getInvoiceProduct = \App\Models\SaleInvoiceProduct::where('invoice_id',$id)->get();
        if(!empty($getInvoiceProduct) && $getInvoiceProduct > 0)
        {
            foreach ($getInvoiceProduct as $key => $value) {
                //get old stock
                $getOldstock =   \App\Models\AdjustmentItem::where('variation_id',@$value->variation_id)->first();
                $updateStock = @$getOldstock->quantity - @$value->product_quantity;

                //update main stock
                $updateMainStock = \App\Models\AdjustmentItem::where('variation_id',@$value->variation_id)                           ->update(['quantity' => @$updateStock]);

            }
        }
        if(!empty($SaleInvoiceDelete)){
                return response(['status'=>true,'message'=>'Sale invoice recover successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Sale invoice not recover"]);
        }
    }
     /*Cancel*/
     public function invoiceCancel($id)
     {
         $SaleInvoiceDelete = SaleInvoice::where('id',$id)->update([
            'payment_status' => "Cancelled",
            'final_amount' => "0",
            'final_sgst' => "0",
            'final_cgst' => "0",
            'final_igst' => "0",
            'final_product_wise_discount' => "0",
            'final_total_discount_reductions' => "0",
            'final_extra_charges' => "0",
            'final_total' => "0",
            'final_total_words' => "",
        ]);

        $SaleInvoiceAddPayment =  \App\Models\SaleInvoiceAddPayment::where('invoice_id',$id)->update([
            'payment_status' => "Cancelled",
            'amount_received' => "0",
            'transaction_charge' => "0",
            'tds_amount' => "0",
            'tcs_percentage' => "0",
            'tcs_amount' => "0",
            'amount_to_settle' => "0"
        ]);

        // add stock for cancel invoice
         $this->cancelInvoiceStockAdd($id);
        
         if(!empty($SaleInvoiceDelete)){
                 return response(['status'=>true,'message'=>'Invoice cancelled successfully..']);
         }else{
 
             return response()->json(['status'=>false,'message'=>"Invoice not cancelled"]);
         }
     }
     // add stock for cancel invoice
     public function cancelInvoiceStockAdd($invoice_id)
     {
        $getInvoiceProduct = \App\Models\SaleInvoiceProduct::where('invoice_id',$invoice_id)->get();
        if(!empty($getInvoiceProduct) && $getInvoiceProduct > 0)
        {
            foreach ($getInvoiceProduct as $key => $value) {
                //get old stock
                $getOldstock =   \App\Models\AdjustmentItem::where('variation_id',@$value->variation_id)->first();
                $updateStock = @$getOldstock->quantity + @$value->product_quantity;

                //update main stock
                $updateMainStock = \App\Models\AdjustmentItem::where('variation_id',@$value->variation_id)                           ->update(['quantity' => @$updateStock]);

            }
        }
        return;
            
     }

      /*Remove payment*/
    public function invoiceRemovePayment($id)
    {
        $SaleInvoiceDelete = SaleInvoice::where('id',$id)->update([
            'payment_status' => "Unpaid",
        ]);

        $SaleInvoiceAddPayment =  \App\Models\SaleInvoiceAddPayment::where('invoice_id',$id)->update([
            'payment_status' => "Unpaid",
            'amount_received' => "0",
            'transaction_charge' => "0",
            'tds_amount' => "0",
            'tcs_percentage' => "0",
            'tcs_amount' => "0",
            'amount_to_settle' => "0"
        ]);
       
        if(!empty($SaleInvoiceDelete)){
                return response(['status'=>true,'message'=>'Invoice payment removed successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Invoice payment not removed"]);
        }
    }
    /*delete api*/
    public function destroy_old($id)
    {
        $SaleInvoice = SaleInvoice::find($id);
        if (empty($SaleInvoice)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }
        /*S3 delete code*/
        if(!empty($SaleInvoice))
        {
            if(!empty($SaleInvoice->business_logo) && $SaleInvoice->business_logo != '')
            {
                $delete_media = explode('/',$SaleInvoice->business_logo);
                $file = base64_decode($delete_media['2']);
                $media_delete = Storage::disk('s3')->delete($file);
            }
        }
        if(!empty($SaleInvoice))
        {
            if(!empty($SaleInvoice->signature) && $SaleInvoice->signature != '')
            {
                $delete_media = explode('/',$SaleInvoice->signature);
                $file = base64_decode($delete_media['2']);
                $media_delete = Storage::disk('s3')->delete($file);
            }
        }
        $SaleInvoiceAttachments = SaleInvoiceAttachments::where('invoice_id',$id)->get(); 
        if(!empty($SaleInvoiceAttachments))
        {
            foreach ($SaleInvoiceAttachments as$value) {
                if(!empty($value->invoice_attachments) && $value->invoice_attachments != '')
                {
                    $delete_media = explode('/',$value->invoice_attachments);
                    $file = base64_decode($delete_media['2']);
                    $media_delete = Storage::disk('s3')->delete($file);
                }
            }
        }
        $SaleInvoiceAttachments = SaleInvoiceAttachments::where('invoice_id',$id)->delete();
        $SaleInvoiceProduct = SaleInvoiceProduct::where('invoice_id',$id)->delete();
        $SaleInvoiceProductImage = SaleInvoiceProductImage::where('invoice_id',$id)->get(); 
        if(!empty($SaleInvoiceProductImage))
        {
            foreach ($SaleInvoiceProductImage as$value) {
                if(!empty($value->invoice_product_image) && $value->invoice_product_image != '')
                {
                    $delete_media = explode('/',$value->invoice_product_image);
                    $file = base64_decode($delete_media['2']);
                    $media_delete = Storage::disk('s3')->delete($file);
                }
            }
        }
        $SaleInvoiceProductImage = SaleInvoiceProductImage::where('invoice_id',$id)->delete();
        $SaleInvoiceService = SaleInvoiceService::where('invoice_id',$id)->delete();
        $SaleInvoiceGroup = SaleInvoiceGroup::where('invoice_id',$id)->delete();
        $SaleInvoiceGroupImg = SaleInvoiceGroupImg::where('invoice_id',$id)->get(); 
        if(!empty($SaleInvoiceGroupImg))
        {
            foreach ($SaleInvoiceGroupImg as$value) {
                if(!empty($value->invoice_group_image) && $value->invoice_group_image != '')
                {
                    $delete_media = explode('/',$value->invoice_group_image);
                    $file = base64_decode($delete_media['2']);
                    $media_delete = Storage::disk('s3')->delete($file);
                }
            }
        }
        /*end s3 deletc code*/
        $SaleInvoiceGroupImg = SaleInvoiceGroupImg::where('invoice_id',$id)->delete();
        $SaleInvoiceAdvanceSetting = \App\Models\SaleInvoiceAdvanceSetting::where('invoice_id',$id)->delete();
        $SaleInvoiceFields = \App\Models\SaleInvoiceFields::where('invoice_id',$id)->delete();
        $SaleInvoiceAddFooter = \App\Models\SaleInvoiceAddFooter::where('invoice_id',$id)->delete();
        $SaleInvoiceAddLetterhead = \App\Models\SaleInvoiceAddLetterhead::where('invoice_id',$id)->delete();
        $SaleInvoiceAddPayment = \App\Models\SaleInvoiceAddPayment::where('invoice_id',$id)->delete();
        $SaleInvoiceBankUpi = \App\Models\SaleInvoiceBankUpi::where('invoice_id',$id)->delete();
        $SaleInvoiceBusinessDetails = \App\Models\SaleInvoiceBusinessDetails::where('invoice_id',$id)->delete();
        $SaleInvoiceChargeLateFee = \App\Models\SaleInvoiceChargeLateFee::where('invoice_id',$id)->delete();
        $SaleInvoiceClientDetails = \App\Models\SaleInvoiceClientDetails::where('invoice_id',$id)->delete();
        $SaleInvoiceKycDetails = \App\Models\SaleInvoiceKycDetails::where('invoice_id',$id)->delete();
        $SaleInvoiceLabelChange = \App\Models\SaleInvoiceLabelChange::where('invoice_id',$id)->delete();
        $SaleInvoiceProvideEinvoiceDetails = \App\Models\SaleInvoiceProvideEinvoiceDetails::where('invoice_id',$id)->delete();
        $SaleInvoiceQrCode = \App\Models\SaleInvoiceQrCode::where('invoice_id',$id)->delete();
        $SaleInvoiceShare = \App\Models\SaleInvoiceShare::where('invoice_id',$id)->delete();
        $SaleInvoice->delete();      
        if(!empty($SaleInvoice)){
                return response(['status'=>true,'message'=>'Sale Invoice Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    public function SaleInvoiceMuilipleDelete(Request $request)
    {
       
        $id = $request->id;
        $SaleInvoice = \App\Models\SaleInvoice::whereIn('id',$id)->update(['is_delete' => 1]);       
       
        if(!empty($SaleInvoice)){
                return response(['status'=>true,'message'=>'Sale Invoice Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
        
    }

    /*CustomerPdf*/
     public function InvoicePdf($invoice_id='',$template_id='', $auth_id ='') {
       //echo "ddd"; exit;
        $getUser =  \App\Models\User::where('id',$auth_id)->first();
        $team_id =  $getUser->parent_id;
        if ($getUser->parent_id == 0) {
            $team_id = $getUser->id;
        }
        if(!empty(request()->copy))
        {
            $copy = request()->copy;
        }
        /*echo $copy;
        exit;*/

        $sale_invoice_list = SaleInvoice::where('sale_invoice.id', $invoice_id);
        $sale_invoice_list->leftjoin('sale_invoice_advance_setting','sale_invoice.id','sale_invoice_advance_setting.invoice_id');
        $sale_invoice_list->leftjoin('sale_invoice_fields','sale_invoice.id','sale_invoice_fields.invoice_id');
        $sale_invoice_list->leftjoin('sale_invoice_label_change','sale_invoice.id','sale_invoice_label_change.invoice_id');
        $sale_invoice_list->leftjoin('currency','sale_invoice.currency','currency.id');
        $sale_invoice_list->leftjoin('users','sale_invoice.created_by','users.id');
        $sale_invoice_list->select('sale_invoice.*','sale_invoice_advance_setting.invoice_id','sale_invoice_advance_setting.number_format','sale_invoice_advance_setting.invoice_country','sale_invoice_advance_setting.decimal_digit_format','sale_invoice_advance_setting.hide_place_of_supply','sale_invoice_advance_setting.hsn_column_view','sale_invoice_advance_setting.show_hsn_summary','sale_invoice_advance_setting.add_original_images','sale_invoice_advance_setting.show_description_in_full_width','sale_invoice_fields.filed_data','sale_invoice_label_change.label_invoice_no','sale_invoice_label_change.label_invoice_date','sale_invoice_label_change.label_invoice_due_date','sale_invoice_label_change.label_invoice_billed_by','sale_invoice_label_change.label_invoice_billed_to','sale_invoice_label_change.label_invoice_shipped_from','sale_invoice_label_change.label_invoice_shipped_to','sale_invoice_label_change.label_invoice_transport_details','sale_invoice_label_change.label_invoice_challan_no','sale_invoice_label_change.label_invoice_challan_date','sale_invoice_label_change.label_invoice_transport','sale_invoice_label_change.label_invoice_extra_information','sale_invoice_label_change.label_invoice_terms_and_conditions','sale_invoice_label_change.label_invoice_additional_notes','sale_invoice_label_change.label_invoice_attachments','sale_invoice_label_change.additional_info_label','sale_invoice_label_change.label_round_up','sale_invoice_label_change.label_round_down','sale_invoice_label_change.label_total',
            'currency.type','currency.unit','users.name as CreatedBy');
        $sale_invoice_list->orderBy('sale_invoice.id','DESC');
        $saleInvoice = $sale_invoice_list->first();

         if(!is_null($saleInvoice['business_logo'])){
            $profile_image = CommonHelper::getS3FileUrl($saleInvoice['business_logo']);
            if($profile_image->status == "success"){
                $saleInvoice->business_logo = $profile_image->fileUrl;
            }
        }  
        if(!is_null($saleInvoice['invoice_pdf'])){
            $profile_image = CommonHelper::getS3FileUrl($saleInvoice['invoice_pdf']);
            if($profile_image->status == "success"){
                $saleInvoice->invoice_pdf = $profile_image->fileUrl;
            }
        } 
        $InvoiceProductData = \App\Models\SaleInvoiceProduct::where('sale_invoice_product.invoice_id',$invoice_id);
        //$InvoiceProduct->leftjoin('product_variation','sale_invoice_product.product_id','product_variation.id');
       // $InvoiceProduct->leftjoin('product_services','sale_invoice_product.product_id','product_services.id');
        $InvoiceProductData->where('sale_invoice_product.invoice_group_id','0');
        $InvoiceProductData->select('sale_invoice_product.*');
        $InvoiceProductData = $InvoiceProductData->get();
        $count1 = 0;
        foreach ($InvoiceProductData as $key => $value) {
            $InvoiceProduct = \App\Models\SaleInvoiceProduct::where('sale_invoice_product.invoice_id',$invoice_id);
            $InvoiceProduct->leftjoin('product_variation','sale_invoice_product.variation_id','product_variation.id');
            $InvoiceProduct->leftjoin('product_services','sale_invoice_product.product_id','product_services.id');
            $InvoiceProduct->where('sale_invoice_product.invoice_group_id','0');
            $InvoiceProduct->select('sale_invoice_product.*','product_variation.variation_name','product_services.name as productName');
            $InvoiceProduct = $InvoiceProduct->get()->toArray();

            $SaleInvoiceProduct = \App\Models\SaleInvoiceProductImage::where('product_id',$value['product_id'])->where('product_id',$value['product_id'])->get()->toArray(); 
           
            $SaleInvoiceProductNew = [];
            foreach ($SaleInvoiceProduct  as $key => $ProductImage) {
                  if(!is_null($ProductImage['invoice_product_image'])){
                    $profile_image = CommonHelper::getS3FileUrl($ProductImage['invoice_product_image']);
                    if($profile_image->status == "success"){
                        $SaleInvoiceProductNew[$key]['id'] = $ProductImage['id'];
                        $SaleInvoiceProductNew[$key]['invoice_id'] = $ProductImage['invoice_id'];
                        $SaleInvoiceProductNew[$key]['product_id'] = $ProductImage['product_id'];
                        $SaleInvoiceProductNew[$key]['invoice_product_image'] = $profile_image->fileUrl;
                    }
                } 
            }

            $InvoiceProduct[$count1]['product_img'] = $SaleInvoiceProductNew;
            $count1++;
        }
       
        $InvoiceGroupProduct = \App\Models\SaleInvoiceProduct::where('sale_invoice_product.invoice_id',$invoice_id);
        $InvoiceGroupProduct->where('sale_invoice_product.invoice_group_id','!=','0');
        $InvoiceGroupProduct->leftjoin('sale_invoice_group','sale_invoice_product.invoice_group_id','sale_invoice_group.id');
        $InvoiceGroupProduct->select('sale_invoice_product.product_id','sale_invoice_product.invoice_group_id','sale_invoice_group.group_name');
        $InvoiceGroupProduct = $InvoiceGroupProduct->get();
        
        $count =0;
        $grpProduct = [];
        foreach ($InvoiceGroupProduct as  $value) {
            $GroupProduct = \App\Models\SaleInvoiceProduct::where('sale_invoice_product.invoice_id',$invoice_id);
            $GroupProduct->where('sale_invoice_product.invoice_group_id',$value['invoice_group_id']);
            $GroupProduct->leftjoin('product_variation','sale_invoice_product.variation_id','product_variation.id');
            $GroupProduct->leftjoin('sale_invoice_group','sale_invoice_product.invoice_group_id','sale_invoice_group.id');
            $GroupProduct->leftjoin('product_services','sale_invoice_product.product_id','product_services.id');
            $GroupProduct->select('sale_invoice_product.*','product_variation.variation_name','sale_invoice_group.group_name','product_services.name as productName');
            $GroupProduct = $GroupProduct->get()->toArray();
            

            $SaleInvoiceProduct = \App\Models\SaleInvoiceProductImage::where('product_id',$value['product_id'])->where('product_id',$value['product_id'])->get()->toArray(); 
           
            $SaleInvoiceProductNew = [];
            foreach ($SaleInvoiceProduct  as $key => $ProductImage) {
                  if(!is_null($ProductImage['invoice_product_image'])){
                    $profile_image = CommonHelper::getS3FileUrl($ProductImage['invoice_product_image']);
                    if($profile_image->status == "success"){
                        $SaleInvoiceProductNew[$key]['id'] = $ProductImage['id'];
                        $SaleInvoiceProductNew[$key]['invoice_id'] = $ProductImage['invoice_id'];
                        $SaleInvoiceProductNew[$key]['product_id'] = $ProductImage['product_id'];
                        $SaleInvoiceProductNew[$key]['invoice_product_image'] = $profile_image->fileUrl;
                    }
                } 
            }

            $grpProduct[$count]['group_name'] = @$value->group_name;
            $grpProduct[$count]['group_details'] = $GroupProduct;
            $grpProduct[$count]['product_img'] = $SaleInvoiceProductNew;
            $count++;
        }


        if(!empty($InvoiceProduct) && !empty($grpProduct)){
            $SaleInvoiceProduct1 = array_merge($InvoiceProduct,$grpProduct);
            $SaleInvoiceProduct =array_map("unserialize", array_unique(array_map("serialize", $SaleInvoiceProduct1)));
        }
        else if(!empty($InvoiceProduct) && empty($grpProduct)){
            $SaleInvoiceProduct = $InvoiceProduct;
        }
        else if(empty($InvoiceProduct) && !empty($grpProduct)){
            $SaleInvoiceProduct = $grpProduct;
        }else{
            $SaleInvoiceProduct = [];
        }
     
        $SaleInvoiceService = \App\Models\SaleInvoiceService::where('invoice_id',$invoice_id)->get(); 
        $SaleInvoiceGroup = \App\Models\SaleInvoiceGroup::where('invoice_id',$invoice_id)->get();
        $SaleInvoiceGroupImg = \App\Models\SaleInvoiceGroupImg::where('invoice_id',$invoice_id)->get();    
        $SaleInvoiceProductImage = \App\Models\SaleInvoiceProductImage::where('invoice_id',$invoice_id)->get();    
        foreach ($SaleInvoiceProductImage as $key => $ProductImage) {
            if(!is_null($ProductImage->invoice_product_image)){
                $profile_image = CommonHelper::getS3FileUrl($ProductImage->invoice_product_image);
                if($profile_image->status == "success"){
                    $ProductImage->invoice_product_image = $profile_image->fileUrl;
                }
            } 
        }
        $SaleInvoiceAddFooter = \App\Models\SaleInvoiceAddFooter::where('invoice_id',$invoice_id)->first();
        if(!is_null($SaleInvoiceAddFooter->footer_img)){
            $profile_image = CommonHelper::getS3FileUrl($SaleInvoiceAddFooter->footer_img);
            if($profile_image->status == "success"){
                $SaleInvoiceAddFooter->footer_img = $profile_image->fileUrl;
            }
        }
        $SaleInvoiceAddLetterhead = \App\Models\SaleInvoiceAddLetterhead::where('invoice_id',$invoice_id)->first();
        if(!is_null($SaleInvoiceAddLetterhead->letterhead_img)){
            $profile_image = CommonHelper::getS3FileUrl($SaleInvoiceAddLetterhead->letterhead_img);
            if($profile_image->status == "success"){
                $SaleInvoiceAddLetterhead->letterhead_img = $profile_image->fileUrl;
            }
        }
        $SaleInvoiceAddPayment = \App\Models\SaleInvoiceAddPayment::where('invoice_id',$invoice_id)->get();
        $SaleInvoiceBusinessDetails = \App\Models\SaleInvoiceBusinessDetails::where('invoice_id',$invoice_id)->get();
        $SaleInvoiceChargeLateFee = \App\Models\SaleInvoiceChargeLateFee::where('invoice_id',$invoice_id)->get();
        $SaleInvoiceClientDetails = \App\Models\SaleInvoiceClientDetails::where('invoice_id',$invoice_id)->get();
        $SaleInvoiceQrCode = \App\Models\SaleInvoiceQrCode::where('invoice_id',$invoice_id)->first();
        $SaleInvoiceShare = \App\Models\SaleInvoiceShare::where('invoice_id',$invoice_id)->get();
        $SaleInvoiceAllBankUpi = \App\Models\SaleInvoiceBankUpi::where('team_id',$team_id)->where('business_id',$getUser->active_business_id)->get();
        $SaleInvoiceAllBankDetails = \App\Models\SaleInvoiceBankDetails::where('team_id',$team_id)->where('business_id',$getUser->active_business_id)->get();

        $SaleInvoiceBankDetails = \App\Models\SaleInvoiceBankDetails::where('team_id',$team_id)->where('business_id',$getUser->active_business_id)->where('is_show',1)->first();
        $SaleInvoiceBankUpi = \App\Models\SaleInvoiceBankUpi::where('team_id',$team_id)->where('business_id',$getUser->active_business_id)->where('is_active',1)->first();
        // Advance setting
        $advanceSetting = \App\Models\SaleInvoiceAdvanceSetting::where('invoice_id',$invoice_id)->first();
        // show hsn code"
        $hsnInvoiceDetails = \App\Models\SaleInvoiceProduct::where('sale_invoice_product.invoice_id',$invoice_id)->get();

        //get product decription
        $getDecription = CommonHelper::getDecription($invoice_id,$row_index_id);
        //get product decription
        $getProductMedia = CommonHelper::getProductMedia($invoice_id,$row_index_id);
         /*SaleInvoiceAttachments*/ 
        $SaleInvoiceAttachments_data = \App\Models\SaleInvoiceAttachments::where('invoice_id',$invoice_id)->get();     
        foreach ($SaleInvoiceAttachments_data as $key => $Attachments) {
            if(!is_null($Attachments->invoice_attachments)){
                $profile_image = CommonHelper::getS3FileUrl($Attachments->invoice_attachments);
                if($profile_image->status == "success"){
                    $Attachments->invoice_attachments = $profile_image->fileUrl;
                }
            } 
        }
        /*SaleInvoiceAddFooter*/ 
        $SaleInvoiceAddFooter = \App\Models\SaleInvoiceAddFooter::where('invoice_id',$invoice_id)->first();     
        if(!is_null($SaleInvoiceAddFooter->footer_img)){
            $profile_image = CommonHelper::getS3FileUrl($SaleInvoiceAddFooter->footer_img);
            if($profile_image->status == "success"){
                $SaleInvoiceAddFooter->footer_img = $profile_image->fileUrl;
            }
        } 
        /*SaleInvoiceAddLetterhead*/ 
        $SaleInvoiceAddLetterhead = \App\Models\SaleInvoiceAddLetterhead::where('invoice_id',$invoice_id)->first();     
        if(!is_null($SaleInvoiceAddLetterhead->letterhead_img)){
            $profile_image = CommonHelper::getS3FileUrl($SaleInvoiceAddLetterhead->letterhead_img);
            if($profile_image->status == "success"){
                $SaleInvoiceAddLetterhead->letterhead_img = $profile_image->fileUrl;
            }
        }
        /*signature_url get*/
        //echo $auth_user->id; exit;
        $SaleInvoiceSetting = \App\Models\SaleInvoiceSetting::where('created_by',$getUser->id);
        $SaleInvoiceSetting->where('business_id',$getUser->active_business_id);
        $SaleInvoiceSetting = $SaleInvoiceSetting->first();
        if(!is_null($SaleInvoiceSetting->s3_signature_url)){
            $profile_image = CommonHelper::getS3FileUrl($SaleInvoiceSetting->s3_signature_url);
            if($profile_image->status == "success"){
                $SaleInvoiceSetting->s3_signature_url = $profile_image->fileUrl;
            }
        }

        $amount_recived_sum =  SaleInvoiceAddPayment::where('invoice_id',@$invoice_id)->sum('amount_received');
        $total_tcs_amount =  SaleInvoiceAddPayment::where('invoice_id',@$invoice_id)->sum('tcs_amount');
        $total_tds_amount =  SaleInvoiceAddPayment::where('invoice_id',@$invoice_id)->sum('tds_amount');
        $total_transaction_charge =  SaleInvoiceAddPayment::where('invoice_id',@$invoice_id)->sum('transaction_charge');
        $amount_recived =  SaleInvoiceAddPayment::where('invoice_id',@$invoice_id)->orderBy('id',"DESC")->first();
        
        if(!empty($saleInvoice->template_id))
        {
            $template_id = $saleInvoice->template_id;

        }else{
            $template_id = 1;
        }
        if(!empty($template_id) && $template_id == 1)
        {
            $pdf = PDF::loadView('pdfFormat.invoice_theme_1',compact('invoice_id','saleInvoice','SaleInvoiceProduct','SaleInvoiceProductImage','SaleInvoiceService','SaleInvoiceGroup','SaleInvoiceGroupImg','SaleInvoiceAddFooter','SaleInvoiceAddLetterhead','SaleInvoiceAddPayment','SaleInvoiceBankUpi','SaleInvoiceBusinessDetails','SaleInvoiceChargeLateFee','SaleInvoiceClientDetails','SaleInvoiceQrCode','SaleInvoiceShare','SaleInvoiceBankDetails','advanceSetting','hsnInvoiceDetails', 'SaleInvoiceAllBankUpi', 'SaleInvoiceAllBankDetails', 'invoice_id','getDecription','getProductMedia','SaleInvoiceAttachments_data','SaleInvoiceSetting','amount_recived_sum','total_transaction_charge', 'total_tcs_amount', 'total_tds_amount','copy'))->setPaper('a4')->setOption('fontDir', public_path('/pdfFont/fonts'));
        }
        if(!empty($template_id) && $template_id == 2)
        {
            $pdf = PDF::loadView('pdfFormat.invoice_theme_2',compact('invoice_id','saleInvoice','SaleInvoiceProduct','SaleInvoiceProductImage','SaleInvoiceService','SaleInvoiceGroup','SaleInvoiceGroupImg','SaleInvoiceAddFooter','SaleInvoiceAddLetterhead','SaleInvoiceAddPayment','SaleInvoiceBankUpi','SaleInvoiceBusinessDetails','SaleInvoiceChargeLateFee','SaleInvoiceClientDetails','SaleInvoiceQrCode','SaleInvoiceShare','SaleInvoiceBankDetails','advanceSetting','hsnInvoiceDetails', 'SaleInvoiceAllBankUpi', 'SaleInvoiceAllBankDetails', 'invoice_id','getDecription','getProductMedia','SaleInvoiceAttachments_data','SaleInvoiceSetting','amount_recived_sum','total_transaction_charge', 'total_tcs_amount', 'total_tds_amount','copy'))->setPaper('a4')->setOption('fontDir', public_path('/pdfFont/fonts'));
        }
        if(!empty($template_id) && $template_id == 3)
        {
            $pdf = PDF::loadView('pdfFormat.invoice_theme_3',compact('invoice_id','saleInvoice','SaleInvoiceProduct','SaleInvoiceProductImage','SaleInvoiceService','SaleInvoiceGroup','SaleInvoiceGroupImg','SaleInvoiceAddFooter','SaleInvoiceAddLetterhead','SaleInvoiceAddPayment','SaleInvoiceBankUpi','SaleInvoiceBusinessDetails','SaleInvoiceChargeLateFee','SaleInvoiceClientDetails','SaleInvoiceQrCode','SaleInvoiceShare','SaleInvoiceBankDetails','advanceSetting','hsnInvoiceDetails', 'SaleInvoiceAllBankUpi', 'SaleInvoiceAllBankDetails', 'invoice_id','getDecription','getProductMedia','SaleInvoiceAttachments_data','SaleInvoiceSetting','amount_recived_sum','total_transaction_charge', 'total_tcs_amount', 'total_tds_amount','copy'))->setPaper('a4')->setOption('fontDir', public_path('/pdfFont/fonts'));
        }
        if(!empty($template_id) && $template_id == 4)
        {
            $pdf = PDF::loadView('pdfFormat.invoice_theme_4',compact('invoice_id','saleInvoice','SaleInvoiceProduct','SaleInvoiceProductImage','SaleInvoiceService','SaleInvoiceGroup','SaleInvoiceGroupImg','SaleInvoiceAddFooter','SaleInvoiceAddLetterhead','SaleInvoiceAddPayment','SaleInvoiceBankUpi','SaleInvoiceBusinessDetails','SaleInvoiceChargeLateFee','SaleInvoiceClientDetails','SaleInvoiceQrCode','SaleInvoiceShare','SaleInvoiceBankDetails','advanceSetting','hsnInvoiceDetails', 'SaleInvoiceAllBankUpi', 'SaleInvoiceAllBankDetails', 'invoice_id','getDecription','getProductMedia','SaleInvoiceAttachments_data','SaleInvoiceSetting','amount_recived_sum','total_transaction_charge', 'total_tcs_amount', 'total_tds_amount','copy'))->setPaper('a4')->setOption('fontDir', public_path('/pdfFont/fonts'));
        }
        $name = 'Invoice_' . date('Y-m-d i:h:s');
        //save pdf link

        $fileName = 'Invoice_' . date('Y-m-d i:h:s') . '.pdf';
        $path = 'invoice/invoice_pdf';
        Storage::disk('s3')->put($path.$fileName,$pdf->output());
        $pdfPath = $path.$fileName;
        $update_pdf = SaleInvoice::where('id',$invoice_id)->update(['invoice_pdf' => $pdfPath]);      

        return $pdf->download($name.'.pdf');
    }

    public function SaleInvoiceCheck(Request $request)
    {
        $input = $request->all();
        if($request->hasfile('check_data'))
        {

            $image = $request->file('check_data');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $filename ='public/invoice_pdf/'.rand(100, 999).$image->getClientOriginalName();
            $path = public_path('/invoice_pdf');
            $file_path = $image->move($path, $filename);
            //$input['check_data'] = $filename;
        }
        $dd = File::get($file_path);      
        
        //$pdf = PDF::loadView("'".$dd."'");
        $pdf = PDF::loadHtml($dd);
        $name = 'Invoice_' . date('Y-m-d i:h:s');
        return $pdf->download($name.'.pdf');

    }
   
    /*SaleInvoiceAddColor*/
    public function SaleInvoiceAddColor(Request $request)
    {
        $SaleInvoiceAddcolor = SaleInvoice::where('id',$request->invoice_id)->update(['color' => $request->color]);
       
        if(!empty($SaleInvoiceAddcolor)){
                return response(['status'=>true,'message'=>'Sale invoice color added successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Sale invoice color not added"]);
        }
    } 

    /*SaleInvoiceAddTempalate*/
    public function SaleInvoiceAddTempalate(Request $request)
    {
        $SaleInvoiceAddTempalate = SaleInvoice::where('id',$request->invoice_id)->update(['template_id' => $request->template_id]);
       
        if(!empty($SaleInvoiceAddTempalate)){
                return response(['status'=>true,'message'=>'Sale invoice template added successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Sale invoice template not added"]);
        }
    }
    
    public function SaleInvoiceGetMedia(Request $request)
    {

      $get_product_media = \App\Models\SaleInvoiceProductImage::where('invoice_id',$request->invoice_id);       
       $get_product_media->where('product_row_index',$request->row_index_id);
       $get_product_media = $get_product_media->get();
       foreach ($get_product_media as $key => $product_media) {
            if(!is_null($product_media->invoice_product_image)){
                $profile_image = CommonHelper::getS3FileUrl($product_media->invoice_product_image);
                if($profile_image->status == "success"){
                    $product_media->invoice_product_image = $profile_image->fileUrl;
                }
            } 
        }
       if(!empty($get_product_media)){
                return response(['status'=>true,'message'=>'Media Get successfully..','data' => $get_product_media]);
        }else{

            return response()->json(['status'=>false,'message'=>"Media Get not successfully "]);
        }
    }
    /*SeleinvoiceMediadelete api*/
    public function SaleInvoiceMediadelete($mediad_id)
    {
        $invoice_media = \App\Models\SaleInvoiceProductImage::find($mediad_id);       
        if (empty($invoice_media)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }
        /*S3 Delete code added*/
        if(!empty($invoice_media->invoice_product_image) && $invoice_media->invoice_product_image != '')
        {
            $delete_media = explode('/',$invoice_media->invoice_product_image);
            $file = base64_decode($delete_media['2']);
            $media_delete = Storage::disk('s3')->delete($file);
        }
        /*End s3 delete code*/
        $invoice_media->delete();   
    
        if(!empty($invoice_media)){
                return response(['status'=>true,'message'=>'Sale Invoice media Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    // SaleInvoiceExport
    public function SaleInvoiceExport(Request $request ,$id = '')
    {
        $request['user_id']   = \Crypt::decrypt($id);
        //$request['user_id']   = '24';
        $name = 'invoice_' . date('Y-m-d i:h:s');
        $request = $request->all();
        $getBusinessId = \App\Models\User::where('id',$request['user_id'])->first();
        $request['business_id'] = $getBusinessId['active_business_id'];
        if(!empty($request) && $request['id'] != '')
        {
            $data = Excel::download(new SaleInvoiceExport($request), $name . '.xlsx'); ob_end_clean();
        }else{
            $data = Excel::download(new SaleInvoiceExport($request), $name . '.xlsx'); ob_end_clean();

        }

        return $data;
    }
        
}