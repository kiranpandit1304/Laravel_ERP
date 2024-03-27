var selector = "body";
if ($(selector + " .repeater").length) {
    var $dragAndDrop = $("body .repeater tbody").sortable({
        handle: ".sort-handler",
    });
    var $repeater = $(selector + " .repeater").repeater({
        initEmpty: true,
        defaultValues: {
            status: 1,
        },
        show: function () {
            $(this).slideDown();
            var file_uploads = $(this).find("input.multi");
            if (file_uploads.length) {
                $(this).find("input.multi").MultiFile({
                    max: 3,
                    accept: "png|jpg|jpeg",
                    max_size: 2048,
                });
            }
            if ($(".select2").length) {
                $(".select2").select2();
            }
        },
        hide: function (deleteElement) {
            if (confirm("Are you sure you want to delete this element?")) {
                $(this).slideUp(deleteElement);
                $(this).remove();
                var inputs = $(".amount");
                var subTotal = 0;
                for (var i = 0; i < inputs.length; i++) {
                    subTotal =
                        parseFloat(subTotal) + parseFloat($(inputs[i]).html());
                }
                $(".subTotal").html(subTotal.toFixed(2));
                $(".totalAmount").html(subTotal.toFixed(2));
            }
        },
        ready: function (setIndexes) {
            $dragAndDrop.on("drop", setIndexes);
        },
        isFirstItemUndeletable: true,
    });
    var value = $(selector + " .repeater").attr("data-value");
    if (typeof value != "undefined" && value.length != 0) {
        value = JSON.parse(value);
        $repeater.setList(value);
        for (var i = 0; i < value.length; i++) {
            var tr = $(
                '#sortable-table .id[value="' + value[i].id + '"]'
            ).parent();
            tr.find(".item").val(value[i].product_id);
            changeItem(tr.find(".item"));
            // $(".status_d").val(value[i]?.status);
        }
    }
}

$(document).on("change", "#customer_d", function () {
    $("#vender_detail").removeClass("d-none");
    $("#vender_detail").addClass("d-block");
    $("#vender-box").removeClass("d-block");
    $("#vender-box").addClass("d-none");
    var id = $(this).val();
    var url = $(this).data("url");
    $.ajax({
        url: url,
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": jQuery("#token").val(),
        },
        data: {
            id: id,
        },
        cache: false,
        success: function (data) {
            if (data != "") {
                $("#vender_detail").html(data);
            } else {
                $("#customer-box-box").removeClass("d-none");
                $("#customer-box-box").addClass("d-block");
                $("#vender_detail").removeClass("d-block");
                $("#vender_detail").addClass("d-none");
            }
        },
    });
});

// #get vendor
$(document).on("change", "#vender", function () {
    $("#vender_detail").removeClass("d-none");
    $("#vender_detail").addClass("d-block");
    $("#vender-box").removeClass("d-block");
    $("#vender-box").addClass("d-none");
    var id = $(this).val();
    var url = $(this).data("url");
    $.ajax({
        url: url,
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": jQuery("#token").val(),
        },
        data: {
            id: id,
        },
        cache: false,
        success: function (data) {
            if (data != "") {
                $("#vender_detail").html(data);
            } else {
                $("#customer-box-box").removeClass("d-none");
                $("#customer-box-box").addClass("d-block");
                $("#vender_detail").removeClass("d-block");
                $("#vender_detail").addClass("d-none");
            }
        },
    });
});
$(document).on("click", "#remove", function () {
    $("#vender-box").removeClass("d-none");
    $("#vender-box").addClass("d-block");
    $("#vender_detail").removeClass("d-block");
    $("#vender_detail").addClass("d-none");
});


// var purchase_id = '{{$purchase->id}}';
function changeItem(element) {
    var iteams_id = element.val();
    var warehouse_id = $(".warehouse_d").val();
    
    var url = element.data("url");
    var el = element;
    $.ajax({
        url: url,
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": jQuery("#token").val(),
        },
        data: {
            product_id: iteams_id,
            warehouse_id: warehouse_id,

        },
        cache: false,
        success: function (data) {
            var item = JSON.parse(data);
            $.ajax({
                url: itemURL,
                type: "GET",
                headers: {
                    "X-CSRF-TOKEN": jQuery("#token").val(),
                },
                data: {
                    purchase_id: purchase_id,
                    product_id: iteams_id,
                },
                cache: false,
                success: function (data) {
                    var purchaseItems = JSON.parse(data);
                    var amount = 0;
                    if (purchaseItems != null) {
                        amount = purchaseItems.price * purchaseItems.quantity;
                        $(el.parent().parent().parent().find(".quantity")).val(
                            purchaseItems.quantity
                        );
                        $(el.parent().parent().parent().find(".price")).val(
                            purchaseItems.price
                        );
                    } 
                    else {
                        $(el.parent().parent().parent().find(".quantity")).val(
                            1
                        );
                        $(el.parent().parent().parent().find(".price")).val(
                            item?.price
                        );
                    }
                    $(el.parent().parent().next(".stock_d")
                    ).html(item.totalstock);
                    var taxes = "";
                    var tax = [];
                    var totalItemTaxRate = 0;
                    if (purchaseItems != null) {
                        amount = purchaseItems.price * purchaseItems.quantity;
                        $(el.parent().parent().next().next().next().next(".amount")).html(amount);
                    } else {
                        $(
                            el.parent().parent().next().next().next().next(".amount")
                        ).html(item.totalAmount);
                    }
                    
                    var inputs = $(".amount");
                    var subTotal = 0;
                    for (var i = 0; i < inputs.length; i++) {
                        subTotal =
                            parseFloat(subTotal) +
                            parseFloat($(inputs[i]).html());
                    }
                    $(".subTotal").html(subTotal.toFixed(2));

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

                    var totalItemPrice = 0;
                    var priceInput = $(".price");
                    for (var j = 0; j < priceInput.length; j++) {
                        if (priceInput[j].value != null)
                            totalItemPrice += parseFloat(priceInput[j].value);
                    }

                    var totalItemDiscountPercentage = 0;
                    if (
                        totalItemDiscountPrice != null &&
                        !isNaN(totalItemDiscountPrice)
                    ) {
                        totalItemDiscountPercentage = parseFloat(
                            (totalItemDiscountPrice / 100) * subTotal
                        );
                    }

                    ShowAllCalulationsTotals();
                    
                },
            });
        },
    });
}
$(document).on("change", ".item", function () {
    var warehouse_id = $(".warehouse_d").val();
    if(warehouse_id == '' || warehouse_id == null){
        alert("Please select warehouse first.")
        return false;
    }
    changeItem($(this));
});

$(document).on("click", "[data-repeater-create]", function () {
    $(".item :selected").each(function () {
        var id = $(this).val();
        $(".item option[value=" + id + "]").prop("disabled", true);
    });
});
