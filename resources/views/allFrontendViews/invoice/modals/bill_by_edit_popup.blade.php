 <!-- Bill By Edit Popup -->
 <div class="modal fade twoside_modal" id="billbyedit" tabindex="-1" role="dialog" aria-labelledby="billbyeditLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
             </button>
             <div class="modal-body">
                 <div class="setup_wrapper">
                     <h2>Business Details</h2>

                     <div class="inner_model_wrapper">
                         <div class="accordion" id="accordionExample">
                             <div class="accordion-item">
                                 <h2 class="accordion-header" id="headingOne">
                                     <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                         Basic Information
                                     </button>
                                 </h2>
                                 <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                     <div class="accordion-body">
                                         <div class="comn_card">
                                             <div class="row">
                                                 <div class="form-group col-sm-12">
                                                     <label>
                                                         <input type="text" required="" class="edit_busi_name" id="" value="Unesync">
                                                         <span>Client's Business Name</span>
                                                     </label>
                                                 </div>
                                             </div>
                                            
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="accordion-item">
                                 <h2 class="accordion-header" id="headingTwo">
                                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                         Tax Information <span>(optional)</span>
                                     </button>
                                 </h2>
                                 <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                     <div class="accordion-body">
                                         <div class="comn_card">
                                             <div class="row">
                                                 <div class="form-group col-sm-6">
                                                     <label>
                                                         <input type="text" required="" id="" value="" class="edit_businee_gstin" placeholder="Business GSTIN">
                                                         <span>Business GSTIN</span>
                                                     </label>
                                                 </div>
                                                 <div class="form-group col-sm-6">
                                                     <label>
                                                         <input type="text" required="" id="" value="" class="edit_businee_pan_no" placeholder="Business PAN Number">
                                                         <span>Business PAN Number</span>
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
                                         Address <span>(optional)</span>
                                     </button>
                                 </h2>
                                 <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                     <div class="accordion-body">
                                         <div class="comn_card">
                                         <div class="row">
                                                 <div class="form-group col-sm-6">
                                                     <div class="select-full">
                                                         <select class="js-example-placeholder-single-country edit_countyr_id">
                                                             <option value="0" selected>Select Country</option>
                                                             @foreach($commonData['countryList'] as $country)
                                                             <option value="{{@$country->id}}" {{ $country->id == 101 ? 'selected' : ''}}>{{@$country->name}}</option>
                                                             @endforeach
                                                         </select>
                                                     </div>
                                                 </div>
                                                 <div class="form-group col-sm-6">
                                                     <div class="select-full">
                                                         <select class="js-example-placeholder-single-state edit_busi_state" id="editBusiState">
                                                             <option value="0" selected>Select State</option>
                                                             @foreach($commonData['stateList'] as $state)
                                                             <option value="{{@$state->id}}">{{@$state->name}}</option>
                                                             @endforeach
                                                         </select>
                                                     </div>
                                                 </div>
                                             </div>
                                             <!-- <div class="row">
                                                 <div class="form-group col-sm-6">
                                                     <div class="select-full">
                                                         <select class="js-example-placeholder-single-country">
                                                             <option value="0" selected>Select Country</option>
                                                             @foreach($commonData['countryList'] as $country)
                                                             <option value="{{@$country->id}}" {{ $country->id == 101 ? 'selected' : ''}}>{{@$country->name}}</option>
                                                             @endforeach
                                                         </select>
                                                     </div>
                                                 </div>
                                                 <div class="form-group col-sm-6">
                                                     <div class="select-full">
                                                         <select class="js-example-placeholder-single-state">
                                                             <option value="0" selected>Select State</option>
                                                             @foreach($commonData['stateList'] as $state)
                                                             <option value="{{@$state->id}}">{{@$state->name}}</option>
                                                             @endforeach
                                                         </select>
                                                     </div>
                                                 </div>
                                             </div> -->
                                             <div class="row">
                                                 <div class="form-group col-sm-6">
                                                     <label>
                                                         <input type="text" required="" id="" class="potal_code" placeholder="Postal Code / Zip Code" />
                                                         <span>Postal Code / Zip Code</span>
                                                     </label>
                                                 </div>
                                                 <div class="form-group col-sm-6">
                                                     <label>
                                                         <input type="text" required="" class="edit_busi_street_address" id="" placeholder="Street Address" />
                                                         <span>Street Address</span>
                                                     </label>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="accordion-item">
                                 <h2 class="accordion-header" id="headingFour">
                                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                         Additional Details <span>(optional)</span>
                                     </button>
                                 </h2>
                                 <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                     <div class="accordion-body">
                                         <div class="comn_card">
                                             <div class="row">
                                                 <div class="form-group col-sm-6">
                                                     <label>
                                                         <input type="email" class="edit_business_email" required="" id="" value="">
                                                         <span>Email</span>
                                                     </label>
                                                     <!-- <div class="sd_check">
                                                         <input type="checkbox" class="is_show_email_on_invoice"  value="1"  name="is_show_email_on_invoice" id="saad">
                                                         <label class="pull-right text" for="saad">Show Email in Invoice</label>
                                                     </div> -->
                                                 </div>
                                                 <div class="form-group col-sm-6 cpnumber">
                                                     <label class="phone">
                                                         <div class="prefix">+91</div>
                                                         <input type="text"  class="edit_busi_no" required="" id="phone">
                                                         <span>Phone Number</span>
                                                     </label>
                                                     <!-- <div class="sd_check">
                                                         <input type="checkbox" class="is_show_phone_on_invoice"  value="1"  name="is_show_phone_on_invoice" id="saad1">
                                                         <label class="pull-right text" for="saad1">Show Phone in Invoice</label>
                                                     </div> -->
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="com_action">
                             <div class="sd_check">
                                 <input type="checkbox" class="update_current_change_by" value="1" name="update_current_change_by" id="saad2">
                                 <label class="pull-right text" for="saad2">Update current changes for all existing invoices of this business.</label>
                             </div>
                             <button class="" onclick="UpdateBusinessDetil(this)">Save</button>
                             <!-- <button class="close_bill_by_popup"  >Save</button> -->
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>