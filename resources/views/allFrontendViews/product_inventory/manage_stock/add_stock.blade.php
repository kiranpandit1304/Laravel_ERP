<!-- Add Manage Stock -->
<div class="modal fade twoside_modal same_cr_ec" id="manageStockPopup" tabindex="-1" role="dialog" aria-labelledby="manageStockPopupLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close close_stk_alert" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <form action="javascript:void(0)" id="manageVariationForm_d" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="shinvite">
                                <div class="shi_header">
                                    <h5>Manage Stock alert</h5>
                                    <a href="#"><iconify-icon icon="ph:info"></iconify-icon></a>
                                </div>
                                <div class="shi_body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group qspan">
                                                <label>
                                                    <input type="number" class="varit_updated_low_qty" placeholder="Quantity" />
                                                    <span>Quantity</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" class="edit_varit_id" value="" />

                                <div class="shi_footer">
                                    <button id="ch_to_table" class="done_btn" onclick="UpdateStocklaert(this)">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
