 <!-- ExportModel -->
 <div class="modal fade twoside_modal" id="exportPopup" tabindex="-1" role="dialog" aria-labelledby="exportPopupLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">×</span>
             </button>
             <div class="modal-body">
                 <div class="row">
                    <form action="javascript:void(0)" method="post" id="exportForm_d" >
                     <div class="col-lg-12 col-sm-12 col-xs-12">
                         <div class="shinvite">
                             <div class="shi_header">
                                 <h5>Export Invoices</h5>
                                 <a href="#"><iconify-icon icon="ph:info"></iconify-icon></a>
                             </div>
                             <div class="shi_body">
                                 <div class="grid">
                                     <label class="card ">
                                         <input name="plan" class="radio export_option" value="pdf" data-type="" type="radio"  />

                                         <span class="plan-details">
                                             <img src="{{asset('unsync_assets/assets/images/pdf.png') }}" data-type="" alt="" />
                                             <h2>PDF</h2>
                                         </span>
                                     </label>
                                     <label class="card " data-id="excel">
                                         <input name="plan" class="radio export_option" value="excel" data-type="" type="radio" checked />

                                         <span class="plan-details" aria-hidden="true">
                                             <img src="{{asset('unsync_assets/assets/images/excel.png') }}" alt="" />
                                             <h2>Excel</h2>
                                         </span>
                                     </label>
                                     <label class="card " data-id="tally">
                                         <input name="plan" class="radio export_option " value="tally" data-type="" type="radio" />

                                         <span class="plan-details" aria-hidden="true">
                                             <img src="{{asset('unsync_assets/assets/images/essay.png') }}" alt="" />
                                             <h2>Tally</h2>
                                         </span>
                                     </label>
                                 </div>
                             </div>
                             <input type="hidden" class="hidhen_export_val" />
                             <div class="shi_footer">
                            
                                 <button type="submit" class="done_btn export_cut_btn expt_btn" data-url="{{url('/api/SaleInvoiceExport?guard=WEB&platform=Unesync', $enypt_id,)}}">Export</button> &nbsp; &nbsp;
                             </div>
                         </div>
                     </div>
                    </form>
                 </div>
             </div>
         </div>
     </div>
 </div>
 