@extends('allFrontendViews.layouts.app')
@section('page-title')
{{__('Create invoice')}}
@endsection
@push('css-page')
<link rel="stylesheet" href="{{asset('unsync_assets/assets/css/select2.css')}}" />
<link rel="stylesheet" href="{{asset('unsync_assets/assets/css/select2-bootstrap4.css')}}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.2.0/tailwind.min.css" />

<link href="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" />
<link href="https://erp.unesync.com/assets/js/plugins/dropzone/css/dropzone.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.1/styles/default.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/codemirror.min.css" />
<link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor.min.css" />
@endpush
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 flush">
            <div class="the_mini_header">
                @if($saleInvoice->is_delete != 1)
                <div class="page_head forinvoice">
                    <div class="actions_bar">
                        <div class="filter_main">
                            <ul class="main_steps">
                                <li class="">
                                    <span>1</span>
                                    <p> <a href="{{route('fn.invoice_step1', [$enypt_id, $invoice_id])}}">Invoice Details </a></p>
                                </li>
                                <li class="">
                                    <span>2</span>
                                    <p> <a href="{{route('fn.invoice_step2', [$enypt_id, $invoice_id])}}"> Your Bank Details</a></p>
                                </li>
                                <li class="active">
                                    <span>3</span>
                                    <p> <a href="{{route('fn.invoice_step3', [$enypt_id, $invoice_id])}}"> Select Design & Colors</a></p>
                                </li>
                            </ul>
                            <!-- <span class="bg_darkblu squre_icon"><iconify-icon icon="icon-park-outline:ad-product"></iconify-icon></span> -->
                            <!-- <select class="ddl-select" id="listc1" name="list">
                                                <option value="1">All Categories (10)</option>
                                                <option value="2">Shirts (5)</option>
                                                <option value="2">T-shirts (5)</option>
                                            </select> -->
                        </div>
                        <div class="action_btns">
                            <button class="btn_secondary" data-toggle="modal" data-target="#shareInvoice"><iconify-icon icon="basil:share-outline"></iconify-icon> Share</button>
                            <a class="btn btn-primary" target="_blank" href="{{url('/api/SaleInvoice/Pdf/'.$invoice_id .'/'.$templete_id.'/'.$auth_user->id.'?copy='.$copy_type)}}"><iconify-icon icon="material-symbols:download"></iconify-icon> Download</a class="btn btn-primary" href="">
                        </div>
                    </div>
                </div>
                @endif
                <div class="editing_option">
                    <div class="action_invoice_buttons">
                        <div class="left_side">
                            @if(empty($copy_id) && $saleInvoice->is_delete != 1)
                            <a class="" href="{{route('fn.invoice_step1', [$enypt_id, $invoice_id])}}"><iconify-icon icon="material-symbols:edit"></iconify-icon> Edit</a>
                            <button class="show_payment_btn" title="{{$invoice_id}}" data-page="step3"><iconify-icon icon="fa-solid:money-bill-alt"></iconify-icon> Add Payment Details</button>
                            @endif
                            <button><iconify-icon icon="ic:baseline-print"></iconify-icon> Print</button>
                        </div>
                        @if(empty($copy_id) && $saleInvoice->is_delete != 1)
                        <div class="right_side">
                            <a class="btn btn-primary" type="button" href="{{route('fn.invoice_step1', $enypt_id)}}"><iconify-icon icon="pajamas:plus"></iconify-icon> Create Another Invoice</a>
                            <div class="dropdown more">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <iconify-icon icon="ep:arrow-down-bold"></iconify-icon>
                                </button>
                                <ul class="dropdown-menu" style="">
                                    <li>
                                        <a class="dropdown-item" href="{{route('fn.invoice_step1', $enypt_id)}}">Create New Invoice</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">Generate IRN</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">Generate Delivery Challan</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item sendWhatsAppReminder" href="#">Send Reminder by Whatsapp</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">Send Reminder by Email</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" target="_blank" href="{{route('fn.invoice_step3', [$enypt_id, $invoice_id, 'copy=RHVwbGljYXRl'])}}">View/Print Duplicate Invoice</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" target="_blank" href="{{route('fn.invoice_step3', [$enypt_id, $invoice_id, 'copy=VHJpcGxpY2F0ZQ'])}}">View/Print Triplicate Invoice</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">Add Custom Label</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">Create Credit Note</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">Create Debit Note</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item duplicate_inv" title="{{@$invoice_id}}" href="javascript:void()" data-page="step3">Duplicate Invoice</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item delte_invoice_btn" href="javascript:void(0)" title="{{@$invoice_id}}" data-page="step3">Delete Invoice</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item cancel_invoice_btn" href="javascript:void(0)" title="{{@$invoice_id}}" data-page="step3">Cancel Invoice</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div id="main_wrapper" class="forinvoice">
                <div class="content_page invoice_laststep">
                    @if(empty($copy_id) && $saleInvoice->is_delete != 1)
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <iconify-icon icon="mdi:invoice"></iconify-icon> Invoice Summary
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="five_cards">
                                        <div class="sum_card">
                                            <label for="">{{ !empty($saleInvoice->label_invoice_no) ? $saleInvoice->label_invoice_no : 'Invoice No'}} </label>
                                            <h3>{{@$saleInvoice->invoice_no}}</h3>
                                        </div>
                                        <div class="sum_card">
                                            <label for="">{{ !empty($saleInvoice->label_invoice_date) ? $saleInvoice->label_invoice_date : 'Invoice Date'}}</label>
                                            <h3>{{date('F d, Y', strtotime($saleInvoice->invoice_date))}}</h3>
                                        </div>
                                        <div class="sum_card">
                                            <label for="">{{ !empty($saleInvoice->label_invoice_due_date) ? $saleInvoice->label_invoice_due_date : 'Due Date'}}</label>
                                            <h3>{{date('F d, Y', strtotime($saleInvoice->due_date))}}
                                                <?php
                                                $is_over_due = '';
                                                if (!empty($saleInvoice->due_date)  && $saleInvoice->payment_status != 'Paid') {
                                                    $current_date1 =  date("Y-m-d");
                                                    $current_date = date("Y-m-d", strtotime($current_date1));
                                                    $due_date = date("Y-m-d", strtotime($saleInvoice->due_date));
                                                    if ($current_date > $due_date) {
                                                        $is_over_due = 'Overdue';
                                                    }
                                                }
                                                ?>
                                                <span>{{$is_over_due}} </span>
                                            </h3>
                                        </div>
                                        <div class="sum_card">
                                            <label for="">Total Amount</label>
                                            <h3>{{@$saleInvoice->final_total}}</h3>
                                        </div>
                                        <div class="sum_card">
                                            <label for="">Payment Options</label>
                                            <h3>
                                                @if(!empty($SaleInvoiceBankDetails->account_holder_name) || !empty($SaleInvoiceBankDetails->account_no) || !empty($SaleInvoiceBankDetails->bank_name) )
                                                Account Transfer
                                                @endif
                                                @if(!empty($SaleInvoiceBankUpi->upi_id))
                                                , UPI
                                                @endif
                                            </h3>
                                        </div>
                                        <div class="sum_card">
                                            <label for="">{{ !empty($saleInvoice->label_invoice_billed_to) ? $saleInvoice->label_invoice_billed_to : 'Billed To'}}</label>
                                            <h3>{{@$saleInvoice->customer_name}}
                                                <!-- <b>{{@$saleInvoice->shipped_to_country_name}}</b> -->
                                            </h3>
                                        </div>
                                        <div class="sum_card">
                                            <label for="">Created by</label>
                                            <h3>{{@$saleInvoice->CreatedBy}}</h3>
                                        </div>
                                        <div class="sum_card">
                                            <label for="">Balance</label>
                                            <h3>{{@$saleInvoice->final_total}}( Due )</h3>
                                        </div>
                                    </div>
                                    <div class="summ_footer">
                                        <div class="ot_options">
                                            <button data-toggle="modal" data-target="#einvoicedetails">Generate E-Invoice</button>
                                            <button>Generate Delivery Challan</button>
                                            <!-- <button class="show_kyc_btn" >Add new KYC document</button> -->
                                            <!-- <button data-toggle="modal" data-target="#chargeLate">Add Late payment fee</button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @php
                    $active_theme='';
                    if(!empty($saleInvoice->template_id) && $saleInvoice->template_id =='1'){
                    $active_theme = 'theme1';
                    }else if(!empty($saleInvoice->template_id) && $saleInvoice->template_id == '2'){
                    $active_theme = 'theme2';

                    }else if(!empty($saleInvoice->template_id) && $saleInvoice->template_id == '3'){
                    $active_theme = 'theme3';

                    }else if(!empty($saleInvoice->template_id) && $saleInvoice->template_id == '4'){
                    $active_theme = 'theme4';
                    }
                    $color = @$saleInvoice->color;
                    @endphp
                    <div class="invoice_preview {{$active_theme}} {{$color}}">
                        <div class="ip_header">
                            <h2 class="for_theme_3">{{!empty($saleInvoice->invoice_title) ? $saleInvoice->invoice_title : 'Invoice'}}
                            </h2>
                            <div class="sm_info">
                                <div class="sm_left">
                                    <h2>{{!empty($saleInvoice->invoice_title) ? $saleInvoice->invoice_title : 'Invoice'}}
                                        <br />
                                        <p>{{!empty($saleInvoice->invoice_sub_title) ? $saleInvoice->invoice_sub_title : ''}}</p>
                                    </h2>
                                    <ul>
                                        <li><span>{{ !empty($saleInvoice->label_invoice_no) ? $saleInvoice->label_invoice_no : 'Invoice No'}}#</span>{{@$saleInvoice->invoice_no}}</li>
                                        <li><span>{{ !empty($saleInvoice->label_invoice_date) ? $saleInvoice->label_invoice_date : 'Invoice Date'}}</span>{{date('F d, Y', strtotime($saleInvoice->invoice_date))}}</li>
                                        <li><span>{{ !empty($saleInvoice->label_invoice_due_date) ? $saleInvoice->label_invoice_due_date : 'Due Date' }}</span>{{date('F d, Y', strtotime($saleInvoice->due_date))}}</li>
                                        <li><span>Created By</span>{{@$saleInvoice->CreatedBy}}</li>
                                        @php
                                        $invoice_custome_filed = json_decode($saleInvoice->invoice_custome_filed)
                                        @endphp
                                        @if(!empty($invoice_custome_filed))
                                        @foreach($invoice_custome_filed as $custome_filed)
                                        @if(!empty($custome_filed->value))
                                        <li><span>{{$custome_filed->key}}</span> {{$custome_filed->value}}</li>
                                        @endif
                                        @endforeach
                                        @endif
                                    </ul>
                                </div>
                                <div class="sm_right">
                                    {{@$copy_type}}
                                    <img src="{{ !empty($saleInvoice->business_logo) && $saleInvoice->business_logo != 'undefined' ? $saleInvoice->business_logo : asset('unsync_assets/assets/images/logo.png') }}" alt="">
                                </div>
                            </div>
                            <div class="einvoice">
                                <div class="left_side">
                                    <ul>
                                        <li><span>IRN:</span>9as9d8as9d85sa98as95d9as5d9</li>
                                        <li><span>Ack No:</span>12136456548</li>
                                        <li><span>Ack Date:</span>20-03-2023 15:35:00</li>
                                    </ul>
                                </div>
                                <div class="rightside">
                                    <img src="{{asset('unsync_assets/assets/images/qr_code.png')}}" alt="">
                                </div>
                            </div>
                            <div class="bill_details">
                                <div class="bill_by">
                                    <h2>{{ !empty($saleInvoice->label_invoice_billed_by) ? $saleInvoice->label_invoice_billed_by : 'Billed By'}}</h2>
                                    <h6>{{@$saleInvoice->company_name}}</h6>
                                    <p>{{@$saleInvoice->company_address}} <br />
                                    </p>
                                </div>
                                <div class="bill_to">
                                    <h2>{{ !empty($saleInvoice->label_invoice_billed_to) ? $saleInvoice->label_invoice_billed_to : 'Billed To'}}</h2>
                                    <h6>{{@$saleInvoice->customer_name}}</h6>
                                    <p>
                                        {{@$saleInvoice->customer_address}}<br />
                                    </p>
                                </div>
                            </div>
                            @if($saleInvoice->is_shipping_detail_req)
                            <div class="bill_details">
                                <div class="bill_by">
                                    <h2>{{ !empty($saleInvoice->label_invoice_shipped_from) ? $saleInvoice->label_invoice_shipped_from : 'Shipped From'}}</h2>
                                    <h6>{{@$saleInvoice->shipped_from_name}}</h6>
                                    <p>
                                        {{@$saleInvoice->shipped_from_address}}<br />
                                        {{@$saleInvoice->shipped_from_state_name}} {{@$saleInvoice->shipped_from_city}} - {{@$saleInvoice->shipped_from_zip_code}} {{@$saleInvoice->shipped_from_country_name}}
                                    </p>
                                </div>
                                <div class="bill_to">
                                    <h2>{{ !empty($saleInvoice->label_invoice_shipped_to) ? $saleInvoice->label_invoice_shipped_to : 'Shipped To'}}</h2>
                                    <h6>{{@$saleInvoice->shipped_to_name}}</h6>
                                    <p>{{@$saleInvoice->shipped_to_address}} <br />
                                        {{@$saleInvoice->shipped_to_state_name}} {{@$saleInvoice->shipped_to_city}} - {{@$saleInvoice->shipped_to_zip_code}} {{@$saleInvoice->shipped_to_country_name}}
                                        <br />
                                        @php
                                        $shipped_to_custom_filed = json_decode($saleInvoice->shipped_to_custome_filed)
                                        @endphp
                                        @if(!empty($shipped_to_custom_filed))
                                        @foreach($shipped_to_custom_filed as $custome_filed)
                                        @if(!empty($custome_filed->value))
                                        <b> {{$custome_filed->key}}: </b>&nbsp; {{$custome_filed->value}}
                                        <br />
                                        @endif
                                        @endforeach
                                        @endif

                                    </p>
                                </div>
                            </div>
                            @if(!empty($saleInvoice->transport_name) || !empty($saleInvoice->transport_challan))
                            <div class="bill_details transport">
                                <div class="bill_by">
                                    <h2>{{ !empty($saleInvoice->label_invoice_transport_details) ? $saleInvoice->label_invoice_transport_details : 'Transport Details'}}</h2>
                                    <ul>
                                        <li><span>{{ !empty($saleInvoice->label_invoice_transport) ? $saleInvoice->label_invoice_transport : 'Transport'}}:</span>{{@$saleInvoice->transport_name}}</li>
                                        <li><span>{{ !empty($saleInvoice->label_invoice_challan_date) ? $saleInvoice->label_invoice_challan_date : 'Challan Date'}}:</span>{{ !empty($saleInvoice->transport_challan_date) && $saleInvoice->transport_challan_date!='undefined' ?  date('F d, Y', strtotime($saleInvoice->transport_challan_date)) : ''}}</li>
                                        <li><span>{{ !empty($saleInvoice->label_invoice_challan_no) ? $saleInvoice->label_invoice_challan_no : 'Challan Number'}}:</span>{{@$saleInvoice->transport_challan}}</li>
                                        <li><span>{{ !empty($saleInvoice->label_invoice_extra_information) ? $saleInvoice->label_invoice_extra_information : 'Extra Information'}}:</span>{{@$saleInvoice->transport_information}}</li>
                                    </ul>
                                </div>
                            </div>
                            @endif
                            @endif
                        </div>
                        <div class="ip_body">
                            <div class="table-responsive">
                                @php
                                $gindex = 0;
                                $pindex = 0;
                                $saleInvoiceAllData = json_decode($saleInvoice->filed_data);
                                $is_merge = !empty($saleInvoice->hsn_column_view==1) ? 1 : 0;
                                @endphp
                                <table>
                                    <thead>
                                        <tr>

                                            <th></th>
                                            @foreach($saleInvoiceAllData[0]->columns as $key=>$data)
                                            @if(@$data->hide != 1)
                                            @if($data->unique_key == 'HSN_SAC')
                                            @if($is_merge !== 1)
                                            <th width="10">{{@$data->column_name}}</th>
                                            @endif
                                            @else
                                            <th width="10">{{@$data->column_name}}</th>
                                            @endif
                                            @endif
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $dataToPrint = array_slice($saleInvoiceAllData,0,count($saleInvoiceAllData)-1); @endphp
                                        @foreach($dataToPrint as $key=>$invoiceProduct)
                                        <!-- ...group listing -->
                                        @if($invoiceProduct->is_group==1)
                                        <?php $gindex = 0; ?>
                                        <tr class="item-group-row full-width hide-background">
                                            <td colspan="100" class="" style="text-align: left; background: #fff; font-weight: 600;"><?= $invoiceProduct->data[1]->field_val ?></td>
                                        </tr>
                                        @foreach($invoiceProduct->data[1]->fields as $key=>$fieldsData)
                                        <?php
                                        $gindex++; ?>
                                        @if($number % 2 == 0)
                                        <tr class="alternate">
                                            @else
                                        <tr>
                                            @endif
                                            @foreach($fieldsData as $key=>$data)

                                            @if($key==0)
                                            <td width="10">{{$gindex}}</td>
                                            @endif
                                            @if(@$data->hide != 1)
                                            <!-- .Showin item value -->
                                            @if($key==0)
                                            <?php
                                            $hsn_text = '';
                                            if ($is_merge) {
                                                $hsn_text = '(HSN/SAC: ' . @$fieldsData[1]->row_hsn_val . ' )';
                                            }
                                            $item_name = explode('(', $data->field_val);
                                            ?>
                                            <td width="12">
                                                {{$item_name[0]}}
                                                {{$hsn_text}}
                                            </td>
                                            @else
                                            <!-- .Showin other columns value -->
                                            @if($data->unique_key != 'HSN_SAC')
                                            <!-- showing % with rate -->
                                            @if($data->unique_key == 'GST_Rate')
                                            <td width="10">{{$data->field_val}} %</td>
                                            @else
                                            <td width="10">{{$data->field_val}}</td>
                                            @endif

                                            @else
                                            <!-- check hsn is merge or split -->
                                            @if($is_merge != 1 && $data->unique_key == 'HSN_SAC')
                                            <td width="10">{{$data->field_val}}</td>
                                            @endif

                                            @endif
                                            @endif

                                            @endif
                                            @endforeach
                                        </tr>
                                        <?php $description = \App\Helpers\CommonHelper::getDecription(@$invoice_id, @$fieldsData[1]->main_index); ?>
                                        @if(!empty($description) && $description->product_description != "")
                                        <tr class="large-item-row description full-remaining-width">
                                            <!-- <td></td> -->
                                            <td colspan="100" class="desc-column">
                                                <div class="sc-hBbWxd hYJyQg">
                                                    <div>
                                                        <div class="toastui-editor-contents" style="overflow-wrap: break-word;">
                                                            <p data-nodeid="3">
                                                                {{$description->product_description}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                        <?php $SaleInvoiceMedia = \App\Helpers\CommonHelper::getProductMedia(@$invoice_id, @$fieldsData[1]->main_index, @$invoiceProduct->data[0]->field_product_id, @$advanceSetting->add_original_images); ?>
                                        @if(!empty($SaleInvoiceMedia['get_product_media']) && count($SaleInvoiceMedia['get_product_media']) > 0 )
                                        <tr class="images">
                                            <td></td>
                                            <td colspan="100">
                                                <span>
                                                    @foreach($SaleInvoiceMedia['get_product_media'] as $groupt_img)
                                                    @if(!empty($groupt_img['invoice_product_image']))
                                                    <a href="{{@$groupt_img['invoice_product_image']}}" target="_blank" rel="noopener noreferrer" style="padding: 0px 15px;"><img height="40" width="40" alt="{{@$groupt_img['invoice_product_image']}}" src="{{@$groupt_img['invoice_product_image']}}" srcset="{{@$groupt_img['invoice_product_image']}}" /></a>
                                                    @endif
                                                    @endforeach
                                                </span>
                                            </td>
                                        </tr>
                                        @endif
                                        <!---- main group img -->
                                        @if(!empty($SaleInvoiceMedia['get_original_images']) && count($SaleInvoiceMedia['get_original_images']) > 0 && @$advanceSetting->add_original_images == 1)
                                        <tr class="images">
                                            <td></td>
                                            <td colspan="100">
                                                <span>
                                                    @foreach($SaleInvoiceMedia['get_original_images'] as $product_img)
                                                    @if(!empty($product_img['product_image']))
                                                    <a href="{{@$product_img['product_image']}}" target="_blank" rel="noopener noreferrer" style="padding: 0px 15px;"><img height="40" width="40" alt="{{@$product_img['product_image']}}" src="{{@$product_img['product_image']}}" srcset="{{@$product_img['product_image']}}" /></a>
                                                    @endif
                                                    @endforeach
                                                </span>
                                            </td>
                                        </tr>
                                        @endif
                                        <!-- end group media -->
                                        @endforeach
                                        <tr class="large-item-row aside-collpased gst-invoice strong alternate">
                                            @foreach($invoiceProduct->data[1]->fields as $key=>$fieldsData)
                                            @if($key == 0)
                                            <td class="" width="10"><span class=""></span></td>
                                            <td class="" width="10"><span class=""><b>Sub total</b></span></td>
                                            @foreach($fieldsData as $key=>$data)

                                            @if(@$data->hide != 1)
                                            @if($key != 0)
                                            @if($data->unique_key == 'HSN_SAC')
                                            @if($is_merge != 1)
                                            <td width="10"></td>
                                            @endif
                                            @else

                                            @if($data->column_name == 'Quantity')
                                            <td class="" width="10"><b>{{$invoiceProduct->data[0]->total_qty}}</b></td>
                                            @elseif($data->column_name == 'Amount')
                                            <td class="" width="10"><b>{{$invoiceProduct->data[0]->total_amt}}</b></td>
                                            @elseif($data->column_name == 'Total')
                                            <td class="" width="10"><b>{{$invoiceProduct->data[0]->total_row}}</b></td>
                                            @else
                                            <td class="" width="10"></td>
                                            @endif
                                            @endif

                                            @endif
                                            @endif

                                            @endforeach

                                            @endif
                                            @endforeach
                                        </tr>
                                        @else
                                        <!-- ...product listing -->
                                        <?php $idnx = 1; ?>
                                        @php $pindex++; @endphp
                                        @foreach($invoiceProduct as $key=>$fieldsData)
                                        @if($key != 'columns')
                                        @if($number % 2 == 0)
                                        <tr class="alternate">
                                            @else
                                        <tr>
                                            @endif
                                            @foreach($fieldsData as $key=>$fdata)
                                            @if($key==0)
                                            <td width="10">{{$pindex}}.</td>
                                            @endif
                                            @if(@$fdata->hide != 1)
                                            <!-- showing item value -->
                                            @if($key==0)
                                            <?php
                                            $hsn_text = '';
                                            if ($is_merge) {
                                                $hsn_text = '(HSN/SAC: ' . @$fieldsData[1]->row_hsn_val . ')';
                                            }
                                            $item_name = explode('(', $fdata->field_val); ?>
                                            <td width="12">{{$item_name[0]}}
                                                {{$hsn_text}}
                                            </td>
                                            @else
                                            <!-- Other columns values -->
                                            @if($fdata->unique_key != 'HSN_SAC')
                                            <!-- showing % with rate -->
                                            @if($fdata->unique_key == 'GST_Rate')
                                            <td width="10">{{$fdata->field_val}} %</td>
                                            @else
                                            <td width="10">{{$fdata->field_val}}</td>
                                            @endif
                                            @else
                                            <!-- checking hsn in merge or split -->
                                            @if($is_merge != 1 && $fdata->unique_key == 'HSN_SAC')
                                            <td width="10">{{$fdata->field_val}}</td>
                                            @endif
                                            @endif
                                            <!-- <td width="10">{{$fdata->field_val}}</td> -->
                                            @endif
                                            @endif
                                            @endforeach
                                        </tr>
                                        @endif
                                        <?php
                                        $description = \App\Helpers\CommonHelper::getDecription(@$invoice_id, @$fieldsData[1]->main_index);
                                        ?>
                                        @if(!empty($description) && $description->product_description != "")
                                        <tr class="large-item-row description full-remaining-width">
                                            <!-- <td></td> -->
                                            <td colspan="100" class="desc-column">
                                                <div class="sc-hBbWxd hYJyQg">
                                                    <div>
                                                        <div class="toastui-editor-contents" style="overflow-wrap: break-word;">
                                                            <p data-nodeid="3">
                                                                {{$description->product_description}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                        <?php $SaleInvoiceMedia = \App\Helpers\CommonHelper::getProductMedia(@$invoice_id, @$fieldsData[1]->main_index, @$invoiceProduct->data[0]->field_product_id, @$advanceSetting->add_original_images);
                                      ?>
                                        @if(!empty($SaleInvoiceMedia['get_product_media']) && count($SaleInvoiceMedia['get_product_media']) > 0 )
                                        <tr class="images">
                                            <td></td>
                                            <td colspan="100">
                                                <span>
                                                    @foreach($SaleInvoiceMedia['get_product_media'] as $product_img)
                                                    @if(!empty($product_img['invoice_product_image']))
                                                    <a href="{{@$product_img['invoice_product_image']}}" target="_blank" rel="noopener noreferrer" style="padding: 0px 15px;"><img height="40" width="40" alt="{{@$product_img['invoice_product_image']}}" src="{{@$product_img['invoice_product_image']}}" srcset="{{@$product_img['invoice_product_image']}}" /></a>
                                                    @endif
                                                    @endforeach
                                                </span>
                                            </td>
                                        </tr>
                                        @endif
                                        <!---- main img -->
                                        @if(!empty($SaleInvoiceMedia['get_original_images']) && count($SaleInvoiceMedia['get_original_images']) > 0 && @$advanceSetting->add_original_images == 1)
                                        <tr class="images">
                                            <td></td>
                                            <td colspan="100">
                                                <span>
                                                    @foreach($SaleInvoiceMedia['get_original_images'] as $product_img)
                                                    @if(!empty($product_img['product_image']))
                                                    <a href="{{@$product_img['product_image']}}" target="_blank" rel="noopener noreferrer" style="padding: 0px 15px;"><img height="40" width="40" alt="{{@$product_img['product_image']}}" src="{{@$product_img['product_image']}}" srcset="{{@$product_img['product_image']}}" /></a>
                                                    @endif
                                                    @endforeach
                                                </span>
                                            </td>
                                        </tr>
                                        @endif
                                        <!-- ..end media -->
                                        @endforeach
                                        <!-- end product listing -->
                                        @endif
                                        @endforeach
                                        <!-- ..Grand total -->
                                        @if($saleInvoice->final_summarise_total_quantity == 1)
                                        @php $grand_toalValues = end($saleInvoiceAllData); @endphp
                                        <tr class="large-item-row aside-collpased gst-invoice strong alternate">
                                            @foreach($saleInvoiceAllData[0]->data as $key=>$data)
                                            @if(@$data->hide != 1)

                                            @if($key == 0)
                                            <td class="" width="10"><span class=""></span></td>
                                            <td class="" width="10"><span class=""><b>Total</b></span></td>
                                            @else
                                            @if($data->unique_key == 'HSN_SAC')
                                            @if($is_merge != 1)
                                            <td width="10"></td>
                                            @endif
                                            @else
                                            @if($data->column_name == 'Quantity')
                                            <td class="" width="10"><b>{{$grand_toalValues->grand_total_qty }}</b></td>
                                            @elseif($data->column_name == 'Amount')
                                            <td class="" width="10"><b>{{$grand_toalValues->grand_total_amt }}</b></td>
                                            @elseif($data->column_name == 'Total')
                                            <td class="" width="10"><b>{{$grand_toalValues->grand_row_total }}</b></td>
                                            @else
                                            <td class="" width="10"></td>
                                            @endif
                                            @endif

                                            @endif
                                            @endif
                                            @endforeach
                                        </tr>
                                        @endif
                                        <!-- END grand total... -->
                                        <tr class="item-name-row item-group-row full-width">
                                            <td colspan="100" class="" style="text-align: left; background: #F7EEFF; font-weight: 600;">Product</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($saleInvoice->is_total_words_show == 1)
                        <div class="invoice-total-in-words-wrapper">
                            <p><span class="invoice-total-in-words-title">Total (in words) :
                                </span><span class="invoice-total-in-words">
                                    {{@$saleInvoice->final_total_words}}
                                </span></p>
                        </div>
                        @endif
                        <div class="ip_footer">
                            <div class="foot_left">
                                @if(!empty($SaleInvoiceBankDetails->account_holder_name) || !empty($SaleInvoiceBankDetails->account_no) || !empty($SaleInvoiceBankDetails->ifsc) || !empty($SaleInvoiceBankDetails->bank_name) )
                                <div class="bank_details_card bank_detil_crd {{ empty($SaleInvoiceSetting->is_bank_detail_show_onInv) && $SaleInvoiceSetting->is_bank_detail_show_onInv!=1 ? 'hide-d' : ''}}">
                                    <button class="show_bank_detail_btn">Bank Details <iconify-icon icon="material-symbols:edit-rounded"></iconify-icon></button>
                                    <ul class="bank_detail_mdle_div">
                                        <li><span>Account Holder Name</span>{{@$SaleInvoiceBankDetails->account_holder_name}}</li>
                                        <li><span>Account Number</span> {{@$SaleInvoiceBankDetails->account_no}}</li>
                                        <li><span>IFSC</span> {{@$SaleInvoiceBankDetails->ifsc}}</li>
                                        <li><span>IBAN</span> {{@$SaleInvoiceBankDetails->iban}}</li>
                                        <li><span>Account Type</span>
                                            <?php
                                            if ($SaleInvoiceBankDetails->account_type == '1')
                                                echo 'Current';
                                            else if ($SaleInvoiceBankDetails->account_type == '2')
                                                echo  'Savings';
                                            else echo ''; ?>
                                        </li>
                                        <li><span>Bank</span>{{@$SaleInvoiceBankDetails->bank_name}}</li>
                                    </ul>
                                </div>
                                @endif

                                @if(!empty($SaleInvoiceBankUpi->upi_id))
                                <div class="upi_details_card upi_id_crd  {{empty($SaleInvoiceSetting->is_upi_detail_show_onInv) && $SaleInvoiceSetting->is_upi_detail_show_onInv!=1 ? 'hide-d' : ''}}">
                                    <button class="show_scaner_btn">UPI - Scan to Pay <iconify-icon icon="material-symbols:edit-rounded"></iconify-icon></button>
                                    <span>
                                        <div id="qrcode"></div>
                                        <p class="active_upi_id">{{@$SaleInvoiceBankUpi->upi_id}}</p>
                                    </span>
                                </div>
                                @endif
                            </div>

                            <div class="foot_right">
                                <ul>
                                    <li>Amount<span>{{ !empty($saleInvoice->final_amount) && $saleInvoice->final_amount!='undefined' ? $saleInvoice->final_amount : '0'}}</span></li>
                                    @if($saleInvoice->is_tax == 'IGST' && $saleInvoice->tax_type != 'none')
                                    <li>IGST<span> {{ !empty($saleInvoice->final_igst) && $saleInvoice->final_igst!='undefined' ? $saleInvoice->final_igst : '0'}} </span></li>
                                    @elseif($saleInvoice->is_tax == 'CGST' && $saleInvoice->tax_type != 'none')
                                    <li>SGST<span> {{ !empty($saleInvoice->final_sgst) && $saleInvoice->final_sgst!='undefined' ? $saleInvoice->final_sgst : '0'}} </span></li>
                                    <li>CGST<span> {{ !empty($saleInvoice->final_cgst) && $saleInvoice->final_cgst!='undefined' ? $saleInvoice->final_cgst : '0'}}</span></li>
                                    @endif
                                    <?php
                                    $totalWithTax=0;
                                    if($saleInvoice->tax_type != 'none'){
                                        if($saleInvoice->is_tax == 'IGST')
                                        $totalWithTax = (float)$saleInvoice->final_amount + (float)$saleInvoice->final_igst;
                                        elseif($saleInvoice->is_tax == 'CGST'){
                                        $totalWithTax = (float)$saleInvoice->final_amount + (float)$saleInvoice->final_sgst+ (float)$saleInvoice->final_cgst;
                                        }
                                      }
                                    ?>

                                    @if(!empty($saleInvoice->final_total_discount_reductions) && $saleInvoice->final_total_discount_reductions != 'undefined' )
                                    <?php
                                    $total_dic = 0;
                                    if ($saleInvoice->final_total_discount_reductions_unit === '%') {
                                        $total_dic = (float)($saleInvoice->final_total_discount_reductions / 100) * $totalWithTax;
                                    } else {
                                        $total_dic = (float)$saleInvoice->final_total_discount_reductions;
                                    }

                                    ?>
                                    <li>Reductions ({{@$saleInvoice->final_total_discount_reductions}} {{@$saleInvoice->final_total_discount_reductions_unit }}) <span>({{number_format($total_dic, 2)}})</span></li>
                                    @endif

                                    @if(!empty($saleInvoice->final_extra_charges) && $saleInvoice->final_extra_charges!='undefined')
                                    @php
                                    if($saleInvoice->extra_changes_unit == '%')
                                    $total_extra = ($saleInvoice->final_extra_charges / 100) * $totalWithTax;
                                    else
                                    $total_extra = $saleInvoice->final_extra_charges;
                                    @endphp
                                    <li>Extra charges ({{@$saleInvoice->final_extra_charges }} {{@$saleInvoice->extra_changes_unit }}) <span> {{ number_format($total_extra, 2) }} </span></li>
                                    @endif
                                    <li class="total "> {{ !empty($saleInvoice->label_total) ? $saleInvoice->label_total : 'Total' }} (INR) <span class="g_step3total">{{ number_format(@$saleInvoice->final_total, 2) }}</span></li>
                                </ul>
                                <!-- //.....      Recevied   Payment  -->
                                @php
                                $final_total = (!empty($saleInvoice->final_total) ? $saleInvoice->final_total : 0);
                                $grand_total_paid = $amount_recived_sum + $total_tcs_amount + $total_tds_amount + $total_transaction_charge;
                                $due_amount = (float)$final_total - (float)$grand_total_paid;

                                @endphp
                                @if(!empty($amount_recived_sum))
                                <ul class="custom_fields payment_div">
                                    <li>Amount Paid <span>{{$amount_recived_sum}}</span></li>
                                    @if(!empty($total_transaction_charge))
                                    <li>Transaction Charge <span class="pay_trans_charges">{{$total_transaction_charge}}</span></li>
                                    @endif
                                    @if(!empty($total_tds_amount))
                                    <li>TDS <span class="pay_tds_amt">{{$total_tds_amount}}</span></li>
                                    @endif
                                    @if(!empty($total_tcs_amount))
                                    <li>TCS <span class="pay_tcs_amt">{{$total_tcs_amount}}</span></li>
                                    @endif
                                    @if(!empty($due_amount))
                                    <li class="total ">Due Amount <span class="pay_inv_due_amt">{{$due_amount}}</span></li>
                                    @endif
                                </ul>
                                @endif
                                <!-- ..For js append vales -->
                                <!-- <ul class="custom_fields amt_paid_tr hide-d">
                                    <li class="hide-d amt_paid_tr">Amount Paid <span class="pay_inv_paid_amt"></span></li>
                                    <li class="hide-d changes_tr">Transaction Charge <span class="pay_trans_charges"></span></li>
                                    <li class="tds_tr hide-d">TDS <span class="pay_tds_amt"></span></li>
                                    <li class="tcs_tr hide-d">TCS <span class="pay_tcs_amt"></span></li>
                                    <li class=" amt_due_tr total hide-d">Due Amount <span class="pay_inv_due_amt"></span></li>
                                </ul> -->
                                <!-- //.....     Bottom custom fields  -->
                                @php
                                $bottom_custome_filed = json_decode($saleInvoice->final_total_more_filed)
                                @endphp
                                @if(!empty($bottom_custome_filed))
                                <ul class="custom_fields">
                                    @foreach($bottom_custome_filed as $custome_filed)
                                    @if(!empty($custome_filed->value))
                                    <li>{{$custome_filed->key}} <span>{{$custome_filed->value}}</span></li>
                                    @endif
                                    @endforeach
                                </ul>
                                @endif
                                @if(!empty($SaleInvoiceSetting->s3_signature_url))
                                <div class="signature logo-wrapper">
                                    <img alt="" src="{{$SaleInvoiceSetting->s3_signature_url}}" srcset="{{$SaleInvoiceSetting->s3_signature_url}}">
                                    <span>{{@$SaleInvoiceSetting->signature_labed_name}}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        @if(!empty($advanceSetting) && $advanceSetting->show_hsn_summary == '1')
                        <div class="invoice-hsn-table-wrapper">
                            <table class="invoice-hsn-table" cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr class="no-pdf small-item-row">
                                        <th colspan="2">HSN Summary</th>
                                    </tr>
                                    <tr class="large-item-row aside-collpased">
                                        <th>HSN</th>
                                        <th>Taxable Value</th>
                                        @if($saleInvoice->is_tax == 'IGST')
                                        <th colspan="2">IGST</th>
                                        @elseif($saleInvoice->is_tax == 'CGST')
                                        <th colspan="2">CGST</th>
                                        <th colspan="2">SGST</th>
                                        @endif
                                        <th>Total</th>
                                    </tr>
                                    <tr class="large-item-row aside-collpased">
                                        <th aria-label="Empty"></th>
                                        <th aria-label="Empty"></th>
                                        @if($saleInvoice->is_tax == 'IGST')
                                        <th>Rate</th>
                                        <th>Amount</th>
                                        @elseif($saleInvoice->is_tax == 'CGST')
                                        <th>Rate</th>
                                        <th>Amount</th>
                                        <th>Rate</th>
                                        <th>Amount</th>
                                        @endif
                                        <th aria-label="Empty"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="no-pdf small-item-row full-width">
                                        <td>HSN</td>
                                        <td>998311</td>
                                    </tr>
                                    <tr class="no-pdf small-item-row full-width">
                                        <td>Taxable Value</td>
                                        <td>0.98</td>
                                    </tr>
                                    <tr class="no-pdf small-item-row full-width">
                                        <td>IGST Rate</td>
                                        <td>0%</td>
                                    </tr>
                                    @if($saleInvoice->is_tax == 'IGST')
                                    <tr class="no-pdf small-item-row full-width">
                                        <td>IGST Amount</td>
                                        <td>0</td>
                                    </tr>
                                    @elseif($saleInvoice->is_tax == 'CGST')
                                    <tr class="no-pdf small-item-row full-width">
                                        <td>SGST Rate</td>
                                        <td>%</td>
                                    </tr>
                                    <tr class="no-pdf small-item-row full-width">
                                        <td>SGST Amount</td>
                                        <td>0</td>
                                    </tr>
                                    @endif
                                    <tr class="no-pdf small-item-row full-width">
                                        <td>CGST Rate</td>
                                        <td>%</td>
                                    </tr>
                                    <tr class="no-pdf small-item-row full-width">
                                        <td>CGST Amount</td>
                                        <td>0</td>
                                    </tr>
                                    <tr class="no-pdf small-item-row full-width">
                                        <td>Total</td>
                                        <td>0</td>
                                    </tr>
                                    <?php
                                    $taxable_total = 0;
                                    $isgt_rate_total = 0;
                                    $isgt_amount_total = 0;

                                    $s_c_gst_rate_total = 0;
                                    $s_c_gst_amount_total = 0;

                                    ?>
                                    @if(!empty($hsnInvoiceDetails))
                                    @foreach($hsnInvoiceDetails as $hsnDetails)
                                    <tr class="large-item-row aside-collapsed">
                                        <td> {{$hsnDetails->product_hsn_code}} </td>
                                        <td> {{$hsnDetails->product_amount}} </td>
                                        <?php
                                        $product_total = (!empty($hsnDetails->product_amount) ? $hsnDetails->product_amount : 0);
                                        $gst_rate = !empty($hsnDetails->product_gst_rate) ? $hsnDetails->product_gst_rate : 0;
                                        $igst_percentage = ($gst_rate / 100) * $product_total;

                                        $s_c_gst_rate = $gst_rate / 2;
                                        $s_c_gst_percenatge = $igst_percentage / 2;

                                        $taxable_total = $taxable_total + $product_total;
                                        $isgt_rate_total = $isgt_rate_total + $gst_rate;
                                        $isgt_amount_total = $isgt_amount_total + $igst_percentage;

                                        $s_c_gst_rate_total = $s_c_gst_rate_total + $s_c_gst_rate;
                                        $s_c_gst_amount_total = $s_c_gst_amount_total + $s_c_gst_percenatge;

                                        ?>
                                        @if($saleInvoice->is_tax == 'IGST')
                                        <td> {{$hsnDetails->product_gst_rate}}% </td>
                                        <td>{{$igst_percentage}}</td>
                                        @elseif($saleInvoice->is_tax == 'CGST')
                                        <td>{{$s_c_gst_rate}}%</td>
                                        <td>{{$s_c_gst_percenatge}}</td>
                                        <td>{{$s_c_gst_rate }}%</td>
                                        <td>{{$s_c_gst_percenatge }}</td>
                                        @endif
                                        <td>{{$igst_percentage }}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    <tr class="large-item-row aside-collapsed">
                                        <td class="strong">Total</td>
                                        <td>{{$taxable_total }}</td>
                                        @if($saleInvoice->is_tax == 'IGST')
                                        <td></td>
                                        <td>{{$isgt_amount_total }}</td>
                                        @elseif($saleInvoice->is_tax == 'CGST')
                                        <td></td>
                                        <td>{{$s_c_gst_amount_total }}</td>
                                        <td></td>
                                        <td>{{$s_c_gst_amount_total }}</td>
                                        @endif
                                        <td>{{$isgt_amount_total }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @endif
                        @php $termconditions = !empty($saleInvoice->terms_and_conditions) ? json_decode($saleInvoice->terms_and_conditions) : '';

                        @endphp
                        @if(!empty($termconditions))
                        <div class="tandc">
                            <h2>{{ !empty($saleInvoice->label_invoice_terms_and_conditions) ? $saleInvoice->label_invoice_terms_and_conditions : 'Terms and Conditions'}}</h2>
                            <ul>
                                @foreach($termconditions as $termcondition)
                                @if($termcondition != 'Write here..')
                                <li>{!! @$termcondition !!} </li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if(!empty($saleInvoice->additional_notes))
                        <div class="tandc adnote">
                            <h2> {{ !empty($saleInvoice->label_invoice_additional_notes) ? $saleInvoice->label_invoice_additional_notes : 'Additional Notes' }} </h2>
                            <ul>
                                <li>{{@$saleInvoice->additional_notes}}</li>
                            </ul>
                        </div>
                        @endif

                        <?php $add_additional_info = json_decode($saleInvoice->add_additional_info);  ?>
                        @if(!empty($add_additional_info))
                        <table border="0" class="invoice-table invoice-head-table invoice-footer-table tandc">
                            <tbody>
                                <tr>
                                    <th style="width: 23%;"> {{ !empty($saleInvoice->additional_info_label) ? $saleInvoice->additional_info_label : 'Additional info' }} </th>
                                    <td></td>
                                </tr>
                                @if(!empty($add_additional_info))
                                @foreach($add_additional_info as $info)
                                <tr>
                                    <td style="width: 23%;">{{@$info->key}}</td>
                                    <td>{{@$info->value}}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        @endif

                        @if(!empty($SaleInvoiceAttachments_data) && $SaleInvoiceAttachments_data!= '[]')
                        <div class="tandc">
                            <h2> {{ !empty($saleInvoice->label_invoice_attachments) ? $saleInvoice->label_invoice_attachments : 'Attachments'}}</h2>
                            @foreach($SaleInvoiceAttachments_data as $key=>$data)
                            @if(!empty($data->invoice_attachments))
                            <div class="attachment-link-wrapper">
                                <div class="attachment-link"><span>{{$key+1}}.</span><span>&nbsp;</span><a href="{{$data->invoice_attachments}}" target="_blank" rel="noopener noreferrer">{{$data->invoice_attachments_name}}</a>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        @endif

                        @if($saleInvoice->is_contact_show==1 && !empty($saleInvoice->contact_details))
                        <div class="tandc contact_details">
                            <div class="invoice-contact-wrapper"><span>{{$saleInvoice->contact_details}}</span></div>
                        </div>
                        @endif
                    </div>
                    @if(empty($copy_id) && $saleInvoice->is_delete != 1)
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    <iconify-icon icon="ic:round-color-lens"></iconify-icon> Customize Invoice Design
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="accordion inner_accord" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingINONE">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseINONE" aria-expanded="true" aria-controls="collapseINONE">
                                                    1. Select Invoice Template
                                                </button>
                                            </h2>
                                            <div id="collapseINONE" class="accordion-collapse collapse show" aria-labelledby="headingINONE" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="grid-wrapper grid-col-auto">
                                                        <label for="radio-card-1" class="radio-card">
                                                            <input type="radio" name="radio-card" id="radio-card-1" value="theme_one" data-id="1" class="themeChange templateChange" {{!empty($saleInvoice->template_id) && $saleInvoice->template_id=="1" ? 'checked' : '' }} />
                                                            <div class="card-content-wrapper">
                                                                <div class="alred">
                                                                    <h6>Professional</h6>
                                                                    <span class="check-icon"></span>
                                                                </div>
                                                                <div class="card-content">
                                                                    <img src="{{asset('unsync_assets/assets/images/theme1.jpg')}}" alt="" />
                                                                </div>
                                                            </div>
                                                        </label>

                                                        <label for="radio-card-2" class="radio-card">
                                                            <input type="radio" name="radio-card" id="radio-card-2" class="themeChange templateChange" data-id="2" value="theme_two" {{!empty($saleInvoice->template_id) && $saleInvoice->template_id=="2" ? 'checked' : '' }} />
                                                            <div class="card-content-wrapper">
                                                                <div class="alred">
                                                                    <h6>Green Gradient</h6>
                                                                    <span class="check-icon"></span>
                                                                </div>
                                                                <div class="card-content">
                                                                    <img src="{{asset('unsync_assets/assets/images/theme2.jpg')}}" alt="" />
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <label for="radio-card-3" class="radio-card">
                                                            <input type="radio" name="radio-card" id="radio-card-3" class="themeChange templateChange" value="theme_three" data-id="3" {{!empty($saleInvoice->template_id) && $saleInvoice->template_id=="3" ? 'checked' : '' }} />
                                                            <div class="card-content-wrapper">
                                                                <div class="alred">
                                                                    <h6>Modern</h6>
                                                                    <span class="check-icon"></span>
                                                                </div>
                                                                <div class="card-content">
                                                                    <img src="{{asset('unsync_assets/assets/images/theme3.jpg')}}" alt="" />
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <label for="radio-card-4" class="radio-card">
                                                            <input type="radio" name="radio-card" id="radio-card-4" class="themeChange templateChange" value="theme_four" data-id="4" {{!empty($saleInvoice->template_id) && $saleInvoice->template_id=="4" ? 'checked' : '' }} />
                                                            <div class="card-content-wrapper">
                                                                <div class="alred">
                                                                    <h6>Crisp</h6>
                                                                    <span class="check-icon"></span>
                                                                </div>
                                                                <div class="card-content">
                                                                    <img src="{{asset('unsync_assets/assets/images/theme4.jpg')}}" alt="" />
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingINTWO">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseINTWO" aria-expanded="true" aria-controls="collapseINTWO">
                                                    2. Change Color
                                                </button>
                                            </h2>
                                            <div id="collapseINTWO" class="accordion-collapse collapse show" aria-labelledby="headingINTWO" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="three_column">
                                                        <div class="column">
                                                            <label for="">Change Color</label>
                                                            <div id="myColorSelector" class="colorSelector">
                                                                <label class="buttonContainer">
                                                                    <input type="radio" name="color" value="color1" data-id="0, 106, 255" class="colorChange">
                                                                    <div class="colorOption color1"></div>
                                                                </label>
                                                                <label class="buttonContainer">
                                                                    <input type="radio" name="color" value="color2" data-id="253, 187, 139" class="colorChange">
                                                                    <div class="colorOption color2"></div>
                                                                </label>
                                                                <label class="buttonContainer">
                                                                    <input type="radio" name="color" value="color3" data-id="83, 113, 136" class="colorChange">
                                                                    <div class="colorOption color3"></div>
                                                                </label>
                                                                <label class="buttonContainer">
                                                                    <input type="radio" name="color" value="color4" data-id="247, 211, 71" class="colorChange">
                                                                    <div class="colorOption color4"></div>
                                                                </label>
                                                                <label class="buttonContainer">
                                                                    <input type="radio" name="color" value="color5" data-id="243, 100, 70" class="colorChange">
                                                                    <div class="colorOption color5"></div>
                                                                </label>
                                                                <label class="buttonContainer">
                                                                    <input type="radio" name="color" value="color6" data-id="61, 76, 231" class="colorChange">
                                                                    <div class="colorOption color6"></div>
                                                                </label>
                                                                <label class="buttonContainer">
                                                                    <input type="radio" name="color" value="color7" data-id="255,255,255" class="colorChange">
                                                                    <div class="colorOption color7"></div>
                                                                </label>
                                                                <div class="colorPickers">
                                                                    <button id="colorPickerIcon" class="colorPickerIcon">
                                                                        <iconify-icon icon="ic:baseline-color-lens"></iconify-icon>
                                                                    </button>
                                                                    <input type="color" id="colorPicker">
                                                                </div>
                                                            </div>
                                                            <!-- <div class="picker"></div> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingINTHREE">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseINTHREE" aria-expanded="true" aria-controls="collapseINTHREE">
                                                    3. Add LetterHead & Footer
                                                </button>
                                            </h2>
                                            <div id="collapseINTHREE" class="accordion-collapse collapse" aria-labelledby="headingINTHREE" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="three_column header_footer">
                                                        <div class="column">
                                                            <label for="">Add Letterhead</label>
                                                            <div class="uploadImageLogo">
                                                                <label for="uploadImage" class="btn-upload upload-button"><iconify-icon icon="ic:round-add"></iconify-icon> Recommended resolution 1000x200px and file size upto 500KB</label>
                                                                <!-- <label for="uploadImage" id="changeImage" class="btn-upload" style="display: none;"><iconify-icon icon="material-symbols:edit-rounded"></iconify-icon> Change</label> -->
                                                                <input type="file" id="uploadImage" class="letter_head_img" accept="image/*" style="display: none;">
                                                                <button id="removeImage" class="btn-upload" style="display: none;"><iconify-icon icon="eva:close-outline"></iconify-icon></button>
                                                                <div class="image-preview">
                                                                    <img id="preview" src="" alt="Preview Image">
                                                                </div>
                                                            </div>
                                                            <p>Letterhead will be applied on final pdf</p>
                                                            <div class="sd_check">
                                                                <input type="checkbox" class="letter_head_btn" name="layout" id="letterhead">
                                                                <label class="pull-right text" for="letterhead">Letterhead on first page</label>
                                                            </div>
                                                        </div>

                                                        <div class="column">
                                                            <label for="">Add Footer</label>
                                                            <div class="uploadImageLogo">
                                                                <label for="uploadImage2" class="btn-upload upload-button"><iconify-icon icon="ic:round-add"></iconify-icon>
                                                                    Recommended resolution 1000x200px and
                                                                    file size upto 500KB</label>
                                                                <!-- <label for="uploadImage" id="changeImage" class="btn-upload" style="display: none;"><iconify-icon icon="material-symbols:edit-rounded"></iconify-icon> Change</label> -->
                                                                <input type="file" id="uploadImage2" class="pdf_footer_img" accept="image/*" style="display: none;">
                                                                <button id="removeImage2" class="btn-upload" style="display: none;"><iconify-icon icon="eva:close-outline"></iconify-icon></button>
                                                                <div class="image-preview">
                                                                    <img id="preview2" src="" alt="Preview Image">
                                                                </div>
                                                            </div>
                                                            <p>Footer will be applied on final pdf</p>
                                                            <div class="sd_check">
                                                                <input type="checkbox" class="pdf_footer_btn" name="layout" id="footerlast">
                                                                <label class="pull-right text" for="footerlast">Footer on last
                                                                    page</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                    <iconify-icon icon="fluent:building-bank-24-filled"></iconify-icon> Bank And UPI Details
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse show" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="payment_cards">

                                        <div class="py_cards">
                                            <div class="icon">
                                                <img src="assets/images/bank.svg" alt="" />
                                            </div>
                                            <div class="py_details">
                                                <div class="py_title">
                                                    <span>
                                                        <h3>Bank Account Transfer</h3>
                                                        <p>NEFT, IMPS, CASH</p>
                                                    </span>
                                                    <label class="switch">
                                                        <input type="checkbox" name="is_bank_detail_show" class="is_bank_detail_show" value="1" {{!empty($SaleInvoiceBankDetails->id) ? 'checked' : ''}}>
                                                        <span class="slider"></span>
                                                    </label>
                                                </div>
                                                <ul>
                                                    <li>Benefits: <b>Free for you</b></li>
                                                    <li>Transaction Charges: <b>None</b></li>
                                                </ul>
                                                <div class="blue_details bank_botom_dev">
                                                    <h5>{{@$SaleInvoiceBankDetails->bank_name}}</h5>
                                                    <p>{{@$SaleInvoiceBankDetails->account_holder_name}}</p>
                                                    <p>Acc. No: <span>{{@$SaleInvoiceBankDetails->account_no}}</span> &nbsp; &nbsp; IFSC: <span>{{@$SaleInvoiceBankDetails->ifsc}}</span></p>
                                                </div>
                                                <input type="hidden" class="active_bank_db_id" value="{{ !empty($SaleInvoiceBankDetails->id) ? $SaleInvoiceBankDetails->id : @$SaleInvoiceSetting->last_active_bank_id}}" />
                                                <button class="show_bank_detail_btn"><iconify-icon icon="ep:setting"></iconify-icon> Edit Bank Details</button>
                                            </div>
                                        </div>

                                        <div class="py_cards">
                                            <div class="icon">
                                                <img src="assets/images/upi.svg" alt="" />
                                            </div>
                                            <div class="py_details">
                                                <div class="py_title">
                                                    <span>
                                                        <h3>UPI</h3>
                                                        <p>GooglePay, PhonePe, BHIM</p>
                                                    </span>
                                                    <label class="switch">
                                                        <input type="checkbox" name="is_upi_show" class="is_upi_show" value="1" {{!empty($SaleInvoiceBankUpi->id) ? 'checked' : ''}}>
                                                        <span class="slider"></span>
                                                    </label>
                                                </div>
                                                <ul>
                                                    <li>Benefits: <b>Convenient for You</b></li>
                                                    <li>Transaction Charges: <b>None</b></li>
                                                </ul>
                                                <div class="blue_details">
                                                    <h5>UPI</h5>
                                                    <p>UPI Id: <span class="active_upi_id">{{@$SaleInvoiceBankUpi->upi_id}}</span></p>
                                                </div>
                                                <input type="hidden" class="active_upi_db_id" value="{{ !empty($SaleInvoiceBankUpi->id) ? $SaleInvoiceBankUpi->id : @$SaleInvoiceSetting->last_active_upi_id}}" />
                                                <button class="show_scaner_btn"><iconify-icon icon="ep:setting"></iconify-icon> Edit UPI Details</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingSIX">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSIX" aria-expanded="true" aria-controls="collapseSIX">
                                    <iconify-icon icon="material-symbols:mail-rounded"></iconify-icon> Messages to Client
                                </button>
                            </h2>
                            <div id="collapseSIX" class="accordion-collapse collapse" aria-labelledby="headingSIX" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="table-responsive">
                                        <table data-striped="true">
                                            <thead>
                                                <tr>
                                                    <th>Message Type</th>
                                                    <th>Sent On</th>
                                                    <th>Recipient</th>
                                                    <th>Mobile Number</th>
                                                </tr>
                                            </thead>
                                            <tbody class="clnt_msg_body">
                                                @if(!empty($SaleInvoiceShare))
                                                @foreach($SaleInvoiceShare as $key=>$shareData)
                                                <tr>
                                                    <td>{{@$shareData->mesg_type}}</td>
                                                    <td>{{!empty($shareData->created_at) ? date('F d, Y' , strtotime(@$shareData->created_at)) : ''}}</td>
                                                    <td>{{@$shareData->recipient}}</td>
                                                    <td>{{!empty($shareData->mobile_no) ? $shareData->mobile_no : '-'}}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <input type="hidden" class="save_inv_id" value="{{$invoice_id}}" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modals')
@include('allFrontendViews.invoice.modals.kyc_document_popup')
@include('allFrontendViews.invoice.modals.update_bank_detail_popup')
@include('allFrontendViews.invoice.modals.share_invoice_popup')
@include('allFrontendViews.invoice.modals.add_bank_detail_popup')
@include('allFrontendViews.invoice.modals.update_upi_detail_popup')
@include('allFrontendViews.invoice.modals.add_payment_record_popup')
@include('allFrontendViews.invoice.modals.cropper')
@endsection
@push('custom-scripts')

<script src="{{asset('unsync_assets/assets/js/app.js')}}"></script>
<script src="{{asset('unsync_assets/assets/js/main.js')}}"></script>
<script src="{{asset('unsync_assets/assets/js/tiny-autocomplete.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/47585/slip.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script> -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/autosize.js/4.0.2/autosize.min.js'></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.1/highlight.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.1/languages/css.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.1/languages/javascript.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.1/languages/java.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.1/languages/xml.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.1/languages/php.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.1/languages/php-template.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.1/languages/sql.min.js"></script>
<script src="https://uicdn.toast.com/editor-plugin-code-syntax-highlight/latest/toastui-editor-plugin-code-syntax-highlight-all.min.js"></script>
<script src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>
<script>
    let suggestions = <?= json_encode($commonData['allProducts']); ?>;
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="{{asset('js/custom/invoice_step2.js')}}"></script>

<script src="{{asset('js/custom/invoice_step3.js')}}"></script>
<script src="{{asset('js/custom/main_invoice.js')}}"></script>

<script type="text/javascript" src="{{asset('assets/js/plugins/dropzone/dropzone.min.js')}}"></script>


<!-- DatePicker -->
<script>
    $(function() {
        $(".datepicker").datepicker({
            dateFormat: "dd-mm-yy",
            duration: "fast"
        });
        $(".datepicker2").datepicker({
            dateFormat: "dd-mm-yy",
            duration: "fast"
        });

        $(".datepicker-button").on("click", function() {
            $(".datepicker").datepicker("show");
        });
        $(".datepicker-button2").on("click", function() {
            $(".datepicker2").datepicker("show");
        });
    });
</script>
<!-- H2 Editable Text Script -->
<script>
    // Add a class "editableText" to all the elements you want to make editable
    var editableTextElements = document.querySelectorAll(".editableText");

    // Add the event listeners to all the elements
    editableTextElements.forEach(function(editableTextElement) {
        editableTextElement.addEventListener("click", function(event) {
            editableTextElement.className = "small_size";
            var input = document.createElement("input");
            input.value = editableTextElement.innerHTML;
            editableTextElement.innerHTML = "";
            editableTextElement.appendChild(input);
            input.focus();
            event.stopPropagation();
            input.addEventListener("blur", function() {
                editableTextElement.innerHTML = input.value;
            });
        });

        document.addEventListener("click", function() {
            editableTextElement.className = "big_size";
        });
    });
</script>
<script>
    // Mini Header
    $(".js-states.form-control.nosearch").select2({
        minimumResultsForSearch: Infinity,
        theme: "bootstrap4",
    });

    $(".js-example-placeholder-single-default").select2({
        placeholder: "Default",
    });

    $(".js-example-placeholder-single-country").select2({
        placeholder: "Select Country",
    });

    $(".js-example-placeholder-single-state").select2({
        placeholder: "Select State",
    });

    $(".js-example-placeholder-single-industry").select2({
        placeholder: "Client Industry",
    });
</script>
<script>
    // Company with Button
    $(".js-example-placeholder-single-brand").select2().data("select2").$dropdown.addClass("my-container");

    var $customDiv = $('<div class="inner_box"><button id="custom-button"><iconify-icon icon="pajamas:plus"></iconify-icon> Create New Company</button></div>');

    // Bind the "select2:open" event to the select2 element
    $(".js-example-placeholder-single-brand").on("select2:open", function() {
        // Append the custom div to the select2-dropdown element
        $(".my-container .select2-dropdown").append($customDiv);
    });
</script>
<script>
    // Client with Button
    $(".js-example-placeholder-single-client").select2().data("select2").$dropdown.addClass("my-container1");

    var $customDiv1 = $('<div class="inner_box"><button id="custom-button"><iconify-icon icon="pajamas:plus"></iconify-icon> Add New Client</button></div>');

    // Bind the "select2:open" event to the select2 element
    $(".js-example-placeholder-single-client").on("select2:open", function() {
        // Append the custom div to the select2-dropdown element
        $(".my-container1 .select2-dropdown").append($customDiv1);
    });
</script>
<script>
    // Shipping Details with Button
    $(".js-example-placeholder-single-shaddress").select2().data("select2").$dropdown.addClass("my-container2");

    var $customDiv2 = $('<div class="inner_box"><button id="custom-button"><iconify-icon icon="pajamas:plus"></iconify-icon> Add New Shipping Details</button></div>');

    // Bind the "select2:open" event to the select2 element
    $(".js-example-placeholder-single-shaddress").on("select2:open", function() {
        // Append the custom div to the select2-dropdown element
        $(".my-container2 .select2-dropdown").append($customDiv2);
    });
</script>
<script>
    // Select Tax Type with Button
    $(".js-example-placeholder-single-taxtype").select2().data("select2").$dropdown.addClass("my-container3");

    var $customDiv3 = $('<div class="inner_box"><button id="custom-button"><iconify-icon icon="pajamas:plus"></iconify-icon> Create New Tax</button></div>');

    // Bind the "select2:open" event to the select2 element
    $(".js-example-placeholder-single-taxtype").on("select2:open", function() {
        // Append the custom div to the select2-dropdown element
        $(".my-container3 .select2-dropdown").append($customDiv3);
    });
</script>

<script>
    // Show Additional Discount Options
    $("button.show_additional_charge").click(function(e) {
        $('.hide_options').toggleClass('show');
        $('button.show_additional_charge').hide();
    });

    // Show Item Wise Discount
    $("button.giwd").click(function(e) {
        $('.hide_discount_item').toggleClass('show');
        $('button.giwd').hide();
    });
    $(".hide_discount_item button.close_btn").click(function(e) {
        $('.hide_discount_item').toggleClass('show');
        $('button.giwd').show();
    });

    // Show Item Wise Discount
    $("button.gdtotal").click(function(e) {
        $('.hide_adddiscount_item').toggleClass('show');
        // $('button.gdtotal').hide();
    });
    $(".hide_adddiscount_item button.close_btn").click(function(e) {
        $('.hide_adddiscount_item').toggleClass('show');
    });

    // Show Extra Discount
    $("button.aachardes").click(function(e) {
        $('.hide_addcharges_item').toggleClass('show');
        // $('button.gdtotal').hide();
    });
    $(".hide_addcharges_item button.close_btn").click(function(e) {
        $('.hide_addcharges_item').toggleClass('show');
    });

    // Show Round On
    $("button.show_round_on").click(function(e) {
        $('.round_on_hide').toggleClass('show');
        // $('button.gdtotal').hide();
    });
    $(".round_on_hide button.close_btn").click(function(e) {
        $('.round_on_hide').toggleClass('show');
    });

    // Show Round Off
    $("button.show_round_off").click(function(e) {
        $('.round_off_hide').toggleClass('show');
        // $('button.gdtotal').hide();
    });
    $(".round_off_hide button.close_btn").click(function(e) {
        $('.round_off_hide').toggleClass('show');
    });

    // Show Item Wise Discount
    $("button.show_total").click(function(e) {
        $('.hidden_total').toggleClass('show');
        $('button.show_total').hide();
    });
    $(".total-col button.close_btn").click(function(e) {
        $('.hidden_total').toggleClass('show');
        $('button.show_total').show();
    });

    // Show Item Wise Discount
    $("button.show_field_extra").click(function(e) {
        // $('.add_field_item').toggleClass('show');
        // $('button.show_total').hide();
    });
    $(".add_field_item button.close_re_btn").click(function(e) {
        // $('.add_field_item').addClass('show');
        // $('button.show_total').show();
    });


    $("button.showContactdetails").click(function(e) {
        $('.ycontactdetails').removeClass('hide');
    });
    $(".ycontactdetails button.close_cdt").click(function(e) {
        $('.ycontactdetails').addClass('hide');
    });


    // Hide UnHide            
    $(".action_btns button.hide").click(function(e) {
        $('.action_btns button.unhide').addClass('show');
        $('.action_btns button.hide').removeClass('show');
    });
    $(".action_btns button.unhide").click(function(e) {
        $('.action_btns button.hide').addClass('show');
        $('.action_btns button.unhide').removeClass('show');
    });

    // Add New Column        
    $(".addnewcolumnbtn").click(function(e) {
        $('.add_new_column').toggleClass('show');
    });
    $(".add_new_column button.remove").click(function(e) {
        $('.add_new_column').toggleClass('show');
    });


    // Show Description on Table
    $("button.openDescription").click(function(e) {
        $('.hide_option_descandimage').addClass('show');
        $('button.openDescription').hide();
    });
    $("button.openDescription2").click(function(e) {
        $('.hide_option_descandimage2').addClass('show');
        $('button.openDescription2').hide();
    });

    $("button.openthumbnails").click(function(e) {
        $('.hide_option_imageOnly').addClass('show');
        $('button.openthumbnails').hide();
    });
    $("button.opetwo").click(function(e) {
        $('.two_op').addClass('show');
        $('button.opetwo').hide();
    });
</script>
<script>
    var ul = document.getElementById('sortable-list');

    ul.addEventListener('slip:beforereorder', function(e) {
        if (/demo-no-reorder/.test(e.target.className)) {
            e.preventDefault();
        }
    }, false);

    ul.addEventListener('slip:beforeswipe', function(e) {
        if (e.target.nodeName == 'INPUT' || /no-swipe/.test(e.target.className)) {
            e.preventDefault();
        }
    }, false);

    ul.addEventListener('slip:beforewait', function(e) {
        if (e.target.className.indexOf('instant') > -1) e.preventDefault();
    }, false);

    /*ul.addEventListener('slip:afterswipe', function(e){
    e.target.parentNode.appendChild(e.target);
    }, false);*/

    ul.addEventListener('slip:reorder', function(e) {
        e.target.parentNode.insertBefore(e.target, e.detail.insertBefore);
        return false;
    }, false);

    new Slip(ul);
</script>

<script>
    var editor = new toastui.Editor({
        el: document.querySelector('#editor1'),
        initialEditType: 'wysiwyg'
    });

    var editor = new toastui.Editor({
        el: document.querySelector('#editor2'),
        initialEditType: 'wysiwyg'
    });

    var editor = new toastui.Editor({
        el: document.querySelector('#editor3'),
        initialEditType: 'wysiwyg'
    });
</script>

<script>
    // Dropzone
    Dropzone.autoDiscover = false;
    var dropzones = [];
    $(document).ready(function() {
        $(".dropzone").each(function(i, el) {
            var name = "g_" + $(el).data("field");
            var myDropzone = new Dropzone(el, {
                url: window.location.pathname,
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 1,
                maxFiles: 5,
                paramName: name,
                addRemoveLinks: true,
                removedfile: function(file) {
                    file.previewElement.remove();
                },
            });
            dropzones.push(myDropzone);
        });
    });
</script>

<script>
    jQuery(document).ready(function() {
        ImgUpload();
    });

    function ImgUpload() {
        var imgWrap = "";
        var imgArray = [];

        $('.upload__inputfile').each(function() {
            $(this).on('change', function(e) {
                imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
                var maxLength = $(this).attr('data-max_length');

                var files = e.target.files;
                var filesArr = Array.prototype.slice.call(files);
                var iterator = 0;
                filesArr.forEach(function(f, index) {

                    if (!f.type.match('image.*')) {
                        return;
                    }

                    if (imgArray.length > maxLength) {
                        return false
                    } else {
                        var len = 0;
                        for (var i = 0; i < imgArray.length; i++) {
                            if (imgArray[i] !== undefined) {
                                len++;
                            }
                        }
                        if (len > maxLength) {
                            return false;
                        } else {
                            imgArray.push(f);

                            var reader = new FileReader();
                            reader.onload = function(e) {
                                var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                                imgWrap.append(html);
                                iterator++;
                            }
                            reader.readAsDataURL(f);
                        }
                    }
                });
            });
        });

        $('body').on('click', ".upload__img-close", function(e) {
            var file = $(this).parent().data("file");
            for (var i = 0; i < imgArray.length; i++) {
                if (imgArray[i].name === file) {
                    imgArray.splice(i, 1);
                    break;
                }
            }
            $(this).parent().parent().remove();
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.js"></script>
<script>
    $(document).ready(function() {
        let cropper;
        const image = document.getElementById("preview");
        const imageToCrop = document.getElementById("imageToCrop");
        const cropModalElement = document.getElementById("cropModal");
        const cropModal = new bootstrap.Modal(cropModalElement);
        const uploadButton = document.querySelector("label[for='uploadImage']");
        const removeButton = document.getElementById("removeImage");
        // const changeButton = document.getElementById("changeImage");

        $("#uploadImage").on("change", function(event) {
            handleImageUpload(event);
        });
        $("#newfooterUploadImage").on("change", function(event) {
            handleImageUpload(event);
        });

        $("#changeImage").on("click", function(event) {
            handleImageUpload(event);
        });

        $("#replaceImage").on("click", function() {
            $("#uploadImage").click();
        });


        removeButton.addEventListener("click", function() {
            image.src = "";
            uploadButton.style.display = "flex";
            removeButton.style.display = "none";
        });

        image.addEventListener("load", function() {
            removeButton.style.display = "flex";
        });


        function handleImageUpload(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                imageToCrop.src = e.target.result;
                cropModal.show();
            };

            reader.readAsDataURL(file);
        }

        cropModalElement.addEventListener("shown.bs.modal", function() {
            if (cropper) {
                cropper.destroy();
            }

            cropper = new Cropper(imageToCrop, {
                aspectRatio: 1,
                viewMode: 1,
                cropBoxResizable: true,
                data: {
                    width: 550,
                    height: 400,
                },
                ready: function() {
                    cropper.setCropBoxData({
                        width: 550,
                        height: 400,
                    });
                },
            });
        });

        $("#cropAndSave").on("click", function() {
            const croppedImageDataURL = cropper.getCroppedCanvas().toDataURL();
            image.src = croppedImageDataURL;
            cropper.destroy();
            cropper = null;
            cropModal.hide();
            uploadButton.style.display = "none";
            changeButton.style.display = "inline-block";
        });
    });
</script>
<script>
    $(document).ready(function() {
        let cropper2;
        const imagepreview2 = document.getElementById("preview2");
        const imageToCrop2 = document.getElementById("imageToCrop2");
        const cropModalElement2 = document.getElementById("cropModal2");
        const cropModal2 = new bootstrap.Modal(cropModalElement2);
        const uploadButton2 = document.querySelector("label[for='uploadImage2']");
        // const changeButton = document.getElementById("changeImage");
        const removeButton2 = document.getElementById("removeImage2");

        $("#uploadImage2").on("change", function(event) {
            handleImageUpload2(event);
        });

        // $("#changeImage").on("click", function (event) {
        //     handleImageUpload(event);
        // });


        $("#replaceImage2").on("click", function() {
            $("#uploadImage2").click();
        });

        removeButton2.addEventListener("click", function() {
            imagepreview2.src = "";
            uploadButton2.style.display = "flex";
            removeButton2.style.display = "none";
        });

        imagepreview2.addEventListener("load", function() {
            removeButton2.style.display = "flex";
        });

        function handleImageUpload2(event) {
            const file2 = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                imageToCrop2.src = e.target.result;
                cropModal2.show();
            };

            reader.readAsDataURL(file2);
        }

        cropModalElement2.addEventListener("shown.bs.modal", function() {
            if (cropper2) {
                cropper2.destroy();
            }

            cropper2 = new Cropper(imageToCrop2, {
                aspectRatio: 3,
                viewMode: 2,
                cropBoxResizable: true,
                data: {
                    width: 550,
                    height: 400,
                },
                ready: function() {
                    cropper2.setCropBoxData({
                        width: 550,
                        height: 400,
                    });
                },
            });
        });

        $("#cropAndSave2").on("click", function() {
            const croppedImageDataURL2 = cropper2.getCroppedCanvas().toDataURL();
            imagepreview2.src = croppedImageDataURL2;
            cropper2.destroy();
            cropper2 = null;
            cropModal2.hide();
            uploadButton2.style.display = "none";
        });
    });
</script>

<!-- <script>
    $('.colorChange').change(function() {
        $(".invoice_preview").removeClass("orange_color gray_color yellow_color red_color blue_color");

        if (this.value == 'color1') {
            $(".invoice_preview").addClass("default_color");
        } else if (this.value == 'color2') {
            $(".invoice_preview").addClass("orange_color");
        } else if (this.value == 'color3') {
            $(".invoice_preview").addClass("gray_color");
        } else if (this.value == 'color4') {
            $(".invoice_preview").addClass("yellow_color");
        } else if (this.value == 'color5') {
            $(".invoice_preview").addClass("red_color");
        } else if (this.value == 'color6') {
            $(".invoice_preview").addClass("blue_color");
        } else if (this.value == 'color7') {
            $(".invoice_preview").addClass("black_color");
        }
    });


    document.getElementById('colorPickerIcon').addEventListener('click', function () {
            document.getElementById('colorPicker').click();
        });
        document.getElementById('colorPicker').addEventListener('input', function () {
            const hexToRgb = hex => hex.charAt(0) === '#' ?
                ` ${parseInt(hex.substring(1, 3), 16)}, ${parseInt(hex.substring(3, 5), 16)}, ${parseInt(hex.substring(5, 7), 16)}` :
                null;
            document.documentElement.style.setProperty('--theme-color', hexToRgb(this.value));
            $(".invoice_preview").removeClass("orange_color gray_color yellow_color red_color blue_color black_color");
            document.getElementById('colorPickerIcon').style.backgroundColor = this.value;
        });
</script> -->

<!-- Theme Change -->
<!-- <script>
    $('.themeChange').change(function() {
        $(".invoice_preview").removeClass("theme1 theme2 theme3 theme4");

        if (this.value == 'theme_one') {
            $(".invoice_preview").addClass("theme1");
        } else if (this.value == 'theme_two') {
            $(".invoice_preview").addClass("theme2");
        } else if (this.value == 'theme_three') {
            $(".invoice_preview").addClass("theme3");
        } else if (this.value == 'theme_four') {
            $(".invoice_preview").addClass("theme4");
        }
    });
</script> -->

<!-- Theme Color Change -->


<script>
    $(document).ready(function() {
        var db_color = "<?= $saleInvoice->color; ?>";
        if (db_color) {
            document.documentElement.style.setProperty('--theme-color', db_color);
        }
    });

    $('.colorChange').change(function() {
        $(".invoice_preview").removeClass("default_color orange_color gray_color yellow_color red_color blue_color black_color");
        let customColor;
        if (this.value === 'color1') {
            customColor = '0, 106, 255';
            textColor = '0,0,0';
        } else if (this.value === 'color2') {
            customColor = '253, 187, 139';
            textColor = '0,0,0';
        } else if (this.value === 'color3') {
            customColor = '83, 113, 136';
            textColor = '0,0,0';
        } else if (this.value === 'color4') {
            customColor = '247, 211, 71';
            textColor = '0,0,0';
        } else if (this.value === 'color5') {
            customColor = '243, 100, 70';
            textColor = '0,0,0';
        } else if (this.value === 'color6') {
            customColor = '61, 76, 231';
            textColor = '0,0,0';
        } else if (this.value === 'color7') {
            customColor = '0, 0, 0';
            textColor = '255,255,255';
        }
        if (customColor) {
            document.documentElement.style.setProperty('--theme-color', customColor);
        }
        if (textColor) {
            document.documentElement.style.setProperty('--text-color', textColor);
        }
    });
    // $('.colorChange').change(function () {
    //     $(".invoice_preview").removeClass("default_color orange_color gray_color yellow_color red_color blue_color black_color");
    //     if (this.value == 'color1') {
    //         $(".invoice_preview").addClass("default_color");
    //     }
    //     else if (this.value == 'color2') {
    //         $(".invoice_preview").addClass("orange_color");
    //     }
    //     else if (this.value == 'color3') {
    //         $(".invoice_preview").addClass("gray_color");
    //     }
    //     else if (this.value == 'color4') {
    //         $(".invoice_preview").addClass("yellow_color");
    //     }
    //     else if (this.value == 'color5') {
    //         $(".invoice_preview").addClass("red_color");
    //     }
    //     else if (this.value == 'color6') {
    //         $(".invoice_preview").addClass("blue_color");
    //     }
    //     else if (this.value == 'color7') {
    //         $(".invoice_preview").addClass("black_color");
    //     }
    // });
    document.getElementById('colorPickerIcon').addEventListener('click', function() {
        document.getElementById('colorPicker').click();
    });
    document.getElementById('colorPicker').addEventListener('input', function() {
        const hexToRgb = hex => hex.charAt(0) === '#' ?
            ` ${parseInt(hex.substring(1, 3), 16)}, ${parseInt(hex.substring(3, 5), 16)}, ${parseInt(hex.substring(5, 7), 16)}` :
            null;
        document.documentElement.style.setProperty('--theme-color', hexToRgb(this.value));
        $(".invoice_preview").removeClass("default_color orange_color gray_color yellow_color red_color blue_color black_color");
        document.getElementById('colorPickerIcon').style.backgroundColor = this.value;
    });

    document.getElementById('colorPicker').addEventListener('change', function() {
        const hexToRgb = hex => hex.charAt(0) === '#' ?
            ` ${parseInt(hex.substring(1, 3), 16)}, ${parseInt(hex.substring(3, 5), 16)}, ${parseInt(hex.substring(5, 7), 16)}` :
            null;
        var color_val = hexToRgb(this.value);
        handleColorChange(color_val);
    });
</script>
<!-- Theme Change -->
<script>
    $('.themeChange').change(function() {
        $(".invoice_preview").removeClass("theme1 theme2 theme3 theme4");
        let customColor;
        if (this.value == 'theme_one') {
            $(".invoice_preview").addClass("theme1");
        } else if (this.value == 'theme_two') {
            $(".invoice_preview").addClass("theme2");
            customColor = '152, 216, 170';
        } else if (this.value == 'theme_three') {
            $(".invoice_preview").addClass("theme3");
            customColor = '247, 211, 71';
        } else if (this.value == 'theme_four') {
            $(".invoice_preview").addClass("theme4");
        }
        if (customColor) {
            document.documentElement.style.setProperty('--theme-color', customColor);
        }
    });
</script>
@endpush