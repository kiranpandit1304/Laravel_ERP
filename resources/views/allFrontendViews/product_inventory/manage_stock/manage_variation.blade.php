        <!-- Add Manage Variation Stock -->
        <div class="modal fade twoside_modal same_cr_ec" id="manageveriPopup" tabindex="-1" role="dialog" aria-labelledby="manageveriPopupLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close close_manageveriPopup" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <form action="javascript:void(0)" id="manageVariationForm_d" method="post">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-xs-12">
                                    <div class="shinvite">
                                        <div class="shi_header">
                                            <h5>Manage</h5>
                                            <a href="#"><iconify-icon icon="ph:info"></iconify-icon></a>
                                        </div>
                                        <div class="shi_body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <input type="text" class="varit_name" placeholder="Variation Name" value="" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group qspan">
                                                        <label>
                                                            <input type="number" class="varit_qty" placeholder="Quantity">
                                                            <span>Quantity</span>
                                                        </label>
                                                        <!-- <span>KG</span> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row vendor_show hide">
                                                <div class="col-lg-11">
                                                    <select class="ddl-select" class="varit_vedor_id" id="listunitt4" name="vendor_id">
                                                            @foreach($vend_cutomers as $data)
                                                            <option value="{{@$data['id']}}" data-type="{{@$data['user_type']}}">{{@$data['name']}} </option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-1">
                                                    <a href="#" class="hide_vendor"><iconify-icon icon="material-symbols:close-rounded"></iconify-icon></a>
                                                </div>
                                            </div>
                                            <div class="row custom_field_alert">
                                                <div class="col-lg-11">
                                                    <div class="form-group qspan">
                                                        <label>
                                                            <input type="number" class="varit_low_qty" placeholder="Low Stock Quantity">
                                                            <span>Low Stock Quantity</span>
                                                        </label>
                                                        <!-- <span>KG</span> -->
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <a href="#" class="hide_bar"><iconify-icon icon="material-symbols:close-rounded"></iconify-icon></a>
                                                </div>
                                            </div>
                                            <div class="row custom_field">
                                                <div class="col-lg-4">
                                                    <input type="text" class="varit_custom_key" placeholder="Field Name">
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="form-group">
                                                        <input type="text" class="varit_custom_value" placeholder="value">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <a href="#" class="hide_bar"><iconify-icon icon="material-symbols:close-rounded"></iconify-icon></a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <button class="add_line add_more add_vendor" type="button">
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
                                                        Add Vendor
                                                    </button>
                                                    <!-- <br />
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
                                                    </button> -->
                                                    <br />
                                                    <button class="add_line add_more alert_btn" type="button">
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
                                                        Add Low Stock Alert
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="save_varit_id" value="">
                                        <input type="hidden" class="fist_time_stock_d" value="1">

                                        <div class="shi_footer">
                                            <button id="ch_to_table" class="done_btn show_stock" onclick="UpdateNewStock(this)">Save</button>
                                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
        </div>