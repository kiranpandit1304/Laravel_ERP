
$(function () {

    $("#registerForm").validate({
        //Specify validation rules
        rules: {
            mobile_no: {
                required: true,
                minlength: 10,
                maxlength: 10,
            },

        },
        //Specify validation error messages
        messages: {
            mobile_no: {
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
            form_data.append('mobile_no', +'91' + $('#phone').val());
            form_data.append('invitee_id', $('#invitee_id').val());
            form_data.append('platform', "Unesync");
            form_data.append('guard', "WEB");
            form_data.append('_token', csrfTokenVal);
            $.ajax({
                url: APP_URL + "/api/register",
                data: form_data,
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    block_gui_start();
                },
                success: function (response) {
                    //    response = jQuery.parseJSON(response);
                    block_gui_end();
                    console.log("response ", response)
                    $("#save_btn").prop("disabled", false);
                    if (response.status == true) {
                        toastr.info("OTP is sent to your number please check");
                        localStorage.setItem('userno', response.mobile_no);
                        window.location.href = APP_URL + '/en/signup/otp';
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

// #............Resend OTP
$("body").on("click", '#resendOtpBtn', function () {
    $("#save_btn").prop("disabled", true);
    if (localStorage.getItem('userno') != '' && localStorage.getItem('userno') != undefined) {
        var form_data = new FormData();
        form_data.append('mobile_no', localStorage.getItem('userno'));
        form_data.append('_token', csrfTokenVal);
        $.ajax({
            url: APP_URL + "/api/resend_otp",
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
                    toastr.info("OTP is resent to your number please check");
                } else {
                    toastr.error(response?.message)
                }
            }, error: function (response) {
                block_gui_end();
                $("#save_btn").prop("disabled", false);
                toastr.error(response?.responseJSON?.message)
            }
        });
    } else {
        toastr.error("Number is not valid.");
    }
});

// /.........
$(function () {

    $("#verifyForm").validate({
        //Specify validation rules
        rules: {
            digit1: {
                required: true,
            },
            digit2: {
                required: true,
            },
            digit3: {
                required: true,
            },
            digit4: {
                required: true,
            },
        },
        //Specify validation error messages
        messages: {
            digit1: {
                required: "*",
            },
            digit2: {
                required: "*",
            },
            digit3: {
                required: "*",
            },
            digit4: {
                required: "*",
            },
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function (form) {
            $("#verify").prop("disabled", true);

            var form_data = new FormData();
            var opt = $('#digit-1').val() + $('#digit-2').val() + $('#digit-3').val() + $('#digit-4').val()
            form_data.append('otp', opt);
            form_data.append('mobile_no', localStorage.getItem('userno'));
            form_data.append('_token', csrfTokenVal);
            $.ajax({
                url: APP_URL + "/api/verify_otp",
                data: form_data,
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    // block_gui_start();
                    $(".button-verify").addClass('animate');
                },
                success: function (response) {
                    block_gui_end();
                    $("#verify").prop("disabled", false);
                    $(".button-verify").removeClass('error');
                    $(".button-verify").removeClass('success');
                    if (response.status == true) {
                        toastr.success(response?.message)
                        $("#verify").prop("disabled", false);
                        $(".button-verify").addClass('success');
                        toastr.success(response?.message)
                        setTimeout(function () {
                            block_gui_start();
                            window.location.href = APP_URL + '/en/signup/password';

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
                    $("#verify").prop("disabled", false);
                    toastr.error(response?.message)
                }
            });
        }
    });
});


$(function () {

    $("#registerpasswordForm").validate({
        //Specify validation rules
        rules: {
            password: {
                required: true,
            },

        },
        //Specify validation error messages
        messages: {
            password: {
                required: "Please enter your password ",
            }
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function (form) {
            $("#save_btn").prop("disabled", true);
            var form_data = new FormData();
            form_data.append('mobile_no', localStorage.getItem('userno'));
            form_data.append('password', $('#password-field').val());
            form_data.append('_token', csrfTokenVal);
            $.ajax({
                url: APP_URL + "/api/update_password",
                data: form_data,
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    block_gui_start();
                },
                success: function (response) {
                    //    response = jQuery.parseJSON(response);
                    block_gui_end();
                    $("#save_btn").prop("disabled", false);
                    if (response.status == true) {
                        toastr.success(response?.message)
                        localStorage.setItem('user', JSON.stringify(response?.user));
                        localStorage.setItem('token', response?.token);
                        var uid = response?.user_id;
                        window.location.href = APP_URL + '/en/dashboard/' + uid;
                    } else {
                        toastr.error(response?.message)
                    }
                }, error: function (response) {
                    block_gui_end();
                    $("#save_btn").prop("disabled", false);
                    toastr.error(response?.message)
                }
            });
        }
    });
});


//#.........RESER PASSWORD SECTION/
$(function () {

    $("#fogotPassForm").validate({

        //Specify validation rules
        rules: {
            phone: {
                required: true,
                minlength: 10,
                maxlength: 10,
            },

        },
        //Specify validation error messages
        messages: {
            phone: {
                required: "Please enter a valid phone number ",
                minlength: "Please enter a valid phone number",
                maxlength: "Please enter a valid phone number.",
            }
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function (form) {
            $("#save_btn").prop("disabled", true);
            var user_number = +'91' + $('#phone').val();
            var form_data = new FormData();
            form_data.append('mobile_no', user_number);
            form_data.append('_token', csrfTokenVal);
            $.ajax({
                url: APP_URL + "/api/reset_password_send_otp",
                data: form_data,
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    block_gui_start();
                },
                success: function (response) {
                    //    response = jQuery.parseJSON(response);
                    block_gui_end();
                    console.log("response ", response)
                    $("#save_btn").prop("disabled", false);
                    if (response.status == true) {
                        localStorage.setItem('userno', user_number);
                        toastr.info("OTP is sent to your number please check");
                        window.location.href = APP_URL + '/en/password/otp';
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

    $("#resetPassForm").validate({
        //Specify validation rules
        rules: {
            digit1: {
                required: true,
            },
            digit2: {
                required: true,
            },
            digit3: {
                required: true,
            },
            digit4: {
                required: true,
            },
        },
        //Specify validation error messages
        messages: {
            digit1: {
                required: "*",
            },
            digit2: {
                required: "*",
            },
            digit3: {
                required: "*",
            },
            digit4: {
                required: "*",
            },
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function (form) {
            $("#save_btn").prop("disabled", true);
            var form_data = new FormData();
            var opt = $('#digit-1').val() + $('#digit-2').val() + $('#digit-3').val() + $('#digit-4').val()
            form_data.append('otp', opt);
            form_data.append('mobile_no', localStorage.getItem('userno'));
            form_data.append('_token', csrfTokenVal);
            $.ajax({
                url: APP_URL + "/api/verify_otp",
                data: form_data,
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    // block_gui_start();
                    $(".button-verify").addClass('animate');
                },
                success: function (response) {
                    $(".button-verify").removeClass('error');
                    $(".button-verify").removeClass('success');
                    block_gui_end();
                    if (response.status == true) {
                        $("#verify").prop("disabled", false);
                        $(".button-verify").addClass('success');
                        toastr.success(response?.message)
                        setTimeout(function () {
                            block_gui_start();
                            window.location.href = APP_URL + '/en/password/resets';

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
                    toastr.error(response?.message)
                }
            });
        }
    });
});