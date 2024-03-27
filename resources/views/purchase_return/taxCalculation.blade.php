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
        <input class="form-control itemTaxRate itemEditTxRate" type="text" name="tax_charges[]" value="{{@$DBchargesValues->tax_rate}}" onkeyup="setTaxCharges(this)" data-index="{{$key}}" />
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
        <input class="form-control itemTaxRate itemEditTxRate" type="text" onkeyup="setTaxCharges(this)" name="tax_charges[]" placeholder="0.00" data-index="0" />
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
        <input class="form-control itemTaxRate itemEditShpRate" type="text" name="shipping_charges[]" onkeyup="setShippingCharges(this)"  value="{{@$DBshippingValues->tax_rate}}" data-index="{{$key}}" />
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
        <input class="form-control itemTaxRate itemEditShpRate"  type="text" name="shipping_charges[]" onkeyup="setShippingCharges(this)" placeholder="0.00" data-index="0" />
    </td>
    <td colspan="2">
        <button class="btn btn-md btn-primary mt-2 add_shipping_row" type="button">+</button>
    </td>
</tr>
@endif
<tr class="mt-1"   id="shp_row_{{ !empty($ShippigChargesDBValues) && count($ShippigChargesDBValues) > 0 ? count($ShippigChargesDBValues) : 0 }}"  ></tr>

@push('script-page')

<script>
    var taxChargesTypes = <?= json_encode($taxChargesTypes) ?>;
    var shippingChargesTypes = <?= json_encode($shippingChargesTypes) ?>;

    var TaxChargesDBCount = <?= (!empty($TaxChargesDBValues) && count($TaxChargesDBValues)>0 ?count($TaxChargesDBValues): 0) ?>;
    var shippingChargesDBCount = <?= (!empty($ShippigChargesDBValues) && count($ShippigChargesDBValues)>0 ? count($ShippigChargesDBValues) : 0) ?>;
</script>

<script>
    // #Add tax Rows
    var indx =  TaxChargesDBCount;
$("body").on("click", ".add_tax_row", function(){
    var html = [];
    // html += '<tr class="mt-1" >';
    html += '<td colspan="2">';
    html += ' <label>Tax type</label>';
    html += '<select class="form-control tx_type" data-index="' + (indx + 1) + '"  onchange="setTaxType(this)" name="tax_type[]" >';
    html += '    <option value="" >Select..</option>';
    if(taxChargesTypes && taxChargesTypes.length > 0){
        for(var j=0; j<taxChargesTypes.length; j++) {
            if(taxChargesTypes[j]?.name != '' && taxChargesTypes[j]?.name != null){
    html += '    <option value="'+taxChargesTypes[j]?.id+'" >'+taxChargesTypes[j]?.name+' </option>';
        }}  }
    html += '</select>';
    html += '</td>';
    html += '<td colspan="2">';
    html += '    <label>Tax Charges</label>';
    html += '      <input class="form-control itemTaxRate itemEditTxRate" data-index="' + (indx + 1) + '"  onkeyup="setTaxCharges(this)" type="text" name="tax_charges[]" placeholder="0.00" />';
    html += '  </td>';
    html += '  <td colspan="2">';
    html += '      <button  class="btn btn-md btn-danger mt-2 minus_tax_row" type="button">-</button>';
    html += '  </td>';
  
    $("#tx_row_"+indx).html(html);
    $("#tx_row_"+indx).closest( "tr" ).after('<tr class="mt-1" data-index="' + (indx + 1) + '"  id="tx_row_' + (indx + 1) + '"></tr>');

    var shtxHtml=[];
    shtxHtml += ' <td>&nbsp;</td>';
    shtxHtml += ' <td>&nbsp;</td>';
    shtxHtml += ' <td>&nbsp;</td>';
    shtxHtml += ' <td></td>';
    shtxHtml += ' <td><strong id="singleListingtaxType_' + (indx + 1) + '">Tax </strong></td>';
    shtxHtml += ' <td class="text-end totalTax" id="singleListingtaxRate_' + (indx + 1) + '">0.00</td>';
    shtxHtml += ' <td></td>';
    $("#show_tx_list_"+indx).html(shtxHtml);
    $("#show_tx_list_"+indx).closest( "tr" ).after('<tr class="mt-1" id="show_tx_list_' + (indx + 1) + '"></tr>');
    indx++;
   
});

$("body").on("click", ".minus_tax_row", function(){
    indx--
    $(this).parent().parent().remove();
    $("#show_tx_list_"+indx).remove();
    $("#singleListingtaxRate_"+indx).remove();
    console.log('idx ', " #show_tx_list_"+indx)
    updateTaxTotal('singleListingtaxRate_'+indx, 0);
    updateDiscountTotal(parseFloat($(".inp_discount").val()));

});

function setTaxCharges(event){
    var tax_val = $(event).val();
    var dIndex = $(event).attr("data-index");
          updateTaxTotal('singleListingtaxRate_'+dIndex, tax_val);
          updateDiscountTotal(parseFloat($(".inp_discount").val()));
}

function setTaxType(event)
{
    var tax_type = $(event).find('option:selected').text();
    var dIndex = $(event).attr("data-index");
    $("#singleListingtaxType_"+dIndex).html(tax_type);
}

function updateTaxTotal (rowID, tax_val)
 {
    var inputs = $(".amount");
    var subTotal = 0;
            for (var i = 0; i < inputs.length; i++) 
             {
                subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
             }
            if(typeof  tax_val != 'undefined' && tax_val !=0 && tax_val !=null)
             {
                var itemsingleTaxPrice = parseFloat((subTotal / 100) * (parseFloat(tax_val)).toFixed(2));
                 $("#"+rowID).html(itemsingleTaxPrice.toFixed(2) +' ('+tax_val+' %)' );
             }
           
            var totalItemTaxPrice = 0;
            var itemTaxPriceInput = $('.itemTaxRate');
            for (var j = 0; j < itemTaxPriceInput.length; j++) {
                if(itemTaxPriceInput[j].value != '' && !isNaN(itemTaxPriceInput[j].value) && itemTaxPriceInput[j].value != null)
                    totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
            }
            var itemTaxPrice = parseFloat((totalItemTaxPrice / 100) * (subTotal));
              $('.totalAmount').html((parseFloat(subTotal) + parseFloat(itemTaxPrice)).toFixed(2));
 }

</script>

<!------------------------------- SHIPPING SECTION ------------------------->
<script>
    // #Add shipping Rows
    var index = shippingChargesDBCount;
 $("body").on("click", ".add_shipping_row", function(){
        var html = [];
        html += '<td colspan="2">';
        html += ' <label>Shipping type</label>';
        html += '<select class="form-control " onchange="setShippingType(this)" data-index="' + (index + 1) + '"  name="shipping_type[]" >';
        html += '    <option value="" >Select..</option>';
        if(shippingChargesTypes && shippingChargesTypes.length > 0){
            for(var j=0; j<shippingChargesTypes.length; j++) {
                if(shippingChargesTypes[j]?.name != '' && shippingChargesTypes[j]?.name != null){
        html += '    <option value="'+shippingChargesTypes[j]?.id+'" >'+shippingChargesTypes[j]?.name+' </option>';
            }}  }
        html += '</select>';
        html += '</td>';
        html += '<td colspan="2">';
        html += '    <label>Shipping Charges</label>';
        html += '      <input class="form-control itemTaxRate itemEditShpRate" type="text" data-index="' + (index + 1) + '" onkeyup="setShippingCharges(this)"   name="shipping_charges[]" placeholder="0.00" />';
        html += '  </td>';
        html += '  <td colspan="2">';
        html += '      <button  class="btn btn-md btn-danger mt-2 minus_ship_row" type="button">-</button>';
        html += '  </td>';

 $("#shp_row_"+index).html(html);
    $("#shp_row_"+index).closest( "tr" ).after('<tr class="mt-1" data-index="' + (index + 1) + '"  id="shp_row_' + (index + 1) + '"></tr>');

     // #listing
    var shipHtml=[];
    shipHtml += ' <td>&nbsp;</td>';
    shipHtml += ' <td>&nbsp;</td>';
    shipHtml += ' <td>&nbsp;</td>';
    shipHtml += ' <td></td>';
    shipHtml += ' <td><strong id="singleListingShippingType_' + (index + 1) + '">Shipping </strong></td>';
    shipHtml += ' <td class="text-end totalTax" id="singleListingShippingRate_' + (index + 1) + '">0.00</td>';
    shipHtml += ' <td></td>';
    $("#show_shipping_list_"+index).html(shipHtml);
    $("#show_shipping_list_"+index).closest( "tr" ).after('<tr class="mt-1" id="show_shipping_list_' + (index + 1) + '"></tr>');
    index++;
});

$("body").on("click", ".minus_ship_row", function(){
    index--
    $(this).parent().parent().remove();
    $("#show_shipping_list_"+index).remove();
    $("#singleListingShippingRate_"+index).remove();
    updateTaxTotal('singleListingShippingRate_'+index, 0);
    updateDiscountTotal(parseFloat($(".inp_discount").val()));

});

function setShippingCharges(event){
    var shp_val = $(event).val();
    var dIndex = $(event).attr("data-index");
    updateTaxTotal('singleListingShippingRate_'+dIndex, shp_val);
    updateDiscountTotal(parseFloat($(".inp_discount").val()));

 }

function setShippingType(event){
    var shp_type = $(event).find('option:selected').text();
    var dIndex = $(event).attr("data-index");
    $("#singleListingShippingType_"+dIndex).html(shp_type);
}

</script>
<script>

  function updateDiscountTotal (totalItemDiscountPrice)
   {
    var inputs = $(".amount");
    var subTotal = 0;
            for (var i = 0; i < inputs.length; i++) 
             {
                subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
             }
            var totalItemTaxPrice = 0;
            var itemTaxPriceInput = $('.itemTaxRate');
            for (var j = 0; j < itemTaxPriceInput.length; j++) {
                totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
            }
                var itemTaxPrice = parseFloat((totalItemTaxPrice / 100) * (subTotal));
                var totalItemDiscountPercentage = parseFloat((totalItemDiscountPrice / 100) * (subTotal));

            $('.totalDiscount').html(totalItemDiscountPercentage.toFixed(2) + ' ('+ totalItemDiscountPrice +' % )');
            $('.totalAmount').html((parseFloat(subTotal) - parseFloat(totalItemDiscountPercentage) + parseFloat(itemTaxPrice)).toFixed(2));

  }

$(".inp_discount").on("keyup", function(){
   var  discount_val = $(this).val();
        discount_val =  parseFloat(discount_val);
    updateDiscountTotal(discount_val);

});

</script>
@endpush