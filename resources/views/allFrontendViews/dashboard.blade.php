@extends('allFrontendViews.layouts.app')
@php
$logo=asset(Storage::url('uploads/logo/'));
$company_logo=Utility::getValByName('company_logo');
$settings = Utility::settings();

@endphp

@section('page-title')
{{__('Dashboard')}}
@endsection
@section('content')
<div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-lg-4">
                            <div class="complete_profile">
                                <div class="content_p">
                                    <div class="alert">
                                        <h4><iconify-icon icon="ph:info"></iconify-icon> Your profile is not complete</h4>
                                        <p>Descriptions and other basic details are missing from your profile</p>
                                    </div>
                                </div>
                                <button class="btn_profile" type="button" data-toggle="modal" data-target="#cprofilePopup">Complete Your Profile</button>
                                <!-- <button class="btn_profile" type="button" id="shwProfileModal" >Complete Your Profile</button> -->
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <div class="analytics_card">
                                <div class="ac_header">
                                    <div class="select_app">
                                        <select class="vodiapicker">
                                            <option value="" class="test" data-thumbnail="{{asset('unsync_assets/assets/images/icon-1.png')}}">Clients & Vendors</option>
                                            <option value="" data-thumbnail="{{asset('unsync_assets/assets/images/icon-2.png')}}">Accounting</option>
                                            <option value="" data-thumbnail="{{asset('unsync_assets/assets/images/icon-3.png')}}">Leads & Tickets</option>
                                            <option value="" data-thumbnail="{{asset('unsync_assets/assets/images/icon-4.png')}}">Projects</option>
                                            <option value="" data-thumbnail="{{asset('unsync_assets/assets/images/icon-5.png')}}">Products & Inventory</option>
                                            <option value="" data-thumbnail="{{asset('unsync_assets/assets/images/icon-6.png')}}">Warehouse</option>
                                        </select>
                                        <div class="lang-select">
                                            <button class="btn-select" value=""></button>
                                            <iconify-icon class="arrow_down" icon="material-symbols:keyboard-arrow-down-rounded"></iconify-icon>
                                            <iconify-icon class="arrow_up" icon="material-symbols:keyboard-arrow-up-rounded"></iconify-icon>
                                            <div class="b">
                                                <ul id="a"></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="set_daterange">
                                        <div class="c-datepicker-date-editor  J-datepicker-range-day mt10">
                                            <i class="c-datepicker-range__icon kxiconfont icon-clock"></i>
                                            <!-- <input placeholder="Start" name="" class="c-datepicker-data-input only-date" value="">
                                            <span class="c-datepicker-range-separator">-</span>
                                            <input placeholder="End" name="" class="c-datepicker-data-input only-date" value=""> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="ac_body">
                                    <div class="headline">
                                        <div class="hdtitle">
                                            <span>
                                                <img src="{{asset('unsync_assets/assets/images/headline_icon.png')}}" alt="" />
                                            </span>
                                            <!-- Headlines -->
                                        </div>
                                        <ul class="bxslider">
                                            <li>
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.</p>
                                            </li>
                                            <li>
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.</p>
                                            </li>
                                            <li>
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.</p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="cards_numbers">
                                        <div class="num_card">
                                            <h5>Monthly Payment <span>2</span></h5>
                                            <h2>
                                                $5000
                                                <p>$2500 <iconify-icon icon="tabler:arrow-up" style="color: #279f62;"></iconify-icon></p>
                                            </h2>
                                        </div>
                                        <div class="num_card end">
                                            <h5>Monthly Payment</h5>
                                            <h2>
                                                $5000
                                                <p>$2500</p>
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="cards_numbers last">
                                        <div class="num_card">
                                            <h5>Monthly Payment <span>5</span></h5>
                                            <h2>
                                                $5000
                                                <p>$2500 <iconify-icon icon="tabler:arrow-up" style="color: #279f62;"></iconify-icon></p>
                                            </h2>
                                        </div>
                                        <div class="num_card end">
                                            <h5>Monthly Payment</h5>
                                            <h2>
                                                $5000
                                                <p>$2500</p>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="ac_footer"></div>
                            </div>
                        </div>
                    </div>
                </div>
@endsection
@section('modals')
@include('allFrontendViews.layouts.modals.profile')
@include('allFrontendViews.layouts.modals.welcome')
@endsection
@push('custom-scripts')
<!-- <script src="{{asset('js/custom/jquery.validate.min.js')}}"></script>
<script src="{{asset('js/custom/login.js')}}"></script> -->
@endpush