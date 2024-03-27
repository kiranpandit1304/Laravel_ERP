@extends('allFrontendViews.layouts.auth')
@php
$logo=asset(Storage::url('uploads/logo/'));
$company_logo=Utility::getValByName('company_logo');
$settings = Utility::settings();
@endphp

@section('page-title')
{{__('Create Password')}}
@endsection

@section('content')
<div class="content_side">
    <div class="lheader">
    </div>
    <div class="content_side">
        <div class="lheader">
        </div>
        <div class="form_content">
            <h2>Create new password</h2>
            <p>Already have an account?<a href="{{route('fn.login')}}">Login</a></p>
            <form id="registerpasswordForm" action="javascript:void(0)">
                <div class="form-group">
                                    <label>
                                        <input type="password" id="password-field" required="" autocomplete="off" placeholder="Password">
                                        <span>Password</span>
</label>
                                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                <p class="light_p">Please set a new password to gain access to your account.</p>
                &nbsp;
                <button type="submit">Go to Dashboard</button>
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
    <script src="{{asset('js/custom/auth.js')}}"></script>
    @endpush