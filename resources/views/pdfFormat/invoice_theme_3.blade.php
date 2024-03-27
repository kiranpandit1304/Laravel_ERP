<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.2.0/tailwind.min.css" />
      <?php
      header("Content-type: text/css; charset: UTF-8");
      $color = @$saleInvoice->color;
      ?>
    <style>
       
        /** 
                Set the margins of the pdf page to 0, so the footer and the header
                can be of the full height and width !
             **/
        @page {
            margin: 0cm 0cm;
        }

        /** Define now the real margins of every pdf page in the PDF **/
        body {
           
            margin-left: 0.3cm;
            margin-right: 1cm;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
        }

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 4cm;
        }

        @font-face {
            font-family: DejaVu Sans;
            src: url(path/to/dejavu-font-file.ttf);
        }

        @font-face {
            font-family: 'Poppins', sans-serif;
            src: url("fonts/Poppins-Bold.ttf") format("truetype");
        }

        * {
            font-family: sans-serif;
        }
        
        .theme_color {
            background-color: #fff !important;
        }
        .text_theme_color {
            <?php if (!empty(@$color) && @$color != '') { ?>
                color: <?php echo @$color; ?> !important;
            <?php } else { ?>
                color: #006AFF !important;
            <?php } ?>
            /* color: #ffd95a !important; */
        }
        .table_bg {
            <?php if (!empty(@$color) && @$color != '') { ?>
                background-color: <?php echo @$color; ?> !important;
            <?php } else { ?>
                background-color: #006AFF !important;
            <?php } ?>
        }
        .bank_detail_color {
            <?php if (!empty(@$color) && @$color != '') { ?>
                background-color: <?php echo @$color; ?> !important;
            <?php } else { ?>
                background-color: #006AFF !important;
            <?php } ?>
            /* background-color: rgba(255,217,90,0.9); !important; */
        }
        .bank_detail_color h2,  .upi_details_card h2 {
            <?php if (!empty(@$color) && @$color != '') { ?>
                color: <?php echo @$color; ?> !important;
            <?php } else { ?>
                color: #006AFF !important;
            <?php } ?>
        }
        thead.bank_detail_color tr th {
            color:#000;
        }

        main {
            /* margin-top: 150px; */
            padding: 15px 15px;
            width: 100%;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-family: DejaVu Sans !important;
        }

        .invoice-details .left {
            float: left;
            width: 50%;
        }

        .invoice-details .right {
            float: right;
            width: 50%;
            text-align: right;
        }

        .invoice-hsn-table td {
            padding: 5px 5px 5px 10px;
            border: 1px solid #000;
            text-align: center;
            vertical-align: middle;
            font-size: 14px;
            color: #000;
        }

        .invoice-hsn-table th {
            border: 1px solid #000;
            font-size: 14px;
            text-align: center;
            color: #000;
            font-family: 'Poppins', sans-serif;
        }

        .invoice-hsn-table {
            border: 1px solid #000;
            box-shadow: none;
            margin: 0;
            width: 100%;
            border-radius: 6px;
        }

        .small-item-row {
            display: none;
        }

        th:first-child,
        th:nth-child(2) {
            text-align: center;
        }

        .main_table tr th:first-child {
            padding: 5px 6px; 
            font-size: 14px; 
            border-top-left-radius: 5px;
        }

        .invoice-hsn-table th {
            font-size: 14px;
        }

        h2.title {
            font-size: 32px;
            color: #000;
            margin-bottom: 0px;
        }

        span.subtitle {
            font-size: 14px;
            font-weight: 400;
        }

        .invoice-title {
            background:#000;
            display:inline-block;
            width:auto;
            height:52px;
            margin-bottom:10px;
            color:#fff !important;
            position: relative;
        }
        .invoice-title h2 {
            color:#fff !important;
        }
        .invoice-title span.bg_vbg {
            position: absolute;
            top:0;
            left:-30px;
            width:250px;
            height:70px;
            background:#ffd95a;
            z-index: -1;
            display:inline-block;
        }

        .einvoice {
            padding: 15px;
            padding-top: 10px !important;
            border-radius: 5px;
        }

        .bill_by {
            padding: 15px;
            padding-top: 10px !important;
            border-radius: 5px;
            height: 100px;
        }

        .bill_by h2,
        .bill_to h2,
        .bill_by_sfa h2,
        .bill_to_sfa h2,
        .bill_by_tdetails h2 {
            font-weight: 400 !important;
            line-height: 1.5;
            margin: 0px;
            font-size: 1.25rem;
            cursor: pointer;
            color:#000;
            display: inline-block;
        }

        .bill_by h6,
        .bill_to h6,
        .bill_by_sfa h6,
        .bill_to_sfa h6,
        .bill_by_tdetails h6 {
            font-weight: bold !important;
            font-size: 14px;
            color:#000;
        }

        .bill_by p,
        .bill_to p,
        .bill_by_sfa p,
        .bill_to_sfa p,
        .bill_by_tdetails p {
            font-weight: 400 !important;
            font-size: 14px;
            color:#000;
        }

        .bill_by_tdetails ul li {
            font-weight: bold;
            padding-top: 5px;
            display:block;
        }

        .bill_by_tdetails ul li span {
            font-weight: 400 !important;
            margin-right:10px !important;
        }

        .bill_to {
            text-align: left;
            padding: 15px;
            padding-top: 10px !important;
            border-radius: 5px;
            height: 100px;
        }

        .bill_by_sfa {
            padding: 15px;
            padding-top: 10px !important;
            border-radius: 5px;
            height: 145px;
        }

        .bill_to_sfa {
            text-align: left;
            padding: 15px;
            padding-top: 10px !important;
            border-radius: 5px;
            height: 145px;
        }

        .rightside {
            width: 80px;
            height: 80px;
            display: inline-block;
            float: right;
        }

        .left_bank {
            width:170px;
        }

        .left_numbers_list {
            width:230px;
        }

        .left tr td {
            font-size: 14px;
            font-weight: bold;
            color: #000;
            font-family: 'Poppins', sans-serif !important;
        }

        .left tr td span {
            font-weight: 400;
        }

        .einvoice .left {
            width:auto;
            padding-top:5px;
        }
        
        .einvoice .left ul {
            margin-bottom:0;
        }

        .einvoice .left ul li {
            font-size: 14px;
            color: #000;
            font-weight: 400;
        }

        .einvoice .left ul li span {
            font-weight: 400;
            color: #000;
            width: 100px;
            margin-bottom:-5px;
            display: inline-block;
        }

        .bill_by_tdetails {
            padding: 15px;
            padding-top: 10px !important;
            border-radius: 5px;
            /* height: 150px; */
        }

        table.main_table {
            <?php if (!empty(@$color) && @$color != '') { ?>
                border: 1px solid <?php echo @$color; ?> !important;
            <?php } else { ?>
                border: 1px solid #ffd95a !important;
            <?php } ?>
            border-radius: 5px;
            overflow: hidden;
            margin-top: 10px;
            text-align: center;
            font-family: 'Poppins', sans-serif !important;
        }

        table.main_table tr {
            padding: 7px 9px !important;
        }

        table.main_table tr td {
            padding: 7px 9px !important;
        }

        table.main_table tr td span {
            display: inline !important;
        }

        .bank_details_card {
            padding: 15px;
            border-radius: 10px;
            /* height: 280px; */
            margin-top: 20px;
            margin-bottom: 50px;
            position: absolute;
            top:0;
            width:34%;
        }

        .upi_details_card {
            padding: 15px 0px;
            border-radius: 10px;
            text-align: center;
            display: block;
            /* height: 280px; */
            margin-top: 20px;
            margin-bottom: 50px;
            position: absolute;
            top:0;
            left:42%;
        }

        .bank_details_card h2,
        .upi_details_card h2 {
            font-size: 14px;
            font-weight: bold;
            color: #ffd95a;
        }

        .foot_right {
            padding: 15px 0px;
            /* border-radius: 10px; */
            /* text-align: center; */
            display: block;
            /* height: 280px; */
            margin-top: 20px;
            margin-bottom: 50px;            
            width:100%;
        }

        .bank_details_card button {
            font-size: 18px;
            font-weight: bold;
        }

        .bank_details_card ul {
            margin-top: 15px;
        }

        .bank_details_card ul li span {
            font-weight: bold;
            font-size: 16px;
        }

        .upi_details_card button {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .invoice-hsn-table {
            font-family: DejaVu Sans !important;
        }

        img {
            object-fit: cover !important;
        }

        .main_table {
            <?php if (!empty(@$color) && @$color != '') { ?>
                border: 1px solid <?php echo @$color; ?> !important;
            <?php } else { ?>
                border: 1px solid #ffd95a !important;
            <?php } ?>
        }

        .main_table tr th {
            padding: 5px 6px;
            font-size: 14px;
        }
        .main_table tr td {
            font-size: 14px;
        }
        .main_table tr {
            <?php if (!empty(@$color) && @$color != '') { ?>
                border-right: 1px solid <?php echo @$color; ?> !important;
            <?php } else { ?>
                border-right: 1px solid #ffd95a !important;
            <?php } ?>
        }

        .bank_details_card ul {
            margin-top: 10px;
        }

        .bank_details_card ul li {
            font-size: 14px !important;
            width: 100%;
            color: #000 !important;
            display:inline-block;
        }

        .bank_details_card ul li span {
            font-size: 14px !important;
            font-weight: bold !important;
            width:130px;
            display:inline-block;
        }

        table.other_text tr td {
            font-size: 14px;
            color: #535f6b;
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
        }

        .invoice_numbers_details {
            width:100%;
            position: relative;
            top:-50px;
            left:0;
        }

        .invoice_numbers_details ul li {
            display:inline-block;
            padding-right:20px;
        }

        .main_header_wlogo {
            display:inline-block;
            width:100%;
            position: relative;
        }

        .sm_right {
            float:left !important;
            margin-top: 0;
            width:20%;
        }

        img.main_logo {
            border-radius: 5px; 
            width: 120px; 
            height:auto;
        }

        .title_wsub {
            display:inline-block;
            width:100%;
            text-align:center;
            margin-top:10px;
            margin-bottom:20px;
        }

        span.half_bg_color {
            position: relative;
            top: -20px;
            left: -26px;
            padding:0px 25px;
            width:99.8%;
            <?php if (!empty(@$color) && @$color != '') { ?>
                background-color: <?php echo @$color; ?> !important;
            <?php } else { ?>
                background-color: #006AFF !important;
            <?php } ?>
            z-index: -1;
            display:inline-block;
        }

        td.group_color {
            text-align: left; 
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            padding: 5px 10px; 
            color:#fff;
            <?php if (!empty(@$color) && @$color != '') { ?>
                background-color: <?php echo @$color; ?> !important;
            <?php } else { ?>
                background-color: #006AFF !important;
            <?php } ?>
        }

        .main_header_wlogo .sm_right {
            position: relative;
        }

        .main_header_wlogo .sm_right span.main_logo_bg {
            background: rgba(255, 255, 255, 0.8);
            display:inline-block;
            border-radius:10px;
            position: absolute;
            top:-20px;
            left:0;
            width:135px;
            height:120px;
            z-index: -1;
        }
    </style>
</head>
    @if(!empty($SaleInvoiceAddLetterhead->letterhead_img) && $SaleInvoiceAddLetterhead->letterhead_on_first_page =='1')
    <body style="margin-top: 4.5cm;margin-bottom: 3cm;">
    <header style="margin-bottom:20px;">
        <img class="header_set" style="border-radius: 0px; height:175px;" width="100%" height="100%" alt="letterhead"
            src="{{$SaleInvoiceAddLetterhead->letterhead_img}}">
    </header>
    @endif
    @if(!empty($SaleInvoiceAddFooter->footer_img) && $SaleInvoiceAddFooter->footer_on_last_page =='1')
    <footer  style="margin-top:20px;">
        <img class="" style="border-radius: 0px; height:175px;" width="100%" height="100%" alt=" letterhead footer"
            src="{{$SaleInvoiceAddFooter->footer_img}}">
    </footer>
    @endif
    <body style="">
    <main>
        <span class="half_bg_color">
            <div class="title_wsub">
                <h2 class="title">{{ !empty($saleInvoice->invoice_title) ? $saleInvoice->invoice_title : 'Invoice Title'}}</h2>
                <span class="subtitle">{{@$saleInvoice->invoice_sub_title}}</span>
            </div>

            <div class="main_header_wlogo">
                <div class="sm_right">
                    @if(!empty($copy))                        
                        @if(!empty($copy) && $copy == 'Triplicate')
                        <h2 class="">Triplicate</h2>
                        @else
                        <h2 class="">Duplicate</h2>                              
                        @endif
                    @endif
                    @if(!empty($saleInvoice->business_logo) && $saleInvoice->business_logo != 'undefined' )
                        <img class="main_logo"
                            src="{{$saleInvoice->business_logo}}"
                            alt="" style="z-index: 2; margin-left:10px;" />
                        <span class="main_logo_bg"></span>
                    @endif
                </div>  
                
                <div class="invoice_numbers_details">
                    <ul>
                        <li>
                            <span>{{ !empty($saleInvoice->label_invoice_no) ? $saleInvoice->label_invoice_no : 'Invoice No'}}</span><br/>
                            {{@$saleInvoice->invoice_no}}
                        </li>
                        <li>
                            <span>{{ !empty($saleInvoice->label_invoice_date) ? $saleInvoice->label_invoice_date : 'Invoice Date'}}</span><br/>
                            {{date('F d, Y', strtotime($saleInvoice->invoice_date))}}
                        </li>
                        <li>
                            <span>{{ !empty($saleInvoice->label_invoice_due_date) ? $saleInvoice->label_invoice_due_date : 'Due Date'}}</span><br/>
                            {{date('F d, Y', strtotime($saleInvoice->due_date))}}
                        </li>
                        @php
                        $invoice_custome_filed = json_decode($saleInvoice->invoice_custome_filed)
                        @endphp
                        @if(!empty($invoice_custome_filed))
                        @foreach($invoice_custome_filed as $custome_filed)
                        @if(!empty($custome_filed->value))
                        <li><span>{{$custome_filed->key}}</span><br/> {{$custome_filed->value}}</li>
                        @endif
                        @endforeach
                        @endif
                    </ul>
                </div>
            </div>

            <table class="einvoice theme_color" style="padding-bottom:25px; opacity: 0.8;">
                <tr style="opacity: 2;">
                    <td class="left">
                        <ul>
                            <li><span>IRN:</span>9as9d8as9d85sa98as95d9as5d9</li>
                            <li><span>Ack No:</span>12136456548</li>
                            <li><span>Ack Date:</span>20-03-2023 15:35:00</li>
                        </ul>
                    </td>
                    <td class="right">
                        <div class="rightside">
                            <img style="border-radius: 5px; width: 100%; object-fit: contain;"
                                src="data:image/png;base64,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"
                                alt="">
                        </div>
                    </td>
                </tr>
            </table>

            <table class="invoice-details" style="padding: 10px 0px; height: 110px;">
                <tr>
                    <td class="left" style="padding-right: 5px;">
                        <div class="bill_by theme_color" style="opacity: 0.8;">
                            <table>
                                <tr style="opacity: 2;">
                                    <td>
                                        <h2>{{ !empty($saleInvoice->label_invoice_billed_by) ? $saleInvoice->label_invoice_billed_by : 'Billed By'}}</h2>
                                        <h6>{{@$saleInvoice->company_name}}</h6>
                                        <p>{{@$saleInvoice->company_address}}</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td class="right" style="padding-left: 5px;">
                        <div class="bill_to theme_color" style="opacity: 0.8;">
                            <table>
                                <tr style="opacity: 2;">
                                    <td>
                                        <h2>{{ !empty($saleInvoice->label_invoice_billed_to) ? $saleInvoice->label_invoice_billed_to : 'Billed To'}}</h2>
                                        <h6>{{@$saleInvoice->customer_name}}</h6>
                                        <p>{{@$saleInvoice->customer_address}}</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
            @if($saleInvoice->is_shipping_detail_req)
            <table class="invoice-details" style="padding-bottom: 10px; height: 110px;">
                <tr>
                    <td class="left" style="padding-right: 5px;">
                        <div class="bill_by_sfa theme_color" style="opacity: 0.8;">
                            <table>
                                <tr style="opacity: 2;">
                                    <td>
                                        <h2 style="font-size: 18px; font-weight: bold;">{{ !empty($saleInvoice->label_invoice_shipped_from) ? $saleInvoice->label_invoice_shipped_from : 'Shipped From'}}</h2>
                                        <h6>{{@$saleInvoice->shipped_from_name}}</h6>
                                        <p>
                                            {{@$saleInvoice->shipped_from_address}}<br />
                                            {{@$saleInvoice->shipped_from_state_name}} {{@$saleInvoice->shipped_from_city}} - {{@$saleInvoice->shipped_from_zip_code}} {{@$saleInvoice->shipped_from_country_name}}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td class="right" style="padding-left: 5px;">
                        <div class="bill_to_sfa theme_color" style="opacity: 0.8;">
                            <table>
                                <tr style="opacity: 2;">
                                    <td>
                                        <h2 style="font-size: 18px; font-weight: bold;">{{ !empty($saleInvoice->label_invoice_shipped_to) ? $saleInvoice->label_invoice_shipped_to : 'Shipped To'}}</h2>
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
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
            @if(!empty($saleInvoice->transport_name) || !empty($saleInvoice->transport_challan))
            <table class="invoice-details" style="padding-bottom: 10px; height: 150px; margin-top:0px;">
                <tr>
                    <td class="left" style="padding-right: 0px;">
                        <div class="bill_by_tdetails theme_color" style="opacity: 0.8;">
                            <table>
                                <tr style="opacity: 2;">
                                    <td>
                                        <h2>{{ !empty($saleInvoice->label_invoice_transport_details) ? $saleInvoice->label_invoice_transport_details : 'Transport Details'}}</h2>
                                        <ul style="font-weight: bold;">
                                            <li><span>{{ !empty($saleInvoice->label_invoice_transport ) ? $saleInvoice->label_invoice_transport  : 'Transport'}}:</span>{{@$saleInvoice->transport_name}}</li>
                                            <li><span>{{ !empty($saleInvoice->label_invoice_challan_date ) ? $saleInvoice->label_invoice_challan_date  : 'Challan Date'}} :</span>{{ !empty($saleInvoice->transport_challan_date) && $saleInvoice->transport_challan_date!='undefined' ?  date('F d, Y', strtotime($saleInvoice->transport_challan_date)) : ''}}</li>
                                            <li><span>{{ !empty($saleInvoice->label_invoice_challan_no ) ? $saleInvoice->label_invoice_challan_no  : 'Challan Number'}}:</span>{{@$saleInvoice->transport_challan}}</li>
                                            <li><span>{{ !empty($saleInvoice->label_invoice_extra_information ) ? $saleInvoice->label_invoice_extra_information  : 'Extra Information'}} :</span>{{@$saleInvoice->transport_information}}</li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
            @endif
            @endif
        </span>
         @php
        $gindex = 0;
        $pindex = 0;
        $saleInvoiceAllData = json_decode($saleInvoice->filed_data);
        @endphp
        <table class="main_table">
            <thead>
                <tr class="table_bg" style="color: #fff;">
                    <th style="border-top-left-radius: 5px;" width="10" aria-label="Item Number"></th>
                   <?php                  
                      $l_count = count($saleInvoiceAllData[0]->data);//count((array)$saleInvoiceAllData[0]); 
                      $v_count = count($saleInvoiceAllData[0]->data);//count((array)$saleInvoiceAllData[0]); 
                    ?>
                    @foreach($saleInvoiceAllData[0]->data as $key=>$data)
                     @if(@$l_count <= 10)
                        @if(@$data->hide != 1)
                            @if($key == 0)
                                <th style="text-align: left;">{{$data->column_name}}</th>
                            @elseif($key == (count($saleInvoiceAllData[0]->data)-1))
                                <th style="border-top-right-radius: 5px;">Total</th>
                            @else
                                <th style="">{{$data->column_name}}</th>
                            @endif
                        @endif
                        @endif
                    @endforeach
                </tr>
            </thead>
            <tbody>
            @foreach($saleInvoiceAllData as $key=>$invoiceProduct)
            <!-- ...group listing -->
            @if($v_count <= 10)
            @if($invoiceProduct->is_group==1)
            <?php $gindex=0; ?>
            <tr class="item-group-row full-width hide-background">
                    <!-- <td width=""></td> -->
                     <?php $g_count = @$v_count + 1; ?>
                    <td colspan="{{@$g_count}}" class="group_color"><?= $invoiceProduct->data[1]->field_val ?></td>
                
                @foreach($invoiceProduct->data[1]->fields as $key=>$fieldsData)
                <?php $gindex++; ?>
                    @if($number % 2 == 0)
                        <tr class="alternate">
                            @else
                        <tr>
                    @endif
                    @foreach($fieldsData as $key=>$data)
                        @if(@$data->hide != 1)
                            @if($key == 0)
                                <td width="10">{{$gindex}}.</td>
                                <?php  $item_name = explode('(',$data->field_val);?>
                                <td style="padding: 4px 6px; text-align: left;" width="87">{{$item_name[0]}}</td>
                            @else
                                <td style="padding: 4px 6px;" width="31">{{$data->field_val}}</td>
                            @endif
                        @endif
                    @endforeach
            </tr>
            <?php $description = \App\Helpers\CommonHelper::getDecription(@$invoice_id, @$fieldsData[1]->main_index); ?>
            @if(!empty($description))

            <tr style="padding: 4px 6px;">
                    <td></td>
                    <td style="padding: 4px 4px; text-align: left;" colspan="{{@$v_count}}">
                    <div class="sc-hBbWxd hYJyQg">
                        <div>
                            <div class="toastui-editor-contents" style="overflow-wrap: break-word;">
                                <p style="font-size: 14px;" data-nodeid="3">
                                    {{$description->product_description}}
                                </p>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endif

            <?php $SaleInvoiceMedia = \App\Helpers\CommonHelper::getProductMedia(@$invoice_id, @$fieldsData[1]->main_index, @$invoiceProduct->data[0]->field_product_id, @$advanceSetting->add_original_images); ?>
            @if(!empty($SaleInvoiceMedia['get_product_media']))
            @foreach($SaleInvoiceMedia['get_product_media'] as $groupt_img)
            @if(!empty($groupt_img['invoice_product_image']))
            <tr style="padding: 4px 6px; text-align: left;">
                    <td></td>
                    <td style="padding: 4px 4px;" colspan="{{@$v_count}}"><a href="{{@$groupt_img['invoice_product_image']}}" target="_blank" rel="noopener noreferrer" style="padding: 0px 15px;"><img height="40" width="40" alt="{{@$groupt_img['invoice_product_image']}}" src="{{@$groupt_img['invoice_product_image']}}" srcset="{{@$groupt_img['invoice_product_image']}}" /></a>
                </td>
            </tr>
            @endif
            @endforeach
            @endif
            <!---- main group img -->
            @if(!empty($SaleInvoiceMedia['get_original_images']) && @$advanceSetting->add_original_images == 1)
            @foreach($SaleInvoiceMedia['get_original_images'] as $product_img)
            <!-- <tr style="padding: 4px 6px; text-align: left;">
                    <td></td>
                    <td style="padding: 4px 4px;" colspan="100"><a href="{{@$product_img['product_image']}}" target="_blank" rel="noopener noreferrer" style="padding: 0px 15px;"><img height="40" width="40" alt="{{@$product_img['product_image']}}" src="{{@$product_img['product_image']}}" srcset="{{@$product_img['product_image']}}" /></a>
                </td>
            </tr> -->
            @endforeach
            @endif
            <!-- end group media -->

            @endforeach

            <tr class="large-item-row aside-collpased gst-invoice strong alternate">
                <td width="10"></td>
                @foreach($invoiceProduct->data[1]->fields as $key=>$fieldsData)
                    @if($key == 0)
                    <td class="" width="10" style="text-align:left !important;"><span class=""><b>Sub total</b></span></td>
                    @foreach($fieldsData as $key=>$data)
                        @if($data->hide == 0)
                            @if($key != 0)
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
                    @endforeach
                    @endif
                @endforeach
            </tr>
            @else
            <!-- ...product listing -->
            <?php $idnx = 1; ?>
            <?php $pindex++; ?>
            @foreach($invoiceProduct as $key=>$fieldsData)
            @if($number % 2 == 0)
            <tr class="alternate">
                @else
            <tr>
                @endif
                @foreach($fieldsData as $key=>$data)
                    @if(@$data->hide != 1)
                        @if($key == 0)
                            <td width="10">{{$pindex}}.</td>
                             <?php  $item_name = explode('(',$data->field_val);?>
                            <td style="padding: 4px 6px; text-align: left;" width="87">{{$item_name[0]}}</td>
                        @else
                            <td style="padding: 4px 6px;" width="30">{{$data->field_val}}</td>
                        @endif
                    @endif
                @endforeach
            </tr>
            <?php $description = \App\Helpers\CommonHelper::getDecription(@$invoice_id, @$fieldsData[1]->main_index); ?>
            @if(!empty($description))
             <tr style="padding: 4px 6px;">
                    <td></td>
                    <td style="padding: 4px 4px; text-align: left;" colspan="{{@$v_count}}">
                        <div class="sc-hBbWxd hYJyQg">
                        <div>
                            <div class="toastui-editor-contents" style="overflow-wrap: break-word;">
                                <p style="font-size: 14px;" data-nodeid="3">
                                    {{$description->product_description}}
                                </p>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endif
            <?php $SaleInvoiceMedia = \App\Helpers\CommonHelper::getProductMedia(@$invoice_id, @$fieldsData[1]->main_index, @$invoiceProduct->data[0]->field_product_id, @$advanceSetting->add_original_images); ?>
            @if(!empty($SaleInvoiceMedia['get_product_media']))
            @foreach($SaleInvoiceMedia['get_product_media'] as $product_img)
            @if(!empty($product_img['invoice_product_image']))
            <tr style="padding: 4px 6px; text-align: left;">
                    <td></td>
                    <td style="padding: 4px 4px;" colspan="{{@$v_count}}"><a href="{{@$product_img['invoice_product_image']}}" target="_blank" rel="noopener noreferrer" style="padding: 0px 15px;"><img height="40" width="40" alt="{{@$product_img['invoice_product_image']}}" src="{{@$product_img['invoice_product_image']}}" srcset="{{@$product_img['invoice_product_image']}}" /></a>
                </td>
            </tr>
            @endif
            @endforeach
            @endif
            <!---- main img -->
            @if(!empty($SaleInvoiceMedia['get_original_images']) && @$advanceSetting->add_original_images == 1)
            @foreach($SaleInvoiceMedia['get_original_images'] as $product_img)
            @if(!empty($product_img['product_image']))
            <!-- <tr style="padding: 4px 6px; text-align: left;">
                <td></td>
                <td style="padding: 4px 4px;" colspan="100"><a href="{{@$product_img['product_image']}}" target="_blank" rel="noopener noreferrer" style="padding: 0px 15px;"><img height="40" width="40" alt="{{@$product_img['product_image']}}" src="{{@$product_img['product_image']}}" srcset="{{@$product_img['product_image']}}" /></a>
                </td>
            </tr> -->
            @endif
            @endforeach
            @endif
            <!-- ..end media -->
            @endforeach
            <!-- end product listing -->
            @endif
            @endif
            @endforeach

            <!-- ..Grand total -->
            @if($saleInvoice->final_summarise_total_quantity == 1)
            @php $grand_toalValues = end($saleInvoiceAllData); @endphp
            <tr class="large-item-row aside-collpased gst-invoice strong alternate">
                <td width="10"></td>
                @foreach($saleInvoiceAllData[0]->data as $key=>$data)
                @if($key == 0)
                
                <td class="" style="text-align:left !important;" width="10"><span class=""><b>Total</b></span></td>
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
                @endforeach
            </tr>
            @endif
            <!-- END grand total... -->
            <!-- <tr class="item-name-row item-group-row full-width">
                <td colspan="100" class="" style="text-align: left; background: #F7EEFF; font-weight: 600;">Product</td>
            </tr> -->
        </tbody>
        </table>
        @if($saleInvoice->is_total_words_show == 1)
        <table>
            <tr>
                <td>
                    <div class="invoice-total-in-words-wrapper">
                        <p>
                            <span class="invoice-total-in-words-title">Total (in words) :</span>
                            <span class="invoice-total-in-words">{{@$saleInvoice->final_total_words}}</span>
                        </p>
                    </div>
                </td>
            </tr>
        </table>
        @endif
        <table class="invoice-details" style="padding: 0px 0px; position:relative;">

            <tr>
            @if(!empty($SaleInvoiceSetting->is_bank_detail_show_onInv) && $SaleInvoiceSetting->is_bank_detail_show_onInv == 1)
            @if(!empty($SaleInvoiceBankDetails->account_holder_name) || !empty($SaleInvoiceBankDetails->account_no) || !empty($SaleInvoiceBankDetails->ifsc) || !empty($SaleInvoiceBankDetails->bank_name) )
                <td class="left_bank" style="padding-right: 10px;">
                    <div class="bank_details_card bank_detail_color" style="opacity: 0.1;">
                        <table>
                            <tr style="opacity: 2;">
                                <td>
                                    <h2>Bank Details</h2>
                                    <ul class="bank_detail_mdle_div">
                                        <li><span>Account Holder Name</span> {{@$SaleInvoiceBankDetails->account_holder_name}}</li>
                                        <li><span>Account Number</span> {{@$SaleInvoiceBankDetails->account_no}}</li>
                                        <li><span>IFSC</span> {{@$SaleInvoiceBankDetails->ifsc}}</li>
                                        <li><span>IBAN</span> {{@$SaleInvoiceBankDetails->iban}}</li>
                                        <li><span>Account Type</span> <?php if ($SaleInvoiceBankDetails->account_type == '1') {
                                            echo 'Current';
                                        } elseif ($SaleInvoiceBankDetails->account_type == '2') {
                                            echo 'Savings';
                                        } else {
                                            echo '';
                                        } ?></li>
                                        <li><span>Bank</span> {{@$SaleInvoiceBankDetails->bank_name}}</li>
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
                <!-- endif -->
                @endif
                @endif
                <td class="center" style="padding-right: 10px; width: 33%;">
                    @if(!empty($SaleInvoiceSetting->is_upi_detail_show_onInv) && $SaleInvoiceSetting->is_upi_detail_show_onInv == 1)
                    @if(!empty($SaleInvoiceBankUpi->upi_id))
                    <div class="upi_details_card">
                        <h2>UPI - Scan to Pay</h2><br/>
                        <span style="width: 120px; height: 120px; display: inline-block;">
                            <img style="border-radius: 10px; width: 100%; object-fit: contain;"
                                src="{{ @$SaleInvoiceQrCode->qr_image }}"
                                style="margin-bottom: 15px;" alt="">
                            <p>{{@$SaleInvoiceBankUpi->upi_id}}</p>
                        </span>
                    </div>
                    @endif
                    @endif
                </td>
                <td class="right" style="padding-left: 0px;">
                    <div class="foot_right" style="text-align: left;">
                        <table style="font-size: 14px; color:#000;">
                        <tr>
                            <td style="padding-bottom: 3px;">Amount</td>
                            <td style="padding-bottom: 3px;"><span style="font-family: DejaVu Sans !important;">₹</span>{{ !empty($saleInvoice->final_amount) && $saleInvoice->final_amount!='undefined' ? $saleInvoice->final_amount : '0'}}</td>
                        </tr>
                        @if($saleInvoice->is_tax == 'IGST')
                        <tr>
                            <td style="padding-bottom: 3px;">SGST</td>
                            <td style="padding-bottom: 3px;"><span style="font-family: DejaVu Sans !important;">₹</span> {{ !empty($saleInvoice->final_igst) && $saleInvoice->final_igst!='undefined' ? $saleInvoice->final_igst : '0'}}</td>
                        </tr>
                         @else
                        <tr>
                            <td style="padding-bottom: 3px;">SGST</td>
                            <td style="padding-bottom: 3px;"><span style="font-family: DejaVu Sans !important;">₹</span>{{ !empty($saleInvoice->final_sgst) && $saleInvoice->final_sgst!='undefined' ? $saleInvoice->final_sgst : '0'}}</td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 3px;">CGST</td>
                            <td style="padding-bottom: 3px;"><span style="font-family: DejaVu Sans !important;">₹</span>{{ !empty($saleInvoice->final_cgst) && $saleInvoice->final_cgst!='undefined' ? $saleInvoice->final_cgst : '0'}}</td>
                        </tr>
                         @endif
                            @php
                            $totalWithTax = $saleInvoice->final_amount + $saleInvoice->final_igst;
                            @endphp

                            @if(!empty($saleInvoice->final_total_discount_reductions) && $saleInvoice->final_total_discount_reductions!='undefined' )
                            <?php if ($saleInvoice->final_total_discount_reductions_unit == '%') {
                                $total_dic = ($saleInvoice->final_total_discount_reductions / 100) * $totalWithTax;
                            } else {
                                $total_dic = $saleInvoice->final_total_discount_reductions;
                            } ?>
                        <tr>
                            <td style="padding-bottom: 5px;">Reductions</td>
                            <td style="padding-bottom: 5px;"><span style="font-family: DejaVu Sans !important;">₹</span>({{@$saleInvoice->final_total_discount_reductions}} {{@$saleInvoice->final_total_discount_reductions_unit }})<span>({{$total_dic}})</span></td>
                        </tr>
                         @endif
                        @if(!empty($saleInvoice->final_extra_charges) && $saleInvoice->final_extra_charges!='undefined')
                        @php
                        if($saleInvoice->extra_changes_unit == '%')
                        $total_extra = ($saleInvoice->final_extra_charges / 100) * $totalWithTax;
                        else
                        $total_extra = $saleInvoice->final_extra_charges;
                        @endphp
                        <tr>
                            <td style="padding-bottom: 5px;">Extra Charges</td>
                            <td style="padding-bottom: 5px;"><span style="font-family: DejaVu Sans !important;">₹</span>({{@$saleInvoice->final_extra_charges }} {{@$saleInvoice->extra_changes_unit }}) <span> {{ $total_extra}} </span></td>
                        </tr>
                        @endif
                        <tr style="border-top: 1px solid #000;
                    border-bottom: 1px solid #000;
                    font-size: 18px;
                    font-weight: bold;                    
                    <?php if (!empty(@$color) && @$color != '') { ?>
                background-color: <?php echo @$color; ?> !important;
            <?php } else { ?>
                background-color: #006AFF !important;
            <?php } ?>
            padding:0px 10px;
                color:#fff;
                    font-family: DejaVu Sans !important;
                    margin-top: 15px;">
                            <td style="padding-bottom: 5px;">Total (INR)</td>
                            <td style="padding-bottom: 5px;"><span
                                    style="font-family: DejaVu Sans !important; font-weight: normal;">₹</span>{{@$saleInvoice->final_total}}
                            </td>
                        </tr>
                        @if(@$saleInvoice->payment_status != 'Unpaid')
                            @php
                            $final_total = (!empty($saleInvoice->final_total) ? $saleInvoice->final_total : 0);
                            $grand_total_paid = $amount_recived_sum + $total_tcs_amount + $total_tds_amount + $total_transaction_charge;
                            $due_amount = (float)$final_total - (float)$grand_total_paid;

                            @endphp
                            @if(!empty($amount_recived_sum))
                            <tr>
                                <td style="padding-bottom: 5px;">Amount Paid</td>
                                <td style="padding-bottom: 5px;"><span style="font-family: DejaVu Sans !important;">₹</span><span>{{$amount_recived_sum}} </span></td>
                            </tr>
                             @if(!empty($total_transaction_charge))
                             <tr>
                                <td style="padding-bottom: 5px;">Transaction Charge</td>
                                <td style="padding-bottom: 5px;"><span style="font-family: DejaVu Sans !important;">₹</span><span>{{$total_transaction_charge}} </span></td>
                            </tr>
                            @endif

                            @if(!empty($total_tds_amount))
                             <tr>
                                <td style="padding-bottom: 5px;">TDS</td>
                                <td style="padding-bottom: 5px;"><span style="font-family: DejaVu Sans !important;">₹</span><span>{{$total_tds_amount}} </span></td>
                            </tr>
                            @endif

                            @if(!empty($total_tcs_amount))
                             <tr>
                                <td style="padding-bottom: 5px;">TCS</td>
                                <td style="padding-bottom: 5px;"><span style="font-family: DejaVu Sans !important;">₹</span><span>{{$total_tcs_amount}} </span></td>
                            </tr>
                            @endif
                            @if(!empty(@$due_amount))
                            <tr style="border-top: 1px solid #000;
                            border-bottom: 1px solid #000;
                            font-size: 18px;
                            font-weight: bold;
                            font-family: DejaVu Sans !important;
                            margin-top: 15px;">
                                    <td style="padding-bottom: 5px;">Due Amount</td>
                                    <td style="padding-bottom: 5px;"><span
                                            style="font-family: DejaVu Sans !important; font-weight: normal;">₹</span>{{@$due_amount}}
                                    </td>
                                </tr>
                            @endif
                        @endif
                        @endif
                    </table>
                        @php
                        $bottom_final_filed = json_decode($saleInvoice->final_total_more_filed)
                        @endphp
                        @if(!empty($bottom_final_filed))
                        <table border="0" class="invoice-table invoice-extra-total-table" style="margin-top: 5px;">
                        <tbody style="font-size: 14px; padding: 0;
                        font-weight: bold; text-align: left; width: 100%;">
                        @foreach($bottom_final_filed as $custome_filed)
                        @if(!empty($custome_filed->value))
                        <tr align="left">
                            <th>{{$custome_filed->key}} </th>
                            <td>{{$custome_filed->value}}</td>
                        </tr>
                        @endif
                        @endforeach
                         </tbody>
                        </table>
                        @endif
                        @if(!empty($SaleInvoiceSetting->s3_signature_url))
                        <table style=" margin-bottom: 10px;">
                            <tr>
                                <td>
                                    <div class="signature logo-wrapper" style="text-align: center;">
                                        <img alt=""
                                            src="{{$SaleInvoiceSetting->s3_signature_url}}" srcset="{{$SaleInvoiceSetting->s3_signature_url}}">
                                        <span>{{@$SaleInvoiceSetting->signature_labed_name}}</span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        @endif
                    </div>
                </td>
            </tr>
        </table>
        @if(!empty($advanceSetting) && $advanceSetting->show_hsn_summary == '1')
         <table class="invoice-hsn-table" cellpadding="0" cellspacing="0">
            <thead class="bank_detail_color" style="opacity:0.1 !important;">
                <tr class="no-pdf small-item-row">
                    <th colspan="2">HSN Summary</th>
                </tr>
                <tr class="large-item-row aside-collpased">
                    <th style="">HSN</th>
                    <th style="">Taxable Value</th>
                    @if($saleInvoice->is_tax == 'IGST')
                    <th style="" colspan="2">IGST</th>
                    @elseif($saleInvoice->is_tax == 'CGST')
                    <th style="" colspan="2">CGST</th>
                    <th style="" colspan="2">SGST</th>
                    @endif
                    <th style="">Total</th>
                </tr>
                <tr class="large-item-row aside-collpased">
                    <th aria-label="Empty"></th>
                    <th aria-label="Empty"></th>
                    @if($saleInvoice->is_tax == 'IGST')
                    <th style="">Rate</th>
                    <th style="">Amount</th>
                    @elseif($saleInvoice->is_tax == 'CGST')
                    <th style="">Rate</th>
                    <th style="">Amount</th>
                    <th style="">Rate</th>
                    <th style="">Amount</th>
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
                <td> {{$hsnDetails->product_rate}} </td>
                <?php
                $product_total = !empty($hsnDetails->product_rate) ? $hsnDetails->product_rate : 0;
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
    @endif
    @php $termconditions = json_decode($saleInvoice->terms_and_conditions); @endphp
    @if(!empty($termconditions) && !empty($termconditions[0]) && $termconditions[0] != 'Write here..')                      
    <table style="margin-bottom: 0; padding: 10px 0px;" class="other_text">
        <tr>
        <td class="text_theme_color" style="font-size: 18px; font-weight: bold;" colspan="2">{{ !empty($saleInvoice->label_invoice_terms_and_conditions) ? $saleInvoice->label_invoice_terms_and_conditions : 'Terms and Conditions'}}</td>
        </tr>
            <?php $i = 1; ?>
            @foreach ($termconditions as $key => $value)
            @if($value != 'Write here..')
            <tr>
                <td>{{ @$i }} {{ @$value }}</td>
            </tr>
            <?php $i++; ?>
            @endif
            @endforeach
        </tr>
    </table>
    @endif
    @if(!empty($saleInvoice->additional_notes))
    <table style="padding: 10px 0px; margin-bottom: 10px;" class="other_text">
        <tr>
            <td>
                <div class="tandc adnote">
                <h2 class="text_theme_color" style="font-size: 18px; font-weight: bold;">{{ !empty($saleInvoice->label_invoice_additional_notes) ? $saleInvoice->label_invoice_additional_notes : 'Additional Notes' }}</h2>
                    <ul>
                        <li>{{@$saleInvoice->additional_notes}}</li>
                    </ul>
                </div>
            </td>
        </tr>
    </table>
     @endif

    <?php $add_additional_info = json_decode($saleInvoice->add_additional_info); ?>
    @if(!empty($add_additional_info))
    <table border="0" class="" style="padding: 10px 0px;" class="other_text">
        <tbody>
            <tr>
                <th class="text_theme_color" style="width: 35%; font-size: 18px; font-weight: bold; text-align: left;">
                 {{ !empty($saleInvoice->additional_info_label) ? $saleInvoice->additional_info_label : 'Additional info' }}</th>
                @if(!empty($add_additional_info))
                @foreach($add_additional_info as $info)
                <tr>
                    <td style="width: 23%;">{{@$info->key}}</td>
                    <td>{{@$info->value}}</td>
                </tr>
            @endforeach
            @endif
            </tr>
        </tbody>
    </table>
     @endif
    @if(!empty($SaleInvoiceAttachments_data) && $SaleInvoiceAttachments_data!= '[]')
    <table style="padding: 10px 0px;" class="other_text">
        <tr>
            <td>
                <div class="tandc">
                    <h2 class="text_theme_color" style="font-size: 18px; font-weight: bold;">{{ !empty($saleInvoice->label_invoice_attachments) ? $saleInvoice->label_invoice_attachments : 'Attachments'}}</h2>
                    @foreach($SaleInvoiceAttachments_data as $key=>$data)
                    <div class="attachment-link-wrapper">
                        <div class="attachment-link"><span>{{$key+1}}.</span><span>&nbsp;</span><a href="{{$data->invoice_attachments}}" target="_blank" rel="noopener noreferrer">{{$data->invoice_attachments_name}}</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </td>
        </tr>
    </table>
    @endif
    @if($saleInvoice->is_contact_show==1 && !empty($saleInvoice->contact_details))
    <table style="padding: 10px 0px; text-align: center;">
            <tr>
                <td>
                    <div class="tandc contact_details">
                        <div class="invoice-contact-wrapper" style="font-size: 16px;">
                            <!-- <span>For any inquiries, reach out via</span>
                            <span>email at <b>mansuri.jafar7@gmail.com</b>, <br />call on</span>
                            <span class="phone-input"><b>+91 98659 95465</b></span> -->
                            {{$saleInvoice->contact_details}}
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    @endif
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>