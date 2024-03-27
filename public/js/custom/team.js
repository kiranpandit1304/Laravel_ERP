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
    $("#category_status").val('').change();
    $(".reset_bt").addClass("hide-d");

    var url = window.location.href;
    var url = updateQueryStringParameter(url, "page", 1);
    var data = make_final_parameters_object(url);
    data = makeDataObject(data);
    getDomainPage(url, data);
    window.history.pushState("", "", url);
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
    $(".reset_bt").removeClass("hide-d");
}

function getDomainPage(url, data) {
    block_gui_start();
    $.ajax({
        data: data,
        url: url,
        dataType: 'json',
        success: function (data) {
            block_gui_end();
            $('#page_listing').html(data.content);
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


    if ($(".top_bar_filter").val())
        data['status'] = $(".top_bar_filter").val();
    else
        data['status'] = "";

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

function copyText() {
    $(".copy_link").addClass("hide-d");
    $(".link_copied").removeClass("hide-d");
    // Get the text field
    var copyText = document.getElementById("linkcopborad");

    // Select the text field
    copyText.select();
    copyText.setSelectionRange(0, 99999); // For mobile devices

    // Copy the text inside the text field
    navigator.clipboard.writeText(copyText.value);
}

function copyTableText(event) {
    $(".copy_link").addClass("hide-d");
    $(".link_copied").removeClass("hide-d");
    var keyId = $(event).attr("data-id")
    // Get the text field
    var copyText = document.getElementById("linkcopborad_" + keyId);

    // Select the text field
    copyText.select();
    copyText.setSelectionRange(0, 99999); // For mobile devices

    // Copy the text inside the text field
    navigator.clipboard.writeText(copyText.value);
    toastr.success("Link copied");
}

$("body").on("click", ".add_another_btn", function () {
    resetcreateFormFields();
});

function resetcreateFormFields() {
    $(".save_btn").removeClass("hide-d");
    $(".add_another_btn").addClass("hide-d");
    $(".invite_link").removeClass("show");
    $(".permission_id").val(' ').trigger('change');
    $(".member_name").val(' ');
    $(".email").val(' ');
}

$(document).on("click", "#addDomain", function () {
    $("#addDominForm")[0].reset();
    $("#cid").val('');
    $("#addNewDomainModal").modal("show");
});

$("body").on("click", '.save_btn', function () {

    var form_data = new FormData();
    form_data.append('email', $(".email").val());
    form_data.append('name', $(".member_name").val());

    var limit = $(".permission_id").length;
    var index = 0;
    for (var j = 0; j <= limit; j++) {
        if ($(".permission_id") && $(".permission_id")[j]?.value != '' && $(".permission_id")[j]?.value != undefined) {
            form_data.append('module_id[' + index + ']', $(".moduleList")[j]?.value);
            form_data.append('permission_id[' + index + ']', $(".permission_id")[j]?.value);
            index++;
        }
    }
    form_data.append('_token', csrfTokenVal);
    $.ajax({
        url: APP_URL + "/api/send_invite",
        data: form_data,
        type: "post",
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

        },
        success: function (response) {
            block_gui_end();
            $("#save_btn").prop("disabled", false);
            if (response.status == true) {
                // $(".email").val('');
                $('.invite_link').addClass('show');
                toastr.success(response?.message)
                $("#linkcopborad").val(response?.link);
                $(".save_btn").addClass("hide-d");
                $(".add_another_btn").removeClass("hide-d");
                $(".invite_link").addClass("show");
                ResetDomainPage();
                setTimeout(function () {
                    $(".link_copied").addClass("hide-d");
                }, 5000);
            } else {
                toastr.error(response?.message)
            }
        },
        error: function (response) {
            block_gui_end();
            $("#save_btn").prop("disabled", false);
            toastr.error(response?.message)
        }
    });
});

function editTeamMember(event) {
    var uid = $(event).attr("data-id");
    $.ajax({
        url: APP_URL + "/api/teamMemberUserDetail/" + uid,
        type: 'get',
        data: '',
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

        },
        success: function (resp) {
            block_gui_end();

            if (resp.status == true) {
            }
            $(".team_user_name").text(resp?.data?.name);
            $(".team_user_email").text(resp?.data?.email);
            $(".team_user_phone").text(resp?.data?.mobile_no);
            $(".edit_user_id").val(resp?.data?.id);

            var moduleHtml = [];
            for (var j = 0; j < modules.length; j++) {
                var selected_permision = '';
                var is_edit_pemission = '';
                var is_view_pemission = '';
                let user_permisson = resp?.permisson.filter((item) => item.module_id === modules[j]?.id);
                selected_permision = user_permisson[0]?.permission_id;
                if (selected_permision == 1) {
                    is_edit_pemission = 'selected'
                } else if (selected_permision == 2) {
                    is_view_pemission = 'selected'
                }
                moduleHtml += '<li>';
                moduleHtml += '                  <h5><span class="bg_green squre_icon"><iconify-icon icon="material-symbols:account-balance-wallet-outline"></iconify-icon></span>' + modules[j]?.name + '</h5>';
                moduleHtml += '                  <div class="selec_s">';
                moduleHtml += '                      <select class="form-select edit_permission_id"  id="editlist1' + j + '" name="module_list[]" aria-label="Default select example">';
                moduleHtml += '                          <option value="" >Give Access</option>';
                moduleHtml += '                          <option value="1" ' + is_edit_pemission + ' >Edit and View</option>';
                moduleHtml += '                          <option value="2" ' + is_view_pemission + ' >Only View</option>';
                moduleHtml += '                      </select>';
                moduleHtml += '                  </div>';
                moduleHtml += '              </li>';
                moduleHtml += '              <input type="hidden" class="edit_moduleList" value="' + modules[j]?.id + '" />';
            }
            $(".module_edit_list").empty().append(moduleHtml);
            $("#editItem").addClass("active");
        },
        error: function (resp) {
            block_gui_end();
            console.log("server side error");
        },
    });


}

function updateTeamPermission() {

    var form_data = new FormData();
    var limit = $(".edit_permission_id").length;
    var indx = 0;
    for (var j = 0; j <= limit; j++) {
        if ($(".edit_permission_id") && $(".edit_permission_id")[j]?.value != '' && $(".edit_permission_id")[j]?.value != undefined) {
            form_data.append('module_id[' + indx + ']', $(".edit_moduleList")[j]?.value);
            form_data.append('permission_id[' + indx + ']', $(".edit_permission_id")[j]?.value);
            indx++;
        }
    }

    form_data.append('user_id', $(".edit_user_id").val());
    $.ajax({
        url: APP_URL + "/api/UserPermissonEdit",
        data: form_data,
        type: "post",
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
                $("#editItem").removeClass("active");
                toastr.success(response?.message)
            } else {
                toastr.error(response?.message)
            }
        },
        error: function (response) {
            block_gui_end();
            toastr.error(response?.message)
        }
    });
}

$("body").on("click", ".offcanvasTeamEditView", function() {

    var id = $(this).attr('data-id');
    var uRl = APP_URL + '/api/sendInviteShow/' + id;

    $.ajax({
        url: uRl,
        type: "GET",
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
                $(".team_headr_name").text(response?.data?.name);
                $(".team_member_name").val(response?.data?.name);
                $(".team_member_email").val(response?.data?.email);
                $(".team_member_status").val(response?.data?.invitee_status);
                $(".tid").val(response?.data?.id);
                $("#offcanvasExample").offcanvas("show");

            } else {
                toastr.error(response.message);
            }

        },
        error: function(response) {
            block_gui_end();
            console.log("server side error");
        }
    });
});

// Export and delete

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
    url: APP_URL + '/api/sendInviteMuilipleDelete/',
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


$("body").on("click", ".delte_cutomer_btn", function () {
var mid = $(".tid").val();
$.ajax({
    url:  APP_URL + '/api/sendInviteDelete/'+mid,
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


function TrashCat(event) {

    var id = $(event).attr('data-id');
    if (id) {
        var res = confirm("Are you sure you want to delete ?");
        if (res) {
            $.ajax({
                url: APP_URL + "/admin/delete-checked-dpts",
                data: { 'id': id, '_token': csrfTokenVal },
                dataType: 'json',
                type: 'post',
                beforeSend: function (xhr) {
                    block_gui_start();
                    xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

                },
                success: function (response) {
                    block_gui_end();
                    if (response.status == true) {
                        $("#success_msg").html(response.message);
                        $('#success_message_modal').modal("show");
                        setTimeout(function () {
                            $("#success_msg").html("");
                            $('#success_message_modal').modal("hide");
                            ResetDomainPage();
                            window.location.reload();
                        }, 2000);
                    } else {
                        $("#error_msg").html(response.message);
                        $('#error_message_modal').modal("show");
                        setTimeout(function () {
                            $("#error_msg").html("");
                            $('#error_message_modal').modal("hide");
                        }, 2000);
                    }
                }, error: function (response) {
                    block_gui_end();
                    console.log("server side error");
                }
            })
        }
    }
}


