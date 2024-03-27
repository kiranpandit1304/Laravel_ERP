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
                <div class="page_head forinvoice">
                    <div class="actions_bar">
                        <div class="filter_main">
                            <ul class="main_steps">
                                <li class="">
                                    <span>1</span>
                                    <p> <a href="{{route('fn.invoice_step1', [$enypt_id, $invoice_id])}}">Invoice Details </a></p>
                                </li>
                                <li class="active">
                                    <span>2</span>
                                    <p> <a href="{{route('fn.invoice_step2', [$enypt_id, $invoice_id])}}"> Your Bank Details</a></p>
                                </li>
                                <li class="">
                                    <span>3</span>
                                    <p> <a href="{{route('fn.invoice_step3', [$enypt_id, $invoice_id])}}"> Select Design & Colors</a></p>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            @php
            $showAddform = true;
            if(!empty($bank_details) && count((array)$bank_details)>0){
            $showAddform = false;
            }
            @endphp
            <div id="main_wrapper" class="forinvoice">
                <div class="content_page">
                    <div class="bankDetails">
                        <h3>Your Bank Account Details</h3>
                        <p>This bank detail will be mentioned on the invoice for clients to pay you easily.</p>
                        <div class="title_text show">
                            <h2 class="big_size_noedit">Bank Details</h2>
                        </div>
                        <div class="form_details bankdetails {{$showAddform == true ? 'show' : ''}}">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>
                                        <input type="text" id="ifsc_ivn_code" class="inp_ifsc" placeholder="IFSC">
                                        <span>IFSC</span>
                                    </label>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>
                                        <input type="text" class="inp_account_no" placeholder="Account Number">
                                        <span>Account Number</span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>
                                        <input type="text" class="inp_bank_name" placeholder="Bank Name">
                                        <span>Bank Name</span>
                                    </label>
                                </div>
                                <div class="form-group col-sm-6">
                                    <div class="select-full">
                                        <select class="js-example-placeholder-single-country inp_bank_country_id">
                                            <option value="0">Select Country</option>
                                            @foreach($commonData['countryList'] as $country)
                                            <option value="{{@$country->id}}" {{ $country->id == 101 ? 'selected' : ''}}>{{@$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>
                                        <input type="text" class="inp_iban" placeholder="IBAN">
                                        <span>IBAN</span>
                                    </label>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>
                                        <input type="text" class="swift_code" placeholder="SWIFT Code">
                                        <span>SWIFT Code</span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <div class="select-full">
                                        <select class="js-example-placeholder-single-currency inpt_currency">
                                            <!-- <option value="0" selected>Select Currency</option> -->
                                            <option value="1">Indian Rupee(INR, ₹)</option>
                                            <option value="2">US Dollar(USD, $)</option>
                                            <option value="3">United Arab Emirates Dirham(AED, AED)</option>
                                            <option value="1">Ugandan Shilling(UGX, USh)</option>
                                            <option value="2">Turkmenistan(TMT, T)</option>
                                            <option value="3">Uzbekistan Som(UZS, UZS)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <div class="select-full">
                                        <select class="js-states form-control nosearch inpt_account_type">
                                            <option value="0">Account Type</option>
                                            <option value="1">Current</option>
                                            <option value="2">Savings</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>
                                        <input type="text" class="inp_account_holder_name" placeholder="Account Holder Name">
                                        <span>Account Holder Name</span>
                                    </label>
                                </div>
                                <div class="form-group col-sm-6">
                                    <div class="phone_number">
                                        <div class="prefix">+91</div>
                                        <label>
                                            <input type="text" class="inp_phone_number" placeholder="Your Phone Number">
                                            <span>Your Phone Number</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row bk_detail_div">
                                <div class="form-group col-sm-12">
                                    <label for="" class="big_size_noedit">Custom Bank Details</label>
                                </div>
                            </div>
                            <input type="hidden" class="save_inv_id" value="{{$invoice_id}}" />
                            <input type="hidden" class="bank_detal_db_id" value="" />
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <button class="add_newfield " onclick="appendBankCustomRow(this)"><iconify-icon icon="material-symbols:add-circle-outline-rounded"></iconify-icon> Add New Field</button>
                                </div>
                            </div>
                        </div>
                        <div class="save_bankdetails {{$showAddform == false ? 'show' : ''}} ">
                            <div class="gray_card bank">
                                <div class="gcard_header">
                                    <h3>Bank Accounts</h3>
                                    <a href="javascript:void(0)" onclick="showAddbankForm()" class="shownewbankdetails"><iconify-icon icon="ic:round-add"></iconify-icon> Add New Bank Account</a>
                                </div>
                                <div class="gcard_body bank_detail_body">
                                    @foreach($bank_details as $bank_detail)
                                    <div class="upi_id  bank_rwo_{{@$bank_detail->id}}">
                                        <div class="ali_bank">
                                            <span>
                                                <h6><span><img src="assets/images/SBI-logo.svg" alt=""></span>{{@$bank_detail->bank_name}} <a href="javascript:void(0)" onclick="showBankEditForm(this)" data-id="{{@$bank_detail->id}}"><iconify-icon icon="material-symbols:edit-rounded"></iconify-icon></a></h6>
                                                <h5>{{@$bank_detail->account_holder_name}}</h5>
                                            </span>
                                            <ul>
                                                <li><span>Account No:</span>{{@$bank_detail->account_no}}</li>
                                                <li><span>IFSC:</span>{{@$bank_detail->ifsc}}</li>
                                                <li><span>IBAN:</span>{{@$bank_detail->iban}}</li>
                                            </ul>
                                        </div>
                                        <div class="gaction">
                                            <a href="javascript:void(0)" class="removeUpi" onclick="removeBankDetailRecord(this)" data-id="{{@$bank_detail->id}}">Remove</a>
                                        </div>
                                        <div class="gaction toggle_action inp_show_invoice_type ">
                                            <p>Show in invoice?</p>
                                            <label class="switch">
                                                <input type="checkbox" class="account_activate" value="{{@$bank_detail->id}}" {{@$bank_detail->is_show == 1 ? 'checked' : ''}}>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page_button">
                        <button type="button" class="save_bank_details {{$showAddform == false ? 'hide-d' : ''}} " onclick="saveBankDetail(this)">Save Bank Details</button>
                    </div>
                    <div class="gray_card">
                        <div class="gcard_header">
                            <h3>Your UPI IDs</h3>
                            <a href="javascript:void(0)" class="showNewupi" onclick="showAddUpiForm(this)"><iconify-icon icon="ic:round-add"></iconify-icon> Add New UPI ID</a>
                        </div>
                        <div class="gcard_body upi_body_d">
                            @foreach($upi_details as $upi_detail)
                            <div class="upi_id upi_rwo_{{@$upi_detail->id}}">
                                <h6><span><img src="assets/images/SBI-logo.svg" alt=""></span> {{@$upi_detail->upi_id}}<a href="javascript:void(0)" onclick="showUpiEditForm(this)" data-id="{{@$upi_detail->id}}"><iconify-icon icon="material-symbols:edit-rounded"></iconify-icon></a></h6>
                                <div class="gaction">
                                    <a href="javascript:void(0)" class="removeUpi" onclick="removeUPIDetailRecord(this)" data-id="{{@$upi_detail->id}}">Remove</a>
                                </div>
                                <div class="gaction toggle_action">
                                    <p>Show in invoice?</p>
                                    <label class="switch">
                                        <input type="checkbox" class="upi_id_activate" value="{{@$upi_detail->id}}" {{@$upi_detail->is_active == 1 ? 'checked' : ''}}>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                            <div class="enter_new upi_id show upi_form hide-d">
                                <div class="form-group col-sm-12">
                                    <label for="" class="big_size_noedit ">Enter new UPI Id</label>
                                    <input type="text" class="inp_upi_id">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" class="upi_detal_db_id" />
                        <div class="gcard_footer upi_footer hide-d">
                            <button type="button" class="save_upi_btn" onclick="saveUserUpiID(this)" class="">Save UPI ID</button>
                        </div>
                    </div>
                    <div class="page_button continue">
                        <a href="{{route('fn.invoice_step3', [$enypt_id, $invoice_id])}}"><button type="button" class="">Continue</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('modals')
@include('allFrontendViews.invoice.modals.bill_by_edit_popup')
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
    var statelist = <?= json_encode($commonData['stateList']); ?>;
</script>

<script src="{{asset('js/custom/invoice_step2.js')}}"></script>
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

    $(".js-example-placeholder-single-currency").select2({
        // placeholder: "Select Country",
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
@endpush