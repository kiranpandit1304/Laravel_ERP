<?php

namespace App\Helpers;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;


class CommonHelper
{
    /**
     * This function for upload any files on S3 bucket
     * Params: we have used 3 params here
     * First: For request, 
     * Second: For form file input name, 
     * Third: For folder path where we need to upload this file
     */
    public static function s3UploadFiles(Request $request, $key = NULL, $folderPath = NULL)
    {
        try {
            $fileName = $request->file($key)->store($folderPath,'s3');
            $fileUrl = env('AWS_S3_URL') . $fileName;
            return (object)array("status" => "success", "fileUrl" => $fileName);
        } catch (\Exception $e) {
            return (object)array("status" => "error", "message" => $e->getMessage());
        }
    }
    /*Mutiple file*/
    public static function s3UploadFilesMultiple($images, $key = NULL, $folderPath = NULL)
    {
        try {
            if(!empty($images) && $images != 'undefined')
            {
                $fileName = $images->store($folderPath,'s3');
                $fileUrl = env('AWS_S3_URL') . $fileName;
                return (object)array("status" => "success", "fileUrl" => $fileName);
            }
        } catch (\Exception $e) {
            return (object)array("status" => "error", "message" => $e->getMessage());
        }
    }

    /*Singel file*/
    public static function s3UploadFilesSingel($images, $key = NULL, $folderPath = NULL)
    {
       /* echo "<pre>";
        print_r($images);exit;*/
        try {
            $fileName = $images->store($folderPath,'s3');
            $fileUrl = env('AWS_S3_URL') . $fileName;
            return (object)array("status" => "success", "fileUrl" => $fileName);
        } catch (\Exception $e) {
            return (object)array("status" => "error", "message" => $e->getMessage());
        }
    }

    /**
     * This function is for to retrive signature path from S3 bucket
     * @param $filename = need to pass only file name with folder structure like: images/users/profile/abcd.jpg
     */
    public static function getS3FileUrl($fileName = NULL){
        try {
            $s3 = \Storage::disk('s3');
            $client = $s3->getDriver()->getAdapter()->getClient();
            $expiry = env('AWS_S3_FILE_EXPIRY');
    
            $command = $client->getCommand('GetObject', [
                'Bucket' => env('AWS_BUCKET'),
                'Key'    => $fileName
            ]);
    
            $request = $client->createPresignedRequest($command, $expiry);

            return (object)array('status' => "success", "fileUrl" => (string) $request->getUri());

        } catch (\Exception $e) {

            return (object)array("status" => "error", "message" => $e->getMessage());

        }
    }

    /*getDecription*/
    public static function getDecription($invoice_id,$row_index_id)
    {
       $get_decription = \App\Models\SaleInvoiceProduct::where('invoice_id',$invoice_id);
       $get_decription->where('product_row_index',$row_index_id);
       $get_decription = $get_decription->first();

       return $get_decription;

    }

    /*getDecription*/
    public static function getProductMedia($invoice_id,$row_index_id,$field_product_id = '',$add_original_images = '')
    {
       $get_product_media = \App\Models\SaleInvoiceProductImage::where('invoice_id',$invoice_id);       
       $get_product_media->where('product_row_index',$row_index_id);
       $get_product_media = $get_product_media->get();
       foreach ($get_product_media as $key => $product_media) {
            if(!is_null($product_media->invoice_product_image)){
                $profile_image = CommonHelper::getS3FileUrl($product_media->invoice_product_image);
                if($profile_image->status == "success"){
                    $product_media->invoice_product_image = $profile_image->fileUrl;
                }
            } 
        }
        /*$field_product_id = 26;
        $add_original_images = 1;*/
        if(!empty($add_original_images) && $add_original_images == '1')
        {
           $get_original_images = \App\Models\ProductImage::where('product_id',$field_product_id);
           $get_original_images = $get_original_images->get();
               foreach ($get_original_images as $key => $product_media) {
                if(!is_null($product_media->product_image)){
                    $profile_image = CommonHelper::getS3FileUrl($product_media->product_image);
                    if($profile_image->status == "success"){
                        $product_media->product_image = $profile_image->fileUrl;
                    }
                } 
            }

        }
        $data['get_product_media'] = $get_product_media;
        $data['get_original_images'] = $get_original_images;
        
       /* echo "<pre>";
        print_r($data); exit;*/

       return $data;

    }

    // get sale invoice pdf
    public static function getSaleInvoicePdf($invoice_id)
    {
        $saleInvoice = \App\Models\SaleInvoice::where('id',$invoice_id)->select('id','invoice_pdf')->first();
        if(!is_null($saleInvoice->invoice_pdf)){
            $profile_image = CommonHelper::getS3FileUrl($saleInvoice->invoice_pdf);
            if($profile_image->status == "success"){
                $saleInvoice->invoice_pdf = $profile_image->fileUrl;
            }
        } 

        return $saleInvoice;
    }
   
   //CreateInvoicePdf
    public static function CreateInvoicePdf($invoice)
    {
        $invoice_id = $invoice->id; 
        //echo $invoice_id; exit;
        $getUser =  \App\Models\User::where('id',\Auth::user()->id)->first();
        $team_id =  $getUser->parent_id;
        if ($getUser->parent_id == 0) {
            $team_id = $getUser->id;
        }
        $sale_invoice_list = \App\Models\SaleInvoice::where('sale_invoice.id', $invoice_id);
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

        $amount_recived_sum =  \App\Models\SaleInvoiceAddPayment::where('invoice_id',@$invoice_id)->sum('amount_received');
        $total_tcs_amount =  \App\Models\SaleInvoiceAddPayment::where('invoice_id',@$invoice_id)->sum('tcs_amount');
        $total_tds_amount =  \App\Models\SaleInvoiceAddPayment::where('invoice_id',@$invoice_id)->sum('tds_amount');
        $total_transaction_charge =  \App\Models\SaleInvoiceAddPayment::where('invoice_id',@$invoice_id)->sum('transaction_charge');
        $amount_recived =  \App\Models\SaleInvoiceAddPayment::where('invoice_id',@$invoice_id)->orderBy('id',"DESC")->first();
        
        if(!empty($saleInvoice->template_id))
        {
            $template_id = $saleInvoice->template_id;

        }else{
            $template_id = 1;
        }
        if(!empty($template_id) && $template_id == 1)
        {
            $pdf = \PDF::loadView('pdfFormat.invoice_theme_1',compact('invoice_id','saleInvoice','SaleInvoiceProduct','SaleInvoiceProductImage','SaleInvoiceService','SaleInvoiceGroup','SaleInvoiceGroupImg','SaleInvoiceAddFooter','SaleInvoiceAddLetterhead','SaleInvoiceAddPayment','SaleInvoiceBankUpi','SaleInvoiceBusinessDetails','SaleInvoiceChargeLateFee','SaleInvoiceClientDetails','SaleInvoiceQrCode','SaleInvoiceShare','SaleInvoiceBankDetails','advanceSetting','hsnInvoiceDetails', 'SaleInvoiceAllBankUpi', 'SaleInvoiceAllBankDetails', 'invoice_id','getDecription','getProductMedia','SaleInvoiceAttachments_data','SaleInvoiceSetting','amount_recived_sum','total_transaction_charge', 'total_tcs_amount', 'total_tds_amount','copy'))->setPaper('a4')->setOption('fontDir', public_path('/pdfFont/fonts'));
        }
        if(!empty($template_id) && $template_id == 2)
        {
            $pdf = \PDF::loadView('pdfFormat.invoice_theme_2',compact('invoice_id','saleInvoice','SaleInvoiceProduct','SaleInvoiceProductImage','SaleInvoiceService','SaleInvoiceGroup','SaleInvoiceGroupImg','SaleInvoiceAddFooter','SaleInvoiceAddLetterhead','SaleInvoiceAddPayment','SaleInvoiceBankUpi','SaleInvoiceBusinessDetails','SaleInvoiceChargeLateFee','SaleInvoiceClientDetails','SaleInvoiceQrCode','SaleInvoiceShare','SaleInvoiceBankDetails','advanceSetting','hsnInvoiceDetails', 'SaleInvoiceAllBankUpi', 'SaleInvoiceAllBankDetails', 'invoice_id','getDecription','getProductMedia','SaleInvoiceAttachments_data','SaleInvoiceSetting','amount_recived_sum','total_transaction_charge', 'total_tcs_amount', 'total_tds_amount','copy'))->setPaper('a4')->setOption('fontDir', public_path('/pdfFont/fonts'));
        }
        if(!empty($template_id) && $template_id == 3)
        {
            $pdf = \PDF::loadView('pdfFormat.invoice_theme_3',compact('invoice_id','saleInvoice','SaleInvoiceProduct','SaleInvoiceProductImage','SaleInvoiceService','SaleInvoiceGroup','SaleInvoiceGroupImg','SaleInvoiceAddFooter','SaleInvoiceAddLetterhead','SaleInvoiceAddPayment','SaleInvoiceBankUpi','SaleInvoiceBusinessDetails','SaleInvoiceChargeLateFee','SaleInvoiceClientDetails','SaleInvoiceQrCode','SaleInvoiceShare','SaleInvoiceBankDetails','advanceSetting','hsnInvoiceDetails', 'SaleInvoiceAllBankUpi', 'SaleInvoiceAllBankDetails', 'invoice_id','getDecription','getProductMedia','SaleInvoiceAttachments_data','SaleInvoiceSetting','amount_recived_sum','total_transaction_charge', 'total_tcs_amount', 'total_tds_amount','copy'))->setPaper('a4')->setOption('fontDir', public_path('/pdfFont/fonts'));
        }
        if(!empty($template_id) && $template_id == 4)
        {
            $pdf = \PDF::loadView('pdfFormat.invoice_theme_4',compact('invoice_id','saleInvoice','SaleInvoiceProduct','SaleInvoiceProductImage','SaleInvoiceService','SaleInvoiceGroup','SaleInvoiceGroupImg','SaleInvoiceAddFooter','SaleInvoiceAddLetterhead','SaleInvoiceAddPayment','SaleInvoiceBankUpi','SaleInvoiceBusinessDetails','SaleInvoiceChargeLateFee','SaleInvoiceClientDetails','SaleInvoiceQrCode','SaleInvoiceShare','SaleInvoiceBankDetails','advanceSetting','hsnInvoiceDetails', 'SaleInvoiceAllBankUpi', 'SaleInvoiceAllBankDetails', 'invoice_id','getDecription','getProductMedia','SaleInvoiceAttachments_data','SaleInvoiceSetting','amount_recived_sum','total_transaction_charge', 'total_tcs_amount', 'total_tds_amount','copy'))->setPaper('a4')->setOption('fontDir', public_path('/pdfFont/fonts'));
        }
        $name = 'Invoice_' . date('Y-m-d i:h:s');
        //save pdf link

        $fileName = 'Invoice_' . date('Y-m-d i:h:s') . '.pdf';
        $path = 'invoice/invoice_pdf';
        \Storage::disk('s3')->put($path.$fileName,$pdf->output());
        $pdfPath = $path.$fileName;
        $update_pdf = \App\Models\SaleInvoice::where('id',$invoice_id)->update(['invoice_pdf' => $pdfPath]);      

        //return $pdf->download($name.'.pdf');
        return $saleInvoice;
    }
}
