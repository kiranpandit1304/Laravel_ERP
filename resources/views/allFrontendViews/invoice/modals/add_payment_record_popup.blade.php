   <!-- Add Payment Record Popup -->
   <div class="modal fade twoside_modal" id="paymentRecord" tabindex="-1" role="dialog" aria-labelledby="paymentRecordLabel" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered" role="document">
           <div class="modal-content">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
               </button>
               <div class="modal-body">
                   <div class="setup_wrapper">
                       <h2>Add Payment Record</h2>

                       <div class="inner_model_wrapper">
                           <div class="model_body_content">
                               <ul>
                                   <li>
                                       <table>
                                           <tr>
                                               <td>Invoice No</td>
                                               <td><span class="pay_inv_no">{{@$saleInvoice->invoice_no}}</span></td>
                                           </tr>
                                           <tr>
                                               <td>Billed To</td>
                                               <td><span class="pay_inv_cust_name">{{@$saleInvoice->customer_name}}</span></td>
                                           </tr>
                                           <!-- <tr>
                                               <td> Taxable Amount</td>
                                               <td><span class="pay_inv_total_amt" >{{@$saleInvoice->total_amount}}</span></td>
                                           </tr> -->
                                           <tr>
                                               <td>Invoice Total</td>
                                               <td><span class="txable_amt pay_inv_txt_amt">{{!empty($saleInvoice->final_amount) && $saleInvoice->final_amount!='undefined' ? $saleInvoice->final_amount : '0'}}</span></td>
                                           </tr>
                                           <tr class="amt_paid_tr hide-d">
                                               <td>Amount Paid</td>
                                               <td><span class="pay_inv_paid_amt"></span></td>
                                           </tr>
                                           <tr class="changes_tr hide-d">
                                               <td>Transaction Charge</td>
                                               <td><span class="pay_trans_charges"></span></td>
                                           </tr>
                                           <tr class="tds_tr hide-d">
                                               <td>TDS</td>
                                               <td><span class="pay_tds_amt"></span></td>
                                           </tr>
                                           </tr>
                                           <tr class="tcs_tr hide-d">
                                               <td>TCS</td>
                                               <td><span class="pay_tcs_amt"></span></td>
                                           </tr>
                                           <tr class="amt_due_tr hide-d">
                                               <td>Due Amount</td>
                                               <td><span class="pay_inv_due_amt"></span></td>
                                           </tr>
                                       </table>
                                   </li>
                                   <li>
                                       Amount Received (A)
                                       <div class="input-group form-group">
                                           <div class="input-group-append">
                                               <span class="input-group-text" id="basic-addon2">₹</span>
                                           </div>
                                           <label>
                                               <input type="text" class="amount_received pay_inv_received_amt" required="" id="" aria-label="Enter Value" aria-describedby="basic-addon2" placeholder="Enter Value" value="{{!empty($SaleInvoiceAddPayment->amount_received) ? $SaleInvoiceAddPayment->amount_received : ''}}">
                                               <span>Enter Value</span>
                                           </label>
                                       </div>
                                   </li>
                                   <li>
                                       Transaction Charge (B)
                                       <div class="input-group form-group">
                                           <div class="input-group-append">
                                               <span class="input-group-text" id="basic-addon2">₹</span>
                                           </div>
                                           <label>
                                               <input type="text" class="transaction_charge pay_inv_trans_amt" required="" id="" aria-label="Enter Value" aria-describedby="basic-addon2" placeholder="Enter Value" value="{{!empty($SaleInvoiceAddPayment->transaction_charge) ? $SaleInvoiceAddPayment->transaction_charge : ''}}">
                                               <span>Enter Value</span>
                                           </label>
                                       </div>
                                   </li>
                                   <li class="oth_option">
                                       <button aria-label="Add Description" class="addtds" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                               <g id="plus-square-outline" transform="translate(-.266 .217)">
                                                   <g id="Rectangle_1143" fill="rgba(255,255,255,0)" stroke="#006AFF" transform="translate(.266 -.217)">
                                                       <rect width="16" height="16" stroke="none" rx="3"></rect>
                                                       <rect width="15" height="15" x=".5" y=".5" fill="none" rx="2.5">
                                                       </rect>
                                                   </g>
                                                   <g id="Group_588" transform="translate(5.264 4.783)">
                                                       <path id="Line_109" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="translate(3)"></path>
                                                       <path id="Line_110" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="rotate(90 1.5 4.5)">
                                                       </path>
                                                   </g>
                                               </g>
                                           </svg>Add TDS</button>
                                       <button aria-label="Add Description" class="addtcs" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                               <g id="plus-square-outline" transform="translate(-.266 .217)">
                                                   <g id="Rectangle_1143" fill="rgba(255,255,255,0)" stroke="#006AFF" transform="translate(.266 -.217)">
                                                       <rect width="16" height="16" stroke="none" rx="3"></rect>
                                                       <rect width="15" height="15" x=".5" y=".5" fill="none" rx="2.5">
                                                       </rect>
                                                   </g>
                                                   <g id="Group_588" transform="translate(5.264 4.783)">
                                                       <path id="Line_109" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="translate(3)"></path>
                                                       <path id="Line_110" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="rotate(90 1.5 4.5)">
                                                       </path>
                                                   </g>
                                               </g>
                                           </svg>Add TCS</button>
                                   </li>
                                   <li class="show_tds">
                                       <a href="#" class="remove_tds">
                                           <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" color="#006AFF" xmlns="http://www.w3.org/2000/svg">
                                               <path d="M5.35355 4.64645C5.15829 4.45118 4.84171 4.45118 4.64645 4.64645C4.45118 4.84171 4.45118 5.15829 4.64645 5.35355L5.35355 4.64645ZM18.6464 19.3536C18.8417 19.5488 19.1583 19.5488 19.3536 19.3536C19.5488 19.1583 19.5488 18.8417 19.3536 18.6464L18.6464 19.3536ZM4.64645 5.35355L18.6464 19.3536L19.3536 18.6464L5.35355 4.64645L4.64645 5.35355Z">
                                               </path>
                                               <path d="M19.3536 5.35355C19.5488 5.15829 19.5488 4.84171 19.3536 4.64645C19.1583 4.45118 18.8417 4.45118 18.6464 4.64645L19.3536 5.35355ZM4.64645 18.6464C4.45118 18.8417 4.45118 19.1583 4.64645 19.3536C4.84171 19.5488 5.15829 19.5488 5.35355 19.3536L4.64645 18.6464ZM18.6464 4.64645L4.64645 18.6464L5.35355 19.3536L19.3536 5.35355L18.6464 4.64645Z">
                                               </path>
                                           </svg>
                                       </a>
                                       <div class="sp_oths">
                                           TDS (%)
                                           <div class="input-group form-group n_space">
                                               <label>
                                                   <input type="text" class="tds_percentage pay_inv_tds_perctg" required="" id="" aria-label="Enter Value" aria-describedby="basic-addon2" placeholder="Enter Value" value="{{!empty($SaleInvoiceAddPayment->tds_percentage) ? $SaleInvoiceAddPayment->tds_percentage : ''}}">
                                                   <span>Enter Value</span>
                                               </label>
                                           </div>
                                       </div>
                                       <div class="sp_oths">
                                           TDS withheld (C)
                                           <div class="input-group form-group">
                                               <div class="input-group-append">
                                                   <span class="input-group-text" id="basic-addon2">₹</span>
                                               </div>
                                               <label>
                                                   <input type="text" class="tds_amount pay_inv_tds_amt" required="" id="" aria-label="Enter Value" aria-describedby="basic-addon2" placeholder="Enter Value" value="{{!empty($SaleInvoiceAddPayment->tds_amount) ? $SaleInvoiceAddPayment->tds_amount : ''}}">
                                                   <span>Enter Value</span>
                                               </label>
                                           </div>
                                       </div>
                                   </li>
                                   <li class="show_tcs">
                                       <a href="#" class="remove_tcs">
                                           <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" color="#006AFF" xmlns="http://www.w3.org/2000/svg">
                                               <path d="M5.35355 4.64645C5.15829 4.45118 4.84171 4.45118 4.64645 4.64645C4.45118 4.84171 4.45118 5.15829 4.64645 5.35355L5.35355 4.64645ZM18.6464 19.3536C18.8417 19.5488 19.1583 19.5488 19.3536 19.3536C19.5488 19.1583 19.5488 18.8417 19.3536 18.6464L18.6464 19.3536ZM4.64645 5.35355L18.6464 19.3536L19.3536 18.6464L5.35355 4.64645L4.64645 5.35355Z">
                                               </path>
                                               <path d="M19.3536 5.35355C19.5488 5.15829 19.5488 4.84171 19.3536 4.64645C19.1583 4.45118 18.8417 4.45118 18.6464 4.64645L19.3536 5.35355ZM4.64645 18.6464C4.45118 18.8417 4.45118 19.1583 4.64645 19.3536C4.84171 19.5488 5.15829 19.5488 5.35355 19.3536L4.64645 18.6464ZM18.6464 4.64645L4.64645 18.6464L5.35355 19.3536L19.3536 5.35355L18.6464 4.64645Z">
                                               </path>
                                           </svg>
                                       </a>
                                       <div class="sp_oths">
                                           TCS (%)
                                           <div class="input-group form-group n_space">
                                               <label>
                                                   <input type="text" class="tcs_percentage pay_inv_tcs_perctg" required="" id="" aria-label="Enter Value" aria-describedby="basic-addon2" placeholder="Enter Value" value="{{!empty($SaleInvoiceAddPayment->tcs_percentage) ? $SaleInvoiceAddPayment->tcs_percentage : ''}}">
                                                   <span>Enter Value</span>
                                               </label>
                                           </div>
                                       </div>
                                       <div class="sp_oths">
                                           TCS withheld (C)
                                           <div class="input-group form-group">
                                               <div class="input-group-append">
                                                   <span class="input-group-text" id="basic-addon2">₹</span>
                                               </div>
                                               <label>
                                                   <input type="text" class="tcs_amount pay_inv_tcs_amt" required="" id="" aria-label="Enter Value" aria-describedby="basic-addon2" placeholder="Enter Value" value="{{!empty($SaleInvoiceAddPayment->tcs_amount) ? $SaleInvoiceAddPayment->tcs_amount : ''}}">
                                                   <span>Enter Value</span>
                                               </label>
                                           </div>
                                       </div>
                                   </li>
                                   <li>
                                       <p class="normal">Amount to Settle (A+B)</p>
                                       <p class="tds_tcs">Amount to Settle (A+B+C)</p>
                                       <div class="input-group form-group">
                                           <div class="input-group-append">
                                               <span class="input-group-text" id="basic-addon2">₹</span>
                                           </div>
                                           <label>
                                               <input type="text" disabled class="amount_to_settle pay_inv_settled_amt" required="" id="" aria-label="Enter Value" aria-describedby="basic-addon2" placeholder="Enter Value" value="{{!empty($SaleInvoiceAddPayment->amount_to_settle) ? $SaleInvoiceAddPayment->amount_to_settle : ''}}">
                                               <span>Enter Value</span>
                                           </label>
                                       </div>
                                   </li>
                                   <li>
                                       Payment Date
                                       <div class="input-group form-group date">
                                           <input type="date" class="payment_date pay_inv_date" name="" id="" value="{{!empty($SaleInvoiceAddPayment->payment_date) ? $SaleInvoiceAddPayment->payment_date : ''}}">
                                       </div>
                                   </li>
                                   <li>
                                       Payment Method
                                       <select class="js-example-placeholder-single-currency payment_method pay_inv_acct_trans_type">
                                           <option value="1">Account Transfer</option>
                                           <option value="2">UPI</option>
                                           <option value="3">Cash Payment</option>
                                           <option value="4">Cheque</option>
                                           <option value="5">Demand Draft</option>
                                           <option value="6">Other</option>
                                           <option value="7">Proforma Payment</option>
                                       </select>
                                   </li>
                                   <li>
                                       Additional Notes
                                       <textarea name="" class="additional_notes pay_inv_addinalt_notes" id="" cols="30" rows="3" placeholder="Add any additional notes such as payment refrens"></textarea>
                                   </li>
                               </ul>
                           </div>
                           <input type="hidden" class="pay_inv_id" />
                           <input type="hidden" class="curent_page" />
                           <div class="com_action">
                               <button class="nobgc" data-dismiss="modal" aria-label="Close">Cancel</button>
                               <button class="click_next" onclick="savePaymentDetail(this)">Done</button>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>

   @push('custom-scripts')
   <script>
       //..............get detail..........
       $("body").on("click", ".show_payment_btn", function() {
               loadModalValues();
               var id = $(this).attr("title");
               var page = $(this).attr("data-page");
           $.ajax({
               url: APP_URL + '/api/SaleInvoiceGetPayment/' + id,
               type: 'get',
               cache: false,
               contentType: false,
               processData: false,
               beforeSend: function(xhr) {
                   block_gui_start();
                   xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
               },
               success: function(response) {
                   block_gui_end();
                   var data = response?.data;
                   $(".pay_inv_no").text(data?.invoice_no);
                   $(".pay_inv_cust_name").text(data?.customer_name);
                   $(".pay_inv_txt_amt").text(data?.final_total);
                   $(".pay_inv_total_amt").text(data?.total_amount);
                   $(".pay_inv_received_amt").val(data?.last_paid_amount);
                   $('.pay_inv_id').val(id);
                   $('.curent_page').val(page);

                   if (data?.total_pay_amount != '' && !isNaN(data?.total_pay_amount) && data?.total_pay_amount != undefined) {
                       $(".amt_paid_tr").removeClass("hide-d");
                       $(".pay_inv_paid_amt").text(data?.total_pay_amount);
                   }

                   if (data?.due_amount != '' && !isNaN(data?.due_amount) && data?.due_amount != undefined) {
                       $(".amt_due_tr").removeClass("hide-d");
                       $(".pay_inv_due_amt").text(data?.due_amount.toFixed(2));

                   }
                   if (data?.total_transaction_charge != '' && !isNaN(data?.total_transaction_charge) && data?.total_transaction_charge != undefined) {
                       $(".changes_tr").removeClass("hide-d");
                       $(".pay_trans_charges").text(data?.total_transaction_charge);
                   }
                   if (data?.total_tds_amount != '' && !isNaN(data?.total_tds_amount) && data?.total_tds_amount != undefined) {
                       $(".tds_tr").removeClass("hide-d");
                       $(".pay_tds_amt").text(data?.total_tds_amount);

                   }
                   if (data?.total_tcs_amount != '' && !isNaN(data?.total_tcs_amount) && data?.total_tcs_amount != undefined) {
                       $(".tcs_tr").removeClass("hide-d");
                       $(".pay_tcs_amt").text(data?.total_tcs_amount);

                   }

                   $("#paymentRecord").modal('show');

                   ResetDomainPage();

               },
               error: function(response) {
                   block_gui_end();
                   console.log("server side error");
               }
           });
       });

       function loadModalValues(){
           $(".amt_paid_tr").addClass("hide-d");
           $(".amt_due_tr").addClass("hide-d");
           $(".changes_tr").addClass("hide-d");
           $(".tds_tr").addClass("hide-d");
           $(".tcs_tr").addClass("hide-d");
        //    $(".payment_div").addClass("hide-d");

           $('.amount_received').val('');
           $('.transaction_charge').val('');
           $('.tds_percentage').val('');
           $('.tds_amount').val('');
           $('.tcs_percentage').val('');
           $('.tcs_amount').val('');
           $('.amount_to_settle').val('');
           $('.payment_date').val('');
           $('.payment_method').val('');
           $('.additional_notes').val('');
       }
       // ...end
       //   
       $(".amount_received").on("input", function() {
           var amt_class = '';
           if ($(".addtds").hasClass("active")) {
               amt_class = 'tds_amount';
           } else if ($(".addtcs").hasClass("active")) {
               amt_class = 'tcs_amount';
           } else {
               amt_class = 'no';

           }
           calculatePayTotal(false, '', '', amt_class);
       })

       $(".transaction_charge").on("input", function() {
           var amt_class = '';
           if ($(".addtds").hasClass("active")) {
               amt_class = 'tds_amount';
           } else if ($(".addtcs").hasClass("active")) {
               amt_class = 'tcs_amount';
           } else {
               amt_class = 'no';

           }
           calculatePayTotal(false, '', '', amt_class);
       })

       //   ..................... TDS .............................

       $(".tds_percentage").on("input", function() {
           calculatePayTotal(true, '%', 'tds_percentage', 'tds_amount')
       });

       $(".tds_amount").on("input", function() {
           calculatePayTotal(true, 'amount', 'tds_percentage', 'tds_amount');
       })
       //   ............................ Tcs....................

       $(".tcs_percentage").on("input", function() {
           calculatePayTotal(true, '%', 'tcs_percentage', 'tcs_amount')
       });

       $(".tcs_amount").on("input", function() {
           calculatePayTotal(true, 'amount', 'tcs_percentage', 'tcs_amount')
       });
       //    ...............Button click..........
       $(".addtds").on("click", function() {
           calculatePayTotal(true, '%', 'tds_percentage', 'tds_amount')
       });

       $(".addtcs").on("click", function() {
           calculatePayTotal(true, '%', 'tcs_percentage', 'tcs_amount')
       });

       function calculatePayTotal(is_percenatge = false, percentage_type = '', percenatage_class = '', tcs_td_amount = '') {

           var total = 0;
           var taxable_amt = parseFloat($(".txable_amt").text());
           var amt1 = parseFloat($(".amount_received").val());
           var amt2 = parseFloat($(".transaction_charge").val());
           total = amt1 + amt2;

           if (is_percenatge == true) {
               var tds_in_percatge = parseFloat($("." + percenatage_class).val());
               var tds_amount = parseFloat($("." + tcs_td_amount).val());
               if (percentage_type == '%') {
                   var pert_total = (tds_in_percatge / 100) * taxable_amt;
                   if (pert_total != undefined && !isNaN(pert_total))
                       $("." + tcs_td_amount).val(pert_total.toFixed(2));
                   else
                       $("." + tcs_td_amount).val('0');

                   if (pert_total != undefined && !isNaN(pert_total))
                       total = total + pert_total;

               } else if (percentage_type == 'amount') {

                   var amt_total = (tds_amount / taxable_amt) * 100;
                   if (amt_total != undefined && !isNaN(amt_total))
                       $("." + percenatage_class).val(amt_total.toFixed(2));
                   else
                       $("." + percenatage_class).val('0');

                   if (tds_amount != undefined && !isNaN(amt_total))
                       total = total + tds_amount;

               }
           } else {
               if ($("." + tcs_td_amount).val() != 'no' && $("." + tcs_td_amount).val() != undefined && !isNaN($("." + tcs_td_amount).val()))
                   total = total + parseFloat($("." + tcs_td_amount).val());
           }

           if (total != undefined && !isNaN(total))
               $(".amount_to_settle").val(total.toFixed(2));
           else
               $(".amount_to_settle").val('0');
       }

       function savePaymentDetail(event) {
           var formData = new FormData();

           formData.append('invoice_id', $('.pay_inv_id').val());
           formData.append('amount_received', $('.amount_received').val());
           formData.append('transaction_charge', $('.transaction_charge').val());
           formData.append('tds_percentage', $('.tds_percentage').val());
           formData.append('tds_amount', $('.tds_amount').val());
           formData.append('tcs_percentage', $('.tcs_percentage').val());
           formData.append('tcs_amount', $('.tcs_amount').val());
           formData.append('amount_to_settle', $('.amount_to_settle').val());
           formData.append('payment_date', $('.payment_date').val());
           formData.append('payment_method', $('.payment_method').val());
           formData.append('additional_notes', $('.additional_notes').val());

           $.ajax({
               url: APP_URL + '/api/SaleInvoiceAddPaymentAdd',
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
                       $("#paymentRecord").modal('hide');
                   ResetDomainPage();
                   var page = $(".curent_page").val();
                   if(page == 'step3'){
                     window.location.reload();
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
       // ...
       //.........................Add letter head.......

       $("body").on("click", ".letter_head_btn", function() {

           if ($(this).is(":checked")) {
               var formData = new FormData();
               formData.append('invoice_id', $('.save_inv_id').val());
               formData.append('letterhead_on_first_page', 1);
               $(".letter_head_img").each(function(index) {
                   formData.append('letterhead_img', $(this)[0].files[0]);
               });
               var selVal = $(this).val();
               $.ajax({
                   url: APP_URL + '/api/SaleInvoiceAddLetterheadAdd',
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
                           toastr.success(response?.message)
                       }
                   },
                   error: function(response) {
                       block_gui_end();
                       console.log("server side error");
                   }
               });
           }

       });
   </script>
 <script>
// ..................Payment popup.........
    $("button.addtds").click(function(e) {
        $('.show_tds').addClass('show');
        $('.show_tcs').removeClass('show');
        $('button.addtds').addClass('active');
        $('button.addtcs').removeClass('active');
        $(".tcs_amount").val(0);
        $('p.tds_tcs').addClass('show');
        $('p.normal').addClass('hide');
    });
    $("a.remove_tds").click(function(e) {
        $('.show_tds').removeClass('show');
        $('button.addtds').removeClass('active');
        $('button.addtcs').removeClass('active');
        $('p.tds_tcs').removeClass('show');
        $('p.normal').removeClass('hide');
    });

    $("button.addtcs").click(function(e) {
        $('.show_tcs').addClass('show');
        $('.show_tds').removeClass('show');
        $('button.addtcs').addClass('active');
        $('button.addtds').removeClass('active');
        $(".tds_amount").val(0);
        $('p.tds_tcs').addClass('show');
        $('p.normal').addClass('hide');
    });
    $("a.remove_tcs").click(function(e) {
        $('.show_tcs').removeClass('show');
        $('button.addtcs').removeClass('active');
        $('button.addtds').removeClass('active');
        $('p.tds_tcs').removeClass('show');
        $('p.normal').removeClass('hide');
    });
</script>

   @endpush