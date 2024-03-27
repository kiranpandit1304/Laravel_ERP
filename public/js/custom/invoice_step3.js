$("body").on("click", ".show_scaner_btn", function () {
   
    $.ajax({
        url: APP_URL + '/api/SaleInvoiceBankUpiList',
        type: 'get',
        beforeSend: function (xhr) {
                block_gui_start();
                xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
           
        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                var baankDetails = response?.data;
                loadAllUPIDetials(baankDetails);
                $("#updateUPIdetail").modal('show');
                $(".upi_footer").removeClass("hide-d");
                $(".save_upi_btn").removeClass("hide-d");
                $(".save_upi_btn").attr("onclick", "generateQRCode(this)");
        }
        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
     });


});

$("body").on("click", ".show_bank_detail_btn", function () {
    $.ajax({
        url: APP_URL + '/api/SaleInvoiceBankDetailsList',
        type: 'get',
        beforeSend: function (xhr) {
                block_gui_start();
                xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
           
        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                var baankDetails = response?.data;
                var btn_class = 'activate_bank_account_btn';
                loadAllBankDetial(baankDetails, btn_class);
                 $("#updateBankdetail").modal('show');

        }
        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
     });
    // $("#updateBankdetail").modal('show');
});


function loadAllBankDetial(baankDetails, btn_class){
    var deHtml = []; 
    for(var i=0; i<=baankDetails.length; i++){
        if(baankDetails[i]?.account_no != undefined && baankDetails[i]?.bank_name != undefined){
            deHtml+='<div class="upi_id bank_rwo_'+baankDetails[i]?.id+'">';
            deHtml+='<div class="ali_bank">';
            deHtml+='<span>';
            deHtml+='   <h6><span><img src="assets/images/SBI-logo.svg" alt=""></span>'+baankDetails[i]?.bank_name+' <a  href="javascript:void(0)" onclick="showBankEditForm(this)" data-id="'+baankDetails[i]?.id+'"><iconify-icon icon="material-symbols:edit-rounded"></iconify-icon></a></h6>';
            deHtml+='    <h5>'+baankDetails[i]?.account_holder_name+'</h5>';
            deHtml+=' </span>';
            deHtml+='  <ul>';
            deHtml+='      <li><span>Account No:</span>'+baankDetails[i]?.account_no+'</li>';
            deHtml+='      <li><span>IFSC:</span>'+baankDetails[i]?.ifsc+'</li>';
            deHtml+='       <li><span>IBAN:</span>'+baankDetails[i]?.iban+'</li>';
            deHtml+='   </ul>';
            deHtml+=' </div>';
            deHtml+=' <div class="gaction">';
            deHtml+='      <a href="javascript:void(0)" onclick="removeBankDetailRecord(this)" data-id="'+baankDetails[i]?.id+'" class="removeUpi">Remove</a>';
            deHtml+='  </div>';
            deHtml+=' <div class="gaction toggle_action inp_show_invoice_type">';
            deHtml+='    <p>Show in invoice?</p>';
            deHtml+='    <label class="switch">';
            if(baankDetails[i]?.is_show==1){
            deHtml+='       <input type="checkbox" class="'+btn_class+'" checked  value="'+baankDetails[i]?.id+'">';
            }else{
            deHtml+='       <input type="checkbox" class="'+btn_class+'"  value="'+baankDetails[i]?.id+'">';

            }
            deHtml+='      <span class="slider"></span>';
            deHtml+='  </label>';
            deHtml+='  </div>';
            deHtml+='  </div>';
     }
    }
    $(".bank_detail_body").empty().append(deHtml);
}
$("body").on("click", ".show_add_new_bank_btn", function () {
    $(".bank_detal_db_id").val('');
    $('.inp_ifsc').val('');
    $('.inp_account_no').val('');
    $('.inp_bank_name').val('');
    $('.inp_iban').val('');
    $('.swift_code').val('');
    $('.inp_account_holder_name').val('');
    $(".save_bank_details").attr("onclick", "saveNewBankDetail(this)");
    $('.inp_phone_number').val('');
    
    $(".bank_cutom_dib").remove();
    $(".bankdetails").addClass("show"); 
    
    $(".save_bank_details").removeClass("hide-d");
    $(".save_bankdetails").addClass("show");
    $("#addnewbankaccount").modal('show');
});



$("body").on("click", ".activate_bank_account_btn", function () {
    $(".activate_bank_account_btn").not(this).prop("checked", false);
    var current_val = $(this).is(":checked") ? true : false;
    $(this).prop("checked", current_val);
    var selVal = $(this).val();
    $.ajax({
        url: APP_URL + '/api/SaleInvoiceBankDetailsActive',
        data:{'id':selVal, 'is_show':current_val},
        type: 'post',
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                if(response?.data != '' && response?.data!=null)
                  appendBankActiveDetail(response?.data);
             var length =  $('.activate_bank_account_btn').filter(':checked').length
                console.log('lenght',length)
                  if(length == 1){
                    alert("here")
                    $(".is_bank_detail_show").prop("checked", true);
                }else{
                   $(".is_bank_detail_show").prop("checked", false);
   
                }
            }
        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });

});

function saveNewBankDetail(event) {
    var formData = new FormData();
    
    formData.append('invoice_id', $('.save_inv_id').val());
    formData.append('ifsc', $('.inp_ifsc').val());
    formData.append('account_no', $('.inp_account_no').val());
    formData.append('bank_name', $('.inp_bank_name').val());
    formData.append('country_id', $('.inp_bank_country_id').val());
    formData.append('iban', $('.inp_iban').val());
    formData.append('swift_code', $('.swift_code').val());
    formData.append('currency', $('.inpt_currency').val());
    formData.append('account_type', $('.inpt_account_type').val());
    formData.append('account_holder_name', $('.inp_account_holder_name').val());
    formData.append('mobile_no', $('.inp_phone_number').val());
    formData.append('is_show',1);
    
    $(".bank_custom_key").each(function (index) {
        formData.append('custom_bank_details_key[' + index + ']', $(this).val());
    });
    $(".bank_custom_value").each(function (index) {
        formData.append('custom_bank_details_value[' + index + ']', $(this).val());
    });
    
    $.ajax({
        url: APP_URL + '/api/SaleInvoiceBankDetailsAdd',
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
                $("#addnewbankaccount").modal('hide');
                $(".bank_cutom_dib").remove()
    
                var baankDetails = response?.data;
                var btn_class = 'activate_bank_account_btn';
                loadAllBankDetials(baankDetails, btn_class);
                var last_new_record = baankDetails[baankDetails.length-1];
                appendBankActiveDetail(last_new_record);

                toastr.success(response?.message)
            } else {
                toastr.error(response?.message)
            }
    
        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
     })
    }

    // .............Tp kyc..................
    $("body").on("click", ".show_kyc_btn", function () {
        $(".document_name").val('');
        $(".document_number").val('');
        $(".document_type").val('');
        $(".evidence_type").val('');

        $("#addkyc").modal('show');
    });
    
    function saveNewKycDocument(event) {
        var formData = new FormData();
        
        formData.append('invoice_id', $('.save_inv_id').val());
        formData.append('document_name', $('.document_name').val());
        formData.append('document_number', $('.document_number').val());
        formData.append('document_type', $('.document_type').val());
        formData.append('evidence_type', $('.evidence_type').val());
        
        $.ajax({
            url: APP_URL + '/api/SaleInvoiceKycDetailsAdd',
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
                    toastr.success(response?.message);
                      $("#addkyc").modal('hide');

                } else {
                    toastr.error(response?.message)
                }
        
            }, error: function (response) {
                block_gui_end();
                console.log("server side error");
            }
         })
        }
    
    // ......payment section .............
    // $("body").on("click", ".show_payment_btn", function () {
    //     // $(".amount_received").val('');
    //     // $(".transaction_charge").val('');
    //     // $(".tds_percentage").val('');
    //     // $(".tds_amount").val('');
    //     // $(".tcs_percentage").val('');
    //     // $(".tcs_amount").val('');
    //     // $(".amount_to_settle").val('');
    //     // $(".payment_date").val('');
    //     // $(".payment_method").val('');
    //     // $(".additional_notes").val('');
    //     $("#paymentRecord").modal('show');
    // });
   
    //...................... Add footer img
    
    $("body").on("click", ".pdf_footer_btn", function () {
        
        if($(this).is(":checked")){
            var formData = new FormData();
            formData.append('invoice_id', $('.save_inv_id').val());
            formData.append('footer_on_last_page', 1);
        $(".pdf_footer_img").each(function (index) {
            formData.append('footer_img', $(this)[0].files[0]);
        });
            var selVal = $(this).val();
            $.ajax({
                url: APP_URL + '/api/SaleInvoiceAddFooter',
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
                    }
                }, error: function (response) {
                    block_gui_end();
                    console.log("server side error");
                }
            });
      }
    
    });

     //.........................Add color head.......
    
     $("body").on("click", ".colorChange", function () {
        var color_val =  $(this).attr("data-id");
         handleColorChange(color_val);
  });

     function handleColorChange(selectedColor){
        var formData = new FormData();
        formData.append('invoice_id', $('.save_inv_id').val());
        formData.append('color', selectedColor);
   
        $.ajax({
            url: APP_URL + '/api/SaleInvoiceAddColor',
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
                }
            }, error: function (response) {
                block_gui_end();
                console.log("server side error");
            }
        });
     }

     $("body").on("click", ".templateChange", function () {
        var formData = new FormData();
        formData.append('invoice_id', $('.save_inv_id').val());
        formData.append('template_id', $(this).attr("data-id"));
   
        $.ajax({
            url: APP_URL + '/api/SaleInvoiceAddTempalate',
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
                    //  toastr.success(response?.message)
                }
            }, error: function (response) {
                block_gui_end();
                console.log("server side error");
            }
        });
 });

$(document).ready(function () {
    generateQRCode();
});


$("body").on("click", ".sendWhatsAppReminder", function(){
    $.ajax({
        url:'https://api.refrens.com/businesses/test-gizfvh/invoices/64ba573a6a360b0011987a36/share?copy=Duplicate',
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
                //  toastr.success(response?.message)
            }
        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
});


$("body").on("click", ".is_upi_show", function () {
    if($(this).is(":checked")){
        $(".upi_id_crd").removeClass("hide-d");
    }else{
        $(".upi_id_crd").addClass("hide-d");
    }
    ajaxBandUpiRequestCall()
});

$("body").on("click", ".is_bank_detail_show", function () {
    if($(this).is(":checked")){
        $(".bank_detil_crd").removeClass("hide-d");
    }else{
        $(".bank_detil_crd").addClass("hide-d");
    }
    ajaxBandUpiRequestCall()
});
function ajaxBandUpiRequestCall(){
    var formData = new FormData();
    formData.append('last_active_bank_id', $('.active_bank_db_id').val());
    formData.append('is_bank_detail_show_onInv', $('.is_bank_detail_show').is(":checked") ? 1 : 0);

    formData.append('last_active_upi_id', $('.active_upi_db_id').val());
    formData.append('is_upi_detail_show_onInv', $('.is_upi_show').is(":checked") ? 1 : 0);
    formData.append('invoice_id', $('.save_inv_id').val());

    $.ajax({
        url: APP_URL + '/api/SaleInvoiceBankAndUpiStatus',
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
                //  toastr.success(response?.message)
            }
        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
}


