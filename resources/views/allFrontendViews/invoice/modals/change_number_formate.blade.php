 <!-- Change Number Format Popup -->
 <div class="modal fade twoside_modal" id="changenumberformat" tabindex="-1" role="dialog" aria-labelledby="changenumberformatLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
                    </button>
                    <div class="modal-body">
                        <div class="setup_wrapper">
                            <h2>Change Number Format</h2>

                            <div class="inner_model_wrapper">
                                <p>Change between Roman and Arabic number systems. Million vs. Lakhs.</p>
                                <span>Select Number Format</span>
                                <div class="number_wrap">
                                    <input type="radio" class="number_format" value="ind" name="select" id="option-1" checked />
                                    <input type="radio" class="number_format" value="usa" name="select" id="option-2" />
                                    <label for="option-1" class="option option-1">
                                        <div class="dot"></div>
                                        <span>India - English (Lakhs)<br/><h6>₹1,23,45,679</h6></span>
                                    </label>
                                    <label for="option-2" class="option option-2">
                                        <div class="dot"></div>
                                        <span>United States - English (Millions)<br/><h6>₹12,345,679</h6></span>
                                    </label>
                                </div>  
                                <div class="select-full">
                                    <select class="js-example-placeholder-single-country invoice_country">
                                        <option value="1">India</option>
                                        <option value="2">Canada</option>
                                        <option value="3">London</option>
                                        <option value="1">India</option>
                                        <option value="2">Canada</option>
                                        <option value="3">London</option>
                                        <option value="1">India</option>
                                        <option value="2">Canada</option>
                                        <option value="3">London</option>
                                    </select>
                                </div> 
                                <span>Select Decimal Digits</span>
                                <div class="number_wrap digital">
                                    <input type="radio" class="decimal_digit_format" value="none" name="select1" id="option-3" checked />
                                    <label for="option-3" class="option option-3">
                                        <div class="dot"></div>
                                        <span>None</span>
                                    </label>
                                    <input type="radio" class="decimal_digit_format"  value="99" name="select1" id="option-4" />
                                    <label for="option-4" class="option option-4">
                                        <div class="dot"></div>
                                        <span>99</span>
                                    </label>

                                    <input type="radio" class="decimal_digit_format"  value="99.0" name="select1" id="option-5" />
                                    <label for="option-5" class="option option-5">
                                        <div class="dot"></div>
                                        <span>99.0</span>
                                    </label>
                                    <input type="radio" class="decimal_digit_format"  value="99.00" name="select1" id="option-6" />
                                    <label for="option-6" class="option option-6">
                                        <div class="dot"></div>
                                        <span>99.00</span>
                                    </label>
                                </div> 
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <div class="inputGroup">
                                            <input type="text" class="filed_data"  name="number_format" required="" id="" value="">
                                            <label for="name">Add Custom Currency Symbol</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="com_action">
                                    <button class="nobgc" data-dismiss="modal" aria-label="Close">Cancel</button>
                                    <button class="click_next close">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
