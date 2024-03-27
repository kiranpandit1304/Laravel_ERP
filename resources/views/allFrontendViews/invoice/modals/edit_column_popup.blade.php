<!-- Edit Columns Popup -->
<div class="modal fade twoside_modal" id="editcolumns" tabindex="-1" role="dialog" aria-labelledby="editcolumnsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close colse_column_popup" data-dismiss="modal" aria-label="Close">
                <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
            </button>
            <div class="modal-body">
                <div class="setup_wrapper">
                    <h2>Edit Columns</h2>

                    <div class="inner_model_wrapper">
                        <p>Add new fields or Edit name of fields in the invoice. Use this to add fields like units, hours, service/product specification etc. Also, private columns are not visible to clients and are not part of pdf.</p>

                        <div class="btn_sec">
                            <button type="button" class="addnewcolumnbtn">
                                <svg stroke="#006AFF" fill="#006AFF" stroke-width="0" viewBox="0 0 512 512" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm144 276c0 6.6-5.4 12-12 12h-92v92c0 6.6-5.4 12-12 12h-56c-6.6 0-12-5.4-12-12v-92h-92c-6.6 0-12-5.4-12-12v-56c0-6.6 5.4-12 12-12h92v-92c0-6.6 5.4-12 12-12h56c6.6 0 12 5.4 12 12v92h92c6.6 0 12 5.4 12 12v56z"></path>
                                </svg>
                                Add New Column
                            </button>
                        </div>
                        <div class="columns">
                            <div class="col_head">
                                <ul>
                                    <li></li>
                                    <li>Column Name</li>
                                    <li>Column Type</li>
                                </ul>
                            </div>
                            <div class="col_line last_col_div append_table_col">
                                <div class="space_grag">
                                    <!-- &nbsp; -->
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="text" class="first_item_popup_field dynmic_itm_rw" required="" id="" value="" placeholder="Item">
                                        <span class="first_item_span">Col name</span>
                                    </label>
                                </div>
                                <div class="select_wr">
                                    <select class="js-states form-control nosearch ">
                                        <option value="">TEXT1</option>
                                        <option value="">NUMBER1</option>
                                    </select>
                                </div>
                                <div class="action_btns">
                                    <button class="hide"><iconify-icon icon="ph:eye"></iconify-icon> Hide</button>
                                    <button class="unhide"><iconify-icon icon="ph:eye-slash"></iconify-icon> Unhide</button>
                                </div>
                            </div>
                            <ol id="slippylist" tabindex="0" aria-role="listbox">
                            </ol>

                        </div>

                        <!-- <div class="show_table_head">
                            <div cols="22" class="thead">
                                <span class="th-b six-s itm_th">Item</span>
                                <span class="th-b two-s hsn_th">HSN/SAC</span>
                                <span class="th-b two-s gst_th">GST Rate</span>
                                <span class="th-b two-s qty_th">Quantity</span>
                                <span class="th-b two-s rate_th">Rate</span>
                                <span class="th-b two-s amt_th">Amount</span>
                                <span class="th-b two-s cgst_th">CGST</span>
                                <span class="th-b two-s sgst_th">SGST</span>
                                <span class="th-b two-s totl_th">Total</span>
                            </div>
                            <div cols="22" class="thead" id="listColumnsInPopUp">
                             </div>
                        </div> -->
                        <div class="show_table_head">
                            <div cols="20" class="thead" id="listColumnsInPopUp">

                            </div>
                        </div>
                        <div class="com_action">
                            <button class="nobgc" data-dismiss="modal" id="closeEditColumn" aria-label="Close">Cancel</button>
                            <button class="click_next" id="saveEditColumn">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom-scripts')
<script>

</script>
@endpush