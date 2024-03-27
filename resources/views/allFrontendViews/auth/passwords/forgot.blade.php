@extends('allFrontendViews.layouts.auth')
@php
$logo=asset(Storage::url('uploads/logo/'));
$company_logo=Utility::getValByName('company_logo');
$settings = Utility::settings();
@endphp
@section('page-title')
{{__('Forgot Pass')}}
@endsection
@section('content')
<div class="content_side">
    <div class="lheader">
    </div>
    <div class="form_content">
        <h2>Reset Password?</h2>
        <p>Already have an account?<a href="{{route('fn.login')}}">Login</a></p>
        <form action="javascript:void(0)" id="fogotPassForm">
            <div class="form-control form-group">
                <label class="phone">
                    <div class="prefix">+91</div>
                    <input type="text" id="phone" name="phone" required="">
                    <span>Phone Number</span>
                </label>
            </div>
            <p class="light_p">Enter your phone number to receive a secure one-time password (OTP) for creating a new account.</p>
            &nbsp;
            <button type="submit">Get OTP</button>
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
    $(document).ready(function() {
        if (localStorage.getItem('userno') != '' && localStorage.getItem('userno') != undefined) {
            $("#phone").val(localStorage.getItem('userno').substring(2));
        } else {
            $("#phone").val('');
        }
    });
</script>
@endpush