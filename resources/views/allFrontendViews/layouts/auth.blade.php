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
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{isset($setting['SITE_RTL']) && $setting['SITE_RTL'] == 'on' ? 'rtl' : '' }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>{{(Utility::getValByName('title_text')) ? Utility::getValByName('title_text') : config('app.name', 'ERPGO')}} - @yield('page-title')</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('unsync_assets/assets/images/favicon.ico') }}" />

    <link rel="stylesheet" href="{{ asset('unsync_assets/assets/css/backend.css') }}" />
    <!-- <link rel="stylesheet" href="assets/css/backend.min.css" /> -->
    <link rel="stylesheet" href="{{ asset('unsync_assets/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('unsync_assets/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('unsync_assets/assets/vendor/remixicon/fonts/remixicon.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css" />
    

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script>
        var APP_URL =<?=json_encode(url('/')) ?>;
        var csrfTokenVal = <?= json_encode(csrf_token()) ?>;
        if(localStorage.getItem('token')){
           var encypt_id = localStorage.getItem('encypt_id');
            window.location.href="/en/dashboard/"+encypt_id;
        }
    </script>
    
    <style type="text/css">
        .error{
            color: red !important;
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
    <section id="login">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12  col-lg-6 col-sm-6 flush">
                    <div class="slider_side">
                        <a href="#" class="logo">
                            <img src="{{ asset('unsync_assets/assets/images/logo.png') }}" alt="">
                            <!-- <img src="{{ $logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') }}"
                             alt="{{ config('app.name', 'ERPGo') }}" class="logo w-50"> -->
                        </a>
                    </div>
                </div>
                <div class="col-12  col-lg-6 col-sm-6 flush">
                    @yield('content')
                </div>
            </div>
        </div>
    </section>
    <!-- [ auth-signup ] end --> 
    <!-- Backend Bundle JavaScript -->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{asset('unsync_assets/assets/js/backend-bundle.min.js')}}"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.3/iconify-icon.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js" integrity="sha256-/H4YS+7aYb9kJ5OKhFYPUjSJdrtV6AeyJOtTkw6X72o=" crossorigin="anonymous"></script>
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
    @stack('custom-scripts')
</body>

</html>