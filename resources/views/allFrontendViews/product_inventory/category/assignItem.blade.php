<style>
    .select2-container {
    /* display: block;
    z-index: 99999999; */
}
</style>       
       <!-- Assign Items -->
        <div class="modal fade twoside_modal same_cr_ec abc_d" id="assignitemsPopup" style="z-index: 999999;" tabindex="-1" role="dialog" aria-labelledby="assignitemsPopupLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close close_asing_btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="shinvite">
                                    <div class="shi_header">
                                        <h5>Assign Items</h5>
                                        <span>
                                            <a href="#" class="blue_purl assign_new_btn"><iconify-icon icon="pajamas:plus"></iconify-icon> Add new item</a>
                                            <a href="#"><iconify-icon icon="ph:info"></iconify-icon></a>
                                        </span>
                                    </div>
                                    <div class="shi_body">
                                        <div class="shw_aprent_dropdown hide-d">
                                        <select class="js-example-placeholder-single-currency show_sub_cate_d assignitems_dropdown hide-d">
                                            <option value="" selected>Select</option>
                                            <option value="1">Category 1</option>
                                        </select>
                                        </div>
                                        <input type="hidden" class="cat_selcted_type" />
                                        <div class="table_view">
                                            <div class="table-responsive">
                                                <table id="" class="table" role="grid">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" style="width: 15%;">Items</th>
                                                            <th scope="col" style="width: 5%;">Quantity</th>
                                                            <th scope="col" style="width: 20%; text-align: right;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="data_assign_item">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" class="category_id_d" value="">
                                    <!-- <div class="shi_footer">
                                        <button id="ch_to_table" class="done_btn" data-dismiss="modal" aria-label="Close">Save</button>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ............................assign item popup -->
        <div class="modal fade twoside_modal same_cr_ec" id="assignNewItemPopup" style="z-index: 9999999;" tabindex="-1" role="dialog" aria-labelledby="manageStockPopupLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close close_newasign_popup" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="shinvite">
                                    <div class="shi_header">
                                        <h5>Assign New Item</h5>
                                        <a href="#"><iconify-icon icon="ph:info"></iconify-icon></a>
                                    </div>
                                    <div class="shi_body">
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                                <select class="js-example-placeholder-single-item asign_item_d" id="listingvc12" name="assign_item">
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" class="cid_d" value="">
                                    <div class="shi_footer">
                                        <button id="ch_to_table" class="done_btn" onclick="assignNewItem(this)">Assign Item</button>
                                    </div>
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
        <script>
            $("body").on("click", ".close_asing_btn", function() {
                $("#assignitemsPopup").modal("hide");
            });

            $("body").on("click", ".assign_new_btn", function() {
                $(".cid_d").val($(".category_id_d").val());
                $.ajax({
                    url: APP_URL + '/api/CatAssignProductList',
                    type: "GET",
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
                            var itemHtml = [];
                            for (var i = 0; i <= response.data.length; i++) {
                                if (response.data[i]?.name != '' && response.data[i]?.name != null && response.data[i]?.name != undefined) {
                                    itemHtml += '<option value="' + response.data[i]?.id + '" >' + response.data[i]?.name + '</option>';
                                }
                            }
                            $(".asign_item_d").empty().append(itemHtml);
                           
                            
                            $("#assignNewItemPopup").modal("show");

                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(response) {
                        block_gui_end();
                        console.log("server side error");
                    }

                });
            });

            $("body").on("click", ".close_newasign_popup", function() {
                $("#assignNewItemPopup").modal("hide");
            });

            function assignNewItem(event) {
                var pid = $(".asign_item_d").val();
                var cid = $(".cid_d").val();

                var form_data = new FormData();
                form_data.append('product_id', pid);
                form_data.append('category_id', cid);
                form_data.append('platform', "Unesync");
                form_data.append('guard', "WEB");
                $.ajax({
                    url: APP_URL + "/api/AddNewItem",
                    data: form_data,
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
                            getAssignItem(cid)
                            $('#assignNewItemPopup').modal('hide');

                        } else {
                            toastr.error(response?.message);
                        }
                    },
                    error: function(response) {
                        block_gui_end();
                        console.log("server side error");
                    }
                });

            }
        </script>
        @endpush