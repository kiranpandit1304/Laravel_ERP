@extends('layouts.admin')
@section('page-title')
{{__('Status Types')}}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
<li class="breadcrumb-item">{{__('Status Types')}}</li>
@endsection

@section('action-btn')
<div class="float-end">
    @can('create constant unit')
    <a href="#" data-url="{{ route('status-types.create') }}" data-ajax-popup="true" data-title="{{__('Create New Status Type')}}" data-bs-toggle="tooltip" title="{{__('Create')}}" class="btn btn-sm btn-primary">
        <i class="ti ti-plus"></i>
    </a>
    @endcan
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th> {{__('Name')}}</th>
                                <th width="10%"> {{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($StatusTypes as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td class="Action">
                                    <span>
                                        <div class="action-btn bg-primary ms-2">
                                            <a href="#" class="mx-3 btn btn-sm align-items-center" data-url="{{ route('status-types.edit',$item->id) }}" data-ajax-popup="true" data-title="{{__('Edit Status type')}}" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        </div>
                                        @if($item->id != 1 && $item->id != 2)
                                        <div class="action-btn bg-danger ms-2">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['status-types.destroy', $item->id],'id'=>'delete-form-'.$item->id]) !!}
                                            <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$unit->id}}').submit();">
                                                <i class="ti ti-trash text-white"></i>
                                            </a>
                                            {!! Form::close() !!}
                                        </div>
                                    </span>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection