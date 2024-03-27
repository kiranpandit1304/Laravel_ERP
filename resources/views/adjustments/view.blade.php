<div class="modal-body">
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="invoice">
                    <div class="invoice-print">
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <!-- <div class="font-bold mb-3">{{__('Date')}} : {{ @$adjustment->date }}</div> -->
                                <small class="mb-2">{{__('Date')}} : {{ date('Y-m-d', strtotime(@$adjustment->date)) }}</small><br/>
                                <small class="mb-2">{{__('Reference')}} : {{ @$adjustment->reference_code }}</small><br/>
                                <small class="mb-2">{{__('Warehouse')}} : {{ @$adjustment->warehouse->name }}</small>
                                    
                                <div class="table-responsive mt-3">
                                    <table class="table ">
                                        <tr>
                                            <th idth="50%">{{__('Product')}}</th>
                                            <th idth="50%">{{__('Code')}}</th>
                                            <th>{{__('Quantity')}}</th>
                                            <th>{{__('Type')}} </th>
                                        </tr>
                                        <tbody class="ui-sortable" data-repeater-item>
                                            @foreach($adjustment_items as $adjustment_item)
                                            <tr>
                                                <td width="50%" class="form-group pt-1">
                                                {{ App\Models\Utility::getProductName($adjustment_item->product_id)->name }}
                                                </td>
                                                <td width="50%" class="form-group pt-1">
                                                {{ App\Models\Utility::getProductName($adjustment_item->product_id)->sku }}
                                                </td>
                                                <td class=" ">
                                                    {{  @$adjustment_item->quantity }}
                                                </td>
                                                <td class="text-end ">
                                                    <div class="form-group col-md-12">
                                                        {{ $adjustment_item->method_type == 1 ? 'Addition' : 'Subtraction'}}
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
            </div>
        </div>
    </div>
</div>
</div>