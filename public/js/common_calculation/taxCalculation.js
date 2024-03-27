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
     html += '      <input class="form-control itemTaxRate taxRate" data-index="' + (indx + 1) + '"  onkeyup="setTaxCharges(this)" type="text" name="tax_charges[]" placeholder="0.00" />';
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
    //  $("#singleListingtaxType_"+indx).remove();
    //  $("#singleListingtaxRate_"+indx).remove();
    console.log("#show_tx_list_"+indx);
     updateTaxTotal('singleListingtaxRate_'+indx, 0);
 
 });
 
 function setTaxCharges(event){
     var tax_val = $(event).val();
     var dIndex = $(event).attr("data-index");
           updateTaxTotal('singleListingtaxRate_'+dIndex, tax_val);
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
          
       ShowAllCalulationsTotals();
}