@extends('layouts.admin')
@section('page-title')
{{__('Manage Transfer')}}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
<li class="breadcrumb-item">{{__('Transfer')}}</li>
@endsection
@push('script-page')
<script>
    $('.copy_link').click(function(e) {
        e.preventDefault();
        var copyText = $(this).attr('href');

        document.addEventListener('copy', function(e) {
            e.clipboardData.setData('text/plain', copyText);
            e.preventDefault();
        }, true);

        document.execCommand('copy');
        show_toastr('success', 'Url copied to clipboard', 'success');
    });
</script>
@endpush

@section('action-btn')
<div class="float-end">
    @can('create purchase')
    <a href="{{ route('transfer.create',0) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{__('Create')}}">
        <i class="ti ti-plus"></i>
    </a>
    @endcan
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th> {{__('Transfer')}}</th>
                                <th> {{__('From Warehouse')}}</th>
                                <th> {{__('To Warehouse')}}</th>
                                <th> {{__('Grand Total')}}</th>
                                <!-- <th> {{__('Paid')}}</th>
                                <th> {{__('Due')}}</th> -->
                                <th> {{__('Transfer Date')}}</th>
                                <th>{{__('Status')}}</th>
                                @if(Gate::check('edit purchase') || Gate::check('delete purchase') || Gate::check('show purchase'))
                                <th> {{__('Action')}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transfer as $purchase)
                            <tr>
                                <td class="Id">
                                    <a href="{{ route('purchase.show',\Crypt::encrypt($purchase->id)) }}" class="btn btn-outline-primary">{{ Auth::user()->transferNumberFormat($purchase->transfer_id) }}</a>

                                </td>
                                <td>{{ !empty($purchase->from_warehouse_id)?$purchase->from_warehouse->name:''}}</td>
                                <td>{{ !empty($purchase->to_warehouse_id)?$purchase->to_warehouse->name:''}}</td>
                                <td>{{ !empty(\Auth::user()->priceFormat($purchase->getTotal()))?\Auth::user()->priceFormat($purchase->getTotal()):''}}</td>
                                <!-- <td>{{\Auth::user()->priceFormat(($purchase->getTotal()-$purchase->getDue()))}}</td>
                                <td>{{\Auth::user()->priceFormat($purchase->getDue())}}</td> -->
                                <td>{{ Auth::user()->dateFormat($purchase->transfer_date) }}</td>
                                <td>
                                    <span class="purchase_status badge bg-primary p-2 px-3 rounded">{{ !empty($purchase->status)?$purchase->StatusType->name:''}} </span>
                                </td>
                                @if(Gate::check('edit purchase') || Gate::check('delete purchase') || Gate::check('show purchase'))
                                <td class="Action">
                                    <span>
                                        @can('show purchase')
                                        <div class="action-btn bg-info ms-2">
                                            <a href="{{ route('transfer.show',\Crypt::encrypt($purchase->id)) }}" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('Show')}}" data-original-title="{{__('Detail')}}">
                                                <i class="ti ti-eye text-white"></i>
                                            </a>
                                        </div>
                                        @endcan
                                        @can('edit purchase')
                                        <div class="action-btn bg-primary ms-2">
                                            <a href="{{ route('transfer.edit',\Crypt::encrypt($purchase->id)) }}" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="Edit" data-original-title="{{__('Edit')}}">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        </div>
                                        @endcan
                                        @can('delete purchase')
                                        <div class="action-btn bg-danger ms-2">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['transfer.destroy', $purchase->id],'class'=>'delete-form-btn','id'=>'delete-form-'.$purchase->id]) !!}
                                            <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$purchase->id}}').submit();">
                                                <i class="ti ti-trash text-white"></i>
                                            </a>
                                            {!! Form::close() !!}
                                        </div>
                                        @endcan
                                    </span>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection