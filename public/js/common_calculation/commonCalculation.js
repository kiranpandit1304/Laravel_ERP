function ShowAllCalulationsTotals() {

    var inputs = $(".amount");
    var subTotal = 0;
            for (var i = 0; i < inputs.length; i++) 
             {
                subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
             }
    var totalItemDiscountPrice = 0;
    var itemDiscountPriceInput = $(".inp_discount");

    for (var k = 0; k < itemDiscountPriceInput.length; k++) {
        if (
            typeof itemDiscountPriceInput[k]?.value !=
                "undefined" &&
            itemDiscountPriceInput[k]?.value != null
        ) {
            totalItemDiscountPrice += parseFloat(
                itemDiscountPriceInput[k].value
            );
        }
    }
    var itemEditTxPrice = $(".taxRate");
    var totalTax_rate = 0;
    for (var t = 0; t <= itemEditTxPrice.length; t++) {
        if (
            typeof itemEditTxPrice[t]?.value &&
            itemEditTxPrice[t]?.value != "" &&
            itemEditTxPrice[t]?.value != "undefined" &&
            itemEditTxPrice[t]?.value != null &&
            !isNaN(itemEditTxPrice[t]?.value)
        ) {
            totalTax_rate =
                parseFloat(totalTax_rate) +
                parseFloat(itemEditTxPrice[t]?.value / 100) * subTotal;
            $("#singleListingtaxRate_" + t).html(
                parseFloat(
                    (itemEditTxPrice[t]?.value / 100) * subTotal
                ).toFixed(2) +
                    " (" +
                    itemEditTxPrice[t]?.value +
                    " %)"
            );
        }
    }
    var itemShpPrice = $(".shipingRate");
    var totalShipping_rate = 0;
    for (var k = 0; k <= itemShpPrice.length; k++) {
        if (
            typeof itemShpPrice[k]?.value != "undefined" &&
            itemShpPrice[k]?.value != "" &&
            itemShpPrice[k]?.value != null &&
            !isNaN(itemShpPrice[k]?.value)
        ) {
            totalShipping_rate =
                parseFloat(totalShipping_rate) +
                parseFloat(itemShpPrice[k]?.value);
            $("#singleListingShippingRate_" + k).html(itemShpPrice[k]?.value);
        }
    }
    var totalItemDiscountPercentage = 0;
    var showItemDiscountRate = 0;
    if (
        typeof totalItemDiscountPrice &&
        totalItemDiscountPrice != "" &&
        totalItemDiscountPrice != "undefined" &&
        totalItemDiscountPrice != null &&
        !isNaN(totalItemDiscountPrice)
    ) {
        totalItemDiscountPercentage = parseFloat(
            (totalItemDiscountPrice / 100) * subTotal
        );
        showItemDiscountRate = parseFloat(totalItemDiscountPrice);
    }
    var totalItemTaxPrice =
        parseFloat(totalTax_rate) + parseFloat(totalShipping_rate);
    $(".totalDiscount").html(
        totalItemDiscountPercentage.toFixed(2) +
            " (" +
            showItemDiscountRate +
            " % )"
    );
    $(".totalAmount").html(
        (
            parseFloat(subTotal) -
            parseFloat(totalItemDiscountPercentage) +
            parseFloat(totalItemTaxPrice)
        ).toFixed(2)
    );
    return true;
}

$(document).on("keyup", ".quantity", function () {
    var el = $(this).parent().parent().parent().parent();
    var quantity = $(this).val();
    var price = $(el.find(".price")).val();
    var totalItemDiscountPrice = $(el.find(".inp_discount")).val();

    var totalItemPrice = quantity * price;
    var amount = totalItemPrice;
    $(el.find(".amount")).html(amount);

    var inputs = $(".amount");
    var subTotal = 0;
    for (var i = 0; i < inputs.length; i++) {
        subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
    }
    $(".subTotal").html(subTotal.toFixed(2));

    ShowAllCalulationsTotals();
});

$(document).on("keyup", ".price", function () {
    var el = $(this).parent().parent().parent().parent();
    var price = $(this).val();
    var quantity = $(el.find(".quantity")).val();
    var totalItemDiscountPrice = $(el.find(".inp_discount")).val();
    var totalItemPrice = quantity * price;

    var amount = totalItemPrice;
    $(el.find(".amount")).html(amount);

    var inputs = $(".amount");
    var subTotal = 0;
    for (var i = 0; i < inputs.length; i++) {
        subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
    }
    $(".subTotal").html(subTotal.toFixed(2));

    ShowAllCalulationsTotals();
});
$(".inp_discount").on("keyup", function(){
    ShowAllCalulationsTotals();
});

$("body").on("click",".item", function(){
    var wID  = $(".warehouse_d").val();
if(wID==''){
    alert("Please select warehouse.")
}
});

    $("body").on("click",".sale_wh_id", function(){
     var wID  = $(this).val();
     var wurl = $(this).data("url");
    getPurchasedProducts(wID);
     
 });
 $("body").on("click",".add_items", function(){
    var wID  = $(".warehouse_d").val();
    getPurchasedProducts(wID);
});

function getPurchasedProducts(wID){
    var wurl = $(".warehouse_d").data("url");
    $.ajax({
        url:wurl,
        type:'POST',
        headers: {
            "X-CSRF-TOKEN": jQuery("#token").val(),
        },
        data:{warehouse_id:wID},
        success: function (resp){
            var html=[];
            html+= '<option value="" >Select Item</option>';
            if(resp.length){
            for(var i=0; i<resp.length; i++){
                if(resp[i]?.id!='' && resp[i]?.id!='undefined'&& resp[i]?.id!=null){
                html+= '<option value="'+resp[i]?.id+'" >'+resp[i]?.name+'</option>'
            }
           }
          }
           $(".sale_prod").empty().html(html);
        }
     });
}
