 <!-- Import Customer Popup -->
 <div class="modal fade twoside_modal" id="importPopup" tabindex="-1" role="dialog" aria-labelledby="importPopupLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-5 col-sm-5 col-xs-12">
                                <div class="team_list">
                                    <div class="tl_header">
                                        <h5>Process</h5>
                                    </div>
                                    <div class="tlist">
                                        <ul class="step-tab-items">
                                            <li class="step-item active">
                                                <span>
                                                    <iconify-icon icon="material-symbols:download"></iconify-icon>
                                                </span>
                                                <div class="side_text">
                                                    <h6>Download Template</h6>
                                                    <p>Download pre-made templates</p>
                                                </div>
                                            </li>
                                            <li class="step-item">
                                                <span>
                                                    <iconify-icon icon="gala:data"></iconify-icon>
                                                </span>
                                                <div class="side_text">
                                                    <h6>Data Formatting</h6>
                                                    <p>Format your data</p>
                                                </div>
                                            </li>
                                            <li class="step-item">
                                                <span>
                                                    <iconify-icon icon="material-symbols:file-copy-outline"></iconify-icon>
                                                </span>
                                                <div class="side_text">
                                                    <h6>Select Files</h6>
                                                    <p>Select your files here</p>
                                                </div>
                                            </li>
                                            <li class="step-item">
                                                <span>
                                                    <iconify-icon icon="material-symbols:assignment-outline"></iconify-icon>
                                                </span>
                                                <div class="side_text">
                                                    <h6>Finish</h6>
                                                    <p>Verify your files</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-sm-7 col-xs-12 flush">
                                <div class="shinvite">
                                    <div class="shi_header">
                                        <h5>Import Customer</h5>
                                        <a href="#"><iconify-icon icon="ph:info"></iconify-icon></a>
                                    </div>
                                    <div class="shi_body">
                                        <div class="steps">
                                            <div class="step-tabs">
                                                <div class="step-tab active" id="step-i1">

                                                    <div class="templates">
                                                        <h2>Use a template for easy importing</h2>
                                                        <p>We've created a custom template based on your customer attributes.</p>
                                                        <a href="{{asset('/export_sample/sample-customer.csv')}}" target="_blank">Download Template</a>
                                                    </div>

                                                    <div class="form-submit text-right">
                                                        <button class="form-btn" type="button" tab-target="step-i2">Next <iconify-icon icon="material-symbols:arrow-forward-rounded"></iconify-icon></button>
                                                    </div>
                                                </div>

                                                <div class="step-tab" id="step-i2">

                                                    <div class="templates">
                                                        <h2>Check your data format</h2>
                                                        <p>We've created a custom data based on your customer attributes.</p>
                                                        <div class="inner_cards">
                                                            <div class="icards">
                                                                <h6>Dates</h6>
                                                                <p>Preferred formate are YYYY-MM-DD and MM-DD-YYYY.</p>
                                                                <a href="#">Read more</a>
                                                            </div>
                                                            <div class="icards">
                                                                <h6>Phone number</h6>
                                                                <p>A country code will be added to all phone numbers without a country code</p>
                                                                <a href="#">Read more</a>
                                                            </div>
                                                            <div class="icards">
                                                                <h6>Birthday</h6>
                                                                <p>Preferred formate are YYYY-MM-DD and MM-DD-YYYY.</p>
                                                                <a href="#">Read more</a>
                                                            </div>
                                                            <div class="icards">
                                                                <h6>Address</h6>
                                                                <p>A country code will be added to all phone numbers without a country code</p>
                                                                <a href="#">Read more</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-submit grid-2">
                                                        <button type="button" class="form-btn" tab-target="step-i1"><iconify-icon icon="material-symbols:arrow-back-rounded"></iconify-icon> Previous</button>
                                                        <button type="button" class="form-btn" tab-target="step-i3">Next <iconify-icon icon="material-symbols:arrow-forward-rounded"></iconify-icon></button>
                                                    </div>
                                                </div>

                                                <div class="step-tab" id="step-i3">
                                                <form id="cusForm_import_d" action="javascript:void(0)" method="post" >

                                                <div class="dropzone dz-default dz-message " id="desktop_media">

                                                  </div>
                                                    <div class="form-submit grid-2">
                                                        <button type="button" class="form-btn" tab-target="step-i2"><iconify-icon icon="material-symbols:arrow-back-rounded"></iconify-icon> Previous</button>
                                                        <button type="submit" class="form-btn cust_import_file">Save <iconify-icon icon="charm:tick"></iconify-icon></button>
                                                        <button type="button" class="form-btn  next_imp_btn hide-d" tab-target="step-i4">Next <iconify-icon icon="material-symbols:arrow-forward-rounded"></iconify-icon></button>
                                                    </div>
                                                </form>
                                                </div>
                                                <div class="step-tab" id="step-i4">
                                                <div class="cc_card">
                                                            <lottie-player src="https://lottie.host/a6963a1c-1049-4992-a95a-d016d2d07948/fVRIDbvFti.json"  background="transparent"  speed="1"  style="width: 100px; height: 100px;"  loop  autoplay></lottie-player>
                                                            <div class="content_cc">
                                                                <h6>Customer created successfully</h6>
                                                                <p>This customer is created successfully now you can skip and go to dashboard</p>
                                                                <a href="{{route('fn.dashboard')}}">Go to dashboard</a>
                                                            </div>
                                                        </div>
                                                    <div class="form-submit grid-2">
                                                        <!-- <button type="button" class="form-btn" tab-target="step-i3"><iconify-icon icon="material-symbols:arrow-back-rounded"></iconify-icon> Previous</button> -->
                                                        <button type="submit" class="form-btn" data-dismiss="modal" aria-label="Close">Finish <iconify-icon icon="charm:tick"></iconify-icon></button>
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
            </div>
        </div>
