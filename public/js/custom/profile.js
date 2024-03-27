 $(function () {

$("#profileForm").validate({
        
        //Specify validation rules
        rules: {
            first_name:{
                 required: true,  
                
            },
            last_name:{
                 required: true,
            },
            email:{
                 required: true,
            },
            gst_no:{
                 required: true,
            },
            business_name:{
                 required: true,
            },
            brand_name:{
                 required: true,
            },
           
            pan_card:{
                 required: true,
            },
            profile_photo:{
                 required: true,
            }
        },
        //Specify validation error messages
        messages: {
            first_name: {
               required:"Please enter your first name ",
            },
            last_name: {
               required:"Please enter your last name",
            },
            email: {
               required:"Please enter your email",
            },
            gst_no: {
               required:"Please enter your gst number",
            },
            business_name: {
               required:"Please enter your business",
            },
            brand_name: {
               required:"Please enter your brand name",
            },
            pan_card: {
               required:"Please enter pan card number",
            },
            profile_photo: {
               required:"Please upload your profile pic",
            }
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function (form) {
            $("#save_btn").prop("disabled", true);
            var form = $("#profileForm")[0];
            var formData = new FormData(form);
            formData.append('id',  currentUser.id);
           $.ajax({
                url: APP_URL + "/api/profileUpdate",
                data: formData,
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function (xhr) {
                    block_gui_start();
                    xhr.setRequestHeader('Authorization','Bearer ' + tokenString );
                },
                success: function (response) {
                        block_gui_end();
                        $("#save_btn").prop("disabled", false);
                        if (response.status == true) {
                            toastr.success(response?.message)
                            localStorage.setItem('user', JSON.stringify(response?.data));
                            $("#cprofilePopup").modal("hide")
                        } else {
                            toastr.error(response?.message)
                        }
                    }, error: function (response) {
                        block_gui_end();
                        $("#save_btn").prop("disabled", false);
                        toastr.error(response?.message);
                    }
            });
        }
    });
});


$(document).ready(function(){
    $('#fname').val(currentUser?.name);
    $('#lname').val(currentUser?.last_name);
    $('#email').val(currentUser?.email);
    $('#gst_number').val(currentUser?.gst_no);
    $('#business_name').val(currentUser?.business_name);
    $('#brand_name').val(currentUser?.brand_name);
    $('#address').val(currentUser?.address);
    $('#list7').val(currentUser?.gstin);
    $('#list8').val(currentUser?.gstin);
    $('#pan_card').val(currentUser?.pan_card);
    $('#profilestatedropdown').val(currentUser?.state_id);
});

// 06AAHCD4406B1Z8
$("body").on("click", ".get_gst_data", function(){
    var gst_number =  $('#gst_number').val(); 
    if (gst_number == '' || gst_number == undefined) {
        $("#gst_number").css("border", "1px solid red");
        return false;
    } else {
        $("#gst_number").css("border", "");

    }
      $("#pan_card").val(gst_number.slice(2, -3));
        $.ajax({
            url: APP_URL + "/api/getGstDetails/"+gst_number,
            type: "GET",
            // data: {'gst_no': gst_number, '_token':csrfTokenVal},
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function (xhr) {
                block_gui_start();
                xhr.setRequestHeader('Authorization','Bearer ' + tokenString );

            },
            success: function (response) {
                    block_gui_end();
                    if (response.status == true) {
                        response = response.data
                        if(response.status !=0){
                            $('#business_name').val(response?.lgnm)
                            // $('#profilecountrydropdown').val(response?.gstin).change();
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
                            $('#address').val(addesss);
                            var statelist = state_list.filter(v => v.name === stcd);
                            $('.sv_billing_state').val(statelist[0]?.id);
                            $('.billing_zip_code').val(pncd);
                       }
                      
                    }else{
                        toastr.warning('GST is not correct');
                    }
                    $(".step-tab").removeClass("active");
                    $("#step-03").addClass("active");
                }, error: function (response) {
                    block_gui_end();
                    console.log("server side error");
                }
        });
});
$("body").on("click", ".prof_first_btn", function(){
    if ($("#fname").val() == '' || $("#fname").val() == undefined) {
        $("#fname").css("border", "1px solid red");
        return false;
    } else {
        $("#fname").css("border", "");
    }
    // #..
    if ($("#lname").val() == '' || $("#lname").val() == undefined) {
        $("#lname").css("border", "1px solid red");
        return false;
    } else {
        $("#lname").css("border", "");
    }
    // ..
    if ($("#email").val() == '' || $("#email").val() == undefined) {
        $("#email").css("border", "1px solid red");
        return false;
    } else {
        $("#email").css("border", "");
    }
    $(".step-tab").removeClass("active");
    $("#step-02").addClass("active");
})

$("body").on("click", ".sec_last_btn", function(){
    if ($("#business_name").val() == '' || $("#business_name").val() == undefined) {
        $("#business_name").css("border", "1px solid red");
        return false;
    } else {
        $("#business_name").css("border", "");
    }
    // #..
    // if ($("#brand_name").val() == '' || $("#brand_name").val() == undefined) {
    //     $("#brand_name").css("border", "1px solid red");
    //     return false;
    // } else {
    //     $("#brand_name").css("border", "");
    // }
    // ..
    if ($("#address").val() == '' || $("#address").val() == undefined) {
        $("#address").css("border", "1px solid red");
        return false;
    } else {
        $("#address").css("border", "");
    }
    if ($("#profilecountrydropdown").val() == '' || $("#profilecountrydropdown").val() == undefined) {
        $("#profilecountrydropdown").css("border", "1px solid red");
        return false;
    } else {
        $("#profilecountrydropdown").css("border", "");
    }
    if ($("#profilestatedropdown").val() == '' || $("#profilestatedropdown").val() == undefined) {
        $("#profilestatedropdown").css("border", "1px solid red");
        return false;
    } else {
        $("#profilestatedropdown").css("border", "");
    }
    
    if ($("#pan_card").val() == '' || $("#pan_card").val() == undefined) {
        $("#pan_card").css("border", "1px solid red");
        return false;
    } else {
        $("#pan_card").css("border", "");
    }
    // ...
    $(".step-tab").removeClass("active");
    $("#step-04").addClass("active");
})