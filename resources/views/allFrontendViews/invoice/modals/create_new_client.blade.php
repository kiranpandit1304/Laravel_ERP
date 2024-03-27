<!-- Bill to Create New Popup -->
<div class="modal fade twoside_modal" id="createnewclient" tabindex="-1" role="dialog" aria-labelledby="createnewclientLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
                </button>
                <div class="modal-body">
                    <div class="setup_wrapper">
                        <h2>Create New Client</h2>

                        <div class="inner_model_wrapper">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFive">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseFive" aria-expanded="true"
                                            aria-controls="collapseFive">
                                            Basic Information
                                        </button>
                                    </h2>
                                    <div id="collapseFive" class="accordion-collapse collapse show"
                                        aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="comn_card">
                                                <div class="row">
                                                    <div class="form-group col-sm-12">
                                                        <label class="d-block">Have GST number?</label>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="customRadio6" name="customRadio1" class="custom-control-input" checked="">
                                                            <label class="custom-control-label" for="customRadio6"> Yes, I have </label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="customRadio7" name="customRadio1" class="custom-control-input" >
                                                            <label class="custom-control-label" for="customRadio7"> No, I don't have </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="have_gstsetup show">
                                                    <div class="form-group col-sm-12 flush">
                                                        <label>
                                                            <input type="text" class="clt_gst_no"  required="" id="" value="" placeholder="Enter GST number">
                                                            <span>Enter GST number</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-sm-12">
                                                        <label>
                                                            <input type="text"  class="clt_name" required="" id="" value=""
                                                                placeholder="Client's Name">
                                                            <span>Client's Name</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingSeven">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseSeven"
                                            aria-expanded="false" aria-controls="collapseSeven">
                                            Address <span>(optional)</span>
                                        </button>
                                    </h2>
                                    <div id="collapseSeven" class="accordion-collapse collapse"
                                        aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="comn_card">
                                                <div class="row">
                                                    <div class="form-group col-sm-6">
                                                        <div class="select-full">
                                                            <select class="js-example-placeholder-single-ctry clt_billing_country_id ">
                                                                <option value="0" >Select Country</option>
                                                                @foreach($commonData['countryList'] as $country)
                                                                <option value="{{@$country->id}}" {{ $country->id == 101 ? 'selected' : ''}}>{{@$country->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <div class="select-full">
                                                            <select class="js-example-placeholder-single-st clt_billing_stateid">
                                                                <option value="0" >Select State</option>
                                                                @foreach($commonData['stateList'] as $state)
                                                             <option value="{{@$state->id}}">{{@$state->name}}</option>
                                                             @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-sm-6">
                                                        <label>
                                                            <input type="text" class="clt_billing_street_address" required="" id=""
                                                                placeholder="Street Address" />
                                                            <span>Street Address</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>
                                                            <input type="text" class="clt_billing_postal_code" required="" id=""
                                                                placeholder="Postal Code / Zip Code" />
                                                            <span>Postal Code / Zip Code</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="sd_check">
                                                    <input type="checkbox" class="show_shipping_address" name="layout" value="1" id="asa">
                                                    <label class="pull-right text" for="asa">Same as shipping Address</label>
                                                </div>

                                                <!-- .. -->
                                                <div class="ship_card mt-3" >
                                                <div class="row">
                                                    <div class="form-group col-sm-6">
                                                        <div class="select-full">
                                                            <select class="js-example-placeholder-single-brand js-states clt_shipping_country_id">
                                                                <option value="0" >Select Country</option>
                                                                @foreach($commonData['countryList'] as $country)
                                                                <option value="{{@$country->id}}" {{ $country->id == 101 ? 'selected' : ''}}>{{@$country->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <div class="select-full">
                                                            <select class="js-example-placeholder-single-state clt_shipping_state_id">
                                                                <option value="0" >Select State</option>
                                                                @foreach($commonData['stateList'] as $state)
                                                                 <option value="{{@$state->id}}">{{@$state->name}}</option>
                                                                 @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-sm-6">
                                                        <label>
                                                            <input type="text" class="clt_shipping_st_address" required="" id=""
                                                                placeholder="Street Address" />
                                                            <span>Shipping Street Address</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label> 
                                                            <input type="text" class="clt_postal_code" required="" id=""
                                                                placeholder="Postal Code / Zip Code" />
                                                            <span>Shipping Postal Code / Zip Code</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                </div>
                                                <!--  -->
                                            </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                 
                                <!-- End -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingSix">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseSix"
                                            aria-expanded="false" aria-controls="collapseSix">
                                            Tax Information <span>(optional)</span>
                                        </button>
                                    </h2>
                                    <div id="collapseSix" class="accordion-collapse collapse"
                                        aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="comn_card">
                                                <div class="row">
                                                    <div class="form-group col-sm-6">
                                                        <label>
                                                            <input type="text" class="clt_business_gstin" required="" id="" value=""
                                                                placeholder="Business GSTIN">
                                                            <span>Business GSTIN</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>
                                                            <input type="text" required="" class="clt_pan_no" id="" value=""
                                                                placeholder="Business PAN Number">
                                                            <span>Business PAN Number</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingEight">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseEight"
                                            aria-expanded="false" aria-controls="collapseEight">
                                            Additional Details <span>(optional)</span>
                                        </button>
                                    </h2>
                                    <div id="collapseEight" class="accordion-collapse collapse"
                                        aria-labelledby="headingEight" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="comn_card">
                                                <div class="row">
                                                    <div class="form-group col-sm-6">
                                                        <label>
                                                            <input type="email" required="" class="clt_email" id="" value=""
                                                                placeholder="Email">
                                                            <span>Email</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group col-sm-6 cpnumber">
                                                        <label class="phone">
                                                            <div class="prefix">+91</div>
                                                            <input type="text" required="" id="phone" class="clt_phone_no"
                                                                placeholder="Phone Number">
                                                            <span>Phone Number</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="com_action">
                                <button class="nobgc" data-dismiss="modal" aria-label="Close">Cancel</button>
                                <button class="" onclick="saveNewShipClient(this)">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('custom-scripts')
    <script>
    $(".js-example-placeholder-single-ctry").select2({
            placeholder: "Select Country",
        });
        $(".js-example-placeholder-single-st").select2({
            placeholder: "Select State",
        });
    </script>

<script>
    $("body").on("click", ".show_shipping_address", function(){
        if( $(this).is(":checked")){
                    $('.clt_shipping_st_address').val($('.clt_billing_street_address').val());
                    $('.clt_shipping_state_id').val($('.clt_billing_stateid').val()).trigger('change');
                    $('.clt_postal_code').val($('.clt_billing_postal_code').val());

        }else{
                    $('.clt_shipping_st_address').val('');
                    $('.clt_shipping_state_id').val('').trigger('change');
                    $('.clt_postal_code').val('');
        }
    });

function saveNewShipClient(){
    var formData = new FormData();

formData.append('gst_no', $('.clt_gst_no').val());
formData.append('name', $('.clt_name').val());

formData.append('billing_country', $('.clt_billing_country_id').val());
formData.append('billing_country_name', $('.clt_billing_country_id').find(":selected").text());
formData.append('billing_state',  $('.clt_billing_stateid').val());
formData.append('billing_state_name',  $('.clt_billing_stateid').find(":selected").text());
formData.append('billing_zip', $('.clt_billing_postal_code').val());
formData.append('billing_address', $('.clt_billing_street_address').val());
 
formData.append('shipping_country', $('.clt_shipping_country_id').val());
formData.append('shipping_state', $('.clt_shipping_state_id').val());
formData.append('shipping_country_name', $('.clt_shipping_country_id').find(":selected").text());
formData.append('shipping_state_name',  $('.clt_shipping_state_id').find(":selected").text());
formData.append('shipping_zip', $('.clt_postal_code').val());
formData.append('shipping_address', $('.clt_shipping_st_address').val());

formData.append('nature_of_business', $('.clt_business_name').val());
formData.append('bussiness_gstin', $('.clt_business_gstin').val());
formData.append('pan', $('.clt_pan_no').val());

formData.append('email', $('.clt_email').val());
formData.append('billing_phone', $('.clt_phone_no').val());

formData.append('platform', "Unesync");
formData.append('guard', "WEB");

$.ajax({
        url: APP_URL + '/api/AddCustomerInvoice',
        data: formData,
        type: 'post',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                toastr.success(response?.message);
                 appedClientData(response);
                 $("#createnewclient").modal("hide");
                 $(".bill_customer_id").append('<option  value="'+response?.data?.id+'" selected >'+response?.data?.name+' </option>')
            } else {
                toastr.error(response?.message)
            }

        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    })

}
//06AAHCD4406B1Z8
$("body").on("focusout", ".clt_gst_no", function () {
    var gst_number = $(this).val();
    $.ajax({
        url: APP_URL + "/api/getGstDetails/" + gst_number,
        type: "GET",
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                response = response.data
                if(response && response!= '' ){

                    $('.clt_name').val(response?.lgnm)
                    $('.clt_business_gstin').val(response?.gstin);
                    // var addesss = response?.pradr?.addr?.bno + ' ' +response?.pradr?.addr?.bnm + ' ' + response?.pradr?.addr?.st + ' ' + response?.pradr?.addr?.loc + ' ' + response?.pradr?.addr?.dst + ' ' + response?.pradr?.addr?.stcd+ ' ' +ddr?.city+ ' ' + response?.pradr?.addr?.pncd
                var addesss = response?.pradr?.addr?.bno + ' ' +response?.pradr?.addr?.bnm + ' ' + response?.pradr?.addr?.st + ' ' + response?.pradr?.addr?.loc + ' ' + response?.pradr?.addr?.dst + ' ' + response?.pradr?.addr?.stcd+ ' ' + response?.pradr?.addr?.pncd
                    $('.clt_billing_street_address').val(addesss);

                    var statelist = state_list.filter(v => v.name === response?.pradr?.addr?.stcd);
                    $('.clt_billing_stateid').val(statelist[0]?.id).trigger('change');
                    $('.clt_billing_postal_code').val(response?.pradr?.addr?.pncd);
                }

                // $('.clt_shipping_st_address').val(addesss);
                // $('.clt_shipping_state_id').val(statelist[0]?.id).trigger('change');
                // $('.clt_postal_code').val(response?.pradr?.addr?.pncd);

                $(".clt_pan_no").val(gst_number.slice(2, -3));

            } else {
                toastr.error('GST number is not correct.');
            }
        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
});

</script>
@endpush