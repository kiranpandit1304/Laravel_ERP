<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoice extends Model
{
    public $table = 'sale_invoice';
    protected $fillable = [
        'platform', 
        'guard',
        'team_id',
        'created_by',
        'business_id',
        'invoice_title',
        'invoice_sub_title',
        'invoice_no',
        'invoice_date',
        'due_date',
        'invoice_custome_filed',
        'business_logo',
        'business_logo_name',
        'e_invoice_details',
        'company_id',
        'company_name',
        'company_address',
        'customer_id',
        'customer_name',
        'customer_address',
        'is_shipping_detail_req',
        'shipped_from_name',
        'shipped_from_country_id',
        'shipped_from_country_name',
        'shipped_from_address',
        'shipped_from_city',
        'shipped_from_zip_code',
        'shipped_from_state_name',
        'shipped_to_id',
        'shipped_to_name',
        'shipped_to_country_id',
        'shipped_to_country_name',
        'shipped_to_address',
        'shipped_to_city',
        'shipped_to_zip_code',
        'shipped_to_state_name',
        'shipped_to_custome_filed',
        'transport_challan',
        'transport_challan_date',
        'transport_name',
        'transport_information',
        'tax_type',
        'is_tax',
        'currency',
        'final_amount',
        'final_sgst',
        'final_cgst',
        'final_igst',
        'final_product_wise_discount',
        'final_total_discount_reductions_unit',
        'final_total_discount_reductions',
        'final_extra_charges',
        'extra_changes_unit',
        'final_summarise_total_quantity',
        'final_total',
        'is_total_words_show',
        'round_up',
        'round_down',
        'final_total_words',
        'final_total_more_field',
        'terms_and_conditions',
        'additional_notes',
        'add_additional_info',
        'contact_details',
        'is_contact_show',
        'signature',
        'signature_name',
        'invoice_pdf',
        'billing_from_country_id',
        'billing_from_country_name',
        'billing_from_address',
        'billing_from_city',
        'billing_from_zip_code',
        'billing_from_state_name', 
        'billing_to_country_id',
        'billing_to_country_name',
        'billing_to_address',
        'billing_to_city',
        'billing_to_zip_code',
        'billing_to_state_name',
        'color',
        'is_terms_req',
        'is_additional_notes_req',
        'is_attactments_req',
        'is_additional_info_req',
        'template_id',
        'is_delete',
        'payment_status',
     ];


}
