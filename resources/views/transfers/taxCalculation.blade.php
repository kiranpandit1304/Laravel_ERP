<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td><strong>{{__('Sub Total')}} ({{\Auth::user()->currencySymbol()}})</strong></td>
    <td class="text-end subTotal">0.00</td>
    <td></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td><strong>{{__('Discount')}} </strong></td>
    <td class="text-end totalDiscount">0.00</td>
    <td></td>
</tr>
@if(!empty($TaxChargesDBValues) && count($TaxChargesDBValues))
@foreach($TaxChargesDBValues as $key=>$DBchargesValues)
<tr id="show_tx_list_{{$key}}">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td><strong id="singleListingtaxType_{{ $key }}">{{ @$DBchargesValues->charges_type_name }}  </strong></td>
    <td class="text-end totalTax" id="singleListingtaxRate_{{ $key }}">{{ @$DBchargesValues->tax_rate }}</td>
    <td></td>
</tr>
@endforeach
@else
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td><strong id="singleListingtaxType_0" >{{__('Tax')}}  </strong></td>
    <td class="text-end totalTax" id="singleListingtaxRate_0" >0.00</td>
    <td></td>
</tr>
@endif
<tr class="mt-1 " id="show_tx_list_{{ !empty($TaxChargesDBValues) && count($TaxChargesDBValues) > 0 ? count($TaxChargesDBValues) : 0 }}"  ></tr>

<!-- #Shipping  -->
@if(!empty($ShippigChargesDBValues) && count($ShippigChargesDBValues))
@foreach($ShippigChargesDBValues as $key=>$DBchargesValues)
<tr id="show_shipping_list_{{$key}}">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td><strong id="singleListingShippingType_{{ $key }}">{{ @$DBchargesValues->charges_type_name }}  </strong></td>
    <td class="text-end totalTax" id="singleListingShippingRate_{{ $key }}">{{ $DBchargesValues->tax_rate }}</td>
    <td></td>
</tr>
@endforeach
@else
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td><strong id="singleListingShippingType_0" >{{__('Shipping')}}  </strong></td>
    <td class="text-end totalShipping" id="singleListingShippingRate_0" >0.00</td>
    <td></td>
</tr>
@endif
<tr class="mt-1 " id="show_shipping_list_{{ !empty($ShippigChargesDBValues) && count($ShippigChargesDBValues) > 0 ? count($ShippigChargesDBValues) : 0 }}"  ></tr>

<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="blue-text"><strong>{{__('Total Amount')}} ({{\Auth::user()->currencySymbol()}})</strong></td>
    <td class="blue-text text-end totalAmount"></td>
    <td></td>
</tr>
<tr class="mt-5 " id="taxfoot" >
    <td colspan="5"><h5>Tax</h5></td>
</tr>
<!-- ..... -->
@if(!empty($TaxChargesDBValues) && count($TaxChargesDBValues))
@foreach($TaxChargesDBValues as $key=>$DBchargesValues)
<tr class="mt-2 " id="tx_row_{{$key}}">
    <td colspan="2">
        <label>Tax Type</label>
        <select class="form-control tx_type" data-index="{{$key}}"  onchange="setTaxType(this)" name="tax_type[]" >
            <option value="" >Select..</option>
            @foreach($taxChargesTypes as $item)
            <option value="{{$item->id}}" {{ $DBchargesValues->charges_type_id && $DBchargesValues->charges_type_id== $item->id ? 'selected' : ''}} > {{$item->name}}</option>
            @endforeach
        </select>
    </td>
    <td colspan="2">
        <label>Tax Charges</label>
        <input class="form-control itemTaxRate taxRate" type="text" name="tax_charges[]" value="{{@$DBchargesValues->tax_rate}}" onkeyup="setTaxCharges(this)" data-index="{{$key}}" />
    </td>
   <td colspan="2">
    @if($key==0)
        <button class="btn btn-md btn-primary mt-2 add_tax_row" type="button">+</button>
    @else
    <button  class="btn btn-md btn-danger mt-2 minus_tax_row" type="button">-</button>
    @endif
   </td>
</tr>
@endforeach
@else
<tr class="mt-2 ">
    <td colspan="2">
        <label>Tax Type</label>
        <select class="form-control tx_type" data-index="0"  onchange="setTaxType(this)" name="tax_type[]" >
            <option value="" >Select..</option>
            @foreach($taxChargesTypes as $item)
            <option value="{{$item->id}}" > {{$item->name}}</option>
            @endforeach
        </select>
    </td>
    <td colspan="2">
        <label>Tax Charges</label>
        <input class="form-control itemTaxRate taxRate" type="text" onkeyup="setTaxCharges(this)" name="tax_charges[]" placeholder="0.00" data-index="0" />
    </td>
    <td colspan="2">
        <button class="btn btn-md btn-primary mt-2 add_tax_row" type="button">+</button>
    </td>
</tr>
<!-- <tr class="mt-1 " id="tx_row_0" ></tr> -->
@endif
<tr class="mt-1" id="tx_row_{{ !empty($TaxChargesDBValues) && count($TaxChargesDBValues) > 0 ? count($TaxChargesDBValues) : 0 }}"  ></tr>

<!----- SHIPPING Section ---->

<tr class="mt-3 " >
    <td colspan="5"><h5>Shipping</h5></td>
</tr>
@if(!empty($ShippigChargesDBValues) && count($ShippigChargesDBValues))
@foreach($ShippigChargesDBValues as $key=>$DBshippingValues)
<tr class="mt-2 " id="shp_row_{{$key}}">
    <td colspan="2">
        <label>Shipping Type</label>
        <select class="form-control " data-index="{{$key}}" onchange="setShippingType(this)" name="shipping_type[]" >
            <option value="" >Select..</option>
            @foreach($shippingChargesTypes as $item)
            <option value="{{$item->id}}" {{ $DBshippingValues->charges_type_id && $DBshippingValues->charges_type_id== $item->id ? 'selected' : ''}} > {{$item->name}}</option>
            @endforeach
        </select>
    </td>
    <td colspan="2">
        <label>Shipping Charges</label>
        <input class="form-control itemTaxRate shipingRate" type="text" name="shipping_charges[]" onkeyup="setShippingCharges(this)"  value="{{@$DBshippingValues->tax_rate}}" data-index="{{$key}}" />
    </td>
    <td colspan="2">
    @if($key==0)
        <button class="btn btn-md btn-primary mt-2 add_shipping_row" type="button">+</button>
    @else
    <button  class="btn btn-md btn-danger mt-2 minus_ship_row" type="button">-</button>
    @endif
    </td>
</tr>
@endforeach
@else
<tr class="mt-2 "  >
    <td colspan="2">
        <label>Shipping Type</label>
        <select class="form-control " data-index="0"  onchange="setShippingType(this)" name="shipping_type[]" >
            <option value="" >Select..</option>
            @foreach($shippingChargesTypes as $item)
            <option value="{{$item->id}}" > {{$item->name}}</option>
            @endforeach
        </select>
    </td>
    <td colspan="2">
        <label>Shipping Charges</label>
        <input class="form-control itemTaxRate shipingRate"  type="text" name="shipping_charges[]" onkeyup="setShippingCharges(this)" placeholder="0.00" data-index="0" />
    </td>
    <td colspan="2">
        <button class="btn btn-md btn-primary mt-2 add_shipping_row" type="button">+</button>
    </td>
</tr>
@endif
<tr class="mt-1"   id="shp_row_{{ !empty($ShippigChargesDBValues) && count($ShippigChargesDBValues) > 0 ? count($ShippigChargesDBValues) : 0 }}"  ></tr>

@push('script-page')
<script src="{{asset('js/jquery-ui.min.js')}}"></script>
<script src="{{asset('js/jquery.repeater.min.js')}}"></script> 
<script>
    var taxChargesTypes = <?= json_encode($taxChargesTypes) ?>;
    var shippingChargesTypes = <?= json_encode($shippingChargesTypes) ?>;

    var TaxChargesDBCount = <?= (!empty($TaxChargesDBValues) && count($TaxChargesDBValues)>0 ?count($TaxChargesDBValues): 0) ?>;
    var shippingChargesDBCount = <?= (!empty($ShippigChargesDBValues) && count($ShippigChargesDBValues)>0 ? count($ShippigChargesDBValues) : 0) ?>;
</script>
<script src="{{asset('js/common_calculation/taxCalculation.js')}}"></script>
<script src="{{asset('js/common_calculation/shippingCalculation.js')}}"></script>
<script src="{{asset('js/common_calculation/commonCalculation.js')}}"></script>
<!------------------------------- SHIPPING SECTION ------------------------->

@endpush