
$(function () {

$("#loginForm").validate({
        
        //Specify validation rules
        rules: {
            mobile_no:{
                 required: true,  
                 minlength: 10,
                 maxlength: 10,
            },
            password:{
                 required: true,
            }
        },
        messages: {
            mobile_no: {
               required:"Please enter a valid phone number ",
               minlength: "Please enter a valid phone number",
               maxlength: "Please enter a valid phone number.",
            },
            password: {
               required:"Please enter your pasword",
            }
        },
        
        submitHandler: function (form) {
    // $("#loginForm").on("submit", function () {
            $("#save_btn").prop("disabled", true);
            var form_data = new FormData();
            form_data.append('mobile_no', '91'+$('#phone').val());
            form_data.append('password', $('#password-field').val());
            form_data.append('_token', csrfTokenVal);
           $.ajax({
                url: APP_URL + "/api/login",
                data: form_data,
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    block_gui_start();
                },
                success: function (response) {
                        block_gui_end();
                        $("#save_btn").prop("disabled", false);
                        if (response.status == true) {
                            toastr.success(response?.message)
                            localStorage.setItem('user', JSON.stringify(response?.user));
                            localStorage.setItem('token', response?.token);
                            var uid= response?.user_id;
                            localStorage.setItem('encypt_id',uid);
                            window.location.href = APP_URL + '/en/dashboard/'+uid;
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


$(function () {
    $("#loginNumberForm").validate({
        //Specify validation rules
        rules: {
            mobile_no1: {
                required: true,
                 minlength: 10,
                 maxlength: 10,
            },

        },
        //Specify validation error messages
        messages: {
            mobile_no1: {
                required: "Please enter a valid number ",
                minlength: "Please enter a valid phone number",
                maxlength: "Please enter a valid phone number.",
            }
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function (form) {
            $("#save_btn").prop("disabled", true);
            var form_data = new FormData();
            var user_no =  +'91'+$('#phone').val();
            form_data.append('mobile_no',user_no);
            form_data.append('_token', csrfTokenVal);
            $.ajax({
                url: APP_URL + "/api/login_via_otp_send",
                data: form_data,
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    block_gui_start();
                },
                success: function (response) {
                    block_gui_end();
                    $("#save_btn").prop("disabled", false);
                    if (response.status == true) {
                        toastr.info("OTP is sent to your number please check");
                        localStorage.setItem('userno', user_no);
                        window.location.href = APP_URL + '/en/login/otp';
                    } else {
                        toastr.error(response?.message)
                    }
                }, error: function (response) {
                    block_gui_end();
                    $("#save_btn").prop("disabled", false);
                    toastr.error(response?.responseJSON?.message)
                }
            });
        }
    });
});


$(function () {
    $("#verifyloginOtp").validate({
        //Specify validation rules
        rules: {
            mobile_no1: {
                required: true,
                 minlength: 10,
                 maxlength: 10,
            },

        },
        //Specify validation error messages
        messages: {
            mobile_no1: {
                required: "Please enter a valid number ",
                minlength: "Please enter a valid phone number",
                maxlength: "Please enter a valid phone number.",
            }
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function (form) {
            $("#verify").prop("disabled", true);
            var form_data = new FormData();
            var user_no = localStorage.getItem('userno')
            var opt = $('#digit-1').val() + $('#digit-2').val() + $('#digit-3').val() + $('#digit-4').val()
            form_data.append('otp', opt);
            form_data.append('mobile_no',user_no);
            // form_data.append('_token', csrfTokenVal);
            $.ajax({
                url: APP_URL + "/api/login_via_otp",
                data: form_data,
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $(".button-verify").addClass('animate');

                },
                success: function (response) {
                    block_gui_end();
                    $("#verify").prop("disabled", false);
                    $(".button-verify").removeClass('error');
                    $(".button-verify").removeClass('success');
                    if (response.status == true) {
                        // toastr.info("OTP is sent to your number please check");
                        localStorage.setItem('user_no', user_no);
                        localStorage.setItem('user', JSON.stringify(response?.user));
                        localStorage.setItem('token', response?.token);
                        var uid= response?.user_id;
                        localStorage.setItem('encypt_id',uid);
                        $(".button-verify").addClass('success');
                        toastr.success(response?.message)
                        setTimeout(function () {
                            block_gui_start();
                            window.location.href = APP_URL + '/en/dashboard/'+uid;

                        }, 3000);
                    } else {
                        $(".button-verify").addClass('error');
                        setTimeout(function () {
                            $(".button-verify").removeClass('animate');
                            $(".button-verify").removeClass('error');
                        }, 3000);
                        toastr.error(response?.message)
                    }
                }, error: function (response) {
                    block_gui_end();
                    $("#save_btn").prop("disabled", false);
                    toastr.error(response?.responseJSON?.message)
                }
            });
        }
    });
});