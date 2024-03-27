$("#opencreatenewbusiness").click(function(e) {
    $('#createnewbusiness').addClass('active');
    $('body').toggleClass('ov_hidden');
});

$("a#close_cibsp").click(function(e) {
    $('#createnewbusiness').removeClass('active');
});


function saveNewBusiness() {

    $(".error").remove();
    if ($(".email").val().length < 1) {
        $('.email').after('<span class="error">This field is required</span>');
        return false;
    }
    if ($(".business_name").val().length < 1) {
        $('.business_name').after('<span class="error">This field is required</span>');
        return false;
    }
    if ($(".brand_name").val().length < 1) {
        $('.brand_name').after('<span class="error">This field is required</span>');
        return false;
    }
    if ($(".street_address").val().length < 1) {
        $('.street_address').after('<span class="error">This field is required</span>');
        return false;
    }
    if ($(".pan_no").val().length < 1) {
        $('.pan_no').after('<span class="error">This field is required</span>');
        return false;
    }

    var form = $("#addBusinessForm")[0];
    var formData = new FormData(form);
    formData.append('platform', "Unesync");
    formData.append('guard', "WEB");
    
    $.ajax({
        url: APP_URL + "/api/BusinesAdd",
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
                $('#createnewbusiness').removeClass('active');
                  window.location.reload();
                toastr.success(response.message);
                  block_gui_start();

            } else {
                toastr.error(response.message);
            }

        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
}


// 06AAHCD4406B1Z8 get tax details
$("body").on("focusout", ".get_business_gst_data", function () {
    var gst_number = $('.gst_no').val();

    if (gst_number == '' || gst_number == undefined) {
        $(".gst_no").css("border", "1px solid red");
        return false;
    } else {
        $(".gst_no").css("border", "");

    }
    $(".pan_no").val(gst_number.slice(2, -3));
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

                if(response && response!= '' ){
                $('.business_name').val(response?.lgnm)
                // var bnm = '';
                // if(response?.pradr?.addr?.bnm != undefined && response?.pradr?.addr?.bnm != ''){
                //     bnm = response?.pradr?.addr?.bnm 
                // }
                // var st = '';
                // if(response?.pradr?.addr?.st != undefined && response?.pradr?.addr?.st != ''){
                //     st = response?.pradr?.addr?.st 
                // }
                // var loc = '';
                // if(response?.pradr?.addr?.loc != undefined && response?.pradr?.addr?.loc != ''){
                //     loc = response?.pradr?.addr?.loc 
                // }
                // var dst = '';
                // if(response?.pradr?.addr?.dst != undefined && response?.pradr?.addr?.dst != ''){
                //     dst = response?.pradr?.addr?.dst 
                // }
                var stcd = '';
                if(response?.pradr?.addr?.stcd !== ''){
                    stcd = response?.pradr?.addr?.stcd 
                }
                // var pncd = '';
                // if(response?.pradr?.addr?.pncd != undefined && response?.pradr?.addr?.pncd != ''){
                //     pncd = response?.pradr?.addr?.pncd 
                // }
                // var addesss = bno + ' ' +bnm + ' ' + st + ' ' + loc + ' ' + dst + ' ' + stcd+ ' ' +pncd;
                var addesss = response?.pradr?.addr?.bno + ' ' +response?.pradr?.addr?.bnm + ' ' + response?.pradr?.addr?.st + ' ' + response?.pradr?.addr?.loc + ' ' + response?.pradr?.addr?.dst + ' ' + response?.pradr?.addr?.stcd+ ' ' + response?.pradr?.addr?.pncd
                $('.street_address').val(addesss);
                $('.zip_code').val(response?.pradr?.addr?.pncd);
                var statelist = stateList_d.filter(v => v.name ===  response?.pradr?.addr?.stcd);
                $('.state_id').val(statelist[0]?.id).change();
            }

            } else {
                toastr.error('GST number is not correct.');
            }
        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
});

function readURL(input, previewElement) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        previewElement.style.backgroundImage = "url(" + e.target.result + ")";
        previewElement.style.display = "none";
        previewElement.style.display = "block";
        };
        reader.readAsDataURL(input.files[0]);
    }
    }

    var editIcons = document.querySelectorAll('.editLink');
    var uploadInputs = document.querySelectorAll('.imageUpload');
    var previewElements = document.querySelectorAll('.imagePreview');

    editIcons.forEach(function (icon, index) {
    icon.addEventListener('click', function () {
        uploadInputs[index].click();
    });
    });

    uploadInputs.forEach(function (input, index) {
    input.addEventListener('change', function () {
        readURL(this, previewElements[index]);
    });
});