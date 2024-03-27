<?php

namespace App\Exports;

use App\Models\SaleInvoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SaleInvoiceExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $request;
    public function __construct($request = '')
    {
        $this->request = $request;
    }
    public function collection()
    {
        $request = $this->request;        
        if(!empty($request) && $request['id'] != '')
        {
            $user_id = $request['id'];
            $sale_invoice_list = SaleInvoice::whereIn('sale_invoice.id',$request['id']);
            $sale_invoice_list->where('sale_invoice.business_id',$request['business_id']);
            $sale_invoice_list->where('sale_invoice.is_delete', "=", '0');
            $sale_invoice_list->leftjoin('sale_invoice_advance_setting','sale_invoice.id','sale_invoice_advance_setting.invoice_id');
            $sale_invoice_list->leftjoin('sale_invoice_fields','sale_invoice.id','sale_invoice_fields.invoice_id');
            $sale_invoice_list->leftjoin('sale_invoice_label_change','sale_invoice.id','sale_invoice_label_change.invoice_id');
            $sale_invoice_list->leftjoin('currency','sale_invoice.currency','currency.id');
            $sale_invoice_list->leftjoin('users','sale_invoice.created_by','users.id');
            $sale_invoice_list->leftjoin('sale_invoice_client_details','sale_invoice.id','sale_invoice_client_details.invoice_id');
            $sale_invoice_list->leftjoin('customers','sale_invoice_client_details.client_id','customers.id');
            $sale_invoice_list->select('sale_invoice.*','customers.tax_number as gst_no','customers.pan as pan_no','sale_invoice_advance_setting.invoice_id','sale_invoice_advance_setting.number_format','sale_invoice_advance_setting.invoice_country','sale_invoice_advance_setting.decimal_digit_format','sale_invoice_advance_setting.hide_place_of_supply','sale_invoice_advance_setting.hsn_column_view','sale_invoice_advance_setting.show_hsn_summary','sale_invoice_advance_setting.add_original_images','sale_invoice_advance_setting.show_description_in_full_width','sale_invoice_fields.filed_data','sale_invoice_label_change.label_invoice_no','sale_invoice_label_change.label_invoice_date','sale_invoice_label_change.label_invoice_due_date','sale_invoice_label_change.label_invoice_billed_by','sale_invoice_label_change.label_invoice_billed_to','sale_invoice_label_change.label_invoice_shipped_from','sale_invoice_label_change.label_invoice_shipped_to','sale_invoice_label_change.label_invoice_transport_details','sale_invoice_label_change.label_invoice_challan_no','sale_invoice_label_change.label_invoice_challan_date','sale_invoice_label_change.label_invoice_transport','sale_invoice_label_change.label_invoice_extra_information','sale_invoice_label_change.label_invoice_terms_and_conditions','sale_invoice_label_change.label_invoice_additional_notes','sale_invoice_label_change.label_invoice_attachments','currency.type','currency.unit','users.name as CreatedBy');
            $sale_invoice_list->where('sale_invoice.is_delete','0');
            $sale_invoice_list->orderBy('sale_invoice.id','DESC');
            $data = $sale_invoice_list->get();

        }else{

            $user_id = $request['id'];
            $sale_invoice_list = SaleInvoice::where('sale_invoice.created_by',$request['user_id']);
            $sale_invoice_list->where('sale_invoice.business_id',$request['business_id']);
            $sale_invoice_list->where('sale_invoice.is_delete', "=", '0');
            $sale_invoice_list->leftjoin('sale_invoice_advance_setting','sale_invoice.id','sale_invoice_advance_setting.invoice_id');
            $sale_invoice_list->leftjoin('sale_invoice_fields','sale_invoice.id','sale_invoice_fields.invoice_id');
            $sale_invoice_list->leftjoin('sale_invoice_label_change','sale_invoice.id','sale_invoice_label_change.invoice_id');
            $sale_invoice_list->leftjoin('currency','sale_invoice.currency','currency.id');
            $sale_invoice_list->leftjoin('users','sale_invoice.created_by','users.id');
            $sale_invoice_list->leftjoin('sale_invoice_client_details','sale_invoice.id','sale_invoice_client_details.invoice_id');
            $sale_invoice_list->leftjoin('customers','sale_invoice_client_details.client_id','customers.id');
            $sale_invoice_list->select('sale_invoice.*','customers.tax_number as gst_no','customers.pan as pan_no','sale_invoice_advance_setting.invoice_id','sale_invoice_advance_setting.number_format','sale_invoice_advance_setting.invoice_country','sale_invoice_advance_setting.decimal_digit_format','sale_invoice_advance_setting.hide_place_of_supply','sale_invoice_advance_setting.hsn_column_view','sale_invoice_advance_setting.show_hsn_summary','sale_invoice_advance_setting.add_original_images','sale_invoice_advance_setting.show_description_in_full_width','sale_invoice_fields.filed_data','sale_invoice_label_change.label_invoice_no','sale_invoice_label_change.label_invoice_date','sale_invoice_label_change.label_invoice_due_date','sale_invoice_label_change.label_invoice_billed_by','sale_invoice_label_change.label_invoice_billed_to','sale_invoice_label_change.label_invoice_shipped_from','sale_invoice_label_change.label_invoice_shipped_to','sale_invoice_label_change.label_invoice_transport_details','sale_invoice_label_change.label_invoice_challan_no','sale_invoice_label_change.label_invoice_challan_date','sale_invoice_label_change.label_invoice_transport','sale_invoice_label_change.label_invoice_extra_information','sale_invoice_label_change.label_invoice_terms_and_conditions','sale_invoice_label_change.label_invoice_additional_notes','sale_invoice_label_change.label_invoice_attachments','currency.type','currency.unit','users.name as CreatedBy');
            $sale_invoice_list->where('sale_invoice.is_delete','0');
            $sale_invoice_list->orderBy('sale_invoice.id','DESC');
            $data = $sale_invoice_list->get();

            }
       

        foreach($data as $k => $invoice)
        {
            unset(
                 
                $invoice->platform, 
                $invoice->guard, 
                $invoice->business_id,
                $invoice->platform,  
                $invoice->guard,   
                $invoice->business_id,   
                $invoice->invoice_title, 
                $invoice->invoice_sub_title,   
                //$invoice->invoice_no,  
                //$invoice->invoice_date,  
                //$invoice->due_date,   
                $invoice->invoice_custome_filed,   
                $invoice->business_logo,   
                $invoice->business_logo_name,   
                $invoice->e_invoice_details,   
                $invoice->company_id,  
                $invoice->company_name,   
                $invoice->company_address,  
                $invoice->customer_id,  
                //$invoice->customer_name,   
                $invoice->customer_address,   
                $invoice->is_shipping_detail_req,   
                $invoice->shipped_from_name,   
                $invoice->shipped_from_country_id,  
                $invoice->shipped_from_country_name,   
                $invoice->shipped_from_address,   
                $invoice->shipped_from_city,   
                $invoice->shipped_from_zip_code,   
                $invoice->shipped_from_state_name,   
                $invoice->shipped_to_id,  
                $invoice->shipped_to_name,   
                $invoice->shipped_to_country_id,   
                $invoice->shipped_to_country_name,   
                $invoice->shipped_to_address,   
                $invoice->shipped_to_city,   
                $invoice->shipped_to_zip_code,   
                $invoice->shipped_to_state_name,   
                $invoice->billing_from_country_id,   
                $invoice->billing_from_country_name,   
                $invoice->billing_from_address,   
                $invoice->billing_from_city,   
                $invoice->billing_from_zip_code,   
                $invoice->billing_from_state_name,   
                $invoice->billing_to_country_id,   
                $invoice->billing_to_country_name,   
                $invoice->billing_to_address,   
                $invoice->billing_to_city,   
                $invoice->billing_to_zip_code,   
                $invoice->billing_to_state_name,   
                $invoice->shipped_to_custome_filed,  
                $invoice->transport_challan,   
                $invoice->transport_challan_date,  
                $invoice->transport_name,   
                $invoice->transport_information,   
                $invoice->tax_type,                  
                $invoice->currency,   
                // $invoice->final_amount,                        
                $invoice->final_product_wise_discount,   
                $invoice->final_total_discount_reductions_unit,   
                $invoice->extra_changes_unit,  
                $invoice->final_summarise_total_quantity,   
                $invoice->round_up,   
                $invoice->round_down,   
                $invoice->is_total_words_show,   
                $invoice->final_total_words,   
                $invoice->final_total_more_filed,   
                $invoice->terms_and_conditions,   
                $invoice->additional_notes,   
                $invoice->add_additional_info,   
                $invoice->contact_details,   
                $invoice->is_contact_show,   
                $invoice->signature,   
                $invoice->signature_name,   
                $invoice->invoice_pdf,   
                $invoice->color, 
                $invoice->is_terms_req,   
                $invoice->is_additional_notes_req,   
                $invoice->is_attactments_req,   
                $invoice->is_additional_info_req,  
                $invoice->template_id,  
                $invoice->team_id,   
                $invoice->created_by,   
                //$invoice->payment_status,   
                $invoice->is_delete,   
                $invoice->created_at,   
                $invoice->updated_at,  
                $invoice->invoice_id,   
                $invoice->number_format,   
                $invoice->invoice_country,   
                $invoice->decimal_digit_format,   
                $invoice->hide_place_of_supply,   
                $invoice->hsn_column_view,   
                $invoice->show_hsn_summary,   
                $invoice->add_original_images,   
                $invoice->show_description_in_full_width,   
                $invoice->filed_data,   
                $invoice->label_invoice_no,   
                $invoice->label_invoice_date,   
                $invoice->label_invoice_due_date,   
                $invoice->label_invoice_billed_by,   
                $invoice->label_invoice_billed_to,   
                $invoice->label_invoice_shipped_from,   
                $invoice->label_invoice_shipped_to,   
                $invoice->label_invoice_transport_details,   
                $invoice->label_invoice_challan_no,   
                $invoice->label_invoice_challan_date,   
                $invoice->label_invoice_transport,   
                $invoice->label_invoice_extra_information,   
                $invoice->label_invoice_terms_and_conditions,   
                $invoice->label_invoice_additional_notes,  
                $invoice->label_invoice_attachments,   
               // $invoice->type,   
               // $invoice->unit,   
                   
            );
            $data[$k]["Date"]     = date('F d, Y', strtotime(@$invoice->invoice_date));
            $data[$k]["Invoice"]     = @$invoice->invoice_no;
            $data[$k]["Billed To"]     = @$invoice->customer_name;
            $data[$k]["Amount"]     = @$invoice->final_total;
            $data[$k]["Status"]     = @$invoice->payment_status;
           // $data[$k]["Currency"]     = @$invoice->unit.' '.@$invoice->type;
           // $data[$k]["Place Of Supply"]     = '';
           // $data[$k]["Next Scheduled Date"]     = '';

            $amount_recived_sum =  \App\Models\SaleInvoiceAddPayment::where('invoice_id',@$invoice->id)
            ->sum('amount_received');
            $total_tcs_amount =  \App\Models\SaleInvoiceAddPayment::where('invoice_id',@$invoice->id)->sum('tcs_amount');
            $total_tds_amount =  \App\Models\SaleInvoiceAddPayment::where('invoice_id',@$invoice->id)->sum('tds_amount');
            $total_transaction_charge =  \App\Models\SaleInvoiceAddPayment::where('invoice_id',@$invoice->id)->sum('transaction_charge');
            $amount_recived =  \App\Models\SaleInvoiceAddPayment::where('invoice_id',@$invoice->id)
            ->orderBy('invoice_id',"DESC")
            ->first();

            $final_total = (!empty($invoice->final_total) ? $invoice->final_total : 0);
            $grand_total_paid = $amount_recived_sum + $total_tcs_amount + $total_tds_amount + $total_transaction_charge;
            $due_amount = (float)$final_total - (float)$grand_total_paid;
            $data[$k]["Payment Date"]     = (!empty($grand_total_paid) ? @$invoice->invoice_date : '');
            //$data[$k]["Due Date"]     = date('F d, Y', strtotime(@$invoice->due_date));
            //$data[$k]["GST/Non-GST"]     = @$invoice->is_tax;
           //$data[$k]["GST Rate"]     = '18%';
             
            $data[$k]["GSTIN/UIN of Recipient"]     = @$invoice->gst_no;
            $data[$k]["PAN"]     = @$invoice->pan_no;
            $data[$k]["IRN Status"]     = '-';
            $data[$k]["Invoice Email"]     = '-';
            $data[$k]["Amount Paid"]     = number_format(@$grand_total_paid, 2);
            $data[$k]["TCS"]     = number_format(@$total_tcs_amount, 2);
            $data[$k]["TDS"]     = number_format(@$total_tds_amount, 2);
            @$due_amount = $due_amount > 0 ? $due_amount : 0;
            $data[$k]["Amount Due"]     = number_format(@$due_amount, 2);
            $data[$k]["Invoice Amount"]     = number_format(@$invoice->final_total, 2);

            /*$data[$k]["Taxable Value"]     = "QA";
            //get hsn code
            $get_hsn =  \App\Models\SaleInvoiceProduct::where('invoice_id',@$invoice->id)->get();
            $hsn_code = [];
            if(!empty($get_hsn))
            {
                foreach ($get_hsn as $key => $value) {
                    array_push($hsn_code, $value->product_hsn_code);
                }
            }           
            $data[$k]["HSN/SAC list"]     = implode(',', $hsn_code);
            $data[$k]["Total Additional Charges"]     = @$invoice->final_extra_charges;*/
           //$data[$k]["Created By"]     = @$invoice->CreatedBy;
             unset(
                $invoice->id,
                $invoice->invoice_no,  
                $invoice->invoice_date,
                $invoice->customer_name,
                $invoice->final_amount,
                $invoice->payment_status,
                $invoice->due_date,
                $invoice->type,   
                $invoice->unit,
                $invoice->gst_no,   
                $invoice->pan_no,  
                $invoice->is_tax, 
                $invoice->final_igst,
                $invoice->final_cgst, 
                $invoice->final_sgst,
                $invoice->final_total,  
                $invoice->final_total_discount_reductions,
                $invoice->final_extra_charges, 
                $invoice->CreatedBy,  
            );

        }
       return $data;
    }

    public function headings(): array
    {
        return [
            "Date",
            "Invoice#",
            "Billed To",
            "Amount",
            "Status",
            //"Currency",
            //"Place Of Supply",
           // "Next Scheduled Date",
            "Payment Date",
            //"Due Date",
            
            //"GST/Non-GST",
           // "GST Rate",
           
           // "SGST",
            "GSTIN/UIN of Recipient",
            "PAN",
            "IRN Status",
            "Invoice Email",
            "Amount Paid",
            "TCS",
            "TDS",
            "Amount Due",
            "Invoice Amount",
            /*"Discount",
            "Taxable Value",
            "HSN/SAC list",
            "Total Additional Charges",
            "Created By",*/
        
        ];
    }
}
