<!-- Due Date Popup -->
<div class="modal fade twoside_modal" id="duedate" tabindex="-1" role="dialog" aria-labelledby="duedateLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
                    </button>
                    <div class="modal-body">
                        <div class="setup_wrapper">
                            <h2>Set a Due Date</h2>

                            <div class="inner_model_wrapper">
                                
                                <div class="dudate_seter">
                                    <span>Set due date to</span>
                                    <input type="number" class="days_after_due_date" name="" id="" value="{{ (!empty($savedInvloiceAllData['SaleInvoiceSetting']->due_days) ? $savedInvloiceAllData['SaleInvoiceSetting']->due_days : '')}}">
                                    <span>days after Invoice date</span>
                                </div>

                                <div class="com_action">
                                    <button class="nobgc" data-dismiss="modal" aria-label="Close">Cancel</button>
                                    <button class="click_next" data-dismiss="modal" aria-label="Close" onclick="addDateInterval(this)" >Save</button>
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
        