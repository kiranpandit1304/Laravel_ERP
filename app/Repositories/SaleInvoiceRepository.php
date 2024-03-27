<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\SaleInvoice;
use App\Models\SaleInvoiceAttachments;
use App\Models\SaleInvoiceProduct;
use App\Models\SaleInvoiceProductImage;
use App\Models\SaleInvoiceService;
use App\Models\SaleInvoiceAdvanceSetting;
use App\Models\SaleInvoiceFields;
use App\Models\SaleInvoiceGroup;
use App\Models\SaleInvoiceGroupImg;
use App\Models\SaleInvoiceLabelChange;
use File;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper; 

/**
 * Class Profilepository
 */
class SaleInvoiceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        
    ];

    /**
     * @var string[]
     */
    protected $allowedFields = [
        'name',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return SaleInvoice::class;
    }

    public function sale_invoice_list()
    {
        $sale_invoice_list = SaleInvoice::where('sale_invoice.business_id',\Auth::user()->active_business_id);
        $sale_invoice_list->leftjoin('sale_invoice_advance_setting','sale_invoice.id','sale_invoice_advance_setting.invoice_id');
        $sale_invoice_list->leftjoin('sale_invoice_fields','sale_invoice.id','sale_invoice_fields.invoice_id');
        $sale_invoice_list->select('sale_invoice.*','sale_invoice_advance_setting.invoice_id','sale_invoice_advance_setting.number_format','sale_invoice_advance_setting.invoice_country','sale_invoice_advance_setting.decimal_digit_format','sale_invoice_advance_setting.hide_place_of_supply','sale_invoice_advance_setting.hsn_column_view','sale_invoice_advance_setting.show_hsn_summary','sale_invoice_advance_setting.add_original_images','sale_invoice_advance_setting.show_description_in_full_width','sale_invoice_fields.filed_data');
        $sale_invoice_list = $sale_invoice_list->get();
        //$serviceList->where('sale_invoice.platform',\Auth::user()->platform);
        //$sale_invoiceList->where('sale_invoice.guard',\Auth::user()->guard); 
        $count =0;
        foreach ($sale_invoice_list as $value) {
            if(!is_null($value->business_logo)){
                $profile_image = CommonHelper::getS3FileUrl($value->business_logo);
                if($profile_image->status == "success"){
                    $value->business_logo = $profile_image->fileUrl;
                }
            }  
            if(!is_null($value->signature)){
                $profile_image = CommonHelper::getS3FileUrl($value->signature);
                if($profile_image->status == "success"){
                    $value->signature = $profile_image->fileUrl;
                }
            } 
        /*SaleInvoiceAttachments*/ 
        $SaleInvoiceAttachments_data = SaleInvoiceAttachments::where('invoice_id',$value['id'])->get();     
        foreach ($SaleInvoiceAttachments_data as $key => $Attachments) {
            if(!is_null($Attachments->invoice_attachments)){
                $profile_image = CommonHelper::getS3FileUrl($Attachments->invoice_attachments);
                if($profile_image->status == "success"){
                    $Attachments->invoice_attachments = $profile_image->fileUrl;
                }
            } 
        }
        $SaleInvoiceProduct = SaleInvoiceProduct::where('invoice_id',$value['id'])->get();     
        $SaleInvoiceProductImage = SaleInvoiceProductImage::where('invoice_id',$value['id'])->get();     
        foreach ($SaleInvoiceProductImage as $key => $ProductImage) {
            if(!is_null($ProductImage->invoice_product_image)){
                $profile_image = CommonHelper::getS3FileUrl($ProductImage->invoice_product_image);
                if($profile_image->status == "success"){
                    $ProductImage->invoice_product_image = $profile_image->fileUrl;
                }
            } 
        }
        $SaleInvoiceService = SaleInvoiceService::where('invoice_id',$value['id'])->get();
        $SaleInvoiceGroup = SaleInvoiceGroup::where('invoice_id',$value['id'])->get();
        $SaleInvoiceGroupImg = SaleInvoiceGroupImg::where('invoice_id',$value['id'])->get();

        $sale_invoice_list_data[$count] = $value; 
        $sale_invoice_list_data[$count]['SaleInvoiceAttachments'] = $SaleInvoiceAttachments_data; 
        $sale_invoice_list_data[$count]['SaleInvoiceProduct'] = $SaleInvoiceProduct; 
        $sale_invoice_list_data[$count]['SaleInvoiceProductImage'] = $SaleInvoiceProductImage; 
        $sale_invoice_list_data[$count]['SaleInvoiceProductImage'] = $SaleInvoiceProductImage; 
        $sale_invoice_list_data[$count]['SaleInvoiceGroup'] = $SaleInvoiceGroup; 
        $sale_invoice_list_data[$count]['SaleInvoiceGroupImg'] = $SaleInvoiceGroupImg;         
        $sale_invoice_list_data[$count]['SaleInvoiceService'] = $SaleInvoiceService; 
        $count++;
        }

        return $sale_invoice_list_data;
    }
    public function sale_invoice_show($id)
    {
        $sale_invoice_list = SaleInvoice::where('sale_invoice.id',$id);
        $sale_invoice_list->leftjoin('sale_invoice_advance_setting','sale_invoice.id','sale_invoice_advance_setting.invoice_id');
        $sale_invoice_list->leftjoin('sale_invoice_fields','sale_invoice.id','sale_invoice_fields.invoice_id');
        $sale_invoice_list->select('sale_invoice.*','sale_invoice_advance_setting.invoice_id','sale_invoice_advance_setting.number_format','sale_invoice_advance_setting.invoice_country','sale_invoice_advance_setting.decimal_digit_format','sale_invoice_advance_setting.hide_place_of_supply','sale_invoice_advance_setting.hsn_column_view','sale_invoice_advance_setting.show_hsn_summary','sale_invoice_advance_setting.add_original_images','sale_invoice_advance_setting.show_description_in_full_width','sale_invoice_fields.filed_data');
        $sale_invoice_show = $sale_invoice_list->first();

        return $sale_invoice_show;
    }

    public function sale_invoice_last_record_show()
    {

        $sale_invoice_list = SaleInvoice::where('sale_invoice.business_id',\Auth::user()->active_business_id);
        $sale_invoice_list->where('sale_invoice.created_by',\Auth::user()->id);
        $sale_invoice_list->leftjoin('sale_invoice_advance_setting','sale_invoice.id','sale_invoice_advance_setting.invoice_id');
        $sale_invoice_list->leftjoin('sale_invoice_fields','sale_invoice.id','sale_invoice_fields.invoice_id');
        $sale_invoice_list->leftjoin('sale_invoice_label_change','sale_invoice.id','sale_invoice_label_change.invoice_id');
        $sale_invoice_list->select('sale_invoice.*','sale_invoice_advance_setting.invoice_id','sale_invoice_advance_setting.number_format','sale_invoice_advance_setting.invoice_country','sale_invoice_advance_setting.decimal_digit_format','sale_invoice_advance_setting.hide_place_of_supply','sale_invoice_advance_setting.hsn_column_view','sale_invoice_advance_setting.show_hsn_summary','sale_invoice_advance_setting.add_original_images','sale_invoice_advance_setting.show_description_in_full_width','sale_invoice_fields.filed_data','sale_invoice_label_change.label_invoice_no','sale_invoice_label_change.label_invoice_date','sale_invoice_label_change.label_invoice_due_date','sale_invoice_label_change.label_invoice_billed_by','sale_invoice_label_change.label_invoice_billed_to','sale_invoice_label_change.label_invoice_shipped_from','sale_invoice_label_change.label_invoice_shipped_to','sale_invoice_label_change.label_invoice_transport_details','sale_invoice_label_change.label_invoice_challan_no','sale_invoice_label_change.label_invoice_challan_date','sale_invoice_label_change.label_invoice_transport','sale_invoice_label_change.label_invoice_extra_information','sale_invoice_label_change.label_invoice_terms_and_conditions','sale_invoice_label_change.label_invoice_additional_notes','sale_invoice_label_change.label_invoice_attachments');
        $sale_invoice_list->orderBy('sale_invoice.id','DESC');
        $sale_invoice_show = $sale_invoice_list->first();      

        return $sale_invoice_show;
    }

    public function sale_invoice_add($input)
    {
        try 
        { 
            /*echo "<pre>";
            print_r($input);
            //print_r(json_decode($input['product_array']));
            exit;*/
            $requestData = new SaleInvoice;
            $requestData->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
            $requestData->guard  =    (!empty($input['guard']) ? $input['guard'] : '');
            $requestData->business_id  =    (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');
            $requestData->invoice_title  =    (!empty($input['invoice_title']) ? $input['invoice_title'] : '');
            $requestData->invoice_sub_title  =    (!empty($input['invoice_sub_title']) ? $input['invoice_sub_title'] : '');
            $requestData->invoice_no  =    (!empty($input['invoice_no']) ? $input['invoice_no'] : '');
            $requestData->invoice_date  =    (!empty($input['invoice_date']) ? $input['invoice_date'] : '');
            $requestData->due_date  =    (!empty($input['due_date']) ? $input['due_date'] : '');
            if(!empty($input['invoice_custome_filed_key']))
            {
                $invoice_custome_filed_data = [];
                for($i = 0; $i < count($input['invoice_custome_filed_key']); $i++)
                {
                    if(!empty($input['invoice_custome_filed_key'][$i]) && !empty($input['invoice_custome_filed_value'][$i])){
                      $invoice_custome_filed_data[$i]['key'] = $input['invoice_custome_filed_key'][$i];
                      $invoice_custome_filed_data[$i]['value'] = $input['invoice_custome_filed_value'][$i];
                    }
                }                
                $requestData->invoice_custome_filed  =    json_encode($invoice_custome_filed_data);
            }
            if (!empty($input['business_logo']) && $input['business_logo'] != 'undefined') 
            {
                $errorMessages = array();            
                $imgResponse = CommonHelper::s3UploadFilesSingel($input['business_logo'], 'business_logo', BUSINESLOGO);
                if($imgResponse->status == "success"){
                     $requestData->business_logo = $imgResponse->fileUrl;
                     $requestData->business_logo_name = @$input['business_logo']->getClientOriginalName();
                }else{
                    $errorMessages[]= $imgResponse->message;
                }
            }
            
            $requestData->e_invoice_details  =    (!empty($input['e_invoice_details']) ? $input['e_invoice_details'] : '');
            $requestData->company_id  =    (!empty($input['company_id']) ? $input['company_id'] : '');
            $requestData->company_name  =    (!empty($input['company_name']) ? $input['company_name'] : '');
            $requestData->company_address  =    (!empty($input['company_address']) ? $input['company_address'] : '');
            $requestData->customer_id  =    (!empty($input['customer_id']) ? $input['customer_id'] : '');
            $requestData->customer_name  =    (!empty($input['customer_name']) ? $input['customer_name'] : '');
            $requestData->customer_address  =    (!empty($input['customer_address']) ? $input['customer_address'] : '');
            if(!empty($input['is_shipping_detail_req'])){
                $requestData->is_shipping_detail_req   =    $input['is_shipping_detail_req'];
            }
            $requestData->shipped_from_name  =    (!empty($input['shipped_from_name']) ? $input['shipped_from_name'] : '');
            $requestData->shipped_from_country_id  =    (!empty($input['shipped_from_country_id']) ? $input['shipped_from_country_id'] : '');
            $requestData->shipped_from_country_name  =    (!empty($input['shipped_from_country_name']) ? $input['shipped_from_country_name'] : '');
            $requestData->shipped_from_address  =    (!empty($input['shipped_from_address']) ? $input['shipped_from_address'] : '');
            $requestData->shipped_from_city  =    (!empty($input['shipped_from_city']) ? $input['shipped_from_city'] : '');
            $requestData->shipped_from_zip_code  =    (!empty($input['shipped_from_zip_code']) ? $input['shipped_from_zip_code'] : '');
            $requestData->shipped_from_state_name  =    (!empty($input['shipped_from_state_name']) ? $input['shipped_from_state_name'] : '');
            $requestData->shipped_to_id  =    (!empty($input['shipped_to_id']) ? $input['shipped_to_id'] : '');
            $requestData->shipped_to_name  =    (!empty($input['shipped_to_name']) ? $input['shipped_to_name'] : '');
            $requestData->shipped_to_country_id  =    (!empty($input['shipped_to_country_id']) ? $input['shipped_to_country_id'] : '');
            $requestData->shipped_to_country_name  =    (!empty($input['shipped_to_country_name']) ? $input['shipped_to_country_name'] : '');
            $requestData->shipped_to_address  =    (!empty($input['shipped_to_address']) ? $input['shipped_to_address'] : '');
            $requestData->shipped_to_city  =    (!empty($input['shipped_to_city']) ? $input['shipped_to_city'] : '');
            $requestData->shipped_to_zip_code  =    (!empty($input['shipped_to_zip_code']) ? $input['shipped_to_zip_code'] : '');
            $requestData->shipped_to_state_name  =    (!empty($input['shipped_to_state_name']) ? $input['shipped_to_state_name'] : '');
            $requestData->transport_challan  =    (!empty($input['transport_challan']) ? $input['transport_challan'] : '');
            $requestData->transport_challan_date  =    (!empty($input['transport_challan_date']) ? $input['transport_challan_date'] : '');
            $requestData->transport_name  =    (!empty($input['transport_name']) ? $input['transport_name'] : '');
            $requestData->transport_information  =    (!empty($input['transport_information']) ? $input['transport_information'] : '');
            
            $requestData->billing_from_country_id  =    (!empty($input['billing_from_country_id']) ? $input['billing_from_country_id'] : '');
            $requestData->billing_from_country_name  =    (!empty($input['billing_from_country_name']) ? $input['billing_from_country_name'] : '');
            $requestData->billing_from_address  =    (!empty($input['billing_from_address']) ? $input['billing_from_address'] : '');
            $requestData->billing_from_city  =    (!empty($input['billing_from_city']) ? $input['billing_from_city'] : '');
            $requestData->billing_from_zip_code  =    (!empty($input['billing_from_zip_code']) ? $input['billing_from_zip_code'] : '');
            $requestData->billing_from_state_name  =    (!empty($input['billing_from_state_name']) ? $input['billing_from_state_name'] : '');
                
            $requestData->billing_to_country_id  =    (!empty($input['billing_to_country_id']) ? $input['billing_to_country_id'] : '');
            $requestData->billing_to_country_name  =    (!empty($input['billing_to_country_name']) ? $input['billing_to_country_name'] : '');
            $requestData->billing_to_address  =    (!empty($input['billing_to_address']) ? $input['billing_to_address'] : '');
            $requestData->billing_to_city  =    (!empty($input['billing_to_city']) ? $input['billing_to_city'] : '');
            $requestData->billing_to_zip_code  =    (!empty($input['billing_to_zip_code']) ? $input['billing_to_zip_code'] : '');
            $requestData->billing_to_state_name  =    (!empty($input['billing_to_state_name']) ? $input['billing_to_state_name'] : '');
            if(!empty($input['shipped_to_custome_filed_key']))
            {
                $shipped_to_custome_filed_data = [];
                for($i = 0; $i < count($input['shipped_to_custome_filed_key']); $i++)
                {
                    if(!empty($input['shipped_to_custome_filed_key']) && !empty($input['shipped_to_custome_filed_value'][$i])){
                      
                      $shipped_to_custome_filed_data[$i]['key'] = $input['shipped_to_custome_filed_key'][$i];
                      $shipped_to_custome_filed_data[$i]['value'] = $input['shipped_to_custome_filed_value'][$i];
                    }

                }                
                $requestData->shipped_to_custome_filed  =    json_encode($shipped_to_custome_filed_data);
            }
            $requestData->tax_type  =    (!empty($input['tax_type']) ? $input['tax_type'] : '');
            $requestData->is_tax  =    (!empty($input['is_tax']) ? $input['is_tax'] : '');
            $requestData->currency  =    (!empty($input['currency']) ? $input['currency'] : '');
            $requestData->final_amount  =    (!empty($input['final_amount']) ? $input['final_amount'] : '');
            $requestData->final_sgst  =    (!empty($input['final_sgst']) ? $input['final_sgst'] : '');
            $requestData->final_cgst  =    (!empty($input['final_cgst']) ? $input['final_cgst'] : '');
            $requestData->final_igst  =    (!empty($input['final_igst']) ? $input['final_igst'] : '');
            $requestData->round_up  =    (!empty($input['round_up']) ? $input['round_up'] : '');
            $requestData->round_down  =    (!empty($input['round_down']) ? $input['round_down'] : '');
            $requestData->final_product_wise_discount  =   (!empty($input['final_product_wise_discount']) ? $input['final_product_wise_discount'] : '');
            $requestData->final_total_discount_reductions  =   (!empty($input['final_total_discount_reductions']) ? $input['final_total_discount_reductions'] : '');
            $requestData->final_total_discount_reductions_unit  =   (!empty($input['final_total_discount_reductions_unit']) ? $input['final_total_discount_reductions_unit'] : '');
            $requestData->final_extra_charges  =    (!empty($input['final_extra_charges']) ? $input['final_extra_charges'] : '');
            $requestData->extra_changes_unit  =    (!empty($input['extra_changes_unit']) ? $input['extra_changes_unit'] : '');
            $requestData->final_summarise_total_quantity  =    (!empty($input['final_summarise_total_quantity']) ? $input['final_summarise_total_quantity'] : '');
            $requestData->final_total  =    (!empty($input['final_total']) ? $input['final_total'] : '');
            if(!empty($input['final_total_more_field_key']))
            {
                $final_total_more_field_data = [];
                for($i = 0; $i < count($input['final_total_more_field_key']); $i++)
                {
                    if(!empty($input['final_total_more_field_key']) && !empty($input['final_total_more_field_value'][$i])){
                      
                      $final_total_more_field_data[$i]['key'] = $input['final_total_more_field_key'][$i];
                      $final_total_more_field_data[$i]['value'] = $input['final_total_more_field_value'][$i];
                    }

                }                
                $requestData->final_total_more_filed  =    json_encode($final_total_more_field_data);
            }
            $requestData->final_total_words  =    (!empty($input['final_total_words']) ? $input['final_total_words'] : '');
            /*$requestData->additional_notes  =    (!empty($input['additional_notes']) ? $input['additional_notes'] : '');
            if(!empty($input['is_total_words_show'])){
                $requestData->is_total_words_show   =  $input['is_total_words_show'];
            }
            if(!empty($input['is_terms_req'])){
                $requestData->is_terms_req   =  $input['is_terms_req'];
            }
            if(!empty($input['is_additional_notes_req'])){
                $requestData->is_additional_notes_req   =  $input['is_additional_notes_req'];
            }
            if(!empty($input['is_attactments_req'])){
                $requestData->is_attactments_req   =  $input['is_attactments_req'];
            }
            if(!empty($input['is_additional_info_req'])){
                $requestData->is_additional_info_req   =  $input['is_additional_info_req'];
            }
            if(!empty($input['terms_and_conditions_value']))
            {
                $terms_and_conditions_data = [];
                for($i = 0; $i < count($input['terms_and_conditions_value']); $i++)
                {
                    if(!empty($input['terms_and_conditions_value'][$i]) && $input['terms_and_conditions_value'][$i] != "'Write here..'"){
                      $terms_and_conditions_data[$i] = $input['terms_and_conditions_value'][$i];
                    }
                } 
                $requestData->terms_and_conditions  =    json_encode($terms_and_conditions_data);
            }
            if(!empty($input['add_additional_info_key']))
            {              
                $add_additional_info_data = [];
                for($i = 0; $i < count($input['add_additional_info_key']); $i++)
                {
                    if(!empty($input['add_additional_info_key'][$i]) && !empty($input['add_additional_info_value'][$i])){
                      $add_additional_info_data[$i]['key'] = $input['add_additional_info_key'][$i];
                      $add_additional_info_data[$i]['value'] = $input['add_additional_info_value'][$i];
                    }
                } 
                $requestData->add_additional_info  =    json_encode($add_additional_info_data);
            }
            $requestData->contact_details  =     (!empty($input['contact_details']) ? $input['contact_details'] : '');
            if(!empty($input['is_contact_show'])){
                $requestData->is_contact_show   =  $input['is_contact_show'];
            }*/
            $requestData->final_total_words  =    (!empty($input['final_total_words']) ? $input['final_total_words'] : '');
            
            if(!empty($input['is_total_words_show'])){
                $requestData->is_total_words_show   =  $input['is_total_words_show'];
            }
            $requestData->is_terms_req   =  $input['is_terms_req'];
            if(!empty($input['is_terms_req']) && $input['is_terms_req'] == 1){
                if(!empty($input['terms_and_conditions_value']))
                {
                    $terms_and_conditions_data = [];
                    for($i = 0; $i < count($input['terms_and_conditions_value']); $i++)
                    {
                        if(!empty($input['terms_and_conditions_value'][$i]) && $input['terms_and_conditions_value'][$i] != "'Write here..'"){
                          $terms_and_conditions_data[$i] = $input['terms_and_conditions_value'][$i];
                        }
                    } 
                    $requestData->terms_and_conditions  =    json_encode($terms_and_conditions_data);

                }
            }
            $requestData->is_additional_notes_req   =  $input['is_additional_notes_req'];
            $requestData->is_attactments_req   =  $input['is_attactments_req'];
            if(!empty($input['is_additional_notes_req']) && $input['is_additional_notes_req'] == 1){
                $requestData->additional_notes  =    (!empty($input['additional_notes']) ? $input['additional_notes'] : '');
            }
            $requestData->is_additional_info_req   =  $input['is_additional_info_req'];
            if(!empty($input['is_additional_info_req']) && $input['is_additional_notes_req'] == 1){
                if(!empty($input['add_additional_info_key']))
                {              
                    $add_additional_info_data = [];
                    for($i = 0; $i < count($input['add_additional_info_key']); $i++)
                    {
                        if(!empty($input['add_additional_info_key'][$i]) && !empty($input['add_additional_info_value'][$i])){
                          $add_additional_info_data[$i]['key'] = $input['add_additional_info_key'][$i];
                          $add_additional_info_data[$i]['value'] = $input['add_additional_info_value'][$i];
                        }
                    } 
                    $requestData->add_additional_info  =    json_encode($add_additional_info_data);
                }
            }        
            $requestData->is_contact_show   =  $input['is_contact_show'];
            if(!empty($input['is_contact_show']) && $input['is_contact_show'] == 1){
                $requestData->contact_details  =     (!empty($input['contact_details']) ? $input['contact_details'] : '');
            }
            /*add team id*/
            if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
            {
                $requestData->team_id = \Auth::user()->parent_id;
            }else{
                $requestData->team_id = \Auth::user()->id;
            }
            /*end*/
            $requestData->created_by = \Auth::user()->id;
            $requestData->business_id   =    (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');
            $requestData->save();
            /*Change Number Format*/
            $ChangeNumberFormat = new SaleInvoiceAdvanceSetting;
            $ChangeNumberFormat->invoice_id = (!empty($requestData['id']) ? $requestData['id'] : '');
            $ChangeNumberFormat->number_format = (!empty($input['number_format']) ? $input['number_format'] : '');
            $ChangeNumberFormat->invoice_country = (!empty($input['invoice_country']) ? $input['invoice_country'] : '');
            $ChangeNumberFormat->decimal_digit_format = (!empty($input['decimal_digit_format']) ? $input['decimal_digit_format'] : '');
            $ChangeNumberFormat->hide_place_of_supply = (!empty($input['hide_place_of_supply']) ? $input['hide_place_of_supply'] : '');
            $ChangeNumberFormat->hsn_column_view = (!empty($input['hsn_column_view']) ? $input['hsn_column_view'] : '');
            $ChangeNumberFormat->show_hsn_summary = (!empty($input['show_hsn_summary']) ? $input['show_hsn_summary'] : '');
            $ChangeNumberFormat->add_original_images = (!empty($input['add_original_images']) ? $input['add_original_images'] : '');
            $ChangeNumberFormat->show_description_in_full_width = (!empty($input['show_description_in_full_width']) ? $input['show_description_in_full_width'] : '');
            $ChangeNumberFormat->created_by = \Auth::user()->id;
            $ChangeNumberFormat->save();
            /*Add new field and Edit Columns*/
            if(!empty($input['filed_data']))
            {                   
                $SaleInvoiceFields = new SaleInvoiceFields;
                $SaleInvoiceFields->invoice_id = (!empty($requestData['id']) ? $requestData['id'] : '');
                $SaleInvoiceFields->filed_data  =    (!empty($input['filed_data']) ? $input['filed_data'] : '');;
                $SaleInvoiceFields->created_by = \Auth::user()->id;
                $SaleInvoiceFields->save();
            }
            /*attachments add multiple*/
            if(!empty($input['is_attactments_req']) && $input['is_attactments_req'] == 1){
                $image = @$input['invoice_attachments'];
                if (!empty($image) && $image != 'undefined') {
                    for ($i = 0; $i < count($image); $i++) {
                        if ($image[$i] != '') {
                            if (isset($image[$i]) && $image[$i] != '') {
                                $errorMessages = array();                                    
                                $imgResponse = CommonHelper::s3UploadFilesMultiple($image[$i], 'invoice_attachments', INVOICE_ATTACHMENTS);
                                if($imgResponse->status == "success"){
                                    $input['invoice_attachments'] = $imgResponse->fileUrl;
                                }else{
                                    $errorMessages[]= $imgResponse->message;
                                }
                                $invoice_attachments['platform'] = (!empty($input['platform']) ? $input['platform'] : '');
                                $invoice_attachments['guard'] = (!empty($input['guard']) ? $input['guard'] : '');
                                $invoice_attachments['invoice_id'] = (!empty($requestData['id']) ? $requestData['id'] : '');
                                $invoice_attachments['created_by'] = \Auth::user()->id;
                                $invoice_attachments['invoice_attachments'] = $input['invoice_attachments'];
                                $invoice_attachments['invoice_attachments_name'] =  @$image[$i]->getClientOriginalName();
                                $requestData1 = SaleInvoiceAttachments::create($invoice_attachments);
                            }
                        }
                    }
                }
            }
            if(!empty($input['product_array']))
            {   
                $product = json_decode($input['product_array']);
                for ($i = 0; $i < count($product); $i++) 
                {
            
                    if(!empty($product[$i]) && $product[$i]->product_id !='')
                    {
                    
                        // check exit group invoice id wise
                        $exit_group = SaleInvoiceGroup::where('invoice_id',$requestData['id'])->where('group_name',$product[$i]->group_name)->first();
                        //echo "<pre>";  print_r($exit_group);  
                        if(empty($exit_group) && $product[$i]->group_name != '')
                        {
                            $SaleInvoiceGroup = new SaleInvoiceGroup;
                            $SaleInvoiceGroup->group_name = (!empty($product[$i]->group_name) ? $product[$i]->group_name : '');
                            $SaleInvoiceGroup->invoice_id = (!empty($requestData['id']) ? $requestData['id'] : '');
                            $SaleInvoiceGroup->created_by = \Auth::user()->id;
                            $SaleInvoiceGroup->save();
                        }
                        //add group wise product
                        $productData = new SaleInvoiceProduct;
                        if(empty($exit_group))
                        {
                            $productData->invoice_group_id = (!empty($SaleInvoiceGroup['id']) ? $SaleInvoiceGroup['id'] : '');
                        }else{
                            $productData->invoice_group_id = (!empty($exit_group['id']) ? $exit_group['id'] : '');

                        }
                        $productData->product_id = (!empty($product[$i]->product_id) ? $product[$i]->product_id : '');
                        $productData->variation_id = (!empty($product[$i]->variation_id) ? $product[$i]->variation_id : '');
                        
                        $productData->product_hsn_code = (!empty($product[$i]->product_hsn_code) ? $product[$i]->product_hsn_code : '');
                        $productData->product_gst_rate = (!empty($product[$i]->product_gst_rate) ? $product[$i]->product_gst_rate : '');
                        $productData->product_quantity = (!empty($product[$i]->product_quantity) ? $product[$i]->product_quantity : '');
                        $productData->product_rate = (!empty($product[$i]->product_rate) ? $product[$i]->product_rate : '');
                        $productData->product_amount = (!empty($product[$i]->product_amount) ? $product[$i]->product_amount : '');
                        $productData->product_discount_type = (!empty($product[$i]->product_discount_type) ? $product[$i]->product_discount_type : '');
                        $productData->product_discount = (!empty($product[$i]->product_discount) ? $product[$i]->product_discount : '');
                        $productData->product_igst = (!empty($product[$i]->product_igst) ? $product[$i]->product_igst : '');
                        $productData->product_cgst = (!empty($product[$i]->product_cgst) ? $product[$i]->product_cgst : '');
                        $productData->product_sgst = (!empty($product[$i]->product_sgst) ? $product[$i]->product_sgst : '');
                        $productData->product_total = (!empty($product[$i]->product_total) ? $product[$i]->product_total : '');
                        $productData->product_description = (!empty($product[$i]->product_description) ? $product[$i]->product_description : '');
                        $productData->product_row_index = (!empty($product[$i]->product_row_index) ? $product[$i]->product_row_index : '');
                        //$productData->product_name = (!empty($product[$i]->product_name) ? $product[$i]->product_name : '');
                        $productData->invoice_id = (!empty($requestData['id']) ? $requestData['id'] : '');
                        $productData->tax_type = (!empty($product[$i]->g_tax_type) ? $product[$i]->g_tax_type : '');
                        $productData->description = (!empty($product[$i]->g_description) ? $product[$i]->g_description : '');
                        $productData->created_by = \Auth::user()->id;
                        $productData->product_invoice_details = (!empty($product[$i]->g_product_invoice_details) ? $product[$i]->g_product_invoice_details : '');
                        $productData->save();
                        // stock update
                        $getCurrentStock = \App\Models\AdjustmentItem::where('variation_id',$product[$i]->variation_id)
                                                                    ->where('product_id',$product[$i]->product_id)->first();

                        // Check mange stock flg
                        $productService = \App\Models\ProductService::where('id',$product[$i]->product_id)->first();  
                        if(!empty($productService) && $productService->is_manage_stock != '0') 
                        {                            
                            $stock = @$getCurrentStock->quantity - @$product[$i]->product_quantity;
                            $update_stock = \App\Models\AdjustmentItem::where('variation_id',$product[$i]->variation_id)                            
                                                         ->update(['quantity' => @$stock]);
                        /*update product id*/             
                                $stockHistory = new \App\Models\StockHistory;
                                if(!empty($product[$i]->variation_id))
                                {
                                    $variation_name = \App\Models\ProductVariation::where('id',$product[$i]->variation_id)->first();
                                }
                                $stockHistory->vendor_id = (!empty($input['customer_id']) ? $input['customer_id'] : '');
                                $stockHistory->vendor_client_name = (!empty($input['customer_name']) ? $input['customer_name'] : '');
                                $stockHistory->product_id = (!empty($product[$i]->product_id) ? $product[$i]->product_id : '');
                                $stockHistory->variation_id = (!empty($product[$i]->variation_id) ? $product[$i]->variation_id : '');
                                $stockHistory->variation_name = @$variation_name['variation_name'];
                                $stockHistory->user_type = (!empty($input['user_type']) ? $input['user_type'] : '');
                                if(!empty($input['user_type']) && $input['user_type'] == 'customer')
                                {
                                    $customer = \App\Models\Customer::where('id',$input['vendor_id'])->first();
                                }
                                else if(!empty($input['user_type']) && $input['user_type'] == 'vendor')
                                {
                                    $customer = \App\Models\Vender::where('id',$input['vendor_id'])->first();
                                }
                                $stockHistory->vendor_client_name = (!empty($input['customer_name']) ? $input['customer_name'] : '');;
                                $stockHistory->stock = (!empty($product[$i]->product_quantity) ? $product[$i]->product_quantity : '');
                                $stockHistory->created_by = \Auth::user()->id;
                                $stockHistory->method_type = 2;
                                $stockHistory->stock_date = date('Y-m-d');
                                $stockHistory = $stockHistory->save();
                        }                                      

                        //end stock update
                        //item add mutiple image 
                        if(!empty($input['invoice_product_image']) && $input['invoice_product_image'][$i] != '' && $input['invoice_product_image'][$i] != 'undefined')
                        {
                            $img['id'] = $product[$i]->product_id;
                            $img['invoice_id'] = (!empty($requestData['id']) ? $requestData['id'] : '');
                            $image = @$input['invoice_product_image'][$i];
                            $img['product_row_index'] = @$product[$i]->product_row_index;
                            $this->invoice_product_image($image,$img);
                        }
                        //group img
                        if(!empty($input['invoice_group_image']) && $input['invoice_group_image'][$i] != '' && $input['invoice_group_image'][$i] != 'undefined')
                        {
                            $img['id'] =  $productData->invoice_group_id;
                            $img['invoice_id'] = (!empty($requestData['id']) ? $requestData['id'] : '');
                            $image = @$input['invoice_group_image'][$i];
                            $this->invoice_group_image($image,$img);
                        }
                    }
                } 
            }
            /*
            /*app side if(service id add product)*/
            if (!empty($input['service_id']))
            {
                for ($i = 0; $i < count($input['service_id']); $i++) 
                {
                    $serviceData = new SaleInvoiceService;
                    $serviceData->invoice_id = (!empty($requestData['id']) ? $requestData['id'] : '');
                    $serviceData->service_id = (!empty($input['service_id'][$i]) ? $input['service_id'][$i] : '');
                    $serviceData->business_id = (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');
                    $serviceData->service_name = (!empty($input['service_name'][$i]) ? $input['service_name'][$i] : '');
                    $serviceData->service_sale_price = (!empty($input['service_sale_price'][$i]) ? $input['service_sale_price'][$i] : '');
                    $serviceData->service_item_discount = (!empty($input['service_item_discount'][$i]) ? $input['service_item_discount'][$i] : '');
                    $serviceData->service_final_price = (!empty($input['service_final_price'][$i]) ? $input['service_final_price'][$i] : '');
                    $serviceData->created_by = \Auth::user()->id;;
                    $serviceData->save();                                                     
                }
            }

            // add business details
            $invoice = SaleInvoice::orderBy('id','DESC')->first();
            $SaleInvoiceBusiness = new \App\Models\SaleInvoiceBusinessDetails;
            $SaleInvoiceBusiness->invoice_id  =    (!empty($invoice['id']) ? $invoice['id'] : '');
            $SaleInvoiceBusiness->business_id  =    (!empty($input['business_id']) ? $input['business_id'] : '');
            $SaleInvoiceBusiness->business_name  =    (!empty($input['business_name']) ? $input['business_name'] : '');
            $SaleInvoiceBusiness->business_gst_in  =    (!empty($input['business_gst_in']) ? $input['business_gst_in'] : '');
            $SaleInvoiceBusiness->business_pan_no  =    (!empty($input['business_pan_no']) ? $input['business_pan_no'] : '');
            $SaleInvoiceBusiness->address_country_id =    (!empty($input['business_address_country_id']) ? $input['business_address_country_id'] : '');
            $SaleInvoiceBusiness->address_state_id  =    (!empty($input['business_address_state_id']) ? $input['business_address_state_id'] : '');
            $SaleInvoiceBusiness->business_zip_code  =    (!empty($input['business_zip_code']) ? $input['business_zip_code'] : '');
            $SaleInvoiceBusiness->street_address  =    (!empty($input['business_street_address']) ? $input['business_street_address'] : '');
            $SaleInvoiceBusiness->business_email  =    (!empty($input['business_email']) ? $input['business_email'] : '');
            $SaleInvoiceBusiness->show_email_invoice  =    (!empty($input['business_show_email_invoice']) ? $input['business_show_email_invoice'] : '');
            $SaleInvoiceBusiness->business_phone  =    (!empty($input['business_phone']) ? $input['business_phone'] : '');
            $SaleInvoiceBusiness->show_phone_invoice  =    (!empty($input['business_show_phone_invoice']) ? $input['business_show_phone_invoice'] : '');
            $SaleInvoiceBusiness->current_changes_business  =    (!empty($input['business_current_changes_business']) ? $input['business_current_changes_business'] : '');
            $SaleInvoiceBusiness->created_by  =    \Auth::user()->id;
            $SaleInvoiceBusiness->save();

            //add client detaails
            $SaleInvoiceClient = new \App\Models\SaleInvoiceClientDetails;
            $SaleInvoiceClient->invoice_id  =  (!empty($invoice['id']) ? $invoice['id'] : '');
            $SaleInvoiceClient->client_id  =    (!empty($input['client_id']) ? $input['client_id'] : '');
            $SaleInvoiceClient->name  =    (!empty($input['client_business_name']) ? $input['client_business_name'] : '');
            $SaleInvoiceClient->client_gst_in  =    (!empty($input['client_gst_in']) ? $input['client_gst_in'] : '');
            $SaleInvoiceClient->client_pan_no  =    (!empty($input['client_pan_no']) ? $input['client_pan_no'] : '');
            $SaleInvoiceClient->address_country_id =    (!empty($input['client_address_country_id']) ? $input['client_address_country_id'] : '');
            $SaleInvoiceClient->address_state_id  =    (!empty($input['client_address_state_id']) ? $input['client_address_state_id'] : '');
            $SaleInvoiceClient->street_address   =    (!empty($input['client_street_address']) ? $input['client_street_address'] : '');
            $SaleInvoiceClient->address_zip_code  =    (!empty($input['client_address_zip_code']) ? $input['client_address_zip_code'] : '');
            $SaleInvoiceClient->client_email  =    (!empty($input['client_email']) ? $input['client_email'] : '');
            $SaleInvoiceClient->show_email_invoice  =    (!empty($input['client_show_email_invoice']) ? $input['client_show_email_invoice'] : '');
            $SaleInvoiceClient->client_phone  =    (!empty($input['client_phone']) ? $input['business_phone'] : '');
            $SaleInvoiceClient->show_phone_invoice  =    (!empty($input['client_show_phone_invoice']) ? $input['client_show_phone_invoice'] : '');
            $SaleInvoiceClient->current_changes_business  =    (!empty($input['client_current_changes_business']) ? $input['client_current_changes_business'] : '');
            $SaleInvoiceClient->created_by  =    \Auth::user()->id;
            $SaleInvoiceClient->save();

            //Sale Invoice Label Change
            $SaleInvoiceLabelChange = new \App\Models\SaleInvoiceLabelChange;
            $SaleInvoiceLabelChange->invoice_id  =  (!empty($invoice['id']) ? $invoice['id'] : '');
            $SaleInvoiceLabelChange->label_invoice_no  =    (!empty($input['label_invoice_no'] && $input['label_invoice_no'] != 'undefined') ? $input['label_invoice_no'] : '');
            $SaleInvoiceLabelChange->label_invoice_date  =    (!empty($input['label_invoice_date'] && $input['label_invoice_date'] != 'undefined') ? $input['label_invoice_date'] : '');
            $SaleInvoiceLabelChange->label_invoice_due_date  =    (!empty($input['label_invoice_due_date'] && $input['label_invoice_due_date'] != 'undefined') ? $input['label_invoice_due_date'] : '');
            $SaleInvoiceLabelChange->label_invoice_billed_by  =    (!empty($input['label_invoice_billed_by'] && $input['label_invoice_billed_by'] != 'undefined') ? $input['label_invoice_billed_by'] : '');
            $SaleInvoiceLabelChange->label_invoice_billed_to  =    (!empty($input['label_invoice_billed_to'] && $input['label_invoice_billed_to'] != 'undefined') ? $input['label_invoice_billed_to'] : '');
            $SaleInvoiceLabelChange->label_invoice_shipped_from  =    (!empty($input['label_invoice_shipped_from'] && $input['label_invoice_shipped_from'] != 'undefined') ? $input['label_invoice_shipped_from'] : '');
            $SaleInvoiceLabelChange->label_invoice_shipped_to  =    (!empty($input['label_invoice_shipped_to'] && $input['label_invoice_shipped_to'] != 'undefined') ? $input['label_invoice_shipped_to'] : '');
            $SaleInvoiceLabelChange->label_invoice_transport_details  =    (!empty($input['label_invoice_transport_details'] && $input['label_invoice_transport_details'] != 'undefined') ? $input['label_invoice_transport_details'] : '');
            $SaleInvoiceLabelChange->label_invoice_challan_no  =    (!empty($input['label_invoice_challan_no'] && $input['label_invoice_challan_no'] != 'undefined') ? $input['label_invoice_challan_no'] : '');
            $SaleInvoiceLabelChange->label_invoice_challan_date  =    (!empty($input['label_invoice_challan_date'] && $input['label_invoice_challan_date'] != 'undefined') ? $input['label_invoice_challan_date'] : '');
            $SaleInvoiceLabelChange->label_invoice_transport  =    (!empty($input['label_invoice_transport'] && $input['label_invoice_transport'] != 'undefined') ? $input['label_invoice_transport'] : '');
            $SaleInvoiceLabelChange->label_invoice_extra_information  =    (!empty($input['label_invoice_extra_information'] && $input['label_invoice_extra_information'] != 'undefined') ? $input['label_invoice_extra_information'] : '');
            $SaleInvoiceLabelChange->label_invoice_terms_and_conditions  =    (!empty($input['label_invoice_terms_and_conditions'] && $input['label_invoice_terms_and_conditions'] != 'undefined') ? $input['label_invoice_terms_and_conditions'] : '');
            $SaleInvoiceLabelChange->label_invoice_additional_notes  =    (!empty($input['label_invoice_additional_notes'] && $input['label_invoice_additional_notes'] != 'undefined') ? $input['label_invoice_additional_notes'] : '');
            $SaleInvoiceLabelChange->label_invoice_attachments  =    (!empty($input['label_invoice_attachments'] && $input['label_invoice_attachments'] != 'undefined') ? $input['label_invoice_attachments'] : '');
            $SaleInvoiceLabelChange->additional_info_label  =    (!empty($input['additional_info_label'] && $input['additional_info_label'] != 'undefined') ? $input['additional_info_label'] : '');
            $SaleInvoiceLabelChange->label_round_up  =    (!empty($input['label_round_up'] && $input['label_round_up'] != 'undefined') ? $input['label_round_up'] : '');
            $SaleInvoiceLabelChange->label_round_down  =    (!empty($input['label_round_down'] && $input['label_round_down'] != 'undefined') ? $input['label_round_down'] : '');
            $SaleInvoiceLabelChange->label_total  =    (!empty($input['label_total'] && $input['label_total'] != 'undefined') ? $input['label_total'] : '');
            $SaleInvoiceLabelChange->created_by  =    \Auth::user()->id;
            $SaleInvoiceLabelChange->save();





            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
    /*add mutiple img product*/
    public function invoice_product_image($product_img,$img)
    {
        $image = $product_img;
        if (!empty($image) && $image != '') {
             for ($j = 0; $j < count($image); $j++) {
                if ($image[$j] != '' && $image[$j] != '') {
                    if (isset($image[$j]) && $image[$j] != 'undefined') {
                        $errorMessages = array();                                    
                        $imgResponse = CommonHelper::s3UploadFilesMultiple($image[$j], 'invoice_product_image', INVOICE_PRODUCT_IMAGE);
                        if($imgResponse->status == "success"){
                            $input['invoice_product_image'] = $imgResponse->fileUrl;
                        }else{
                            $errorMessages[]= $imgResponse->message;
                        }
                        $invoice_product_image['product_id'] = (!empty($img['id']) ? $img['id'] : '');
                        $invoice_product_image['invoice_id'] = (!empty($img['invoice_id']) ? $img['invoice_id'] : '');
                        $invoice_product_image['created_by'] = \Auth::user()->id;
                        $invoice_product_image['invoice_product_image'] = $input['invoice_product_image'];
                        $invoice_product_image['product_row_index'] = @$img['product_row_index'];
                        //$invoice_product_image['invoice_product_image_name'] =  @$image[$j]->getClientOriginalName();
                        $requestData1 = SaleInvoiceProductImage::create($invoice_product_image);
                    }
                }
            }
           
        }
        return $requestData1;
    } 
    /*add mutiple img Group invoice*/
    public function invoice_group_image($group_img,$img)
    {
        $image = $group_img;
        if (!empty($image) && $image != 'undefined') {
            for ($j = 0; $j < count($image); $j++) {
                if ($image[$j] != '') {
                    if (isset($image[$j]) && $image[$j] != '') {
                        $errorMessages = array();                                    
                        $imgResponse = CommonHelper::s3UploadFilesMultiple($image[$j], 'invoice_group_image', INVOICE_GROUP_IMAGE);
                        if($imgResponse->status == "success"){
                            $input['invoice_group_image'] = $imgResponse->fileUrl;
                        }else{
                            $errorMessages[]= $imgResponse->message;
                        }
                        $group_id =  SaleInvoiceGroup::where('invoice_id',$img['invoice_id'])->first();
                        $invoice_group_image['group_id'] = (!empty($group_id['id']) ? $group_id['id'] : '');
                        $invoice_group_image['invoice_id'] = (!empty($img['invoice_id']) ? $img['invoice_id'] : '');
                        $invoice_group_image['created_by'] = \Auth::user()->id;
                        $invoice_group_image['invoice_group_image'] = $input['invoice_group_image'];
                        //$invoice_group_image['invoice_group_image_name'] =  @$image[$j]->getClientOriginalName();
                        $requestData1 = SaleInvoiceGroupImg::create($invoice_group_image);
                    }
                }
            }
           
        }
        return $requestData1;
    }
    public function sale_invoice_edit($input)
    {
         try 
        { 
            /*echo "<pre>";
            print_r($input);
            //print_r(json_decode($input['product_array']));
            exit;*/
            $requestData =  SaleInvoice::find($input['id']);
             $requestData->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
            $requestData->guard  =    (!empty($input['guard']) ? $input['guard'] : '');
            $requestData->business_id  =    (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');
            $requestData->invoice_title  =    (!empty($input['invoice_title']) ? $input['invoice_title'] : '');
            $requestData->invoice_sub_title  =    (!empty($input['invoice_sub_title']) ? $input['invoice_sub_title'] : '');
            $requestData->invoice_no  =    (!empty($input['invoice_no']) ? $input['invoice_no'] : '');
            $requestData->invoice_date  =    (!empty($input['invoice_date']) ? $input['invoice_date'] : '');
            $requestData->due_date  =    (!empty($input['due_date']) ? $input['due_date'] : '');
            if(!empty($input['invoice_custome_filed_key']))
            {
                $invoice_custome_filed_data = [];
                for($i = 0; $i < count($input['invoice_custome_filed_key']); $i++)
                {
                    if(!empty($input['invoice_custome_filed_key'][$i]) && !empty($input['invoice_custome_filed_value'][$i])){
                      $invoice_custome_filed_data[$i]['key'] = $input['invoice_custome_filed_key'][$i];
                      $invoice_custome_filed_data[$i]['value'] = $input['invoice_custome_filed_value'][$i];
                    }
                }                
                $requestData->invoice_custome_filed  =    json_encode($invoice_custome_filed_data);
            }else{
                $requestData->invoice_custome_filed = '';
            }

            if (!empty($input['business_logo']) && $input['business_logo'] != 'undefined') 
            {
                $errorMessages = array();            
                $imgResponse = CommonHelper::s3UploadFilesSingel($input['business_logo'], 'business_logo', BUSINESLOGO);
                if($imgResponse->status == "success"){
                     $requestData->business_logo = $imgResponse->fileUrl;
                     $requestData->business_logo_name = @$input['business_logo']->getClientOriginalName();
                }else{
                    $errorMessages[]= $imgResponse->message;
                }
            }
            
            $requestData->e_invoice_details  =    (!empty($input['e_invoice_details']) ? $input['e_invoice_details'] : '');
            $requestData->company_id  =    (!empty($input['company_id']) ? $input['company_id'] : '');
            $requestData->company_name  =    (!empty($input['company_name']) ? $input['company_name'] : '');
            $requestData->company_address  =    (!empty($input['company_address']) ? $input['company_address'] : '');
            $requestData->customer_id  =    (!empty($input['customer_id']) ? $input['customer_id'] : '');
            $requestData->customer_name  =    (!empty($input['customer_name']) ? $input['customer_name'] : '');
            $requestData->customer_address  =    (!empty($input['customer_address']) ? $input['customer_address'] : '');
            if(!empty($input['is_shipping_detail_req'])){
                $requestData->is_shipping_detail_req   =    $input['is_shipping_detail_req'];
            }
            $requestData->shipped_from_name  =    (!empty($input['shipped_from_name']) ? $input['shipped_from_name'] : '');
            $requestData->shipped_from_country_id  =    (!empty($input['shipped_from_country_id']) ? $input['shipped_from_country_id'] : '');
            $requestData->shipped_from_country_name  =    (!empty($input['shipped_from_country_name']) ? $input['shipped_from_country_name'] : '');
            $requestData->shipped_from_address  =    (!empty($input['shipped_from_address']) ? $input['shipped_from_address'] : '');
            $requestData->shipped_from_city  =    (!empty($input['shipped_from_city']) ? $input['shipped_from_city'] : '');
            $requestData->shipped_from_zip_code  =    (!empty($input['shipped_from_zip_code']) ? $input['shipped_from_zip_code'] : '');
            $requestData->shipped_from_state_name  =    (!empty($input['shipped_from_state_name']) ? $input['shipped_from_state_name'] : '');
            $requestData->shipped_to_id  =    (!empty($input['shipped_to_id']) ? $input['shipped_to_id'] : '');
            $requestData->shipped_to_name  =    (!empty($input['shipped_to_name']) ? $input['shipped_to_name'] : '');
            $requestData->shipped_to_country_id  =    (!empty($input['shipped_to_country_id']) ? $input['shipped_to_country_id'] : '');
            $requestData->shipped_to_country_name  =    (!empty($input['shipped_to_country_name']) ? $input['shipped_to_country_name'] : '');
            $requestData->shipped_to_address  =    (!empty($input['shipped_to_address']) ? $input['shipped_to_address'] : '');
            $requestData->shipped_to_city  =    (!empty($input['shipped_to_city']) ? $input['shipped_to_city'] : '');
            $requestData->shipped_to_zip_code  =    (!empty($input['shipped_to_zip_code']) ? $input['shipped_to_zip_code'] : '');
            $requestData->shipped_to_state_name  =    (!empty($input['shipped_to_state_name']) ? $input['shipped_to_state_name'] : '');
            $requestData->transport_challan  =    (!empty($input['transport_challan']) ? $input['transport_challan'] : '');
            $requestData->transport_challan_date  =    (!empty($input['transport_challan_date']) ? $input['transport_challan_date'] : '');
            $requestData->transport_name  =    (!empty($input['transport_name']) ? $input['transport_name'] : '');
            $requestData->transport_information  =    (!empty($input['transport_information']) ? $input['transport_information'] : '');
            
            $requestData->billing_from_country_id  =    (!empty($input['billing_from_country_id']) ? $input['billing_from_country_id'] : '');
            $requestData->billing_from_country_name  =    (!empty($input['billing_from_country_name']) ? $input['billing_from_country_name'] : '');
            $requestData->billing_from_address  =    (!empty($input['billing_from_address']) ? $input['billing_from_address'] : '');
            $requestData->billing_from_city  =    (!empty($input['billing_from_city']) ? $input['billing_from_city'] : '');
            $requestData->billing_from_zip_code  =    (!empty($input['billing_from_zip_code']) ? $input['billing_from_zip_code'] : '');
            $requestData->billing_from_state_name  =    (!empty($input['billing_from_state_name']) ? $input['billing_from_state_name'] : '');
                
            $requestData->billing_to_country_id  =    (!empty($input['billing_to_country_id']) ? $input['billing_to_country_id'] : '');
            $requestData->billing_to_country_name  =    (!empty($input['billing_to_country_name']) ? $input['billing_to_country_name'] : '');
            $requestData->billing_to_address  =    (!empty($input['billing_to_address']) ? $input['billing_to_address'] : '');
            $requestData->billing_to_city  =    (!empty($input['billing_to_city']) ? $input['billing_to_city'] : '');
            $requestData->billing_to_zip_code  =    (!empty($input['billing_to_zip_code']) ? $input['billing_to_zip_code'] : '');
            $requestData->billing_to_state_name  =    (!empty($input['billing_to_state_name']) ? $input['billing_to_state_name'] : '');
            if(!empty($input['shipped_to_custome_filed_key']))
            {
                $shipped_to_custome_filed_data = [];
                for($i = 0; $i < count($input['shipped_to_custome_filed_key']); $i++)
                {
                    if(!empty($input['shipped_to_custome_filed_key']) && !empty($input['shipped_to_custome_filed_value'][$i])){
                      
                      $shipped_to_custome_filed_data[$i]['key'] = $input['shipped_to_custome_filed_key'][$i];
                      $shipped_to_custome_filed_data[$i]['value'] = $input['shipped_to_custome_filed_value'][$i];
                    }

                }                
                $requestData->shipped_to_custome_filed  =    json_encode($shipped_to_custome_filed_data);
            }else{
                $requestData->shipped_to_custome_filed = '';
            }
            $requestData->tax_type  =    (!empty($input['tax_type']) ? $input['tax_type'] : '');
            $requestData->is_tax  =    (!empty($input['is_tax']) ? $input['is_tax'] : '');
            $requestData->currency  =    (!empty($input['currency']) ? $input['currency'] : '');
            $requestData->final_amount  =    (!empty($input['final_amount']) ? $input['final_amount'] : '');
            $requestData->final_sgst  =    (!empty($input['final_sgst']) ? $input['final_sgst'] : '');
            $requestData->final_cgst  =    (!empty($input['final_cgst']) ? $input['final_cgst'] : '');
            $requestData->final_igst  =    (!empty($input['final_igst']) ? $input['final_igst'] : '');
            $requestData->round_up  =    (!empty($input['round_up']) ? $input['round_up'] : '');
            $requestData->round_down  =    (!empty($input['round_down']) ? $input['round_down'] : '');
            $requestData->final_product_wise_discount  =   (!empty($input['final_product_wise_discount']) ? $input['final_product_wise_discount'] : '');
            $requestData->final_total_discount_reductions  =   (!empty($input['final_total_discount_reductions']) ? $input['final_total_discount_reductions'] : '');
            $requestData->final_total_discount_reductions_unit  =   (!empty($input['final_total_discount_reductions_unit']) ? $input['final_total_discount_reductions_unit'] : '');
            $requestData->final_extra_charges  =    (!empty($input['final_extra_charges']) ? $input['final_extra_charges'] : '');
            $requestData->extra_changes_unit  =    (!empty($input['extra_changes_unit']) ? $input['extra_changes_unit'] : '');
            $requestData->final_summarise_total_quantity  =    (!empty($input['final_summarise_total_quantity']) ? $input['final_summarise_total_quantity'] : '');
            $requestData->final_total  =    (!empty($input['final_total']) ? $input['final_total'] : '');
            $requestData->final_total_words  =    (!empty($input['final_total_words']) ? $input['final_total_words'] : '');
            
            if(!empty($input['is_total_words_show'])){
                $requestData->is_total_words_show   =  $input['is_total_words_show'];
            }
            $requestData->is_terms_req   =  $input['is_terms_req'];
            $requestData->is_additional_notes_req   =  $input['is_additional_notes_req'];
            $requestData->is_attactments_req   =  $input['is_attactments_req'];
            $requestData->is_additional_info_req   =  $input['is_additional_info_req'];

            $requestData->is_contact_show   =  $input['is_contact_show'];

            if(!empty($input['is_terms_req']) && $input['is_terms_req'] == 1){
                if(!empty($input['terms_and_conditions_value']))
                {
                    $terms_and_conditions_data = [];
                    for($i = 0; $i < count($input['terms_and_conditions_value']); $i++)
                    {
                        if(!empty($input['terms_and_conditions_value'][$i]) && $input['terms_and_conditions_value'][$i] != "'Write here..'"){
                          $terms_and_conditions_data[$i] = $input['terms_and_conditions_value'][$i];
                        }
                    } 
                    $requestData->terms_and_conditions  =    json_encode($terms_and_conditions_data);

                }
            }else{
                 $requestData->terms_and_conditions = '';
            }
            if(!empty($input['is_additional_notes_req']) && $input['is_additional_notes_req'] == 1){
                $requestData->additional_notes  =    (!empty($input['additional_notes']) ? $input['additional_notes'] : '');
            }else{
                $requestData->additional_notes = '';
            }
            
            
            if(!empty($input['is_additional_info_req']) && $input['is_additional_info_req'] == 1){
                if(!empty($input['add_additional_info_key']))
                {              
                    $add_additional_info_data = [];
                    for($i = 0; $i < count($input['add_additional_info_key']); $i++)
                    {
                        if(!empty($input['add_additional_info_key'][$i]) && !empty($input['add_additional_info_value'][$i])){
                          $add_additional_info_data[$i]['key'] = $input['add_additional_info_key'][$i];
                          $add_additional_info_data[$i]['value'] = $input['add_additional_info_value'][$i];
                        }
                    } 
                    $requestData->add_additional_info  =    json_encode($add_additional_info_data);
                }
            }else{
                $requestData->add_additional_info = '';
            }        
            
            if(!empty($input['is_contact_show']) && $input['is_contact_show'] == 1){
                $requestData->contact_details  =     (!empty($input['contact_details']) ? $input['contact_details'] : '');
            }else{
                $requestData->contact_details = '';
            }
            if(!empty($input['final_total_more_field_key']))
            {
                $final_total_more_field_data = [];
                for($i = 0; $i < count($input['final_total_more_field_key']); $i++)
                {
                    if(!empty($input['final_total_more_field_key']) && !empty($input['final_total_more_field_value'][$i])){
                      
                      $final_total_more_field_data[$i]['key'] = $input['final_total_more_field_key'][$i];
                      $final_total_more_field_data[$i]['value'] = $input['final_total_more_field_value'][$i];
                    }

                }                
                $requestData->final_total_more_filed  =    json_encode($final_total_more_field_data);
            }else{
                $requestData->final_total_more_filed = '';
            }
            /*add team id*/
            if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
            {
                $requestData->team_id = \Auth::user()->parent_id;
            }else{
                $requestData->team_id = \Auth::user()->id;
            }
            /*end*/
            $requestData->created_by = \Auth::user()->id;
            $requestData->business_id   =    (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');
            $requestData->save();
            /*Change Number Format*/
            $old_record = SaleInvoiceAdvanceSetting::where('invoice_id',$input['id'])->delete();
            $ChangeNumberFormat = new SaleInvoiceAdvanceSetting;
            $ChangeNumberFormat->invoice_id = (!empty($input['id']) ? $input['id'] : '');
            $ChangeNumberFormat->number_format = (!empty($input['number_format']) ? $input['number_format'] : '');
            $ChangeNumberFormat->invoice_country = (!empty($input['invoice_country']) ? $input['invoice_country'] : '');
            $ChangeNumberFormat->decimal_digit_format = (!empty($input['decimal_digit_format']) ? $input['decimal_digit_format'] : '');
            $ChangeNumberFormat->hide_place_of_supply = (!empty($input['hide_place_of_supply']) ? $input['hide_place_of_supply'] : '');
            $ChangeNumberFormat->hsn_column_view = (!empty($input['hsn_column_view']) ? $input['hsn_column_view'] : '');
            $ChangeNumberFormat->show_hsn_summary = (!empty($input['show_hsn_summary']) ? $input['show_hsn_summary'] : '');
            $ChangeNumberFormat->add_original_images = (!empty($input['add_original_images']) ? $input['add_original_images'] : '');
            $ChangeNumberFormat->show_description_in_full_width = (!empty($input['show_description_in_full_width']) ? $input['show_description_in_full_width'] : '');
            $ChangeNumberFormat->created_by = \Auth::user()->id;
            $ChangeNumberFormat->save();
            /*Add new field and Edit Columns*/
            if(!empty($input['filed_data']))
            {                   
                //$SaleInvoiceFields['invoice_id'] = (!empty($input['id']) ? $input['id'] : '');
                $SaleInvoiceFields['filed_data']  =    (!empty($input['filed_data']) ? $input['filed_data'] : '');;
                $SaleInvoiceFields = SaleInvoiceFields::where('invoice_id',$input['id'])->update($SaleInvoiceFields);
            }
            /*attachments add multiple*/
            if(!empty($input['is_attactments_req']) && $input['is_attactments_req'] == 1){
                if(!empty($input['invoice_attachments']))
                {
                    $image = @$input['invoice_attachments'];
                    if (!empty($image) && $image != 'undefined') {
                        for ($i = 0; $i < count($image); $i++) {
                            if ($image[$i] != '') {
                                if (isset($image[$i]) && $image[$i] != '') {
                                    $errorMessages = array();                                    
                                    $imgResponse = CommonHelper::s3UploadFilesMultiple($image[$i], 'invoice_attachments', INVOICE_ATTACHMENTS);
                                    if($imgResponse->status == "success"){
                                        $input['invoice_attachments'] = $imgResponse->fileUrl;
                                    }else{
                                        $errorMessages[]= $imgResponse->message;
                                    }
                                    $invoice_attachments['invoice_id'] = (!empty($input['id']) ? $input['id'] : '');
                                    $invoice_attachments['created_by'] = \Auth::user()->id;
                                    $invoice_attachments['invoice_attachments'] = $input['invoice_attachments'];
                                    $invoice_attachments['invoice_attachments_name'] =  @$image[$i]->getClientOriginalName();
                                    $requestData1 = SaleInvoiceAttachments::create($invoice_attachments);
                                }
                            }
                        }
                    }
                }
            }else{
                SaleInvoiceAttachments::where('invoice_id',$input['id'])->delete();
            }
            /*attachments end*/

            /*add product*/
            if(!empty($input['product_array']))
            {  
                $oldDelete = SaleInvoiceProduct::where('invoice_id',$input['id'])->delete();
                $product = json_decode($input['product_array']);
                for ($i = 0; $i < count($product); $i++) 
                {
                    //echo "<pre>";  print_r($product);  exit;
                    if(!empty($product[$i]) && $product[$i]->product_id !='')
                    {                    
                        // check exit group invoice id wise
                        $exit_group = SaleInvoiceGroup::where('invoice_id',$requestData['id'])->where('group_name',$product[$i]->group_name)->first();
                        if(empty($exit_group) && $product[$i]->group_name != '')
                        {
                            $SaleInvoiceGroup = new SaleInvoiceGroup;
                            $SaleInvoiceGroup->group_name = (!empty($product[$i]->group_name) ? $product[$i]->group_name : '');
                            $SaleInvoiceGroup->invoice_id = (!empty($input['id']) ? $input['id'] : '');
                            $SaleInvoiceGroup->created_by = \Auth::user()->id;
                            $SaleInvoiceGroup->save();
                        }
                        //add group wise product
                        // stock update
                        $getCurrentStock = \App\Models\AdjustmentItem::where('variation_id',@$product[$i]->variation_id)
                                                                    ->where('product_id',@$product[$i]->product_id)
                                                                    ->first();
                        // Check mange stock flg
                        $productService = \App\Models\ProductService::where('id',@$product[$i]->product_id)->first();  
                        if(!empty($productService) && $productService->is_manage_stock != '0') 
                        {             
                            //check code add or not
                            $exit_check = SaleInvoiceProduct::where('variation_id',@$product[$i]->variation_id)
                                                              ->where('invoice_id',@$input['id'])
                                                              ->where('product_id',@$product[$i]->product_id)
                                                              ->first();
                            if(!empty($exit_check))
                            {
                                $old_stock = @$exit_check->product_quantity + @$getCurrentStock->quantity; 
                                $stock = $old_stock - @$product[$i]->product_quantity;
                                $update_stock = \App\Models\AdjustmentItem::where('variation_id',@$product[$i]->variation_id)
                                               ->update(['quantity' => @$stock]);
                            }else{
                                $stock = @$getCurrentStock->quantity - @$product[$i]->product_quantity;
                                $update_stock = \App\Models\AdjustmentItem::where('variation_id',@$product[$i]->variation_id)
                                               ->update(['quantity' => @$stock]);
                            }               
                            
                            /*update product id*/             
                            $stockHistory = new \App\Models\StockHistory;
                            if(!empty($product[$i]->variation_id))
                            {
                                $variation_name = \App\Models\ProductVariation::where('id',$product[$i]->variation_id)->first();
                            }
                            $stockHistory->vendor_id = (!empty($input['customer_id']) ? $input['customer_id'] : '');
                            $stockHistory->vendor_client_name = (!empty($input['customer_name']) ? $input['customer_name'] : '');
                            $stockHistory->product_id = (!empty($product[$i]->product_id) ? $product[$i]->product_id : '');
                            $stockHistory->variation_id = (!empty($product[$i]->variation_id) ? $product[$i]->variation_id : '');
                            $stockHistory->variation_name = @$variation_name['variation_name'];
                            $stockHistory->user_type = (!empty($input['user_type']) ? $input['user_type'] : '');
                            if(!empty($input['user_type']) && $input['user_type'] == 'customer')
                            {
                                $customer = \App\Models\Customer::where('id',$input['vendor_id'])->first();
                            }
                            else if(!empty($input['user_type']) && $input['user_type'] == 'vendor')
                            {
                                $customer = \App\Models\Vender::where('id',$input['vendor_id'])->first();
                            }
                            $stockHistory->vendor_client_name = (!empty($input['customer_name']) ? $input['customer_name'] : '');;
                            $stockHistory->stock = (!empty($product[$i]->product_quantity) ? $product[$i]->product_quantity : '');
                            $stockHistory->created_by = \Auth::user()->id;
                            $stockHistory->method_type = 2;
                            $stockHistory->stock_date = date('Y-m-d');
                            $stockHistory = $stockHistory->save();
                        }                                      

                        //end stock update
                        //$productData = new SaleInvoiceProduct;
                        //add group wise product
                        
                        $productData = new SaleInvoiceProduct;
                        if(empty($exit_group))
                        {
                            $productData->invoice_group_id = (!empty($SaleInvoiceGroup['id']) ? $SaleInvoiceGroup['id'] : '');
                        }else{
                            $productData->invoice_group_id = (!empty($exit_group['id']) ? $exit_group['id'] : '');

                        }
                        $productData->product_id = (!empty($product[$i]->product_id) ? $product[$i]->product_id : '');
                        $productData->variation_id = (!empty($product[$i]->variation_id) ? $product[$i]->variation_id : '');
                        
                        $productData->product_hsn_code = (!empty($product[$i]->product_hsn_code) ? $product[$i]->product_hsn_code : '');
                        $productData->product_gst_rate = (!empty($product[$i]->product_gst_rate) ? $product[$i]->product_gst_rate : '');
                        $productData->product_quantity = (!empty($product[$i]->product_quantity) ? $product[$i]->product_quantity : '');
                        $productData->product_rate = (!empty($product[$i]->product_rate) ? $product[$i]->product_rate : '');
                        $productData->product_amount = (!empty($product[$i]->product_amount) ? $product[$i]->product_amount : '');
                        $productData->product_discount_type = (!empty($product[$i]->product_discount_type) ? $product[$i]->product_discount_type : '');
                        $productData->product_discount = (!empty($product[$i]->product_discount) ? $product[$i]->product_discount : '');
                        $productData->product_igst = (!empty($product[$i]->product_igst) ? $product[$i]->product_igst : '');
                        $productData->product_cgst = (!empty($product[$i]->product_cgst) ? $product[$i]->product_cgst : '');
                        $productData->product_sgst = (!empty($product[$i]->product_sgst) ? $product[$i]->product_sgst : '');
                        $productData->product_total = (!empty($product[$i]->product_total) ? $product[$i]->product_total : '');
                        $productData->product_description = (!empty($product[$i]->product_description) ? $product[$i]->product_description : '');
                        $productData->product_row_index = (!empty($product[$i]->product_row_index) ? $product[$i]->product_row_index : '');
                        //$productData->product_name = (!empty($product[$i]->product_name) ? $product[$i]->product_name : '');
                        $productData->invoice_id = (!empty($input['id']) ? $input['id'] : '');
                        $productData->tax_type = (!empty($product[$i]->g_tax_type) ? $product[$i]->g_tax_type : '');
                        $productData->description = (!empty($product[$i]->g_description) ? $product[$i]->g_description : '');
                        $productData->created_by = \Auth::user()->id;
                        $productData->product_invoice_details = (!empty($product[$i]->g_product_invoice_details) ? $product[$i]->g_product_invoice_details : '');
                        $productData->save();
                        
                        //item add mutiple image 
                        if(!empty($input['invoice_product_image']) && $input['invoice_product_image'][$i] != '' && $input['invoice_product_image'][$i] != 'undefined')
                        {
                            $img['id'] = $product[$i]->product_id;
                            $img['invoice_id'] = (!empty($input['id']) ? $input['id'] : '');
                            $img['product_row_index'] = @$product[$i]->product_row_index;        
                            $image = @$input['invoice_product_image'][$i];
                            $this->invoice_product_image_edit($image,$img);
                        }
                        //group img
                        if(!empty($input['invoice_group_image']) && $input['invoice_group_image'][$i] != '' && $input['invoice_group_image'][$i] != 'undefined')
                        {
                            $img['id'] =  $productData->invoice_group_id;
                            $img['invoice_id'] = (!empty($input['id']) ? $input['id'] : '');
                            $image = @$input['invoice_group_image'][$i];
                            $this->invoice_group_image_edit($image,$img);
                        }
                    }
                }            
            }
            /*app side if(service id add product)*/
            if (!empty($input['service_id']))
            {
                for ($i = 0; $i < count($input['service_id']); $i++) 
                {
                    $serviceData = new SaleInvoiceService;
                    $serviceData->invoice_id = (!empty($input['id']) ? $input['id'] : '');
                    $serviceData->service_id = (!empty($input['service_id'][$i]) ? $input['service_id'][$i] : '');
                    $serviceData->business_id = (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');
                    $serviceData->service_name = (!empty($input['service_name'][$i]) ? $input['service_name'][$i] : '');
                    $serviceData->service_sale_price = (!empty($input['service_sale_price'][$i]) ? $input['service_sale_price'][$i] : '');
                    $serviceData->service_item_discount = (!empty($input['service_item_discount'][$i]) ? $input['service_item_discount'][$i] : '');
                    $serviceData->service_final_price = (!empty($input['service_final_price'][$i]) ? $input['service_final_price'][$i] : '');
                    $serviceData->created_by = \Auth::user()->id;;
                    $serviceData->save();                                                     
                }
            }

            // add business details
            $deletRecord = \App\Models\SaleInvoiceBusinessDetails::where('invoice_id',$input['id'])->delete();
            $SaleInvoiceBusiness = new \App\Models\SaleInvoiceBusinessDetails;
            $SaleInvoiceBusiness->invoice_id  =    (!empty($input['id']) ? $input['id'] : '');
            $SaleInvoiceBusiness->business_id  =    (!empty($input['business_id']) ? $input['business_id'] : '');
            $SaleInvoiceBusiness->business_name  =    (!empty($input['business_name']) ? $input['business_name'] : '');
            $SaleInvoiceBusiness->business_gst_in  =    (!empty($input['business_gst_in']) ? $input['business_gst_in'] : '');
            $SaleInvoiceBusiness->business_pan_no  =    (!empty($input['business_pan_no']) ? $input['business_pan_no'] : '');
            $SaleInvoiceBusiness->address_country_id =    (!empty($input['business_address_country_id']) ? $input['business_address_country_id'] : '');
            $SaleInvoiceBusiness->address_state_id  =    (!empty($input['business_address_state_id']) ? $input['business_address_state_id'] : '');
            $SaleInvoiceBusiness->business_zip_code  =    (!empty($input['business_zip_code']) ? $input['business_zip_code'] : '');
            $SaleInvoiceBusiness->street_address  =    (!empty($input['business_street_address']) ? $input['business_street_address'] : '');
            $SaleInvoiceBusiness->business_email  =    (!empty($input['business_email']) ? $input['business_email'] : '');
            $SaleInvoiceBusiness->show_email_invoice  =    (!empty($input['business_show_email_invoice']) ? $input['business_show_email_invoice'] : '');
            $SaleInvoiceBusiness->business_phone  =    (!empty($input['business_phone']) ? $input['business_phone'] : '');
            $SaleInvoiceBusiness->show_phone_invoice  =    (!empty($input['business_show_phone_invoice']) ? $input['business_show_phone_invoice'] : '');
            $SaleInvoiceBusiness->current_changes_business  =    (!empty($input['business_current_changes_business']) ? $input['business_current_changes_business'] : '');
            $SaleInvoiceBusiness->created_by  =    \Auth::user()->id;
            $SaleInvoiceBusiness->save();

            //add client detaails
            $deletRecord = \App\Models\SaleInvoiceClientDetails::where('invoice_id',$input['id'])->delete();
            $SaleInvoiceClient = new \App\Models\SaleInvoiceClientDetails;
            $SaleInvoiceClient->invoice_id  =  (!empty($input['id']) ? $input['id'] : '');
            $SaleInvoiceClient->client_id  =    (!empty($input['client_id']) ? $input['client_id'] : '');
            $SaleInvoiceClient->name  =    (!empty($input['client_business_name']) ? $input['client_business_name'] : '');
            $SaleInvoiceClient->client_gst_in  =    (!empty($input['client_gst_in']) ? $input['client_gst_in'] : '');
            $SaleInvoiceClient->client_pan_no  =    (!empty($input['client_pan_no']) ? $input['client_pan_no'] : '');
            $SaleInvoiceClient->address_country_id =    (!empty($input['client_address_country_id']) ? $input['client_address_country_id'] : '');
            $SaleInvoiceClient->address_state_id  =    (!empty($input['client_address_state_id']) ? $input['client_address_state_id'] : '');
            $SaleInvoiceClient->street_address   =    (!empty($input['client_street_address']) ? $input['client_street_address'] : '');
            $SaleInvoiceClient->address_zip_code  =    (!empty($input['client_address_zip_code']) ? $input['client_address_zip_code'] : '');
            $SaleInvoiceClient->client_email  =    (!empty($input['client_email']) ? $input['client_email'] : '');
            $SaleInvoiceClient->show_email_invoice  =    (!empty($input['client_show_email_invoice']) ? $input['client_show_email_invoice'] : '');
            $SaleInvoiceClient->client_phone  =    (!empty($input['client_phone']) ? $input['business_phone'] : '');
            $SaleInvoiceClient->show_phone_invoice  =    (!empty($input['client_show_phone_invoice']) ? $input['client_show_phone_invoice'] : '');
            $SaleInvoiceClient->current_changes_business  =    (!empty($input['client_current_changes_business']) ? $input['client_current_changes_business'] : '');
            $SaleInvoiceClient->created_by  =    \Auth::user()->id;
            $SaleInvoiceClient->save();

            //Sale Invoice Label Change
            $deletRecord = \App\Models\SaleInvoiceLabelChange::where('invoice_id',$input['id'])->delete();
            $SaleInvoiceLabelChange = new \App\Models\SaleInvoiceLabelChange;
            $SaleInvoiceLabelChange->invoice_id  =  (!empty($input['id']) ? $input['id'] : '');
            $SaleInvoiceLabelChange->label_invoice_no  =    (!empty($input['label_invoice_no'] && $input['label_invoice_no'] != 'undefined') ? $input['label_invoice_no'] : '');
            $SaleInvoiceLabelChange->label_invoice_date  =    (!empty($input['label_invoice_date'] && $input['label_invoice_date'] != 'undefined') ? $input['label_invoice_date'] : '');
            $SaleInvoiceLabelChange->label_invoice_due_date  =    (!empty($input['label_invoice_due_date'] && $input['label_invoice_due_date'] != 'undefined') ? $input['label_invoice_due_date'] : '');
            $SaleInvoiceLabelChange->label_invoice_billed_by  =    (!empty($input['label_invoice_billed_by'] && $input['label_invoice_billed_by'] != 'undefined') ? $input['label_invoice_billed_by'] : '');
            $SaleInvoiceLabelChange->label_invoice_billed_to  =    (!empty($input['label_invoice_billed_to'] && $input['label_invoice_billed_to'] != 'undefined') ? $input['label_invoice_billed_to'] : '');
            $SaleInvoiceLabelChange->label_invoice_shipped_from  =    (!empty($input['label_invoice_shipped_from'] && $input['label_invoice_shipped_from'] != 'undefined') ? $input['label_invoice_shipped_from'] : '');
            $SaleInvoiceLabelChange->label_invoice_shipped_to  =    (!empty($input['label_invoice_shipped_to'] && $input['label_invoice_shipped_to'] != 'undefined') ? $input['label_invoice_shipped_to'] : '');
            $SaleInvoiceLabelChange->label_invoice_transport_details  =    (!empty($input['label_invoice_transport_details'] && $input['label_invoice_transport_details'] != 'undefined') ? $input['label_invoice_transport_details'] : '');
            $SaleInvoiceLabelChange->label_invoice_challan_no  =    (!empty($input['label_invoice_challan_no'] && $input['label_invoice_challan_no'] != 'undefined') ? $input['label_invoice_challan_no'] : '');
            $SaleInvoiceLabelChange->label_invoice_challan_date  =    (!empty($input['label_invoice_challan_date'] && $input['label_invoice_challan_date'] != 'undefined') ? $input['label_invoice_challan_date'] : '');
            $SaleInvoiceLabelChange->label_invoice_transport  =    (!empty($input['label_invoice_transport'] && $input['label_invoice_transport'] != 'undefined') ? $input['label_invoice_transport'] : '');
            $SaleInvoiceLabelChange->label_invoice_extra_information  =    (!empty($input['label_invoice_extra_information'] && $input['label_invoice_extra_information'] != 'undefined') ? $input['label_invoice_extra_information'] : '');
            $SaleInvoiceLabelChange->label_invoice_terms_and_conditions  =    (!empty($input['label_invoice_terms_and_conditions'] && $input['label_invoice_terms_and_conditions'] != 'undefined') ? $input['label_invoice_terms_and_conditions'] : '');
            $SaleInvoiceLabelChange->label_invoice_additional_notes  =    (!empty($input['label_invoice_additional_notes'] && $input['label_invoice_additional_notes'] != 'undefined') ? $input['label_invoice_additional_notes'] : '');
            $SaleInvoiceLabelChange->label_invoice_attachments  =    (!empty($input['label_invoice_attachments'] && $input['label_invoice_attachments'] != 'undefined') ? $input['label_invoice_attachments'] : '');
            $SaleInvoiceLabelChange->additional_info_label  =    (!empty($input['additional_info_label'] && $input['additional_info_label'] != 'undefined') ? $input['additional_info_label'] : '');
            $SaleInvoiceLabelChange->label_round_up  =    (!empty($input['label_round_up'] && $input['label_round_up'] != 'undefined') ? $input['label_round_up'] : '');
            $SaleInvoiceLabelChange->label_round_down  =    (!empty($input['label_round_down'] && $input['label_round_down'] != 'undefined') ? $input['label_round_down'] : '');
            $SaleInvoiceLabelChange->label_total  =    (!empty($input['label_total'] && $input['label_total'] != 'undefined') ? $input['label_total'] : '');
            $SaleInvoiceLabelChange->created_by  =    \Auth::user()->id;
            $SaleInvoiceLabelChange->save();


            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
    /*edit mutiple img product*/
    public function invoice_product_image_edit($product_img,$img)
    {
        $image = $product_img;
        if (!empty($image)) {
             //SaleInvoiceProductImage::where('invoice_id',$img['invoice_id'])->delete();
            for ($j = 0; $j < count($image); $j++) {
                if ($image[$j] != '') {
                   if (isset($image[$j]) && $image[$j] != 'undefined') {
                        $errorMessages = array();                                    
                        $imgResponse = CommonHelper::s3UploadFilesMultiple($image[$j], 'invoice_product_image', INVOICE_PRODUCT_IMAGE);
                        if($imgResponse->status == "success"){
                            $input['invoice_product_image'] = $imgResponse->fileUrl;
                        }else{
                            $errorMessages[]= $imgResponse->message;
                        }
                        $invoice_product_image['product_id'] = (!empty($img['id']) ? $img['id'] : '');
                        $invoice_product_image['invoice_id'] = (!empty($img['invoice_id']) ? $img['invoice_id'] : '');
                        $invoice_product_image['created_by'] = \Auth::user()->id;
                        $invoice_product_image['invoice_product_image'] = $input['invoice_product_image'];
                        $invoice_product_image['product_row_index'] = @$img['product_row_index'];

                        //$invoice_product_image['invoice_product_image_name'] =  @$image[$j]->getClientOriginalName();
                        $requestData1 = SaleInvoiceProductImage::create($invoice_product_image);
                    }
                }
            }
           
        }
        return $requestData1;
    }
    /*edit mutiple img group*/
    public function invoice_group_image_edit($group_img,$img)
    {
        $image = $group_img;
        if (!empty($image)) {
             SaleInvoiceGroupImg::where('invoice_id',$img['invoice_id'])->delete();
            for ($j = 0; $j < count($image); $j++) {
                if ($image[$j] != '') {
                    if (isset($image[$j]) && $image[$j] != '') {
                        $errorMessages = array();                                    
                        $imgResponse = CommonHelper::s3UploadFilesMultiple($image[$j], 'invoice_group_image', INVOICE_GROUP_IMAGE);
                        if($imgResponse->status == "success"){
                            $input['invoice_group_image'] = $imgResponse->fileUrl;
                        }else{
                            $errorMessages[]= $imgResponse->message;
                        }
                        $invoice_group_image['group_id'] = (!empty($img['id']) ? $img['id'] : '');
                        $invoice_group_image['invoice_id'] = (!empty($img['invoice_id']) ? $img['invoice_id'] : '');
                        $invoice_group_image['created_by'] = \Auth::user()->id;
                        $invoice_group_image['invoice_group_image'] = $input['invoice_group_image'];
                        //$invoice_group_image['invoice_group_image_name'] =  @$image[$j]->getClientOriginalName();
                        $requestData1 = SaleInvoiceGroupImg::create($invoice_group_image);
                    }
                }
            }
           
        }
        return $requestData1;
    }

    public function sale_invoice_duplicate_add($input)
    {
        $getUser =  \App\Models\User::where('id',\Auth::user()->id)->first();
        $team_id =  $getUser->parent_id;
        if ($getUser->parent_id == 0) {
            $team_id = $getUser->id;
        }
        $invoice_id = $input['invoice_id'];
        $last_invoice = SaleInvoice::orderBy('id','DESC')
                        ->where('created_by',$team_id)
                        ->where('sale_invoice.is_delete', "=", '0')
                        ->where('business_id',\Auth::user()->active_business_id)
                        ->first();
        $firstString = substr($last_invoice->invoice_no, 0, -1);
        $lastDigit = substr($last_invoice->invoice_no, -1);
        if(is_numeric($lastDigit) && is_numeric($firstString))
        {

            preg_match('/^([0A-Za-z]+)(\d+)$/', $last_invoice->invoice_no, $matches);
            if(!empty($matches))
            {
                $letterPart = $matches[1];
                $numericPart = intval($matches[2]);
                $newNumericPart = $numericPart + 1;
                $paddedNumericPart = str_pad($newNumericPart, strlen($matches[2]), '0', STR_PAD_LEFT);
                $invoice_no = $letterPart . $paddedNumericPart;
            }else{
                $inNumberString = @$last_invoice->invoice_no;
                $invoice_no = (int)$inNumberString + 1;
            }

        }
        if(is_numeric($lastDigit) && !is_numeric($firstString))
        {
            //echo "dd"; exit;
            preg_match('/^([\/\\\\#,_|A-Za-z :-]+)(\d+)$/', $last_invoice->invoice_no, $matches);
            if(!empty($matches))
            {
                $letterPart = $matches[1];
                $numericPart = intval($matches[2]);
                $newNumericPart = $numericPart + 1;
                $paddedNumericPart = str_pad($newNumericPart, strlen($matches[2]), '0', STR_PAD_LEFT);
                $invoice_no = $letterPart . $paddedNumericPart;
            }else{
                //echo "dd"; exit;
                preg_match('/([A-Za-z]+)(\d+)/', $last_invoice->invoice_no, $matches);
                $str = $matches[0];
                preg_match('/([A-Za-z]+)(\d+)\D*$/', $last_invoice->invoice_no, $matches);
                $letterPart = $matches[1];
                $numericPart = intval($matches[2]);
                $newNumericPart = $numericPart + 1;
                $paddedNumericPart = str_pad($newNumericPart, strlen($matches[2]), '0', STR_PAD_LEFT);
                $invoice_no = $str. $matches[1] . $paddedNumericPart;


                /*echo $invoice_no; exit;
                $inNumberString = @$last_invoice->invoice_no;
                $trimmed = trim($last_invoice->invoice_no,$lastDigit);
                $invoice_no = $trimmed.(int)$lastDigit + 1;*/
            }

        }
        if(!is_numeric($lastDigit) && !is_numeric($firstString) && !empty($last_invoice->invoice_no))
        {
            $numericPart = preg_replace('/[^0-9]/', '', $last_invoice->invoice_no);
            if(!empty($numericPart))
            { 
                $numericPart = (int)$numericPart;
                // Increment the numeric part
                $numericPart++;
                // Reconstruct the new invoice number
                $invoice_no = preg_replace('/[0-9]+/', sprintf('%03d', $numericPart), $last_invoice->invoice_no);;
            }
            else            
            {
              $invoice_no = $last_invoice->invoice_no.'1' ;
            }
        }
        if(empty($last_invoice->invoice_no) && $last_invoice->invoice_no =='') 
        {
            $invoice_no = 'A0001';
        }
         
       //echo $invoice_no; exit;
                
        $SaleInvoice = SaleInvoice::where('id',$input['invoice_id'])->first();
        $requestData['platform']  =    (!empty($SaleInvoice['platform']) ? $SaleInvoice['platform'] : '');
        $requestData['guard']  =    (!empty($SaleInvoice['guard']) ? $SaleInvoice['guard'] : '');
        $requestData['business_id']  =    (!empty($SaleInvoice['business_id']) ? $SaleInvoice['business_id'] : '');
        $requestData['invoice_title']  =    (!empty($SaleInvoice['invoice_title']) ? $SaleInvoice['invoice_title'] : '');
        $requestData['invoice_sub_title']  =    (!empty($SaleInvoice['invoice_sub_title']) ? $SaleInvoice['invoice_sub_title'] : '');
        $requestData['invoice_no']  =    (!empty($invoice_no) ? $invoice_no : '');
        $requestData['invoice_date']  =    (!empty($SaleInvoice['invoice_date']) ? $SaleInvoice['invoice_date'] : '');
        $requestData['due_date']  =    (!empty($SaleInvoice['due_date']) ? $SaleInvoice['due_date'] : '');
        $requestData['invoice_custome_filed']  =    (!empty($SaleInvoice['invoice_custome_filed']) ? $SaleInvoice['invoice_custome_filed'] : '');
        $requestData['business_logo']  =    (!empty($SaleInvoice['business_logo']) ? $SaleInvoice['business_logo'] : '');
        $requestData['e_invoice_details']  =    (!empty($SaleInvoice['e_invoice_details']) ? $SaleInvoice['e_invoice_details'] : '');
        $requestData['company_id']  =    (!empty($SaleInvoice['company_id']) ? $SaleInvoice['company_id'] : '');
        $requestData['company_name']  =    (!empty($SaleInvoice['company_name']) ? $SaleInvoice['company_name'] : '');
        $requestData['company_address']  =    (!empty($SaleInvoice['company_address']) ? $SaleInvoice['company_address'] : '');
        $requestData['customer_id']  =    (!empty($SaleInvoice['customer_id']) ? $SaleInvoice['customer_id'] : '');
        $requestData['customer_name']  =    (!empty($SaleInvoice['customer_name']) ? $SaleInvoice['customer_name'] : '');
        $requestData['customer_address']  =    (!empty($SaleInvoice['customer_address']) ? $SaleInvoice['customer_address'] : '');
        $requestData['is_shipping_detail_req']   =    $SaleInvoice['is_shipping_detail_req'];
        $requestData['shipped_from_name']  =    (!empty($SaleInvoice['shipped_from_name']) ? $SaleInvoice['shipped_from_name'] : '');
        $requestData['shipped_from_country_id']  =    (!empty($SaleInvoice['shipped_from_country_id']) ? $SaleInvoice['shipped_from_country_id'] : '');
        $requestData['shipped_from_country_name']  =    (!empty($SaleInvoice['shipped_from_country_name']) ? $SaleInvoice['shipped_from_country_name'] : '');
        $requestData['shipped_from_address']  =    (!empty($SaleInvoice['shipped_from_address']) ? $SaleInvoice['shipped_from_address'] : '');
        $requestData['shipped_from_city']  =    (!empty($SaleInvoice['shipped_from_city']) ? $SaleInvoice['shipped_from_city'] : '');
        $requestData['shipped_from_zip_code']  =    (!empty($SaleInvoice['shipped_from_zip_code']) ? $SaleInvoice['shipped_from_zip_code'] : '');
        $requestData['shipped_from_state_name']  =    (!empty($SaleInvoice['shipped_from_state_name']) ? $SaleInvoice['shipped_from_state_name'] : '');
        $requestData['shipped_to_id']  =    (!empty($SaleInvoice['shipped_to_id']) ? $SaleInvoice['shipped_to_id'] : '');
        $requestData['shipped_to_name']  =    (!empty($SaleInvoice['shipped_to_name']) ? $SaleInvoice['shipped_to_name'] : '');
        $requestData['shipped_to_country_id']  =    (!empty($SaleInvoice['shipped_to_country_id']) ? $SaleInvoice['shipped_to_country_id'] : '');
        $requestData['shipped_to_country_name']  =    (!empty($SaleInvoice['shipped_to_country_name']) ? $SaleInvoice['shipped_to_country_name'] : '');
        $requestData['shipped_to_address']  =    (!empty($SaleInvoice['shipped_to_address']) ? $SaleInvoice['shipped_to_address'] : '');
        $requestData['shipped_to_city']  =    (!empty($SaleInvoice['shipped_to_city']) ? $SaleInvoice['shipped_to_city'] : '');
        $requestData['shipped_to_zip_code']  =    (!empty($SaleInvoice['shipped_to_zip_code']) ? $SaleInvoice['shipped_to_zip_code'] : '');
        $requestData['shipped_to_state_name']  =    (!empty($SaleInvoice['shipped_to_state_name']) ? $SaleInvoice['shipped_to_state_name'] : '');
        $requestData['transport_challan']  =    (!empty($SaleInvoice['transport_challan']) ? $SaleInvoice['transport_challan'] : '');
        $requestData['transport_challan_date']  =    (!empty($SaleInvoice['transport_challan_date']) ? $SaleInvoice['transport_challan_date'] : '');
        $requestData['transport_name']  =    (!empty($SaleInvoice['transport_name']) ? $SaleInvoice['transport_name'] : '');
        $requestData['transport_information']  =    (!empty($SaleInvoice['transport_information']) ? $SaleInvoice['transport_information'] : '');
        $requestData['billing_from_country_id']  =    (!empty($SaleInvoice['billing_from_country_id']) ? $SaleInvoice['billing_from_country_id'] : '');
        $requestData['billing_from_country_name']  =    (!empty($SaleInvoice['billing_from_country_name']) ? $SaleInvoice['billing_from_country_name'] : '');
        $requestData['billing_from_address']  =    (!empty($SaleInvoice['billing_from_address']) ? $SaleInvoice['billing_from_address'] : '');
        $requestData['billing_from_city'] =    (!empty($SaleInvoice['billing_from_city']) ? $SaleInvoice['billing_from_city'] : '');
        $requestData['billing_from_zip_code']  =    (!empty($SaleInvoice['billing_from_zip_code']) ? $SaleInvoice['billing_from_zip_code'] : '');
        $requestData['billing_from_state_name']  =    (!empty($SaleInvoice['billing_from_state_name']) ? $SaleInvoice['billing_from_state_name'] : '');
        $requestData['billing_to_country_id']  =    (!empty($SaleInvoice['billing_to_country_id']) ? $SaleInvoice['billing_to_country_id'] : '');
        $requestData['billing_to_country_name']  =    (!empty($SaleInvoice['billing_to_country_name']) ? $SaleInvoice['billing_to_country_name'] : '');
        $requestData['billing_to_address']  =    (!empty($SaleInvoice['billing_to_address']) ? $SaleInvoice['billing_to_address'] : '');
        $requestData['billing_to_city']  =    (!empty($SaleInvoice['billing_to_city']) ? $SaleInvoice['billing_to_city'] : '');
        $requestData['billing_to_zip_code']  =    (!empty($SaleInvoice['billing_to_zip_code']) ? $SaleInvoice['billing_to_zip_code'] : '');
        $requestData['billing_to_state_name']  =    (!empty($SaleInvoice['billing_to_state_name']) ? $SaleInvoice['billing_to_state_name'] : '');
        $requestData['shipped_to_custome_filed'] =    (!empty($SaleInvoice['shipped_to_custome_filed']) ? $SaleInvoice['shipped_to_custome_filed'] : '');
        $requestData['tax_type']  =    (!empty($SaleInvoice['tax_type']) ? $SaleInvoice['tax_type'] : '');
        $requestData['is_tax']  =    (!empty($SaleInvoice['is_tax']) ? $SaleInvoice['is_tax'] : '');
        $requestData['currency']  =    (!empty($SaleInvoice['currency']) ? $SaleInvoice['currency'] : '');
        $requestData['final_amount']  =    (!empty($SaleInvoice['final_amount']) ? $SaleInvoice['final_amount'] : '');
        $requestData['final_sgst']  =    (!empty($SaleInvoice['final_sgst']) ? $SaleInvoice['final_sgst'] : '');
        $requestData['final_cgst']  =    (!empty($SaleInvoice['final_cgst']) ? $SaleInvoice['final_cgst'] : '');
        $requestData['final_igst']  =    (!empty($SaleInvoice['final_igst']) ? $SaleInvoice['final_igst'] : '');
        $requestData['round_up']  =    (!empty($SaleInvoice['round_up']) ? $SaleInvoice['round_up'] : '');
        $requestData['round_down']  =    (!empty($SaleInvoice['round_down']) ? $SaleInvoice['round_down'] : '');
        $requestData['final_product_wise_discount']  =   (!empty($SaleInvoice['final_product_wise_discount']) ? $SaleInvoice['final_product_wise_discount'] : '');
        $requestData['final_total_discount_reductions']  =   (!empty($SaleInvoice['final_total_discount_reductions']) ? $SaleInvoice['final_total_discount_reductions'] : '');
        $requestData['final_total_discount_reductions_unit']  =   (!empty($SaleInvoice['final_total_discount_reductions_unit']) ? $SaleInvoice['final_total_discount_reductions_unit'] : '');
        $requestData['final_extra_charges']  =    (!empty($SaleInvoice['final_extra_charges']) ? $SaleInvoice['final_extra_charges'] : '');
        $requestData['extra_changes_unit']  =    (!empty($SaleInvoice['extra_changes_unit']) ? $SaleInvoice['extra_changes_unit'] : '');
        $requestData['final_summarise_total_quantity']  =    (!empty($SaleInvoice['final_summarise_total_quantity']) ? $SaleInvoice['final_summarise_total_quantity'] : '');
        $requestData['final_total']  =    (!empty($SaleInvoice['final_total']) ? $SaleInvoice['final_total'] : '');
        $requestData['final_total_more_filed']  =    (!empty($SaleInvoice['final_total_more_filed']) ? $SaleInvoice['final_total_more_filed'] : '');
        $requestData['final_total_words']  =    (!empty($SaleInvoice['final_total_words']) ? $SaleInvoice['final_total_words'] : '');
        $requestData['additional_notes']  =    (!empty($SaleInvoice['additional_notes']) ? $SaleInvoice['additional_notes'] : '');
        $requestData['is_total_words_show']   =  $SaleInvoice['is_total_words_show'];
      
        $requestData['terms_and_conditions']  =    (!empty($SaleInvoice['terms_and_conditions']) ? $SaleInvoice['terms_and_conditions'] : '');
        $requestData['add_additional_info']  =    (!empty($SaleInvoice['add_additional_info']) ? $SaleInvoice['add_additional_info'] : '');
        $requestData['contact_details']  =     (!empty($SaleInvoice['contact_details']) ? $SaleInvoice['contact_details'] : '');
        $requestData['is_contact_show']   =  (!empty($SaleInvoice['is_contact_show']) ? $SaleInvoice['is_contact_show'] : '');
        $requestData['is_terms_req']   =  (!empty($SaleInvoice['is_terms_req']) ? $SaleInvoice['is_terms_req'] : '');
        $requestData['is_additional_notes_req']   =  (!empty($SaleInvoice['is_additional_notes_req']) ? $SaleInvoice['is_additional_notes_req'] : '');
        $requestData['is_attactments_req']   =  (!empty($SaleInvoice['is_attactments_req']) ? $SaleInvoice['is_attactments_req'] : '');
        $requestData['is_additional_info_req']   =  (!empty($SaleInvoice['is_additional_info_req']) ? $SaleInvoice['is_additional_info_req'] : '');
        $requestData['template_id']   =  (!empty($SaleInvoice['template_id']) ? $SaleInvoice['template_id'] : '');
        $requestData['payment_status']   =  (!empty($SaleInvoice['payment_status']) ? $SaleInvoice['payment_status'] : '');


        /*add team id*/
        if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
        {
            $requestData['team_id'] = \Auth::user()->parent_id;
        }else{
            $requestData['team_id'] = \Auth::user()->id;
        }
        /*end*/
        $requestData['created_by'] = \Auth::user()->id;
        $requestData = SaleInvoice::create($requestData);
        $lastInvoiceId = SaleInvoice::orderBy('id','DESC')->first();
        //Add new field and Edit Columns
        $SaleInvoiceFields = SaleInvoiceFields::where('invoice_id',$invoice_id)->first();
        if(!empty($SaleInvoiceFields))
        {                   
            $SaleInvoiceFieldsData['invoice_id'] = (!empty($lastInvoiceId['id']) ? $lastInvoiceId['id'] : '');
            $SaleInvoiceFieldsData['filed_data']  =    (!empty($SaleInvoiceFields['filed_data']) ? $SaleInvoiceFields['filed_data'] : '');;
            $SaleInvoiceFieldsData['created_by'] = \Auth::user()->id;
            $SaleInvoiceFieldsData = SaleInvoiceFields::insert($SaleInvoiceFieldsData);
        }
        //SaleInvoiceAttachments
        $getSaleInvoiceAttachments = SaleInvoiceAttachments::where('invoice_id',$invoice_id)->get();
        if(!empty($getSaleInvoiceAttachments))
        {
            foreach ($getSaleInvoiceAttachments as $key => $value) {
                $invoice_attachments['platform'] = (!empty($value['platform']) ? $value['platform'] : '');
                $invoice_attachments['guard'] = (!empty($value['guard']) ? $value['guard'] : '');
                $invoice_attachments['invoice_id'] = (!empty($lastInvoiceId['id']) ? $lastInvoiceId['id'] : '');
                $invoice_attachments['created_by'] = \Auth::user()->id;
                $invoice_attachments['invoice_attachments'] = $value['invoice_attachments'];
                $invoice_attachments['invoice_attachments_name'] =  $value['invoice_attachments_name'];
                $requestData1 = SaleInvoiceAttachments::create($invoice_attachments);
            }
        }
        //SaleInvoiceProduct
        $getSaleInvoiceProduct = SaleInvoiceProduct::where('invoice_id',$invoice_id)->get();
        if(!empty($getSaleInvoiceProduct))
        {
            foreach ($getSaleInvoiceProduct as $value) {
                $productData['invoice_id'] = (!empty($lastInvoiceId->id) ? $lastInvoiceId->id : '');
                $productData['invoice_group_id'] = (!empty($value->invoice_group_id) ? $value->invoice_group_id : '0');
                $productData['product_id'] = (!empty($value->product_id) ? $value->product_id : '');
                $productData['variation_id'] = (!empty($value->variation_id) ? $value->variation_id : '');                
                $productData['product_hsn_code'] = (!empty($value->product_hsn_code) ? $value->product_hsn_code : '');
                $productData['product_gst_rate'] = (!empty($value->product_gst_rate) ? $value->product_gst_rate : '');
                $productData['product_quantity'] = (!empty($value->product_quantity) ? $value->product_quantity : '');
                $productData['product_rate'] = (!empty($value->product_rate) ? $value->product_rate : '');
                $productData['product_amount'] = (!empty($value->product_amount) ? $value->product_amount : '');
                $productData['product_discount_type'] = (!empty($value->product_discount_type) ? $value->product_discount_type : '');
                $productData['product_discount'] = (!empty($value->product_discount) ? $value->product_discount : '');
                $productData['product_igst'] = (!empty($value->product_igst) ? $value->product_igst : '');
                $productData['product_cgst'] = (!empty($value->product_cgst) ? $value->product_cgst : '');
                $productData['product_sgst'] = (!empty($value->product_sgst) ? $value->product_sgst : '');
                $productData['product_total'] = (!empty($value->product_total) ? $value->product_total : '');
                $productData['product_description'] = (!empty($value->product_description) ? $value->product_description : '');
                $productData['product_row_index'] = (!empty($value->product_row_index) ? $value->product_row_index : '');
                $productData['tax_type'] = (!empty($value->g_tax_type) ? $value->g_tax_type : '');
                $productData['description'] = (!empty($value->g_description) ? $value->g_description : '');
                $productData['created_by'] = \Auth::user()->id;
                $productData['product_invoice_details'] = (!empty($value->g_product_invoice_details) ? $value->g_product_invoice_details: '');
                $productData = SaleInvoiceProduct::create($productData);           
                $productData =[]; 
                // stock update
                $getCurrentStock = \App\Models\AdjustmentItem::where('variation_id',$value['variation_id'])
                                                            ->where('product_id',$value['product_id'])->first();

                // Check mange stock flg
                $productService = \App\Models\ProductService::where('id',$value['product_id'])->first();  
                if(!empty($productService) && $productService->is_manage_stock != '0') 
                {                            
                    $stock = @$getCurrentStock->quantity - @$value['product_quantity'];
                    $update_stock = \App\Models\AdjustmentItem::where('variation_id',$value['variation_id'])                            
                                                 ->update(['quantity' => @$stock]);
                /*update product id*/             
                        $stockHistory = new \App\Models\StockHistory;
                        if(!empty($product[$i]->variation_id))
                        {
                            $variation_name = \App\Models\ProductVariation::where('id',$value['variation_id'])->first();
                        }
                        $stockHistory->vendor_id = (!empty($SaleInvoice['customer_id']) ? $SaleInvoice['customer_id'] : '');
                        $stockHistory->vendor_client_name = (!empty($SaleInvoice['customer_name']) ? $SaleInvoice['customer_name'] : '');
                        $stockHistory->product_id = (!empty($value['product_id']) ? $value['product_id'] : '');
                        $stockHistory->variation_id = (!empty($value['variation_id']) ? $value['variation_id'] : '');
                        $stockHistory->variation_name = @$variation_name['variation_name'];
                        $stockHistory->user_type = (!empty($SaleInvoice['user_type']) ? $SaleInvoice['user_type'] : '');
                        if(!empty($SaleInvoice['user_type']) && $SaleInvoice['user_type'] == 'customer')
                        {
                            $customer = \App\Models\Customer::where('id',$SaleInvoice['vendor_id'])->first();
                        }
                        else if(!empty($SaleInvoice['user_type']) && $SaleInvoice['user_type'] == 'vendor')
                        {
                            $customer = \App\Models\Vender::where('id',$SaleInvoice['vendor_id'])->first();
                        }
                        $stockHistory->vendor_client_name = (!empty($SaleInvoice['customer_name']) ? $SaleInvoice['customer_name'] : '');;
                        $stockHistory->stock = (!empty($value['product_quantity']) ? $value['product_quantity'] : '');
                        $stockHistory->created_by = \Auth::user()->id;
                        $stockHistory->method_type = 2;
                        $stockHistory->stock_date = date('Y-m-d');
                        $stockHistory = $stockHistory->save();
                }                                       
            }         
        }
        // add media saleinvoice
        $SaleInvoiceProductImage = SaleInvoiceProductImage::where('invoice_id',$invoice_id)->get();
        if(!empty($SaleInvoiceProductImage))
        {
            foreach ($SaleInvoiceProductImage as $key => $value) {
                $invoice_product_image['product_id'] = (!empty($value['product_id']) ? $value['product_id'] : '');
                $invoice_product_image['invoice_id'] = (!empty($lastInvoiceId->id) ? $lastInvoiceId->id : '');
                $invoice_product_image['created_by'] = \Auth::user()->id;
                $invoice_product_image['invoice_product_image'] = @$value['invoice_product_image'];
                $invoice_product_image['product_row_index'] = @$value['product_row_index'];
                $requestData1 = SaleInvoiceProductImage::create($invoice_product_image);
            }
        }
        // add business details
        $SaleInvoiceBusiness = \App\Models\SaleInvoiceBusinessDetails::where('invoice_id',$invoice_id)->first();
        $SaleInvoiceBusinessData['invoice_id']  =    (!empty($lastInvoiceId->id) ? $lastInvoiceId->id : '');
        $SaleInvoiceBusinessData['business_id']  =    (!empty($SaleInvoiceBusiness['business_id']) ? $SaleInvoiceBusiness['business_id'] : '');
        $SaleInvoiceBusinessData['business_name']  =    (!empty($SaleInvoiceBusiness['business_name']) ? $SaleInvoiceBusiness['business_name'] : '');
        $SaleInvoiceBusinessData['business_gst_in']  =    (!empty($SaleInvoiceBusiness['business_gst_in']) ? $SaleInvoiceBusiness['business_gst_in'] : '');
        $SaleInvoiceBusinessData['business_pan_no']  =    (!empty($SaleInvoiceBusiness['business_pan_no']) ? $SaleInvoiceBusiness['business_pan_no'] : '');
        $SaleInvoiceBusinessData['address_country_id'] =    (!empty($SaleInvoiceBusiness['address_country_id']) ? $SaleInvoiceBusiness['address_country_id'] : '');
        $SaleInvoiceBusinessData['address_state_id']  =    (!empty($SaleInvoiceBusiness['address_state_id']) ? $SaleInvoiceBusiness['address_state_id'] : '');
        $SaleInvoiceBusinessData['business_zip_code']  =    (!empty($SaleInvoiceBusiness['business_zip_code']) ? $SaleInvoiceBusiness['business_zip_code'] : '');
        $SaleInvoiceBusinessData['street_address']  =    (!empty($SaleInvoiceBusiness['street_address']) ? $SaleInvoiceBusiness['street_address'] : '');
        $SaleInvoiceBusinessData['business_email']  =    (!empty($SaleInvoiceBusiness['business_email']) ? $SaleInvoiceBusiness['business_email'] : '');
        $SaleInvoiceBusinessData['show_email_invoice']  =    (!empty($SaleInvoiceBusiness['show_email_invoice']) ? $SaleInvoiceBusiness['show_email_invoice'] : '');
        $SaleInvoiceBusinessData['business_phone']  =    (!empty($SaleInvoiceBusiness['business_phone']) ? $SaleInvoiceBusiness['business_phone'] : '');
        $SaleInvoiceBusinessData['show_phone_invoice']  =    (!empty($SaleInvoiceBusiness['show_phone_invoice']) ? $SaleInvoiceBusiness['show_phone_invoice'] : '');
        $SaleInvoiceBusinessData['current_changes_business']  =    (!empty($SaleInvoiceBusiness['current_changes_business']) ? $SaleInvoiceBusiness['current_changes_business'] : '');
        $SaleInvoiceBusinessData['created_by']  =    \Auth::user()->id;
        $SaleInvoiceBusiness = \App\Models\SaleInvoiceBusinessDetails::create($SaleInvoiceBusinessData);

        //SaleInvoiceClientDetails
        $SaleInvoiceClientData = \App\Models\SaleInvoiceClientDetails::where('invoice_id',$invoice_id)->first();
        $SaleInvoiceClient['invoice_id']  =  (!empty($lastInvoiceId->id) ? $lastInvoiceId->id : '');
        $SaleInvoiceClient['client_id']  =    (!empty($SaleInvoiceClientData['client_id']) ? $SaleInvoiceClientData['client_id'] : '');
        $SaleInvoiceClient['name']  =    (!empty($SaleInvoiceClientData['name']) ? $SaleInvoiceClientData['name'] : '');
        $SaleInvoiceClient['client_gst_in']  =    (!empty($SaleInvoiceClientData['client_gst_in']) ? $SaleInvoiceClientData['client_gst_in'] : '');
        $SaleInvoiceClient['client_pan_no']  =    (!empty($SaleInvoiceClientData['client_pan_no']) ? $SaleInvoiceClientData['client_pan_no'] : '');
        $SaleInvoiceClient['address_country_id'] =    (!empty($SaleInvoiceClientData['address_country_id']) ? $SaleInvoiceClientData['address_country_id'] : '');
        $SaleInvoiceClient['address_state_id']  =    (!empty($SaleInvoiceClientData['address_state_id']) ? $SaleInvoiceClientData['address_state_id'] : '');
        $SaleInvoiceClient['street_address']   =    (!empty($SaleInvoiceClientData['street_address']) ? $SaleInvoiceClientData['street_address'] : '');
        $SaleInvoiceClient['address_zip_code']  =    (!empty($SaleInvoiceClientData['address_zip_code']) ? $SaleInvoiceClientData['address_zip_code'] : '');
        $SaleInvoiceClient['client_email']  =    (!empty($SaleInvoiceClientData['client_email']) ? $SaleInvoiceClientData['client_email'] : '');
        $SaleInvoiceClient['show_email_invoice']  =    (!empty($SaleInvoiceClientData['client_show_email_invoice']) ? $SaleInvoiceClientData['client_show_email_invoice'] : '');
        $SaleInvoiceClient['client_phone']  =    (!empty($SaleInvoiceClientData['client_phone']) ? $SaleInvoiceClientData['business_phone'] : '');
        $SaleInvoiceClient['show_phone_invoice']  =    (!empty($SaleInvoiceClientData['show_phone_invoice']) ? $SaleInvoiceClientData['show_phone_invoice'] : '');
        $SaleInvoiceClient['current_changes_business']  =    (!empty($SaleInvoiceClientData['current_changes_business']) ? $SaleInvoiceClientData['current_changes_business'] : '');
        $SaleInvoiceClient['created_by']  =    \Auth::user()->id;
        $SaleInvoiceClient = \App\Models\SaleInvoiceClientDetails::create($SaleInvoiceClient);
        //Sale Invoice Label Change

        $SaleInvoiceLabelChangeData =  \App\Models\SaleInvoiceLabelChange::where('invoice_id',$invoice_id)->first();
        $SaleInvoiceLabelChange['invoice_id']  =  (!empty($lastInvoiceId->id) ? $lastInvoiceId->id : '');
        $SaleInvoiceLabelChange['label_invoice_no']  =    (!empty($SaleInvoiceLabelChangeData['label_invoice_no'] && $SaleInvoiceLabelChangeData['label_invoice_no'] != 'undefined') ? $SaleInvoiceLabelChangeData['label_invoice_no'] : '');
        $SaleInvoiceLabelChange['label_invoice_date']  =    (!empty($SaleInvoiceLabelChangeData['label_invoice_date'] && $SaleInvoiceLabelChangeData['label_invoice_date'] != 'undefined') ? $SaleInvoiceLabelChangeData['label_invoice_date'] : '');
        $SaleInvoiceLabelChange['label_invoice_due_date']  =    (!empty($SaleInvoiceLabelChangeData['label_invoice_due_date'] && $SaleInvoiceLabelChangeData['label_invoice_due_date'] != 'undefined') ? $SaleInvoiceLabelChangeData['label_invoice_due_date'] : '');
        $SaleInvoiceLabelChange['label_invoice_billed_by']  =    (!empty($SaleInvoiceLabelChangeData['label_invoice_billed_by'] && $SaleInvoiceLabelChangeData['label_invoice_billed_by'] != 'undefined') ? $SaleInvoiceLabelChangeData['label_invoice_billed_by'] : '');
        $SaleInvoiceLabelChange['label_invoice_billed_to']  =    (!empty($SaleInvoiceLabelChangeData['label_invoice_billed_to'] && $SaleInvoiceLabelChangeData['label_invoice_billed_to'] != 'undefined') ? $SaleInvoiceLabelChangeData['label_invoice_billed_to'] : '');
        $SaleInvoiceLabelChange['label_invoice_shipped_from']  =    (!empty($SaleInvoiceLabelChangeData['label_invoice_shipped_from'] && $SaleInvoiceLabelChangeData['label_invoice_shipped_from'] != 'undefined') ? $SaleInvoiceLabelChangeData['label_invoice_shipped_from'] : '');
        $SaleInvoiceLabelChange['label_invoice_shipped_to']  =    (!empty($SaleInvoiceLabelChangeData['label_invoice_shipped_to'] && $SaleInvoiceLabelChangeData['label_invoice_shipped_to'] != 'undefined') ? $SaleInvoiceLabelChangeData['label_invoice_shipped_to'] : '');
        $SaleInvoiceLabelChange['label_invoice_transport_details']  =    (!empty($SaleInvoiceLabelChangeData['label_invoice_transport_details'] && $SaleInvoiceLabelChangeData['label_invoice_transport_details'] != 'undefined') ? $SaleInvoiceLabelChangeData['label_invoice_transport_details'] : '');
        $SaleInvoiceLabelChange['label_invoice_challan_no']  =    (!empty($SaleInvoiceLabelChangeData['label_invoice_challan_no'] && $SaleInvoiceLabelChangeData['label_invoice_challan_no'] != 'undefined') ? $SaleInvoiceLabelChangeData['label_invoice_challan_no'] : '');
        $SaleInvoiceLabelChange['label_invoice_challan_date']  =    (!empty($SaleInvoiceLabelChangeData['label_invoice_challan_date'] && $SaleInvoiceLabelChangeData['label_invoice_challan_date'] != 'undefined') ? $SaleInvoiceLabelChangeData['label_invoice_challan_date'] : '');
        $SaleInvoiceLabelChange['label_invoice_transport']  =    (!empty($SaleInvoiceLabelChangeData['label_invoice_transport'] && $SaleInvoiceLabelChangeData['label_invoice_transport'] != 'undefined') ? $SaleInvoiceLabelChangeData['label_invoice_transport'] : '');
        $SaleInvoiceLabelChange['label_invoice_extra_information']  =    (!empty($SaleInvoiceLabelChangeData['label_invoice_extra_information'] && $SaleInvoiceLabelChangeData['label_invoice_extra_information'] != 'undefined') ? $SaleInvoiceLabelChangeData['label_invoice_extra_information'] : '');
        $SaleInvoiceLabelChange['label_invoice_terms_and_conditions']  =    (!empty($SaleInvoiceLabelChangeData['label_invoice_terms_and_conditions'] && $SaleInvoiceLabelChangeData['label_invoice_terms_and_conditions'] != 'undefined') ? $SaleInvoiceLabelChangeData['label_invoice_terms_and_conditions'] : '');
        $SaleInvoiceLabelChange['label_invoice_additional_notes']  =    (!empty($SaleInvoiceLabelChangeData['label_invoice_additional_notes'] && $SaleInvoiceLabelChangeData['label_invoice_additional_notes'] != 'undefined') ? $SaleInvoiceLabelChangeData['label_invoice_additional_notes'] : '');
        $SaleInvoiceLabelChange['label_invoice_attachments']  =    (!empty($SaleInvoiceLabelChangeData['label_invoice_attachments'] && $SaleInvoiceLabelChangeData['label_invoice_attachments'] != 'undefined') ? $SaleInvoiceLabelChangeData['label_invoice_attachments'] : '');
        $SaleInvoiceLabelChange['additional_info_label']  =    (!empty($SaleInvoiceLabelChangeData['additional_info_label'] && $SaleInvoiceLabelChangeData['additional_info_label'] != 'undefined') ? $SaleInvoiceLabelChangeData['additional_info_label'] : '');
        $SaleInvoiceLabelChange['label_round_up']  =    (!empty($SaleInvoiceLabelChangeData['label_round_up'] && $SaleInvoiceLabelChangeData['label_round_up'] != 'undefined') ? $SaleInvoiceLabelChangeData['label_round_up'] : '');
        $SaleInvoiceLabelChange['label_round_down']  =    (!empty($SaleInvoiceLabelChangeData['label_round_down'] && $SaleInvoiceLabelChangeData['label_round_down'] != 'undefined') ? $SaleInvoiceLabelChangeData['label_round_down'] : '');
        $SaleInvoiceLabelChange['label_total']  =    (!empty($SaleInvoiceLabelChangeData['label_total'] && $SaleInvoiceLabelChangeData['label_total'] != 'undefined') ? $SaleInvoiceLabelChangeData['label_total'] : '');
        $SaleInvoiceLabelChange['created_by']  =    \Auth::user()->id;
        $SaleInvoiceLabelChange = \App\Models\SaleInvoiceLabelChange::create($SaleInvoiceLabelChange);

        return $requestData;
    }
}
