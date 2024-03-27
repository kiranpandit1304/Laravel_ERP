<?php

use Illuminate\Routing\Route;
?>
@extends('allFrontendViews.layouts.app')
@section('page-title')
{{__('Create invoice')}}
@endsection
@push('css-page')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.2.0/tailwind.min.css" />
<link rel="stylesheet" href="{{asset('unsync_assets/assets/css/select2.css')}}" />
<link rel="stylesheet" href="{{asset('unsync_assets/assets/css/select2-bootstrap4.css')}}" />

<link href="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/css/tiny-autocomplete.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" />
<link href="https://erp.unesync.com/assets/js/plugins/dropzone/css/dropzone.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.1/styles/default.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/codemirror.min.css" />
<link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor.min.css" />
<link rel="stylesheet" href="{{asset('assets/inwords/inword.css')}}" />
@endpush
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 flush">
            <div class="the_mini_header">
                <div class="page_head forinvoice">
                    <div class="actions_bar">
                        <div class="filter_main">
                            @if(!empty($invoice_id))
                            <ul class="main_steps">
                                <li class="active">
                                    <span>1</span>
                                    <p> <a href="{{route('fn.invoice_step1', [$enypt_id, $invoice_id])}}">Invoice Details </a></p>
                                </li>
                                <li class="">
                                    <span>2</span>
                                    <p> <a href="{{route('fn.invoice_step2', [$enypt_id, $invoice_id])}}"> Your Bank Details</a></p>
                                </li>
                                <li>
                                    <span>3</span>
                                    <p> <a href="{{route('fn.invoice_step3', [$enypt_id, $invoice_id])}}"> Select Design & Colors</a></p>
                                </li>
                            </ul>
                            @else
                            <ul class="main_steps">
                                <li class="active">
                                    <span>1</span>
                                    <p> <a href="javascript:void(0)">Invoice Details </a></p>
                                </li>
                                <li class="">
                                    <span>2</span>
                                    <p> <a href="javascript:void(0)"> Your Bank Details</a></p>
                                </li>
                                <li>
                                    <span>3</span>
                                    <p> <a href="javascript:void(0)"> Select Design & Colors</a></p>
                                </li>
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div id="main_wrapper" class="forinvoice">
                <div class="content_page">
                    <div class="page_title">
                        <h2 class="editableText invoice_title">{{!empty($saleInvoice->invoice_title) ? $saleInvoice->invoice_title : 'Invoice'}}</h2>
                        <!-- <div class="subtitle">
                            <button class="subTitle add_more" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <g id="plus-square-outline" transform="translate(-.266 .217)">
                                        <g id="Rectangle_1143" fill="rgba(255,255,255,0)" stroke="#000" transform="translate(.266 -.217)">
                                            <rect width="16" height="16" stroke="none" rx="3"></rect>
                                            <rect width="15" height="15" x=".5" y=".5" fill="none" rx="2.5"></rect>
                                        </g>
                                        <g id="Group_588" transform="translate(5.264 4.783)">
                                            <path id="Line_109" d="M0 0L0 6" stroke="#000" fill="none" stroke-linecap="round" transform="translate(3)"></path>
                                            <path id="Line_110" d="M0 0L0 6" stroke="#000" fill="none" stroke-linecap="round" transform="rotate(90 1.5 4.5)"></path>
                                        </g>
                                    </g>
                                </svg>
                                Add Sub Title
                            </button>
                            <input type="text" name="invoice_sub_title" value="{{!empty($saleInvoice->invoice_sub_title) ? $saleInvoice->invoice_sub_title : ''}}" class="hide_box invoice_sub_title" />
                        </div> -->
                        <!-- .. -->
                        <div class="subtitle">
                            <p class=" invoice_sub_title {{ empty($saleInvoice->invoice_sub_title) ? 'hide_box' : '' }}"><input type="text" class="editableText" value="{{!empty($saleInvoice->invoice_sub_title) && $saleInvoice->invoice_sub_title!= 'undefined' ? $saleInvoice->invoice_sub_title : ''}}" /></p>
                            <button class="subTitle add_more  {{ !empty($saleInvoice->invoice_sub_title) ? 'hide-d' : '' }}" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <g id="plus-square-outline" transform="translate(-.266 .217)">
                                        <g id="Rectangle_1143" fill="rgba(255,255,255,0)" stroke="#000" transform="translate(.266 -.217)">
                                            <rect width="16" height="16" stroke="none" rx="3"></rect>
                                            <rect width="15" height="15" x=".5" y=".5" fill="none" rx="2.5">
                                            </rect>
                                        </g>
                                        <g id="Group_588" transform="translate(5.264 4.783)">
                                            <path id="Line_109" d="M0 0L0 6" stroke="#000" fill="none" stroke-linecap="round" transform="translate(3)"></path>
                                            <path id="Line_110" d="M0 0L0 6" stroke="#000" fill="none" stroke-linecap="round" transform="rotate(90 1.5 4.5)">
                                            </path>
                                        </g>
                                    </g>
                                </svg>
                                Add Sub Title
                            </button>
                        </div>
                        <!-- .. -->
                    </div>
                    <div class="page_minidetail">
                        <div class="inner_left col-lg-6 flush">
                            <ul class="append_top_column">
                                <li>
                                    <span>
                                        <h6 class="editableText label_invoice_no">{{ !empty($saleInvoice->label_invoice_no) ? $saleInvoice->label_invoice_no : 'Invoice No'}} </h6>
                                    </span>
                                    <div>
                                        <input type="text" class="invoice_no" name="invoice_no" id="" value="<?= !empty($saleInvoice->invoice_no) && $is_inv_duplicate!=1 ? $saleInvoice->invoice_no :  @$new_invoice_no ?>">
                                        <p> {{ !empty($lastSaleInvoiceNo->invoice_no) ? 'Last Invoice No: '. $lastSaleInvoiceNo->invoice_no : ''}} {{ !empty($lastSaleInvoiceNo->created_at) ? '('. date('F d, Y', strtotime(@$lastSaleInvoiceNo->created_at)) .')' : ''}} </p>
                                    </div>
                                </li>
                                <li>
                                    <span>
                                        <h6 class="editableText label_invoice_date"> {{ !empty($saleInvoice->label_invoice_date) ? $saleInvoice->label_invoice_date : 'Invoice Date'}}</h6>
                                    </span>
                                    <div class="withicon">
                                        <input type="text" class="datepicker invoice_date" name="invoice_date" autocomplete="off" value="{{!empty($saleInvoice->invoice_date) ? $saleInvoice->invoice_date : ''}}">
                                        <button class="datepicker-button" type="button"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" color="#000" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7.55556 6.44444V2V6.44444ZM16.4444 6.44444V2V6.44444ZM6.44444 10.8889H17.5556H6.44444ZM4.22222 22H19.7778C21.0051 22 22 21.0051 22 19.7778V6.44444C22 5.21714 21.0051 4.22222 19.7778 4.22222H4.22222C2.99492 4.22222 2 5.21714 2 6.44444V19.7778C2 21.0051 2.99492 22 4.22222 22Z" stroke-linecap="round" stroke-width="2px" stroke-linejoin="round"></path>
                                            </svg></button>
                                    </div>
                                </li>
                                <li>
                                    <span>
                                        <h6 class="editableText label_invoice_due_date"> {{ !empty($saleInvoice->label_invoice_due_date) ? $saleInvoice->label_invoice_due_date : 'Due Date' }}</h6>
                                    </span>
                                    <div class="withicon">
                                        <input type="text" class="datepicker2 due_date" name="due_date" autocomplete="off" value="{{!empty($saleInvoice->due_date) ? $saleInvoice->due_date : ''}}">
                                        <button class="datepicker-button2" type="button"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" color="#000" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7.55556 6.44444V2V6.44444ZM16.4444 6.44444V2V6.44444ZM6.44444 10.8889H17.5556H6.44444ZM4.22222 22H19.7778C21.0051 22 22 21.0051 22 19.7778V6.44444C22 5.21714 21.0051 4.22222 19.7778 4.22222H4.22222C2.99492 4.22222 2 5.21714 2 6.44444V19.7778C2 21.0051 2.99492 22 4.22222 22Z" stroke-linecap="round" stroke-width="2px" stroke-linejoin="round"></path>
                                            </svg></button>
                                    </div>
                                    <a href="#" data-toggle="modal" data-target="#duedate"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" color="#9A9EA4" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.0746 3.46472C10.2947 2.47988 11.395 1.82332 12.3852 2.04217C13.0454 2.26102 13.5955 2.69873 13.8156 3.46472C14.0356 4.44956 15.1359 5.10612 16.1261 4.88727C16.3462 4.88727 16.4562 4.77784 16.6763 4.66841C17.5565 4.12128 18.7668 4.44956 19.3169 5.32497C19.647 5.98153 19.647 6.63809 19.3169 7.29465C18.7668 8.17007 19.0969 9.37376 19.9771 9.92089C20.1972 10.0303 20.3072 10.1397 20.5272 10.1397C21.5175 10.3586 22.1777 11.4529 21.9576 12.4377C21.7375 13.0943 21.2974 13.6414 20.5272 13.8603C19.537 14.0791 18.8768 15.1734 19.0969 16.1582C19.0969 16.3771 19.2069 16.4865 19.3169 16.7053C19.8671 17.5808 19.537 18.7845 18.6568 19.3316C17.9966 19.6599 17.3365 19.6599 16.6763 19.3316C15.7961 18.7845 14.5858 19.1127 14.0356 19.9881C13.9256 20.207 13.8156 20.3164 13.8156 20.5353C13.5955 21.5201 12.4952 22.1767 11.505 21.9578C10.8448 21.739 10.2947 21.3013 10.0746 20.5353C9.85459 19.5504 8.75432 18.8939 7.76407 19.1127C7.54402 19.1127 7.43399 19.2222 7.21393 19.3316C6.33372 19.8787 5.12342 19.5504 4.57328 18.675C4.2432 18.0185 4.2432 17.3619 4.57328 16.7053C5.12342 15.8299 4.79333 14.6262 3.91311 14.0791C3.69306 13.9697 3.58303 13.8603 3.36298 13.8603C2.48276 13.532 1.8226 12.4377 2.04265 11.4529C2.2627 10.7963 2.81284 10.2492 3.47301 10.0303C4.46325 9.81147 5.12342 8.7172 4.90336 7.73236C4.90336 7.51351 4.79333 7.40408 4.68331 7.18523C4.13317 6.30981 4.35322 5.21555 5.34347 4.66841C5.89361 4.23071 6.6638 4.23071 7.32396 4.66841C8.20418 5.21555 9.41448 4.88727 9.96462 4.01185C9.96462 3.90243 10.0746 3.68357 10.0746 3.46472Z" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M15 12C15 13.7 13.7 15 12 15C10.3 15 9 13.7 9 12C9 10.3 10.3 9 12 9C13.7 9 15 10.3 15 12Z" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg></a>
                                </li>
                                <li class="last_top_li">
                                    @php
                                    $invoice_custome_filed = json_decode($saleInvoice->invoice_custome_filed);
                                    $total_top_tkey = count((array)$invoice_custome_filed);
                                    @endphp
                                    @if(!empty($invoice_custome_filed))
                                    @foreach($invoice_custome_filed as $key=>$custome_filed)
                                    @if(!empty($custome_filed->value))
                                <li class="ui-state-default show top_rwo_{{$key}}" key="{{$key}}">
                                    <input type="text" class="invoice_custome_filed_key" name="col_key{{$key}}" id="" value="{{$custome_filed->key}}" placeholder="Fields name">

                                    <div>
                                        <input type="text" class="invoice_custome_filed_value" name="col_value[{{$key}}]" id="" value="{{$custome_filed->value}}" placeholder="Value">
                                    </div>
                                    <a href="javascript:void(0)" onclick="removeTopColumn(this)" data-id="{{$key}}" class="close">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" color="#006AFF" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.35355 4.64645C5.15829 4.45118 4.84171 4.45118 4.64645 4.64645C4.45118 4.84171 4.45118 5.15829 4.64645 5.35355L5.35355 4.64645ZM18.6464 19.3536C18.8417 19.5488 19.1583 19.5488 19.3536 19.3536C19.5488 19.1583 19.5488 18.8417 19.3536 18.6464L18.6464 19.3536ZM4.64645 5.35355L18.6464 19.3536L19.3536 18.6464L5.35355 4.64645L4.64645 5.35355Z"></path>
                                            <path d="M19.3536 5.35355C19.5488 5.15829 19.5488 4.84171 19.3536 4.64645C19.1583 4.45118 18.8417 4.45118 18.6464 4.64645L19.3536 5.35355ZM4.64645 18.6464C4.45118 18.8417 4.45118 19.1583 4.64645 19.3536C4.84171 19.5488 5.15829 19.5488 5.35355 19.3536L4.64645 18.6464ZM18.6464 4.64645L4.64645 18.6464L5.35355 19.3536L19.3536 5.35355L18.6464 4.64645Z"></path>
                                        </svg>
                                    </a>
                                </li>
                                @endif
                                @endforeach
                                @endif
                                <button class="add_line add_more" type="button" onclick="appendTopColumns(this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                        <g id="plus-square-outline" transform="translate(-.266 .217)">
                                            <g id="Rectangle_1143" fill="rgba(255,255,255,0)" stroke="#000" transform="translate(.266 -.217)">
                                                <rect width="16" height="16" stroke="none" rx="3"></rect>
                                                <rect width="15" height="15" x=".5" y=".5" fill="none" rx="2.5"></rect>
                                            </g>
                                            <g id="Group_588" transform="translate(5.264 4.783)">
                                                <path id="Line_109" d="M0 0L0 6" stroke="#000" fill="none" stroke-linecap="round" transform="translate(3)"></path>
                                                <path id="Line_110" d="M0 0L0 6" stroke="#000" fill="none" stroke-linecap="round" transform="rotate(90 1.5 4.5)"></path>
                                            </g>
                                        </g>
                                    </svg>
                                    Add More Fields
                                </button>
                                </li>
                            </ul>
                        </div>
                        <div class="inner_right col-lg-6 flush">
                            <div class="uploadImageLogo">
                                @if(!empty($saleInvoice->business_logo))
                                <label for="uploadImage" class="btn-upload upload-button" style="display: none;"><iconify-icon icon="mdi:file-image-outline"></iconify-icon> Add Business Logo</label>
                                @else
                                <label for="uploadImage" class="btn-upload upload-button"><iconify-icon icon="mdi:file-image-outline"></iconify-icon> Add Business Logo</label>
                                @endif
                                <label for="uploadImage" id="changeImage" class="btn-upload" style="display: none;"><iconify-icon icon="material-symbols:edit-rounded"></iconify-icon> Change</label>
                                <input type="file" class="business_logo" id="uploadImage" accept="image/*" style="display: none;">

                                <div class="image-preview">
                                    <img id="preview" src="{{!empty($saleInvoice->business_logo) ? $saleInvoice->business_logo : ''}}" alt="Preview Image">
                                </div>
                            </div>
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
                    <div class="biling_detail">
                        <div class="billed_by">
                            <span class="inline_title">
                                <h2 class="editableText label_invoice_billed_by"> {{ !empty($saleInvoice->label_invoice_billed_by) ? $saleInvoice->label_invoice_billed_by : 'Billed By'}}</h2>
                                <span class="tag">(Your Details)</span>
                            </span>
                            <div class="select-full">
                                <select class="js-example-placeholder-single-brand js-states billed_by_business_id " id="billedByBusinessID" onchange="getBusinessDeatil(this)" data-type="billed_by">
                                    <option value="0" selected>Select Companies</option>
                                    @foreach($commonData['business'] as $business)
                                    @if(!empty($saleInvoice->company_id))
                                    <option value="{{@$business->id}}" {{$saleInvoice->company_id == @$business->id ? 'Selected' : '' }}>{{@$business->business_name}}</option>
                                    @else
                                    <option value="{{@$business->id}}" {{@$commonData['active_business_data']->id == @$business->id ? 'Selected' : '' }}>{{@$business->business_name}}</option>
                                    @endif
                                    @endforeach
                                    <!-- <option value="{{$auth_user->active_business_id}}"> {{ @$auth_user->mobile_no  }}</option> -->
                                </select>
                            </div>
                            <div class="miniCard">
                                <div class="title">
                                    <h6>Business details</h6>
                                    <!-- <a href="javascript:void(0)" onclick="showEditBusinessModel(this)"  data-toggle="modal" data-target="#billbyedit"><iconify-icon icon="material-symbols:edit"></iconify-icon> Edit</a> -->
                                    <a href="javascript:void(0)" onclick="showEditBusinessModel(this)" data-target="#billbyedit"><iconify-icon icon="material-symbols:edit"></iconify-icon> Edit</a>
                                </div>
                                <div class="cd_body">
                                    <ul>
                                        <li>
                                            <span>Business Name</span>
                                            @if(!empty($saleInvoice->company_id))
                                            <span class="business_by_name_txt_d"> {{ !empty($saleInvoice->company_name) ? $saleInvoice->company_name : '' }}</span>
                                            <span class="business_by_code_txt_d hide-d"> {{ !empty($saleInvoice->gst_code) ? $saleInvoice->gst_code : '' }}</span>
                                            <span class="business_by_country_txt_d hide-d"> {{ !empty($saleInvoice->billing_from_country_name) ? $saleInvoice->billing_from_country_name : '' }}</span>
                                            <span class="business_by_state_txt_d hide-d"> {{ !empty($saleInvoice->billing_from_state_name) ? $saleInvoice->billing_from_state_name : '' }}</span>
                                            @else
                                            <span class="business_by_name_txt_d"> {{ !empty($commonData['active_business_data']->business_name) ? $commonData['active_business_data']->business_name : '' }}</span>
                                            <span class="business_by_code_txt_d hide-d"> {{ !empty($commonData['active_business_data']->gst_code) ? $commonData['active_business_data']->gst_code : '' }}</span>
                                            <span class="business_by_country_txt_d hide-d"> {{ !empty($commonData['active_business_data']->country) ? $commonData['active_business_data']->country : '' }}</span>
                                            <span class="business_by_state_txt_d hide-d"> {{ !empty($commonData['active_business_data']->state) ? $commonData['active_business_data']->state : '' }}</span>
                                            @endif
                                        </li>
                                        <li>
                                            <span>Address</span>
                                            <span class="business_by_address_txt_d"> {{ !empty($commonData['active_business_data']->street_address) ? $commonData['active_business_data']->street_address : '' }}</span>
                                            <span class="business_by_state_txt_d hide-d"> {{ !empty($commonData['active_business_data']->state) ? $commonData['active_business_data']->state : '' }}</span>
                                            <span class="business_by_zip_txt_d hide-d"> {{ !empty($commonData['active_business_data']->zip_code) ? $commonData['active_business_data']->zip_code : '' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="billed_to">
                            <span class="inline_title">
                                <h2 class="editableText label_invoice_billed_to">{{ !empty($saleInvoice->label_invoice_billed_to) ? $saleInvoice->label_invoice_billed_to : 'Billed To'}} </h2>
                                <span class="tag">(Client Details)</span>
                            </span>
                            <div class="select-full">
                                <select class="js-example-placeholder-single-client bill_customer_id " id="billCustomerID" onchange="getClientBusinessData(this)">
                                    <option value="0" selected>Select Client</option>
                                    @foreach($commonData['customers'] as $customer)
                                    <option value="{{$customer->id}}" {{$saleInvoice->customer_id == @$customer->id ? 'Selected' : '' }}>{{ $customer->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="miniCard  client_empty_form {{!empty($saleInvoice->customer_id) ? 'hide-d' : ''}} ">
                                <div class="empty_card">
                                    <span>Select a Client/Business from list</span><span>Or</span>
                                    <button type="button" class="show_new_client_popup">
                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"></path>
                                        </svg>
                                        Add New Client
                                    </button>
                                </div>
                            </div>

                            <div class="miniCard cient_detail_form  {{!empty($saleInvoice->customer_id) ? '' : 'hide-d'}}">
                                <div class="title">
                                    <h6>Client details</h6>
                                    <!-- <a href="#" data-toggle="modal" data-target="#billtoedit"><iconify-icon icon="material-symbols:edit"></iconify-icon> Edit</a> -->
                                    <a href="javascript:void(0)" onclick="showEditClientModel(this)"><iconify-icon icon="material-symbols:edit"></iconify-icon> Edit</a>
                                </div>
                                <div class="cd_body">
                                    <ul>
                                        <li>
                                            <span>Business Name</span>
                                            <span class="business_to_name_txt_d">{{ !empty($saleInvoice->customer_name) ? $saleInvoice->customer_name : '' }} </span>
                                            <span class="business_to_code_txt_d hide-d"> {{ !empty($saleInvoice->gst_code) ? $saleInvoice->gst_code : '' }}</span>
                                            <span class="client_zip_txt_d hide-d"> {{ !empty($saleInvoice->billing_zip) ? $commonData['active_business_data']->billing_zip : '' }}</span>
                                            <span class="client_country_txt_d hide-d"> {{ !empty($saleInvoice->billing_to_country_name) ? $saleInvoice->billing_to_country_name : '' }}</span>
                                            <span class="client_state_txt_d hide-d"> {{ !empty($saleInvoice->billing_to_state_name) ? $saleInvoice->billing_to_state_name : '' }}</span>

                                        </li>
                                        <li>
                                            <span>Address</span>
                                            <span class="business_to_address_txt_d">
                                                {{ !empty($saleInvoice->customer_address) ? $saleInvoice->customer_address : '' }}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sd_check">
                        <input type="checkbox" name="layout" class="is_shiiping_detail_req" id="showshipping" {{ !empty($saleInvoice->is_shipping_detail_req) ? 'checked' : '' }} />
                        <label class="pull-right text" for="showshipping">Add Shipping Details</label>
                    </div>
                    <div class="biling_detail shipping_details  {{ !empty($saleInvoice->is_shipping_detail_req) ? 'show' : '' }}">
                        <div class="billed_by ship_by col-lg-6">
                            <span class="inline_title">
                                <h2 class="editableText label_invoice_shipped_from"> {{ !empty($saleInvoice->label_invoice_shipped_from) ? $saleInvoice->label_invoice_shipped_from : 'Shipped From'}}</h2>
                            </span>
                            <div class="miniCard">
                                <div class="sd_check"><input type="checkbox" name="layout" id="sameadd" onclick="copyShippingFromData(this)" /> <label class="pull-right text" for="sameadd">Same as your business address</label></div>
                                <div class="cd_body">
                                    <form action="">
                                        <input type="text" name="shipped_from_name" id="" placeholder="Business / Freelancer Name" class="shipped_from_name" value="{{!empty($saleInvoice->shipped_from_name) ? $saleInvoice->shipped_from_name : '' }}" />
                                        <div class="select-full">
                                            <select class="js-example-placeholder-single-country shipping_from_country">
                                                @foreach($commonData['countryList'] as $country)
                                                @if(!empty($saleInvoice->shipped_from_country_id))
                                                <option value="{{@$country->id}}" {{ $country->id == $saleInvoice->shipped_from_country_id ? 'selected' : ''}}>{{@$country->name}}</option>
                                                @else
                                                <option value="{{@$country->id}}" {{ $country->id == 101 ? 'selected' : ''}}>{{@$country->name}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="text" name="shipped_from_address" value="{{!empty($saleInvoice->shipped_from_address) ? $saleInvoice->shipped_from_address : '' }}" class="shipped_from_address" id="" placeholder="Address (optional)" />
                                        <span>
                                            <input type="text" name="shipped_from_city" class="shipped_from_city" id="" placeholder="City (optional)" value="{{!empty($saleInvoice->shipped_from_city) ? $saleInvoice->shipped_from_city : '' }}" />
                                            <input type="text" name="shipped_from_zip_code" class="shipped_from_zip_code" id="" placeholder="Postal Code / Zip Code" value="{{!empty($saleInvoice->shipped_from_zip_code) ? $saleInvoice->shipped_from_zip_code : '' }}" />
                                        </span>
                                        <input type="text" name="shipped_from_state_name" class="shipped_from_state_name" id="" placeholder="State (optional)" value="{{!empty($saleInvoice->shipped_from_state_name) ? $saleInvoice->shipped_from_state_name : '' }}" />
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="billed_by ship_to col-lg-6 select_sss">
                            <span class="inline_title">
                                <h2 class="editableText label_invoice_shipped_to"> {{ !empty($saleInvoice->label_invoice_shipped_to) ? $saleInvoice->label_invoice_shipped_to : 'Shipped To'}}</h2>
                            </span>
                            <select class="js-example-placeholder-single-shaddress shiping_to_dropdown" onchange="getClientShippingAddress(this)">
                                <option value="">Select</option>

                            </select>
                            <div class="miniCard">
                                <div class="sd_check"><input type="checkbox" name="layout" onclick="copyShippingToData(this)" id="sameadd2" /> <label class="pull-right text" for="sameadd2">Same as your business address</label></div>
                                <div class="cd_body">
                                    <form action="">
                                        <input type="text" name="shipped_to_name" class="shipped_to_name" id="" placeholder="Client's business name" value="{{!empty($saleInvoice->shipped_to_name) ? $saleInvoice->shipped_to_name : '' }}" />
                                        <div class="select-full">
                                            <select class="js-example-placeholder-single-country shipped_to_country_id" name="shipped_to_country_id">
                                                <option value=""></option>
                                                @foreach($commonData['countryList'] as $country)
                                                @if(!empty($saleInvoice->shipped_to_country_id))
                                                <option value="{{@$country->id}}" {{ $country->id == $saleInvoice->shipped_to_country_id ? 'selected' : ''}}>{{@$country->name}}</option>
                                                @else
                                                <option value="{{@$country->id}}" {{ $country->id == 101 ? 'selected' : ''}}>{{@$country->name}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="text" name="shipped_to_address" class="shipped_to_address" id="" placeholder="Address (optional)" value="{{!empty($saleInvoice->shipped_to_address) ? $saleInvoice->shipped_to_address : '' }}" />
                                        <span>
                                            <input type="text" name="shipped_to_city" class="shipped_to_city" id="" placeholder="City (optional)" value="{{!empty($saleInvoice->shipped_to_city) ? $saleInvoice->shipped_to_city : '' }}" />
                                            <input type="text" name="shipped_to_zip_code" class="shipped_to_zip_code" id="" placeholder="Postal Code / Zip Code" value="{{!empty($saleInvoice->shipped_to_zip_code) ? $saleInvoice->shipped_to_zip_code : '' }}" />
                                        </span>
                                        <input type="text" name="shipped_to_state_name" class="shipped_to_state_name" id="" placeholder="State (optional)" value="{{!empty($saleInvoice->shipped_to_state_name) ? $saleInvoice->shipped_to_state_name : '' }}" />
                                        <ul class="shipp_cus_data">
                                            <li class="last_top_li">
                                                @php
                                                $invoice_shipping_custome_filed = json_decode($saleInvoice->shipped_to_custome_filed);
                                                $total_shipping_tkey = count((array)$invoice_shipping_custome_filed);
                                                @endphp
                                                @if(!empty($invoice_shipping_custome_filed))
                                                @foreach($invoice_shipping_custome_filed as $key=>$custome_filed)
                                                @if(!empty($custome_filed->value))
                                            <li class="ship_rwo_{{$key}}" key="{{$key}}">
                                                <input type="text" class="shipped_to_custome_filed_key" name="shipped_to_custome_filed_key[{{$key}}]" id="" value="{{@$custome_filed->key}}" placeholder="Value">

                                                <div>
                                                    <input type="text" class="shipped_to_custome_filed_value" name="shipped_to_custome_filed_value[{{$key}}]" id="" value="{{@$custome_filed->value}}" placeholder="Value">
                                                </div>
                                                <a href="javascript:void(0)" onclick="removeShippingCustomField(this)" data-id="{{$key}}" class="close">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" color="#006AFF" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M5.35355 4.64645C5.15829 4.45118 4.84171 4.45118 4.64645 4.64645C4.45118 4.84171 4.45118 5.15829 4.64645 5.35355L5.35355 4.64645ZM18.6464 19.3536C18.8417 19.5488 19.1583 19.5488 19.3536 19.3536C19.5488 19.1583 19.5488 18.8417 19.3536 18.6464L18.6464 19.3536ZM4.64645 5.35355L18.6464 19.3536L19.3536 18.6464L5.35355 4.64645L4.64645 5.35355Z"></path>
                                                        <path d="M19.3536 5.35355C19.5488 5.15829 19.5488 4.84171 19.3536 4.64645C19.1583 4.45118 18.8417 4.45118 18.6464 4.64645L19.3536 5.35355ZM4.64645 18.6464C4.45118 18.8417 4.45118 19.1583 4.64645 19.3536C4.84171 19.5488 5.15829 19.5488 5.35355 19.3536L4.64645 18.6464ZM18.6464 4.64645L4.64645 18.6464L5.35355 19.3536L19.3536 5.35355L18.6464 4.64645Z"></path>
                                                    </svg>
                                                </a>
                                            </li>
                                            @endif
                                            @endforeach
                                            @endif
                                        </ul>
                                        <button class="add_line add_more" type="button" onclick="addShippingCustomFields(this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                                <g id="plus-square-outline" transform="translate(-.266 .217)">
                                                    <g id="Rectangle_1143" fill="rgba(255,255,255,0)" stroke="#000" transform="translate(.266 -.217)">
                                                        <rect width="16" height="16" stroke="none" rx="3"></rect>
                                                        <rect width="15" height="15" x=".5" y=".5" fill="none" rx="2.5"></rect>
                                                    </g>
                                                    <g id="Group_588" transform="translate(5.264 4.783)">
                                                        <path id="Line_109" d="M0 0L0 6" stroke="#000" fill="none" stroke-linecap="round" transform="translate(3)"></path>
                                                        <path id="Line_110" d="M0 0L0 6" stroke="#000" fill="none" stroke-linecap="round" transform="rotate(90 1.5 4.5)"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                            Add More Fields
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="biling_detail shipping_details {{ !empty($saleInvoice->is_shipping_detail_req) ? 'show' : '' }}">
                        <div class="billed_by col-lg-6">
                            <span class="inline_title invoice_transport_details_div">
                                <h2 class="editableText label_invoice_transport_details"> {{ !empty($saleInvoice->label_invoice_transport_details) ? $saleInvoice->label_invoice_transport_details : 'Transport Details'}}</h2>
                            </span>
                            <div class="miniCard sidebyside">
                                <form action="">
                                    <div class="side">
                                        <div class="lside challan_no_div ">
                                            <span>
                                                <h6 class="editableText label_invoice_challan_no"> {{ !empty($saleInvoice->label_invoice_challan_no) ? $saleInvoice->label_invoice_challan_no : 'Challan Number'}}</h6>
                                            </span>
                                        </div>
                                        <div class="rside">
                                            <input name="challan_number" class="challan_number" placeholder="Challan Number (optional)" value="{{!empty($saleInvoice->transport_challan) ? $saleInvoice->transport_challan : '' }}" />
                                        </div>
                                        <div class="lside challan_date_div">
                                            <span>
                                                <h6 class="editableText label_invoice_challan_date"> {{ !empty($saleInvoice->label_invoice_challan_date) ? $saleInvoice->label_invoice_challan_date : 'Challan Date'}}</h6>
                                            </span>
                                        </div>
                                        <div class="rside">
                                            <div class="withicon">
                                                <input type="text" class="datepicker3 challan_date" name="challan_date" autocomplete="off" value="{{!empty($saleInvoice->transport_challan_date) ? $saleInvoice->transport_challan_date : '' }}" placeholder="Challan Date (optional)">
                                                <button class="datepicker3-button" type="button"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" color="#000" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.55556 6.44444V2V6.44444ZM16.4444 6.44444V2V6.44444ZM6.44444 10.8889H17.5556H6.44444ZM4.22222 22H19.7778C21.0051 22 22 21.0051 22 19.7778V6.44444C22 5.21714 21.0051 4.22222 19.7778 4.22222H4.22222C2.99492 4.22222 2 5.21714 2 6.44444V19.7778C2 21.0051 2.99492 22 4.22222 22Z" stroke-linecap="round" stroke-width="2px" stroke-linejoin="round"></path>
                                                    </svg></button>
                                            </div>
                                            <!-- <input placeholder="Challan Date (optional)" value="{{!empty($saleInvoice->shipped_to_state_name) ? $saleInvoice->shipped_to_state_name : '' }}" /> -->
                                        </div>

                                        <div class="lside invoice_transport_div">
                                            <span>
                                                <h6 class="editableText label_invoice_transport"> {{ !empty($saleInvoice->label_invoice_transport) ? $saleInvoice->label_invoice_transport : 'Transport'}}</h6>
                                            </span>
                                        </div>
                                        <div class="rside">
                                            <input name="transport_name" class="transport_name" placeholder="Transport Name (optional)" value="{{!empty($saleInvoice->transport_name) ? $saleInvoice->transport_name : '' }}" />
                                        </div>

                                        <div class="lside extra_information_div">
                                            <span>
                                                <h6 class="editableText label_invoice_extra_information">{{ !empty($saleInvoice->label_invoice_extra_information) ? $saleInvoice->label_invoice_extra_information : 'Extra Information'}} </h6>
                                            </span>
                                        </div>
                                        <div class="rside">
                                            <textarea name="shipping_note" class="shipping_note" placeholder="Shipping Note (optional)" rows="4" value="">
                                            {{!empty($saleInvoice->transport_information) ? $saleInvoice->transport_information : '' }}
                                            </textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="actions">
                        <button data-toggle="modal" data-target="#changeGst"><iconify-icon icon="akar-icons:percentage"></iconify-icon> Change GST</button>
                        <select class="js-example-placeholder-single-currency currency_id" name="currency_id">
                            @foreach($currencies as $currency)
                            <option value="{{@$currency->unit}}" data-cid="{{@$currency->id}}" data-id="{{@$currency->type}}" data-unit="{{@$currency->minimun_rupees}}">{{@$currency->name}}</option>
                            @endforeach
                        </select>
                        <!-- <button data-toggle="modal" data-target="#changenumberformat"><iconify-icon icon="mdi:123"></iconify-icon> Change Number Format</button> -->
                        <!-- <button data-toggle="modal" data-target="#editcolumns"><iconify-icon icon="material-symbols:table-chart-outline"></iconify-icon> Rename/Add Fields</button> -->
                        <button class="show_column_modal" onclick="showColumnModal(this)"><iconify-icon icon="material-symbols:table-chart-outline"></iconify-icon> Rename/Add Fields</button>
                    </div>
                    <div class="gst_option comn_rate_col {{$saleInvoice->tax_type=='none' ? 'hide-d' : ''}}">
                        <div class="form-check">
                            <input class="form-check-input i_c_s_gst_radio" value="IGST" type="radio" name="final_igst" id="final_igst1" {{  $saleInvoice->is_tax != 'CGST' ? 'checked' : '' }}>
                            <label class="form-check-label" for="final_igst1">
                                IGST
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input i_c_s_gst_radio" value="CGST" type="radio" name="final_igst" id="final_sgst2" {{ !empty($saleInvoice->is_tax) && $saleInvoice->is_tax == 'CGST' ? 'checked' : '' }}>
                            <label class="form-check-label" for="final_sgst2">
                                CGST & SGST
                            </label>
                        </div>
                    </div>
                    <div class="page_table">
                        <div cols="20" class="thead" id="loadColumnOnPage">
                        </div>
                        <div cols="22" class="tbody tble_append_d mainTable">
                            <div class="tbody_column ui-state-default loadColumnFieldsOnPage" data-main_listing_index="0">

                            </div>
                            <!-- .. -->
                            <!-- <div class="empty_rw_gp"></div> -->
                        </div>
                        <div class="add_button bt_footer">
                            <button class="addnewcolumn addNewLineBtn" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <g id="plus-square-outline" transform="translate(-.266 .217)">
                                        <g id="Rectangle_1143" fill="rgba(255,255,255,0)" stroke="#006AFF" transform="translate(.266 -.217)">
                                            <rect width="16" height="16" stroke="none" rx="3"></rect>
                                            <rect width="15" height="15" x=".5" y=".5" fill="none" rx="2.5"></rect>
                                        </g>
                                        <g id="Group_588" transform="translate(5.264 4.783)">
                                            <path id="Line_109" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="translate(3)"></path>
                                            <path id="Line_110" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="rotate(90 1.5 4.5)"></path>
                                        </g>
                                    </g>
                                </svg>
                                <span class="">Add New Line</span>
                            </button>
                            <button class="addnewgroup appendItemGroup " type="button" onclick="appendItemGroup(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <g id="plus-square-outline" transform="translate(-.266 .217)">
                                        <g id="Rectangle_1143" fill="rgba(255,255,255,0)" stroke="#006AFF" transform="translate(.266 -.217)">
                                            <rect width="16" height="16" stroke="none" rx="3"></rect>
                                            <rect width="15" height="15" x=".5" y=".5" fill="none" rx="2.5"></rect>
                                        </g>
                                        <g id="Group_588" transform="translate(5.264 4.783)">
                                            <path id="Line_109" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="translate(3)"></path>
                                            <path id="Line_110" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="rotate(90 1.5 4.5)"></path>
                                        </g>
                                    </g>
                                </svg>
                                <span class="">Add New Group</span>
                            </button>
                        </div>
                    </div>
                    <div class="page_amount">
                        <div class="empty"></div>
                        <div class="charges ">
                            <div class="ch-col withclose hide_discount_item  {{!empty($saleInvoice->final_total_discount_reductions) ? 'show' : '' }}">
                                <span>Reductions</span>
                                <span class="withIn">
                                    <input type="text" class="dic_out final_product_wise_discount discount_on_total final_total_discount_reductions" value=" {{!empty($saleInvoice->final_total_discount_reductions) ? $saleInvoice->final_total_discount_reductions : '' }}">
                                    <div class="select_full_se">
                                        <select class="js-states form-control nosearch final_product_wise_discount_unit common_currency_sel_d discount_on_total_type final_total_discount_reductions_unit">
                                            <option value="rupees" data-id="₹" {{$saleInvoice->final_total_discount_reductions_unit != '%' ? 'selected' : ''}}>₹</option>
                                            <option value="%" {{ $saleInvoice->final_total_discount_reductions_unit == '%' ? 'selected' : ''}}>%</option>
                                        </select>
                                    </div>
                                </span>
                                <button class="close_btn" type="button"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" color="#733dd9" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.35355 4.64645C5.15829 4.45118 4.84171 4.45118 4.64645 4.64645C4.45118 4.84171 4.45118 5.15829 4.64645 5.35355L5.35355 4.64645ZM18.6464 19.3536C18.8417 19.5488 19.1583 19.5488 19.3536 19.3536C19.5488 19.1583 19.5488 18.8417 19.3536 18.6464L18.6464 19.3536ZM4.64645 5.35355L18.6464 19.3536L19.3536 18.6464L5.35355 4.64645L4.64645 5.35355Z"></path>
                                        <path d="M19.3536 5.35355C19.5488 5.15829 19.5488 4.84171 19.3536 4.64645C19.1583 4.45118 18.8417 4.45118 18.6464 4.64645L19.3536 5.35355ZM4.64645 18.6464C4.45118 18.8417 4.45118 19.1583 4.64645 19.3536C4.84171 19.5488 5.15829 19.5488 5.35355 19.3536L4.64645 18.6464ZM18.6464 4.64645L4.64645 18.6464L5.35355 19.3536L19.3536 5.35355L18.6464 4.64645Z"></path>
                                    </svg></button>
                            </div>
                            <div class="ch-col">
                                <span>Amount</span>
                                <span><b><span class="g_total_sign">₹</span> <span id="showTotal_d"> {{!empty($saleInvoice->final_amount) ? $saleInvoice->final_amount : '' }}</span></b></span>
                            </div>
                            <div class="ch-col igst_td  {{$saleInvoice->is_tax == 'IGST' ? '' : 'hide-d'}}">
                                <span>IGST</span>
                                <span><b id=""><span class="g_total_sign">₹</span><span id="showTotalIGST_d">{{!empty($saleInvoice->final_igst) ? $saleInvoice->final_igst : '' }}</span></b></span>
                            </div>
                            <div class="ch-col c_s_gst_td  {{$saleInvoice->is_tax == 'CGST' ? '' : 'hide-d'}}">
                                <span>SGST</span>
                                <span><b id=""><span class="g_total_sign">₹</span><span id="showTotalSgst_d">{{!empty($saleInvoice->final_sgst) ? $saleInvoice->final_sgst : '' }}</span></b></span>
                            </div>
                            <div class="ch-col c_s_gst_td  {{$saleInvoice->is_tax == 'CGST' ? '' : 'hide-d'}}">
                                <span>CGST</span>
                                <span><b id=""><span class="g_total_sign">₹</span><span id="showTotalCgst_d">{{!empty($saleInvoice->final_cgst) ? $saleInvoice->final_cgst : '' }}</span></b></span>
                            </div>
                            <div class="ch-col withclose hide_addcharges_item extra_changes_div {{!empty($saleInvoice->final_extra_charges) ? 'show' : '' }}">
                                <span>Extra Charges</span>
                                <span class="withIn">
                                    <input type="text" class="dic_out extra_changes" value="{{!empty($saleInvoice->final_extra_charges) ? $saleInvoice->final_extra_charges : '' }}">
                                    <div class="select_full_se">
                                        <select class="js-states form-control nosearch extra_changes_unit common_currency_sel_d extra_charges_type">
                                            <option value="rupees" data-id="₹" {{ $saleInvoice->extra_changes_unit != '%' ? 'selected' : ''}}>₹</option>
                                            <option value="%" {{ $saleInvoice->extra_changes_unit == '%' ? 'selected' : ''}}>%</option>
                                        </select>
                                    </div>
                                </span>
                                <button class="close_btn" type="button"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" color="#733dd9" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.35355 4.64645C5.15829 4.45118 4.84171 4.45118 4.64645 4.64645C4.45118 4.84171 4.45118 5.15829 4.64645 5.35355L5.35355 4.64645ZM18.6464 19.3536C18.8417 19.5488 19.1583 19.5488 19.3536 19.3536C19.5488 19.1583 19.5488 18.8417 19.3536 18.6464L18.6464 19.3536ZM4.64645 5.35355L18.6464 19.3536L19.3536 18.6464L5.35355 4.64645L4.64645 5.35355Z"></path>
                                        <path d="M19.3536 5.35355C19.5488 5.15829 19.5488 4.84171 19.3536 4.64645C19.1583 4.45118 18.8417 4.45118 18.6464 4.64645L19.3536 5.35355ZM4.64645 18.6464C4.45118 18.8417 4.45118 19.1583 4.64645 19.3536C4.84171 19.5488 5.15829 19.5488 5.35355 19.3536L4.64645 18.6464ZM18.6464 4.64645L4.64645 18.6464L5.35355 19.3536L19.3536 5.35355L18.6464 4.64645Z"></path>
                                    </svg></button>
                            </div>
                            <div class="ch-col withclose round_on_hide label_round_up_div {{!empty($saleInvoice->round_up) ? 'show' : '' }}" data-show="{{!empty($saleInvoice->round_up) ? 'yes' : '' }}">
                                <span class="editableText">{{ !empty($saleInvoice->label_round_up) ? $saleInvoice->label_round_up : 'Round on'}}</span>
                                <span class="withIn">
                                    <input type="text" class="dic_out round_up_d" value="{{!empty($saleInvoice->round_up) ? $saleInvoice->round_up : '0' }}">
                                </span>
                                <button class="close_btn" type="button"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" color="#733dd9" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.35355 4.64645C5.15829 4.45118 4.84171 4.45118 4.64645 4.64645C4.45118 4.84171 4.45118 5.15829 4.64645 5.35355L5.35355 4.64645ZM18.6464 19.3536C18.8417 19.5488 19.1583 19.5488 19.3536 19.3536C19.5488 19.1583 19.5488 18.8417 19.3536 18.6464L18.6464 19.3536ZM4.64645 5.35355L18.6464 19.3536L19.3536 18.6464L5.35355 4.64645L4.64645 5.35355Z"></path>
                                        <path d="M19.3536 5.35355C19.5488 5.15829 19.5488 4.84171 19.3536 4.64645C19.1583 4.45118 18.8417 4.45118 18.6464 4.64645L19.3536 5.35355ZM4.64645 18.6464C4.45118 18.8417 4.45118 19.1583 4.64645 19.3536C4.84171 19.5488 5.15829 19.5488 5.35355 19.3536L4.64645 18.6464ZM18.6464 4.64645L4.64645 18.6464L5.35355 19.3536L19.3536 5.35355L18.6464 4.64645Z"></path>
                                    </svg></button>
                            </div>
                            <div class="ch-col withclose round_off_hide label_round_down_div {{!empty($saleInvoice->round_down) ? 'show' : '' }}" data-show="{{!empty($saleInvoice->round_down) ? 'yes' : '' }}">
                                <span class="editableText"> {{ !empty($saleInvoice->label_round_down) ? $saleInvoice->label_round_down : 'Round off'}} </span>
                                <span class="withIn">
                                    <input type="text" class="dic_out round_down_d" value="{{ !empty($saleInvoice->round_down) ? $saleInvoice->round_down : '0' }}">
                                </span>
                                <button class="close_btn" type="button"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" color="#733dd9" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.35355 4.64645C5.15829 4.45118 4.84171 4.45118 4.64645 4.64645C4.45118 4.84171 4.45118 5.15829 4.64645 5.35355L5.35355 4.64645ZM18.6464 19.3536C18.8417 19.5488 19.1583 19.5488 19.3536 19.3536C19.5488 19.1583 19.5488 18.8417 19.3536 18.6464L18.6464 19.3536ZM4.64645 5.35355L18.6464 19.3536L19.3536 18.6464L5.35355 4.64645L4.64645 5.35355Z"></path>
                                        <path d="M19.3536 5.35355C19.5488 5.15829 19.5488 4.84171 19.3536 4.64645C19.1583 4.45118 18.8417 4.45118 18.6464 4.64645L19.3536 5.35355ZM4.64645 18.6464C4.45118 18.8417 4.45118 19.1583 4.64645 19.3536C4.84171 19.5488 5.15829 19.5488 5.35355 19.3536L4.64645 18.6464ZM18.6464 4.64645L4.64645 18.6464L5.35355 19.3536L19.3536 5.35355L18.6464 4.64645Z"></path>
                                    </svg></button>
                            </div>
                            <div class="vh-col">
                                <div class="hide_options">
                                    <button class="giwd" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16">
                                            <g>
                                                <g fill="none" stroke="#000">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.882 10.52l-5.354 5.354a1.493 1.493 0 0 1-2.113 0L2 9.467V2h7.467l6.414 6.414a1.493 1.493 0 0 1 .001 2.106z" transform="translate(-1.996 -1) translate(.852 -.146)"></path>
                                                    <g transform="translate(-1.996 -1) translate(.852 -.146) translate(4.145 4.146)">
                                                        <circle cx="2" cy="2" r="2" stroke="none"></circle>
                                                        <circle cx="2" cy="2" r="1.5"></circle>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                        Give Discount on Total
                                    </button>
                                    <!-- <button class="gdtotal" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                            <g id="plus-square-outline" transform="translate(-.266 .217)">
                                                <g id="Rectangle_1143" fill="rgba(255,255,255,0)" stroke="#733dd9" transform="translate(.266 -.217)">
                                                    <rect width="16" height="16" stroke="none" rx="3"></rect>
                                                    <rect width="15" height="15" x=".5" y=".5" fill="none" rx="2.5"></rect>
                                                </g>
                                                <g id="Group_588" transform="translate(5.264 4.783)">
                                                    <path id="Line_109" d="M0 0L0 6" stroke="#733dd9" fill="none" stroke-linecap="round" transform="translate(3)"></path>
                                                    <path id="Line_110" d="M0 0L0 6" stroke="#733dd9" fill="none" stroke-linecap="round" transform="rotate(90 1.5 4.5)"></path>
                                                </g>
                                            </g>
                                        </svg>
                                        Give Discount on Total
                                    </button> -->
                                    <button class="aachardes" type="button" onclick="addMoreExtraChanges()">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                            <g id="plus-square-outline" transform="translate(-.266 .217)">
                                                <g id="Rectangle_1143" fill="rgba(255,255,255,0)" stroke="#733dd9" transform="translate(.266 -.217)">
                                                    <rect width="16" height="16" stroke="none" rx="3"></rect>
                                                    <rect width="15" height="15" x=".5" y=".5" fill="none" rx="2.5"></rect>
                                                </g>
                                                <g id="Group_588" transform="translate(5.264 4.783)">
                                                    <path id="Line_109" d="M0 0L0 6" stroke="#733dd9" fill="none" stroke-linecap="round" transform="translate(3)"></path>
                                                    <path id="Line_110" d="M0 0L0 6" stroke="#733dd9" fill="none" stroke-linecap="round" transform="rotate(90 1.5 4.5)"></path>
                                                </g>
                                            </g>
                                        </svg>
                                        Add Additional Charges
                                    </button>
                                </div>
                                <button class="show_additional_charge" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16">
                                        <g>
                                            <g fill="none" stroke="#000">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.882 10.52l-5.354 5.354a1.493 1.493 0 0 1-2.113 0L2 9.467V2h7.467l6.414 6.414a1.493 1.493 0 0 1 .001 2.106z" transform="translate(-1.996 -1) translate(.852 -.146)"></path>
                                                <g transform="translate(-1.996 -1) translate(.852 -.146) translate(4.145 4.146)">
                                                    <circle cx="2" cy="2" r="2" stroke="none"></circle>
                                                    <circle cx="2" cy="2" r="1.5"></circle>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                    Add Discounts/Additional Charges
                                </button>
                            </div>
                            <div class="round_state">
                                <button class="show_round_on  " type="button">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" color="#733dd9" height="16" width="16" xmlns="http://www.w3.org/2000/svg" style="color: #006AFF;">
                                        <path fill-rule="evenodd" d="M3.17 6.706a5 5 0 017.103-3.16.5.5 0 10.454-.892A6 6 0 1013.455 5.5a.5.5 0 00-.91.417 5 5 0 11-9.375.789z" clip-rule="evenodd"></path>
                                        <path fill-rule="evenodd" d="M8.147.146a.5.5 0 01.707 0l2.5 2.5a.5.5 0 010 .708l-2.5 2.5a.5.5 0 11-.707-.708L10.293 3 8.147.854a.5.5 0 010-.708z" clip-rule="evenodd"></path>
                                    </svg>
                                    Round Up
                                </button>
                                <button class="show_round_off " type="button">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" color="#733dd9" height="16" width="16" xmlns="http://www.w3.org/2000/svg" style="color: #006AFF;">
                                        <path fill-rule="evenodd" d="M12.83 6.706a5 5 0 00-7.103-3.16.5.5 0 11-.454-.892A6 6 0 112.545 5.5a.5.5 0 11.91.417 5 5 0 109.375.789z" clip-rule="evenodd"></path>
                                        <path fill-rule="evenodd" d="M7.854.146a.5.5 0 00-.708 0l-2.5 2.5a.5.5 0 000 .708l2.5 2.5a.5.5 0 10.708-.708L5.707 3 7.854.854a.5.5 0 000-.708z" clip-rule="evenodd"></path>
                                    </svg>
                                    Round Down
                                </button>
                            </div>
                            <div class="sd_check"><input type="checkbox" class="final_summarise_total_quantity" value="1" name="final_summarise_total_quantity" id="total_quantity" {{ !empty($saleInvoice->final_summarise_total_quantity) ? 'checked' : '' }}> <label class="pull-right text" for="total_quantity">Summarise Total Quantity</label></div>
                            <div class="total-col">
                                <span class="inline_title label_total_div">
                                    <h2 class="editableText ">{{ !empty($saleInvoice->label_total) ? $saleInvoice->label_inlabel_totalvoice_transport : 'Total'}}</h2>
                                    <span class="tag ">(<span class="tag_total_sign">INR</span>)</span>
                                </span>
                                <h6 class="final_total" id="finalGrandTotal12"> <span class="g_total_sign">₹</span> <span id="finalGrandTotal"> {{@$saleInvoice->final_total ? @$saleInvoice->final_total : '' }}</span> </h6>
                            </div>
                            <div class="vh-col">
                                <div class="total-col hidden_total totalnWords {{ !empty($saleInvoice->is_total_words_show) ? 'show' : '' }} ">
                                    <span class="inline_title">
                                        <h2 class="editableText">Total (in words)</h2>
                                        <h2 class="editableText final_total_words"> {{@$saleInvoice->final_total_words ? @$saleInvoice->final_total_words : '' }}</h2>
                                    </span>
                                    <button aria-label="Hide Total In Words" type="button" class="close_btn"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" color="#733dd9" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.35355 4.64645C5.15829 4.45118 4.84171 4.45118 4.64645 4.64645C4.45118 4.84171 4.45118 5.15829 4.64645 5.35355L5.35355 4.64645ZM18.6464 19.3536C18.8417 19.5488 19.1583 19.5488 19.3536 19.3536C19.5488 19.1583 19.5488 18.8417 19.3536 18.6464L18.6464 19.3536ZM4.64645 5.35355L18.6464 19.3536L19.3536 18.6464L5.35355 4.64645L4.64645 5.35355Z"></path>
                                            <path d="M19.3536 5.35355C19.5488 5.15829 19.5488 4.84171 19.3536 4.64645C19.1583 4.45118 18.8417 4.45118 18.6464 4.64645L19.3536 5.35355ZM4.64645 18.6464C4.45118 18.8417 4.45118 19.1583 4.64645 19.3536C4.84171 19.5488 5.15829 19.5488 5.35355 19.3536L4.64645 18.6464ZM18.6464 4.64645L4.64645 18.6464L5.35355 19.3536L19.3536 5.35355L18.6464 4.64645Z"></path>
                                        </svg></button>
                                </div>
                                <input type="hidden" class="is_totalInwordshow" value="0" />
                                <button class="show_total" type="button">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024" color="#006AFF" height="20" width="20" xmlns="http://www.w3.org/2000/svg" style="color: #006AFF;">
                                        <path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372 372 166.6 372 372-166.6 372-372 372zm47.7-395.2l-25.4-5.9V348.6c38 5.2 61.5 29 65.5 58.2.5 4 3.9 6.9 7.9 6.9h44.9c4.7 0 8.4-4.1 8-8.8-6.1-62.3-57.4-102.3-125.9-109.2V263c0-4.4-3.6-8-8-8h-28.1c-4.4 0-8 3.6-8 8v33c-70.8 6.9-126.2 46-126.2 119 0 67.6 49.8 100.2 102.1 112.7l24.7 6.3v142.7c-44.2-5.9-69-29.5-74.1-61.3-.6-3.8-4-6.6-7.9-6.6H363c-4.7 0-8.4 4-8 8.7 4.5 55 46.2 105.6 135.2 112.1V761c0 4.4 3.6 8 8 8h28.4c4.4 0 8-3.6 8-8.1l-.2-31.7c78.3-6.9 134.3-48.8 134.3-124-.1-69.4-44.2-100.4-109-116.4zm-68.6-16.2c-5.6-1.6-10.3-3.1-15-5-33.8-12.2-49.5-31.9-49.5-57.3 0-36.3 27.5-57 64.5-61.7v124zM534.3 677V543.3c3.1.9 5.9 1.6 8.8 2.2 47.3 14.4 63.2 34.4 63.2 65.1 0 39.1-29.4 62.6-72 66.4z"></path>
                                    </svg>
                                    Show Total In Words
                                </button>
                            </div>
                            <div class="vh-col btm_hdr">
                                @php
                                $finalDyanmiRows = !empty($saleInvoice->final_total_more_filed) ? json_decode($saleInvoice->final_total_more_filed) : [];
                                $finalDyanmiRowsCount = (!empty($finalDyanmiRows) ? count((array)$finalDyanmiRows) : '');
                                @endphp
                                @if(!empty($finalDyanmiRows))
                                @foreach($finalDyanmiRows as $key=>$custom_filed)
                                @if(!empty($custom_filed->value))
                                <div class="add_field_item show bt_rwo_{{@$key}}">
                                    <input type="text" class="big_field bottom_custome_filed_key" placeholder="Field Name " value="{{@$custom_filed->key}}">
                                    <input type="text" class="small_field bottom_to_custome_filed_value" placeholder="Value" value="{{@$custom_filed->value}}">
                                    <button class="close_re_btn" type="button" onclick="removeBottomCustomField(this)" data-id="{{@$key}}"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" color="#733dd9" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.35355 4.64645C5.15829 4.45118 4.84171 4.45118 4.64645 4.64645C4.45118 4.84171 4.45118 5.15829 4.64645 5.35355L5.35355 4.64645ZM18.6464 19.3536C18.8417 19.5488 19.1583 19.5488 19.3536 19.3536C19.5488 19.1583 19.5488 18.8417 19.3536 18.6464L18.6464 19.3536ZM4.64645 5.35355L18.6464 19.3536L19.3536 18.6464L5.35355 4.64645L4.64645 5.35355Z"></path>
                                            <path d="M19.3536 5.35355C19.5488 5.15829 19.5488 4.84171 19.3536 4.64645C19.1583 4.45118 18.8417 4.45118 18.6464 4.64645L19.3536 5.35355ZM4.64645 18.6464C4.45118 18.8417 4.45118 19.1583 4.64645 19.3536C4.84171 19.5488 5.15829 19.5488 5.35355 19.3536L4.64645 18.6464ZM18.6464 4.64645L4.64645 18.6464L5.35355 19.3536L19.3536 5.35355L18.6464 4.64645Z"></path>
                                        </svg></button>
                                </div>
                                @endif
                                @endforeach
                                @else
                                <div class="add_field_item  bt_rwo_0">
                                    <input type="text" class="big_field bottom_custome_filed_key" placeholder="Field Name " value="">
                                    <input type="text" class="small_field bottom_to_custome_filed_value" placeholder="Value" value="">
                                    <button class="close_re_btn" type="button"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" color="#733dd9" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.35355 4.64645C5.15829 4.45118 4.84171 4.45118 4.64645 4.64645C4.45118 4.84171 4.45118 5.15829 4.64645 5.35355L5.35355 4.64645ZM18.6464 19.3536C18.8417 19.5488 19.1583 19.5488 19.3536 19.3536C19.5488 19.1583 19.5488 18.8417 19.3536 18.6464L18.6464 19.3536ZM4.64645 5.35355L18.6464 19.3536L19.3536 18.6464L5.35355 4.64645L4.64645 5.35355Z"></path>
                                            <path d="M19.3536 5.35355C19.5488 5.15829 19.5488 4.84171 19.3536 4.64645C19.1583 4.45118 18.8417 4.45118 18.6464 4.64645L19.3536 5.35355ZM4.64645 18.6464C4.45118 18.8417 4.45118 19.1583 4.64645 19.3536C4.84171 19.5488 5.15829 19.5488 5.35355 19.3536L4.64645 18.6464ZM18.6464 4.64645L4.64645 18.6464L5.35355 19.3536L19.3536 5.35355L18.6464 4.64645Z"></path>
                                        </svg></button>
                                </div>
                                @endif
                                <button class="show_field_extra btm_footer" type="button" onclick="addBottomCustomFields(this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16">
                                        <g id="plus-square-outline" transform="translate(-.266 .217)">
                                            <g id="Rectangle_1143" fill="rgba(255,255,255,0)" stroke="#006AFF" transform="translate(.266 -.217)">
                                                <rect width="16" height="16" stroke="none" rx="3"></rect>
                                                <rect width="15" height="15" x=".5" y=".5" fill="none" rx="2.5"></rect>
                                            </g>
                                            <g id="Group_588" transform="translate(5.264 4.783)">
                                                <path id="Line_109" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="translate(3)"></path>
                                                <path id="Line_110" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="rotate(90 1.5 4.5)"></path>
                                            </g>
                                        </g>
                                    </svg>
                                    Add More Fields
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="other_option">
                        <div class="row ro_space">
                            <div class="lside col-lg-8 flush">
                                <div class="btnGroups">
                                    <button class="showtcond" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                            <g id="plus-square-outline" transform="translate(-.266 .217)">
                                                <g id="Rectangle_1143" fill="rgba(255,255,255,0)" stroke="#006AFF" transform="translate(.266 -.217)">
                                                    <rect width="16" height="16" stroke="none" rx="3"></rect>
                                                    <rect width="15" height="15" x=".5" y=".5" fill="none" rx="2.5"></rect>
                                                </g>
                                                <g id="Group_588" transform="translate(5.264 4.783)">
                                                    <path id="Line_109" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="translate(3)"></path>
                                                    <path id="Line_110" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="rotate(90 1.5 4.5)"></path>
                                                </g>
                                            </g>
                                        </svg>
                                        <span class="">Add Terms &amp; Conditions</span>
                                    </button>
                                    <button class="showNote" type="button">
                                        <iconify-icon icon="material-symbols:sticky-note-2-rounded"></iconify-icon>
                                        <span class="">Add Notes</span>
                                    </button>
                                    <button class="showAttch" type="button">
                                        <iconify-icon icon="entypo:attachment"></iconify-icon>
                                        <span class="">Add Attachments</span>
                                    </button>
                                    <button class="showadinfo" type="button">
                                        <iconify-icon icon="material-symbols:sticky-note-2-rounded"></iconify-icon>
                                        <span class="">Add Additional Info</span>
                                    </button>
                                    <button class="showContactdetails" type="button">
                                        <iconify-icon icon="ic:round-call"></iconify-icon>
                                        <span class="">Add Contact Details</span>
                                    </button>
                                </div>
                            </div>
                            <div class="lside col-lg-4 flush text-right">
                                <button class="signBtn" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <g id="signature" transform="translate(2 4)">
                                            <g id="Group_1768" data-name="Group 1768" transform="translate(0 3.375)">
                                                <g id="Group_1764" data-name="Group 1764" transform="translate(7.5)">
                                                    <path id="Path_2116" d="M361.311 374.972l2.047 2.059-5.66 5.383a1.37 1.37 0 0 1-.831.385l-1.554.157a.3.3 0 0 1-.313-.337l.289-1.578a1.325 1.325 0 0 1 .422-.783l5.588-5.3z" class="cls-2" data-name="Path 2116" fill="#006AFF" transform="translate(-354.998 -373.382)"></path>
                                                    <path id="Path_2117" d="M363.308 376.179l-.3.289-2.048-2.068.373-.361a1.457 1.457 0 0 1 1.975 2.144z" class="cls-2" data-name="Path 2117" transform="translate(-353.78 -373.65)" fill="#733dd9"></path>
                                                </g>
                                                <path id="Line_311" fill="none" stroke="#006AFF" stroke-linecap="round" d="M4 0L0 0" data-name="Line 311" transform="translate(2 9.124)"></path>
                                            </g>
                                        </g>
                                    </svg>
                                    <span class="sc-bwzfXH kBmttp">Add Signature</span>
                                </button>
                                <div class="sign_box {{ !empty($savedInvloiceAllData['SaleInvoiceSetting']->signature_url) || !empty($savedInvloiceAllData['SaleInvoiceSetting']->signature_labed_name)  ? 'show' : '' }} ">
                                    <div class="sb_head">
                                        <h2>Signature</h2>
                                        <button class="close">
                                            <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
                                        </button>
                                    </div>
                                    <img id="default-image" src="{{ !empty($savedInvloiceAllData['SaleInvoiceSetting']->signature_url) ? $savedInvloiceAllData['SaleInvoiceSetting']->signature_url : '' }}" crossOrigin="anonymous" style="display: none;" />
                                    <canvas id="signature-pad" width="265" height="150"></canvas>
                                    <div class="btns">
                                        <span>
                                            <input type="file" id="upload-signature" class="signature_file_d" accept="image/png, image/jpeg">
                                            <button id="upload"><iconify-icon icon="fa-solid:upload"></iconify-icon> Upload Signature</button>
                                        </span>
                                    </div>

                                    <div class="show_imput_sig mt-1" style="<?= (!empty($savedInvloiceAllData['SaleInvoiceSetting']->signature_labed_name) ? 'display: block' : 'display: none') ?>">
                                        <div class="lable_set">
                                            <span class="">Add
                                                Signature Label</span>
                                            <button type="button" class=""><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" color="#006AFF" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5.35355 4.64645C5.15829 4.45118 4.84171 4.45118 4.64645 4.64645C4.45118 4.84171 4.45118 5.15829 4.64645 5.35355L5.35355 4.64645ZM18.6464 19.3536C18.8417 19.5488 19.1583 19.5488 19.3536 19.3536C19.5488 19.1583 19.5488 18.8417 19.3536 18.6464L18.6464 19.3536ZM4.64645 5.35355L18.6464 19.3536L19.3536 18.6464L5.35355 4.64645L4.64645 5.35355Z">
                                                    </path>
                                                    <path d="M19.3536 5.35355C19.5488 5.15829 19.5488 4.84171 19.3536 4.64645C19.1583 4.45118 18.8417 4.45118 18.6464 4.64645L19.3536 5.35355ZM4.64645 18.6464C4.45118 18.8417 4.45118 19.1583 4.64645 19.3536C4.84171 19.5488 5.15829 19.5488 5.35355 19.3536L4.64645 18.6464ZM18.6464 4.64645L4.64645 18.6464L5.35355 19.3536L19.3536 5.35355L18.6464 4.64645Z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="label_input">
                                            <input placeholder="Add you name" class="sigture_label_value" name="customLabels.signature" value="{{@$savedInvloiceAllData['SaleInvoiceSetting']->signature_labed_name}}">
                                        </div>
                                    </div>
                                    <div class="sig_label">
                                        <button class="" type="button" style="<?= (!empty($savedInvloiceAllData['SaleInvoiceSetting']->signature_labed_name) ? 'display: none' : '') ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                                <g id="plus-square-outline" transform="translate(-.266 .217)">
                                                    <g id="Rectangle_1143" fill="rgba(255,255,255,0)" stroke="#006AFF" transform="translate(.266 -.217)">
                                                        <rect width="16" height="16" stroke="none" rx="3">
                                                        </rect>
                                                        <rect width="15" height="15" x=".5" y=".5" fill="none" rx="2.5"></rect>
                                                    </g>
                                                    <g id="Group_588" transform="translate(5.264 4.783)">
                                                        <path id="Line_109" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="translate(3)"></path>
                                                        <path id="Line_110" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="rotate(90 1.5 4.5)"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                            <span class="">Add signature
                                                label</span></button>
                                    </div>

                                    <div class="btns mt-1">
                                        <button class="reset_signature" id="clear"><iconify-icon icon="system-uicons:reset"></iconify-icon> Reset</button>
                                        <button class="save_signature" id="save1"><iconify-icon icon="charm:tick"></iconify-icon> Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php $termconditions = json_decode($saleInvoice->terms_and_conditions);
                        $termsCount = (!empty($termconditions) ? count((array)$termconditions) : '');
                        @endphp
                        <div class="lside col-lg-12 flush">
                            <div class="t_c_card tcondition  {{!empty($termconditions)  ? '' : 'hide' }}">
                                <div class="tc_head  invoice_terms_and_conditions_div">
                                    <h3 class="editableText label_invoice_terms_and_conditions">{{ !empty($saleInvoice->label_invoice_terms_and_conditions) ? $saleInvoice->label_invoice_terms_and_conditions : 'Terms and Conditions'}} </h3>
                                    <button aria-label="Remove Group" class="close_b" type="button">
                                        <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
                                    </button>
                                </div>
                                <div class="tc_body terms_body mainTncTable">
                                    @if(!empty($termconditions))
                                    @foreach($termconditions as $key=>$termcondition)
                                    @if($termcondition != 'Write here..')
                                    <div class="item trm_rwo_{{$key}} tncWrapper" data-term_listing_index="{{$key}}">
                                        <span class="terms_and_conditions_note" data-term_listing_number="{{$key}}">{{$key+1}}.</span>
                                        <p class="editableText">{!! @$termcondition !!}</p>
                                        <button aria-label="Remove Term" class="close_icon" onclick="removedTermsConditonRow(this)" data-id="{{$key}}" type="button">
                                            <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
                                        </button>
                                        @if (($key == 0 && count((array)$termconditions) > 1) || (count((array)$termconditions)> $key + 1))
                                        <button shape="circle" aria-label="Move Down" title="Move Down" class="tnc_move_down_button show" data-tnc_move_down_index="{{$key}}" type="button">
                                            @else
                                            <button shape="circle" aria-label="Move Down" title="Move Down" class="tnc_move_down_button hide-d" data-tnc_move_down_index="{{$key}}" type="button">

                                                @endif
                                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="20" width="20" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M99.4 284.9l134 138.1c5.8 6 13.7 9 22.4 9h.4c8.7 0 16.6-3 22.4-9l134-138.1c12.5-12 12.5-31.3 0-43.2-12.5-11.9-32.7-11.9-45.2 0l-79.4 83v-214c0-16.9-14.3-30.6-32-30.6-18 0-32 13.7-32 30.6v214l-79.4-83c-12.5-11.9-32.7-11.9-45.2 0s-12.5 31.2 0 43.2z"></path>
                                                </svg>
                                            </button>
                                            @if($key != 0 && $key <= count((array)$termconditions)) <button shape="circle" aria-label="Move Up" title="Move Up" class="tnc_move_up_button show" data-tnc_move_up_index="{{$key}}" type="button">
                                                @else
                                                <button shape="circle" aria-label="Move Up" title="Move Up" class="tnc_move_up_button hide-d" data-tnc_move_up_index="{{$key}}" type="button">
                                                    @endif
                                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="20" width="20" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M412.6 227.1L278.6 89c-5.8-6-13.7-9-22.4-9h-.4c-8.7 0-16.6 3-22.4 9l-134 138.1c-12.5 12-12.5 31.3 0 43.2 12.5 11.9 32.7 11.9 45.2 0l79.4-83v214c0 16.9 14.3 30.6 32 30.6 18 0 32-13.7 32-30.6v-214l79.4 83c12.5 11.9 32.7 11.9 45.2 0s12.5-31.2 0-43.2z"></path>
                                                    </svg>
                                                </button>
                                    </div>
                                    @endif
                                    @endforeach
                                    @else
                                    <div class="item trm_rwo_0 tncWrapper" data-term_listing_index="0">
                                        <span class="terms_and_conditions_note" data-term_listing_number="0">{{!empty($termsCount) ? $termsCount : 1}}.</span>
                                        <p class="editableText">'Write here..'</p>
                                        <button aria-label="Remove Term" class="close_icon" type="button">
                                            <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
                                        </button>
                                        <button shape="circle" aria-label="Move Down" title="Move Down" class="down_icon hide-d tnc_move_down_button" data-tnc_move_down_index="0" type="button">
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="20" width="20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M99.4 284.9l134 138.1c5.8 6 13.7 9 22.4 9h.4c8.7 0 16.6-3 22.4-9l134-138.1c12.5-12 12.5-31.3 0-43.2-12.5-11.9-32.7-11.9-45.2 0l-79.4 83v-214c0-16.9-14.3-30.6-32-30.6-18 0-32 13.7-32 30.6v214l-79.4-83c-12.5-11.9-32.7-11.9-45.2 0s-12.5 31.2 0 43.2z"></path>
                                            </svg>
                                        </button>
                                        <button shape="circle" aria-label="Move Up" title="Move Up" class="down_icon hide-d tnc_move_up_button" data-tnc_move_up_index="0" type="button">
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="20" width="20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M412.6 227.1L278.6 89c-5.8-6-13.7-9-22.4-9h-.4c-8.7 0-16.6 3-22.4 9l-134 138.1c-12.5 12-12.5 31.3 0 43.2 12.5 11.9 32.7 11.9 45.2 0l79.4-83v214c0 16.9 14.3 30.6 32 30.6 18 0 32-13.7 32-30.6v-214l79.4 83c12.5 11.9 32.7 11.9 45.2 0s12.5-31.2 0-43.2z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    @endif
                                </div>
                                <div class="tc_footer">
                                    <button class="addnewline" type="button" onclick="appendTermsConditonRow(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                            <g id="plus-square-outline" transform="translate(-.266 .217)">
                                                <g id="Rectangle_1143" fill="rgba(255,255,255,0)" stroke="#006AFF" transform="translate(.266 -.217)">
                                                    <rect width="16" height="16" stroke="none" rx="3"></rect>
                                                    <rect width="15" height="15" x=".5" y=".5" fill="none" rx="2.5"></rect>
                                                </g>
                                                <g id="Group_588" transform="translate(5.264 4.783)">
                                                    <path id="Line_109" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="translate(3)"></path>
                                                    <path id="Line_110" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="rotate(90 1.5 4.5)"></path>
                                                </g>
                                            </g>
                                        </svg>
                                        Add New Term<span>&nbsp;&nbsp;</span>
                                    </button>
                                </div>
                            </div>
                            <div class="t_c_card addition_note {{ empty($saleInvoice->additional_notes) ? 'hide' :'' }}">
                                <div class="tc_head additional_notes_div">
                                    <h3 class="editableText additional_notes label_invoice_additional_notes"> {{ !empty($saleInvoice->label_invoice_additional_notes) ? $saleInvoice->label_invoice_additional_notes : 'Notes'}}</h3>
                                    <button aria-label="Remove Group" class="close_c" type="button">
                                        <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
                                    </button>
                                </div>
                                <div class="tc_body">
                                    <div id="editor3">{{@$saleInvoice->additional_notes}}</div>
                                </div>
                                <div class="tc_footer"></div>
                            </div>
                            <div class="t_c_card attech hide">
                                <div class="tc_head invoice_attachments_div">
                                    <h3 class="editableText label_invoice_attachments "> {{ !empty($saleInvoice->label_invoice_attachments) ? $saleInvoice->label_invoice_attachments : 'Attachments'}}</h3>
                                    <button aria-label="Remove Group" class="close_d" type="button">
                                        <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
                                    </button>
                                </div>
                                <div class="tc_body">
                                    <p>*Attachments can be viewed only via the link in shared invoice. Not via PDF.</p>
                                    <div class="dropzone dz-default dz-message" id="desktop_media"></div>
                                </div>
                                <!-- using two similar templates for simplicity in js code -->
                                <template id="file-template">
                                    <li class="block p-1 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-1/8 h-24">
                                        <article tabindex="0" class="group w-full h-full rounded-md focus:outline-none focus:shadow-outline elative bg-gray-100 cursor-pointer relative shadow-sm">
                                            <img alt="upload preview" class="img-preview hidden w-full h-full sticky object-cover rounded-md bg-fixed" />

                                            <section class="flex flex-col rounded-md text-xs break-words w-full h-full z-20 absolute top-0 py-2 px-3">
                                                <h1 class="flex-1 group-hover:text-blue-800"></h1>
                                                <div class="flex">
                                                    <span class="p-1 text-blue-800">
                                                        <i>
                                                            <svg class="fill-current w-4 h-4 ml-auto pt-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                                <path d="M15 2v5h5v15h-16v-20h11zm1-2h-14v24h20v-18l-6-6z" />
                                                            </svg>
                                                        </i>
                                                    </span>
                                                    <p class="p-1 size text-xs text-gray-700"></p>
                                                    <button class="delete ml-auto focus:outline-none hover:bg-gray-300 p-1 rounded-md text-gray-800">
                                                        <svg class="pointer-events-none fill-current w-4 h-4 ml-auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                            <path class="pointer-events-none" d="M3 6l3 18h12l3-18h-18zm19-4v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.316c0 .901.73 2 1.631 2h5.711z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </section>
                                        </article>
                                    </li>
                                </template>
                                <template id="image-template">
                                    <li class="block p-1 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-1/8 h-24">
                                        <article tabindex="0" class="group hasImage w-full h-full rounded-md focus:outline-none focus:shadow-outline bg-gray-100 cursor-pointer relative text-transparent hover:text-white shadow-sm">
                                            <img alt="upload preview" class="img-preview w-full h-full sticky object-cover rounded-md bg-fixed" />

                                            <section class="flex flex-col rounded-md text-xs break-words w-full h-full z-20 absolute top-0 py-2 px-3">
                                                <h1 class="flex-1"></h1>
                                                <div class="flex">
                                                    <span class="p-1">
                                                        <i>
                                                            <svg class="fill-current w-4 h-4 ml-auto pt-" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                                <path d="M5 8.5c0-.828.672-1.5 1.5-1.5s1.5.672 1.5 1.5c0 .829-.672 1.5-1.5 1.5s-1.5-.671-1.5-1.5zm9 .5l-2.519 4-2.481-1.96-4 5.96h14l-5-8zm8-4v14h-20v-14h20zm2-2h-24v18h24v-18z" />
                                                            </svg>
                                                        </i>
                                                    </span>

                                                    <p class="p-1 size text-xs"></p>
                                                    <button class="delete ml-auto focus:outline-none hover:bg-gray-300 p-1 rounded-md">
                                                        <svg class="pointer-events-none fill-current w-4 h-4 ml-auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                            <path class="pointer-events-none" d="M3 6l3 18h12l3-18h-18zm19-4v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.316c0 .901.73 2 1.631 2h5.711z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </section>
                                        </article>
                                    </li>
                                </template>
                            </div>
                            @php
                            $inv_contact_details = !empty($saleInvoice->contact_details) ? explode('-', $saleInvoice->contact_details) : [];
                            @endphp
                            <div class="t_c_card ycontactdetails {{ !$saleInvoice->is_contact_show ? 'hide' :'' }}">
                                <div class="tc_head">
                                    <h4>Your Contact Details</h4>
                                    <button aria-label="Remove Group" class="close_cdt" type="button">
                                        <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
                                    </button>
                                </div>
                                <div class="tc_body">
                                    <div class="align_tab">
                                        <input class="big contact_detail_text" type="text" value="{{ !empty($inv_contact_details[0]) ? @$inv_contact_details[0] : 'For any enquiry, reach out via' }}">
                                        <input type="text" class="contact_detail_email_at" name="" id="" value="{{ !empty($inv_contact_details[1]) ? @$inv_contact_details[1] : 'email at' }} ">
                                        <input class="big contact_detail_your_email" type="text" placeholder="Your email (optional)" value="{{ !empty($inv_contact_details[2]) ? @$inv_contact_details[2] : '' }} ">
                                        <input type="text" class="contact_detail_cell_no" name="" id="" value=" {{ !empty($inv_contact_details[3]) ? @$inv_contact_details[3] : 'call on' }}">
                                        <input class="big contact_detail_country_code" type="text" value=" {{ !empty($inv_contact_details[4]) ? @$inv_contact_details[4] : '+91' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="tc_footer"></div>
                        </div>
                    </div>
                    @php
                    $dynamic_additional_info = !empty($saleInvoice->add_additional_info) ? json_decode($saleInvoice->add_additional_info) : [];
                    $additionalInfoCount = !empty($dynamic_additional_info) ? count((array)$dynamic_additional_info) : '';
                    @endphp
                    <div class="row ro_space">
                        <div class="lside col-lg-8 flush">
                            <div class="add_additional_info additional_info_label_div_d add_additional_info_div_d {{!empty($dynamic_additional_info) ? 'show' :  '' }} ">
                                <h3 class="editableText additional_info_label"> {{ !empty($saleInvoice->additional_info_label) ? $saleInvoice->additional_info_label : 'Add Additional Info'}} </h3>

                                @if(!empty($dynamic_additional_info))
                                @foreach($dynamic_additional_info as $key=>$custome_filed)
                                @if(!empty($custome_filed->value))
                                <div class="item_info all addnal_rwo_{{$key}}">
                                    <input type="text" class="add_additional_info_key" name="" id="" value="{{@$custome_filed->key}}" placeholder="Field Name" />
                                    <input type="text" class="add_additional_info_value" name="" id="" value="{{@$custome_filed->value}}" placeholder="Value" />
                                    <button class="close" onclick="removeAdditionalInfo(this)" data-id="{{$key}}">
                                        <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
                                    </button>
                                </div>
                                @endif
                                @endforeach
                                @else
                                <div class="item_info all addnal_rwo_0">
                                    <input type="text" class="add_additional_info_key" name="" id="" placeholder="Field Name" />
                                    <input type="text" class="add_additional_info_value" name="" id="" placeholder="Value" />
                                    <button class="close" onclick="removeAdditionalInfo(this)" data-id="0">
                                        <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
                                    </button>
                                </div>
                                @endif
                                <button class="add_line add_more additional_footer " type="button" onclick="AppendAdditionalInfo(this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                        <g id="plus-square-outline" transform="translate(-.266 .217)">
                                            <g id="Rectangle_1143" fill="rgba(255,255,255,0)" stroke="#000" transform="translate(.266 -.217)">
                                                <rect width="16" height="16" stroke="none" rx="3"></rect>
                                                <rect width="15" height="15" x=".5" y=".5" fill="none" rx="2.5"></rect>
                                            </g>
                                            <g id="Group_588" transform="translate(5.264 4.783)">
                                                <path id="Line_109" d="M0 0L0 6" stroke="#000" fill="none" stroke-linecap="round" transform="translate(3)"></path>
                                                <path id="Line_110" d="M0 0L0 6" stroke="#000" fill="none" stroke-linecap="round" transform="rotate(90 1.5 4.5)"></path>
                                            </g>
                                        </g>
                                    </svg>
                                    Add More Fields
                                </button>
                            </div>
                            <div class="advance_box">
                                <div class="box_inn">
                                    <span class="sc-dxgOiQ hNCAFA">Advance Options</span>
                                    <div class="select-full">
                                        <h6>Select HSN Column View</h6>
                                        <select class="js-example-placeholder-single-default js-states hsn_column_view">
                                            <option value="0" selected>Default</option>
                                            <option value="1" {{ $saleInvoice->hsn_column_view==1 ? 'selected' : '' }}>Merge</option>
                                            <option value="2" {{ $saleInvoice->hsn_column_view!=1 ? 'selected' : '' }}>Split</option>
                                        </select>
                                    </div>
                                    <div class="sd_check">
                                        <input type="checkbox" class="show_hsn_summary" value="1" name="show_hsn_summary" id="adop2" {{ $saleInvoice->show_hsn_summary==1 ? 'checked' : '' }} />
                                        <label class="pull-right text" for="adop2">Show HSN Summary In Invoice</label>
                                    </div>
                                    <div class="sd_check">
                                        <input type="checkbox" class="add_original_images" value="1" name="add_original_images" id="adop3" {{ $saleInvoice->add_original_images==1 ? 'checked' : '' }} />
                                        <label class="pull-right text" for="adop3">Add Original Images in Line Items</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="error_div">
                        </ul>
                        <div class="rside col-lg-4 flush"></div>
                    </div>
                    <div class="advance_option"></div>
                    <input type="hidden" class="is_terms_req" value=" {{ !empty($saleInvoice->is_terms_req) ? 1 : 0 }}">
                    <input type="hidden" class="is_additional_notes_req" value="{{ !empty($saleInvoice->is_additional_notes_req) ? 1 : 0 }}">
                    <input type="hidden" class="is_attactments_req" value="{{ !empty($saleInvoice->is_attactments_req) ? 1 : 0 }}">
                    <input type="hidden" class="is_additional_info_req" value="{{ !empty($saleInvoice->is_additional_info_req) ? 1 : 0 }}">
                    <input type="hidden" class="is_contact_show" value="{{ !empty($saleInvoice->is_contact_show) ? 1 : 0 }}">

                    <input type="hidden" class="db_invoice_id" value="<?= !empty($invoice_id) ? $invoice_id : '' ?>" />
                    <div class="page_button">
                        <a href="javascript:void(0)"><button type="button" onclick="SaveEntity(this)" class="">Save &amp; Continue</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modals')
@include('allFrontendViews.invoice.modals.bill_by_edit_popup')
@include('allFrontendViews.invoice.modals.create_new_client')
@include('allFrontendViews.invoice.modals.create_new_company')
@include('allFrontendViews.invoice.modals.bill_to_edit_popup')
@include('allFrontendViews.invoice.modals.change_gst_popup')
@include('allFrontendViews.invoice.modals.change_number_formate')
@include('allFrontendViews.invoice.modals.due_date_popup')
@include('allFrontendViews.invoice.modals.edit_column_popup')
@include('allFrontendViews.invoice.modals.cropper')
@endsection
@push('custom-scripts')

<script src="{{asset('unsync_assets/assets/js/app.js')}}"></script>
<script src="{{asset('unsync_assets/assets/js/main.js')}}"></script>
<script src="{{asset('unsync_assets/assets/js/tiny-autocomplete.js')}}"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/47585/slip.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script> -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/autosize.js/4.0.2/autosize.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

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
<script src="{{asset('assets/inwords/inword.js')}}"></script>
<script>
    var enyptID = "<?= $enypt_id; ?>";
    var inv_due_days = "<?= (!empty($savedInvloiceAllData['SaleInvoiceSetting']->due_days) ? @$savedInvloiceAllData['SaleInvoiceSetting']->due_days : '') ?>";

    var suggestions = <?= json_encode($commonData['allProducts']); ?>;
    var state_list = <?= json_encode($commonData['stateList']) ?>;
    var sale_attachments_data = <?= json_encode($savedInvloiceAllData['SaleInvoiceAttachments_data']) ?>;
    var is_inv_duplicate = "<?= $is_inv_duplicate ?>";


    // ..With Edit mode values 
    var is_invoice_edit = "<?= $is_invoice_edit ?>";
    var tkey = <?= !empty($total_top_tkey) ? $total_top_tkey : 0  ?>;
    var shpkey = <?= !empty($total_shipping_tkey) ? $total_shipping_tkey : 0  ?>;
    var trmey = <?= !empty($termsCount) ? $termsCount  : 1  ?>;
    var adkey = <?= !empty($additionalInfoCount) ? $additionalInfoCount : 0  ?>;
    var btmkey = <?= !empty($finalDyanmiRowsCount) ? $finalDyanmiRowsCount : 0  ?>;
    var extrakey = <?= !empty($finalExtraRowsCount) ? $finalExtraRowsCount : 0  ?>;

</script>

<script src="{{asset('js/custom/invoice.js')}}"></script>
<script src="{{asset('unsync_assets/assets/js/signature.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/plugins/dropzone/dropzone.min.js')}}"></script>
<script>
    function getProductDbMedia(main_index) {

        var formData = new FormData();
        formData.append('invoice_id', $('.db_invoice_id').val());
        formData.append('row_index_id', main_index);

        $.ajax({
            url: APP_URL + '/api/SaleInvoiceGetMedia',
            data: formData,
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(xhr) {
                block_gui_start();
                xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
            },
            success: function(response) {
                block_gui_end();
                if (response.status == true) {
                    console.log('media resp ', response?.data);
                    if (response?.data?.length > 0) {
                        var imgeditWrap = $(".table_media_input_" + main_index).closest('.upload__box').find('.upload__img-wrap');
                        var medialist = response?.data;
                        for (var i = 0; i <= medialist.length; i++) {
                            if (medialist[i]?.invoice_product_image != '' && medialist[i]?.invoice_product_image != undefined) {
                                var html = "<div class='upload__img-box'><div style='background-image: url(" + medialist[i]?.invoice_product_image + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + medialist[i]?.invoice_product_image + "' class='img-bg'><div class='upload__img-close remove_tbl_media-onclose' data-mid='" + medialist[i]?.id + "' ></div></div></div>";
                                imgeditWrap.append(html);
                            }
                        }
                        $(".shw_uodr_" + main_index).addClass("show");
                        $(".shw_thumbnail_btn_" + main_index).hide();

                    }
                } else {
                    toastr.error(response?.message)
                }

            },
            error: function(response) {
                block_gui_end();
                console.log("server side error");
            }
        })
    }
</script>
<!-- DatePicker -->
<script>
    $(function() {

        $(".datepicker").datepicker({
            dateFormat: "dd-mm-yy",
            // duration: "fast",
        }).datepicker("setDate", !is_invoice_edit ? 'now' : $(".invoice_date").val());

        $(".datepicker2").datepicker({
            dateFormat: "dd-mm-yy",
            duration: "fast",
        }).datepicker("setDate", !is_invoice_edit ? 'now' : $(".due_date").val());

        $(".datepicker3").datepicker({
            dateFormat: "dd-mm-yy",
            duration: "fast",
        }).datepicker("setDate", !is_invoice_edit ? 'now' : $(".challan_date").val());

        $(".datepicker-button").on("click", function() {
            $(".datepicker").datepicker("show");
        });
        $(".datepicker-button2").on("click", function() {
            $(".datepicker2").datepicker("show");
        });
        $(".datepicker-button3").on("click", function() {
            $(".datepicker3").datepicker("show");
        });

        if (inv_due_days != '' && inv_due_days != undefined) {
            var days = inv_due_days;
            var date2 = $('.datepicker').datepicker('getDate', '+1d');
            date2.setDate(date2.getDate() + parseInt(days));
            $('.datepicker2').datepicker('setDate', date2);
        }

    });
</script>
<script>
    // Show Item Signature Label
    $(".sig_label button").click(function(e) {
        $('.show_imput_sig').show();
        $('.sig_label button').hide();
    });
    $(".lable_set button").click(function(e) {
        $('.show_imput_sig').hide();
        $('.sig_label button').show();
    });
</script>
<script>
    document.getElementById('upload').addEventListener('click', function() {
        document.getElementById('upload-signature').click();
    });


    document.getElementById('save1').addEventListener('click', function() {
        var signatureCanvas = document.getElementById('signature-pad');
        var signatureData = signatureCanvas.toDataURL();

        var imageFileInput = document.getElementById('upload-image');

        var imageFile = '';
        if (imageFileInput?.files[0])
            imageFile = imageFileInput?.files[0];

        if (signatureData && !imageFile) {
            // Only signature data is available
            var signatureBlob = dataURItoBlob(signatureData);

            // Call the callback function here
            saveCallback(signatureBlob, null);
        } else if (!signatureData && imageFile) {
            // Only image file is available
            var imageReader = new FileReader();
            imageReader.onload = function(e) {
                var imageData = e.target.result;

                // Call the callback function here
                saveCallback(null, imageData);
            };
            imageReader.readAsDataURL(imageFile);
        } else {
            // Both signature and image are available
            var signatureReader = new FileReader();
            signatureReader.onload = function(e) {
                var signatureBlob = dataURItoBlob(e.target.result);

                var imageReader = new FileReader();
                imageReader.onload = function(e) {
                    var imageData = e.target.result;

                    // Call the callback function here
                    saveCallback(signatureBlob, imageData);
                };
                imageReader.readAsDataURL(imageFile);
            };
            signatureReader.readAsDataURL(signatureBlob);
        }
    });

    function saveCallback(signatureBlob, imageData) {
        // Add your code here
        // This function will be called when either signature or image is ready for upload
        console.log('Save button clicked!');

        if (signatureBlob) {
            // Perform AJAX call to upload the signatureBlob to the server
            var signatureFormData = new FormData();
            signatureFormData.append('signature_url', signatureBlob);
            signatureFormData.append('signature_labed_name', $(".sigture_label_value").val());


            var signatureXHR = new XMLHttpRequest();
            signatureXHR.open('POST', APP_URL + '/api/SaleInvoiceAddSetting', true);
            signatureXHR.setRequestHeader('Authorization', 'Bearer ' + tokenString);
            signatureXHR.onreadystatechange = function() {
                if (signatureXHR.readyState === XMLHttpRequest.DONE) {
                    if (signatureXHR.status === 200) {
                        toastr.success("Saved successfully.");
                        // Handle the response from the server if needed
                    } else {
                        console.log('Signature upload failed!');
                        // Handle the error case if needed
                    }
                }
            };
            signatureXHR.send(signatureFormData);
        }

        if (imageData) {
            // Perform AJAX call to upload the imageData to the server
            var imageFormData = new FormData();
            imageFormData.append('signature_url', imageData);
            imageFormData.append('signature_labed_name', $(".sigture_label_value").val());


            var imageXHR = new XMLHttpRequest();
            imageXHR.open('POST', APP_URL + '/api/SaleInvoiceAddSetting', true);
            signatureXHR.setRequestHeader('Authorization', 'Bearer ' + tokenString);
            imageXHR.onreadystatechange = function() {
                if (imageXHR.readyState === XMLHttpRequest.DONE) {
                    if (imageXHR.status === 200) {
                        toastr.success("Saved successfully.");
                        // Handle the response from the server if needed
                    } else {
                        console.log('Image upload failed!');
                        // Handle the error case if needed
                    }
                }
            };
            imageXHR.send(imageFormData);
        }
    }

    function dataURItoBlob(dataURI) {
        var byteString = atob(dataURI.split(',')[1]);
        var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
        var ab = new ArrayBuffer(byteString.length);
        var ia = new Uint8Array(ab);

        for (var i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }

        return new Blob([ab], {
            type: mimeString
        });
    }

    document.getElementById('upload-signature').addEventListener('change', function(e) {
        var file = e.target.files[0];

        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var signatureData = e.target.result;
                var canvas = document.getElementById('signature-pad');
                var context = canvas.getContext('2d');

                var signatureImage = new Image();
                signatureImage.onload = function() {
                    context.clearRect(0, 0, canvas.width, canvas.height);
                    context.drawImage(signatureImage, 0, 0, canvas.width, canvas.height);
                    imageModified = true;
                    signatureModified = false;
                };
                signatureImage.src = signatureData;
            };
            // signatureUploadCallback(signatureData);
            reader.readAsDataURL(file);
        }
    });

    function signatureUploadCallback(signatureData) {
        // Add your code here
        // This function will be called when the signature upload is complete
        console.log('Signature upload complete!');
        // Perform AJAX call to upload the image to the server
        var xhr = new XMLHttpRequest();
        xhr.open('POST', APP_URL + '/api/SaleInvoiceAddSetting', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log('Image upload successful!');
                    // Handle the response from the server if needed
                } else {
                    console.log('Image upload failed!');
                    // Handle the error case if needed
                }
            }
        };
        xhr.send(JSON.stringify({
            signature_url: signatureData
        }));
    }

    var signatureModified = false;
    var imageModified = false;

    document.addEventListener('DOMContentLoaded', function() {
        var defaultImage = document.getElementById('default-image');
        var signatureCanvas = document.getElementById('signature-pad');
        var context = signatureCanvas.getContext('2d');

        var signatureImage = new Image();
        signatureImage.onload = function() {
            if (!signatureModified && !imageModified) {
                context.clearRect(0, 0, signatureCanvas.width, signatureCanvas.height);
                context.drawImage(signatureImage, 0, 0, signatureCanvas.width, signatureCanvas.height);
            }
        };
        signatureImage.src = defaultImage.src;
        defaultImage.style.display = 'none';
    });

    document.getElementById('clear').addEventListener('click', function() {
        var canvas = document.getElementById('signature-pad');
        var context = canvas.getContext('2d');
        context.clearRect(0, 0, canvas.width, canvas.height);
        var defaultImage = document.getElementById('default-image');
        var signatureImage = new Image();
        signatureImage.onload = function() {
            if (!signatureModified && !imageModified) {
                context.drawImage(signatureImage, 0, 0, signatureCanvas.width, signatureCanvas.height);
            }
        };
        signatureImage.src = defaultImage.src;

        // Reset the modification flags
        signatureModified = false;
        imageModified = false;
    });
</script>
<!-- H2 Editable Text Script -->
<script>
    $(document).ready(function() {
        initializeEditabeEditor();
    });
    // Add a class "editableText" to all the elements you want to make editable
    function initializeEditabeEditor() {
        // Add a class "editableText" to all the elements you want to make editable
        var editableTextElements = document.querySelectorAll(".editableText");

        // Add the event listeners to all the elements
        editableTextElements.forEach(function(editableTextElement) {
            editableTextElement.addEventListener("click", function(event) {
                if (editableTextElement.getElementsByTagName("input").length > 0) {
                    return; // Exit if an input field already exists
                }

                editableTextElement.className = "small_size";
                var input = document.createElement("input");
                input.value = editableTextElement.innerHTML;
                editableTextElement.innerHTML = "";
                editableTextElement.appendChild(input);
                input.focus();
                event.stopPropagation();

                input.addEventListener("blur", function() {
                    editableTextElement.innerHTML = input.value;
                    editableTextElement.className = "big_size";
                });
            });
        });

        document.addEventListener("click", function() {
            editableTextElements.forEach(function(editableTextElement) {
                editableTextElement.className = "big_size";
            });
        });
    }
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

    $(".js-example-placeholder-single-currency").select2({
        // placeholder: "Select Country",
    });
    $(".js-example-placeholder-single-country2").select2({
        placeholder: "Select Country",
    });
    $(".js-example-placeholder-single-state2").select2({
        placeholder: "Select State",
    });
</script>
<script>
    // Company with Button
    $(".js-example-placeholder-single-brand").select2().data("select2").$dropdown.addClass("my-container");

    var $customDiv = $('<div class="inner_box"><button id="custom-button" class="show_new_business_popup" ><iconify-icon icon="pajamas:plus"></iconify-icon> Create New Company</button></div>');

    // Bind the "select2:open" event to the select2 element
    $(".js-example-placeholder-single-brand").on("select2:open", function() {
        // Append the custom div to the select2-dropdown element
        $(".my-container .select2-dropdown").append($customDiv);
        $customDiv.find("#custom-button").click(function() {
            // Programmatically close the dropdown
            $(".js-example-placeholder-single-brand").select2("close");
            $("#createnewcompany").modal("show");
        });
    });
</script>
<script>
    // Client with Button
    $(".js-example-placeholder-single-client").select2().data("select2").$dropdown.addClass("my-container1");

    var $customDiv1 = $('<div class="inner_box"><button id="custom-button" class="show_new_client_popup" ><iconify-icon icon="pajamas:plus"></iconify-icon> Add New Client</button></div>');

    // Bind the "select2:open" event to the select2 element
    $(".js-example-placeholder-single-client").on("select2:open", function() {
        // Append the custom div to the select2-dropdown element
        $(".my-container1 .select2-dropdown").append($customDiv1);
        $customDiv1.find("#custom-button").click(function() {
            // Programmatically close the dropdown
            $(".js-example-placeholder-single-client").select2("close");
            $("#createnewclient").modal("show");
        });
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
    // $(".js-example-placeholder-single-taxtype").select2().data("select2").$dropdown.addClass("my-container3");

    $(".js-example-placeholder-single-taxtype").select2({
        placeholder: "Client Industry",
    });
    // var $customDiv3 = $('<div class="inner_box"><button id="custom-button"><iconify-icon icon="pajamas:plus"></iconify-icon> Create New Tax</button></div>');

    // Bind the "select2:open" event to the select2 element
    // $(".js-example-placeholder-single-taxtype").on("select2:open", function() {
    // $(".my-container3 .select2-dropdown").append($customDiv3);
    // });
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
        $(".discount_on_total").val(0);
        calculateInvoiceTotal();
        $('.hide_discount_item').toggleClass('show');
        $('button.giwd').show();
    });

    var discountShowed = false;
    var CGSTShowed = false;
    // Show Item Wise Discount
    $("body").on("click", ".add_discount", function(e) {
        var indx_key = $(this).attr("data-key");
        $('.inline_disc_div_' + indx_key).toggleClass('show');
        $(".discount_th").removeClass("hide-d");
        $(".inline_disc_td").removeClass("hide-d");
        $(".inpt_inline_disc_0").attr("data-show-disc", 'yes');

        var template_columns = $(".items_view_edit_table").attr("data-grid-template-columns");
        if (typeof(template_columns) != "undefined" && !discountShowed) {
            template_columns = parseInt(template_columns) + 2;
            $(".items_view_edit_table").attr("data-grid-template-columns", template_columns);
            $(".items_view_edit_table").css({
                "grid-template-columns": "repeat(" + template_columns + ", 1fr)"
            });
            $("#loadColumnOnPage").css({
                "grid-template-columns": "repeat(" + template_columns + ", 1fr)"
            });
        }

        discountShowed = true;
        $(this).hide();
    });
    $(".hide_discount button.close_btn").click(function(e) {
        var indx_key = $(this).attr("data-id");
        $('.inline_disc_div_' + indx_key).toggleClass('show');
        $(this).show();
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
        $(".extra_changes").val(0);
        calculateInvoiceTotal();
        $('.hide_addcharges_item').toggleClass('show');
    });

    // Show Round On
    $("button.show_round_on").click(function(e) {
        var amot = ($("#finalGrandTotal").text());
        var totalAMt = parseFloat(amot.toString().split(".")[1]);

        if (totalAMt.toString().length == 1)
            totalAMt = totalAMt + '0';

        totalAMt = parseFloat(100) - parseFloat(totalAMt);
        $(".round_up_d").val('0.' + totalAMt);

        $('.show_round_off').addClass('hide-d');
        $('.round_on_hide').toggleClass('show');
        $('.round_on_hide').attr('data-show', 'yes');
        $('.round_off_hide').attr('data-show', 'no');


        var totl = Math.ceil(amot);
        $("#finalGrandTotal").html(totl.toFixed(2));
    });


    //close up
    $(".round_on_hide button.close_btn").click(function(e) {

        $('.round_on_hide').toggleClass('show');
        $('.round_on_hide').attr('data-show', 'no');
        $(".round_up_d").val('0');

        $('.show_round_on').removeClass('hide-d');
        $('.show_round_off').removeClass('hide-d');

        calculateInvoiceTotal();
        // $("#finalGrandTotal").html(amot);
    });

    // Show Round Off
    $("button.show_round_off").click(function(e) {
        var amot = ($("#finalGrandTotal").text());
        var totalAMt = parseFloat(amot.toString().split(".")[1]);
        if (totalAMt.length == 1)
            totalAMt + '0';

        $(".round_down_d").val('0.' + totalAMt);

        $('.round_off_hide').toggleClass('show');
        $('.round_off_hide').attr('data-show', 'yes');
        $('.round_on_hide').attr('data-show', 'no');

        $('.show_round_on').addClass('hide-d');

        var totl = Math.floor(amot);
        $("#finalGrandTotal").html(totl.toFixed(2));
    });
    // close down
    $(".round_off_hide button.close_btn").click(function(e) {
        $('.round_off_hide').toggleClass('show');
        $('.round_off_hide').attr('data-show', 'no');
        $(".round_down_d").val('0');

        $('.show_round_on').removeClass('hide-d');
        $('.show_round_off').removeClass('hide-d');

        calculateInvoiceTotal();
        // $("#finalGrandTotal").html(amot);
    });

    function clear() {
        $("#errSpan").hide();
        $("#resultDiv").hide();
    }
    // Show Item Wise Discount
    $("button.show_total").click(function(e) {
        numberToWordsWithDecimal();
        $(".is_totalInwordshow").val('1')
        $('.hidden_total').toggleClass('show');
        $('button.show_total').hide();
    });
    $(".total-col button.close_btn").click(function(e) {
        $(".is_totalInwordshow").val('0')
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
        $(".is_contact_show").val('1')
        $('.ycontactdetails').removeClass('hide');
    });
    $(".ycontactdetails button.close_cdt").click(function(e) {
        $(".is_contact_show").val('0')
        $('.ycontactdetails').addClass('hide');
    });

    // Hide UnHide
    $(document).on('click', '.action_btns button.hide', function() {

        var $this = $(this);
        defaultJson[$(this).data('index')].hide = '1';
        $("[data-popup_column_index='" + $(this).data('index') + "']").addClass('hide-d');

        $("[data-action_btns_index='" + $(this).data('index') + "'] button.unhide").addClass('show');
        $("[data-action_btns_index='" + $(this).data('index') + "'] button.hide").removeClass('show');
    });

    $(document).on('click', '.action_btns button.unhide', function() {

        var $this = $(this);
        defaultJson[$(this).data('index')].hide = '0';

        $("[data-popup_column_index='" + $(this).data('index') + "']").removeClass('hide-d');
        $("[data-action_btns_index='" + $(this).data('index') + "'] button.hide").addClass('show');
        $("[data-action_btns_index='" + $(this).data('index') + "'] button.unhide").removeClass('show');
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
        $('.openDescription_row').hide();
    });

    $("button.openthumbnails").click(function(e) {
        $('.hide_option_imageOnly').addClass('show');
        $('button.openthumbnails').hide();
    });
</script>



<script>
    var ul = document.getElementById('slippylist');

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

    ul.addEventListener('slip:reorder', function(e) {
        const movedItem = defaultJson[event.detail.originalIndex];
        defaultJson.splice(event.detail.originalIndex, 1); // Remove item from the previous position
        defaultJson.splice(event.detail.spliceIndex, 0, movedItem); // Insert item in the new position
        listColumnsInPopUp(); //Change list column position in popup
        loadDefaultColumns();

        e.target.parentNode.insertBefore(e.target, e.detail.insertBefore);
        return false;
    }, false);

    new Slip(ul);
</script>



<script>
    // var editor = new toastui.Editor({
    //     el: document.querySelector('#editor1'),
    //     initialEditType: 'wysiwyg'
    // });
    var editor = new toastui.Editor({
        el: document.querySelector('#editor3'),
        initialEditType: 'wysiwyg'
    });

    function initializeEditor(ckID) {
        if ($("#" + ckID).length) {
            var editor = new toastui.Editor({
                el: document.querySelector("#" + ckID),
                initialEditType: 'wysiwyg'
            });
        }
    }
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
                maxFiles: 30,
                paramName: name,
                addRemoveLinks: true,
                removedfile: function(file) {
                    file.previewElement.remove();
                },
                // ..
                // init: function() {
                //     // sale_attachments_data
                //     var thisDropzone = this;
                //     Dropzone.autoDiscover = false;
                //     for(var i=0; i<= sale_attachments_data.length; i++){
                //         console.log('attacments1', sale_attachments_data[i]?.invoice_attachments);

                //         if(sale_attachments_data[i]?.invoice_attachments!= '' && sale_attachments_data[i]?.invoice_attachments!= undefined && !isNaN(sale_attachments_data[i]?.invoice_attachments)){
                //             console.log('attacments2', sale_attachments_data[i]?.invoice_attachments);
                //         var stored_file = sale_attachments_data[i]?.invoice_attachments;
                //         var stored_file_name = sale_attachments_data[i]?.invoice_attachments_name;
                //     var mockFile = {
                //         name: stored_file_name,
                //         size: 12345,
                //         type: 'image/jpeg'
                //     };
                //     thisDropzone.files.push(mockFile);
                //     thisDropzone.emit("addedfile", mockFile);
                //     thisDropzone.emit("success", mockFile);
                //     thisDropzone.emit("thumbnail", stored_file);
                //     // thisDropzone.emit("thumbnail", mockFile, "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBwgHBgkIBwgKCgkLDRYPDQwMDRsUFRAWIB0iIiAdHx8kKDQsJCYxJx8fLT0tMTU3Ojo6Iys/RD84QzQ5OjcBCgoKDQwNGg8PGjclHyU3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3N//AABEIAKYA9QMBIgACEQEDEQH/xAAbAAACAwEBAQAAAAAAAAAAAAADBAACBQEGB//EAEEQAAEEAQIDBQYDBQUIAwAAAAEAAgMRBBIhMUFRBRMiYXEGFDJCgZFUkqFSscHR8BUjNGLxJDNDRFNyguEHFyX/xAAaAQADAQEBAQAAAAAAAAAAAAAAAQIDBAUG/8QAJxEAAgICAQUAAgEFAAAAAAAAAAECEQMSIQQTMUFRFCIyBSNCUmH/2gAMAwEAAhEDEQA/APkgh1SaeqZbAYTqe/SXcr/ggtt3hJro4IgNeGXj91qzqgolzGDt4XfohPxQQaa6+q7IwtedLiESGcR0JLPnSXJVRk6kIPhfG7gV0FxFFakjoZAC2ej0ek3wEklrgfMJp2ZTxa/xKQDunixaI2NpeWgVuqNLuBXTuKpWJcIZ7tsDQ7U1x/ZHJLZLCHk8QeaNE3SKcTXkVeSJrgCJARfCxspNHHZcGX1Cfx4jPCa4sFob4ABbQdkxiT+7ObIBZHEHmEzOEalUgWvubsbHgh2XjUeIRcxzJXaowQw8L5K0EW0lcgmNx5pBcPxbdQhzQaC7bkjwxEubG3i4ghHnilbI7WNyKN8lPhm+m0DOk0Phb4vFppCYivbfwoIHiIOypHPLyGkbbNSWl4hOR+KMjoEJ8e1oCStWK8EaIar9ENzaKNHsxUjJLkG5tFcqwVZ25UA2TEBA8SrXipFIVooy47DfggXsjG6AhnxlNSROYLk49EH6UL2SBqnQ3gxdz3bz4adqtBy5u8Dz+0UTv/A8DcAU3zKXLfApo2c/11QFrC7ioul5GwUQZ8F2NffibqKsKL926fqixNMmwDbrddMYHFI3UXVljFXhNX1tXijb8L9wqxk2NW6bEemiRskzWEbFZIgw23Yeao550kcvJNz6DVFcMLJADdHoiweNv+IpFFrBq7RI8ZzngJmKAxEq4kIcC1u4RY1iXs7JHE2EVRddJJ0ThI7a23stFkVvt+wdxCbbDE3iBpPA9EbG3a7n/DFaS4mMtBdVWVR8Lhte6dyodRJjAtp+pCvFH4Q57aF1dJ2ZdpvgVwsXU+3cuaPls0vaYSbbs8VzTM72RwN7r475DklcfW6Sn7gnghFaqK1R3EJdOyR4+DezyTeY8TOcQ0absjq7qi5+OyKGCKAWx51uf59FXGax7C0jxc1HHk6IwcbxmZJGC/UNh0QZYauWtjsncxn96Q3YBXaG+6Oa4bgqrpWc7xbScTObbW7c0QMJh4bosmP3W93fJWafAW1uqM1GuGZcwpyudowrTMJk4IchN0FSOWSpsqwapKV5KDq6LsTa8S48WbTJrgGRavG8R7891UilUpkhHyuk3duuxN+Z3CihDgjNNNb6HZIpc+SkY1PO9fwRHBrxsaHAFdiZWm96YSQrQx94HNaPC0WFLZrGIN/cA7qJeb4l1QDsZhkLAKpFD74hK1Z3JV2u4eaqhxn6HDCW0SKvcLrn0KPJcbIDE1ukgAVxtDlurSOhySVoLGNZR4QACHbJSCUMfZBPojt8ZIbxSaKhJPn2Oxd3IwixYCXDCJOm6kbSH1fJOQsErwHEX6qLOrXdIG5ocBpG6FT3M0GxW9pqWJ0MergLpEiiD4i9xvbYjgU0y3jbdIBjwB4DrAdzR89rXRw90aYDTh5oGiWA2LcPTgmoQ19h1Bp3vzSf0qCVa0JNaH20HS5v6pUExynnZW0YO6LSa8WwA3SrGsfLQaLvYlOMjPJ09UvZfBDpmPhc63XbLRG4wbI4ubQ5qkodjy8NQri3g1NQ5DchjCd3s6c1LZvjS/jLyIvii3bZLj81IP8AhJzbDIwjewjQvbFl91JwN6T0WhLH3jnvAa5rBvR4+ip/qZKCnyvJhTNAkBDvP6dFx8el+p3PgiZUYZINPC9rXJQAA17hpHNUvByuNN2L5DGt3PHySrYO8la0DinJA3doNhN+z2OJ82TUAQxpVOWsWzOOHu5VD6I9oY4gnLG8KCTo3QWv2u3/AGgg8bSLIC80DXmiErjZHUYtcjiheSLSAeRQXtTuY+6Y02GirSrWW6las5ZxS8FGsJF0iRtN7jYBXvSKAXWyA6WHa+JQxJegmLH3uvhpFWfJUe/RIXN23OyZpsDHaAWh4q+azJXaiTZ3KzfLOiUu3GvYOU6nWFFUqJ0czk2MNBJTEMJlHg3LdyELQ2gWm0Qa4y1zbBHRUaxDs7rQ2mWD+iNNgyOjL4Q5wZ8QrghudrIdQB6dUV+bZGkaHkU7c0fNS0zpjKNUxAgh1OBB6FMMeWHUEw9kOTG0s2fW5G6U7ow7ucb8haZNOPKG2zBw1A04I0DXOIkb133Wc2fSCC36p7ElZpq+PVS4cG2LKnI0sipcctfYkHJKY0zooXRg6m/slXMg0neyeKXAIdr173tQUxjwdOTLck4mzDIJYWB0YjrauiWyS5pcYn3tXmlJc+QNLXniOIV8DMuUF2l17Ovmp0a5NfyITqPsdwJzKzQ4DUPhJKWi1RZ7muHh+ZarYY5AWwFrm3YDfiCQzoXMyGyMH25qIvmjbJjloqfgZazHkkIL+LaDVPdDDUkYJOxG5IpWxxExrJpcdwlvY3Qr+CMcl3dubjxudxquHopextHRr9vJi57TDkNfQPFM4cGtnvAm3GwYEXLEM8RcAXOHynkj4zgIB3mPpYTs5gJ/eVpKTcDlhBd534MbMZTi5wqvhSlOeQOd8wtztDDe4FzAdHyrO92cwNMli+SFJUY5unkpFHYzixzzXDqmPZoGPNeXEAPjK44taNGk781bDjEWXGQ7YcU5u4NBhhrnjKPoF2kzXmOpLSE40ThQ8dLWyYA7Lf0HErPzIOIcCOlpwf6pEdTjbnKZj3ZpFhZR3Xe7DbPREDgBwWzdI82GO3bKOYChuYxrST8XLyVidkJ1kqE7NJRS5JNKZLHLklnBHLaCoQr4OedvyCIUXaUSJ1CNBHBEa53PdX7sqwjKtGiTI1wv1Vnu1NogLoj8lYRFBXIGIujeHNJB8kZzy52qqK73R6K3clOkCtAizUbPFQ2NgjCJw5LvclFhTBxyOa4OJNhMOnY7ciieYQ+68l3RXL7JcFJyRaZlw7G0BhLK1Gt002i0MHVAysiGA6ZZ9P8AkBtK0Of008SaV+0UoYBva3opI8rFeZwyJzfmrj6Lw8fa0EMgdT3V0CbPtREXMY2GRrOZsX9lhkps7MHWaRpmlmzyxhzAba472bQMPtCXHcGOLtHHZZEnbcT3bxykddt/1Vf7Txi75w3m6uCtOFHPLqpb7RZs5WSwzl8Ac1nyLV7N7VDoO6nHeUvNQ5UE7A1jga+U7FO4kkcJ1Rt8XqnKKkqLw9TNZNrPSy5EQxGudTHVVO+ZVDez8yDRIWsk+U9V52aWWZxJcWjpx/VVx3Phma9pJrkTxWLwqrs7l1z2prg0M3syTFcAXhw6g3sgxxHW1tGtXFbuJkwZbNF6Xu+Ui1eLCY11Orfw7A19bWTyNcSOyHTRlUoGPludDbCCHP42ksx5kiY9xsjw+qczHPm7QdEOHDTWwA80lnnVI0RFoZGKBVRnaRz5cb/a/BnSi23wS5fyTEx23Bv0XMaDW7htxtW5Hn9u5JICGHioQeidySxtMiF9ULunkWW7JRkVkw06FS0niquYOqZkFCtku6jwKuznlCgdeSivt5qJE0anup6Lvu56LY7jyU7jyR3Ds/HMn3c9FcY56LWGOCujH8kd0a6Yy/dj0VhjHotduP5IzcUEcEnlL/FswxjHore7HotwYf8AlV/cxW4S74/xTy2bJBht/wBofR5DmViZvaj3u04/gb15ovtTJ3nab4maqZycKs/yWc3GeNIkLY9e9uFKt2zyssntqjj55XCnSOP1Q7vfifNORYHeaw2QFzBekD4t6VPc3gFwB8N2eX3UNkJWKhhvYKwjI5JuHHc6zx4DbknYcAyP8XgFi9XRZykkbxwN+EZHdnoqljg74VrzYRY7w+If1x6JSXGeJKArYkAb8ERkmKeFx8iVUbFgo8eRLGD3cjhY5FEGDKWtdRDSLLnbADra7PiNicGd7yBcSPhC0TMGmmN4Ha/cO05jDI3qBRH816HEdBnRl2M5rq4it14z3d72vMZDg3i5v8VseyOS+PPfEGuLXt2AOwPonszo6fI9lGXg9EyF0RsXa0cbKkdGI3+Lk087Kv7uZDqqh0IXe4YP922j5KJNS4Z68NsMuPBb+z4nSGZ28jRuCeAWDn4TY5SS8it9jy5L0keFlS7kEXxJJQc3sjvGua5/iPNYcQ9napd+Ouh4mQ0424uRmSFrAAyr5lbX9nQYbXGi955ngCkpIqOqjqPMKllUjB9HPG7YENawXoJceqHO95sbV5JhjdJt7OPDZdMMz/hjAHRUpozlhbXBlOjL3UCriBkfxELTHZ+RJXEegXH9ky/NqHrStTRyvA/NGU4MvguJ53Z1Hcn7rqrZGDxM9IGqwYuroKxs9RNHQFdrPJcDh0RWKG2WmjrI/JHjj3XGBMxsvkocmUcEYAQM1r34srMchspadDuhThZpFpci3UkmEuVR80l7D7U7qTNyY3lzS5xdJQ2HE7n+CTxzA8as2SRzdW7WEHQOtr6tk4UediyY07NccgpzbIsfRYT/AGOwY36mPmbG1hAj1AgG+O63WVeGeNl6CUX/AGzwbGU0SXIyI2Yy5vhfW+k+vRacGRHLpjnHdHgC5uzOgpeng9jcdsrHxzOaWmzqaCD6jh/X1WfkeyvaPvk3urYpWg3tGWgXvQBNDypOU1RMemnF8oWxohkT+BllziAQOPhC34ezXDRJHC7+6+PWOfBIdi9nZhyA1jCHai0A8jwI/rzX1H2Nxcd73R9pQMD9Vljm0L/cuHJNt0epHXDj2as+czdmy04GMh8puMN67k+or9RSwp4mQ5FStMRJLXPdR07L617Y4TJM1sPZbBVk1QLQa34r5xn9h58uSY4oe8OqnBo2Hmf/AGniyc0TOKy49kjz2TkxtbJj4rC4AkXWzwPL0CzDG1lSm3wBwD3Dax5L3GN7C5uRJqz8mKNu1tbZcNvIgf6Jz/69wizQ6Waydng+L9dv0XX3oI819Jkl4R88mkjjp2N3jWlxprnbV/FcwIpsrtCFuBq70uHjaPh6n0X06H/4/wCzHSEuEpaWgd2ZDW3NaOL7P4HZpIxcaJjq0lwG5HrxUvqYFY/6dkcv2YGCEtijZK7U4CiQNieqZw44WT1KTXJG93aPL6rhhHG/usXkT9nraNUkWz3SaQcdjjfQ8FkTw5kptzgGDj4qtPzTMYKIaT5hLS5h/bZ9AuaUlZ6WBzUfBnS4PeAapRQ5aku/DiBp72/mTsszS6yYyfMIffM5mMejAVUZ0XO5eQUbMdnE6kzHJEN9G3m1cGRGBex+gH7lz3yKvhaf/FX3H6Mu1H2y8uY0CmsH3WdlZUjuEbvowpt2dG3g0D0ASs2f0r7qozkRkhCjKm95L/DFJXoojvygTu9ii23ZwvBGzzX9pZv4uX7ro7RzPxMv3SauF6Gp86py+jYz8z8TJ+ZWGdm/ipfzJQBXbwVUitn9HG52d+Km/OiNzs+v8VP+cpNpRWnojWPwtSl9HGZmef8Ampvq8o8eRmk/4iT8xSTCRx/cmYn0k4R+HRjm/o9HLmu/48n5imGOzD8U0n1cUtFL0I+9pqOQ8yfoFk0dsJxDMOQPilf+ZNRTTtIHfP8AzJRsnNWMtEeLfospI64TRt4ErmkAPI3vY80bt7tSfC7Iklikdqa5tO6brMxsnh4glPavK/8AxpWk8S0j7rlnBSZrkaWNuj0+D2hLN2ZjOdK4l8TXkjmSEpPPkV/vHrO9n8u+xsQF3CBl/YJx0l/MphjSZpjacE0heXLzeUsiUlz+0uWTImJ3JCSU9F1xin6McskvJx3aPaw4ZUv5kvL2n2pxOTJ91Z8vm77pWaUb2d/Oh+5arHH4cU8qXhlJe1e0wdsqQfVLP7X7U/GSn6qssm/L7pd7r/0Wqxx+HFkzS+ln9oZ53OVL90B2dm/iZD9Vxx/q0Jyfbh8MHnyepMu7OzDxyH/dV9+zBwnkQnKhSeOPwh5sn+zDO7QzOeRJ9SqHOy/xD/uhEKhCXbj8E8+R/wCTCuzcnnkP+6ocvIP/ADD0MhVT0j8M3ln9LnIn/wCqfuuoRURqiO5P6EBVg5UCtw4qhJlwVYOQS9o4kBVORG34bPolaHsNh/mfsrh/p9kh76P2XfUrnvp+WMX5lPdFbmqx/p9CmI331+hWF79IODWBdHaMw+Vh+iTmilkPSxyEcdQ9CDaM3IBNb7cA5v8AJeYHak4HhDB6X/NUf2jkvaRq0/8AaBupckarOkeuOdjw33j2g+u32WZle0EYd/cDW7mapeacS7crnBZPkt9ZOqRsO7dzCPDJQ9EvN2hkZDdM0znAncHgkAV3Up1Rm+om1TZpY/auZA3TDK5reFckaP2h7RY++9BHQrH1FcJKNENdRkSpSZ6qH2rDhpyYiBtuxMDtfFnaA2Rln9o8f6814yyoCQfDsqSor8zJ75PZmcEjS0m/MDdClkN70PUry7MrIaK759dLtWGfkD579QFqpIiWezcfJXFwr1QHyDqFlHPnPzD7Lnv03Mg/RVujJ5DSL+m/0Qy49Ej75IeIb9lz3tx+JoPojdE72OOKrqS4yhzariZh4I2QrL2uEqWCquTFZCuWouFBJ1RVtRAA3TkfCFR0jjzVFFjbAh342oookBFFFEARRRRAHQuqqloGmWUXAuoKIuriiQyKKWpaYmyWpaquoFZ0qqhKiBWyKKKIERRRRAEU2+qiiAIHOHAorZiNjwQlE7YDHeN6q1g80qCu2eqpTAYpRA1lRPcCqiiizAiiiiAIooogCKKKIAiiiiAIrBRRBSIooogZwriiiCWRRRRAiKKKIAiiiiAIooogCKKKIAiiiiAIooogCKKKIA//2Q==")

                //     // this.on("maxfilesexceeded", function(file) {
                //     //     this.removeFile(file);
                //     //     alert("No more files please!");
                //     // });
                //     dropzones.push(thisDropzone);

                //  }
                // }

                // },
                // ....
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

    $('body').on('click', ".remove_tbl_media-onclose", function(e) {
        var mid = $(this).attr("data-mid");
        $.ajax({
            url: APP_URL + "/api/SaleInvoiceMediadelete/" + mid,
            type: "get",
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(xhr) {
                if (confirm("Are you sure?")) {
                    //  block_gui_start();
                    xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
                } else {
                    // stop the ajax call
                    return false;
                }

            },
            success: function(response) {
                block_gui_end();

            },
            error: function(response) {
                block_gui_end();
                console.log("server side error");
            }
        });
    });
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
        const changeButton = document.getElementById("changeImage");

        $("#uploadImage").on("change", function(event) {
            handleImageUpload(event);
        });

        $("#changeImage").on("click", function(event) {
            handleImageUpload(event);
        });

        $("#replaceImage").on("click", function() {
            $("#uploadImage").click();
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
<!--  -->
<script>
    var savedJsonArray = [];
    var defaultJson = [{
            "column_name": "HSN/SAC",
            "column_class": " ",
            "column_type": "Text",
            "hide": 0,
            "editable": 1,
            "deletable": 0,
            "class": "HSN_SAC ",
            "field_class": "HSN_SAC_field hsn_d hsn_",
            "unique_key": "HSN_SAC",
            "default_value": ""
        }, {
            "column_name": "GST Rate",
            "column_class": " ",
            "column_type": "Text",
            "hide": 0,
            "editable": 1,
            "deletable": 0,
            "class": "GST_Rate ",
            "field_class": "GST_Rate_field gst_rate_d gst_rate_",
            "unique_key": "GST_Rate",
            "default_value": "0"
        }, {
            "column_name": "Quantity",
            "column_class": " ",
            "column_type": "Text",
            "hide": 0,
            "editable": 1,
            "deletable": 0,
            "class": "Quantity ",
            "field_class": "Quantity_field qty_d budle_quantity_",
            "unique_key": "Quantity",
            "default_value": "1"
        }, {
            "column_name": "Rate",
            "column_class": " ",
            "column_type": "Text",
            "hide": 0,
            "editable": 1,
            "deletable": 0,
            "class": "Rate ",
            "field_class": "Rate_field rate_d rate_",
            "unique_key": "Rate",
            "default_value": "1"
        },
        {
            "column_name": "Amount",
            "column_class": " amount_column",
            "column_type": "(Quantity * Rate)",
            "hide": 0,
            "editable": 0,
            "deletable": 0,
            "class": "Amount ",
            "field_class": "Amount_field amt_d amount_",
            "unique_key": "Amount",
            "default_value": ""
        }, {
            "column_name": "IGST",
            "column_type": "Text",
            "column_class": " comn_rate_col igst_th igst_column",
            "hide": 0,
            "editable": 0,
            "deletable": 0,
            "class": "IGST  igst_td comn_rate_col",
            "field_class": "IGST_field igst_d igst_",
            "unique_key": "IGST",
            "default_value": ""
        },
        {
            "column_name": "Total",
            "column_class": " ",
            "column_type": "(Amount + Tax)",
            "hide": 0,
            "editable": 0,
            "deletable": 0,
            "class": "Total ",
            "field_class": "Total_field total_d total_",
            "unique_key": "Total",
            "default_value": ""
        }
    ];

    var newJson = defaultJson;
    var removedFields = [];

    var gstRatetJson = {
        "column_name": "GST Rate",
            "column_class": " ",
            "column_type": "Text",
            "hide": 0,
            "editable": 1,
            "deletable": 0,
            "class": "GST_Rate ",
            "field_class": "GST_Rate_field gst_rate_d gst_rate_",
            "unique_key": "GST_Rate",
            "default_value": ""
    };

    var igstJson = {
        "column_name": "IGST",
        "column_type": "Text",
        "column_class": " comn_rate_col igst_th igst_column",
        "hide": 0,
        "editable": 0,
        "deletable": 0,
        "class": "IGST  igst_td comn_rate_col",
        "field_class": "IGST_field igst_d igst_",
        "unique_key": "IGST",
        "default_value": ""
    };

    var cgstJson = {
        "column_name": "CGST",
        "column_class": "c_s_gst_th cgst_th ",
        "column_type": "Text",
        "hide": 0,
        "editable": 0,
        "deletable": 0,
        "class": "CGST c_s_gst_td cgst_td ",
        "field_class": "CGST_field cgst_d cgst_",
        "unique_key": "CGST",
        "default_value": ""
    };

    var sgstJson = {
        "column_name": "SGST",
        "column_class": " c_s_gst_th sgst_th ",
        "column_type": "Text",
        "hide": 0,
        "editable": 0,
        "deletable": 0,
        "class": "SGST c_s_gst_td sgst_td ",
        "field_class": "SGST_field sgst_d sgst_",
        "unique_key": "SGST",
        "default_value": ""
    };

    function loadDefaultColumns(newJsonArr = '') {

        if (newJsonArr == '') {
            newJsonArr = defaultJson;
        }

        var html = '';
        $.each(newJsonArr, function(key, item) {
            if (item.class.indexOf("hide-d") >= 0 || item.column_name == "Item" || item.column_name == "item") {

            } else {
                html += '<div class="col_line no-swipe ' + item.class + '">';

                html += '<div class="space_grag handle instant">';
                html += '&nbsp';
                html += '</div>';
                html += '<div class="withprivet">';
                html += '<div class="form-group">';
                html += '<label>';
                html += '<input type="text" required="" data-index="' + key + '" class="column_field_popup " id="" value="' + item.column_name + '" placeholder="' + item.column_name + '">';
                html += '<span>' + item.column_name + '</span>';
                html += '</label>';
                html += '</div>';
                if (item.deletable == 1) {
                    html += '<div class="sd_check">';
                    html += '<input type="checkbox" name="layout" id="private">';
                    html += '<label class="pull-right text" for="private">Make private?</label>';
                    html += '</div>';
                }
                html += '</div>';
                html += '<div class="select_wr">';
                html += '<select class="js-states form-control nosearch column_field_type_popup" data-index="' + key + '">';
                html += '<option value="Text">TEXT</option>';
                html += '<option value="Number">NUMBER</option>';
                html += '</select>';
                html += '</div>';
                html += '<div class="action_btns" data-action_btns_index="' + key + '">';
                html += '<button class="hide" data-index="' + key + '"><iconify-icon icon="ph:eye"></iconify-icon>Hide</button>';
                html += '<button class="unhide" data-index="' + key + '"><iconify-icon icon="ph:eye-slash"></iconify-icon>Unhide</button>';
                if (item.deletable == 1) {
                    html += '<button class="remove removeRowInPopup" data-index="' + key + '"><iconify-icon icon="mingcute:delete-2-line"></iconify-icon> Remove</button>';
                }
                html += '</div>';
                html += '</div>';
                $("#slippylist").html(html);

                $(".js-states.form-control.nosearch").select2({
                    minimumResultsForSearch: Infinity,
                    theme: "bootstrap4",
                });
            }
        });
    }


    function listColumnsInPopUp(newJsonArr = '') {

        if (newJsonArr == '') {
            newJsonArr = defaultJson;
        }
        var html = '<span class="th-b six-s first_item_span">Item</span>';
        $.each(newJsonArr, function(key, item) {
            if (item.column_class.indexOf("hide-d") >= 0 || item.column_name == "Item" || item.column_name == "item") {
                html += '<span class="th-b two-s hide-d" data-popup_column_index="' + key + '">' + item.column_name + '</span>';
            } else {
                html += '<span class="th-b two-s" data-popup_column_index="' + key + '">' + item.column_name + '</span>';
            }
        });

        $("#listColumnsInPopUp").html(html);
    }

    function loadColumnOnPage() {
        var html = '<span class="th-b six-s first_item_span">Item</span>';
        $.each(defaultJson, function(key, item) {
            if (item.hide != '1' && item.column_name != "Item") {
                if (item.column_class.indexOf("amount_column") >= 0) {
                    var hideClass = 'hide-d';
                    if (discountShowed) {
                        hideClass = '';
                    }
                    html += '<span class="th-b two-s discount_th ' + hideClass + '">Discount</span>';
                }
                if (item.column_class.indexOf("Discount") < 0) {
                    html += '<span class="th-b two-s ' + item.column_class + '">' + item.column_name + '</span>';
                }
            }
        });

        html += '<span class="th-b one-s"></span>';

        $("#loadColumnOnPage").html(html);

        $(".first_item_span").html($(".first_item_field").attr("placeholder"));
    }

    var newRwkey = 0;

    function loadColumnFieldsOnPage(itemRow = 0) {
        var rid = parseInt(itemRow);
        // var rid = parseInt(itemRow) + 1;
        var html = '<div class="items_view_edit_table" data-items_view_edit_table="' + rid + '">';
        html += '<span cols="20" class="td-u six-s listing-item">';
        html += '<span class="label first_item_span">Item</span>';
        html += '<div class="searchInput">';
        html += '<input class="grp_item first_item_field item_inp_' + itemRow + '"  type="text" placeholder="item">';
        html += '<div class="resultBox">';
        html += '</div>';
        html += '</div>';
        // html += '</div>';
        html += '</span>';
        $.each(defaultJson, function(key, item) {
            var is_disable = '';
            if (item.editable != 1) {
                is_disable = 'disabled';
            }
            if (item.column_class.indexOf("amount_column") >= 0) {
                var hideClass = 'hide-d';
                if (discountShowed) {
                    hideClass = '';
                }

                html += '<span cols="20" class="td-u two-s listing-item  Discount inline_disc_td ' + hideClass + ' discount_td_' + rid + '" data-listing-item="' + key + '" data-unique_key="discount" >';
                html += '<span class="label">Discount</span>';
                html += '<div class="css-rxk9pl">';
                html += '<input type="text" placeholder="Discount" class="Discount_field inline_disc_d inpt_inline_disc_' + rid + '" data-index-key="' + rid + '" data-key="' + rid + '" />';
                html += '</div>';
                html += '</span>';
            }
            if (item.column_class.indexOf("Discount") < 0) {
                if (item.unique_key == "HSN_SAC") {
                    var placeHolder = '#';
                } else {
                    var placeHolder = item.column_name;
                }

                var hideFieldClass = '';
                if(item.hide == '1'){
                    hideFieldClass = 'hide-d';
                }

                html += '<span cols="20" class="td-u two-s listing-item '+ hideFieldClass+' ' + item.class + '" data-listing-item="' + key + '" data-unique_key="' + item.unique_key + '" >';
                html += '<span class="label">' + item.column_name + '</span>';
                html += '<div class="css-rxk9pl">';
                html += '<input type="text" placeholder="' + placeHolder + '" value="' + item.default_value + '" class="' + item.field_class + '' + rid + '" data-index-key="' + rid + '" data-key="' + rid + '" ' + is_disable + ' data-hide="' + item.hide + '"  data-editable="' + item.editable + '"  data-deletable="' + item.deletable + '"  />';
                // html += '<input type="hidden" class="remaining_array_attribute array_attribute_'+key+'" data-key-id="'+key+'" data-hide="' + item.hide + '"  data-editable="' + item.editable + '"  data-deletable="' + item.deletable + '"  />';
                html += '</div>';
                html += '</span>';
            }

        });
        html += '<span class="close_icon listing-item">';
        html += '<button aria-label="Remove Item" type="button" class="remove_row romove_single_rw" data-listing_index="' + itemRow + '">';
        html += '<iconify-icon icon="material-symbols:close-rounded"></iconify-icon>';
        html += '</button>';
        html += '</span>';
        html += '</div>';

        html += '<div class="mini_action_table">';
        html += ' <div cols="15" class="hide_discount listing-item inline_disc_div_' + itemRow + '" data-id="' + itemRow + '">';
        html += '                                           <div class="ch-col withclose hide_discount_item">';
        html += '                                               <span>Discount</span>';
        html += '                                              <span class="withIn">';
        html += '                                                  <input type="text" class="dic_out inline_disc inlineDiscVal_' + itemRow + ' "   data-key="' + itemRow + '">';
        html += '                                                  <div class="select_full_se">';
        html += '                                                     <select class="js-states form-control inline_disc_type nosearch common_currency_sel_d inlineDiscType_' + itemRow + ' "  data-key="' + itemRow + '" >';
        html += '                                                         <option value="rupees" data-id="₹" >₹</option>';
        html += '                                                         <option value="%">%</option>';
        html += '                                                     </select>';
        html += '                                                 </div>';
        html += '                                            </span>';
        html += '                                            <button class="save_btn apply_inline_discount"  data-key="' + itemRow + '" type="button">';
        html += '                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 16 16"><path fill="none" stroke="currentColor" stroke-linecap="round" color="#5bbe2c" stroke-linejoin="round" stroke-width="1.5" d="m2.75 8.75l3.5 3.5l7-7.5"/></svg>';
        html += '                                            </button>';
        html += '                                            <button class="close_btn remove_inline_discount"  data-key="' + itemRow + '" type="button">';
        html += '                                                 <svg width="24" height="24"';
        html += '                                                     viewBox="0 0 24 24" fill="currentColor" color="#006AFF"';
        html += '                                                    xmlns="http://www.w3.org/2000/svg">';
        html += '                                                    <path';
        html += '                                                       d="M5.35355 4.64645C5.15829 4.45118 4.84171 4.45118 4.64645 4.64645C4.45118 4.84171 4.45118 5.15829 4.64645 5.35355L5.35355 4.64645ZM18.6464 19.3536C18.8417 19.5488 19.1583 19.5488 19.3536 19.3536C19.5488 19.1583 19.5488 18.8417 19.3536 18.6464L18.6464 19.3536ZM4.64645 5.35355L18.6464 19.3536L19.3536 18.6464L5.35355 4.64645L4.64645 5.35355Z">';
        html += '                                                   </path>';
        html += '                                                   <path';
        html += '                                                       d="M19.3536 5.35355C19.5488 5.15829 19.5488 4.84171 19.3536 4.64645C19.1583 4.45118 18.8417 4.45118 18.6464 4.64645L19.3536 5.35355ZM4.64645 18.6464C4.45118 18.8417 4.45118 19.1583 4.64645 19.3536C4.84171 19.5488 5.15829 19.5488 5.35355 19.3536L4.64645 18.6464ZM18.6464 4.64645L4.64645 18.6464L5.35355 19.3536L19.3536 5.35355L18.6464 4.64645Z">';
        html += '                                                   </path>';
        html += '                                               </svg>';
        html += '                                           </button>';
        html += '                                       </div>';
        html += '                                   </div>';
        html += '                                      <span cols="5" class="td-u five-s listing-item" data-id="' + itemRow + '">';
        html += '                                         <button aria-label="Add Edit Discount" title=""';
        html += '                                            class="add_discount add_inline_discount add_inlineDisc_' + itemRow + ' " data-key="' + itemRow + '" type="button">';
        html += '                                            <iconify-icon icon="iconamoon:discount-light"></iconify-icon>';
        html += '                                            Add/Edit Discount';
        html += '                                       </button>';
        html += '                                   </span>';
        html += ' <div cols="15" class="hide_option_descandimage2 editrImage_' + itemRow + ' listing-item"> ';
        html += '    <div id="editor1' + itemRow + '"></div>';
        html += ' </div>';
        html += '<span cols="4" class="td-u five-s  listing-item hide_desc_button">';
        html += ' <button aria-label="Add Description" class="openDescription2" data-id="' + itemRow + '" type="button">';
        html += '    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">';
        html += '      <g id="plus-square-outline" transform="translate(-.266 .217)">';
        html += '         <g id="Rectangle_1143" fill="rgba(255,255,255,0)" stroke="#006AFF" transform="translate(.266 -.217)">';
        html += '            <rect width="16" height="16" stroke="none" rx="3"></rect>';
        html += '            <rect width="15" height="15" x=".5" y=".5" fill="none" rx="2.5"></rect>';
        html += '        </g>';
        html += '        <g id="Group_588" transform="translate(5.264 4.783)">';
        html += '             <path id="Line_109" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="translate(3)"></path>';
        html += '              <path id="Line_110" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="rotate(90 1.5 4.5)"></path>';
        html += '          </g>';
        html += '       </g>';
        html += '   </svg>';
        html += '    Add Description';
        html += '  </button>';
        html += ' <button aria-label="Close Description" class="closeDescription hide-d" data-id="' + itemRow + '" type="button" style="">';
        html += '    <iconify-icon icon="gg:close-r"></iconify-icon>';
        html += '    Close Description';
        html += '  </button>';
        html += '</span>';
        html += ' <div cols="20" class="hide_option_imageOnly two_op shw_uodr_' + itemRow + ' listing-item">';
        html += '   <div class="upload__box">';
        html += '      <div class="upload__img-wrap"></div>';
        html += '     <div class="upload__btn-box">';
        html += '         <label class="upload__btn">';
        html += '            <p><iconify-icon icon="ion:add"></iconify-icon> Upload Thumbnail</p>';
        html += '           <input type="file" multiple=""  data-max_length="20" class="upload__inputfile invoice_product_image table_media_input_' + itemRow + '" data-main-index=' + itemRow + '>';
        html += '        </label>';
        html += '    </div>';
        html += '  </div>';
        html += ' </div>';
        html += '<span cols="5" class="td-u five-s listing-item">';
        html += '<button aria-label="Add Thumbnail" class="openthumbnails opetwo shw_thumbnail_btn_' + itemRow + '" data-id="' + itemRow + '" type="button">';
        html += '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16.072 16">';
        html += '<g id="image" transform="translate(0.495 0.495)">';
        html += '<rect id="Rectangle_1144" data-name="Rectangle 1144" width="16" height="16" transform="translate(-0.495 -0.495)" fill="none" opacity="0"></rect>';
        html += '<g id="Rectangle_771" data-name="Rectangle 771" transform="translate(-0.495 -0.495)" fill="none" stroke="#006AFF" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" >';
        html += '<rect width="16" height="16" rx="2" stroke="none"></rect>';
        html += '<rect x="0.5" y="0.5" width="15" height="15" rx="1.5" fill="none"></rect>';
        html += '</g>';
        html += '<circle id="Ellipse_275" data-name="Ellipse 275" cx="1.5" cy="1.5" r="1.5" transform="translate(3.505 3.505)" fill="none" stroke="#006AFF" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" ></circle>';
        html += '<path id="Path_1674" data-name="Path 1674" d="M19.587,14.614,14.973,10,5.426,19.6" transform="translate(-4.718 -4.902)" fill="none" stroke="#006AFF" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" ></path>';
        html += '</g>';
        html += '</svg>';
        html += 'Add Thumbnail';
        html += '</button>';
        html += '</span>';

        html += '<span cols="20" class="td-u tt2-s listing-item">';
        html += '<button aria-label="Add new item" title="Add new item below this item" data-listing_btn="' + itemRow + '" class="addnewcolumn addNewRowBtn" type="button">';
        html += '<svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 20 20" stroke-width="1" fill="none" stroke="currentColor">';
        html += '<path d="M1 8.5V10.2917C1 10.5678 1.22386 10.7917 1.5 10.7917H4.26667M4.26667 10.7917L3.05333 9.325M4.26667 10.7917L3.05333 12.1667M1.5 6H14.5C14.7761 6 15 5.77614 15 5.5V3.5C15 3.22386 14.7761 3 14.5 3H1.5C1.22386 3 1 3.22386 1 3.5V5.5C1 5.77614 1.22386 6 1.5 6ZM7.50057 11.9999H14.5006C14.7767 11.9999 15.0006 11.7761 15.0006 11.4999V9.49991C15.0006 9.22377 14.7767 8.99991 14.5006 8.99991H7.50057C7.22443 8.99991 7.00057 9.22377 7.00057 9.49991V11.4999C7.00057 11.7761 7.22443 11.9999 7.50057 11.9999Z" stroke="#006AFF" stroke-linecap="round" stroke-linejoin="round"></path>';
        html += '</svg>';
        html += 'Insert an item below';
        html += '</button>';
        html += '</span>';
        html += '<span cols="20" class="td-u tt3-s listing-item">';
        if ((itemRow == 0 && $(".loadColumnFieldsOnPage").length > 1) || (parseInt($(".loadColumnFieldsOnPage").length)) > parseInt(itemRow) + 1) {
            html += '<button shape="circle" aria-label="Move Down" title="Move Down" class="move_down_button show" data-move_down_index="' + itemRow + '" type="button">';
        } else {
            html += '<button shape="circle" aria-label="Move Down" title="Move Down" class="move_down_button hide-d" data-move_down_index="' + itemRow + '" type="button">';
        }
        html += '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="20" width="20" xmlns="http://www.w3.org/2000/svg">';
        html += '<path d="M99.4 284.9l134 138.1c5.8 6 13.7 9 22.4 9h.4c8.7 0 16.6-3 22.4-9l134-138.1c12.5-12 12.5-31.3 0-43.2-12.5-11.9-32.7-11.9-45.2 0l-79.4 83v-214c0-16.9-14.3-30.6-32-30.6-18 0-32 13.7-32 30.6v214l-79.4-83c-12.5-11.9-32.7-11.9-45.2 0s-12.5 31.2 0 43.2z"></path>';
        html += '</svg>';
        html += '</button>';
        if (itemRow != 0 && itemRow <= (parseInt($(".loadColumnFieldsOnPage").length))) {
            html += '<button shape="circle" aria-label="Move Up" title="Move Up" class="move_up_button show" data-move_up_index="' + itemRow + '" type="button">';
        } else {
            html += '<button shape="circle" aria-label="Move Up" title="Move Up" class="move_up_button hide-d" data-move_up_index="' + itemRow + '" type="button">';
        }
        html += '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="20" width="20" xmlns="http://www.w3.org/2000/svg">';
        html += '<path d="M412.6 227.1L278.6 89c-5.8-6-13.7-9-22.4-9h-.4c-8.7 0-16.6 3-22.4 9l-134 138.1c-12.5 12-12.5 31.3 0 43.2 12.5 11.9 32.7 11.9 45.2 0l79.4-83v214c0 16.9 14.3 30.6 32 30.6 18 0 32-13.7 32-30.6v-214l79.4 83c12.5 11.9 32.7 11.9 45.2 0s12.5-31.2 0-43.2z"></path>';
        html += '</svg>';
        html += '</button>';
        html += '</span>';
        html += '</div>';

        $("div").find("[data-main_listing_index='" + itemRow + "']").html(html);
        //$(".loadColumnFieldsOnPage").html(html);
        var gid = $(".item_row_" + itemRow).prevAll().closest('.group_rw_d').last().attr("data-key")
        $(".item_row_" + itemRow).attr("data-group-id", gid);
        $(".item_inp_" + itemRow).attr("data-group-id", gid);
        $(".item_inp_" + itemRow).attr("data-group-name", $("group_nm_" + gid).val());

        showCommonRwInAppendColumn();
        initializeEditor('editor1' + itemRow);
        ImgUpload();
        initializeSuggestionInputNew();
        newRwkey = itemRow;
        calculateRowValues(itemRow);
    }

    function initializeSuggestionInputNew() {
        // getting all required elements
        const searchInputs = document.querySelectorAll(".searchInput");

        searchInputs.forEach((searchInput, index) => {
            const input = searchInput.querySelector("input");
            const resultBox = searchInput.querySelector(".resultBox");
            const icon = searchInput.querySelector(".icon");
            let linkTag = searchInput.querySelector("a");
            let webLink;
            var main_listing_index = searchInput.parentNode.parentNode.parentNode.getAttribute("data-main_listing_index");

            // if user press any key and release
            input.addEventListener('keyup', (e) => {
                let userData = e.target.value; //user entered data
                let emptyArray = [];
                if (userData) {
                    emptyArray = suggestions?.filter((data) => {
                        if (data?.prod_name?.toLocaleLowerCase().startsWith(userData?.toLocaleLowerCase()))
                            return data?.prod_name?.toLocaleLowerCase().startsWith(userData?.toLocaleLowerCase());
                    });
                    emptyArray = emptyArray.map((data) => {
                        return data = '<li data-id="' + data?.varit_id + '" data-proid="' + data?.pro_id + '" >' + data?.prod_name + ' ' + data?.variation_name + ' (' + data?.quantity + ')</li>';
                    });

                    if (emptyArray.length) {
                        searchInput.classList.add("active");
                        showSuggestions(emptyArray);
                    }

                    let allList = resultBox.querySelectorAll("li");
                    for (let i = 0; i < allList.length; i++) {
                        allList[i].setAttribute("onclick", `select(${index},${main_listing_index}, this)`);
                    }
                } else {
                    searchInput.classList.remove("active");
                }
            });

            function showSuggestions(list) {
                let listData;
                if (!list.length) {
                    userValue = input.value;
                    listData = '<li>' + userValue + '</li>';
                } else {
                    listData = list.join('');
                }
                resultBox.innerHTML = listData;
            }
        });



        document.addEventListener('click', (e) => {
            const searchInputs = document.querySelectorAll(".searchInput");
            searchInputs.forEach((searchInput) => {
                if (!searchInput.contains(e.target)) {
                    searchInput.classList.remove("active");
                }
            });
        });
    }

    function reLoadColumnFieldsOnPage() {
        $('.loadColumnFieldsOnPage').each(function(i, obj) {
            if (!$(this).hasClass("group_rw_d")) {
                var colsCount = 7;
                if (discountShowed) {
                    colsCount = colsCount + 2;
                }

                $.each(defaultJson, function(key, item) {
                    if (item.unique_key != "Discount") {
                        var jsonKey = key;
                        if ($(obj).find("[data-unique_key='" + item.unique_key + "']").length == 1) {
                            colsCount = parseInt(colsCount) + 2;
                            if (item.hide == '1') {
                                colsCount = parseInt(colsCount) - 2;
                                $(obj).find("[data-unique_key='" + item.unique_key + "']").addClass("hide-d");
                            } else {
                                $(obj).find("[data-unique_key='" + item.unique_key + "']").removeClass("hide-d");
                            }
                        } else {
                            colsCount = parseInt(colsCount) + 2;
                            appendNewFieldOnPage(i, key, item);
                        }
                        if (item.column_class.indexOf("amount_column") >= 0) {
                            $(".Discount").attr("data-listing-item", jsonKey);
                        }

                        $("[data-unique_key='" + item.unique_key + "']").attr("data-listing-item", jsonKey);

                        $("." + item.field_class).attr("placeholder", item.column_name);
                        $("." + item.field_class).attr("type", item.column_type);
                        var classList = item?.field_class.split(" ");
                        var field_cal = classList[0];
                        $("." + field_cal).attr("type", item.column_type);

                        $('.items_view_edit_table').each(function(i, obj) {
                            if($(this).hasClass("group_inner_wrapper") && colsCount > 23){
                                $(this).css({
                                    "grid-template-columns": "repeat(23, 1fr)"
                                });
                            }else{
                                $(this).css({
                                    "grid-template-columns": "repeat(" + colsCount + ", 1fr)"
                                });
                            }
                        });
                        // $(".items_view_edit_table").css({
                        //     "grid-template-columns": "repeat(" + colsCount + ", 1fr)"
                        // });

                        $(".items_view_edit_table").attr("data-grid-template-columns", colsCount);
                        $("#loadColumnOnPage").css({
                            "grid-template-columns": "repeat(" + colsCount + ", 1fr)"
                        });
                    }
                });
            } else {
                //console.log(obj);
            }
        });

        $.each(removedFields, function(key, item) {
            $("." + item).remove();
        });

        removedFields = [];

        initializeSuggestionInputNew();
    }

    function appendNewFieldOnPage(divIndex, key, item) {

        if (item.hide != '1') {
            var is_disable = '';
            if (item.editable != 1) {
                is_disable = 'disabled';
            }
            html = '';
            html += '<span cols="20" class="td-u two-s listing-item ' + item.class + '" data-listing-item="' + key + '" data-unique_key="' + item.unique_key + '">';
            html += '<span class="label">' + item.column_name + '</span>';
            html += '<div class="css-rxk9pl">';
            html += '<input type="' + item.column_type + '" placeholder="' + item.column_name + '" class="' + item.field_class + '' + divIndex + '" ' + is_disable + ' />';
            html += '</div>';
            html += '</span>';

            $(html).insertAfter($("div").find("[data-items_view_edit_table='" + divIndex + "'] .listing-item:nth-child(1)"));
            showCommonRwInAppendColumn();
        }
        $("div").find("[cols]").each(function(index) {
            var totalCols = $(this).attr('cols');
            var colsNum = parseInt(totalCols) + 2;
            $(this).attr('cols', colsNum);
        });

        $("span").find("[cols]").each(function(index) {
            var totalCols = $(this).attr('cols');
            var colsNum = parseInt(totalCols) + 2;
            $(this).attr('cols', colsNum);
        });
    }

    function replaceSpecialChar(str) {
        return str.replace(/[&\/\\#, +()$~%.'":*?<>{}]/g, '_');
    }

    $(document).on('click', '#saveEditColumn', function() {
        defaultJson = newJson;
        loadColumnOnPage();
        reLoadColumnFieldsOnPage();

        $('.loadColumnFieldsOnPage').each(function(i, obj) {
            if (!$(this).hasClass("group_rw_d")) {
                var divList = $(obj).find("[data-items_view_edit_table='" + i + "'] .listing-item");
                divList.sort(function(a, b) {
                    return $(a).data("listing-item") - $(b).data("listing-item")
                });

                $("[data-items_view_edit_table='" + i + "']").html(divList);
            }
        });

        ImgUpload();
        calculateRowValues();
        $("#editcolumns").modal("hide");
        $(".js-states.form-control.nosearch").select2({
            minimumResultsForSearch: Infinity,
            theme: "bootstrap4",
        });
    });

    $(document).on('click', '#closeEditColumn', function() {
        $("#editcolumns").modal("hide");
    });

    // .................Edit invoice section Start........................
    $(document).ready(function() {
        if (is_invoice_edit == 1) {
            loadEditTableValues();
        } else {
            loadDefaultColumns();
            listColumnsInPopUp();
            loadColumnOnPage();
            loadColumnFieldsOnPage();
        }
    })

    function loadEditTableValues() {
        var ArrayForDefaultJson = [];
        var saleInvoiceDynamicTableData = <?= (!empty($savedInvloiceAllData['saleInvoice']->filed_data) ? $savedInvloiceAllData['saleInvoice']->filed_data : []) ?>;
        $.each(saleInvoiceDynamicTableData, function(index, columnsData) {
            if (columnsData?.is_group == false) {
                var SubJsonArray = [];
                var SubJsonArray2 = [];
                $.each(columnsData?.data, function(index1, rowsData) {
                    SubJsonArray.push({
                        "is_group": false,
                        "column_name": rowsData?.column_name,
                        "column_class": rowsData?.column_class,
                        "column_type": "Text",
                        "hide": rowsData?.hide,
                        "editable": rowsData?.editable,
                        "deletable": rowsData?.deletable,
                        "class": rowsData?.unique_key + " ",
                        "field_class": rowsData?.field_class,
                        "unique_key": rowsData?.unique_key,
                        "default_value": rowsData?.field_val,
                        "inline_disc_val": rowsData?.inline_disc_val,
                        "inline_disc_type": rowsData?.inline_disc_type,
                        "row_descrition": rowsData?.row_description,
                        "field_product_id": rowsData?.field_product_id,
                        "field_variat_id": rowsData?.field_variat_id,
                        "row_tax_rate": rowsData?.row_tax_rate


                    });


                    var field_class = rowsData?.field_class.split(" ");
                    field_class.pop();

                    SubJsonArray2.push({
                        "is_group": false,
                        "column_name": rowsData?.column_name,
                        "column_class": rowsData?.column_class,
                        "column_type": "Text",
                        "hide": rowsData?.hide,
                        "editable": rowsData?.editable,
                        "deletable": rowsData?.deletable,
                        "class": rowsData?.unique_key + " ",
                        "field_class": field_class.toString(" ").replace(/,/g, " "),
                        "unique_key": rowsData?.unique_key,
                        "default_value": "",
                        "row_descrition": rowsData?.row_description,
                        "inline_disc_val": rowsData?.inline_disc_val,
                        "inline_disc_type": rowsData?.inline_disc_type,
                        "field_product_id": rowsData?.field_product_id,
                        "field_variat_id": rowsData?.field_variat_id,
                        "row_tax_rate": rowsData?.row_tax_rate
                    });
                });
                
                if (SubJsonArray.length > 0) {
                    savedJsonArray.push(SubJsonArray);
                }

                if (SubJsonArray2.length > 0) {
                    if (ArrayForDefaultJson.length == 0) {
                        ArrayForDefaultJson.push(SubJsonArray2);
                    }
                }
            } else {
                var SubJsonArray = [];
                var SubJsonArray2 = [];
                $.each(columnsData?.data, function(index1, rowsData) {
                    if (index1 == 1) {
                        SubJsonArray.push({
                            "is_group": true,
                            "column_name": '',
                            "column_class": '',
                            "column_type": "Text",
                            "hide": rowsData?.hide,
                            "editable": rowsData?.editable,
                            "deletable": rowsData?.deletable,
                            "class": rowsData?.unique_key + " ",
                            "field_class": rowsData?.field_class,
                            "unique_key": rowsData?.unique_key,
                            "default_value": rowsData?.field_val,
                            "row_descrition": rowsData?.row_description,
                            "inline_disc_val": rowsData?.inline_disc_val,
                            "inline_disc_type": rowsData?.inline_disc_type,
                            "field_product_id": rowsData?.field_product_id,
                            "field_variat_id": rowsData?.field_variat_id,
                            "row_tax_rate": rowsData?.row_tax_rate

                        });

                        if (SubJsonArray.length > 0) {
                            savedJsonArray.push(SubJsonArray);
                            SubJsonArray = [];
                        }

                        $.each(rowsData?.fields, function(index2, fieldsData) {
                            $.each(fieldsData, function(index3, fieldsRow) {
                                SubJsonArray.push({
                                    "is_group": false,
                                    "column_name": fieldsRow?.column_name,
                                    "column_class": fieldsRow?.column_class,
                                    "column_type": "Text",
                                    "hide": fieldsRow?.hide,
                                    "editable": fieldsRow?.editable,
                                    "deletable": fieldsRow?.deletable,
                                    "class": fieldsRow?.unique_key + " ",
                                    "field_class": fieldsRow?.field_class,
                                    "unique_key": fieldsRow?.unique_key,
                                    "default_value": fieldsRow?.field_val,
                                    "row_descrition": fieldsRow?.row_description,
                                    "inline_disc_val": fieldsRow?.inline_disc_val,
                                    "inline_disc_type": fieldsRow?.inline_disc_type,
                                    "field_product_id": fieldsRow?.field_product_id,
                                    "field_variat_id": fieldsRow?.field_variat_id,
                                    "row_tax_rate": fieldsRow?.row_tax_rate

                                });

                                var field_class = fieldsRow?.field_class.split(" ");
                                field_class.pop();

                                SubJsonArray2.push({
                                    "is_group": false,
                                    "column_name": fieldsRow?.column_name,
                                    "column_class": fieldsRow?.column_class,
                                    "column_type": "Text",
                                    "hide": fieldsRow?.hide,
                                    "editable": fieldsRow?.editable,
                                    "deletable": fieldsRow?.deletable,
                                    "class": fieldsRow?.unique_key + " ",
                                    "field_class": field_class.toString(" ").replace(/,/g, " "),
                                    "unique_key": fieldsRow?.unique_key,
                                    "default_value": "",
                                    "row_descrition": fieldsRow?.row_description,
                                    "inline_disc_val": fieldsRow?.inline_disc_val,
                                    "inline_disc_type": fieldsRow?.inline_disc_type,
                                    "field_product_id": fieldsRow?.field_product_id,
                                    "field_variat_id": fieldsRow?.field_variat_id,
                                    "row_tax_rate": fieldsRow?.row_tax_rate
                                });
                            });

                            if (SubJsonArray.length > 0) {
                                savedJsonArray.push(SubJsonArray);
                                SubJsonArray = [];
                            }

                            if (SubJsonArray2.length > 0) {
                                if (ArrayForDefaultJson.length == 0) {
                                    ArrayForDefaultJson.push(SubJsonArray2);
                                }
                                SubJsonArray2 = [];
                            }
                        });
                    }
                });
            }
        });

        defaultJson = ArrayForDefaultJson[0].slice(1);

        newJson = defaultJson;

        loadDefaultColumnsForEdit(saleInvoiceDynamicTableData[0].columns);
        listColumnsInPopUpForEdit(saleInvoiceDynamicTableData[0].columns);
        loadColumnOnPageForEdit(saleInvoiceDynamicTableData[0].columns);
        loadColumnFieldsOnPageForEdit();

        $('.loadColumnFieldsOnPage').each(function(i, obj) {
            if (!$(this).hasClass("group_rw_d")) {
                var divList = $(obj).find("[data-items_view_edit_table='" + i + "'] .listing-item");
                divList.sort(function(a, b) {
                    return $(a).data("listing-item") - $(b).data("listing-item")
                });

                $("[data-items_view_edit_table='" + i + "']").html(divList);
            }
        });

        ImgUpload();
        calculateRowValues();
        $("#editcolumns").modal("hide");
        $(".js-states.form-control.nosearch").select2({
            minimumResultsForSearch: Infinity,
            theme: "bootstrap4",
        });
    }
    //............................................... End Edit invoice section  ........................

    function createRandomString() {
        //define a variable consisting alphabets in small and capital letter  
        var characters = "ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";

        //specify the length for the new string  
        var lenString = 7;
        var randomstring = '';

        //loop to select a new character in each iteration  
        for (var i = 0; i < lenString; i++) {
            var rnum = Math.floor(Math.random() * characters.length);
            randomstring += characters.substring(rnum, rnum + 1);
        }

        return randomstring;
    }

    $(document).on('click', '.addnewcolumnbtn', function() {
        var randomString = createRandomString();
        var newColumn = {
            "column_name": "Column 1",
            "column_class": "",
            "column_type": "Text",
            "hide": 0,
            "editable": 1,
            "deletable": 1,
            "class": randomString,
            "field_class": randomString + "_field",
            "unique_key": randomString,
            "default_value": ""
        };

        if (newJson.length <= 15) {
            newJson.unshift(newColumn);
            loadDefaultColumns(newJson);
            listColumnsInPopUp(newJson);
        } else {
            alert("Limit exceed");
        }
    });

    $(document).on('keyup', '.column_field_popup', function() {
        var $this = $(this);
        defaultJson[$(this).data('index')].column_name = $this.val();

        listColumnsInPopUp();
    });

    $(document).on('keyup', '.first_item_popup_field', function() {
        var $this = $(this);

        $(".first_item_field").attr("placeholder", $this.val());
        $(".first_item_span").html($this.val());
    });

    $(document).on('click', '.addNewRowBtn', function() {
        var index = $(this).attr("data-listing_btn");
        var totalMainDivs = $(".loadColumnFieldsOnPage").length;
        var grid_template_columns = $(".items_view_edit_table").attr("data-grid-template-columns");

        // $(html).insertAfter($('.loadColumnFieldsOnPage:nth-child('+divIndex+1+') .listing-item:nth-child(1)'));

        $('.loadColumnFieldsOnPage').each(function(i, obj) {
            var currentIndex = $(this).attr("data-main_listing_index");
            if (currentIndex != index && currentIndex > index) {

                $(this).attr("data-main_listing_index", (parseInt(currentIndex) + 1));

                if ($(obj).hasClass("group_rw_d")) {
                    $(this).attr("data-key", (parseInt(currentIndex) + 1));
                    $(obj).find("[data-key='" + currentIndex + "']").attr("data-key", (parseInt(currentIndex) + 1));
                    $(obj).find("[data-id='" + currentIndex + "']").attr("data-id", (parseInt(currentIndex) + 1));
                }

                $(obj).find("[data-items_view_edit_table='" + currentIndex + "']").attr("data-items_view_edit_table", (parseInt(currentIndex) + 1));
                $(obj).find("[data-listing_btn='" + currentIndex + "']").attr("data-listing_btn", (parseInt(currentIndex) + 1));
                $(obj).find("[data-listing_index='" + currentIndex + "']").attr("data-listing_index", (parseInt(currentIndex) + 1));
                $(obj).find("[data-move_down_index='" + currentIndex + "']").attr("data-move_down_index", (parseInt(currentIndex) + 1));
                $(obj).find("[data-move_up_index='" + currentIndex + "']").attr("data-move_up_index", (parseInt(currentIndex) + 1));


                // Change counter from classes
                changeClassCounterOfFields(obj, currentIndex, (parseInt(currentIndex) + 1));
            }
        });

        var html = '<div class="tbody_column ui-state-default loadColumnFieldsOnPage" data-main_listing_index="' + (parseInt(index) + 1) + '"></div>';
        $(html).insertAfter($("div").find("[data-main_listing_index='" + index + "']"));

        loadColumnFieldsOnPage((parseInt(index) + 1));
        //  newRwkey++;

        $('.loadColumnFieldsOnPage').each(function(i, obj) {
            if ((i == 0 && $(".loadColumnFieldsOnPage").length > 1) || (parseInt($(".loadColumnFieldsOnPage").length)) > parseInt(i) + 1) {
                $("[data-move_down_index='" + i + "']").removeClass("hide-d");
            } else {
                $("[data-move_down_index='" + i + "']").addClass("hide-d");
            }

            if (i != 0 && i <= (parseInt($(".loadColumnFieldsOnPage").length))) {
                $("[data-move_up_index='" + i + "']").removeClass("hide-d");
            } else {
                $("[data-move_up_index='" + i + "']").addClass("hide-d");
            }
        });

        $('.items_view_edit_table').each(function(i, obj) {
            if($(this).hasClass("group_inner_wrapper") && grid_template_columns > 23){
                $(this).css({
                    "grid-template-columns": "repeat(23, 1fr)"
                });
            }else{
                $(this).css({
                    "grid-template-columns": "repeat(" + grid_template_columns + ", 1fr)"
                });
            }
        });

        // $(".items_view_edit_table").css({
        //     "grid-template-columns": "repeat(" + grid_template_columns + ", 1fr)"
        // });

    });

    $(document).on('click', '.addNewLineBtn', function() {
        var totalMainDivs = $(".loadColumnFieldsOnPage").length;
        var index = totalMainDivs - 1;
        var grid_template_columns = $(".items_view_edit_table").attr("data-grid-template-columns");

        var html = '<div class="tbody_column ui-state-default loadColumnFieldsOnPage" data-main_listing_index="' + (parseInt(index) + 1) + '"></div>';
        // $(html).insertAfter($("div").find("[data-main_listing_index='" + index + "']"));
        $(".tble_append_d").append(html);

        loadColumnFieldsOnPage((parseInt(index) + 1));
        //  newRwkey++;
        $('.loadColumnFieldsOnPage').each(function(i, obj) {
            if ((i == 0 && $(".loadColumnFieldsOnPage").length > 1) || (parseInt($(".loadColumnFieldsOnPage").length)) > parseInt(i) + 1) {
                $("[data-move_down_index='" + i + "']").removeClass("hide-d");
            } else {
                $("[data-move_down_index='" + i + "']").addClass("hide-d");
            }

            if (i != 0 && i <= (parseInt($(".loadColumnFieldsOnPage").length))) {
                $("[data-move_up_index='" + i + "']").removeClass("hide-d");
            } else {
                $("[data-move_up_index='" + i + "']").addClass("hide-d");
            }
        });

        $('.items_view_edit_table').each(function(i, obj) {
            if($(this).hasClass("group_inner_wrapper") && grid_template_columns > 23){
                $(this).css({
                    "grid-template-columns": "repeat(23, 1fr)"
                });
            }else{
                $(this).css({
                    "grid-template-columns": "repeat(" + grid_template_columns + ", 1fr)"
                });
            }
        });

        // $(".items_view_edit_table").css({
        //     "grid-template-columns": "repeat(" + grid_template_columns + ", 1fr)"
        // });

    });

    function appendItemRow(e) {
        var index = $(this).attr("data-listing_btn");
        var totalMainDivs = $(".loadColumnFieldsOnPage").length;
        $(".addNewRowBtn").attr("data-listing_btn", (parseInt(newRwkey)));
        $('.loadColumnFieldsOnPage').each(function(i, obj) {
            var currentIndex = $(this).attr("data-main_listing_index");
            if (currentIndex != index && currentIndex > index) {
                if ($(obj).hasClass("group_rw_d")) {
                    $(this).attr("data-key", (parseInt(currentIndex) + 1));
                    $(obj).find("[data-key='" + currentIndex + "']").attr("data-key", (parseInt(currentIndex) + 1));
                    $(obj).find("[data-id='" + currentIndex + "']").attr("data-id", (parseInt(currentIndex) + 1));
                }

                $("[data-listing_btn='" + currentIndex + "']").attr("data-listing_btn", (parseInt(newRwkey)));
                $("[data-listing_index='" + currentIndex + "']").attr("data-listing_index", (parseInt(currentIndex) + 1));
                $("[data-move_down_index='" + currentIndex + "']").attr("data-move_down_index", (parseInt(currentIndex) + 1));
                $("[data-move_up_index='" + currentIndex + "']").attr("data-move_up_index", (parseInt(currentIndex) + 1));

                // Change counter from classes
                changeClassCounterOfFields(currentIndex, (parseInt(currentIndex) + 1));
            }
        });

        var html = '<div class="tbody_column ui-state-default loadColumnFieldsOnPage" data-main_listing_index="' + (parseInt(index) + 1) + '"></div>';
        // $(html).insertAfter($("div").find("[data-main_listing_index='" + index + "']"));
        $(".tble_append_d").find(".bt_footer").prev().after(html);

        loadColumnFieldsOnPage((parseInt(index) + 1));
        showCommonRwInAppendColumn();
        var gid = $(".item_row_" + rwkey).prevAll().closest('.group_rw_d').last().attr("data-key")
        $(".item_row_" + rwkey).attr("data-group-id", gid);
        $(".item_inp_" + rwkey).attr("data-group-id", gid);
        $(".item_inp_" + rwkey).attr("data-group-name", $(".group_nm_" + gid).val());

        initializeEditor('editor1' + rwkey);
        ImgUpload();
        initializeSuggestionInput();
        rwkey++;
    }


    $(document).on('click', '.move_down_button', function() {
        var listing_index = $(this).attr("data-move_down_index");
        var html1 = $("div").find("[data-main_listing_index='" + (parseInt(listing_index) + 1) + "']");
        // Changing all NEXTs to 00
        $("div").find("[data-main_listing_index='" + (parseInt(listing_index) + 1) + "']").attr("data-main_listing_index", "00");
        $("[data-items_view_edit_table='" + (parseInt(listing_index) + 1) + "']").attr("data-items_view_edit_table", "00");
        $("[data-listing_btn='" + (parseInt(listing_index) + 1) + "']").attr("data-listing_btn", "00");
        $("[data-listing_index='" + (parseInt(listing_index) + 1) + "']").attr("data-listing_index", "00");
        $("[data-move_down_index='" + (parseInt(listing_index) + 1) + "']").attr("data-move_down_index", "00");
        $("[data-move_up_index='" + (parseInt(listing_index) + 1) + "']").attr("data-move_up_index", "00");
        $("[data-key='" + (parseInt(listing_index) + 1) + "']").attr("data-key", "00");
        $("[data-id='" + (parseInt(listing_index) + 1) + "']").attr("data-id", "00");
        // Change counter from classes
        changeClassCounterOfFields($(html1), (parseInt(listing_index) + 1), "00");

        // Changing all Currents to Next
        var html2 = $("div").find("[data-main_listing_index='" + listing_index + "']");
        $("div").find("[data-main_listing_index='" + listing_index + "']").attr("data-main_listing_index", (parseInt(listing_index) + 1));
        $("[data-items_view_edit_table='" + listing_index + "']").attr("data-items_view_edit_table", (parseInt(listing_index) + 1));
        $("[data-listing_btn='" + listing_index + "']").attr("data-listing_btn", (parseInt(listing_index) + 1));
        $("[data-listing_index='" + listing_index + "']").attr("data-listing_index", (parseInt(listing_index) + 1));
        $("[data-move_down_index='" + listing_index + "']").attr("data-move_down_index", (parseInt(listing_index) + 1));
        $("[data-move_up_index='" + listing_index + "']").attr("data-move_up_index", (parseInt(listing_index) + 1));
        $("[data-key='" + listing_index + "']").attr("data-key", (parseInt(listing_index) + 1));
        $("[data-id='" + listing_index + "']").attr("data-id", (parseInt(listing_index) + 1));
        // Change counter from classes
        changeClassCounterOfFields($(html2), listing_index, (parseInt(listing_index) + 1));

        // Changing all 00 to Current
        var html3 = $("div").find("[data-main_listing_index='00']");
        $("div").find("[data-main_listing_index='00']").attr("data-main_listing_index", listing_index);
        $("[data-items_view_edit_table='00']").attr("data-items_view_edit_table", listing_index);
        $("[data-listing_btn='00']").attr("data-listing_btn", listing_index);
        $("[data-listing_index='00']").attr("data-listing_index", listing_index);
        $("[data-move_down_index='00']").attr("data-move_down_index", listing_index);
        $("[data-move_up_index='00']").attr("data-move_up_index", listing_index);
        $("[data-key='00']").attr("data-key", listing_index);
        $("[data-id='00']").attr("data-id", listing_index);
        // Change counter from classes
        changeClassCounterOfFields($(html3), "00", listing_index);

        var divList = $(".loadColumnFieldsOnPage");
        divList.sort(function(a, b) {
            return $(a).data("main_listing_index") - $(b).data("main_listing_index")
        });
        $(".mainTable").html(divList);

        $('.loadColumnFieldsOnPage').each(function(i, obj) {
            if ((i == 0 && $(".loadColumnFieldsOnPage").length > 1) || (parseInt($(".loadColumnFieldsOnPage").length)) > parseInt(i) + 1) {
                $("[data-move_down_index='" + i + "']").removeClass("hide-d");
            } else {
                $("[data-move_down_index='" + i + "']").addClass("hide-d");
            }

            if (i != 0 && i <= (parseInt($(".loadColumnFieldsOnPage").length))) {
                $("[data-move_up_index='" + i + "']").removeClass("hide-d");
            } else {
                $("[data-move_up_index='" + i + "']").addClass("hide-d");
            }
        });

        initializeSuggestionInputNew();

    });

    $(document).on('click', '.move_up_button', function() {
        var listing_index = $(this).attr("data-move_up_index");

        // Changing all NEXTs to 00
        var html1 = $("div").find("[data-main_listing_index='" + (parseInt(listing_index) - 1) + "']");
        $("div").find("[data-main_listing_index='" + (parseInt(listing_index) - 1) + "']").attr("data-main_listing_index", "00");
        $("[data-items_view_edit_table='" + (parseInt(listing_index) - 1) + "']").attr("data-items_view_edit_table", "00");
        $("[data-listing_btn='" + (parseInt(listing_index) - 1) + "']").attr("data-listing_btn", "00");
        $("[data-listing_index='" + (parseInt(listing_index) - 1) + "']").attr("data-listing_index", "00");
        $("[data-move_down_index='" + (parseInt(listing_index) - 1) + "']").attr("data-move_down_index", "00");
        $("[data-move_up_index='" + (parseInt(listing_index) - 1) + "']").attr("data-move_up_index", "00");
        $("[data-key='" + (parseInt(listing_index) - 1) + "']").attr("data-key", "00");
        $("[data-id='" + (parseInt(listing_index) - 1) + "']").attr("data-id", "00");
        // Change counter from classes
        changeClassCounterOfFields($(html1), (parseInt(listing_index) - 1), "00");

        // Changing all Currents to Next
        var html2 = $("div").find("[data-main_listing_index='" + listing_index + "']");
        $("div").find("[data-main_listing_index='" + listing_index + "']").attr("data-main_listing_index", (parseInt(listing_index) - 1));
        $("[data-items_view_edit_table='" + listing_index + "']").attr("data-items_view_edit_table", (parseInt(listing_index) - 1));
        $("[data-listing_btn='" + listing_index + "']").attr("data-listing_btn", (parseInt(listing_index) - 1));
        $("[data-listing_index='" + listing_index + "']").attr("data-listing_index", (parseInt(listing_index) - 1));
        $("[data-move_down_index='" + listing_index + "']").attr("data-move_down_index", (parseInt(listing_index) - 1));
        $("[data-move_up_index='" + listing_index + "']").attr("data-move_up_index", (parseInt(listing_index) - 1));
        $("[data-key='" + listing_index + "']").attr("data-key", (parseInt(listing_index) - 1));
        $("[data-id='" + listing_index + "']").attr("data-id", (parseInt(listing_index) - 1));
        // Change counter from classes
        changeClassCounterOfFields($(html2), listing_index, (parseInt(listing_index) - 1));

        // Changing all 00 to Current
        var html3 = $("div").find("[data-main_listing_index='00']");
        $("div").find("[data-main_listing_index='00']").attr("data-main_listing_index", listing_index);
        $("[data-items_view_edit_table='00']").attr("data-items_view_edit_table", listing_index);
        $("[data-listing_btn='00']").attr("data-listing_btn", listing_index);
        $("[data-listing_index='00']").attr("data-listing_index", listing_index);
        $("[data-move_down_index='00']").attr("data-move_down_index", listing_index);
        $("[data-move_up_index='00']").attr("data-move_up_index", listing_index);
        $("[data-key='00']").attr("data-key", listing_index);
        $("[data-id='00']").attr("data-id", listing_index);
        // Change counter from classes
        changeClassCounterOfFields($(html3), "00", listing_index);

        var divList = $(".loadColumnFieldsOnPage");
        divList.sort(function(a, b) {
            return $(a).data("main_listing_index") - $(b).data("main_listing_index")
        });

        $(".mainTable").html(divList);

        $('.loadColumnFieldsOnPage').each(function(i, obj) {
            if ((i == 0 && $(".loadColumnFieldsOnPage").length > 1) || (parseInt($(".loadColumnFieldsOnPage").length)) > parseInt(i) + 1) {
                $("[data-move_down_index='" + i + "']").removeClass("hide-d");
            } else {
                $("[data-move_down_index='" + i + "']").addClass("hide-d");
            }

            if (i != 0 && i <= (parseInt($(".loadColumnFieldsOnPage").length))) {
                $("[data-move_up_index='" + i + "']").removeClass("hide-d");
            } else {
                $("[data-move_up_index='" + i + "']").addClass("hide-d");
            }
        });

        initializeSuggestionInputNew();

    });

    $(document).on('click', '.remove_row', function() {
        var listing_index = $(this).attr("data-listing_index");
        if (confirm("Are you sure you want to delete it?")) {
            if ($('.mini_action_table').length == 1) {
                $("div").find("[data-main_listing_index='" + listing_index + "']").find('input:text').val('');
                calculateRowValues(listing_index);
                return false;
            }
            $("div").find("[data-main_listing_index='" + listing_index + "']").remove();
            calculateRowValues(listing_index);

            $('.loadColumnFieldsOnPage').each(function(i, obj) {
                var current_listing_index = $(obj).attr("data-main_listing_index");
                if (current_listing_index > listing_index) {

                    if ($(obj).hasClass("group_rw_d")) {
                        $(this).attr("data-key", (parseInt(current_listing_index) - 1));
                        $(obj).find("[data-key='" + current_listing_index + "']").attr("data-key", (parseInt(current_listing_index) - 1));
                        $(obj).find("[data-id='" + current_listing_index + "']").attr("data-id", (parseInt(current_listing_index) - 1));
                    }

                    $("div").find("[data-main_listing_index='" + current_listing_index + "']").attr("data-main_listing_index", (parseInt(current_listing_index) - 1));
                    $("[data-items_view_edit_table='" + current_listing_index + "']").attr("data-items_view_edit_table", (parseInt(current_listing_index) - 1));
                    $("[data-listing_btn='" + current_listing_index + "']").attr("data-listing_btn", (parseInt(current_listing_index) - 1));
                    $("[data-listing_index='" + current_listing_index + "']").attr("data-listing_index", (parseInt(current_listing_index) - 1));
                    $("[data-move_down_index='" + current_listing_index + "']").attr("data-move_down_index", (parseInt(current_listing_index) - 1));
                    $("[data-move_up_index='" + current_listing_index + "']").attr("data-move_up_index", (parseInt(current_listing_index) - 1));

                    // Change counter from classes
                    changeClassCounterOfFields(obj, current_listing_index, (parseInt(current_listing_index) - 1));
                }
            });

            $('.loadColumnFieldsOnPage').each(function(i, obj) {
                if ((i == 0 && $(".loadColumnFieldsOnPage").length > 1) || (parseInt($(".loadColumnFieldsOnPage").length)) > parseInt(i) + 1) {
                    $("[data-move_down_index='" + i + "']").removeClass("hide-d");
                } else {
                    $("[data-move_down_index='" + i + "']").addClass("hide-d");
                }

                if (i != 0 && i <= (parseInt($(".loadColumnFieldsOnPage").length))) {
                    $("[data-move_up_index='" + i + "']").removeClass("hide-d");
                } else {
                    $("[data-move_up_index='" + i + "']").addClass("hide-d");
                }
            });

            initializeSuggestionInputNew();
        }
    });

    $(document).on('change', '.column_field_type_popup', function() {
        var $this = $(this);
        defaultJson[$(this).data('index')].column_type = $this.val();
    });

    $(document).on('click', '.removeRowInPopup', function() {
        var $this = $(this);
        removedFields.push(defaultJson[$(this).data('index')].class);
        newJson = defaultJson;
        newJson.splice($(this).data('index'), 1);

        loadDefaultColumns(newJson);
        listColumnsInPopUp(newJson);
    });

    $(document).ready(function() {

        $(".js-states.form-control.nosearch").select2({
            minimumResultsForSearch: Infinity,
            theme: "bootstrap4",
        });
    });

    $(document).on('click', '.tnc_move_down_button', function() {

        var listing_index = $(this).attr("data-tnc_move_down_index");

        // Changing all NEXTs to 00
        $("div").find("[data-term_listing_index='" + (parseInt(listing_index) + 1) + "']").attr("data-term_listing_index", "00");
        $("[data-term_listing_number='" + (parseInt(listing_index) + 1) + "']").html("00");
        $("[data-term_listing_number='" + (parseInt(listing_index) + 1) + "']").attr("data-term_listing_number", "00");
        $("[data-tnc_move_down_index='" + (parseInt(listing_index) + 1) + "']").attr("data-tnc_move_down_index", "00");
        $("[data-tnc_move_up_index='" + (parseInt(listing_index) + 1) + "']").attr("data-tnc_move_up_index", "00");

        // Changing all Currents to Next
        $("div").find("[data-term_listing_index='" + listing_index + "']").attr("data-term_listing_index", (parseInt(listing_index) + 1));
        $("[data-term_listing_number='" + listing_index + "']").html((parseInt(listing_index) + 2));
        $("[data-term_listing_number='" + listing_index + "']").attr("data-term_listing_number", (parseInt(listing_index) + 1));
        $("[data-tnc_move_down_index='" + listing_index + "']").attr("data-tnc_move_down_index", (parseInt(listing_index) + 1));
        $("[data-tnc_move_up_index='" + listing_index + "']").attr("data-tnc_move_up_index", (parseInt(listing_index) + 1));

        // Changing all 00 to Current
        $("div").find("[data-term_listing_index='00']").attr("data-term_listing_index", listing_index);
        $("[data-term_listing_number='00']").html(parseInt(listing_index) + 1);
        $("[data-term_listing_number='00']").attr("data-term_listing_number", listing_index);
        $("[data-tnc_move_down_index='00']").attr("data-tnc_move_down_index", listing_index);
        $("[data-tnc_move_up_index='00']").attr("data-tnc_move_up_index", listing_index);

        var divList = $(".tncWrapper");
        divList.sort(function(a, b) {
            return $(a).data("term_listing_index") - $(b).data("term_listing_index")
        });
        $(".mainTncTable").html(divList);

        $('.tncWrapper').each(function(i, obj) {
            if ((i == 0 && $(".tncWrapper").length > 1) || (parseInt($(".tncWrapper").length)) > parseInt(i) + 1) {
                $("[data-tnc_move_down_index='" + i + "']").removeClass("hide-d");
            } else {
                $("[data-tnc_move_down_index='" + i + "']").addClass("hide-d");
            }

            if (i != 0 && i <= (parseInt($(".tncWrapper").length))) {
                $("[data-tnc_move_up_index='" + i + "']").removeClass("hide-d");
            } else {
                $("[data-tnc_move_up_index='" + i + "']").addClass("hide-d");
            }
        });

    });

    $(document).on('click', '.tnc_move_up_button', function() {
        var listing_index = $(this).attr("data-tnc_move_up_index");

        // Changing all NEXTs to 00
        $("div").find("[data-term_listing_index='" + (parseInt(listing_index) - 1) + "']").attr("data-term_listing_index", "00");

        $("[data-term_listing_number='" + (parseInt(listing_index) - 1) + "']").html("00");
        $("[data-term_listing_number='" + (parseInt(listing_index) - 1) + "']").attr("data-term_listing_number", "00");
        $("[data-tnc_move_down_index='" + (parseInt(listing_index) - 1) + "']").attr("data-tnc_move_down_index", "00");
        $("[data-tnc_move_up_index='" + (parseInt(listing_index) - 1) + "']").attr("data-tnc_move_up_index", "00");

        // Changing all Currents to Next
        $("div").find("[data-term_listing_index='" + listing_index + "']").attr("data-term_listing_index", (parseInt(listing_index) - 1));

        $("[data-term_listing_number='" + listing_index + "']").html((parseInt(listing_index)));
        $("[data-term_listing_number='" + listing_index + "']").attr("data-term_listing_number", (parseInt(listing_index) - 1));
        $("[data-tnc_move_down_index='" + listing_index + "']").attr("data-tnc_move_down_index", (parseInt(listing_index) - 1));
        $("[data-tnc_move_up_index='" + listing_index + "']").attr("data-tnc_move_up_index", (parseInt(listing_index) - 1));

        // Changing all 00 to Current
        $("div").find("[data-term_listing_index='00']").attr("data-term_listing_index", listing_index);
        $("[data-term_listing_number='00']").html(parseInt(listing_index) + 1);
        $("[data-term_listing_number='00']").attr("data-term_listing_number", listing_index);
        $("[data-tnc_move_down_index='00']").attr("data-tnc_move_down_index", listing_index);
        $("[data-tnc_move_up_index='00']").attr("data-tnc_move_up_index", listing_index);

        var divList = $(".tncWrapper");
        divList.sort(function(a, b) {
            return $(a).data("term_listing_index") - $(b).data("term_listing_index")
        });
        $(".mainTncTable").html(divList);

        $('.tncWrapper').each(function(i, obj) {
            if ((i == 0 && $(".tncWrapper").length > 1) || (parseInt($(".tncWrapper").length)) > parseInt(i) + 1) {
                $("[data-tnc_move_down_index='" + i + "']").removeClass("hide-d");
            } else {
                $("[data-tnc_move_down_index='" + i + "']").addClass("hide-d");
            }

            if (i != 0 && i <= (parseInt($(".tncWrapper").length))) {
                $("[data-tnc_move_up_index='" + i + "']").removeClass("hide-d");
            } else {
                $("[data-tnc_move_up_index='" + i + "']").addClass("hide-d");
            }
        });

    });

    function loadColumnFieldsOnPageForEdit() {

        $.each(savedJsonArray, function(arrayKey, itemArray) {
            itemRow = arrayKey;
            var rid = parseInt(itemRow);
            var gkey = rid;

            if (itemArray[0].is_group) {
                var groupHtml = '<div class="items_view_edit_table group_inner_wrapper group_row_' + gkey + '" data-items_view_edit_table="' + rid + '"  >';
                //groupHtml += '<div class="tbody_column group ui-state-default loadColumnFieldsOnPage group_rw_d group_row_' + gkey + '" data-key="' + gkey + '" data-main_listing_index="' + gkey + '">';
                groupHtml += '<span cols="22" class="td-u six-s group listing-item">';
                groupHtml += '  <span class="label">Item</span>';
                groupHtml += '  <div class="css-rxk9pl">';
                groupHtml += '      <input type="text" class="group_name_d group_nm_' + gkey + '"  data-key="' + gkey + '" value="' + itemArray[0].default_value + '" placeholder="Group name (Required)" />';
                groupHtml += '  </div>';
                groupHtml += ' </span>';
                groupHtml += ' <span class="close_icon listing-item">';
                groupHtml += '    <button aria-label="Remove Item" type="button" class="close_group"  onclick="removeItemGroup(this)" data-id="' + gkey + '">';
                groupHtml += '        <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>';
                groupHtml += '    </button>';
                groupHtml += ' </span>';
                groupHtml += '  <div cols="20" class="hide_option_imageOnly listing-item shw_group_odr_' + gkey + '">';
                groupHtml += '  <div class="upload__box">';
                groupHtml += '      <div class="upload__img-wrap"></div>';
                groupHtml += '      <div class="upload__btn-box">';
                groupHtml += '         <label class="upload__btn">';
                groupHtml += '            <p><iconify-icon icon="ion:add"></iconify-icon> Upload Thumbnail</p>';
                groupHtml += '           <input type="file" multiple="" data-max_length="20" class="upload__inputfile invoice_group_image">';
                groupHtml += '       </label>';
                groupHtml += '     </div>';
                groupHtml += '  </div>';
                groupHtml += ' </div>';
                groupHtml += ' <span cols="5" class="td-u five-s listing-item">';
                groupHtml += '    <button aria-label="Add Thumbnail" class="group_img_tmnail" type="button"  data-id="' + gkey + '" >';
                groupHtml += '       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16.072 16">';
                groupHtml += '           <g id="image" transform="translate(0.495 0.495)">';
                groupHtml += '              <rect id="Rectangle_1144" data-name="Rectangle 1144" width="16" height="16" transform="translate(-0.495 -0.495)" fill="none" opacity="0"></rect>';
                groupHtml += '             <g';
                groupHtml += '                 id="Rectangle_771"';
                groupHtml += '                 data-name="Rectangle 771"';
                groupHtml += '                transform="translate(-0.495 -0.495)"';
                groupHtml += '                fill="none"';
                groupHtml += '                 stroke="#006AFF"';
                groupHtml += '                 stroke-linecap="round"';
                groupHtml += '                 stroke-linejoin="round"';
                groupHtml += '                 stroke-width="1"';
                groupHtml += '             >';
                groupHtml += '                 <rect width="16" height="16" rx="2" stroke="none"></rect>';
                groupHtml += '                 <rect x="0.5" y="0.5" width="15" height="15" rx="1.5" fill="none"></rect>';
                groupHtml += '            </g>';
                groupHtml += '             <circle';
                groupHtml += '                 id="Ellipse_275"';
                groupHtml += '                 data-name="Ellipse 275"';
                groupHtml += '                 cx="1.5"';
                groupHtml += '                 cy="1.5"';
                groupHtml += '                r="1.5"';
                groupHtml += '                   transform="translate(3.505 3.505)"';
                groupHtml += '                  fill="none"';
                groupHtml += '                  stroke="#006AFF"';
                groupHtml += '                  stroke-linecap="round"';
                groupHtml += '                  stroke-linejoin="round"';
                groupHtml += '                  stroke-width="1"';
                groupHtml += '              ></circle>';
                groupHtml += '               <path';
                groupHtml += '                   id="Path_1674"';
                groupHtml += '                   data-name="Path 1674"';
                groupHtml += '                   d="M19.587,14.614,14.973,10,5.426,19.6"';
                groupHtml += '                   transform="translate(-4.718 -4.902)"';
                groupHtml += '                   fill="none"';
                groupHtml += '                   stroke="#006AFF"';
                groupHtml += '                   stroke-linecap="round"';
                groupHtml += '                   stroke-linejoin="round"';
                groupHtml += '                   stroke-width="1"';
                groupHtml += '               ></path>';
                groupHtml += '           </g>';
                groupHtml += '       </svg>';
                groupHtml += '       Add Thumbnail';
                groupHtml += '   </button>';
                groupHtml += '</span>';
                groupHtml += '<span cols="22" class="td-u tt3-s listing-item">';

                if ((gkey == 0 && $(".loadColumnFieldsOnPage").length > 1) || (parseInt($(".loadColumnFieldsOnPage").length)) > parseInt(gkey) + 1) {
                    groupHtml += '<button shape="circle" aria-label="Move Down" title="Move Down" class="move_down_button show" data-move_down_index="' + gkey + '" type="button">';
                } else {
                    groupHtml += '<button shape="circle" aria-label="Move Down" title="Move Down" class="move_down_button hide-d" data-move_down_index="' + gkey + '" type="button">';
                }

                groupHtml += '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="20" width="20" xmlns="http://www.w3.org/2000/svg">';
                groupHtml += '<path d="M99.4 284.9l134 138.1c5.8 6 13.7 9 22.4 9h.4c8.7 0 16.6-3 22.4-9l134-138.1c12.5-12 12.5-31.3 0-43.2-12.5-11.9-32.7-11.9-45.2 0l-79.4 83v-214c0-16.9-14.3-30.6-32-30.6-18 0-32 13.7-32 30.6v214l-79.4-83c-12.5-11.9-32.7-11.9-45.2 0s-12.5 31.2 0 43.2z"></path>';
                groupHtml += '</svg>';
                groupHtml += '</button>';

                if (gkey != 0 && gkey <= (parseInt($(".loadColumnFieldsOnPage").length))) {
                    groupHtml += '<button shape="circle" aria-label="Move Up" title="Move Up" class="move_up_button show" data-move_up_index="' + gkey + '" type="button">';
                } else {
                    groupHtml += '<button shape="circle" aria-label="Move Up" title="Move Up" class="move_up_button hide-d" data-move_up_index="' + gkey + '" type="button">';
                }
                groupHtml += '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="20" width="20" xmlns="http://www.w3.org/2000/svg">';
                groupHtml += '<path d="M412.6 227.1L278.6 89c-5.8-6-13.7-9-22.4-9h-.4c-8.7 0-16.6 3-22.4 9l-134 138.1c-12.5 12-12.5 31.3 0 43.2 12.5 11.9 32.7 11.9 45.2 0l79.4-83v214c0 16.9 14.3 30.6 32 30.6 18 0 32-13.7 32-30.6v-214l79.4 83c12.5 11.9 32.7 11.9 45.2 0s12.5-31.2 0-43.2z"></path>';
                groupHtml += '</svg>';
                groupHtml += '</button>';
                groupHtml += ' </span>';
                groupHtml += '</div>';

                if (itemRow > 0) {
                    var htmlMain = '<div class="tbody_column ui-state-default group_rw_d loadColumnFieldsOnPage group_row_' + itemRow + '" data-main_listing_index="' + itemRow + '"></div>';
                    $(htmlMain).insertAfter($("div").find("[data-main_listing_index='" + (parseInt(itemRow) - 1) + "']"));
                }else{
                    $("div").find("[data-main_listing_index='" + itemRow + "']").addClass("group_rw_d group_row_" + itemRow);    
                }
                $("div").find("[data-main_listing_index='" + itemRow + "']").html(groupHtml);
            } else {
                var alreadyExists = -1;
                var cols = (parseInt(itemArray.length) * 2) + 5;
                var discount_amount = '';
                var discount_inline_amount = '';
                var discount_inline_type = '';

                var html = '<div class="items_view_edit_table" data-items_view_edit_table="' + rid + '" data-grid-template-columns="' + cols + '" style="grid-template-columns: repeat(' + cols + ', 1fr);">';
                // Get Discount Amount     
                $.each(itemArray, function(index, obj) {
                    if (obj.unique_key === "Discount") {
                        alreadyExists = index;
                        return false; // Exit the loop once the object is found
                    }
                });

                if (alreadyExists !== -1) {
                    discount_amount = itemArray[alreadyExists].default_value;
                    discount_inline_amount = itemArray[alreadyExists].inline_disc_val;
                    discount_inline_type = itemArray[alreadyExists].inline_disc_type;
                }

                $.each(itemArray, function(key, item) {
                    var is_disable = '';
                    var firstClass = 'two-s';
                    if (item.editable != 1) {
                        is_disable = 'disabled';
                    }
                    if (item.column_class.indexOf("Discount") >= 0) {
                        discountShowed = true;
                    }
                    if (item.column_class.indexOf("amount_column") >= 0) {
                        var hideClass = 'hide-d';
                        if (discountShowed) {
                            hideClass = '';
                        }

                        html += '<span cols="20" class="td-u two-s listing-item  Discount inline_disc_td ' + hideClass + ' discount_td_' + rid + '" data-listing-item="' + key + '" data-unique_key="Discount" >';
                        html += '<span class="label">Discount</span>';
                        html += '<div class="css-rxk9pl">';
                        html += '<input type="text" placeholder="Discount" value="' + discount_amount + '" class="Discount_field inline_disc_d inpt_inline_disc_' + rid + '" data-index-key="' + rid + '" data-key="' + rid + '" />';
                        html += '</div>';
                        html += '</span>';
                    }
                    if (item.column_class.indexOf("Discount") < 0) {
                        if (item.unique_key == "HSN_SAC") {
                            var placeHolder = '#';
                        } else {
                            var placeHolder = item.column_name;
                        }
                        if (key == 0) {
                            firstClass = 'six-s';
                            html += '<span cols="20" class="td-u ' + firstClass + ' listing-item">';
                            html += '<span class="label">' + item.column_name + '</span>';
                            html += '<div class="searchInput">';
                            html += '<input type="text" placeholder="' + placeHolder + '" value="' + item.default_value + '" data-id="' + item?.field_variat_id + '" data-proid="' + item?.field_product_id + '"  class="first_item_field ' + item.field_class + '" data-index-key="' + rid + '" data-key="' + rid + '" ' + is_disable + ' />';
                            html += '<div class="resultBox">';
                            html += '</div>';
                            html += '</div>';

                            html += '</span>';
                        } else {
                            var hideClass = '';
                            if(item.hide == '1'){
                                hideClass = 'hide-d';
                            }
                            html += '<span cols="20" class="td-u '+ hideClass+' '+ firstClass + ' listing-item  ' + item.class + '" data-listing-item="' + key + '" data-unique_key="' + item.unique_key + '" >';
                            html += '<span class="label">' + item.column_name + '</span>';
                            html += '<div class="css-rxk9pl">';
                             var  row_tax_rate=0
                            if(item.row_tax_rate!='' && item.row_tax_rate!="undefined" && !isNaN(item.row_tax_rate)){
                                row_tax_rate = item.row_tax_rate;
                            }
                            html += '<input type="text" placeholder="' + placeHolder + '" value="' + item.default_value + '" class="' + item.field_class + '" data-gst-rate="' + row_tax_rate + '" data-index-key="' + rid + '" data-key="' + rid + '" ' + is_disable + ' data-hide="' + item.hide + '"  data-editable="' + item.editable + '"  data-deletable="' + item.deletable + '"  />';
                            html += '</div>';
                            html += '</span>';
                        }
                        //  html += '<input type="hidden" class="remaining_array_attribute array_attribute_'+key+'" data-key-id="'+key+'" data-hide="' + item.hide + '"  data-editable="' + item.editable + '"  data-deletable="' + item.deletable + '"  />';

                    }
                });
                html += '<span class="close_icon listing-item">';
                html += '<button aria-label="Remove Item" type="button" class="remove_row romove_single_rw" data-listing_index="' + itemRow + '">';
                html += '<iconify-icon icon="material-symbols:close-rounded"></iconify-icon>';
                html += '</button>';
                html += '</span>';
                html += '</div>';

                html += '<div class="mini_action_table">';
                html += ' <div cols="15" class="hide_discount listing-item inline_disc_div_' + itemRow + '" data-id="' + itemRow + '">';
                html += '                                           <div class="ch-col withclose hide_discount_item">';
                html += '                                               <span>Discount</span>';
                html += '                                              <span class="withIn">';
                var inline_disc_val = 0;
                if (discount_inline_amount != '' && discount_inline_amount != undefined) {
                    inline_disc_val = discount_inline_amount;
                }
                html += '                                                  <input type="text" class="dic_out inline_disc inlineDiscVal_' + rid + ' " value="' + inline_disc_val + '"   data-key="' + rid + '" >';
                html += '                                                  <div class="select_full_se">';
                html += '                                                     <select class="js-states form-control inline_disc_type nosearch common_currency_sel_d inlineDiscType_' + rid + ' "  data-key="' + rid + '" >';
                if (discount_inline_type == 'rupees')
                    html += '                                                         <option value="rupees" data-id="₹" selected >₹</option>';
                else
                    html += '                                                         <option value="rupees" data-id="₹" >₹</option>';
                if (discount_inline_type == '%')
                    html += '                                                         <option value="%" selected >%</option>';
                else
                    html += '                                                         <option value="%">%</option>';

                html += '                                                     </select>';
                html += '                                                 </div>';
                html += '                                            </span>';
                html += '                                            <button class="save_btn apply_inline_discount"  data-key="' + itemRow + '" type="button">';
                html += '                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 16 16"><path fill="none" stroke="currentColor" stroke-linecap="round" color="#5bbe2c" stroke-linejoin="round" stroke-width="1.5" d="m2.75 8.75l3.5 3.5l7-7.5"/></svg>';
                html += '                                            </button>';
                html += '                                            <button class="close_btn remove_inline_discount"  data-key="' + itemRow + '" type="button">';
                html += '                                                 <svg width="24" height="24"';
                html += '                                                     viewBox="0 0 24 24" fill="currentColor" color="#006AFF"';
                html += '                                                    xmlns="http://www.w3.org/2000/svg">';
                html += '                                                    <path';
                html += '                                                       d="M5.35355 4.64645C5.15829 4.45118 4.84171 4.45118 4.64645 4.64645C4.45118 4.84171 4.45118 5.15829 4.64645 5.35355L5.35355 4.64645ZM18.6464 19.3536C18.8417 19.5488 19.1583 19.5488 19.3536 19.3536C19.5488 19.1583 19.5488 18.8417 19.3536 18.6464L18.6464 19.3536ZM4.64645 5.35355L18.6464 19.3536L19.3536 18.6464L5.35355 4.64645L4.64645 5.35355Z">';
                html += '                                                   </path>';
                html += '                                                   <path';
                html += '                                                       d="M19.3536 5.35355C19.5488 5.15829 19.5488 4.84171 19.3536 4.64645C19.1583 4.45118 18.8417 4.45118 18.6464 4.64645L19.3536 5.35355ZM4.64645 18.6464C4.45118 18.8417 4.45118 19.1583 4.64645 19.3536C4.84171 19.5488 5.15829 19.5488 5.35355 19.3536L4.64645 18.6464ZM18.6464 4.64645L4.64645 18.6464L5.35355 19.3536L19.3536 5.35355L18.6464 4.64645Z">';
                html += '                                                   </path>';
                html += '                                               </svg>';
                html += '                                           </button>';
                html += '                                       </div>';
                html += '                                   </div>';
                html += '                                      <span cols="5" class="td-u five-s listing-item" data-id="' + itemRow + '">';
                html += '                                         <button aria-label="Add Edit Discount" title=""';
                html += '                                            class="add_discount add_inline_discount add_inlineDisc_' + itemRow + ' " data-key="' + itemRow + '" type="button">';
                html += '                                            <iconify-icon icon="iconamoon:discount-light"></iconify-icon>';
                html += '                                            Add/Edit Discount';
                html += '                                       </button>';
                html += '                                   </span>';
                var row_deacription = '';
                var is_have_deacription = '';
                var is_have_deacription_style = '';
                var is_show_deacription_clos_btn= '';
                var is_show_deacription_clos_btn_calss= 'hide-d';
                if (itemArray[1]?.row_descrition != '' && itemArray[1]?.row_descrition != undefined) {
                    row_deacription = itemArray[1]?.row_descrition;
                    is_have_deacription = "show";
                    is_have_deacription_style = 'hide-d';
                    is_show_deacription_clos_btn_calss = '';
                    is_show_deacription_clos_btn = "display: block;"
                }

                html += ' <div cols="15" class="hide_option_descandimage2 editrImage_' + itemRow + ' listing-item ' + is_have_deacription + '"> ';


                html += '    <div id="editor1' + itemRow + '">' + row_deacription + '</div>';
                html += ' </div>';
                html += '<span cols="4" class="td-u five-s  listing-item hide_desc_button">';
                html += ' <button aria-label="Add Description" class="openDescription2 '+is_have_deacription_style+'" data-id="' + itemRow + '" type="button" style="">';
                html += '    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">';
                html += '      <g id="plus-square-outline" transform="translate(-.266 .217)">';
                html += '         <g id="Rectangle_1143" fill="rgba(255,255,255,0)" stroke="#006AFF" transform="translate(.266 -.217)">';
                html += '            <rect width="16" height="16" stroke="none" rx="3"></rect>';
                html += '            <rect width="15" height="15" x=".5" y=".5" fill="none" rx="2.5"></rect>';
                html += '        </g>';
                html += '        <g id="Group_588" transform="translate(5.264 4.783)">';
                html += '             <path id="Line_109" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="translate(3)"></path>';
                html += '              <path id="Line_110" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="rotate(90 1.5 4.5)"></path>';
                html += '          </g>';
                html += '       </g>';
                html += '   </svg>';
                html += '    Add Description';
                html += '  </button>';
                html += ' <button aria-label="Add Description" class="closeDescription '+is_show_deacription_clos_btn_calss+'" data-id="' + itemRow + '" type="button" style="'+is_show_deacription_clos_btn+'">';
                html += '    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">';
                html += '      <g id="plus-square-outline" transform="translate(-.266 .217)">';
                html += '         <g id="Rectangle_1143" fill="rgba(255,255,255,0)" stroke="#006AFF" transform="translate(.266 -.217)">';
                html += '            <rect width="16" height="16" stroke="none" rx="3"></rect>';
                html += '            <rect width="15" height="15" x=".5" y=".5" fill="none" rx="2.5"></rect>';
                html += '        </g>';
                html += '        <g id="Group_588" transform="translate(5.264 4.783)">';
                html += '             <path id="Line_109" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="translate(3)"></path>';
                html += '              <path id="Line_110" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="rotate(90 1.5 4.5)"></path>';
                html += '          </g>';
                html += '       </g>';
                html += '   </svg>';
                html += '    Close Description';
                html += '  </button>';
                html += '</span>';
                html += ' <div cols="20" class="hide_option_imageOnly two_op shw_uodr_' + itemRow + ' listing-item">';
                html += '   <div class="upload__box">';
                html += '      <div class="upload__img-wrap"></div>';
                html += '     <div class="upload__btn-box">';
                html += '         <label class="upload__btn">';
                html += '            <p><iconify-icon icon="ion:add"></iconify-icon> Upload Thumbnail</p>';
                html += '           <input type="file" multiple=""  data-max_length="20" class="upload__inputfile invoice_product_image table_media_input_' + itemRow + '" data-main-index=' + itemRow + '>';
                html += '        </label>';
                html += '    </div>';
                html += '  </div>';
                html += ' </div>';
                getProductDbMedia(itemRow);
                html += '<span cols="5" class="td-u five-s listing-item">';
                html += '<button aria-label="Add Thumbnail" class="openthumbnails opetwo shw_thumbnail_btn_' + itemRow + '" data-id="' + itemRow + '" type="button">';
                html += '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16.072 16">';
                html += '<g id="image" transform="translate(0.495 0.495)">';
                html += '<rect id="Rectangle_1144" data-name="Rectangle 1144" width="16" height="16" transform="translate(-0.495 -0.495)" fill="none" opacity="0"></rect>';
                html += '<g id="Rectangle_771" data-name="Rectangle 771" transform="translate(-0.495 -0.495)" fill="none" stroke="#006AFF" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" >';
                html += '<rect width="16" height="16" rx="2" stroke="none"></rect>';
                html += '<rect x="0.5" y="0.5" width="15" height="15" rx="1.5" fill="none"></rect>';
                html += '</g>';
                html += '<circle id="Ellipse_275" data-name="Ellipse 275" cx="1.5" cy="1.5" r="1.5" transform="translate(3.505 3.505)" fill="none" stroke="#006AFF" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" ></circle>';
                html += '<path id="Path_1674" data-name="Path 1674" d="M19.587,14.614,14.973,10,5.426,19.6" transform="translate(-4.718 -4.902)" fill="none" stroke="#006AFF" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" ></path>';
                html += '</g>';
                html += '</svg>';
                html += 'Add Thumbnail';
                html += '</button>';
                html += '</span>';

                html += '<span cols="20" class="td-u tt2-s listing-item">';
                html += '<button aria-label="Add new item" title="Add new item below this item" data-listing_btn="' + itemRow + '" class="addnewcolumn addNewRowBtn" type="button">';
                html += '<svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 20 20" stroke-width="1" fill="none" stroke="currentColor">';
                html += '<path d="M1 8.5V10.2917C1 10.5678 1.22386 10.7917 1.5 10.7917H4.26667M4.26667 10.7917L3.05333 9.325M4.26667 10.7917L3.05333 12.1667M1.5 6H14.5C14.7761 6 15 5.77614 15 5.5V3.5C15 3.22386 14.7761 3 14.5 3H1.5C1.22386 3 1 3.22386 1 3.5V5.5C1 5.77614 1.22386 6 1.5 6ZM7.50057 11.9999H14.5006C14.7767 11.9999 15.0006 11.7761 15.0006 11.4999V9.49991C15.0006 9.22377 14.7767 8.99991 14.5006 8.99991H7.50057C7.22443 8.99991 7.00057 9.22377 7.00057 9.49991V11.4999C7.00057 11.7761 7.22443 11.9999 7.50057 11.9999Z" stroke="#006AFF" stroke-linecap="round" stroke-linejoin="round"></path>';
                html += '</svg>';
                html += 'Insert an item below';
                html += '</button>';
                html += '</span>';
                html += '<span cols="20" class="td-u tt3-s listing-item">';
                if ((itemRow == 0 && $(".loadColumnFieldsOnPage").length > 1) || (parseInt($(".loadColumnFieldsOnPage").length)) > parseInt(itemRow) + 1) {
                    html += '<button shape="circle" aria-label="Move Down" title="Move Down" class="move_down_button show" data-move_down_index="' + itemRow + '" type="button">';
                } else {
                    html += '<button shape="circle" aria-label="Move Down" title="Move Down" class="move_down_button hide-d" data-move_down_index="' + itemRow + '" type="button">';
                }
                html += '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="20" width="20" xmlns="http://www.w3.org/2000/svg">';
                html += '<path d="M99.4 284.9l134 138.1c5.8 6 13.7 9 22.4 9h.4c8.7 0 16.6-3 22.4-9l134-138.1c12.5-12 12.5-31.3 0-43.2-12.5-11.9-32.7-11.9-45.2 0l-79.4 83v-214c0-16.9-14.3-30.6-32-30.6-18 0-32 13.7-32 30.6v214l-79.4-83c-12.5-11.9-32.7-11.9-45.2 0s-12.5 31.2 0 43.2z"></path>';
                html += '</svg>';
                html += '</button>';
                if (itemRow != 0 && itemRow <= (parseInt($(".loadColumnFieldsOnPage").length))) {
                    html += '<button shape="circle" aria-label="Move Up" title="Move Up" class="move_up_button show" data-move_up_index="' + itemRow + '" type="button">';
                } else {
                    html += '<button shape="circle" aria-label="Move Up" title="Move Up" class="move_up_button hide-d" data-move_up_index="' + itemRow + '" type="button">';
                }
                html += '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="20" width="20" xmlns="http://www.w3.org/2000/svg">';
                html += '<path d="M412.6 227.1L278.6 89c-5.8-6-13.7-9-22.4-9h-.4c-8.7 0-16.6 3-22.4 9l-134 138.1c-12.5 12-12.5 31.3 0 43.2 12.5 11.9 32.7 11.9 45.2 0l79.4-83v214c0 16.9 14.3 30.6 32 30.6 18 0 32-13.7 32-30.6v-214l79.4 83c12.5 11.9 32.7 11.9 45.2 0s12.5-31.2 0-43.2z"></path>';
                html += '</svg>';
                html += '</button>';
                html += '</span>';
                html += '</div>';

                if (itemRow > 0) {
                    var htmlMain = '<div class="tbody_column ui-state-default loadColumnFieldsOnPage" data-main_listing_index="' + itemRow + '"></div>';
                    $(htmlMain).insertAfter($("div").find("[data-main_listing_index='" + (parseInt(itemRow) - 1) + "']"));
                }

                $("div").find("[data-main_listing_index='" + itemRow + "']").html(html);
                //$(".loadColumnFieldsOnPage").html(html);
                var gid = $(".item_row_" + itemRow).prevAll().closest('.group_rw_d').last().attr("data-key")
                $(".item_row_" + itemRow).attr("data-group-id", gid);
                $(".item_inp_" + itemRow).attr("data-group-id", gid);
                $(".item_inp_" + itemRow).attr("data-group-name", $("group_nm_" + gid).val());

                showCommonRwInAppendColumn();
                initializeEditor('editor1' + itemRow);
                ImgUpload();
                initializeSuggestionInputNew();
                newRwkey = itemRow;
                calculateRowValues(itemRow);
            }

            $("#loadColumnOnPage").css({
                "grid-template-columns": "repeat(" + cols + ", 1fr)"
            });

            $('.items_view_edit_table').each(function(i, obj) {
                if($(this).hasClass("group_inner_wrapper") && cols > 23){
                    $(this).css({
                        "grid-template-columns": "repeat(23, 1fr)"
                    });
                }else{
                    $(this).css({
                        "grid-template-columns": "repeat(" + cols + ", 1fr)"
                    });
                }
            });

            // $(".items_view_edit_table").css({
            //     "grid-template-columns": "repeat(" + cols + ", 1fr)"
            // });
        });

        $('.loadColumnFieldsOnPage').each(function(i, obj) {
            if ((i == 0 && $(".loadColumnFieldsOnPage").length > 1) || (parseInt($(".loadColumnFieldsOnPage").length)) > parseInt(i) + 1) {
                $("[data-move_down_index='" + i + "']").removeClass("hide-d");
            } else {
                $("[data-move_down_index='" + i + "']").addClass("hide-d");
            }

            if (i != 0 && i <= (parseInt($(".loadColumnFieldsOnPage").length))) {
                $("[data-move_up_index='" + i + "']").removeClass("hide-d");
            } else {
                $("[data-move_up_index='" + i + "']").addClass("hide-d");
            }
        });
    }

    function loadDefaultColumnsForEdit(newJsonArr = '') {

        if (newJsonArr == '') {
            newJsonArr = defaultJson;
        }

        var html = '';
        var key = 0;
        $.each(newJsonArr, function(indKey, item) {
            if (item.class.indexOf("hide-d") >= 0 || item.column_name == "Item" || item.column_name == "item") {

            } else {
                html += '<div class="col_line no-swipe ' + item.class + '">';

                html += '<div class="space_grag handle instant">';
                html += '&nbsp';
                html += '</div>';
                html += '<div class="withprivet">';
                html += '<div class="form-group">';
                html += '<label>';
                html += '<input type="text" required="" data-index="' + key + '" class="column_field_popup " id="" value="' + item.column_name + '" placeholder="' + item.column_name + '">';
                html += '<span>' + item.column_name + '</span>';
                html += '</label>';
                html += '</div>';
                if (item.deletable == 1) {
                    html += '<div class="sd_check">';
                    html += '<input type="checkbox" name="layout" id="private">';
                    html += '<label class="pull-right text" for="private">Make private?</label>';
                    html += '</div>';
                }
                html += '</div>';
                html += '<div class="select_wr">';
                html += '<select class="js-states form-control nosearch column_field_type_popup" data-index="' + key + '">';
                html += '<option value="Text">TEXT</option>';
                html += '<option value="Number">NUMBER</option>';
                html += '</select>';
                html += '</div>';
                html += '<div class="action_btns" data-action_btns_index="' + key + '">';
                if (item.hide == 1) {
                    html += '<button class="hide" data-index="' + key + '"><iconify-icon icon="ph:eye"></iconify-icon>Hide</button>';
                    html += '<button class="unhide show" data-index="' + key + '"><iconify-icon icon="ph:eye-slash"></iconify-icon>Unhide</button>';
                } else {
                    html += '<button class="hide show" data-index="' + key + '"><iconify-icon icon="ph:eye"></iconify-icon>Hide</button>';
                    html += '<button class="unhide" data-index="' + key + '"><iconify-icon icon="ph:eye-slash"></iconify-icon>Unhide</button>';
                }

                if (item.deletable == 1) {
                    html += '<button class="remove removeRowInPopup" data-index="' + key + '"><iconify-icon icon="mingcute:delete-2-line"></iconify-icon> Remove</button>';
                }
                html += '</div>';
                html += '</div>';
                $("#slippylist").html(html);

                $(".js-states.form-control.nosearch").select2({
                    minimumResultsForSearch: Infinity,
                    theme: "bootstrap4",
                });

                key++;
            }
        });
    }

    function listColumnsInPopUpForEdit(newJsonArr = '') {
        if (newJsonArr == '') {
            newJsonArr = defaultJson;
        }
        var html = '<span class="th-b six-s first_item_span">Item</span>';
        $.each(newJsonArr, function(key, item) {
            if (item.column_name == "Item" || item.column_name == "item") {

            } else {
                if (item.column_class.indexOf("hide-d") >= 0) {
                    html += '<span class="th-b two-s hide-d" data-popup_column_index="' + key + '">' + item.column_name + '</span>';
                } else {
                    html += '<span class="th-b two-s" data-popup_column_index="' + key + '">' + item.column_name + '</span>';
                }
            }
        });

        $("#listColumnsInPopUp").html(html);
    }

    function loadColumnOnPageForEdit(newJsonArr = '') {
        var html = '';
        $.each(newJsonArr, function(key, item) {
            var colClass = 'two-s';
            if (key == 0) {
                colClass = 'six-s first_item_span';
            }
            if (item.hide != '1' || item.column_name == "Item" || item.column_name == "item") {
                if (item.column_class.indexOf("Discount") >= 0) {
                    discountShowed = true;
                }
                if (item.column_class.indexOf("amount_column") >= 0) {
                    var hideClass = 'hide-d';
                    if (discountShowed) {
                        hideClass = '';
                    }
                    html += '<span class="th-b two-s discount_th ' + hideClass + '">Discount</span>';
                }

                if (item.column_class.indexOf("Discount") < 0) {
                    html += '<span class="th-b ' + colClass + ' ' + item.column_class + '">' + item.column_name + '</span>';
                }
            }
        });

        html += '<span class="th-b one-s"></span>';

        $("#loadColumnOnPage").html(html);

        $(".first_item_span").html($(".first_item_field").attr("placeholder"));
    }
</script>
@endpush