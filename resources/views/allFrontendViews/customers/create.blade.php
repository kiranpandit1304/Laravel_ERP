 <!-- Create Customer - Bottom Full Screen Popup -->
 <div class="cibsp" id="createcustomer">
     <div class="cibsp_header">
         <a href="#" class="close_cibsp" id="close_cibsp"><iconify-icon icon="material-symbols:close-rounded"></iconify-icon></a>
         <h2>Create Customer</h2>
         <span>&nbsp;</span>
         <button class="updatebtn hide-d" onclick="UpdateEntity(this)">Save</button>
     </div>
     <div class="mini_continer">
         <div class="cibsp_body">
             <div class="inner_model_wrapper">
                 <div class="accordion" id="accordionExample">
                     <div class="accordion-item">
                         <h2 class="accordion-header" id="headingOne">
                             <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                 General Information
                             </button>
                         </h2>
                         <form id="cusForm_d" action="javascript:void(0)" method="post">
                             <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                 <div class="accordion-body">
                                     <div class="gst_btns">
                                         <a href="#" class="have_gst">
                                             <span><img src="{{asset('unsync_assets/assets/images/taxes.png')}}" /></span>
                                             Customer have <br />GST number
                                         </a>
                                         <a href="#" class="no_gst active">
                                             <span><img src="{{asset('unsync_assets/assets/images/taxes.png')}}" /></span>
                                             Customer don't <br />have GST number
                                         </a>
                                     </div>

                                     <div class="row hide_gst">
                                         <div class="form-group col-sm-12 flush">
                                             <label>
                                                 <input type="text" class="gst_field get_gst_data" id="gst_no" placeholder="GST Number"  value="" />
                                                 <span>GST Number</span>
                                             </label>
                                         </div>
                                     </div>
                                     <div class="row">
                                         <div class="form-group withbutton col-sm-12">
                                             <label>
                                                 <input type="text" class="business_name" id="fname" name="name" value="" placeholder="Business/Customer name"  />
                                                 <span>Business/Customer name</span>
                                             </label>
                                             <div class="text_center">
                                                 <button type="submit" class="btn_comman save_customer">Create Customer</button>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="customer_created hide-d">
                                         <div class="cc_card">
                                             <lottie-player src="https://lottie.host/a6963a1c-1049-4992-a95a-d016d2d07948/fVRIDbvFti.json" background="transparent" speed="1" style="width: 100px; height: 100px;" loop autoplay></lottie-player>
                                             <div class="content_cc">
                                                 <h6>Customer created successfully</h6>
                                                 <p>This customer is created successfully now you can skip and go to dashboard</p>
                                                 <!-- <a href="javascript:void(0)" class="show_detail_form">Go to detail form</a> -->
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </form>
                     </div>
                     <form class="hide-d" id="CustomerDetailForm" action="javascript:void(0)" method="post">
                         <div class="accordion-item">
                             <h2 class="accordion-header" id="headingTwo">
                                 <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                     Address & Shipping Details <span>(Optional)</span>
                                 </button>
                             </h2>
                             <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                 <div class="accordion-body">
                                     <br />
                                     <h4>Address</h4>
                                     <div class="row">
                                         <div class="form-group col-sm-12">
                                             <label>
                                                 <input type="text" name="billing_address" id="billing_address" placeholder="Street Address" />
                                                 <span>Street Address</span>
                                             </label>
                                         </div>
                                     </div>
                                     <div class="row">
                                         <div class="form-group col-sm-6">
                                             <select class="js-example-placeholder-single-cuntry js-states form-control sv_billing_country bil_cty ucountry" name="billing_country">
                                                 <option></option>
                                                 @foreach($countryList as $country)
                                                 <option value="{{@$country->id}}" {{ $country->id == 101 ? 'selected' : ''}}>{{@$country->name}}</option>
                                                 @endforeach
                                             </select>
                                         </div>
                                         <div class="form-group col-sm-6">
                                             <select class="js-example-placeholder-single-state js-states form-control sv_billing_state ustate" name="billing_state">
                                                 <option>Select State</option>
                                                 @foreach($stateList as $state)
                                                 <option value="{{@$state->id}}">{{@$state->name}}</option>
                                                 @endforeach
                                             </select>
                                         </div>
                                     </div>
                                     <div class="row">
                                         <div class="form-group col-sm-12">
                                             <label>
                                                 <input type="text" class=" billing_zip_code" id="billing_zip" name="billing_zip" value="" placeholder="Postal Code / Zip Code" />
                                                 <span>Postal Code / Zip Code</span>
                                             </label>
                                         </div>
                                     </div>
                                     <div class="row">
                                         <div class="form-group col-sm-6">
                                             <label>
                                                 <input type="email" class="" id="email" name="email" value="" placeholder="Email"  />
                                                 <span>Email</span>
                                             </label>
                                         </div>
                                         <div class="form-group col-sm-6">
                                             <label>
                                                 <input type="text" class="" id="nature_of_business" name="nature_of_business" value="" placeholder="Nature of Business" />
                                                 <span>Nature of Business</span>
                                             </label>
                                         </div>
                                     </div>
                                     <div class="row">
                                         <div class="form-group col-sm-6">
                                             <label>
                                                 <input type="text" class="" id="contact_person" name="contact_person" value="" placeholder="Contact Person" />
                                                 <span>Contact Person</span>
                                             </label>
                                         </div>
                                         <div class="form-group col-sm-6 cpnumber">
                                             <label class="phone">
                                                <div class="prefix">+91</div>
                                                 <input type="text" class=" billing_phone" name="billing_phone" id="phone" value="" placeholder="Contact Number" />
                                                 <span>Contact Number</span>
                                                </label>
                                         </div>
                                     </div>
                                     <market-divider class="market-divider" margin="medium" hydrated=""></market-divider>
                                     <div class="shipping_info">
                                         <br />
                                         <h4>Shipping Details</h4>
                                         <div class="sd_check">
                                             <input type="checkbox" name="layout" id="saad" class="address_copy" data-id="yes" />
                                             <label class="pull-right text" for="saad">Same as address</label>
                                         </div>
                                         <div class="row">
                                             <div class="form-group col-sm-12">
                                                 <label>
                                                     <input type="text" class="shi_add" name="shipping_address" id="shipping_address" placeholder="Enter Street Address" />
                                                     <span>Street Address</span>
                                                 </label>
                                             </div>
                                         </div>

                                         <div class="row">
                                             <div class="form-group col-sm-6">
                                                 <select class="js-example-placeholder-single-cuntry js-country form-control shipping_country sv_shipping_country" name="shipping_country">
                                                     <option>Select Country</option>
                                                     @foreach($countryList as $country)
                                                     <option value="{{@$country->id}}" {{ $country->id == 101 ? 'selected' : ''}}>{{@$country->name}}</option>
                                                     @endforeach
                                                 </select>
                                             </div>
                                             <div class="form-group col-sm-6">
                                                 <select class="js-example-placeholder-single-state js-states form-control sv_shipping_state shp_state" name="shipping_state">
                                                     <option>Select State</option>
                                                     @foreach($stateList as $state)
                                                     <option value="{{@$state->id}}">{{@$state->name}}</option>
                                                     @endforeach
                                                 </select>
                                             </div>
                                         </div>

                                         <div class="row">
                                             <div class="form-group col-sm-6">
                                                 <label>
                                                     <input type="text" class="form-control shipping_zip_code" id="shipping_zip_code" name="shipping_zip" value="" placeholder="Postal Code / Zip Code" />
                                                     <span>Postal Code / Zip Code</span>
                                                 </label>
                                             </div>
                                             <div class="form-group col-sm-6">
                                                 <label>
                                                     <input type="text" class="form-control" id="bussiness_gstin" name="bussiness_gstin" value="" placeholder="Business GSTIN" />
                                                     <span>Business GSTIN</span>
                                                 </label>
                                             </div>
                                         </div>
                                     </div>

                                 </div>
                             </div>
                         </div>
                         <div class="accordion-item">
                             <h2 class="accordion-header" id="headingThree">
                                 <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                     Taxation Information <span>(Optional)</span>
                                 </button>
                             </h2>
                             <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                 <div class="accordion-body">
                                     <br />
                                     <div class="row">
                                         <div class="input-group form-group col-sm-12 full_in_icon">
                                             <label>
                                                 <input type="text" required="" class=""  name="tax_number" id="final_gst" aria-label="GST" placeholder="GST Number" aria-describedby="basic-addon2">
                                                 <span>GST Number</span>
                                             </label>
                                             <div class="input-group-append">
                                                 <span class="input-group-text" id="basic-addon2"><img src="{{asset('unsync_assets/assets/images/gst-icon.png')}}" alt="" /></span>
                                             </div>
                                         </div>
                                         <div class="input-group form-group col-sm-12 full_in_icon">
                                             <label>
                                                 <input type="text" required="" id="pan" name="pan" aria-label="pan" placeholder="PAN" aria-describedby="basic-addon2">
                                                 <span>PAN</span>
                                             </label>
                                             <div class="input-group-append">
                                                 <span class="input-group-text" id="basic-addon2"><img src="{{asset('unsync_assets/assets/images/id-card.png')}}" alt="" /></span>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="sd_check">
                                         <input type="checkbox" name="is_msme"  value="1" id="ismsme_cust" />
                                         <label class="pull-right text" for="ismsme_cust">Is MSME?</label>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="accordion-item">
                             <h2 class="accordion-header" id="headingFour">
                                 <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                     Payment Details <span>(Optional)</span>
                                 </button>
                             </h2>
                             <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                 <div class="accordion-body">
                                     <br />

                                     <div class="row">
                                         <div class="form-group col-sm-12">
                                             <label>
                                                 <input type="text" class="form-control" id="bank_name" name="bank_name" value="" placeholder="Bank Name" />
                                                 <span>Bank Name</span>
                                             </label>
                                         </div>
                                     </div>

                                     <div class="row">
                                         <div class="form-group col-sm-6">
                                             <label>
                                                 <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" placeholder="IFSC code" />
                                                 <span>IFSC code</span>
                                             </label>
                                         </div>
                                         <div class="form-group col-sm-6">
                                             <label>
                                                 <input type="text" class="form-control" id="account_no" name="account_no" value="" placeholder="Account Number" />
                                                 <span>Account Number</span>
                                             </label>
                                         </div>
                                     </div>

                                     <div class="row">
                                         <div class="form-group col-sm-12">
                                             <label>
                                                 <input type="text" class="form-control" id="branch_address" name="branch_address" value="" placeholder="Branch Address" />
                                                 <span>Branch Address</span>
                                             </label>
                                         </div>
                                     </div>
                                     <div class="row">
                                         <div class="form-group col-sm-6">
                                             <select class="js-example-placeholder-single-cuntry js-country form-control  country_id bk_country" name="country_id">
                                             <option>Select Country</option>
                                                 @foreach($countryList as $country)
                                                 <option value="{{@$country->id}}" {{ $country->id == 101 ? 'selected' : ''}}>{{@$country->name}}</option>
                                                 @endforeach
                                             </select>
                                         </div>
                                         <div class="form-group col-sm-6">
                                             <select class="js-example-placeholder-single-state js-states form-control state_id bnk_state" name="state_id">
                                             <option>Select State</option>
                                             @foreach($stateList as $state)
                                                 <option value="{{@$state->id}}">{{@$state->name}}</option>
                                                 @endforeach
                                             </select>
                                         </div>
                                     </div>
                                     <div class="row">
                                         <div class="form-group col-sm-12">
                                             <label>
                                                 <input type="text" class="form-control" id="zip_code" name="zip_code" value="" placeholder="Postal Code / Zip Code" />
                                                 <span>Postal Code / Zip Code</span>
                                             </label>
                                         </div>
                                     </div>

                                     <div class="row">
                                         <div class="input-group form-group col-sm-6">
                                             <label>
                                                 <input type="text" id="upi" name="upi" placeholder="UPI" aria-label="UPI" aria-describedby="basic-addon2" />
                                                 <span>UPI</span>
                                            </label>
                                             <div class="input-group-append">
                                                 <span class="input-group-text" id="basic-addon2"><img src="{{asset('unsync_assets/assets/images/upiicon.png')}}" alt="" /></span>
                                             </div>
                                         </div>
                                         <div class="input-group form-group col-sm-6">
                                             <label>
                                                 <input type="text" required="" name="payment_terms_days" id="payment_terms_days" aria-label="Payment Terms" placeholder="Payment Terms" aria-describedby="basic-addon2">
                                                 <span>Payment Terms</span>
                                             </label>
                                             <div class="input-group-append">
                                                 <span class="input-group-text" id="basic-addon2">Days</span>
                                             </div>
                                         </div>
                                     </div>

                                 </div>
                             </div>
                         </div>
                         <div class="accordion-item">
                             <h2 class="accordion-header" id="headingFive">
                                 <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                     File Upload <span>(Optional)</span>
                                 </button>
                             </h2>
                             <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                 <div class="accordion-body">
                                     <br />
                                     <h4>You can only upload 5 files at time.</h4>
                                     <div class="dropzone dz-default dz-message" id="desktop_media">
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <input type="hidden" class="uid" id="uid" value="" />
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>


