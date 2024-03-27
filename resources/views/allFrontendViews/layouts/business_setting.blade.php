<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Unesync Product Prototype</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('unsync_assets/assets/images/favicon.ico') }}" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('unsync_assets/assets/css/backend.css') }}" />
    <!-- <link rel="stylesheet" href="assets/css/backend.min.css" /> -->
    <link rel="stylesheet" href="{{asset('unsync_assets/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{asset('unsync_assets/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{asset('unsync_assets/assets/vendor/remixicon/fonts/remixicon.css') }}" />

    <link rel="stylesheet" href="https://foliotek.github.io/Croppie/croppie.css" />
    <link rel="stylesheet" href="{{asset('unsync_assets/assets/css/select2.css') }}">
    <link rel="stylesheet" href="{{asset('unsync_assets/assets/css/select2-bootstrap4.css') }}">

    <!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" /> -->
    <link rel="stylesheet" href="{{asset('unsync_assets/assets/css/datepicker.css') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css" />

    <script>
        var APP_URL = <?= json_encode(url('/')) ?>;
        var csrfTokenVal = <?= json_encode(csrf_token()) ?>;
        var tokenString = localStorage.getItem('token');
        var has_edit_permission = <?= json_encode($has_edit_permission) ?>;

        if (tokenString == '' || tokenString == null || tokenString == undefined) {
            window.location.href = "/en/login";
        }
        var enyptID = <?= json_encode($enypt_id) ?>;
        var currentUser = JSON.parse(localStorage.getItem('user'));

        function block_gui_start() {
            $(".page_loader").addClass('ajax_call');
            $(".page_loader").css('display', 'block');
        }

        function block_gui_end() {

            $(".page_loader").removeClass('ajax_call');
            $(".page_loader").css('display', 'none');
        }
    </script>
    <style type="text/css">
        .error {
            color: red !important;
        }

        .hide-d {
            display: none !important;
        }

        .page_loader {
            background: rgba(255, 255, 255, 0.7);
            position: fixed;
            z-index: 99999;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .page_loader.ajax_call {
            background: rgba(255, 255, 255, 0.75);
        }

        .page_loader img {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100px;
            height: 100px;
            margin: -36px 0 0 -36px;
        }

        .error {
            color: red
        }
    </style>
    <div class="page_loader" style="display:none">
        <img src="{!! URL::asset('Ripple.svg') !!}" alt="image description">
    </div>
</head>

<body class="  ">
    <!-- Wrapper Start -->
    <div class="border"></div>
    <div class="top_notch">
        <div class="notch">
            <button type="button" class="btn btn-secondary mt-2" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Tooltip on bottom">
                <iconify-icon icon="ph:info"></iconify-icon>
            </button>
            <h6>Practise Mode</h6>
            <div class="pr_mode">
                <input id="pr_mode1" type="checkbox" hidden="hidden" checked />
                <label class="switch" for="pr_mode1"></label>
            </div>
        </div>
    </div>
    <div class="bottom_notch">
        <div class="notch">
            <h6>Changes will not be saved in Practise Mode</h6>
        </div>
    </div>
    <div class="wrapper">
        <div class="iq-sidebar sidebar-default">
            <div class="iq-sidebar-logo d-flex align-items-center justify-content-between advance_logo">
                <a href="#" class="dropdown-toggle circle-hover header-logo" id="dropdownMenuButton02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="{{asset('unsync_assets/assets/images/logo.png')}}" class="img-fluid rounded-normal light-logo" alt="logo" />
                    <iconify-icon icon="bx:rotate-left"></iconify-icon>
                </a>
                @include('allFrontendViews.layouts.sideTopBar')
                <div class="iq-menu-bt-sidebar">
                    <i class="las la-bars wrapper-menu"></i>
                </div>
            </div>
            <div class="data-scrollbar user_setting" data-scroll="1">
                <nav class="iq-sidebar-menu">
                    <a href="{{route('fn.dashboard', $enypt_id)}}" class="bch"><iconify-icon icon="material-symbols:arrow-back-rounded"></iconify-icon> Back to home</a>
                    <h2>Setting</h2>
                    <ul id="iq-sidebar-toggle" class="iq-menu">
                        <li class="active">
                            <a href="#mydrive" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <iconify-icon icon="ic:baseline-arrow-right" class="iq-arrow-right arrow-active"></iconify-icon>
                                <iconify-icon icon="ic:baseline-arrow-drop-down" class="iq-arrow-right arrow-hover"></iconify-icon>
                                <span class="squre_icon"><iconify-icon icon="mdi:user-circle-outline"></iconify-icon></span><span>User Setting</span>
                            </a>
                            <ul id="mydrive" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                <li class="op_profile_section active">
                                    <a href="#">
                                        <span class="squre_icon"><iconify-icon icon="material-symbols:account-circle-outline"></iconify-icon></span><span>Profile</span>
                                    </a>
                                </li>
                                <li class="op_account_section">
                                    <a href="#">
                                        <span class="squre_icon"><iconify-icon icon="material-symbols:account-balance-outline-rounded"></iconify-icon></span><span>Subscription</span>
                                    </a>
                                </li>
                                <li class="op_password_section">
                                    <a href="#">
                                        <span class="squre_icon"><iconify-icon icon="ic:round-lock-open"></iconify-icon></span><span>Password Change</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul id="iq-sidebar-toggle" class="iq-menu">
                        <li class="">
                            <a href="#mydrive" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <iconify-icon icon="ic:baseline-arrow-right" class="iq-arrow-right arrow-active"></iconify-icon>
                                <iconify-icon icon="ic:baseline-arrow-drop-down" class="iq-arrow-right arrow-hover"></iconify-icon>
                                <span class="squre_icon"><iconify-icon icon="material-symbols:business-center-outline"></iconify-icon></span><span>Business Setting</span>
                            </a>
                            <ul id="mydrive" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                <li class="op_business_profile">
                                    <a href="#">
                                        <span class="squre_icon"><iconify-icon icon="material-symbols:account-circle-outline"></iconify-icon></span><span>Business Profile</span>
                                    </a>
                                </li>
                                <li class="op_business_account">
                                    <a href="#">
                                        <span class="squre_icon"><iconify-icon icon="material-symbols:account-balance-rounded"></iconify-icon></span><span>Account Details</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- ...topbar -->
        @include('allFrontendViews.layouts.topbar')
        <!-- ...topbar end -->
        <div class="content-page gray_bg">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 flush allttstyle">
                        <div class="profile_section show">
                            <h3>User Profile</h3>
                            <p>Please enter your details, picture etc.</p>
                            <div class="comn_card">
                                <form action="">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="avatar">
                                                <h3>Avatar</h3>
                                                <div class="avatar-upload">
                                                    <div class="avatar-edit">
                                                        <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                                                        <label for="imageUpload">Upload Now</label>
                                                    </div>
                                                    <div class="avatar-preview">
                                                        <div id="imagePreview" style="background:url(assets/images/avbatar_place.png)">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label>
                                                <input type="text" required="" id="" value="" placeholder="First Name">
                                                <span>First Name</span>
                                            </label>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label>
                                                <input type="text" required="" id="" value="" placeholder="Last Name">
                                                <span>Last Name</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label>
                                                <input type="email" required="" id="" value="" placeholder="Email">
                                                <span>Email</span>
                                            </label>
                                        </div>
                                        <div class="form-group col-sm-6 cpnumber">
                                            <label class="phone">
                                                <div class="prefix">+91</div>
                                                <input type="text" class=" billing_phone" name="billing_phone" id="phone" value="" placeholder="Phone Number">
                                                <span>Phone Number</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="master_action">
                                        <button>Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="account_section">
                            <h3>Subscription details</h3>
                            <p>You can see Subscription details, UPI etc.</p>

                        </div>

                        <div class="password_section">
                            <h3>Password</h3>
                            <p>Please enter your current password to change your password</p>
                            <br />
                            <div class="comn_card">
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <label>
                                            <input type="password" required="" id="" value="" placeholder="Currant password">
                                            <span>Currant password</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label>
                                            <input type="password" required="" id="" value="" placeholder="New password">
                                            <span>New password</span>
                                        </label>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>
                                            <input type="password" required="" id="" value="" placeholder="Confirm new password">
                                            <span>Confirm new password</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="master_action">
                                <button>Save</button>
                            </div>
                        </div>

                        <div class="notification_section">
                            <h3>Notification & Alerts</h3>
                            <p>Please change notification setting as your needs.</p>
                            <div class="comn_card">
                                <ul>
                                    <li>
                                        <div class="sw_content">
                                            <h4>Testimonial Emails</h4>
                                            <p>Collect automatic testimonials from your clients when an invoice is paid offline</p>
                                        </div>
                                        <label class="switch">
                                            <input type="checkbox">
                                            <span class="slider"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <div class="sw_content">
                                            <h4>Payment Receipts</h4>
                                            <p>Automatically inform the client when an invoice is marked paid offline</p>
                                        </div>
                                        <label class="switch">
                                            <input type="checkbox" checked>
                                            <span class="slider"></span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="business_profile">
                            <h3>Business Profile</h3>
                            <p>Please enter your business details, picture etc.</p>
                            <div class="comn_card">
                                <form action="javascript:void(0)" method="post" id="EditBusinessForm">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="avatar">
                                                <h3>Business Logo</h3>
                                                <div class="avatar-upload">
                                                    <div class="avatar-edit">
                                                        <input type='file' name="business_logo" id="imageUpload2" accept=".png, .jpg, .jpeg" />
                                                        <label for="imageUpload2">Upload Now</label>
                                                    </div>
                                                    <div class="avatar-preview">
                                                        <div id="imagePreview2" style="background:url(<?= @$commonData['active_business_data']->business_logo ?>)">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label>
                                                <input type="text" class="business_name" name="business_name" required="" id="" value="{{@$commonData['active_business_data']->business_name}}" placeholder="Business Name">
                                                <span>Business Name</span>
                                            </label>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label>
                                                <input type="text" class="brand_name" name="brand_name" required="" id="" value="{{@$commonData['active_business_data']->brand_name}}" placeholder="Brand Name">
                                                <span>Brand Name</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label>
                                                <input type="email" class="business_email" name="business_email" required="" id="" value="{{@$commonData['active_business_data']->email}}" placeholder="Email">
                                                <span>Email</span>
                                            </label>
                                        </div>
                                    </div>
                                    <input type="hidden" class="business_id" value="{{@$commonData['active_business_data']->id}}" />
                                    <div class="master_action">
                                        <button class="updateBusinessData" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="business_account">
                            <h3>Business Account Details</h3>
                            <p>Please enter your business details, picture etc.</p>
                            <br />
                            <div class="comn_card">
                                <form action="javascript:void(0)" method="post" id="EditBusinessDetailForm">
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label class="d-block">Have GST number?</label>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadio6" name="is_gst" class="custom-control-input" value="1" {{ @$commonData['active_business_data']->is_gst == 1 ? 'checked' : ''}}>
                                                <label class="custom-control-label" for="customRadio6"> Yes, I have </label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadio7" name="is_gst" class="custom-control-input" value="0" {{ @$commonData['active_business_data']->is_gst == 0 ? 'checked' : ''}}>
                                                <label class="custom-control-label" for="customRadio7"> No, I don't have </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row have_gstsetup1 {{$commonData['active_business_data']->is_gst ==1 ? 'show' : '' }} ">
                                        <div class="form-group col-sm-12">
                                            <label>
                                                <input type="text" class="business_gst get_edit_business_gst_data" name="gst_no" id="" value="{{@$commonData['active_business_data']->gst_no}}" placeholder="Enter GST number">
                                                <span>Enter GST number</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label>
                                                <input type="text" class="street_address" name="street_address" id="" value="{{@$commonData['active_business_data']->street_address}}" placeholder="Street Address">
                                                <span>Street Address</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <select class="js-example-placeholder-single-cuntry js-states form-control business_country" name="business_country">
                                                <option></option>
                                                @foreach($commonData['countryList'] as $country)
                                                <option value="{{@$country->id}}" value="{{@$country->id}}" {{ $country->id == $commonData['active_business_data']->country_id ? 'selected' : ''}}>{{@$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <select class="js-example-placeholder-single-state js-states form-control business_state" name="business_state">
                                                <option></option>
                                                @foreach($commonData['stateList'] as $state)
                                                <option value="{{$state->id}}" {{ $state->id == $commonData['active_business_data']->state_id ? 'selected' : ''}}>{{$state->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label>
                                                <input type="text" class="zip_code" name="zip_code" value="{{@$commonData['active_business_data']->zip_code}}" required="" id="" placeholder="Code" />
                                                <span>Postal Code</span>
                                            </label>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label>
                                                <input type="text" id="" class="pan_no" name="pan_no" value="{{@$commonData['active_business_data']->pan_no}}" placeholder="PAN">
                                                <span>PAN</span>
                                            </label>
                                        </div>
                                    </div>
                                    <input type="hidden" class="business_id" value="{{@$commonData['active_business_data']->id}}" />
                                    <div class="master_action">
                                        <button class="updateBusinessDdetailData">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNotification" aria-labelledby="offcanvasNotificationLabel">
        <div class="offcanvas-header">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
            </button>
            <h5 class="offcanvas-title" id="offcanvasNotificationLabel">Notifications</h5>
            <span>&nbsp;</span>
        </div>
        <div class="offcanvas-body">
            <div class="offcanvas_details">

                <div class="ft_item notification_box">
                    <a href="#">
                        <div class="card-item">
                            <span class="bg_yellow squre_icon"><iconify-icon icon="tabler:brand-abstract"></iconify-icon></span>
                            <div class="item-text">
                                <h3>New Invoice Generated</h3>
                                <p>2m ago</p>
                            </div>
                            <span class="close_icon"><iconify-icon icon="material-symbols:close-rounded"></iconify-icon></span>
                        </div>
                    </a>
                    <a href="#">
                        <div class="card-item">
                            <span class="bg_green squre_icon"><iconify-icon icon="material-symbols:account-balance-wallet-outline"></iconify-icon></span>
                            <div class="item-text">
                                <h3>New Password created</h3>
                                <p>2m ago</p>
                            </div>
                            <span class="close_icon"><iconify-icon icon="material-symbols:close-rounded"></iconify-icon></span>
                        </div>
                    </a>
                    <a href="#">
                        <div class="card-item">
                            <span class="bg_purple squre_icon"><iconify-icon icon="material-symbols:leaderboard-outline-rounded"></iconify-icon></span>
                            <div class="item-text">
                                <h3>Your password has been saved.</h3>
                                <p>2m ago</p>
                            </div>
                            <span class="close_icon"><iconify-icon icon="material-symbols:close-rounded"></iconify-icon></span>
                        </div>
                    </a>
                </div>

                <div class="bottom_bar_d filter_bar">
                    <p>3 Notifications</p>
                    <span>
                        <a href="#" class="normal_style">Remove All</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    @include('allFrontendViews.layouts.modals.businessModal')
    @include('allFrontendViews.layouts.modals.manage_application')
    @include('allFrontendViews.layouts.modals.notification')

    <!-- Backend Bundle JavaScript -->
    <script src="{{asset('unsync_assets/assets/js/backend-bundle.min.js') }}"></script>

    <script src="{{asset('unsync_assets/assets/js/main-custom.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script src="{{asset('unsync_assets/assets/js/customizer.js') }}"></script>

    <script src="https://bxslider.com/lib/jquery.bxslider.js"></script>

    <script src="https://foliotek.github.io/Croppie/croppie.js"></script>

    <script src="https://code.iconify.design/iconify-icon/1.0.3/iconify-icon.min.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    <!-- <script src="assets/js/invite_tags_search.js"></script> -->
    <script src="{{asset('unsync_assets/assets/js/app.js') }}"></script>
    <script src="{{asset('unsync_assets/assets/js/datepicker.all.js') }}"></script>
    <script src="{{asset('unsync_assets/assets/js/datepicker.en.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js" integrity="sha256-AFAYEOkzB6iIKnTYZOdUf9FFje6lOTYdwRJKwTN5mks=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- File Upload Create Customer -->
    <script src="https://unpkg.com/react@latest/umd/react.development.js"></script>
    <script src="https://unpkg.com/react-dom@latest/umd/react-dom.development.js"></script>
    <script src="https://unpkg.com/prop-types/prop-types.js"></script>
    <script src="https://unpkg.com/react-quill@latest/dist/react-quill.js"></script>
    <script src="{{asset('unsync_assets/assets/js/jquery.ui.widget.js') }}"></script>
    <script src="{{asset('unsync_assets/assets/js/jquery.fileupload.js') }}"></script>
    <script src="{{asset('unsync_assets/assets/js/jquery.iframe-transport.js') }}"></script>
    <script src="{{asset('unsync_assets/assets/js/jquery.fancy-fileupload.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    <!-- <script>
            $(".js-states.form-control.nosearch").select2({
                minimumResultsForSearch: Infinity,
                theme: 'bootstrap4',
            });
        </script> -->
    @stack('custom-scripts')
    @stack('sub-scripts')
    <script>
        function switchBusiness(event) {
            var business_id = $(event).attr("data-id");
            $.ajax({
                url: APP_URL + '/api/activeBusinessIdUpdate',
                type: "post",
                data: {
                    'business_id': business_id
                },
                beforeSend: function(xhr) {
                    block_gui_start();
                    xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

                },
                success: function(response) {
                    if (response.status == true) {
                        window.location.reload();
                        toastr.success(response.message);
                        block_gui_start();

                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(response) {
                    block_gui_end();
                    console.log("server side error");
                }
            });
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });

        function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview2').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview2').hide();
                    $('#imagePreview2').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload2").change(function() {
            readURL2(this);
        });
    </script>

    <script>
        $("body").on("click", ".updateBusinessData", function() {

            $(".error").remove();
            if ($(".business_email").val().length < 1) {
                $('.business_email').after('<span class="error">This field is required</span>');
                return false;
            }
            if ($(".business_name").val().length < 1) {
                $('.business_name').after('<span class="error">This field is required</span>');
                return false;
            }
            if ($(".brand_name").val().length < 1) {
                $('.brand_name').after('<span class="error">This field is required</span>');
                return false;
            }

            var form = $("#EditBusinessForm")[0];
            var formData = new FormData(form);
            formData.append('email', $(".business_email").val());
            businessAjaxFormRequest(formData);

        });

        function businessAjaxFormRequest(formData) {

            formData.append('id', $(".business_id").val());
            formData.append('platform', "Unesync");
            formData.append('guard', "WEB");

            $.ajax({
                url: APP_URL + "/api/BusinesEdit",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(xhr) {
                    block_gui_start();
                    xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

                },
                success: function(response) {
                    block_gui_end();
                    if (response.status == true) {
                        toastr.success(response.message);

                    } else {
                        toastr.error(response.message);
                    }

                },
                error: function(response) {
                    block_gui_end();
                    console.log("server side error");
                }
            });
        }

        $("body").on("click", ".updateBusinessDdetailData", function() {

            var form = $("#EditBusinessDetailForm")[0];
            var formData = new FormData(form);
            formData.append('country_id', $(".business_country").val());
            formData.append('state_id', $(".business_state").val());

            businessAjaxFormRequest(formData);
        })

        // 06AAHCD4406B1Z8 get tax details
        $("body").on("focusout", ".get_edit_business_gst_data", function() {
            var gst_number = $('.business_gst').val();

            if (gst_number == '' || gst_number == undefined) {
                $(".business_gst").css("border", "1px solid red");
                return false;
            } else {
                $(".business_gst").css("border", "");

            }
            $(".pan_no").val(gst_number.slice(2, -3));
            $.ajax({
                url: APP_URL + "/api/getGstDetails/" + gst_number,
                type: "GET",
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(xhr) {
                    block_gui_start();
                    xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

                },
                success: function(response) {
                    block_gui_end();
                    if (response.status == true) {
                        response = response.data
                        $('.business_name').val(response?.lgnm)
                        var addesss = response?.pradr?.addr?.bno + ' ' + response?.pradr?.addr?.bnm + ' ' + response?.pradr?.addr?.st + ' ' + response?.pradr?.addr?.loc + ' ' + response?.pradr?.addr?.dst + ' ' + response?.pradr?.addr?.stcd + ' ' + response?.pradr?.addr?.city + ' ' + response?.pradr?.addr?.pncd
                        $('.street_address').val(addesss);
                        var statelist = state_list.filter(v => v.name === response?.pradr?.addr?.stcd);
                        $('.business_state').val(statelist[0]?.id).change();

                    } else {
                        toastr.error('GST number is not correct.');
                    }
                },
                error: function(response) {
                    block_gui_end();
                    console.log("server side error");
                }
            });
        });
    </script>

    <script>
        // Mini Header
        $(".js-states.form-control.nosearch").select2({
            minimumResultsForSearch: Infinity,
            theme: "bootstrap4",
        });

        // Country
        $(".js-example-placeholder-single-cuntry").select2({
            placeholder: "Select Country",
        });

        // State
        $(".js-example-placeholder-single-state").select2({
            placeholder: "Select State",
        });
    </script>
</body>

</html>