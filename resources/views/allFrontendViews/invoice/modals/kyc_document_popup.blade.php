<!-- Add KYC Popup -->
<div class="modal fade twoside_modal" id="addkyc" tabindex="-1" role="dialog" aria-labelledby="addkycLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
                </button>
                <div class="modal-body">
                    <div class="setup_wrapper">
                        <h2>KYC Details</h2>

                        <div class="inner_model_wrapper">
                            <p>*Please enter KYC Details before enabling online payment*</p>
                            <div class="al_vt">
                                <div class="row">
                                    <div class="form-group col-6 col-lg-6 flush-right">
                                        <label>
                                            <input type="text" class="document_name"  required="" name="document_name" id="" value="" placeholder="Document Number">
                                            <span>Document Number</span>
                                        </label>
                                    </div>
                                    <div class="form-group col-6 col-lg-6">
                                        <label>
                                            <input type="text" class="document_number" name="document_number" required="" id="" value="" placeholder="Document Name">
                                            <span>Document Name</span>
                                        </label>
                                    </div>
                                </div>
                                <select class="js-example-placeholder-single-currency document_type" name="document_type">
                                    <option value="" selected>Kyc Document Type</option>
                                    <option value="1">Passport</option>
                                    <option value="2">Aadhar</option>
                                    <option value="3">Pan</option>
                                    <option value="4">Business Registration</option>
                                    <option value="5">Sales Invoice</option>
                                </select>
                                <select class="js-example-placeholder-single-currency evidence_type" name="evidence_type">
                                    <option value="" selected>Kyc Evidence Type</option>
                                    <option value="1">Address</option>
                                    <option value="2">Identity</option>
                                    <option value="3">Accounts</option>
                                    <option value="4">Others</option>
                                </select>
                            </div>
                            <div class="com_action">
                                <button class="nobgc" data-dismiss="modal" aria-label="Close">Cancel</button>
                                <button class="click_next" onclick="saveNewKycDocument(this)" >Done</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>