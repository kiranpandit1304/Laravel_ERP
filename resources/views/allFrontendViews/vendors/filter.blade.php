  <!-- View Vendor Offcanvas -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasFilter" aria-labelledby="offcanvasFilterLabel">
            <div class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h5 class="offcanvas-title" id="offcanvasFilterLabel">Add Filters</h5>
                <span>&nbsp;</span>
            </div>
            <div class="offcanvas-body">
                <div class="offcanvas_details">
                    
                    <div class="ft_item">
                        <div class="od_card">
                            <div class="od_card_header">
                                <h3>Business/Vendor name</h3>
                            </div>
                            <div class="od_card_body">
                                <input type="text" name="" id="filter_name" placeholder="Search by Business/Vendor name">
                            </div>
                        </div>
                        <div class="od_card">
                            <div class="od_card_header">
                                <h3>Nature of Business</h3>
                            </div>
                            <div class="od_card_body">
                                <input type="text" name="" id="filter_nature_of_business" placeholder="Search by Nature of Business">
                            </div>
                        </div>
                        <div class="od_card">
                            <div class="od_card_header">
                                <h3>Payment Terms</h3>
                            </div>
                            <div class="od_card_body">
                                <input type="text" name="" id="filter_payment_terms" placeholder="Search by Payment Terms">
                            </div>
                        </div>

                        <div class="od_card">
                            <div class="od_card_header">
                                <h3>Vendor have GST?</h3>
                            </div>
                            <div class="od_card_body">
                                <div class="align_check">
                                    <div class="sd_check">
                                        <input type="radio" class="is_have_gst" name="is_have_gst" value="yes" id="yes">
                                        <label class="pull-right text" for="yes">Yes</label>
                                    </div>
                                    <div class="sd_check">
                                        <input type="radio" class="is_have_gst"  name="is_have_gst" value="no" id="no">
                                        <label class="pull-right text" for="no">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bottom_bar_d filter_bar">
                        <p class="filtered_total_result">0 Results shown</p>
                        <span>
                            <a href="#" class="normal_style" onclick="ResetDomainPage(this)">Reset</a>
                            <a href="#" onclick="applyfillter(this)" class="cm_style">Apply</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>   