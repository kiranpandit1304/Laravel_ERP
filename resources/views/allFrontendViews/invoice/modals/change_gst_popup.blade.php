 <!-- Change GST Popup -->
 <div class="modal fade twoside_modal" id="changeGst" tabindex="-1" role="dialog" aria-labelledby="changeGstLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
                    </button>
                    <div class="modal-body">
                        <div class="setup_wrapper">
                            <h2>Configure Tax</h2>

                            <div class="inner_model_wrapper">
                                <select class="js-example-placeholder-single-taxtype tx_poup_taxtype ">
                                    <option value="none" {{$saleInvoice->tax_type=='none' ? 'selected' : ''}} >None</option>
                                    <option value="gst" {{$saleInvoice->tax_type!='none' ? 'selected' : ''}}>GST (India)</option>
                                </select>
                                <div class="gst_option comn_rate_col {{$saleInvoice->tax_type=='none' ? 'hide-d' : ''}} ">
                                    <div class="form-check">
                                        <input class="form-check-input is_igst_popoup_val i_c_s_gst_radio" type="radio" value="IGST" name="flexRadioDefault" id="flexRadioDefault4" {{  $saleInvoice->is_tax != 'CGST' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="flexRadioDefault4">
                                        IGST
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input is_igst_popoup_val i_c_s_gst_radio" type="radio" value="CGST" name="flexRadioDefault" id="flexRadioDefault5" {{ !empty($saleInvoice->is_tax) && $saleInvoice->is_tax == 'CGST' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="flexRadioDefault5">
                                            CGST &amp; SGST
                                        </label>
                                    </div>
                                </div>
                                <span>You are billing to a Non-GST Registered client</span>
                                <div class="com_action">
                                    <button class="nobgc" data-dismiss="modal" aria-label="Close">Cancel</button>
                                    <button class="click_next click_next_close "  data-dismiss="modal" aria-label="Close">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        @push('custom-scripts')
<script>
$("body").on("change", ".tx_poup_taxtype", function(){
    var sel_val = $(this).val();
    if (sel_val == 'none') {
        $(".comn_rate_col").addClass("hide-d");
        $(".c_s_gst_th").addClass("hide-d");
        $(".c_s_gst_td").addClass("hide-d");
        
        $("#final_igst1").prop('checked', true);
        $("#final_sgst2").removeAttr("checked");


        $("#flexRadioDefault4").prop('checked', true);
        $("#flexRadioDefault5").removeAttr("checked");

        //..calculation
        $(".gst_rate_d").val(0);
        $(".igst_d").val(0);

        $(".cgst_d").val(0);
        $(".sgst_d").val(0);
        removeGstRateFromArray();
        removeIgstFromArray();
        removeCgstFromArray();
        removeSgstFromArray();

        var itemGST = $(".gst_rate_d");
    var totalGST = 0;
    for (var k = 0; k <= itemGST.length; k++) {
        if (
            typeof itemGST[k]?.value != "undefined" &&
            itemGST[k]?.value != "" &&
            itemGST[k]?.value != null &&
            !isNaN(itemGST[k]?.value)
        ) {
            // totalGST =
            //     parseFloat(totalGST) +
            //     parseFloat(itemGST[k]?.value);
            calculateRowValues(k);

        }
    }
         // ..end
    } else {
        $(".comn_rate_col").removeClass("hide-d");
        var itemGST = $(".gst_rate_d");
        for (var k = 0; k <= itemGST.length; k++) {
        // if (
        //     typeof itemGST[k]?.value != "undefined" &&
        //     itemGST[k]?.value != "" &&
        //     itemGST[k]?.value != null &&
        //     !isNaN(itemGST[k]?.value)
        // ) {
           var rate=  $(".budle_quantity_"+k).attr("data-gst-rate");
            $(".gst_rate_"+k).val(rate);
                calculateRowValues(k);
        // }
        

         // ..end

    }
        addGstRateInArray();
        addIgstInArray();

    }

    loadDefaultColumns();
    listColumnsInPopUp();
    loadColumnOnPage();
    reLoadColumnFieldsOnPage();

    $('.items_view_edit_table').each(function (i, obj) {
        var index = $(obj).attr("data-items_view_edit_table");
        var divList = $("div").find("[data-items_view_edit_table='" + index + "'] .listing-item");
        divList.sort(function (a, b) {
            return $(a).data("listing-item") - $(b).data("listing-item")
        });

        $("div").find("[data-items_view_edit_table='" + index + "']").html(divList);
    });

    ImgUpload();
    $("#editcolumns").modal("hide");
    AddOldGstRates();

});

function AddOldGstRates() {
    var itemGST = $(".gst_rate_d");
    for (var k = 0; k <= itemGST.length; k++) {
       
            var rate = $(".budle_quantity_" + k).attr("data-gst-rate");
            console.log('rate ', rate);
            $(".gst_rate_" + k).val(rate);
            calculateRowValues(k);
    }
}

</script>
@endpush

      