 <!-- Update UPI Details Popup -->
 <div class="modal fade twoside_modal" id="updateUPIdetail" tabindex="-1" role="dialog" aria-labelledby="updateUPIdetailLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
             </button>
             <div class="modal-body">
                 <div class="setup_wrapper">
                     <h2>Select a UPI ID</h2>
                     <div class="inner_model_wrapper">
                         <div class="gray_card">
                             <div class="gcard_header">
                                 <h3>Your UPI IDs</h3>
                                 <a href="javascript:void(0)" class="showNewupi" onclick="showAddUpiForm(this)"><iconify-icon icon="ic:round-add"></iconify-icon> Add
                                     New UPI ID</a>
                             </div>
                             <div class="gcard_body upi_body_d">
                                 @foreach($SaleInvoiceAllBankUpi as $upi_detail)
                                 <div class="upi_id upi_rwo_{{@$upi_detail->id}}">
                                     <h6><span><img src="assets/images/SBI-logo.svg" alt=""></span> {{@$upi_detail->upi_id}}<a href="javascript:void(0)" onclick="showUpiEditForm(this)" data-id="{{@$upi_detail->id}}"><iconify-icon icon="material-symbols:edit-rounded"></iconify-icon></a></h6>
                                     <div class="gaction">
                                         <a href="javascript:void(0)" class="removeUpi" onclick="removeUPIDetailRecord(this)" data-id="{{@$upi_detail->id}}">Remove</a>
                                     </div>
                                     <div class="gaction toggle_action">
                                         <p>Show in invoice?</p>
                                         <label class="switch">
                                             <input type="checkbox" name="upi_id_name" class="upi_id_activate" data-id="{{@$upi_detail->upi_id}}" value="{{@$upi_detail->id}}" {{@$upi_detail->is_active == 1 ? 'checked' : ''}}>
                                             <span class="slider"></span>
                                         </label>
                                     </div>
                                 </div>
                                 @endforeach
                                 <div class="enter_new upi_id show upi_form hide-d">
                                     <div class="form-group col-sm-12">
                                         <label for="" class="big_size_noedit ">Enter new UPI Id</label>
                                         <input type="text" class="inp_upi_id">
                                     </div>
                                 </div>
                             </div>
                             <input type="hidden" class="upi_detal_db_id" />
                             <div class="gcard_footer">
                                 <button class="save_upi_btn " id="generate-btn" onclick="generateQRCode(this)">Save Changes</button>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>