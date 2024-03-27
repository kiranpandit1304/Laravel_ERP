$(".js-example-placeholder-single-currency").select2({
    placeholder: "Select Customer",
});

$(document).on("click", ".showOffcanvasFilter", function(e) {
    $("#offcanvasFilter").offcanvas("toggle");

});
$(document).on("click", ".current_inv_tab", function(e) {
    var mode_val = $(this).attr("data-id");
    $("#current_inv_mode").val(mode_val);
    ResetDomainPage();
});
// function copyToClipboard(event) {
$(document).on("click", ".copyToClipboard", function() {
    var id = $(this).attr("title");

    // Get the text field
    var copyText = document.getElementById("linkInvloicecopborad_" + id);
    // Select the text field
    copyText.select();
    copyText.setSelectionRange(0, 99999); // For mobile devices

    // Copy the text inside the text field
    navigator.clipboard.writeText(copyText.value);
    toastr.success("Link copied");
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
    $("#search_field_filter").val('');
    $("#payment_status").val('');
    $("#filterinv_status").val('');
    $("#filter_inv_client_id").val('').change();
    $("#filter_inv_start_date").val('');
    $("#filter_inv_end_date").val('');
    // $("#current_inv_mode").val('0');
    $(".reset_bt").addClass("hide-d")
    
    var url = window.location.href;
    var url = updateQueryStringParameter(url, "page", 1);
    var data = make_final_parameters_object(url);
    data = makeDataObject(data);
    getDomainPage(url, data);
    url = url;
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

$(document).on('keypress', "#search_field_filter", function (e) {
    if (e.which == 13) {
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
            $('#page_listing').html(data.content);
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

    if ($("#filterinv_status").val())
        data['payment_status'] = $("#filterinv_status").val();
    else
        data['payment_status'] = "";

    if ($("#filter_inv_client_id").val())
        data['client_id'] = $("#filter_inv_client_id").val();
    else
        data['client_id'] = "";

        if ($("#filter_inv_start_date").val())
        data['start_date'] = $("#filter_inv_start_date").val();
    else
        data['start_date'] = "";

        if ($("#filter_inv_end_date").val())
        data['end_date'] = $("#filter_inv_end_date").val();
    else
        data['end_date'] = "";

        if ($("#current_inv_mode").val())
        data['is_deleted'] = $("#current_inv_mode").val();
    else
        data['is_deleted'] = "";

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

$("body").on("click", ".duplicate_inv", function () {
    var inv_id = $(this).attr("title")
    var formData = new FormData();
    formData.append('invoice_id', inv_id);

    $.ajax({
        url: APP_URL + '/api/SaleInvoiceDuplicate',
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
                window.location.href = APP_URL + '/en/invoice/step1/' + enyptID + '/' + response?.invoice_id;
            }
        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
});

// ...
$("body").on("click", ".showEditConfirmAlert", function(){
    if (confirm("Are you sure?")) {
          return true;
    } else {
        // stop the ajax call
        return false;
    }
});

//........... Delete invoice........... 
$("body").on("click", ".delte_invoice_btn", function () {
    var inv_id = $(this).attr("title");
    var inv_page = $(this).attr("data-page");
    $.ajax({
        url: APP_URL + '/api/SaleInvoiceDelete/' + inv_id,
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
                if (inv_page == 'step3') {
                    window.location.href = APP_URL + '/en/invoices/' + enyptID;

                } else {
                    ResetDomainPage();
                }

            } else {
                toastr.error(response.message);
            }

        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
});
// ..

//........... Cancel invoice........... 
$("body").on("click", ".cancel_invoice_btn", function () {
    var inv_id = $(this).attr("title");
    var inv_page = $(this).attr("data-page");
    $.ajax({
        url: APP_URL + '/api/SaleInvoiceCancel/' + inv_id,
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
                if (inv_page == 'step3') {
                    window.location.reload();
                } else {
                    ResetDomainPage();
                }
            } else {
                toastr.error(response.message);
            }

        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
});

//........... Remove invoice payment........... 
$("body").on("click", ".remove_invoice_payment_btn", function () {
    var inv_id = $(this).attr("title");
    var inv_page = $(this).attr("data-page");
    $.ajax({
        url: APP_URL + '/api/SaleInvoiceRemovePayment/' + inv_id,
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
                if (inv_page == 'step3') {
                    window.location.reload();
                } else {
                    ResetDomainPage();
                }

            } else {
                toastr.error(response.message);
            }

        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
});


//....................Multi delte and export part
//..... #checkbox changing


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

$("body").on('click', '.selected_user_delete', function () {
    var form_data = new FormData();
    var idx = 0;
    // $(".customerChkBox").each(function (i) {
    $('input[name="customerChkBox"]:checked').each(function () {
        if ($(this).val() != '') {
            form_data.append('id[' + idx + ']', $(this).val());
            idx++;
        }
    });
    form_data.append('_token', csrfTokenVal);
    $.ajax({
        url: APP_URL + '/api/SaleInvoiceMuilipleDelete',
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

// ...........

$("body").on("click", ".recover_inv", function () {
    var inv_id = $(this).attr("data-id");
    $.ajax({
        url: APP_URL + '/api/SaleInvoiceRecover/' + inv_id,
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
// ..............ended


// / expot option
$("body").on("click", ".export_cut_btn", function () {
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

$("body").on("click", ".export_option", function () {
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
});

$("body").on("click", ".selected_export", function () {
    $("#exportPopup").modal("show");
    $(".export_option").attr("data-type", "form_submit")
});
$("body").on("click", ".all_export", function () {
    $("#exportPopup").modal("show");
    $(".export_option").attr("data-type", "all")
});
//..... #checkbox changing
$("body").on("click", "#checkAllCustomer", function () {
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

$("body").on("click", ".shareInvoiceOnMail", function(){
    var inv_id=  $(this).attr("title");
    var share_type= 'email';
     shareInvoice(share_type, inv_id);
});

$("body").on("click", ".shareInvoiceOnWhatsApp", function(){
    var inv_id=  $(this).attr("title");
    var share_type= 'whatsup';
     shareInvoice(share_type, inv_id);
});

function shareInvoice(share_type, inv_id) {
    
    var formData = new FormData();
    formData.append('mesg_type', share_type);
    formData.append('invoice_id', inv_id);

    $.ajax({
        url: APP_URL + '/api/SaleInvoiceShareAdd',
        data: formData,
        type: 'post',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function(xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
        },
        success: function(response) {
            block_gui_end();
            if (response.status == true) {
                toastr.success(response?.message);
                if (share_type == 'whatsup') {
                    var whats_text = response?.whats_text;
                    var customer_number = response?.customeer_number;
                    window.open(
                        'https://wa.me/' + customer_number + '/?text=' + whats_text,
                        '_blank' // <- This is what makes it open in a new window.
                    );
                }
            } else {
                toastr.error(response?.message)
            }
        },
        error: function(response) {
            block_gui_end();
            console.log("server side error");
        }
    })
}
