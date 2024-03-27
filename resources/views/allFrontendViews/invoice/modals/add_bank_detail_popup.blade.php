 <!-- Add New Bank Account Popup -->
 <div class="modal fade twoside_modal" id="addnewbankaccount" tabindex="-1" role="dialog"
        aria-labelledby="addnewbankaccountLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
                </button>
                <div class="modal-body">
                    <div class="setup_wrapper">
                        <h2>Add New Bank Account</h2>
                        <div class="inner_model_wrapper">
                            <div class="bankdetails show">
                                <div class="gray_card bank">
                                    <div class="gcard_body">
                                    <div class="form_details bankdetails show">
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
                                                            <option value="0" >Select Country</option>
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
                                                    <button class="add_newfield " onclick="appendBankCustomRow(this)" ><iconify-icon icon="material-symbols:add-circle-outline-rounded"></iconify-icon> Add New Field</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="page_button">
                                            <button type="button" class="save_bank_details" onclick="saveNewBankDetail(this)" >Save Bank Details</button>
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