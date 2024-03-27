 <!-- Update Bank Details Popup -->
 <div class="modal fade twoside_modal" id="updateBankdetail" tabindex="-1" role="dialog" aria-labelledby="updateBankdetailLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
             </button>
             <div class="modal-body">
                 <div class="setup_wrapper">
                     <h2>Update Bank Account</h2>

                     <div class="inner_model_wrapper">
                         <div class="save_bankdetails show">
                             <div class="gray_card bank">
                                 <div class="gcard_header">
                                     <h3>Bank Accounts</h3>
                                     <a href="javascript:void(0)" class="show_add_new_bank_btn"><iconify-icon icon="ic:round-add"></iconify-icon> Add New Bank
                                         Account</a>
                                 </div>
                                 <div class="gcard_body bank_detail_body">
                                     @foreach($SaleInvoiceAllBankDetails as $bank_detail)
                                     <div class="upi_id  bank_rwo_{{@$bank_detail->id}}">
                                         <div class="ali_bank">
                                             <span>
                                                 <h6><span><img src="assets/images/SBI-logo.svg" alt=""></span>{{@$bank_detail->bank_name}} <a href="javascript:void(0)" onclick="showBankEditForm(this)" data-id="{{@$bank_detail->id}}"><iconify-icon icon="material-symbols:edit-rounded"></iconify-icon></a></h6>
                                                 <h5>{{@$bank_detail->account_holder_name}}</h5>
                                             </span>
                                             <ul>
                                                 <li><span>Account No:</span>{{@$bank_detail->account_no}}</li>
                                                 <li><span>IFSC:</span>{{@$bank_detail->ifsc}}</li>
                                                 <li><span>IBAN:</span>{{@$bank_detail->iban}}</li>
                                             </ul>
                                         </div>
                                         <div class="gaction">
                                             <a href="javascript:void(0)" class="removeUpi" onclick="removeBankDetailRecord(this)" data-id="{{@$bank_detail->id}}">Remove</a>
                                         </div>
                                         <div class="gaction toggle_action inp_show_invoice_type ">
                                             <p>Show in invoice?</p>
                                             <label class="switch">
                                                 <input type="checkbox" class="activate_bank_account_btn" value="{{@$bank_detail->id}}" {{@$bank_detail->is_show == 1 ? 'checked' : ''}}>
                                                 <span class="slider"></span>
                                             </label>
                                         </div>
                                     </div>
                                     @endforeach
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>