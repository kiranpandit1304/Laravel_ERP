@extends('allFrontendViews.layouts.auth')
@php
$logo=asset(Storage::url('uploads/logo/'));
$company_logo=Utility::getValByName('company_logo');
$settings = Utility::settings();

@endphp
@push('custom-scripts')

@endpush

@section('page-title')
{{__('Signup')}}
@endsection

@section('content')
<div class="content_side">
    <div class="lheader">
    </div>
    <div class="form_content">
        <h2>Create new account</h2>
        <p>Already have an account?<a href="{{route('fn.login')}}">Login</a></p>
        <form action="javascript:void(0)" id="registerForm">
        <div class="form-control form-group">
                <label class="phone">
                    <div class="prefix">+91</div>
                    <input type="text" name="mobile_no" required="" autocomplete="on" id="phone">
                    <span>Phone Number</span>
</label>
            </div>
            <p class="light_p">By continuing, you agree to the <a href="#">Terms & Condition</a> and <a href="#">Privacy Policy</a>.</p>
            <input type="hidden" name="invitee_id" id="invitee_id" value="{{@$invitee_id}}">
            &nbsp;
            <button id="form_data" type="submit">Get OTP</button>
        </form>
    </div>
    <div class="footer_login">
    </div>
</div>
@endsection
@push('custom-scripts')
<script src="{{asset('js/custom/jquery.validate.min.js')}}"></script>
<script src="{{asset('js/custom/auth.js')}}"></script>
@endpush