@extends('layouts.admin')
@section('page-title')
{{__('Adjustment Edit')}}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
<li class="breadcrumb-item"><a href="{{route('adjustments.index')}}">{{__('Adjustment')}}</a></li>
<li class="breadcrumb-item">{{__('Adjustment Edit')}}</li>
@endsection

@section('content')
<div class="row">
    {{ Form::model($adjustment, ['route' => ['adjustments.update', $adjustment->id], 'method' => 'PUT']) }}
    <div class="col-12">
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('warehouse_id', __('Warehouse'),['class'=>'form-label']) }}
                            {{ Form::select('warehouse_id', $warehouse,$adjustment->warehouse_id, array('class' => 'form-control select warehouse_d','required'=>'required')) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('date', __('Date'),['class'=>'form-label']) }}
                            {{Form::date('date',$adjustment->date,array('class'=>'form-control','required'=>'required'))}}

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

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
                                <th>{{__('Product')}}</th>
                                <th>{{__('Sku')}}</th>
                                <th>{{__('Stock')}}</th>
                                <th>{{__('Quantity')}}</th>
                                <th>{{__('Type')}} </th>
                                <th></th>
                            </tr>
                        </thead>
                        @foreach($adjustment_items as $adjustment_item)
                        <tbody class="ui-sortable" data-repeater-item >
                            <tr>
                                <td width="25%" class="form-group pt-1">
                                    {{ Form::select('item', @$product_services,$adjustment_item->product_id, array('class' => 'form-control select2 item','data-url'=>route('adjustments.productStock'),'required'=>'required')) }}
                                </td>
                                <td class="sku">
                                    0.00
                                </td>
                                <td class=" stock_d">
                                    {{ App\Models\Utility::getWarehouseProductStock($adjustment_item->product_id, $adjustment->warehouse_id) }}
                                </td>
                                <td>
                                    <div class="form-group price-input input-group search-form">
                                        {{ Form::text('quantity',$adjustment_item->quantity, array('class' => 'form-control quantity','required'=>'required','placeholder'=>__('Qty'),'required'=>'required')) }}

                                        <span class="unit input-group-text bg-transparent"></span>
                                    </div>
                                </td>
                                <td class="text-end ">
                                    <div class="form-group col-md-12">
                                        {!! Form::select('method_type', $days= array(""=>"Select Type","1"=>"Addition","2" => "Subtraction"),@$adjustment_item->method_type, ['class' => 'form-control days', 'required'=>'required']) !!}
                                    </div>
                                </td>
                                <td>
                                    <a href="#" class="ti ti-trash text-white text-white repeater-action-btn bg-danger ms-2" data-repeater-delete></a>
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="button" value="{{__('Cancel')}}" onclick="location.href = '{{route("adjustments.index")}}';" class="btn btn-light">
            <input type="submit" value="{{__('Save')}}" class="btn  btn-primary">
        </div>
        {{ Form::close() }}
    </div>
    @push('script-page')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/jquery.repeater.min.js')}}"></script>
    <script>
        var selector = "body";
        if ($(selector + " .repeater").length) {
            var $dragAndDrop = $("body .repeater tbody").sortable({
                handle: '.sort-handler'
            });
            var $repeater = $(selector + ' .repeater').repeater({
                initEmpty: false,
                defaultValues: {
                    'status': 1
                },
                show: function() {
                    $(this).slideDown();

                },
                hide: function(deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                        $(this).remove();

                        var inputs = $(".amount");
                        var subTotal = 0;
                        for (var i = 0; i < inputs.length; i++) {
                            subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
                        }
                        $('.subTotal').html(subTotal.toFixed(2));
                        $('.totalAmount').html(subTotal.toFixed(2));
                    }
                },
                ready: function(setIndexes) {
                    $dragAndDrop.on('drop', setIndexes);
                },
                isFirstItemUndeletable: true
            });
            var value = $(selector + " .repeater").attr('data-value');
            if (typeof value != 'undefined' && value.length != 0) {
                value = JSON.parse(value);
                $repeater.setList(value);
            }

        }


        $(document).on('change', '.item', function() {
            var iteams_id = $(this).val();
            var warehouse_id = $(".warehouse_d").val();
            var url = $(this).data('url');
            var el = $(this);
            $.ajax({
                url: url,
                method: "post",
                headers: {
                    'X-CSRF-TOKEN': jQuery('#token').val()
                },
                data: {
                    'product_id': iteams_id,
                    'warehouse_id': warehouse_id,
                },
                cache: false,
                success: function(data) {
                    var item = JSON.parse(data);

                    // $(el.parent().parent().find('.product_id')).val(1);
                    $(el.parent().parent().find('.quantity')).val(1);
                    $(el.parent().parent().find('.sku')).html(item?.sku);
                    $(el.parent().parent().find('.stock_d')).html(item?.totalStock);

                },
            });
        });

        //     $(document).on("click", "[data-repeater-create]", function () {
        //     $(".item :selected").each(function () {
        //         var id = $(this).val();
        //         $(".item option[value=" + id + "]").prop("disabled", true);
        //     });
        // });
        //    
    </script>
    @endpush
    @endsection