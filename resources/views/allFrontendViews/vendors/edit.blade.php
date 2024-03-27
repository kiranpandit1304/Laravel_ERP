<!-- View Customer Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel" style="overflow: scroll;">
    <div class="offcanvas-header">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <h5 class="offcanvas-title cus_title" id="offcanvasExampleLabel"></h5>
        <div class="card-header-toolbar">
            <div class="dropdown">
                <span class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown" aria-expanded="true">
                    <i class="ri-more-fill"></i>
                </span>
                @if(@$has_edit_permission)
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton2" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-140px, 24px, 0px);">
                    <!-- <a class="dropdown-item" href="#">Edit Vendor</a> -->
                    <a class="dropdown-item" href="#">Merge with another Vendor</a>
                    <a class="dropdown-item" href="#">Delete Vendor</a>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvas_details">
            <form id="CustomerDetailForm1" action="javascript:void(0)" method="post">
                <div class="od_card">
                    <div class="od_card_header">
                        <h3>Vendor Details</h3>
                        @if(@$has_edit_permission)
                        <a href="#" class="edit_btn cust_detail" data-type="edit">Edit</a>
                        @endif
                    </div>
                    <div class="od_card_body">
                        <ul>
                            <li>
                                <label for="">Business/Vendor name</label>
                                <input class="inp_cus_detail fname" type="text" name="name" value="Johan Prince" id="" disabled>
                            </li>
                            <li>
                                <label for="">GST</label>
                                <input class="inp_cus_detail gst_no" type="text" name="gst_no" value="Johan Prince" id="" disabled>
                            </li>
                            <li>
                                <label for="">Email</label>
                                <input class="inp_cus_detail email" type="email" name="email" value="johan12@gmail.com" id="" disabled>
                            </li>
                            <li>
                                <label for="">Nature of Business</label>
                                <input class="inp_cus_detail nature_of_business" type="text" name="nature_of_business" value="Services" id="" disabled>
                            </li>
                            <li>
                                <label for="">Contact Person</label>
                                <input class="inp_cus_detail contact_person" type="text" name="contact_person" value="Johan Prince" id="" disabled>
                            </li>
                            <li>
                                <label for="">Contact Number</label>
                                <input class="inp_cus_detail billing_phone" type="text" name="billing_phone" value="+91 7858765958" id="" disabled>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="od_card">
                    <div class="od_card_header">
                        <h3>Address & Shipping Details</h3>
                        @if(@$has_edit_permission)
                        <a href="#" class="edit_btn address_shipping_detail" data-type="edit">Edit</a>
                        @endif
                    </div>
                    <div class="od_card_body">
                        <ul>
                            <li>
                                <label for="" class="mtitle">Main Address</label>
                                <label for="">Street Address</label>
                                <input class="inp_ship_detail billing_address" type="text" name="billing_address" value="" id="" disabled>
                            </li>
                            <li>
                                <label for="">Country</label>
                                <select class="form-select inp_ship_detail billing_country" name="billing_country" aria-label="Default select example" disabled>
                                    <option>Select Country</option>
                                    @foreach($countryList as $country)
                                    <option value="{{@$country->id}}" {{ $country->id == 101 ? 'selected' : ''}}>{{@$country->name}}</option>
                                    @endforeach
                                </select>
                                </select>
                            </li>
                            <li>
                                <label for="">State</label>
                                <select class="form-select inp_ship_detail billing_state" name="billing_state" aria-label="Default select example" disabled>
                                    <option>Select State</option>
                                    @foreach($stateList as $state)
                                    <option value="{{@$state->id}}">{{@$state->name}}</option>
                                    @endforeach
                                </select>
                            </li>
                            <li>
                                <label for="">Postal Code / Zip Code</label>
                                <input class="inp_ship_detail billing_zip_code" type="text" name="billing_zip_code" value="" id="" disabled>
                            </li>
                            <li>
                                <label for="" class="mtitle">Shipping Details</label>
                                <label for="">Street Address</label>
                                <input class="inp_ship_detail shipping_address " name="shipping_country" type="text" value="" id="shipping_address" disabled>
                            </li>
                            <li>
                                <label for="">Country</label>
                                <select class="form-select inp_ship_detail  shipping_country " name="shipping_state" aria-label="Default select example" disabled>
                                    <option>Select Country</option>
                                    @foreach($countryList as $country)
                                    <option value="{{@$country->id}}" {{ $country->id == 101 ? 'selected' : ''}}>{{@$country->name}}</option>
                                    @endforeach
                                </select>
                                </select>
                            </li>
                            <li>
                                <label for="">State</label>
                                <select class="form-select inp_ship_detail shipping_state" name="shipping_state" aria-label="Default select example" disabled>
                                    <option>Select State</option>
                                    @foreach($stateList as $state)
                                    <option value="{{@$state->id}}">{{@$state->name}}</option>
                                    @endforeach
                                </select>
                            </li>
                            <li>
                                <label for="">Postal Code / Zip Code</label>
                                <input class="inp_ship_detail shipping_zip_code" type="text" name="shipping_zip_code" value="" id="" disabled>

                            </li>
                            <li>
                                <label for="">Business GSTIN</label>
                                <input class="inp_ship_detail bussiness_gstin" type="text" name="bussiness_gstin" value="" id="" disabled>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="od_card">
                    <div class="od_card_header">
                        <h3>Taxation Information</h3>
                        @if(@$has_edit_permission)
                        <a href="#" class="edit_btn tax_information" data-type="edit">Edit</a>
                        @endif
                    </div>
                    <div class="od_card_body">
                        <ul>
                            <li>
                                <label for="">PAN Number</label>
                                <input class="inp_tax_detail pan_no" type="text" name="pan" value="" id="" disabled>
                            </li>

                            <li>
                                <label for="">Is MSME?</label>
                                <input class="inp_tax_detail is_msme _msme_chk" type="checkbox" name="is_msme" value="1" id="" disabled>

                            </li>
                        </ul>
                    </div>
                </div>
                <div class="od_card">
                    <div class="od_card_header">
                        <h3>Payment Details</h3>
                        @if(@$has_edit_permission)
                        <a href="#" class="edit_btn payment_detail_d" data-type="edit">Edit</a>
                        @endif
                    </div>
                    <div class="od_card_body">
                        <ul>
                            <li>
                                <label for="">Bank name</label>
                                <input class="inp_pymnent_detail bank_name" type="text" id="edit_bank_name" name="bank_name" value="" disabled>
                            </li>
                            <li>
                                <label for="">IFSC codee</label>
                                <input class="inp_pymnent_detail ifsc_code" type="text" name="ifsc_code" value="" id="" disabled>
                            </li>
                            <li>
                                <label for="">Account No</label>
                                <input class="inp_pymnent_detail account_no" type="text" name="account_no" value="" id="" disabled>
                            </li>
                            <li>
                                <label for="">Branch Address</label>
                                <input class="inp_pymnent_detail branch_address" type="text" name="branch_address" value="" id="" disabled>
                            </li>
                            <li>
                                <label for="">Country</label>
                                <select class="form-select inp_pymnent_detail country_id" name="country_id" aria-label="Default select example" disabled>
                                    <option>Select Country</option>
                                    @foreach($countryList as $country)
                                    <option value="{{@$country->id}}" {{ $country->id == 101 ? 'selected' : ''}}>{{@$country->name}}</option>
                                    @endforeach
                                </select>
                            </li>
                            <li>
                                <label for="">State</label>
                                <select class="form-select inp_pymnent_detail state_id" name="state_id" aria-label="Default select example" disabled>
                                    <option>Select State</option>
                                    @foreach($stateList as $state)
                                    <option value="{{@$state->id}}">{{@$state->name}}</option>
                                    @endforeach
                                </select>
                            </li>
                            <li>
                                <label for="">Zip Code</label>
                                <input class="inp_pymnent_detail zip_code" type="text" name="zip_code" value="" id="" disabled>
                            </li>
                            <li>
                                <label for="">UPI</label>
                                <input class="inp_pymnent_detail upi" type="text" name="upi" value="" id="" disabled>
                            </li>
                            <li>
                                <label for="">Payment Terms</label>
                                <input class="inp_pymnent_detail payment_terms_days" type="text" name="payment_terms_days" value="" id="" disabled>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="od_card last">
                    <div class="od_card_header">
                        <h3>File Upload</h3>
                        @if(@$has_edit_permission)
                        <a href="#" class="edit_btn upload_file_d" data-type="edit">Upload Files</a>
                        @endif
                    </div>
                    <div class="od_card_body">
                        <div class="dropzone dz-default dz-message hide-d" id="desktop_media">
                        </div>
                        <div class="row" id="desktop_images">
                        </div>
                        <ul class="show_db_media">
                            <li>
                                <div class="file_item">
                                    <div>
                                        <span>
                                            <img src="" alt="">
                                        </span>
                                        <h6>No media found</h6>
                                    </div>
                                    <div class="iabtn">
                                        <!-- <a href="#"><iconify-icon icon="mingcute:delete-2-line"></iconify-icon></a> -->
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <input type="hidden" class="cid" value="" />
            </form>
            <div class="bottom_bar_d">
                <a href="#" class="delte_cutomer_btn"><iconify-icon icon="mingcute:delete-2-line"></iconify-icon> Delete Vendor</a>
            </div>
        </div>
    </div>
</div>