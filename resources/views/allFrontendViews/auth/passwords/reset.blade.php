@extends('allFrontendViews.layouts.auth')
@php
$logo=asset(Storage::url('uploads/logo/'));
$company_logo=Utility::getValByName('company_logo');
$settings = Utility::settings();
@endphp
@section('page-title')
{{__('Reset Pass')}}
@endsection

@section('content')
<div class="content_side">
    <div class="lheader">
    </div>
    <div class="form_content">
        <h2>OTP</h2>
        <p style="text-align: center;">Please enter the OTP sent to  <span class="show_number"> +91 XXXXXXXXXX </span> <a href="{{route('fn.forgot')}}">Change</a></p>
        <form action="javascript:void(0)" id="resetPassForm">
            <div class="form-control">
                <div class="digit-group">
                    <input type="text" id="digit-1" name="digit1" data-next="digit-2" autofocus />
                    <input type="text" id="digit-2" name="digit2" data-next="digit-3" data-previous="digit-1" />
                    <input type="text" id="digit-3" name="digit3" data-next="digit-4" data-previous="digit-2" />
                    <input type="text" id="digit-4" name="digit4" data-next="digit-5" data-previous="digit-3" />
                </div>
            </div>
            &nbsp;
            <button class="button-verify success" id="verify" type="submit">Verify</button>
            <h6><a href="javascript:void(0)" id="resendOtpBtn">Not received code? Resend code</a></h6>
        </form>
    </div>
    <div class="footer_login">

    </div>
</div>
@endsection
   @push('custom-scripts')
    <script src="{{asset('js/custom/jquery.validate.min.js')}}"></script>
    <script src="{{asset('js/custom/auth.js')}}"></script>
    <script>
    $(document).ready(function(){
        if(localStorage.getItem('userno'))
         $(".show_number").html(localStorage.getItem('userno'));
    });
    
        $('.digit-group').find('input').each(function() {
            $(this).attr('maxlength', 1);
            $(this).on('keyup', function(e) {
                var parent = $($(this).parent());
                
                if(e.keyCode === 8 || e.keyCode === 37) {
                    var prev = parent.find('input#' + $(this).data('previous'));
                    
                    if(prev.length) {
                        $(prev).select();
                    }
                } else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
                    var next = parent.find('input#' + $(this).data('next'));
                    
                    if(next.length) {
                        $(next).select();
                    } else {
                        if(parent.data('autosubmit')) {
                            parent.submit();
                        }
                    }
                }
            });
        });
    </script>
  
    <script>
        const form = document.getElementById("resetPassForm");
        const otp = document.getElementById("digit");

        function checkInputs() {
            let isValid = true;
            
            // trim to remove the whitespaces
            const otpValue = otp.value.trim();

            if (otpValue === "") {
                setErrorFor(otp, "OTP cannot be blank");
                isValid = false;
            } else {
                setSuccessFor(otp);
            }

            return isValid;
        }

        function setErrorFor(input, message) {
            const formControl = input.parentElement;
            const small = formControl.querySelector("small");
            formControl.className = "form-control error";
            small.innerText = message;
        }

        function setSuccessFor(input) {
            const formControl = input.parentElement;
            formControl.className = "form-control success";
        }

    </script>
    @endpush