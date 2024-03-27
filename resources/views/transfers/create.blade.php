@extends('layouts.admin')
@section('page-title')
{{__('Transfer Create')}}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
<li class="breadcrumb-item"><a href="{{route('transfer.index')}}">{{__('Transfer')}}</a></li>
<li class="breadcrumb-item">{{__('Transfer Create')}}</li>
@endsection

@section('content')
<div class="row">
    {{ Form::open(array('url' => 'transfer','class'=>'w-100')) }}
    <div class="col-12">
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                                    {{ Form::label('to_warehouse_id', __('From Warehouse'),['class'=>'form-label']) }}
                                    {{ Form::select('from_warehouse_id', $warehouse,null, array('class' => 'form-control select warehouse_d','required'=>'required')) }}
                                </div>
                        <div id="vender_detail" class="d-none">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('from_warehouse_id', __('To Warehouse'),['class'=>'form-label']) }}
                                    {{ Form::select('to_warehouse_id', $warehouse,null, array('class' => 'form-control select warehouse_d','required'=>'required')) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('transfers_date', __('Transfer Date'),['class'=>'form-label']) }}
                                    {{Form::date('transfer_date',null,array('class'=>'form-control','required'=>'required'))}}

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('transfer_number', __('Transfers Number'),['class'=>'form-label']) }}
                                    <input type="text" class="form-control" value="{{$transfer_number}}" readonly>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-12">
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('from_warehouse_id', __('Warehouse From'),['class'=>'form-label']) }}
                                    {{ Form::select('from_warehouse_id', $warehouse,null, array('class' => 'form-control select warehouse_d','required'=>'required')) }}
                                </div>
                            </div>
                       <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('to_warehouse_id', __('Warehouse To'),['class'=>'form-label']) }}
                                    {{ Form::select('to_warehouse_id', $warehouse,null, array('class' => 'form-control select warehouse_d','required'=>'required')) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('transfer_date', __('Transfer Date'),['class'=>'form-label']) }}
                                    {{Form::date('transfer_date',null,array('class'=>'form-control','required'=>'required'))}}

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('transfer_number', __('Transfer Number'),['class'=>'form-label']) }}
                                    <input type="text" class="form-control" value="{{$purchase_number}}" readonly>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="col-12">
        <h5 class=" d-inline-block mb-4">{{__('Product & Services')}}</h5>
        <div class="card repeater">
            <div class="item-section py-2">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                        <div class="all-button-box me-2">
                            <a href="#" data-repeater-create="" class="btn btn-primary" data-bs-toggle="modal" data-target="#add-bank">
                                <i class="ti ti-plus"></i> {{__('Add item')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table mb-0" data-repeater-list="items" id="sortable-table">
                        <thead>
                            <tr>
                            <th>{{__('Items')}}</th>
                                <th>{{__('Stock')}}</th>
                                <th>{{__('Quantity')}}</th>
                                <th>{{__('Price')}} </th>
                                <th class="text-end">{{__('Amount')}} <br><small class="text-danger font-weight-bold">{{__('before tax & discount')}}</small></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="ui-sortable" data-repeater-item>
                            <tr>
                                <td width="25%" class="form-group pt-1">
                                    {{ Form::select('item', $product_services,'', array('class' => 'form-control select2 item','data-url'=>route('purchase.product'),'required'=>'required')) }}
                                </td>
                                <td class=" stock_d">
                                    0
                                </td>
                                <td>
                                    <div class="form-group price-input input-group search-form">
                                        {{ Form::text('quantity','', array('class' => 'form-control quantity','required'=>'required','placeholder'=>__('Qty'),'required'=>'required')) }}

                                        <span class="unit input-group-text bg-transparent"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group price-input input-group search-form">
                                        {{ Form::text('price','', array('class' => 'form-control price','required'=>'required','placeholder'=>__('Price'),'required'=>'required')) }}
                                        <span class="input-group-text bg-transparent">{{\Auth::user()->currencySymbol()}}</span>
                                    </div>
                                </td>
                                <td class="text-end amount">
                                    0.00
                                </td>
                                <td>
                                    <a href="#" class="ti ti-trash text-white text-white repeater-action-btn bg-danger ms-2" data-repeater-delete></a>
                                </td>
                            </tr>
                           
                        </tbody>
                        <tfoot id="tfoot">
                            @include('transfers.taxCalculation')
                        </tfoot>
                    </table>
        
                    <div class="row m-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('discount', __('Discount'),['class'=>'form-label']) }}
                                {{ Form::text('discount','0', array('class' => 'form-control inp_discount','required'=>'required','placeholder'=>__('Discount'))) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('status', __('Status'),['class'=>'form-label']) }}
                                {{ Form::select('status', $StatusTypes,null, array('class' => 'form-control select','required'=>'required','placeholder'=>__('Select..'))) }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                            <div class="form-group">
                                {{ Form::textarea('description', null, ['class'=>'form-control','rows'=>'3','placeholder'=>__('Description')]) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="modal-footer">
        <input type="button" value="{{__('Cancel')}}" onclick="location.href = '{{route("transfer.index")}}';" class="btn btn-light">
        <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
    </div>
    {{ Form::close() }}
</div>
@push('script-page')
   <script src="{{asset('js/common_calculation/addFormCalculation.js')}}"></script>
@endpush
@endsection