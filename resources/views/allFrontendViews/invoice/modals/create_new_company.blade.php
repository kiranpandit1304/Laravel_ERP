

<!-- Bill by Create New Popup -->
<div class="modal fade twoside_modal" id="createnewcompany" tabindex="-1" role="dialog" aria-labelledby="createnewcompanyLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
                </button>
                <div class="modal-body">
                    <div class="setup_wrapper">
                        <h2>Create New Business/Company</h2>

                        <div class="inner_model_wrapper">
                            <form action="javascript:void(0)" method="post" id="addNewBusinessForm" >
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingNine">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseNine" aria-expanded="true"
                                            aria-controls="collapseNine">
                                            Basic Information
                                        </button>
                                    </h2>
                                    <div id="collapseNine" class="accordion-collapse collapse show"
                                        aria-labelledby="headingNine" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="comn_card">
                                                <div class="row">
                                                    <div class="form-group col-sm-12">
                                                        <label class="d-block">Have GST number?</label>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="customRadio61"name="is_gst" value="1" class="custom-control-input" checked="">
                                                            <label class="custom-control-label" for="customRadio61"> Yes, I have </label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="customRadio71" name="is_gst" value="0" class="custom-control-input" >
                                                            <label class="custom-control-label" for="customRadio71"> No, I don't have </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="have_gstsetup show">
                                                    <div class="form-group col-sm-12 flush">
                                                        <label>
                                                            <input type="text" class="busi_gst_no" name="gst_no"  id="" value="" placeholder="Enter GST number">
                                                            <span>Enter GST number</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-sm-12">
                                                        <label>
                                                            <input type="text" class="busi_name"   name="business_name"  id="" value=""
                                                                placeholder="Business Name">
                                                            <span>Business Name</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTen">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTen"
                                            aria-expanded="false" aria-controls="collapseTen">
                                            Address <span>(optional)</span>
                                        </button>
                                    </h2>
                                    <div id="collapseTen" class="accordion-collapse collapse"
                                        aria-labelledby="headingTen" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="comn_card">
                                                <div class="row">
                                                    <div class="form-group col-sm-6">
                                                        <div class="select-full">
                                                            <select class="js-example-placeholder-single-country busi_country_id" name="country_id">
                                                                <option value="0" >Select Country</option>
                                                                @foreach($commonData['countryList'] as $country)
                                                                <option value="{{@$country->id}}" {{ $country->id == 101 ? 'selected' : ''}}>{{@$country->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <div class="select-full">
                                                            <select class="js-example-placeholder-single-state busi_state_id" name="state_id">
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
                                                            <input type="text" class="busi_st_address"  name="street_address"  id="" placeholder="Street Address" />
                                                            <span>Street Address</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>
                                                            <input type="text"  class="busi_postal_code" name="zip_code"  id=""
                                                                placeholder="Postal Code / Zip Code" />
                                                            <span>Postal Code / Zip Code</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingEle">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseEle"
                                            aria-expanded="false" aria-controls="collapseEle">
                                            Tax Information <span>(optional)</span>
                                        </button>
                                    </h2>
                                    <div id="collapseEle" class="accordion-collapse collapse"
                                        aria-labelledby="headingEle" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="comn_card">
                                                <div class="row">
                                                    <div class="form-group col-sm-6">
                                                        <label>
                                                            <input type="text" name="bussiness_gstin" class="busi_gstin"  id="" value=""
                                                                placeholder="Business GSTIN">
                                                            <span>Business GSTIN</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>
                                                            <input type="text" name="pan_no"  class="busi_pan_no" id="" value=""
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
                                    <h2 class="accordion-header" id="headingTwele">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwele"
                                            aria-expanded="false" aria-controls="collapseTwele">
                                            Additional Details <span>(optional)</span>
                                        </button>
                                    </h2>
                                    <div id="collapseTwele" class="accordion-collapse collapse"
                                        aria-labelledby="headingTwele" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="comn_card">
                                                <div class="row">
                                                    <div class="form-group col-sm-6">
                                                        <label>
                                                            <input type="email" name="email" class="busi_email"  id="" value=""
                                                                placeholder="Email">
                                                            <span>Email</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group col-sm-6 cpnumber">
                                                        <label class="phone">
                                                            <div class="prefix">+91</div>
                                                            <input type="text" class="busi_phone"  id="phone"
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
                                <button class="" onclick="AddNewBusiness(this)" >Save</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
@push('custom-scripts')
 <script>
function AddNewBusiness() {

$(".error").remove();
if ($(".busi_name").val().length < 1) {
    $('.busi_name').after('<span class="error">This field is required</span>');
    return false;
}

var form = $("#addNewBusinessForm")[0];
var formData = new FormData(form);
formData.append('platform', "Unesync");
formData.append('guard', "WEB");

$.ajax({
    url: APP_URL + "/api/BusinesAdd",
    type: "POST",
    data: formData,
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
               toastr.success(response.message);
               appendBusinesCardData(response);
               $("#createnewcompany").modal("hide");
                 $(".billed_by_business_id").append('<option  value="'+response?.data?.id+'" selected >'+response?.data?.business_name+' </option>')

        } else {
            toastr.error(response.message);
        }

    }, error: function (response) {
        block_gui_end();
        console.log("server side error");
    }
});
}

//06AAHCD4406B1Z8
$("body").on("focusout", ".busi_gst_no", function () {
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
                $('.busi_name').val(response?.lgnm)
                $('.busi_gstin').val(response?.gstin);
                var addesss = response?.pradr?.addr?.bno + ' ' +response?.pradr?.addr?.bnm + ' ' + response?.pradr?.addr?.st + ' ' + response?.pradr?.addr?.loc + ' ' + response?.pradr?.addr?.dst + ' ' + response?.pradr?.addr?.stcd+ ' ' + response?.pradr?.addr?.pncd
              
                $('.busi_st_address').val(addesss);

                var statelist = state_list.filter(v => v.name === response?.pradr?.addr?.stcd);
                $('.busi_state_id').val(statelist[0]?.id).trigger('change');
                $('.busi_postal_code').val(response?.pradr?.addr?.pncd);

               $(".busi_pan_no").val(gst_number.slice(2, -3));

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