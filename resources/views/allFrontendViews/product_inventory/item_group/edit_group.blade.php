
<!-- View Group Item Offcanvas -->
<div class="offcanvas offcanvas-end big_view" tabindex="-1" id="offcanvasExampleGroupItem" aria-labelledby="offcanvasExampleGroupItemLabel">
    <div class="offcanvas-header">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
            <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
        </button>
        <div class="card-header-toolbar">
            <div class="dropdown">
                <span class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown" aria-expanded="true">
                    <i class="ri-more-fill"></i>
                </span>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton2" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-140px, 24px, 0px);">
                    <!-- <a class="dropdown-item" href="#">Edit Customer</a> -->
                    <!-- <a class="dropdown-item" href="#">Merge with another Customer</a> -->
                    <a class="dropdown-item" href="#">Delete Item</a>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvas_details">
            <div class="item_det">
                <span class="with_btn">
                    <h2>Printed T-shirt</h2>
                    <button class="update_group_btn" type="button" onclick="UpdateGroupItem(this)">Save</button>
                </span>
                <ul class="nav nav-tabs" id="myTab-three" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active tab_btn_d" id="home-tab-three" data-toggle="tab" data-id="form" href="#home-three" role="tab" aria-controls="home" aria-selected="true">Item Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link tab_btn_d" id="profile-tab-three" data-toggle="tab" data-id="trans" href="#profile-three" role="tab" aria-controls="profile" aria-selected="false">Transactions</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent-1">
                    <div class="tab-pane fade show active" id="home-three" role="tabpanel" aria-labelledby="home-tab-three">

                        <form method="post" action="javascript:void(0)" id="edit_item_group_form">
                            <div class="inner_model_wrapper">
                                <div class="row">
                                    <div class="col-lg-9 col-12">
                                        <!-- <h4>Details</h4> -->
                                        <div class="form-group">
                                            <label>
                                                <input type="text" class="edit_group_item_name" name="name" required="" id="" />
                                                <span>Item Name</span>
                                            </label>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-12">
                                                <div class="form-group">
                                                    <label>
                                                        <input type="text" class="edit_group_sku_d" required="" id="" />
                                                        <span>SKU</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-12">
                                        <!-- <div class="avatar-upload">
                                             <div class="avatar-edit">
                                                 <input type="file" class="prod_group_single_img imageUpload" id="imageUpload" name="pro_image" accept=".png, .jpg, .jpeg" />
                                                 <label for="imageUpload"><iconify-icon icon="material-symbols:edit"></iconify-icon> Edit</label>
                                             </div>
                                             <div class="avatar-preview">
                                                 <div id="imagePreview" style="background: url(assets/images/image_placeholder.jpg);"></div>
                                             </div>
                                         </div> -->
                                        <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type="file" class="imageUpload" accept=".png, .jpg, .jpeg" />
                                                <a href="#" class="editLink"><iconify-icon class="editIcon" icon="material-symbols:edit"></iconify-icon> Edit</a>
                                            </div>
                                            <div class="avatar-preview">
                                                <div class="imagePreview iprev edit_image_prev" style="background-image: url(unsync_assets/assets/images/image_placeholder.jpg);"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>
                                                <textarea class="edit_group_item_decription" name="" id="" required="" cols="30" rows="10" placeholder=""></textarea>
                                                <span>Description</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <!-- <div class="form-group image_box">
                                            <label for="">Item Original Images</label>
                                            <div class="upload__box">
                                                <div class="upload__btn-box">
                                                    <label class="upload__btn">
                                                        <p><iconify-icon icon="ic:round-plus"></iconify-icon> Upload images</p>
                                                        <input type="file" name="product_image[]" multiple="" data-max_length="20" class="upload__inputfile multi_group_product_images" />
                                                    </label>
                                                </div>
                                                <div class="upload__img-wrap"></div>
                                            </div>
                                        </div> -->
                                        <div class="od_card last">
                                <div class="od_card_header">
                                    <h3>Item Original Images</h3>
                                    @if(@$has_edit_permission)
                                    <!-- <a href="#" class="edit_btn item_multi_media_card_d" data-type="edit">File Upload</a> -->
                                    @endif
                                </div>
                                <div class="od_card_body">
                                    <div class="dropzone dz-default dz-message" id="desktop_multi_group_item_media">
                                    </div>
                                    <div class="row" id="desktop_group_multi_item_images">
                                    </div>
                                    <div class="form-group">
                                        <ul>
                                            <li class="show_group_db_multi_media">
                                                <div class="file_item">
                                                    <div>
                                                        <span>
                                                            <img src="" alt="">
                                                        </span>
                                                        <h6>No media found</h6>
                                                    </div>
                                                    <div class="iabtn">
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                                    </div>
                                    <!-- </div> -->
                                    <div class="col-lg-12 select-full b-space">
                                        <select class="js-example-placeholder-single-currency edit_currency_group_id js-states">
                                            <option value="" selected>Currency</option>
                                            <option value="1">Indian Rupee(INR, ₹)</option>
                                            <option value="2">US Dollar(USD, $)</option>
                                            <option value="2">Ukrainian Hryvnia(UAH, ₴)</option>
                                        </select>
                                    </div>
                                </div>
                                <market-divider class="market-divider" margin="medium" hydrated=""></market-divider>
                                <div class="row">
                                    <div class="col-lg-12 col-12">
                                    </div>
                                    <div class="row flush-right">
                                        <div class="col-lg-12 flush-right">
                                            <div class="part_gray">
                                                <div class="row">
                                                    <div class="col-lg-12 col-sm-12 col-xs-12">
                                                        <div class="align_search">
                                                            <h6 class="sp_div">Products List</h6>
                                                            <div class="stock_btn">
                                                                <!-- <button class="normal_btn"><iconify-icon icon="ic:round-add"></iconify-icon> Create New Item</button> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table_view">
                                                    <div class="table-responsive">
                                                        <table id="" class="table" role="grid">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" style="width: 10%;">Item</th>
                                                                    <th scope="col" style="width: 10%;">Bundle Quantity</th>
                                                                    <th scope="col" style="width: 7%;">Cost Price</th>
                                                                    <th scope="col" style="width: 10%;">Selling Price</th>
                                                                    <th style="width: 2%;"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="append_edit_group_item_d">

                                                                <!-- table append here -->

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="action_breach small_space">
                                    <div class="row set_padd">
                                        <div class="col-lg-12">
                                            <div class="stock_btn acfield">
                                                <button class="normal_btn" type="button" onclick="addEditCustomGroupItemField(this)"><iconify-icon icon="ic:round-add"></iconify-icon> Add Item/Item Variat to Group</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <market-divider class="market-divider" margin="medium" hydrated=""></market-divider>

                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>
                                                <input type="text" class="edit_gp_buying_price" required="" id="" />
                                                <span>Buying Price</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>
                                                <input type="text" class="edit_gp_selling_price" required="" id="" />
                                                <span>Selling Price</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="initStock">
                                            <h4>Initial stock</h4>
                                            <div class="row set_padd">
                                                <div class="col-lg-12">
                                                    <div class="form-group end">
                                                        <label>
                                                            <input type="text" class="edit_instail_stock_d" required="" id="" />
                                                            <span>Initial stock</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" class="edit_available_instail_stock" />
                                            <div class="row set_padd">
                                                <div class="col-lg-6">
                                                    <div class="form-group end">
                                                        <label>
                                                            <input type="text" class="edit_group_tax_rate " required="" id="" />
                                                            <span>Tax Rate</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group end">
                                                        <label>
                                                            <input type="text" class="edit_group_hsn " required="" id="" />
                                                            <span>HSN</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="edit_row_index_d" value="2" />
                            <input type="hidden" class="edit_variation_id" value="" />
                            <input type="hidden" class="edit_pid" value="" />
                        </form>
                    </div>
                    <div class="tab-pane fade" id="profile-three" role="tabpanel" aria-labelledby="profile-tab-three">
                        <div class="table_view">
                            <div class="table-responsive">
                                <table id="" class="table" role="grid">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width: 10%;">Variation</th>
                                            <th scope="col" style="width: 5%;">Quantity</th>
                                            <th scope="col" style="width: 7%;">Vendor</th>
                                            <th scope="col" style="width: 10%;">Stock</th>
                                            <th scope="col" style="width: 10%;">Reason</th>
                                            <th scope="col" style="width: 10%;">Date</th>
                                            <th scope="col" style="width: 10%;">Custom values</th>
                                        </tr>
                                    </thead>
                                    <tbody id="edit_item_transactional_history_tble">
                                    </tbody>
                                </table>
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
    function UpdateGroupItem(event) {
        // event.preventDefault();
        $(".error").remove();
        if ($(".edit_group_item_name").val().length < 1) {
            $('.edit_group_item_name').after('<span class="error">This field is required</span>');
            return false;
        }

        if ($(".edit_group_item_decription").val().length < 1) {
            $('.edit_group_item_decription').after('<span class="error">This field is required</span>');
            return false;
        }

        if ($(".edit_gp_buying_price").val().length < 1) {
            $('.edit_gp_buying_price').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".edit_gp_selling_price").val().length < 1) {
            $('.edit_gp_selling_price').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".edit_instail_stock_d").val().length < 1) {
            $('.edit_instail_stock_d').after('<span class="error">This field is required</span>');
            return false;
        }
        // var current_stk_val = parseInt($(".edit_instail_stock_d").val());
        // var available_stock_val = parseInt($(".edit_available_instail_stock").val());

        // if (current_stk_val > available_stock_val) {
        //     $('.edit_instail_stock_d').after('<span class="error">Maximun stock will be ' + available_stock_val + ' </span>');
        //     return false;
        // }

       
        var formData = new FormData($("#edit_item_group_form")[0]);

        formData.append('name', $('.edit_group_item_name').val());
        formData.append('description', $('.edit_group_item_decription').val());
        formData.append('currency', $('.edit_currency_group_id').val());
        formData.append('variation_name', 'Regular');
        formData.append('sku', $('.edit_group_sku_d').val());
        formData.append('purchase_price', $('.edit_gp_buying_price').val());
        formData.append('sale_price', $('.edit_gp_selling_price').val());
        formData.append('tax_rate', $('.edit_group_tax_rate').val());
        formData.append('hsn', $('.edit_group_hsn').val());
        formData.append('group_stock', $('.edit_available_instail_stock').val());
        formData.append('method_type', 1);
        formData.append('is_group', 1);
        formData.append('id', $('.edit_pid').val());
        formData.append('variation_id', $('.edit_variation_id').val());


        $(".edit_grp_item").each(function(index) {
            formData.append('product_id[' + index + ']',$(this).attr("data-id"));

        });

        $(".edit_bundleQty").each(function(index) {
            formData.append('bundle_id[' + index + ']', $(this).attr("data-bundle-id"));
        });
        $(".edit_bundleQty").each(function(index) {
            formData.append('bundle_quantity[' + index + ']', $(this).val());
        });
        $(".edit_db_cost_price").each(function(index) {
            formData.append('total_cost_price[' + index + ']', $(this).val());

        });

        $(".edit_db_sale_price").each(function(index) {
            formData.append('total_selling_price[' + index + ']', $(this).val());
        });

      
        var dsk = 0;
        var mb = 0;
        dropzones.forEach(function (dropzone) {

            var element = dropzone.element;
            var cindex = $(element).get(0).id;
            var paramName = dropzone.options;
            var fiels = dropzone.getAcceptedFiles();
            fiels.forEach(function (file, i) {
                if (cindex && cindex == "desktop_multi_group_item_media") {
                    formData.append('product_image[' + dsk + ']', file);
                    dsk++
                }
            });
        });

        $.ajax({
            url: APP_URL + '/api/EditGroupProduct',
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
                    $("#offcanvasExampleGroupItem").offcanvas("hide");

                    ResetFilterItem();

                } else {
                    toastr.error(response?.message)
                }

            },
            error: function(response) {
                block_gui_end();
                console.log("server side error");
            }
        });
    }
</script>
<!-- custom-scripts -->
<script>
    $("body").on("change", ".edit_product_item_dp", function() {
        var id = $(this).val();
        var this_ = $(this);
        $.ajax({
            url: APP_URL + '/api/VariationProductShow/' + id,
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
                if (response.status == true) {
                    var indx_id = this_;
                    $(".edit_cost_price_d_" + indx_id).val(response?.data[0]?.purchase_price);
                    $(".edit_cost_price_d_" + indx_id).attr("data-db-price", response?.data[0]?.purchase_price);
                    $(".edit_sale_price_d_" + indx_id).val(response?.data[0]?.sale_price);
                    $(".edit_sale_price_d_" + indx_id).attr("data-db-price", response?.data[0]?.sale_price);

                    var db_stock = response?.data[0]?.quantity
                    $(".edit_budle_quantity_" + indx_id).val(1);
                    $(".edit_budle_quantity_" + indx_id).attr("data-db-stock", db_stock);
                    $(".edit_budle_quantity_" + indx_id).attr("data-inital-stock", db_stock);
                    get_edit_total(indx_id, 1);
                }
            },
            error: function(response) {
                block_gui_end();
                console.log("server side error");
            }
        });

    });

    function addEditCustomGroupItemField(event) {
        var gp_item_index = $(".edit_row_index_d").val();
        var items = <?= json_encode($allProducts); ?>;
        var custHtml = [];
        custHtml += ' <tr class="edi_gp_rw_id_' + gp_item_index + '" >';

        custHtml += '                                  <td>';
        custHtml += '                                           <div class="searchEditInput">';
        custHtml += '                                               <input class="edit_grp_item" type="text" placeholder="item" value="">';
        custHtml += '                                               <div class="resultEditBox">';
        custHtml += '                                               </div>';
        custHtml += '                                           </div>';
        custHtml += '                                   </td>';
        //  custHtml += '                               <td>';
        //  custHtml += '                                   <div class="form-group end">';
        //  custHtml += '                                       <select class="js-example-placeholder-group-item-list edit_product_item_dp " id="">';
        //  custHtml += '                                           <option value="">Select Item</option>';
        //  if (items.length > 0 && items != '' && items != null) {
        //      for (var i = 0; i < items.length; i++) {
        //          custHtml += '<option value="' + items[i]?.varit_id + '"  data-id="' + gp_item_index + '"  >' + items[i]?.prod_name + ' ' + items[i]?.variation_name + ' ( ' + items[i]?.quantity + ' ) </option>';
        //      }
        //  }
        //  custHtml += '                                           </select>';
        //  custHtml += '                                      </div>';
        //  custHtml += '                                 </td>';
        custHtml += '                               <td><input  class="edit_bundleQty edit_budle_quantity_' + gp_item_index + '"  type="text" value="1"  data-id="' + gp_item_index + '" /></td>';
        custHtml += '                               <td><input class="edit_db_cost_price edit_cost_price_d_' + gp_item_index + '"  type="text" value="0"   disabled data-id="' + gp_item_index + '"  /></td>';
        custHtml += '                               <td><input class=" edit_db_sale_price edit_sale_price_d_' + gp_item_index + '" type="text" value="0" disabled data-id="' + gp_item_index + '"  /></td>';
        custHtml += '                               <td class="al_close" style="width: 2%;">';
        custHtml += '                                   <iconify-icon icon="ic:round-close" onclick="removeEditCustomGroupItemField(this)" data-id="edi_gp_rw_id_' + gp_item_index + '"></iconify-icon>';
        custHtml += '                                </td>';
        custHtml += '             </tr>';
        $(".append_edit_group_item_d").find(".last_fixed").prev().after(custHtml);

        gp_item_index = parseInt(gp_item_index) + 1;
        $(".edit_row_index_d").val(gp_item_index);

         initializeEditSuggestionInput();
    }

    function removeEditCustomGroupItemField(event) {
        var indx_row = $(".edit_row_index_d").val();
        indx_row = parseInt(indx_row) - 1;
        var rwid = $(event).attr("data-id");
        $("." + rwid).remove();
        $(".edit_row_index_d").val(indx_row);
        get_edit_total(rwid, 0)
    }

    $("body").on("input", ".edit_bundleQty", function() {
        var indx = $(this).attr("data-id");
        var qty = $(this).val();
        var db_stock = $(this).attr("data-db-stock");
        var single_inital_stock = parseInt(db_stock / qty);

        $(this).attr("data-inital-stock", single_inital_stock);

        var purchase_price = $(".edit_cost_price_d_" + indx);
        var sale_price = $(".edit_sale_price_d_" + indx);

        var buy_Price = parseInt(purchase_price.attr("data-db-price")) * parseInt(qty);

        if (buy_Price != null && buy_Price != '' && buy_Price != NaN && buy_Price != undefined) {
            purchase_price.val(buy_Price);
        }

        var sPrice = parseInt(sale_price.attr("data-db-price")) * parseInt(qty);
        if (sPrice != null && sPrice != '' && sPrice != NaN && sPrice != undefined) {
            sale_price.val(sPrice);
        }

        get_edit_total(indx, qty);

    });

    function get_edit_total(indx, qty) {

        var edit_bundleQty = $(".edit_bundleQty");
        var edit_db_cost_price = $(".edit_db_cost_price");
        var edit_db_sale_price = $(".edit_db_sale_price");

        var total_cost_price = 0;
        for (var k = 0; k < edit_db_cost_price.length; k++) {
            total_cost_price = parseFloat(total_cost_price) + parseFloat(edit_db_cost_price[k]?.getAttribute("data-db-price") * edit_bundleQty[k]?.value);
        }

        if (total_cost_price != null && total_cost_price != '' && total_cost_price != NaN && total_cost_price != undefined) {
            $(".edit_total_cost_d").text(total_cost_price);
            $(".edit_gp_buying_price").val(total_cost_price);
        }

        var total_sale_price = 0;
        for (var j = 0; j < edit_db_sale_price.length; j++) {
            total_sale_price = parseFloat(total_sale_price) + parseFloat(edit_db_sale_price[j]?.getAttribute("data-db-price") * edit_bundleQty[j]?.value);
        }
        if (total_sale_price != null && total_sale_price != '' && total_sale_price != NaN && total_sale_price != undefined) {
            $(".edit_total_sale_d").text(total_sale_price);
            $(".edit_gp_selling_price").val(total_sale_price);
        }
        // #Set initail stock
        var min_stock = 0;
        var vals = edit_bundleQty.map(function() {
            return parseInt($(this).attr('data-inital-stock'), 10) ? parseInt($(this).attr('data-inital-stock'), 10) : null;
        }).get();

        var min_stock = Math.min.apply(Math, vals);
        $(".edit_available_instail_stock").val(min_stock);
        $(".edit_instail_stock_d").val(min_stock);

    }

    $("body").on("input", ".edit_instail_stock_d", function() {
        var current_stk_val = parseInt($(this).val());
        var available_stock_val = parseInt($(".edit_available_instail_stock").val());
        $(".error").remove();

        if (current_stk_val > available_stock_val) {
            $('.edit_instail_stock_d').after('<span class="error">Maximun stock will be ' + available_stock_val + ' </span>');
        }
    });

    $("body").on("click", ".tab_btn_d", function() {
        val = $(this).attr("data-id");
        if (val === 'form') {
            $(".update_group_btn").removeClass("hide-d");
        } else if (val === 'trans') {
            $(".update_group_btn").addClass("hide-d");
        }
    });

    function Editselect(index, element) {
            const searchEditInput = document.querySelectorAll(".searchEditInput")[index];
            const input = searchEditInput.querySelector("input");
            const resultEditBox = searchEditInput.querySelector(".resultEditBox");
            input.value = element.textContent;
            var selected_id = element.getAttribute("data-id");
            input.setAttribute("data-id", selected_id);
            searchEditInput.classList.remove("active");

            var edit_pid = parseInt(index) + 1;
            // var edit_pid = parseInt(index);
            console.log("edit_pid", edit_pid)
            get_EditProductData(selected_id, edit_pid);

        }

    function initializeEditSuggestionInput() {
        let suggestions = <?= json_encode($allProducts); ?>;
        // getting all required elements
        const searchEditInputs = document.querySelectorAll(".searchEditInput");

       

        searchEditInputs.forEach((searchEditInput, index) => {
            const input = searchEditInput.querySelector("input");
            const resultEditBox = searchEditInput.querySelector(".resultEditBox");
            const icon = searchEditInput.querySelector(".icon");
            let linkTag = searchEditInput.querySelector("a");
            let webLink;

            // if user press any key and release
            input.addEventListener('keyup', (e) => {
                let userData = e.target.value; //user entered data
                let emptyArray = [];
                if (userData) {
                    emptyArray = suggestions?.filter((data) => {
                        if (data?.prod_name?.toLocaleLowerCase().startsWith(userData?.toLocaleLowerCase()))
                            return data?.prod_name?.toLocaleLowerCase().startsWith(userData?.toLocaleLowerCase());
                    });
                    emptyArray = emptyArray.map((data) => {
                        return data = '<li data-id="' + data?.varit_id + '" >' + data?.prod_name + ' ' + data?.variation_name + ' (' + data?.quantity + ')</li>';
                    });
                    searchEditInput.classList.add("active");
                    showSuggestions(emptyArray);
                    let allList = resultEditBox.querySelectorAll("li");
                    for (let i = 0; i < allList.length; i++) {
                        allList[i].setAttribute("onclick", `Editselect(${index}, this)`);
                    }
                } else {
                    searchEditInput.classList.remove("active");
                }
            });

            function showSuggestions(list) {
                let listData;
                if (!list.length) {
                    userValue = input.value;
                    listData = '<li>' + userValue + '</li>';
                } else {
                    listData = list.join('');
                }
                resultEditBox.innerHTML = listData;
            }
        });

       

        document.addEventListener('click', (e) => {
            const searchEditInputs = document.querySelectorAll(".searchEditInput");
            searchEditInputs.forEach((searchEditInput) => {
                if (!searchEditInput.contains(e.target)) {
                    searchEditInput.classList.remove("active");
                }
            });
        });
    }

    function get_EditProductData(id, this_) {
        // var this_ = $(event);
        $.ajax({
            url: APP_URL + '/api/VariationProductShow/' + id,
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
                if (response.status == true) {
                    // var indx_id = this_.select2().find(":selected").data("id"); edit_budle_quantity_
                    var indx_id = this_;
                    console.log('edit_indx_id ', indx_id);
                    $(".edit_cost_price_d_" + indx_id).val(response?.data[0]?.purchase_price);
                    $(".edit_cost_price_d_" + indx_id).attr("data-db-price", response?.data[0]?.purchase_price);
                    $(".edit_sale_price_d_" + indx_id).val(response?.data[0]?.sale_price);
                    $(".edit_sale_price_d_" + indx_id).attr("data-db-price", response?.data[0]?.sale_price);

                    var db_stock = response?.data[0]?.quantity
                    $(".edit_budle_quantity_" + indx_id).attr("data-db-stock", db_stock);
                    $(".edit_budle_quantity_" + indx_id).attr("data-inital-stock", db_stock);
                    get_total(indx_id, 1);
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