var bkkey=0;
function appendBankCustomRow(e) {

    var LineHtml = [];
    LineHtml += '<div class="hidden_row bank_cutom_dib show bank_rwo_' + bkkey + '" key="">';
    LineHtml += '<div class="form-group col-sm-6">';
    LineHtml += '   <label>';
    LineHtml += '      <input type="text" class="bank_custom_key" placeholder="Enter Label">';
    LineHtml += '      <span>Label</span>';
    LineHtml += '  </label> ';
    LineHtml += '</div>';
    LineHtml += '<div class="form-group col-sm-6">';
    LineHtml += '  <label>';
    LineHtml += '     <input type="text" class="bank_custom_value" placeholder="Enter Value">';
    LineHtml += '     <span>Value</span>';
    LineHtml += '  </label> ';
    LineHtml += '   <a href="javascript:void(0)" onclick="removeBankCustomRow(this)" data-id="'+bkkey+'" class="remove_field">Remove</a>';
    LineHtml += ' </div>';
    LineHtml += '</div>';
       $(".bk_detail_div").after(LineHtml);
       bkkey++;
}


function removeBankCustomRow(event) {
    var rid = $(event).attr("data-id");
    $(".bank_rwo_" + rid).remove();
    bkkey--;
}

function showAddbankForm(){

    $(".bank_detal_db_id").val('');
    $('.inp_ifsc').val('');
    $('.inp_account_no').val('');
    $('.inp_bank_name').val('');
    // $('.inp_bank_country_id').val('').change();
    $('.inp_iban').val('');
    $('.swift_code').val('');
    // $('.inpt_currency').val('').change();
    // $('.inpt_account_type').val('').change();
    $('.inp_account_holder_name').val('');
    $('.inp_phone_number').val('');

    $(".bank_cutom_dib").remove()
    $(".bankdetails").addClass("show");
    $(".save_bankdetails").removeClass("show");
    $(".save_bank_details").attr("onclick", "saveBankDetail(this)");
    $(".save_bank_details").removeClass("hide-d");
}


function saveBankDetail(event) {
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
            $(".save_bankdetails").addClass("show");
            $(".bankdetails").removeClass("show");
            $(".bank_cutom_dib").remove()


            var baankDetails = response?.data;
            var btn_class = 'account_activate';
            loadAllBankDetials(baankDetails, btn_class);
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

function loadAllBankDetials(baankDetails, btn_class){
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
    $(".save_bank_details").addClass("hide-d");

}


function removeBankDetailRecord(event){

    var id= $(event).attr("data-id");
    $.ajax({
        url: APP_URL + '/api/SaleInvoiceBankDetailsDelete/'+id,
        type: 'get',
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
                toastr.success(response?.message);
                $(".bank_rwo_"+id).remove();
        }
        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
     });

}

$("body").on("click", ".account_activate", function(){
    $(".account_activate").not(this).prop("checked", false);
    var current_val = $(this).is(":checked") ? true : false;
    $(this).prop("checked", current_val);

   var selVal =  $(this).val();
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

            toastr.success(response?.message);
    }
    }, error: function (response) {
        block_gui_end();
        console.log("server side error");
    }
 });

});

function showBankEditForm(event){
  var id = $(event).attr("data-id")

    $.ajax({
        url: APP_URL + '/api/SaleInvoiceBankDetailsShow/'+id,
        type: 'get',
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
               var data = response?.data;
                $(".bank_detal_db_id").val(data?.id);
                $('.inp_ifsc').val(data?.ifsc);
                $('.inp_account_no').val(data?.account_no);
                $('.inp_bank_name').val(data?.bank_name );
                $('.inp_bank_country_id').val(data?.country_id).change();
                $('.inp_iban').val(data?.iban);
                $('.swift_code').val(data?.swift_code);
                $('.inpt_currency').val(data?.currency).change();
                $('.inpt_account_type').val(data?.account_type).change();
                $('.inp_account_holder_name').val(data?.account_holder_name);
                $('.inp_phone_number').val(data?.mobile_no);
                var customKeysData = JSON.parse(data?.custom_bank_details);
                customArray=[];
                customArray.push(customKeysData);
                console.log('customArray ', customKeysData);

                var LineHtml=[];
                if(customKeysData?.length > 0){
                for(var i=0; i<=customKeysData?.length; i++){
                    if(customKeysData[i]?.key != '' && customKeysData[i]?.key !=undefined){
                        var db_key= customKeysData[i]?.key;
                        var db_value= customKeysData[i]?.value;
                        LineHtml += '<div class="hidden_row show bank_rwo_' + bkkey + '" key="">';
                        LineHtml += '<div class="form-group col-sm-6">';
                        LineHtml += '   <label>';
                        LineHtml += '      <input type="text" class="bank_custom_key" value="'+db_key+'" placeholder="Enter Label">';
                        LineHtml += '      <span>Label</span>';
                        LineHtml += '  </label> ';
                        LineHtml += '</div>';
                        LineHtml += '<div class="form-group col-sm-6">';
                        LineHtml += '  <label>';
                        LineHtml += '     <input type="text" class="bank_custom_value"  value="'+db_value+'" placeholder="Enter Value">';
                        LineHtml += '     <span>Value</span>';
                        LineHtml += '  </label> ';
                        LineHtml += '   <a href="javascript:void(0)" onclick="removeBankCustomRow(this)" data-id="'+bkkey+'" class="remove_field">Remove</a>';
                        LineHtml += ' </div>';
                        LineHtml += '</div>';
                        bkkey++;
                    }
                }
                $(".bk_detail_div").empty().after(LineHtml);
               }
                $(".bankdetails").addClass("show");
                $(".save_bankdetails").removeClass("show");
                $(".save_bank_details").attr("onclick", "editBankDetail(this)");
                $(".save_bank_details").removeClass("hide-d");
                $("#addnewbankaccount").modal('show');

            
        }
        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
     });
}

function editBankDetail(){
    var bid = $('.bank_detal_db_id').val();
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
        formData.append('id', bid);

        $(".bank_custom_key").each(function (index) {
            formData.append('custom_bank_details_key[' + index + ']', $(this).val());
        });
        $(".bank_custom_value").each(function (index) {
            formData.append('custom_bank_details_value[' + index + ']', $(this).val());
        });

    $.ajax({
        url: APP_URL + '/api/SaleInvoiceBankDetailsEdit',
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
                $(".save_bankdetails").addClass("show");
                $(".bankdetails").removeClass("show");
                var baankDetails = response?.data;
                var btn_class = 'account_activate'
                loadAllBankDetials(baankDetails, btn_class);
                var last_new_record = baankDetails.filter(v => v.id == bid);
                console.log('last_new_record' , last_new_record[0]);
                appendBankActiveDetail(last_new_record[0]);
                $("#addnewbankaccount").modal('hide');

            toastr.success(response?.message)
        }
        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
     });

}

function appendBankActiveDetail(data) {

if(data.is_show == 1){
    var middletml = [];

    middletml += ' <li><span>Account Holder Name</span>' + data.account_holder_name + '</li>';
    middletml += '<li><span>Account Number</span> ' + data.account_no + '</li>';
    middletml += ' <li><span>Aadhar</span> ' + data.ifsc + '</li>';
    middletml += ' <li><span>IBAN</span> ' + data.iban + '</li>';
    if (data.account_type == 1)
        middletml += ' <li><span>Account Type</span> Current</li>';
    else if (data.account_type == 2)
        middletml += ' <li><span>Account Type</span> Savings</li>';
     else
        middletml += ' <li><span>Account Type</span> </li>';

    middletml += ' <li><span>Bank</span>' + data.bank_name + '</li>';
    $(".bank_detail_mdle_div").empty().append(middletml);

    var bottomHtml = [];
    bottomHtml += '   <h5>' + data.bank_name + '</h5>';
    bottomHtml += '   <p>' + data.account_holder_name + '</p>';
    bottomHtml += '    <p>Acc. No: <span>' + data.account_no + '</span> &nbsp; &nbsp; IFSC: <span>' + data.ifsc + '</span></p>';
  $(".active_bank_db_id").val(data?.id)
    $(".bank_botom_dev").empty().append(bottomHtml);
  }
}

//Fill next button tab code= SBIN0060288
$("body").on("focusout", "#ifsc_ivn_code", function () {
    var ifcs_code = $(this).val();
    $.ajax({
        url: 'https://ifsc.razorpay.com/' + ifcs_code,
        type: "GET",
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            block_gui_start();
        },
        success: function (response) {
            block_gui_end();
            $('.inp_bank_name').val(response?.BANK);
            $('.swift_code').val(response?.SWIFT);
            var statelist = state_list.filter(v => v.name.toLowerCase() === response?.STATE.toLowerCase());

        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
});



//................................................UPI SECTION START................................................

function showAddUpiForm(){
    $('.inp_upi_id').val('');

    $(".upi_form").removeClass("hide-d");
    $(".upi_footer").removeClass("hide-d");
    $(".save_upi_btn").removeClass("hide-d");
    $(".save_upi_btn").attr("onclick", "saveUserUpiID(this)");
    window.scrollTo(0, 3000);
}

function saveUserUpiID(event) {
var formData = new FormData();
formData.append('invoice_id', $('.save_inv_id').val());
formData.append('upi_id', $('.inp_upi_id').val());
formData.append('show_invoice',1);

$.ajax({
    url: APP_URL + '/api/SaleInvoiceBankUpiAdd',
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
            var baankDetails = response?.data;
            loadAllUPIDetials(baankDetails);
            generateQRCode();
            toastr.success(response?.message);
        } else {
            toastr.error(response?.message)
        }

    }, error: function (response) {
        block_gui_end();
        console.log("server side error");
    }
 })
}

function loadAllUPIDetials(baankDetails){
    var deHtml = []; 
    for(var i=0; i<=baankDetails.length; i++){
        if(baankDetails[i]?.upi_id != undefined){
            deHtml+='<div class="upi_id show upi_rwo_'+baankDetails[i]?.id+'">';
            deHtml+='   <h6><span><img src="assets/images/SBI-logo.svg" alt=""></span>'+baankDetails[i]?.upi_id+' <a href="javascript:void(0)" onclick="showUpiEditForm(this)" data-id="'+baankDetails[i]?.id+'" ><iconify-icon icon="material-symbols:edit-rounded"></iconify-icon></a></h6>';
            deHtml+=' <div class="gaction">';
            deHtml+='      <a href="javascript:void(0)" onclick="removeUPIDetailRecord(this)" data-id="'+baankDetails[i]?.id+'" class="removeUpi">Remove</a>';
            deHtml+='  </div>';
            deHtml+=' <div class="gaction toggle_action inp_show_invoice_type">';
            deHtml+='    <p>Show in invoice?</p>';
            if(baankDetails[i]?.is_active == 1){
                deHtml+='    <label class="switch">';
                deHtml+='       <input type="checkbox" class="upi_id_activate" name="upi_id_name" data-id="'+baankDetails[i]?.upi_id+'" checked value="'+baankDetails[i]?.id+'">';
                deHtml+='      <span class="slider"></span>';
                deHtml+='  </label>';
            }else{
                deHtml+='    <label class="switch">';
                deHtml+='       <input type="checkbox" class="upi_id_activate" name="upi_id_name"  data-id="'+baankDetails[i]?.upi_id+'"  value="'+baankDetails[i]?.id+'">';
                deHtml+='      <span class="slider"></span>';
                deHtml+='  </label>'; 
            }
            deHtml+='  </div>';
            deHtml+='  </div>';
     }
    }
    deHtml+=' <div class="enter_new upi_id show upi_form hide-d">';
    deHtml+=' <div class="form-group col-sm-12">';
    deHtml+='    <label for="" class="big_size_noedit ">Enter new UPI Id</label>';
    deHtml+='   <input type="text" class="inp_upi_id">';
    deHtml+=' </div>';
    deHtml+='</div>';

    $(".upi_body_d").empty().append(deHtml);
    $(".upi_footer").addClass("hide-d");
    $(".save_upi_btn").attr("onclick", "generateQRCode(this)");
}

function showUpiEditForm(event){
    var id = $(event).attr("data-id")
  
      $.ajax({
          url: APP_URL + '/api/SaleInvoiceBankUpiShow/'+id,
          type: 'get',
          beforeSend: function (xhr) {
              block_gui_start();
              xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
          },
          success: function (response) {
              block_gui_end();
              if (response.status == true) {
                 var data = response?.data;
                  $(".upi_detal_db_id").val(data?.id);
                  $('.inp_upi_id').val(data?.upi_id);

                  $(".upi_form").removeClass("hide-d");
                  $(".upi_footer").removeClass("hide-d");
                  $(".save_upi_btn").attr("onclick", "editUpiDetail(this)");

                  window.scrollTo(0, 3000);

          }
          }, error: function (response) {
              block_gui_end();
              console.log("server side error");
          }
       });
  }
  
  function editUpiDetail(){
      var formData = new FormData();
          formData.append('invoice_id', $('.save_inv_id').val());
          formData.append('upi_id', $('.inp_upi_id').val());
          formData.append('id', $('.upi_detal_db_id').val());
  
      $.ajax({
          url: APP_URL + '/api/SaleInvoiceBankUpiEdit',
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
                  $(".save_bankdetails").addClass("show");
                  $(".bankdetails").removeClass("show");
                  var baankDetails = response?.data;
                  loadAllUPIDetials(baankDetails);
                  generateQRCode();
              toastr.success(response?.message)
          }
          }, error: function (response) {
              block_gui_end();
              console.log("server side error");
          }
       });
  
  }

function removeUPIDetailRecord(event){

    var id= $(event).attr("data-id");
    $.ajax({
        url: APP_URL + '/api/SaleInvoiceBankUpiDelete/'+id,
        type: 'get',
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
                toastr.success(response?.message);
                $(".upi_rwo_"+id).remove();
        }
        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
     });

}


$("body").on("click", ".upi_id_activate", function(){
    $(".upi_id_activate").not(this).prop("checked", false);
    var current_val = $(this).is(":checked") ? true : false;
    $(this).prop("checked", current_val);
    var selVal =  $(this).val();
    $.ajax({
     url: APP_URL + '/api/SaleInvoiceBankUpiActive',
     data:{'id':selVal, 'is_active':current_val},
     type: 'post',
     beforeSend: function (xhr) {
             block_gui_start();
             xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
        
     },
     success: function (response) {
         block_gui_end();
         if (response.status == true) {
             toastr.success(response?.message);
             var length = $('.upi_id_activate').filter(':checked').length;
    console.log('lenght',length)
             if(length== 1){
                 $(".is_upi_show").prop("checked", true);
             generateQRCode();

             }else{
                $(".is_upi_show").prop("checked", false);

             }

     }
     }, error: function (response) {
         block_gui_end();
         console.log("server side error");
     }
  });
 
 });

 // .................... QR code img saving

function saveQRCodeDetail(event) {
    var formData = new FormData();
    
    formData.append('invoice_id', $('.save_inv_id').val());
    formData.append('upi_id', $('input[name="upi_id_name"]:checked').attr("data-id"));
    formData.append('amount', $(".g_step3total").text());
    formData.append('qr_color', '#000000');
    formData.append('qr_background_color', '#ffffff');
    formData.append('qr_logo', '');
    formData.append('qr_image', $("#qrcode").children().next().attr("src"));
   
    $.ajax({
        url: APP_URL + '/api/SaleInvoiceQrCodeAdd',
        data: formData,
        type: 'post',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            // block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                // toastr.success(response?.message);
                  $("#paymentRecord").modal('hide');

            } else {
                toastr.error(response?.message)
            }
    
        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
     })
    }

    
function generateQRCode() {
    // const vpa = document.getElementById("vpa-input").value; 
    const vpa = $('input[name="upi_id_name"]:checked').attr("data-id");
    const vpa_id = $('input[name="upi_id_name"]:checked').val();
    const amount = parseFloat($(".g_step3total").text());
    const color = '#000000';
    const bgColor = '#ffffff';
    const logoInput = document.getElementById("logo-input");

    if (vpa && amount) {
        const qrCodeElement = document.getElementById("qrcode");
        qrCodeElement.innerHTML = "";

        const upiUrl = createUPIUrl(vpa, amount);

        const options = {
            text: upiUrl,
            width: 200,
            height: 200,
            colorDark: color,
            colorLight: bgColor,
            correctLevel: QRCode.CorrectLevel.H
        };

        const qrCode = new QRCode(qrCodeElement, options);
        $(".active_upi_id").html(vpa);
        $(".active_upi_db_id").val(vpa_id);
        $("#updateUPIdetail").modal('hide');

        setTimeout(function() { 
            saveQRCodeDetail();
        }, 3000);
        
        if (logoInput.files && logoInput.files[0]) {
            addLogoToQRCode(logoInput, qrCodeElement);

        }
    }
}

function createUPIUrl(vpa, amount) {
    const baseUrl = "upi://pay";
    const queryParams = {
        pa: vpa,
        pn: "",
        mc: "",
        tid: "",
        tr: "",
        tn: "",
        am: amount,
        cu: "INR",
        url: ""
    };

    const queryString = new URLSearchParams(queryParams).toString();
    return `${baseUrl}?${queryString}`;
}


function addLogoToQRCode(logoInput, qrCodeElement) {
    const reader = new FileReader();
    reader.onload = function (e) {
        const logo = new Image();
        logo.src = e.target.result;
        logo.onload = function () {
            const canvas = qrCodeElement.getElementsByTagName("canvas")[0];
            const ctx = canvas.getContext("2d");
            const logoSize = 50;
            const logoPosition = (canvas.width - logoSize) / 2;
            ctx.drawImage(logo, logoPosition, logoPosition, logoSize, logoSize);
        };
    };
    reader.readAsDataURL(logoInput.files[0]);
}

function updateColorInput(input) {
    input.style.backgroundColor = input.value;
    input.style.color = getContrastColor(input.value);
}

function getContrastColor(hexColor) {
    const r = parseInt(hexColor.substr(1, 2), 16);
    const g = parseInt(hexColor.substr(3, 2), 16);
    const b = parseInt(hexColor.substr(5, 2), 16);
    const yiq = ((r * 299) + (g * 587) + (b * 114)) / 1000;
    return (yiq >= 128) ? 'black' : 'white';
}

const colorInput = document.getElementById("color-input");
const bgColorInput = document.getElementById("bgcolor-input");

colorInput.addEventListener("change", () => updateColorInput(colorInput));
bgColorInput.addEventListener("change", () => updateColorInput(bgColorInput));

updateColorInput(colorInput);
updateColorInput(bgColorInput);

document.getElementById("generate-btn").addEventListener("click", generateQRCode);