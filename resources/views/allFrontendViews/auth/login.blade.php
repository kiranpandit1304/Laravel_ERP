@extends('allFrontendViews.layouts.auth')
@php
$logo=asset(Storage::url('uploads/logo/'));
$company_logo=Utility::getValByName('company_logo');
$settings = Utility::settings();

@endphp

@section('page-title')
{{__('Login')}}
@endsection
@section('content')
<div class="content_side">
    <div class="lheader">
    </div>
    <div class="form_content">
        <h2>Welcome back</h2>
        <p>Don't have an account?<a href="{{route('fn.signup')}}">Sign Up</a></p>
        <form action="javascript:void(0)" method="post" id="loginForm">
            @csrf
            <div class="form-control form-group">
                <!-- <input type="number" name="mobile_no" placeholder="Enter your phone number" id="phone" />
                <p>+91</p> -->
                <label class="phone">
                    <div class="prefix">+91</div>
                    <input type="text" name="mobile_no" required id="phone" placeholder="Phone Number">
                    <span>Phone Number</span>
                </label>
                <i class="fas fa-check-circle"></i>
                <i class="fas fa-exclamation-circle"></i>
                <small>Error message</small>
            </div>
            <div class="form-group">
                <!-- <input type="password" name="password" id="password" placeholder="Enter your password"> -->
                <label class="phone">
                    <input type="password" name="password" required="" id="password-field">
                    <span>Password</span>
                </label>
                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                @error('password')
                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                @enderror
            </div>
            <div class="align_f">
                <a href="{{route('fn.forgot')}}">Forgot password?</a>
            </div>
            <button type="submit" id="save_btn">Login</button>
            <h6><a href="{{route('fn.login_number')}}">Login via OTP</a></h6>
        </form>
    </div>
    <div class="footer_login">
    </div>
</div>
@endsection
@push('custom-scripts')
<script>
        // Password EYE hide show
        $(".toggle-password").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
<script src="{{asset('js/custom/jquery.validate.min.js')}}"></script>
<script src="{{asset('js/custom/login.js')}}"></script>
@endpush