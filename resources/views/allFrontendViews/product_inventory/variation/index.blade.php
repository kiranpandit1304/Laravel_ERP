 <!-- Add Variation -->
 <div class="modal fade twoside_modal" id="addvariationPopup" tabindex="-1" role="dialog" aria-labelledby="addvariationPopupLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <button type="button" class="close closeaddvaripopup" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">×</span>
             </button>
             <div class="modal-body">
                 <div class="row">
                     <div class="col-lg-12 col-sm-12 col-xs-12">
                         <div class="shinvite">
                             <div class="shi_header">
                                 <h5>Add Variation</h5>
                                 <a href="#"><iconify-icon icon="ph:info"></iconify-icon></a>
                             </div>
                             <form action="javascript:void(0)" method="post" id="addVariationForm_d">
                                 <div class="shi_body">
                                     <div class="row">
                                         <div class="col-lg-6">
                                             <div class="form-group">
                                                 <input type="text" class="variation_name_d" name="variation_name" placeholder="Variation Name">
                                             </div>
                                         </div>
                                         <div class="col-lg-6">
                                             <div class="form-group">
                                                 <input type="text" class="sku_d" name="sku" placeholder="SKU">
                                             </div>
                                         </div>
                                         <div class="col-lg-6">
                                             <div class="form-group">
                                                 <input type="text" class="purchase_price_d" name="purchase_price" placeholder="Buying Price">
                                             </div>
                                         </div>
                                         <div class="col-lg-6">
                                             <div class="form-group">
                                                 <input type="text" class="sale_price_d" name="sale_price" placeholder="Selling Price">
                                             </div>
                                         </div>
                                     </div>
                                     <div class="row">
                                         <div class="col-lg-6">
                                             <div class="form-group end">
                                                 <input type="text" class="tax_rate_d" name="tax_rate" placeholder="Tax Rate">
                                             </div>
                                         </div>
                                         <div class="col-lg-6">
                                             <div class="form-group end">
                                                 <input type="text" class="hsn_d" name="hsn" placeholder="HSN">
                                             </div>
                                         </div>
                                         <div class="col-lg-12">
                                             <div class="form-group end">
                                                 <select class="form-select unit_id" name="unit_id" id="listunitt2" name="list">
                                                     <option value="">Select Unit</option>
                                                     @if(!empty($productUnits))
                                                     @foreach($productUnits as $unit)
                                                     <option value="{{@$unit->id}}">{{@$unit->name}}</option>
                                                     @endforeach
                                                     @endif

                                                 </select>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <input type="hidden" class="vid" value="">
                                 <input type="hidden" class="variation_screen_type" value="add">
                                 <div class="shi_footer">
                                     <button id="ch_to_table" class="done_btn two_variat_add_btn addboth_stk_btn" onclick="addBothNewVariation(this)">Save</button>
                                     <!-- <button id="ch_to_table" class="done_btn v_edit_btn addsingle_stk_btn hide-d" onclick="addNewVariation(this)">Update</button> -->
                                     <!-- <button id="ch_to_table" class="done_btn v_add_btn hide-d" onclick="addAssignNewVariation(this)">Create</button> -->
                                 </div>
                             </form>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>