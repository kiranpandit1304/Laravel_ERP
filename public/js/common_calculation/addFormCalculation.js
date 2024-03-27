
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
                var file_uploads = $(this).find('input.multi');
                if (file_uploads.length) {
                    $(this).find('input.multi').MultiFile({
                        max: 3,
                        accept: 'png|jpg|jpeg',
                        max_size: 2048
                    });
                }
                $('.select2').select2();
                // get_purchase_product($(".warehpuse_d").val());
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
    // get customer
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
// get vendor
    $(document).on('change', '#vender', function() {
        $('#vender_detail').removeClass('d-none');
        $('#vender_detail').addClass('d-block');
        $('#vender-box').removeClass('d-block');
        $('#vender-box').addClass('d-none');
        var id = $(this).val();
        var url = $(this).data('url');
        $.ajax({
            url: url,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': jQuery('#token').val()
            },
            data: {
                'id': id
            },
            cache: false,
            success: function(data) {
                if (data != '') {
                    $('#vender_detail').html(data);
                } else {
                    $('#vender-box').removeClass('d-none');
                    $('#vender-box').addClass('d-block');
                    $('#vender_detail').removeClass('d-block');
                    $('#vender_detail').addClass('d-none');
                }
            },
        });
    });

    $(document).on('click', '#remove', function() {
        $('#vender-box').removeClass('d-none');
        $('#vender-box').addClass('d-block');
        $('#vender_detail').removeClass('d-block');
        $('#vender_detail').addClass('d-none');
    })


    $(document).on('change', '.item', function() {
        var iteams_id = $(this).val();
        var warehouse_id = $(".warehouse_d").val();
        if(warehouse_id == '' || warehouse_id == null){
            alert("Please select warehouse first.")
            return false;
        }
        var url = $(this).data('url');
        var el = $(this);
        $.ajax({
            url: url,
            type: 'POST',
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

                $(el.parent().parent().find('.quantity')).val(1);
                $(el.parent().parent().find('.price')).val(item?.price);
                console.log(el);
                var taxes = '';
                var tax = [];

                var totalItemTaxRate = 0;
                if (item.taxes == 0) {
                    taxes += '-';
                } else {
                    for (var i = 0; i < item.taxes.length; i++) {

                        taxes += '<span class="badge bg-primary mt-1 mr-2">' + item.taxes[i].name + ' ' + '(' + item.taxes[i].rate + '%)' + '</span>';
                        tax.push(item.taxes[i].id);
                        totalItemTaxRate += parseFloat(item.taxes[i].rate);

                    }
                }
                
                $(el.parent().parent().find('.tax')).val(tax);
                $(el.parent().parent().find('.unit')).html(item.unit);
                $(el.parent().parent().find('.discount')).val(0);
                $(el.parent().parent().find('.amount')).html(item.totalAmount);
                $(el.parent().parent().find('.stock_d')).html(item.totalstock);


                var inputs = $(".amount");
                var subTotal = 0;
                for (var i = 0; i < inputs.length; i++) {
                    subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
                }
                $('.subTotal').html(subTotal.toFixed(2));

                ShowAllCalulationsTotals();

            },
        });
    });

    var vendorId = '{{$vendorId}}';
    if (vendorId > 0) {
        $('#vender').val(vendorId).change();
    }
