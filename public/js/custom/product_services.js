Dropzone.autoDiscover = false;
var dropzones = [];

$(document).ready(function () {
    $('.dropzone').each(function (i, el) {
        var name = 'g_' + $(el).data('field')
        var myDropzone = new Dropzone(el, {
            url: window.location.pathname,
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 1,
            maxFiles: 5,
            paramName: name,
            addRemoveLinks: true,
            removedfile: function (file) {
                file.previewElement.remove();
            }
        });
        dropzones.push(myDropzone);
    });

});

$('body').on('click', '.pagination a', function (e) {
    e.preventDefault();
    $('#load a').css('color', '#dfecf6');
    $('#load').append('<img style="position: absolute; left: 0; top: 0; articles/listingz-index: 100000;" src="/images/loading.gif" />');
    var url = $(this).attr('href');
    var page_number = get_parameter_val("page", url);
    var url = window.location.href;
    var url = updateQueryStringParameter(url, "page", page_number);
    var data = make_final_parameters_object(url);
    data = makeDataObject(data);
    getDomainPage(url, data);
    window.history.pushState("", "", url);
});

$("#applyfilterbtn").on("click", function (e) {
    e.preventDefault();
    $('#load a').css('color', '#dfecf6');
    $('#load').append('<img style="position: absolute; left: 0; top: 0; articles/listingz-index: 100000;" src="/images/loading.gif" />');
    var url = $(location).attr('href');
    var page_number = get_parameter_val("page", url);
    var url = window.location.href;
    var url = updateQueryStringParameter(url, "page", 1);
    var data = make_final_parameters_object(url);
    data = makeDataObject(data);
    getDomainPage(url, data);
    window.history.pushState("", "", url);
});

$("#SerachFilterBtn").on("click", function (e) {

    e.preventDefault();
    $('#load a').css('color', '#dfecf6');
    $('#load').append('<img style="position: absolute; left: 0; top: 0; articles/listingz-index: 100000;" src="/images/loading.gif" />');
    var url = $(location).attr('href');
    var page_number = get_parameter_val("page", url);
    var url = window.location.href;
    var url = updateQueryStringParameter(url, "page", 1);
    var data = make_final_parameters_object(url);
    data = makeDataObject(data);
    getDomainPage(url, data);
    window.history.pushState("", "", url);

});

function ResetDomainPage() {
    $("#filterCategoryBtn").prop("disabled", true);
    $('#load a').css('color', '#dfecf6');
    $('#load').append('<img style="position: absolute; left: 0; top: 0; articles/listingz-index: 100000;" src="/images/loading.gif" />');
    var url = $(location).attr('href');
    var page_number = get_parameter_val("page", url);
    $("#search_item_name").val('');
        $("#search_buying_from").val('');
        $("#search_buying_to").val('');
        $("#search_selling_from").val('');
        $("#search_selling_to").val('');
        $("#search_tax_rate").val('')

    var url = window.location.href;
    var url = updateQueryStringParameter(url, "page", 1);
    var data = make_final_parameters_object(url);
    data = makeDataObject(data);
    getDomainPage(url, data);
    window.history.pushState("", "", url);
    $('.filtered_total_result').html('0 Results shown');

}
function applyfillter() {

    $('#load a').css('color', '#dfecf6');
    $('#load').append('<img style="position: absolute; left: 0; top: 0; articles/listingz-index: 100000;" src="/images/loading.gif" />');
    var url = $(location).attr('href');
    var page_number = get_parameter_val("page", url);
    var url = window.location.href;
    var url = updateQueryStringParameter(url, "page", 1);
    var data = make_final_parameters_object(url);
    data = makeDataObject(data);
    getDomainPage(url, data);
    window.history.pushState("", "", url);
    $(".reset_bt").removeClass("hide-d")
}

$(document).on('keypress', "#search_field_filter", function(e) {
    if(e.which == 13) {
    e.preventDefault();
        applyfillter();
    }
});

function getDomainPage(url, data) {
    block_gui_start();
    $.ajax({
        data: data,
        url: url,
        dataType: 'json',
        success: function (data) {
            block_gui_end();
            $('#product_table_listing').html(data.content);
            $('.filtered_total_result').html(data?.total_record + ' Results shown');
            // resetColumnName();

            $("html, body").animate({ scrollTop: 0 }, 500);
        }, error: function (data) {
            block_gui_end();
            console.log("Item could not be loaded.");
        }
    })
}

function get_parameter_val(name, url) {

    url = filter_uri(url);
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(url);
    if (results == null) {
        return null;
    } else {
        return results[1] || 0;
    }
}
function updateQueryStringParameter(uri, key, value) {

    uri = filter_uri(uri);
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";
    if (uri.match(re)) {
        return uri.replace(re, '$1' + key + "=" + value + '$2');
    } else {
        return uri + separator + key + "=" + value;
    }
}

function make_final_parameters_object(sourceURL) {

    var queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
    var obj = {};
    var pairs = queryString.split('&');
    for (i in pairs) {
        var split = pairs[i].split('=');
        if (obj[decodeURIComponent(split[0])]) {
            obj[decodeURIComponent(split[0])] = obj[decodeURIComponent(split[0])] + "," + decodeURIComponent(split[1]);
        } else {
            obj[decodeURIComponent(split[0])] = decodeURIComponent(split[1]);
        }
    }
    return obj;
}

function filter_uri(uri_enc) {
    if (typeof uri_enc !== "undefined")
        uri_enc = uri_enc.replace(/\+/g, '%20');
    return decodeURIComponent(uri_enc);
}

function makeDataObject(data) {

    if ($("#search_field_filter").val())
        data['search'] = $("#search_field_filter").val();
    else
        data['search'] = "";

    if ($("#search_item_name").val())
        data['item_name'] = $("#search_item_name").val();
    else
        data['item_name'] = "";

    if ($("#search_buying_from").val())
        data['purchase_price_from'] = $("#search_buying_from").val();
    else
        data['purchase_price_from'] = "";

    if ($("#search_buying_to").val())
        data['purchase_price_to'] = $("#search_buying_to").val();
    else
        data['purchase_price_to'] = "";

    if ($("#search_selling_from").val())
        data['selling_price_from'] = $("#search_selling_from").val();
    else
        data['selling_price_from'] = "";

    if ($("#search_selling_to").val())
        data['selling_price_to'] = $("#search_selling_to").val();
    else
        data['selling_price_to'] = "";


    if ($('#search_tax_rate').val())
        data['tax_rate'] = $('#search_tax_rate').val();
    else
        data['tax_rate'] = "";

    if ($('.inventory_topbar_filter').val())
    data['inventory_topbar_filter'] = $('.inventory_topbar_filter').val();
    else
    data['inventory_topbar_filter'] = "";

    return data;
}

function toggleFilterBtn() {

    var f1 = $("#search_field_filter").val();
    var f2 = $("#category_status").val();
    if (f1 || f2) {
        $('#filterCategoryBtn').prop('disabled', false);
    } else {
        $("#filterCategoryBtn").prop("disabled", true);
    }
}

function resetColumnName() {

    $('#gst_no').val('');
    $('#email').val('')
    $('.nature_of_business').val('')
    $('.contact_person').val('')
    $('.billing_phone').val('')
    // $('.sv_billing_country').val('')
    $('.sv_billing_state').val('')
    $('#billing_address').val('')
    $('.billing_zip_code').val('')
    $('.shipping_address').val('')
    // $('.sv_shipping_country').val('')
    $('.sv_shipping_state').val('')
    $('.shipping_zip_code').val('')
    $('#bussiness_gstin').val('')
    $('.pan_no').val('')
    $('._msme_chk').prop('checked', false);
    $('#bank_name').val('')
    $('#ifsc_code').val('')
    $('#account_no').val('')
    $('#branch_address').val('')
    // $('.country_id').val('')
    $('.state_id').val('')
    $('#zip_code').val('')
    $('#upi').val('')
    $('#payment_terms_days').val('')
}

$("body").on("submit", "#create_item_form", function(){
     var formData = new FormData($(this)[0]);
     $(".multi_product_images").each(function (index) {
        // formData.append('product_image[' + index + ']', $(this).val());
     });
        $.ajax({
            url: APP_URL+'/api/ProductAdd',
            data: formData,
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function (xhr) {
                block_gui_start();
                xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
            },
            success: function (response) {
                block_gui_end();
                if (response.status == true) {
                    toastr.success(response?.message)
                    $("#createcustomerPopup").modal("show")
                    window.location.reload();
                } else {
                    toastr.error(response?.message)
                }
    
            }, error: function (response) {
                block_gui_end();
                console.log("server side error");
            }
        })
});

function UpdateEntity(event) {

    var form = $("#CustomerDetailForm")[0];
    var formData = new FormData(form);
    $(".multi_product_images").each(function (index) {
        formData.append('customer_doc[' + index + ']', $(this).val());
    });
    formData.append('billing_country_name', $('.sv_billing_country').find(":selected").text());
    formData.append('billing_state_name', $('.sv_billing_state').find(":selected").text());
    formData.append('shipping_country_name', $('.sv_shipping_country').find(":selected").text());
    formData.append('shipping_state_name', $('.sv_shipping_state').find(":selected").text());
    formData.append('country_name', $('.country_id').find(":selected").text());
    formData.append('state_name', $('.state_id').find(":selected").text());
    formData.append('id', $('#uid').val());
    var dsk = 0;
    var mb = 0;
    dropzones.forEach(function (dropzone) {

        var element = dropzone.element;
        var cindex = $(element).get(0).id;
        var paramName = dropzone.options;
        var fiels = dropzone.getAcceptedFiles();
        fiels.forEach(function (file, i) {
            if (cindex && cindex == "desktop_media") {
                formData.append('customer_doc[' + dsk + ']', file);
                dsk++
            } else if (cindex && cindex == "mobile_media") {
                formData.append('customer_doc[' + mb + ']', file);
                mb++;
            }
        });
    });
    $.ajax({
        url: UpdatCustomereURL,
        data: formData,
        type: 'post',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                toastr.success(response?.message)
                $("#createcustomerPopup").modal("show")
                window.location.reload();
            } else {
                toastr.error(response?.message)
            }

        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    })
}


// 06AAHCD4406B1Z8 get tax details
$("body").on("click", ".get_gst_data", function () {
    var gst_number = $('#gst_no').val();

    if (gst_number == '' || gst_number == undefined) {
        $(".gst_field").css("border", "1px solid red");
        return false;
    } else {
        $(".gst_field").css("border", "");

    }
    $("#pan_card").val(gst_number.slice(2, -3));
    $.ajax({
        url: APP_URL + "/api/getGstDetails/" + gst_number,
        type: "GET",
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                response = response.data
                $('#fname').val(response?.lgnm)
                $('#list10').val(response?.gstin);
                var bnm = '';
                if(response?.pradr?.addr?.bnm != undefined && response?.pradr?.addr?.bnm != ''){
                    bnm = response?.pradr?.addr?.bnm 
                }
                var st = '';
                if(response?.pradr?.addr?.st != undefined && response?.pradr?.addr?.st != ''){
                    st = response?.pradr?.addr?.st 
                }
                var loc = '';
                if(response?.pradr?.addr?.loc != undefined && response?.pradr?.addr?.loc != ''){
                    loc = response?.pradr?.addr?.loc 
                }
                var dst = '';
                if(response?.pradr?.addr?.dst != undefined && response?.pradr?.addr?.dst != ''){
                    dst = response?.pradr?.addr?.dst 
                }
                var stcd = '';
                if(response?.pradr?.addr?.stcd != undefined && response?.pradr?.addr?.stcd != ''){
                    stcd = response?.pradr?.addr?.stcd 
                }
                var pncd = '';
                if(response?.pradr?.addr?.pncd != undefined && response?.pradr?.addr?.pncd != ''){
                    pncd = response?.pradr?.addr?.pncd 
                }
                var addesss = bno + ' ' +bnm + ' ' + st + ' ' + loc + ' ' + dst + ' ' + stcd+ ' ' +pncd;
                // var addesss = response?.pradr?.addr?.st + ' ' + response?.pradr?.addr?.loc + ' ' + response?.pradr?.addr?.dst + ' ' + response?.pradr?.addr?.stcd
                $('#billing_address').val(addesss);
                var statelist = state_list.filter(v => v.name === stcd);
                $('.sv_billing_state').val(statelist[0]?.id);
                $('.billing_zip_code').val(pncd);
                

            } else {
                toastr.error('GST number is not correct.');
            }
            $(".step-tab").removeClass("active");
            var tid = $(".get_gst_data").attr("data-target");
            $("#" + tid).addClass("active");
        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
});
// copy address
$("body").on("click", ".address_copy", function () {
    var typ = $(this).attr("data-id");
    if (typ == 'yes') {
        $(".shi_add").val($("#billing_address").val());
        $(".sv_shipping_country").val($('.sv_billing_country').val());
        $(".sv_shipping_state").val($('.sv_billing_state').val());
        $("#shipping_zip_code").val($("#billing_zip").val())
        $(this).attr("data-id", "no");

    } else {
        $(".shi_add").val('');
        $(".sv_shipping_country").val('');
        $(".sv_shipping_state").val('');
        $("#shipping_zip_code").val('');
        $(this).attr("data-id", "yes");
    }
});
// handle next btn with validation
$("body").on("click", ".next_btn", function () {
    $(".step-tab").removeClass("active");
    var tid = $(this).attr("data-target");
    $("#" + tid).addClass("active");
});

//Fill next button tab
$("body").on("focusout", "#ifsc_code", function(){
   var ifcs_code = $(this).val();
    $.ajax({
        url:  'https://ifsc.razorpay.com/'+ifcs_code,
        type: "GET",
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            block_gui_start();
        },
        success: function (response) {
            block_gui_end();
                $('#bank_name').val(response?.BANK)
                $('#branch_address').val(response?.ADDRESS);
                var statelist = state_list.filter(v => v.name.toLowerCase() === response?.STATE.toLowerCase());
                $('.bnk_state').val(statelist[0]?.id);
                $('#upi').val(response?.UPI);

        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
});
//For Edit
$("body").on("click", ".offcanvasModal", function () {
    dropzones.forEach(function (dropzone) {
        dropzone.removeAllFiles(true);
    });
    var id = $(this).attr('data-id');
    $.ajax({
        url: CustomerShowURL + "/" + id,
        type: "GET",
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                if (response?.media != null && response?.media != '' && response?.media != undefined && response?.media.length > 0) {
                    var mediaHtml = [];
                    for (var i = 0; i <= response?.media.length; i++) {
                        if (response?.media[i]?.customer_doc != '' && response?.media[i]?.customer_doc != undefined && response?.media[i]?.customer_doc != null) {
                            mediaHtml += '<li class="md_row_' + response?.media[i]?.id + '">';
                            mediaHtml += '<div class="file_item">';
                            mediaHtml += ' <div>';
                            mediaHtml += '       <span>';
                            mediaHtml += '        <img src="' + APP_URL + '/storage/uploads/customer_vendor_doc' + response?.media[i]?.customer_doc + '" alt=""> ';
                            mediaHtml += '     </span>';
                            mediaHtml += '    <a href=" ' + APP_URL + '/storage/uploads/customer_vendor_doc/' + response?.media[i]?.customer_doc + '" target="_blank" > <h6>' + response?.media[i]?.customer_doc + '</h6> </a>';
                            mediaHtml += ' </div>';
                            mediaHtml += ' <div class="iabtn">';
                            mediaHtml += '     <a href="#"  class="delte_media_btn" data-id="' + response?.media[i]?.id + '" ><iconify-icon icon="mingcute:delete-2-line"></iconify-icon></a>';
                            mediaHtml += ' </div>';
                            mediaHtml += '</div>';
                            mediaHtml += ' </li>';
                        }
                    }
                    $(".show_db_media").empty().append(mediaHtml);
                }
                response = response.data
                $('.cid').val(response?.id);
                $('.cus_title').html(response?.name);
                $('.fname').val(response?.name);
                $('.gst_no').val(response?.tax_number);
                $('.email').val(response?.email)
                $('.nature_of_business').val(response?.nature_of_business)
                $('.contact_person').val(response?.contact_person)
                $('.billing_phone').val(response?.billing_phone)
                $('.billing_country').val(response?.billing_country)
                $('.billing_state').val(response?.billing_state)
                $('.billing_address').val(response?.billing_address)
                $('.billing_zip_code').val(response?.billing_zip)
                $('.shipping_address').val(response?.shipping_address)
                $('.shipping_country').val(response?.shipping_country)
                $('.shipping_state').val(response?.shipping_state)
                $('.shipping_zip_code').val(response?.shipping_zip)
                $('.bussiness_gstin').val(response?.bussiness_gstin)
                $('.pan_no').val(response?.pan)
                if (response?.is_msme === '1')
                    $('._msme_chk').prop('checked', true);
                else
                    $('._msme_chk').prop('checked', false);

                $('.bank_name').val(response?.bank_name)
                $('.ifsc_code').val(response?.ifsc_code)
                $('.account_no').val(response?.account_no)
                $('.branch_address').val(response?.branch_address)
                $('.country_id').val(response?.country_id)
                $('.state_id').val(response?.state_id)
                $('.zip_code').val(response?.zip_code)
                $('.upi').val(response?.upi)
                $('.payment_terms_days').val(response?.payment_terms_days)

                $("#offcanvasExample").offcanvas("toggle");
            } else {
                toastr.error(response.message);
            }

        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
});
// ..........# Save edit form...........
$("body").on("click", ".cust_save_btn", function () {
    var form = $("#CustomerDetailForm1")[0];
    var formData = new FormData(form);
    formData.append('name', $(".fname").val());
    formData.append('gst_no', $(".gst_no").val());
    formData.append('email', $(".email").val());
    formData.append('nature_of_business', $(".nature_of_business").val());
    formData.append('contact_person', $(".contact_person").val());
    formData.append('billing_phone', $(".billing_phone").val());
    formData.append('billing_address', $(".billing_address").val());
    formData.append('shipping_address', $(".shipping_address").val());
    formData.append('billing_zip', $(".billing_zip_code").val());
    formData.append('shipping_zip', $(".shipping_zip_code").val());
    formData.append('bussiness_gstin', $(".bussiness_gstin").val());
    formData.append('pan', $(".pan_no").val());
    if ($(".is_msme").is(":checked"))
        formData.append('is_msme', '1');
    else
        formData.append('is_msme', '0');

    formData.append('bank_name', $(".bank_name").val());
    formData.append('ifsc_code', $(".ifsc_code").val());
    formData.append('account_no', $(".account_no").val());
    formData.append('branch_address', $(".branch_address").val());
    formData.append('country_id', $(".country_id").val());
    formData.append('state_id', $(".state_id").val());
    formData.append('zip_code', $(".zip_code").val());
    formData.append('upi', $(".upi").val());
    formData.append('payment_terms_days', $(".payment_terms_days").val());

    formData.append('billing_country', $('.billing_country').find(":selected").val());
    formData.append('billing_country_name', $('.billing_country').find(":selected").text());

    formData.append('billing_state', $('.billing_state').find(":selected").val());
    formData.append('billing_state_name', $('.billing_state').find(":selected").text());

    formData.append('shipping_country', $('.shipping_country').find(":selected").val());
    formData.append('shipping_country_name', $('.shipping_country').find(":selected").text());

    formData.append('shipping_state', $('.shipping_state').find(":selected").val());
    formData.append('shipping_state_name', $('.shipping_state').find(":selected").text());

    formData.append('country_name', $('.country_id').find(":selected").text());

    formData.append('state_name', $('.state_id').find(":selected").text());

    formData.append('id', $('.cid').val());
    var dsk = 0;
    var mb = 0;
    dropzones.forEach(function (dropzone) {

        var element = dropzone.element;
        var cindex = $(element).get(0).id;
        var paramName = dropzone.options;
        var fiels = dropzone.getAcceptedFiles();
        fiels.forEach(function (file, i) {
            if (cindex && cindex == "desktop_media") {
                formData.append('customer_doc[' + dsk + ']', file);
                dsk++

            } else if (cindex && cindex == "mobile_media") {
                formData.append('customer_doc[' + mb + ']', file);
                mb++;
            }
        });
    });
    $.ajax({
        url: CustomerEdit,
        type: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                $("#offcanvasExample").offcanvas("toggle");
                toastr.success(response.message);
                ResetDomainPage();
            } else {
                toastr.error(response.message);
            }

        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
});

//handle customer edit form changes
$(".cust_detail").on("click", function () {
    var type = $(this).attr("data-type");
    if (type == 'edit') {
        $('.inp_cus_detail').prop("disabled", false);
        $(this).attr("data-type", 'save');
        $(this).removeClass('cust_save_btn');
        $(this).html('Save');
    } else {
        $('.inp_cus_detail').prop("disabled", true);
        $(this).attr("data-type", 'edit');
        $(this).addClass('cust_save_btn');
        $(this).html('Edit');
    }
});


//handle customer edit form changes
$(".address_shipping_detail").on("click", function () {
    var type = $(this).attr("data-type");
    if (type == 'edit') {
        $('.inp_ship_detail').prop("disabled", false);
        $(this).attr("data-type", 'save');
        $(this).removeClass('cust_save_btn');
        $(this).html('Save');
    } else {
        $('.inp_ship_detail').prop("disabled", true);
        $(this).attr("data-type", 'edit');
        $(this).addClass('cust_save_btn');
        $(this).html('Edit');
    }
});

//handle customer edit form changes
$(".tax_information").on("click", function () {
    var type = $(this).attr("data-type");
    if (type == 'edit') {
        $('.inp_tax_detail').prop("disabled", false);
        $(this).attr("data-type", 'save');
        $(this).removeClass('cust_save_btn');
        $(this).html('Save');
    } else {
        $('.inp_tax_detail').prop("disabled", true);
        $(this).attr("data-type", 'edit');
        $(this).addClass('cust_save_btn');
        $(this).html('Edit');
    }
});

//handle payment form changes
$(".payment_detail_d").on("click", function () {
    var type = $(this).attr("data-type");
    if (type == 'edit') {
        $('.inp_pymnent_detail').prop("disabled", false);
        $(this).attr("data-type", 'save');
        $(this).removeClass('cust_save_btn');
        $(this).html('Save');
    } else {
        $('.inp_pymnent_detail').prop("disabled", true);
        $(this).attr("data-type", 'edit');
        $(this).addClass('cust_save_btn');
        $(this).html('Edit');
    }
});
//handle upload file changes
$(".upload_file_d").on("click", function () {
    var type = $(this).attr("data-type");
    if (type == 'edit') {
        $(this).attr("data-type", 'save');
        $(this).removeClass('cust_save_btn');
        $("#desktop_media").removeClass('hide-d');
        $(this).html('Save file');
    } else {
        $(this).attr("data-type", 'edit');
        $(this).addClass('cust_save_btn');
        $("#desktop_media").addClass('hide-d');
        $(this).html('Upload Files');
    }
});

//........... Delete media........... 
$("body").on("click", ".delte_media_btn", function () {
    var mid = $(this).attr("data-id");
    $.ajax({
        url: DeleteMediaURL + "/" + mid,
        type: "get",
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            if (confirm("Are you sure?")) {
                block_gui_start();
                xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
            } else {
                // stop the ajax call
                return false;
            }

        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                toastr.success(response.message);
                $(".md_row_" + mid).remove();
            } else {
                toastr.error(response.message);
            }

        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
});
$("body").on("click", ".delte_cutomer_btn", function () {
    var mid = $(".cid").val();
    $.ajax({
        url: DeleteCustomerURL + "/" + mid,
        type: "get",
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            if (confirm("Are you sure?")) {
                block_gui_start();
                xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
            } else {
                // stop the ajax call
                return false;
            }

        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                $("#offcanvasExample").offcanvas("toggle");
                ResetDomainPage();
                toastr.success(response.message);
            } else {
                toastr.error(response.message);
            }

        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
});


//.........Import csv file into db

$(".cust_import_file123").on("click", function () {
    var form = $("#cusForm_import_d")[0];
    var formData = new FormData(form);
    formData.append('id', $('.cid').val());
    var dsk = 0;
    var mb = 0;
    dropzones.forEach(function (dropzone) {

        var element = dropzone.element;
        var cindex = $(element).get(0).id;
        var paramName = dropzone.options;
        var fiels = dropzone.getAcceptedFiles();
        fiels.forEach(function (file, i) {
            if (cindex && cindex == "desktop_media") {
                formData.append('customer_file', file);
                // formData.append('customer_file['+dsk+']', file);
                dsk++

            } else if (cindex && cindex == "mobile_media") {
                formData.append('customer_file', file);
                // formData.append('customer_file['+mb+']', file);
                mb++;
            }
        });
    });
    $.ajax({
        url: CustomerImportURL,
        type: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                $(".next_imp_btn").removeClass("hide-d");
                $(".cust_import_file").addClass("hide-d");
                toastr.success(response.message);
                ResetDomainPage();
                window.location.reload();
            } else {
                toastr.error(response.message);
            }

        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
});
//.........Import db file

$(".export_cut_btn").on("click", function () {
    // var routeUrl= $(".hidhen_export_val").val(url);
    var routeUrl = $(this).attr('data-url');
    if (routeUrl != '') {
        var win = window.open(routeUrl, '_blank');
        if (win) {
            //Browser has allowed it to be opened
            win.focus();
        } else {
            //Browser has blocked it
            alert('Please allow popups for this website');
        }

    }
});
// expot option
$("body").on("click", ".export_option1", function () {
    var type = $(this).val();
    var url = '';
    if (type == 'pdf') {
        url = ExportPdfURL;
    } else if (type == 'excel') {
        url = ExportExcelURL;
    } else if (type == 'tally') {
        url = '';
    }
    $(".export_cut_btn").attr('data-url', url);

    // if($(this).attr('data-type')){
    //   $("#exportForm_d").attr("action", url);
    //   $(".expt_btn").removeClass("export_cut_btn");
    //  } else{
    //   $(".export_cut_btn").attr('data-url', url);
    //   $(".expt_btn").addClass("export_cut_btn");

    //  }
});

$("body").on("click", ".selected_export1", function () {
    $("#exportPopup").modal("show");
    $(".export_option").attr("data-type", "form_submit")
});
$("body").on("click", ".all_export", function () {
    $("#exportPopup").modal("show");
    $(".export_option").attr("data-type", "all")
});
//..... #checkbox changing
$("body").on("click", "#checkAllCustome1r", function () {
    $('input:checkbox').not(this).prop('checked', this.checked);
    $(".selected_count").html($('.customerChkBox').filter(':checked').length + ' User Selected');
    if ($('.customerChkBox').filter(':checked').length > 0) {
        $(".show_check").addClass('show_option')
        $('.table_card .thead form.mr-3.position-relative').addClass("hide_search");
    } else {
        $(".show_check").removeClass('show_option')
        $('.table_card .thead form.mr-3.position-relative').removeClass("hide_search");
    }
    var index = 0;
    var exportHtml = [];
    $('input[name="customerChkBox"]:checked').each(function () {
        if ($(this).val() != '') {
            exportHtml += ' <input type="hidden" class="hidden_exported_id" name="id[' + index + ']" value="' + $(this).val() + '" />';
            index++;
        }
    });
    $(".hiden_cust_export_val").empty().append(exportHtml);
});

$("body").on("click", ".customerChkBox", function () {
    $(".selected_count").html($('.customerChkBox').filter(':checked').length + ' User Selected');
    if ($('.customerChkBox').filter(':checked').length > 0) {
        $(".show_check").addClass('show_option')
        $('.table_card .thead form.mr-3.position-relative').addClass("hide_search");
    } else {
        $(".show_check").removeClass('show_option')
        $('.table_card .thead form.mr-3.position-relative').removeClass("hide_search");

    }
    var index = 0;
    var exportHtml = [];
    $('input[name="customerChkBox"]:checked').each(function () {
        if ($(this).val() != '') {
            exportHtml += ' <input type="hidden" class="hidden_exported_id" name="id[' + index + ']" value="' + $(this).val() + '" />';
            index++;
        }
    });
    $(".hiden_cust_export_val").empty().append(exportHtml);
});

$("body").on('click', '.selected_user_delete1', function () {
    var form_data = new FormData();
    var idx = 0;
    $('input[name="customerChkBox"]:checked').each(function () {
        if ($(this).val() != '') {
            form_data.append('id[' + idx + ']', $(this).val());
            idx++;
        }
    });
    form_data.append('_token', csrfTokenVal);
    $.ajax({
        // url: CustomerMultipleDeleteURL,
        data: form_data,
        type: 'post',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                $(".show_check").removeClass('show_option')
                $('.table_card .thead form.mr-3.position-relative').removeClass("hide_search");
                toastr.success(response?.message);
                ResetDomainPage();
            } else {
                toastr.error(response?.message);
            }

        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    })
});
$("body").on("click", ".selected_export_option", function () {
    var type = $(this).val();
    if (type == 'pdf') {
        $(".pdf_select_form").removeClass("hide-d");
        $(".excel_select_form").addClass("hide-d");
    } else if (type == 'excel') {
        $(".pdf_select_form").removeClass("hide-d");
        $(".excel_select_form").addClass("hide-d");
    } else if (type == 'tally') {
        $(".pdf_select_form").addClass("hide-d");
        $(".excel_select_form").addClass("hide-d");
    }
    // $(".export_cut_btn").attr('data-url', url);
});
$("body").on('click', '.selected_export_customer1', function () {
    $("#exportPopup").modal("show");
    var index = 0;
    var exportHtml = [];
    $('input[name="customerChkBox"]:checked').each(function () {
        if ($(this).val() != '') {
            exportHtml += ' <input type="hidden" class="hidden_exported_id" name="id[' + index + ']" value="' + $(this).val() + '" />';
            index++;
        }
    });
    $(".hiden_cust_export_val").empty().append(exportHtml);
});
$("body").on('click', '.selected_export_customer1', function () {
    var form_data = new FormData();
    var idx = 0;
    $(".customerChkBox").each(function (i) {
        if ($(this).val() != '') {
            form_data.append('id[' + idx + ']', $(this).val());
            idx++;
        }
    });
    form_data.append('_token', csrfTokenVal);
    $.ajax({
        url: APP_URL + "/api/CustomerExport",
        data: form_data,
        type: 'post',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                toastr.success(response?.message);
                ResetDomainPage();
            } else {
                toastr.error(response?.message);
            }

        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    })
});

$("body").on("click", ".tabel_col_sorting", function () {
    var col = $(this).val();
    if ($(this).is(":checked")) {
        $("." + col).removeClass("hide-d");
    } else {
        console.log("unChecked");
        $("." + col).addClass("hide-d");
    }
    console.log(col);

});