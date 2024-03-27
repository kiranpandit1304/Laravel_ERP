 <!-- Bill to Edit Popup -->
        <div class="modal fade twoside_modal" id="billtoedit" tabindex="-1" role="dialog" aria-labelledby="billtoeditLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
                    </button>
                    <div class="modal-body">
                        <div class="setup_wrapper">
                            <h2>Edit Client Details</h2>
                            <div class="inner_model_wrapper">
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingFive">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                                Basic Information
                                            </button>
                                        </h2>
                                        <div id="collapseFive" class="accordion-collapse collapse show" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="comn_card">
                                                    <div class="row">
                                                        <div class="form-group col-sm-12">
                                                            <label>
                                                                <input type="text" required="" id="" value=""  class="edit_client_name" placeholder="Client's Business Name">
                                                                <span>Client's Business Name</span>
                                                            </label>
                                                        </div>
                                                        <!-- <div class="form-group col-sm-6">
                                                            <div class="select-full">
                                                                <select class="js-example-placeholder-single-country edit_client_countyr_id">
                                                                    <option value="0" >Select Country</option>
                                                                    @foreach($commonData['countryList'] as $country)
                                                                     <option value="{{@$country->id}}" {{ $country->id == 101 ? 'selected' : ''}}>{{@$country->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingSix">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                Tax Information <span>(optional)</span>
                                            </button>
                                        </h2>
                                        <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="comn_card">
                                                    <div class="row">
                                                        <div class="form-group col-sm-6">
                                                            <label>
                                                                <input type="text"  class="edit_client_gstin"  required="" id="" value="" placeholder="Business GSTIN">
                                                                <span>Business GSTIN</span>
                                                            </label>
                                                        </div>
                                                        <div class="form-group col-sm-6">
                                                            <label>
                                                                <input type="text" required="" class="edit_client_pan_no" id="" value="" placeholder="Business PAN Number">
                                                                <span>Business PAN Number</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingSeven">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                                Address <span>(optional)</span>
                                            </button>
                                        </h2>
                                        <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="comn_card">
                                                    <div class="row">
                                                        <div class="form-group col-sm-6">
                                                            <div class="select-full">
                                                                <select class="js-example-placeholder-single-country edit_client_country edit_client_countyr_id">
                                                                    <option value="0" >Select Country</option>
                                                                    @foreach($commonData['countryList'] as $country)
                                                                     <option value="{{@$country->id}}" {{ $country->id == 101 ? 'selected' : ''}}>{{@$country->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm-6">
                                                            <div class="select-full">
                                                                <select class="js-example-placeholder-single-state edit_client_state" id="editClientState" >
                                                                    <option value="0" selected>Select State</option>
                                                                    @foreach($commonData['stateList'] as $state)
                                                                    <option value="{{@$state->id}}" {{ !empty($saleInvoice->billing_to_state_name) && $saleInvoice->billing_to_state_name == $state->name ? 'selected' : ''}}>{{@$state->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-sm-6">
                                                            <label>
                                                                <input type="text" required="" id="" class="client_potal_code" placeholder="Postal Code / Zip Code"/>
                                                                <span>Postal Code / Zip Code</span>
                                                            </label>
                                                        </div>
                                                        <div class="form-group col-sm-6">
                                                            <label>
                                                                <input type="text" required="" class="editclient_street_address" id="" placeholder="Street Address"/>
                                                                <span>Street Address</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingEight">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                                Additional Details <span>(optional)</span>
                                            </button>
                                        </h2>
                                        <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="comn_card">
                                                    <div class="row">
                                                        <div class="form-group col-sm-6">
                                                            <label>
                                                                <input type="email"  class="edit_client_email" required="" id="" value="" placeholder="Email">
                                                                <span>Email</span>
                                                            </label>
                                                            <!-- <div class="sd_check">
                                                                <input type="checkbox"  class="is_show_client_email_on_invoice"  name="is_show_client_email_on_invoice" value="1" id="saadto">
                                                                <label class="pull-right text" for="saadto">Show Email in Invoice</label>
                                                            </div> -->
                                                        </div>
                                                        <div class="form-group col-sm-6 cpnumber">
                                                            <label class="phone">
                                                                <div class="prefix">+91</div>
                                                                <input type="text"  class="edit_client_no" required="" id="phone"  placeholder="Phone Number">
                                                                <span>Phone Number</span>
                                                            </label>
                                                            <!-- <div class="sd_check">
                                                                <input type="checkbox"  class="is_show_client_phone_on_invoice" value="1" name="is_show_client_phone_on_invoice" id="saadto1">
                                                                <label class="pull-right text" for="saadto1">Show Phone in Invoice</label>
                                                            </div> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <input type="hidden" class="edit_business_id" value="" /> -->
                                <div class="com_action">
                                    <div class="sd_check">
                                        <input type="checkbox" class="update_current_change_to" value="1" name="update_current_change_to" id="saadto2">
                                        <label class="pull-right text" for="saadto2">Update current changes for all existing invoices of this business.</label>
                                    </div>
                                    <button class="" onclick="UpdateClientDetail(this)">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       