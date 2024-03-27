<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleInvoiceLabelChange extends Model
{
    public $table = 'sale_invoice_label_change';
    protected $fillable = [
        'invoice_id',
        'label_invoice_no',
        'label_invoice_date',
        'label_invoice_due_date',
        'label_invoice_billed_by',
        'label_invoice_billed_to',
        'label_invoice_shipped_from',
        'label_invoice_shipped_to',
        'label_invoice_transport_details',
        'label_invoice_challan_no',
        'label_invoice_challan_date',
        'label_invoice_transport',
        'label_invoice_extra_information',
        'label_invoice_terms_and_conditions',
        'label_invoice_additional_notes',
        'label_invoice_attachments',
        'additional_info_label',
        'label_round_up',
        'label_round_down',
        'label_total',
        'created_by',
     ];

    
}
