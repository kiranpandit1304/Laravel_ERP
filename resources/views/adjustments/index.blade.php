@extends('layouts.admin')
@section('page-title')
{{__('Manage Adjustment')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
<li class="breadcrumb-item">{{__('Adjustment')}}</li>

@endsection
@section('action-btn')
<div class="float-end">
    <a href="{{ route('adjustments.create',0) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{__('Create')}}">
        <i class="ti ti-plus"></i>
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>{{ __('Reference') }}</th>
                                <th>{{ __('Warehouse') }}</th>
                                <th>{{ __('Total Products') }}</th>
                                <th>{{ __('Created On') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adjustments as $adjustment)
                            <tr class="font-style">
                                <td>{{ $adjustment->reference_code }}</td>
                                <td>{{ $adjustment->warehouse->name }}</td>
                                <td>{{ $adjustment->total_products }}</td>
                                <td>{{ date('Y-m-d', strtotime($adjustment->date)) }}</td>
                                <td class="Action">
                                        <div class="action-btn bg-info ms-2">
                                            <a data-size="md" href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="{{ route('adjustments.show', @$adjustment->id) }}" data-ajax-popup="true"  data-size="xl" data-bs-toggle="tooltip" title="{{__('Adjustment Details')}}">
                                                <i class="ti ti-eye text-white"></i>
                                            </a>
                                        </div>
                                    <div class="action-btn bg-info ms-2">
                                        <a data-size="md" href="{{ route('adjustments.edit', $adjustment->id) }}" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-size="xl">
                                            <i class="ti ti-edit text-white"></i>
                                        </a>
                                    </div>
                                    <div class="action-btn bg-danger ms-2">
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['adjustments.destroy', $adjustment->id],'class'=>'delete-form-btn','id'=>'delete-form-'.$adjustment->id]) !!}
                                        <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$adjustment->id}}').submit();">
                                            <i class="ti ti-trash text-white"></i>
                                        </a>
                                        {!! Form::close() !!}
                                    </div>
                                </td>
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