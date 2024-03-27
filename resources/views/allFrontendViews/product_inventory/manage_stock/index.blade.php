<div class="modal fade twoside_modal same_cr_ec no_overlay" id="adjustStockPopup" role="dialog" aria-labelledby="adjustStockPopupLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close close_st_btn" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="shinvite">
                            <div class="shi_header">
                                <h5>Adjust Stock</h5>
                                <a href="#"><iconify-icon icon="ph:info"></iconify-icon></a>
                            </div>
                            <form action="javascript:void(0)" id="adjStockForm_d" method="post">
                                <div class="shi_body">
                                    <h3 class="st_title_name">Printed T-shirt</h3>
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link method_type_d stk_tab_type active" data-type="1" data-id="add_stock" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 20 20" color="#733dd9" fill="none" stroke="currentColor" stroke-width="1">
                                                    <path d="M1.5 5H7.55275C10.7473 5 13.2692 7.53846 13.2692 10.7538L13.2692 16M13.2692 16L7.81429 10.7538M13.2692 16L18.5 10.7538" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" stroke="#733dd9"></path>
                                                </svg> Incoming</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link method_type_d stk_tab_type" data-type="2" data-id="minus_stock" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 20 20" color="#733dd9" fill="none" stroke="currentColor" stroke-width="1">
                                                    <path d="M4.5 19L4.5 12.9473C4.5 9.75275 7.03846 7.23077 10.2538 7.23077L15.5 7.23079M15.5 7.23079L10.2538 12.6857M15.5 7.23079L10.2538 2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" stroke="#733dd9"></path>
                                                </svg> Outgoing</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent-2">
                                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group end ">
                                                        <select class="js-example-placeholder-single-cuntry js-states stk_variation_id" data-type="group_item" id="listvarisk1" name="variate_id" aria-placeholder="Variate">
                                                            <option value="" selected>Variation</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 mt-3">
                                                    <div class="form-group qspan end withtag">
                                                        <label>
                                                            <div class="prefix">KG</div>
                                                            <input type="number" name="quantity" class="quantity_d" placeholder="Adjust Quantity" required>
                                                            <span>Adjust Quantity</span>
                                                        </label>
                                                        <!-- <span class="sid_fix">KG</span> -->
                                                        <span class="gray_small">Enter the number of new items which you purchased</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group end">
                                                        <!-- <select class="ddl-select stk_vendor_id" id="liststk1" name="vendor_id" aria-placeholder="Vendor/Client"> -->
                                                        <select class="js-example-placeholder-single-cuntry js-states stk_vendor_id" id="liststk1" name="vendor_id" aria-placeholder="Vendor/Client">
                                                            <option value="" selected>Vendor/Client</option>
                                                            @foreach($vend_cutomers as $data)
                                                            <option value="{{@$data['id']}}" data-type="{{@$data['user_type']}}">{{@$data['name']}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 mt-3">
                                                    <div class="form-group end">
                                                        <!-- <select class="ddl-select adjust_reason_d" id="liststk2" name="adjust_reason" aria-placeholder="Reason to adjust"> -->
                                                        <select class="js-states form-control nosearch adjust_reason_d" id="liststk2" name="adjust_reason" aria-placeholder="Reason to adjust">
                                                            <option value="" selected>Reason to adjust</option>
                                                            <option value="Purchased">Purchased</option>
                                                            <option value="Returned">Returned</option>
                                                            <option value="AdjustStock">Adjust stock</option>
                                                            <option value="Other">Other</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 mt-1 ">
                                                    <div class="form-group end">
                                                        <!-- <label>Reason</label> -->
                                                        <label>
                                                            <textarea class=" form-control custom_adjust_reason_d hide-d" name="custom_reason" placeholder="Write you reason here" style="border: 1px solid #ced4da;"></textarea>
                                                            <span>Write you reason here</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row custom_field">
                                                <div class="col-lg-4">
                                                    <input type="text" class="stk_custom_key" placeholder="Field Name">
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="form-group">
                                                        <input type="text" class="stk_custom_value" placeholder="value">
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" class="method_type_inp_d" value="1" placeholder="">
                                            <input type="hidden" class="product_inp_d" placeholder="">
                                            <input type="hidden" class="adjustment_inp_d" placeholder="">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <button onclick="addCustomField(this)" class="add_line add_more add_field" type="button">
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
                                                        Add Custom Field
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="shi_footer">
                                        <button id="ch_to_table" class="done_btn" onclick="addNewStock(this)">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('custom-scripts')
<script>
    $("body").on("click", ".adjustStock_btn", function() {
        $(".quantity_d").val('');
        $(".stk_vendor_id").val('');
        $(".adjust_reason_d").val('');
        $(".custom_field").empty();
        $(".stk_custom_key").val('');
        $(".stk_custom_value").val('');
        $(".custom_adjust_reason_d").addClass("hide-d");

        var pid = $(this).attr("data-id");
        var pname = $(this).attr("data-name");
        var item_type = $(this).attr("data-type");
        $(".product_inp_d").val(pid);
       
        $.ajax({
            url: APP_URL + '/api/AdjustmentProductWiseShow/' + pid,
            type: 'get',
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
                    var variHtml = [];
                    if(response.data.length>0 && response.data.length!='' && item_type!='group_item'){
                    for (var i = 0; i < response.data.length; i++) {
                        if (response.data[i]?.variation_name != '' && response.data[i]?.variation_name != null) {
                            variHtml += '<option value="' + response.data[i]?.variation_id + '" data-id="' + response.data[i]?.id + '">' + response.data[i]?.variation_name + '</option>';
                        }
                      }
                    }else{
                        variHtml += '<option value="" data-id="">' + pname + '</option>';

                    }
                    $(".stk_variation_id").empty().append(variHtml);
                    $(".st_title_name").text(pname);
                    $("#adjustStockPopup").modal("show");

                } else {
                    toastr.error(response?.message);
                }

            },
            error: function(response) {
                block_gui_end();
                console.log("server side error");
            }
        })
    });

    $("body").on("click", ".close_st_btn", function() {
        $(".product_inp_d").val('');
        $("#adjustStockPopup").modal("hide");
    });

    $("body").on("click", ".stk_tab_type", function(e) {
        e.preventDefault();
        var med_value = $(this).attr("data-type");
        $(".method_type_inp_d").val(med_value);
        var optionHtml = [];
        $(".custom_adjust_reason_d").addClass("hide-d");
        $(".custom_adjust_reason_d").val('');                               

        if (med_value == "1") {
            optionHtml += '<option value="" selected>Reason to adjust</option>';
            optionHtml += '  <option value="Purchased">Purchased</option>';
            optionHtml += '   <option value="Returned">Returned</option>';
            optionHtml += '  <option value="AdjustStock">Adjust stock</option>';
            optionHtml += '  <option value="Other">Other</option>';
        } else if (med_value == "2") {
            optionHtml += '<option value="" selected>Reason to adjust</option>';
            optionHtml += '  <option value="Demaged">Demaged</option>';
            optionHtml += '   <option value="Lost">Lost</option>';
            optionHtml += '  <option value="AdjustStock">Adjust stock</option>';
            optionHtml += '  <option value="Other">Other</option>';

        }
        $(".adjust_reason_d").empty().append(optionHtml);

    });

    $("body").on("change", ".adjust_reason_d", function() {
        var reason = $(this).val();
        if (reason== "Other") {
            $(".custom_adjust_reason_d").removeClass("hide-d");
        }else{
            $(".custom_adjust_reason_d").addClass("hide-d");

        }
    });


    function addNewStock(e) {

        if ($(".quantity_d").val() == '') {
            $(".quantity_d").css("border", "1px solid red");
            return false;
        } else {
            $(".quantity_d").css("border", "");

        }
        var form_data = new FormData();
        form_data.append('method_type', $(".method_type_inp_d").val());
        form_data.append('adjust_reason', $(".adjust_reason_d").val());
        form_data.append('custom_reason', $(".custom_adjust_reason_d").val());
        form_data.append('vendor_id', $(".stk_vendor_id").val());
        form_data.append('user_type', $(".stk_vendor_id").find('option:selected').attr("data-type"));
        form_data.append('quantity', $(".quantity_d").val());
        form_data.append('adjustment_id', $(".stk_variation_id").find('option:selected').attr("data-id"));
        form_data.append('product_id', $(".product_inp_d").val());
        form_data.append('variation_id', $(".stk_variation_id").val());
        var tempArray = [];

        $(".stk_custom_value").each(function(index) {
            form_data.append('custome_value[' + index + ']', $(this).val());
        });
        $(".stk_custom_key").each(function(index) {
            form_data.append('custome_key[' + index + ']', $(this).val());
        });

        form_data.append('platform', "Unesync");
        form_data.append('guard', "WEB");
        $.ajax({
            url: APP_URL + "/api/AdjustmentUpdate",
            data: form_data,
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
                    $(".brand_name").val('');
                    toastr.success(response?.message);
                    $("#adjustStockPopup").modal("hide");
                    ReseProductItemPage();
                } else {
                    toastr.error(response?.message);
                }
            },
            error: function(response) {
                block_gui_end();
                console.log("server side error");
            }
        });
    }
</script>

@endpush