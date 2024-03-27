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
         html += '      <input class="form-control itemTaxRate shipingRate" type="text" data-index="' + (index + 1) + '" onkeyup="setShippingCharges(this)"   name="shipping_charges[]" placeholder="0.00" />';
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
    //  $("#singleListingShippingType_"+index).remove();
    //  $("#singleListingShippingRate_"+index).remove();
     updateShippingTotal('singleListingShippingRate_'+index, 0);
     
 });
 
 function setShippingCharges(event){
     var shp_val = $(event).val();
     var dIndex = $(event).attr("data-index");
     updateShippingTotal('singleListingShippingRate_'+dIndex, shp_val);
 
  }
 
 function setShippingType(event){
     var shp_type = $(event).find('option:selected').text();
     var dIndex = $(event).attr("data-index");
     $("#singleListingShippingType_"+dIndex).html(shp_type);
 }
 

 function updateShippingTotal (rowID, tax_val)
{
           if(typeof  tax_val != 'undefined' && tax_val !=0 && tax_val !=null)
            {
                $("#"+rowID).html(parseFloat(tax_val));
            }
       ShowAllCalulationsTotals();
}