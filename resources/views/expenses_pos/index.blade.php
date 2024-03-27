@extends('layouts.admin')
@section('page-title')
{{__('Manage Expense')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
<li class="breadcrumb-item">{{__('Expense')}}</li>
@endsection
@push('css-page')
<style>
    .hide-d{
        display:"none";
    }
</style>
@endpush
@section('action-btn')
<div class="float-end">
    @can('create expense')
    <a href="#" class="btn btn-primary btn-sm" data-url="{{ route('expense.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-size="lg" data-title="{{__('Create expense')}}">
        <span class="btn-inner--icon"><i class="ti ti-plus"></i></span>
    </a>
    @endcan
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
                                <th>{{ __('Reference code') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Warehouse') }}</th>
                                <th>{{ __('Exp category') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('Payment Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expenses as $expense)
                            <tr class="font-style">
                            <td>{{ @$expense->reference_code }}</td>
                            <td>{{ @$expense->title }}</td>
                                <td>{{ @$expense->warehouse->name }}</td>
                                <td>{{ @$expense->expenseCategory->name }}</td>
                                <td>{{ @$expense->amount }}</td>
                                <td>{{ @$expense->payment_status }}</td>
                                <td class="Action">
                                    <div class="action-btn bg-info ms-2">
                                        <a data-size="md" href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="{{ route('expense.edit', $expense->id) }}" data-ajax-popup="true" data-size="xl" data-bs-toggle="tooltip" title="{{__('Update expense')}}">
                                            <i class="ti ti-pencil text-white"></i>
                                        </a>
                                    </div>
                                    @can('delete expense')
                                    <div class="action-btn bg-danger ms-2">
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['expense.destroy',$expense->id],'id'=>'delete-expense-'.$expense->id]) !!}

                                        <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?')}}|{{__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-expense-{{$expense->id}}').submit();">
                                            <i class="ti ti-trash text-white"></i>
                                        </a>
                                        {!! Form::close() !!}

                                    </div>
                                    @endcan
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
@push('script-page')
<script>
      $("body").on("change", ".pstatus" , function(){
          var status = $(this).val();
          if(status == 'paid'){
              $(".paymen_div").removeClass("hide-d")
              $(".ptype").prop("required", true);
          }else{
            $(".paymen_div").addClass("hide-d")
            $(".ptype").prop("required", false);

          }
      });

</script> 
@endpush