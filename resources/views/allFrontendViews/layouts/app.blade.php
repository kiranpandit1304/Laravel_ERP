<!DOCTYPE html>
@php
// $logo=asset(Storage::url('uploads/logo/'));
$logo=\App\Models\Utility::get_file('uploads/logo/');

$company_logo=Utility::getValByName('company_logo_dark');

$company_logos=Utility::getValByName('company_logo_light');
$company_favicon=Utility::getValByName('company_favicon');
$setting = \App\Models\Utility::colorset();
$color = (!empty($setting['color'])) ? $setting['color'] : 'theme-3';
$company_logo = \App\Models\Utility::GetLogo();
$SITE_RTL= isset($setting['SITE_RTL'])?$setting['SITE_RTL']:'off';
$mode_setting = \App\Models\Utility::mode_layout();





@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{isset($setting['SITE_RTL']) && $setting['SITE_RTL'] == 'on' ? 'rtl' : '' }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Unesync Product Prototype</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('unsync_assets/assets/images/favicon.ico') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('unsync_assets/assets/css/backend.css') }}" />
    <link rel="stylesheet" href="{{asset('unsync_assets/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{asset('unsync_assets/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{asset('unsync_assets/assets/vendor/remixicon/fonts/remixicon.css') }}" />

    <link rel="stylesheet" href="https://foliotek.github.io/Croppie/croppie.css" />

    <!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" /> -->
    <link rel="stylesheet" href="{{asset('unsync_assets/assets/css/datepicker.css') }}" />

    <link rel="stylesheet" href="{{asset('unsync_assets/assets/css/select2.css') }}">
    <link rel="stylesheet" href="{{asset('unsync_assets/assets/css/select2-bootstrap4.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <!-- File upload create customer -->
    <link rel="stylesheet" href="{{asset('unsync_assets/assets/css/fancy_fileupload.css') }}" />
    <!-- Viewer Plugin -->
    <!--PDF-->
    <link rel="stylesheet" href="{{asset('unsync_assets/assets/vendor/doc-viewer/include/pdf/pdf.viewer.css') }}" />
    <!--Docs-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.css" rel="stylesheet" />
    <!--PPTX-->
    <link rel="stylesheet" href="{{asset('unsync_assets/assets/vendor/doc-viewer/include/PPTXjs/css/pptxjs.css') }}" />
    <link rel="stylesheet" href="{{asset('unsync_assets/assets/vendor/doc-viewer/include/PPTXjs/css/nv.d3.min.css') }}" />
    <!--All Spreadsheet -->
    <link rel="stylesheet" href="{{asset('unsync_assets/assets/vendor/doc-viewer/include/SheetJS/handsontable.full.min.css') }}" />
    <!--Image viewer-->
    <link rel="stylesheet" href="{{asset('unsync_assets/assets/vendor/doc-viewer/include/verySimpleImageViewer/css/jquery.verySimpleImageViewer.css') }}" />
    <!--officeToHtml-->
    <link rel="stylesheet" href="{{asset('unsync_assets/assets/vendor/doc-viewer/include/officeToHtml/officeToHtml.css') }}" />
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
    @stack('css-page')
</head>

<body>
    <div class="wrapper">
        @include('allFrontendViews.layouts.sidebar')
        <div class="content-page gray_bg">
            @yield('content')
        </div>
    </div>
    @yield('modals')
    @include('allFrontendViews.layouts.modals.addApplication')
    @include('allFrontendViews.layouts.modals.crope')
    @include('allFrontendViews.layouts.modals.businessModal')
    <!-- .manage_application -->
    @include('allFrontendViews.layouts.modals.notification')

   
    <!-- Backend Bundle JavaScript -->
    <script src="{{asset('unsync_assets/assets/js/backend-bundle.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js" integrity="sha256-AFAYEOkzB6iIKnTYZOdUf9FFje6lOTYdwRJKwTN5mks=" crossorigin="anonymous"></script>

    <!-- Chart Custom JavaScript -->
    <script src="{{asset('unsync_assets/assets/js/main-custom.js')}}"></script>
    <script src="{{asset('unsync_assets/assets/js/customizer.js')}}"></script>


    <!-- Chart Custom JavaScript -->
    <!-- <script src="{{asset('unsync_assets/assets/js/chart-custom.js')}}"></script> -->

    <!--PDF-->
    <!-- <script src="{{asset('unsync_assets/assets/vendor/doc-viewer/include/pdf/pdf.js')}}"></script> -->
    <!--Docs-->
    <!-- <script src="{{asset('unsync_assets/assets/vendor/doc-viewer/include/docx/jszip-utils.js')}}"></script> -->
    <!-- <script src="{{asset('unsync_assets/assets/vendor/doc-viewer/include/docx/mammoth.browser.min.js')}}"></script> -->
    <!--PPTX-->
    <!-- <script src="{{asset('unsync_assets/assets/vendor/doc-viewer/include/PPTXjs/js/filereader.js')}}"></script>
<script src="{{asset('unsync_assets/assets/vendor/doc-viewer/include/PPTXjs/js/d3.min.js')}}"></script>
<script src="{{asset('unsync_assets/assets/vendor/doc-viewer/include/PPTXjs/js/nv.d3.min.js')}}"></script>
<script src="{{asset('unsync_assets/assets/vendor/doc-viewer/include/PPTXjs/js/pptxjs.js')}}"></script>
<script src="{{asset('unsync_assets/assets/vendor/doc-viewer/include/PPTXjs/js/divs2slides.js')}}"></script> -->
    <!-- <script src="https://bxslider.com/lib/jquery.bxslider.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.js"></script>
    <!--All Spreadsheet -->
    <script src="{{asset('unsync_assets/assets/vendor/doc-viewer/include/SheetJS/handsontable.full.min.js')}}"></script>
    <script src="{{asset('unsync_assets/assets/vendor/doc-viewer/include/SheetJS/xlsx.full.min.js')}}"></script>
    <!--Image viewer-->
    <script src="{{asset('unsync_assets/assets/vendor/doc-viewer/include/verySimpleImageViewer/js/jquery.verySimpleImageViewer.js')}}"></script>
    <!--officeToHtml-->
    <!-- <script src="{{asset('unsync_assets/assets/vendor/doc-viewer/include/officeToHtml/officeToHtml.js')}}"></script> -->
    <script src="{{asset('unsync_assets/assets/js/doc-viewer.js')}}"></script>

    <script src="https://foliotek.github.io/Croppie/croppie.js"></script>

    <script src="https://code.iconify.design/iconify-icon/1.0.3/iconify-icon.min.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <!-- app JavaScript -->
    <script src="{{asset('unsync_assets/assets/js/invite_tags_search.js')}}"></script>
    <script src="{{asset('unsync_assets/assets/js/app.js')}}"></script>
    <script src="{{asset('js/UserstateCountry.js')}}"></script>
    <!-- <script src="{{asset('unsync_assets/assets/js/datepicker.all.js')}}"></script>
    <script src="{{asset('unsync_assets/assets/js/datepicker.en.js')}}"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script> -->

    @stack('custom-scripts')
    @stack('sub-scripts')
    <script>
        
        function switchBusiness(event) {
            var business_id = $(event).attr("data-id");
            $.ajax({
                url: APP_URL + '/api/activeBusinessIdUpdate',
                type: "post",
                data: {'business_id': business_id},
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

        function logoutUser() {
            $.ajax({
                url: APP_URL + '/api/logout',
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(xhr) {
                    block_gui_start();
                    xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

                },
                success: function(response) {
                    localStorage.removeItem('token');
                    localStorage.removeItem('user');
                    localStorage.removeItem('user_id');
                    window.location.href = APP_URL + '/en/login'

                },
                error: function(response) {
                    block_gui_end();
                    console.log("server side error");
                }
            });
        }
    </script>

    <script>
        $(".navbar-expand-lg .navbar-nav .dropdown-menu").on("click", function(e) {
            e.stopPropagation();
        });
    </script>
    <script>
            $(function() {
                $('input').on('change', function() {
                    var input = $(this);
                    if (input.val().length) {
                    input.addClass('populated');
                    } else {
                    input.removeClass('populated');
                    }
                });
                setTimeout(function() {
                    $('#fname').trigger('focus');
                }, 500);
            });
        </script>
    <script>
        $(document).ready(function() {
            $(".bxslider").bxSlider({
                slideWidth: 622,
                minSlides: 1,
                maxSlides: 1,
                slideMargin: 5,
                controls: false,
                auto: true,
                autoControls: false,
                stopAutoOnClick: false,
            });
        });
    </script>

    <script>
        // for form steps
        const allStepBtn = document.querySelectorAll('[tab-target]')
        const allStepItem = document.querySelectorAll('.step-item')
        const allTabs = document.querySelectorAll('.step-tab')
        allStepBtn.forEach(item => {
            item.addEventListener('click', () => {
                let currentTabId = item.getAttribute('tab-target')
                let currentTab = document.getElementById(`${currentTabId}`)

                allStepItem.forEach(item => {
                    item.classList.remove('active')
                })

                allTabs.forEach((tab, i) => {
                    if (tab.id === currentTab.id) {
                        for (let l = 0; i >= 0; i--) {
                            allStepItem[i].classList.add('active')
                        }

                    }
                })

                allTabs.forEach(item => {
                    item.classList.remove('active')
                })

                currentTab.classList.add('active')
                item.classList.add('active')
            })
        })
    </script>
    <!-- /*************************** Toggle Practise Mode */ -->
    <script>
        $(document).ready(function() {
            // Get references to both toggle switches
            var $toggle1 = $("#pr_mode");
            var $toggle2 = $("#pr_mode1");

            // Add a "change" event listener to both toggle switches
            $toggle1.add($toggle2).change(function() {
                // Get the state of the toggle that was changed
                var toggleState = $(this).prop("checked");

                // Set the state of both toggle switches to match
                $toggle1.prop("checked", toggleState);
                $toggle2.prop("checked", toggleState);

                // Update the UI based on the new state
                if (toggleState) {
                    setTimeout(function() {
                        $(".border").show();
                        $(".top_notch").show();
                        $(".bottom_notch").show();
                    }, 500); // delay in milliseconds
                } else {
                    setTimeout(function() {
                        $(".border").hide();
                        $(".top_notch").hide();
                        $(".bottom_notch").hide();
                    }, 500); // delay in milliseconds
                }
            });
        });
    </script>
    <script>
        /*************** Welcome Model */
        $(window).on('load', function() {
            setTimeout(function() {
                $('#welcomeModel').modal('show');
            }, 0);
        });
    </script>
    <script>
        $(function() {
            $(".ddl-select").each(function() {
                $(this).hide();
                var $select = $(this);
                var _id = $(this).attr("id");
                var wrapper = document.createElement("div");
                wrapper.setAttribute("class", "ddl ddl_" + _id);

                var input = document.createElement("input");
                input.setAttribute("type", "text");
                input.setAttribute("class", "ddl-input");
                input.setAttribute("id", "ddl_" + _id);
                input.setAttribute("readonly", "readonly");
                input.setAttribute("placeholder", $(this)[0].options[$(this)[0].selectedIndex].innerText);

                $(this).before(wrapper);
                var $ddl = $(".ddl_" + _id);
                $ddl.append(input);
                $ddl.append("<div class='ddl-options ddl-options-" + _id + "'></div>");
                var $ddl_input = $("#ddl_" + _id);
                var $ops_list = $(".ddl-options-" + _id);
                var $ops = $(this)[0].options;
                for (var i = 0; i < $ops.length; i++) {
                    $ops_list.append("<div data-value='" + $ops[i].value + "'>" + $ops[i].innerText + "</div>");
                }

                $ddl_input.click(function() {
                    $ddl.toggleClass("active");
                });
                $ddl_input.blur(function() {
                    $ddl.removeClass("active");
                });
                $ops_list.find("div").click(function() {
                    $select.val($(this).data("value")).trigger("change");
                    $ddl_input.val($(this).text());
                    $ddl.removeClass("active");
                });
            });
        });
    </script>
    <script>
        var langArray = [];
        $(".vodiapicker option").each(function() {
            var img = $(this).attr("data-thumbnail");
            var text = this.innerText;
            var value = $(this).val();
            var item = '<li><div><img src="' + img + '" alt="" value="' + value + '"/></div><span>' + text + "</span></li>";
            langArray.push(item);
        });

        $("#a").html(langArray);

        //Set the button value to the first el of the array
        $(".btn-select").html(langArray[0]);
        $(".btn-select").attr("value", "en");

        //change button stuff on click
        $("#a li").click(function() {
            var img = $(this).find("img").attr("src");
            var value = $(this).find("img").attr("value");
            var text = this.innerText;
            var item = '<li><div><img src="' + img + '" alt="" /></div><span>' + text + "</span></li>";
            $(".btn-select").html(item);
            $(".btn-select").attr("value", value);
            $(".b").toggle();
            $(".lang-select").toggleClass("arrow");
            //console.log(value);
        });

        $(".btn-select").click(function() {
            $(".b").toggle();
            $(".lang-select").toggleClass("arrow");
        });

        //check local storage for the lang
        var sessionLang = localStorage.getItem("lang");
        if (sessionLang) {
            //find an item with value of sessionLang
            var langIndex = langArray.indexOf(sessionLang);
            $(".btn-select").html(langArray[langIndex]);
            $(".btn-select").attr("value", sessionLang);
        } else {
            var langIndex = langArray.indexOf("ch");
            console.log(langIndex);
            $(".btn-select").html(langArray[langIndex]);
            //$('.btn-select').attr('value', 'en');
        }
    </script>
    <script>
        /**************************************** */


        // Start upload preview image
        $(".gambar").attr("src", "assets/images/image_place.png");
        var $uploadCrop,
            tempFilename,
            rawImg,
            imageId;

        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.upload-demo').addClass('ready');
                    $('#cropImagePop').modal('show');
                    rawImg = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                swal("Sorry - you're browser doesn't support the FileReader API");
            }
        }

        $uploadCrop = $('#upload-demo').croppie({
            viewport: {
                width: 275,
                height: 100,
            },
            enforceBoundary: false,
            enableExif: true
        });
        $('#cropImagePop').on('shown.bs.modal', function() {
            // alert('Shown pop');
            $uploadCrop.croppie('bind', {
                url: rawImg
            }).then(function() {
                console.log('jQuery bind complete');
            });
        });

        $('.item-img').on('change', function() {
            imageId = $(this).data('id');
            tempFilename = $(this).val();
            $('#cancelCropBtn').data('id', imageId);
            readFile(this);
        });
        $('#cropImageBtn').on('click', function(ev) {
            $uploadCrop.croppie('result', {
                type: 'base64',
                format: 'jpeg',
                size: {
                    width: 275,
                    height: 100
                }
            }).then(function(resp) {
                $('#item-img-output').attr('src', resp);
                $('#cropImagePop').modal('hide');
            });
        });
        // End upload preview image

        /***************************************** */
    </script>
    <script>
        // Mini Header
        $(".js-states.form-control.nosearch").select2({
            minimumResultsForSearch: Infinity,
            theme: "bootstrap4",
        });
        // Country
        $(".js-example-placeholder-single-cuntry").select2({
            placeholder: "Vendor/Client",
        });
        // State
        $(".js-example-placeholder-single-state").select2({
            placeholder: "Select State",
        });
        // Unit
        $(".js-example-placeholder-single-unit").select2({
            placeholder: "Unit",
        });
        // Currency
        $(".js-example-placeholder-single-currency").select2({
            placeholder: "Currency",
        });
        // Vendor
        $(".js-example-placeholder-single-vendor").select2({
            placeholder: "Vendor",
        });
        //Item
        $(".js-example-placeholder-single-item").select2({
            placeholder: "Item",
        });
        //Item
        $(".js-example-placeholder-group-item-list").select2({
            placeholder: "Item",
        });
    </script>
    <script>
        function unblock() {
            $('.page-content').unblock();
        }

        function block() {
            $('.page-content').block({
                message: '<div class="blockui-default-message"><i class="fa fa-circle-o-notch fa-spin"></i><h6>Please Wait</h6></div>',
                overlayCSS: {
                    background: 'rgba(24, 44, 68, 0.8)',
                    opacity: 1,
                    cursor: 'wait'
                },
                css: {
                    width: '50%'
                },
                blockMsgClass: 'block-msg-default'
            });
        }

        function block_gui_onload_start() {
            //alert("Yes");
            $(".page_loader").addClass('ajax_call');
            $(".page_loader").css('display', 'block');
        }

        function block_gui_onload_gui_end() {

            $(".page_loader").removeClass('ajax_call');
            $(".page_loader").css('display', 'none');
        }

        function block_gui_start() {
            $(".page_loader").addClass('ajax_call');
            $(".page_loader").css('display', 'block');
        }

        function block_gui_end() {

            $(".page_loader").removeClass('ajax_call');
            $(".page_loader").css('display', 'none');
        }
    </script>

</body>

</html>