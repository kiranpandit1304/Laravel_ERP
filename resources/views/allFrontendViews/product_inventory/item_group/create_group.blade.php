<!-- Create Item Group - Bottom Full Screen Popup -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css"> -->
<div class="cibsp" id="createItemgroup">
    <div class="cibsp_header">
        <a href="#" class="close_cibsp"><iconify-icon icon="material-symbols:close-rounded"></iconify-icon></a>
        <h2>Create an Item Group</h2>
        <button onclick="creatNewGroup(this)">Save</button>
    </div>
    <div class="mini_continer">
        <div class="cibsp_body">
            <form method="post" action="javascript:void(0)" id="create_item_group_form">
                <div class="inner_model_wrapper">
                    <div class="row">
                        <div class="col-lg-9 col-12">
                            <h4>Details</h4>
                            <div class="form-group">
                                <label>
                                    <input type="text" class="group_item_name" name="name" required="" id="" placeholder="Item Name" />
                                    <span>Item Name</span>
                                </label>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <div class="form-group">
                                        <label>
                                            <input type="text" class="group_sku_d" required="" id="" placeholder="SKU" />
                                            <span>SKU</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-12">
                            <!-- <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type="file" class="prod_group_single_img" id="imageUpload" name="pro_image" accept=".png, .jpg, .jpeg" />
                                    <label for="imageUpload"><iconify-icon icon="material-symbols:edit"></iconify-icon> Edit</label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview" style="background: url(assets/images/image_placeholder.jpg);"></div>
                                </div>
                            </div> -->
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type="file" class="imageUpload prod_group_single_img" name="pro_image" accept=".png, .jpg, .jpeg" />
                                    <a href="#" class="editLink"><iconify-icon class="editIcon" icon="material-symbols:edit"></iconify-icon> Edit</a>
                                </div>
                                <div class="avatar-preview">
                                    <div class="imagePreview iprev" style='background-image: url("{{asset('unsync_assets/assets/images/image_placeholder.jpg')}}")'></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>
                                    <textarea class="group_item_decription" name="" id="" required="" cols="30" rows="10" placeholder="Description"></textarea>
                                    <span>Description</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group image_box">
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
                            </div>
                        </div>
                        <div class="col-lg-12 select-full b-space">
                            <select class="js-example-placeholder-single-currency currency_group_id js-states">
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
                                                    <button type="button" class="normal_btn opencibsp"><iconify-icon icon="ic:round-add"></iconify-icon> Create New Item</button>
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
                                                <tbody class="append_group_item_d">
                                                    <tr class="first_item">
                                                        <td>
                                                            <!-- <div class="form-group end">
                                                                <select class="js-example-placeholder-group-item-list product_item_dp " id="">
                                                                    <option value="">Select Item</option>
                                                                    @if(!empty($allGroupProducts))
                                                                    @foreach($allGroupProducts as $data)
                                                                    <option value="{{@$data->varit_id}}" data-id="1">{{@$data->prod_name}} {{@$data->variation_name}} ({{@$data->quantity}}) </option>
                                                                    @endforeach
                                                                    @endif
                                                                </select>
                                                            </div> -->
                                                            <!-- <div class="form-group end">
                                                                <label for="input-prefetch">Item</label>
                                                                <select class="form-control changeAutoSelect product_item_dp" name="change_select" data-url="{{route('fn.get_item_vairate', $enypt_id)}}" data-noresults-text="Nothing to see here." data-default-value="x123" data-default-text="Default text before change" autocomplete="off"></select>
                                                              
                                                            </div> -->
                                                            <div class="searchInput">
                                                                <input class="grp_item" type="text" placeholder="item">
                                                                <div class="resultBox">
                                                                    <!-- here list are inserted from javascript -->
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td><input class="bundleQty budle_quantity_1" data-id="1" type="text" value="1" /></td>
                                                        <td class="puchase_td"><input class=" db_cost_price cost_price_d_1" disabled type="text" value="0" /></td>
                                                        <td class="sale_td"><input class="db_sale_price sale_price_d_1" disabled type="text" value="0" /></td>
                                                        <td class="al_close" style="width: 2%;">
                                                        </td>
                                                    </tr>
                                                    <tr class="last_fixed">
                                                        <td>Total</td>
                                                        <td>&nbsp;</td>
                                                        <td class="total_cost_d">0</td>
                                                        <td class="total_sale_d">0</td>
                                                        <td class="al_close" style="width: 2%;">
                                                        </td>
                                                    </tr>
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
                                    <button class="normal_btn" type="button" onclick="addCustomGroupItemField(this)"><iconify-icon icon="ic:round-add"></iconify-icon> Add Item/Item Variat to Group</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <market-divider class="market-divider" margin="medium" hydrated=""></market-divider>

                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label>
                                    <input type="text" class="gp_buying_price" required="" id="" placeholder="Buying Price" />
                                    <span>Buying Price</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label>
                                    <input type="text" class="gp_selling_price" required="" id="" placeholder="Selling Price" />
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
                                                <input type="text" class="instail_stock_d" required="" id="" placeholder="Initial stock" />
                                                <span>Initial stock</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" class="available_instail_stock" />
                                <div class="row set_padd">
                                    <div class="col-lg-6">
                                        <div class="form-group end">
                                            <label>
                                                <input type="text" class="group_tax_rate " required="" id="" placeholder="Tax Rate" />
                                                <span>Tax Rate</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group end">
                                            <label>
                                                <input type="text" class="group_hsn " required="" id="" placeholder="HSN" />
                                                <span>HSN</span>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" class="row_index_d" value="2" />
            </form>
        </div>
    </div>
</div>
@push('custom-scripts')
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script> -->

<!-- <script src="https://raw.githack.com/xcash/bootstrap-autocomplete/master/dist/latest/bootstrap-autocomplete.js"></script> -->
<!-- AutoSuggest Search Box -->
<script>
    let suggestions = <?= json_encode($allGroupProducts); ?>;
    // getting all required elements
    const searchInputs = document.querySelectorAll(".searchInput");

    searchInputs.forEach((searchInput, index) => {
        const input = searchInput.querySelector("input");
        const resultBox = searchInput.querySelector(".resultBox");
        const icon = searchInput.querySelector(".icon");
        let linkTag = searchInput.querySelector("a");
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
                searchInput.classList.add("active");
                showSuggestions(emptyArray);
                let allList = resultBox.querySelectorAll("li");
                for (let i = 0; i < allList.length; i++) {
                    allList[i].setAttribute("onclick", `select(${index}, this)`);
                }
            } else {
                searchInput.classList.remove("active");
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
            resultBox.innerHTML = listData;
        }
    });

    function select(index, element) {
        const searchInput = document.querySelectorAll(".searchInput")[index];
        const input = searchInput.querySelector("input");
        const resultBox = searchInput.querySelector(".resultBox");
        input.value = element.textContent;
        var selected_id = element.getAttribute("data-id");
        input.setAttribute("data-id", selected_id);
        searchInput.classList.remove("active");

        console.log('index ', index)
        var pid = parseInt(index) + 1;
        get_productData(selected_id, pid);

    }

    document.addEventListener('click', (e) => {
        const searchInputs = document.querySelectorAll(".searchInput");
        searchInputs.forEach((searchInput) => {
            if (!searchInput.contains(e.target)) {
                searchInput.classList.remove("active");
            }
        });
    });
</script>

<script>
    // Full Screen Popup Open Create Item Group
    $("#opencibsp_group").click(function(e) {
        $(".group_item_name").val('');
        $(".gp_buying_price").val('');
        $(".gp_selling_price").val('');
        $(".instail_stock_d").val('');
        $(".group_tax_rate").val('');
        $(".group_sku_d").val('');
        $(".group_item_decription").val('');
        $(".currency_group_id").val('').change();
        $(".group_hsn").val('');
        $(".product_item_dp").val('').change();
        $(".bundleQty").val('1');
        $(".db_cost_price").val('0');
        $(".db_sale_price").val('0');
        $(".total_cost_d").text('0.00');
        $(".total_sale_d").text('0.00');
        $(".upload__img-box").remove();
        $("#imagePreview").attr("style", " ")
        $(".append_group_item_d").children().not('.first_item').not(".last_fixed").empty();

        $('#createItemgroup').addClass('active');
        $('body').toggleClass('ov_hidden');
    });

    $("a.close_cibsp").click(function(e) {
        $('#createItemgroup').removeClass('active');
    });

    function creatNewGroup(event) {
        // event.preventDefault();
        $(".error").remove();
        if ($(".group_item_name").val().length < 1) {
            $('.group_item_name').after('<span class="error">This field is required</span>');
            return false;
        }

        if ($(".group_item_decription").val().length < 1) {
            $('.group_item_decription').after('<span class="error">This field is required</span>');
            return false;
        }

        if ($(".gp_buying_price").val().length < 1) {
            $('.gp_buying_price').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".gp_selling_price").val().length < 1) {
            $('.gp_selling_price').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".instail_stock_d").val().length < 1) {
            $('.instail_stock_d').after('<span class="error">This field is required</span>');
            return false;
        }
        var current_stk_val = parseInt($(".instail_stock_d").val());
        var available_stock_val = parseInt($(".available_instail_stock").val());

        if (current_stk_val > available_stock_val) {
            $('.instail_stock_d').after('<span class="error">Maximun stock will be ' + available_stock_val + ' </span>');
            return false;
        }

        if ($(".group_tax_rate").val().length < 1) {
            $('.group_tax_rate').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".group_hsn").val().length < 1) {
            $('.group_hsn').after('<span class="error">This field is required</span>');
            return false;
        }

        var formData = new FormData($("#create_item_group_form")[0]);

        formData.append('name', $('.group_item_name').val());
        formData.append('description', $('.group_item_decription').val());
        formData.append('currency', $('.currency_group_id').val());
        formData.append('variation_name', 'Regular');
        formData.append('sku', $('.group_sku_d').val());
        formData.append('purchase_price', $('.gp_buying_price').val());
        formData.append('sale_price', $('.gp_selling_price').val());

        formData.append('tax_rate', $('.group_tax_rate').val());
        formData.append('hsn', $('.group_hsn').val());
        formData.append('group_stock', $('.instail_stock_d').val());
        formData.append('method_type', 1);
        formData.append('is_group', 1);


        $(".grp_item").each(function(index) {
            formData.append('product_id[' + index + ']', $(this).attr("data-id"));
        });
        $(".bundleQty").each(function(index) {
            formData.append('bundle_quantity[' + index + ']', $(this).val());
        });
        $(".db_cost_price").each(function(index) {
            formData.append('total_cost_price[' + index + ']', $(this).val());

        });

        $(".db_sale_price").each(function(index) {
            formData.append('total_selling_price[' + index + ']', $(this).val());
        });

        $.ajax({
            url: APP_URL + '/api/AddGroupProduct',
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
                    $('#createItem').removeClass('active');
                    window.location.reload();
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

<script>
    $("body").on("change", ".product_item_dp", function() {
        // var id = $(this).val();
        var id = $(this).attr("data-id");
        var this_ = $(this);

        get_productData(id, this_);
    });

    function get_productData(id, this_) {
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
                    // var indx_id = this_.select2().find(":selected").data("id");
                    var indx_id = this_;
                    if (response?.data[0]?.purchase_price != '' && response?.data[0]?.purchase_price != undefined && !isNaN(response?.data[0]?.purchase_price))
                        $(".cost_price_d_" + indx_id).val(response?.data[0]?.purchase_price);
                    else
                        $(".cost_price_d_" + indx_id).val('0.00');

                    if (response?.data[0]?.purchase_price != '' && response?.data[0]?.purchase_price != undefined && !isNaN(response?.data[0]?.purchase_price))
                        $(".cost_price_d_" + indx_id).attr("data-db-price", response?.data[0]?.purchase_price);
                    else
                        $(".cost_price_d_" + indx_id).attr("data-db-price", '0.00');

                    if (response?.data[0]?.sale_price != '' && response?.data[0]?.sale_price != undefined && !isNaN(response?.data[0]?.sale_price))
                        $(".sale_price_d_" + indx_id).val(response?.data[0]?.sale_price);
                    else
                        $(".sale_price_d_" + indx_id).val('0.00');

                    if (response?.data[0]?.sale_price != '' && response?.data[0]?.sale_price != undefined && !isNaN(response?.data[0]?.sale_price))
                        $(".sale_price_d_" + indx_id).attr("data-db-price", response?.data[0]?.sale_price);
                    else
                        $(".sale_price_d_" + indx_id).attr("data-db-price", '0.00');

                    var db_stock = response?.data[0]?.quantity
                    $(".budle_quantity_" + indx_id).attr("data-db-stock", db_stock);
                    $(".budle_quantity_" + indx_id).attr("data-inital-stock", db_stock);
                    get_total(indx_id, 1);
                }
            },
            error: function(response) {
                block_gui_end();
                console.log("server side error");
            }
        });
    }



    function addCustomGroupItemField(event) {
        var gp_item_index = $(".row_index_d").val();
        var items = <?= json_encode($allGroupProducts); ?>;
        var custHtml = [];
        custHtml += ' <tr class="gp_rw_id_' + gp_item_index + '" >';
        custHtml += '                               <td>';
        custHtml += '<div class="searchInput">';
        custHtml += '                                               <input class="grp_item" type="text" placeholder="item">';
        custHtml += '                                               <div class="resultBox">';
        custHtml += '                                               </div>';
        custHtml += '                                           </div>';
        custHtml += '                                   </td>';
        // custHtml += '                               <td>';
        // custHtml += '                                   <div class="form-group end">';
        // custHtml += '                                       <select class="js-example-placeholder-group-item-list product_item_dp " id="">';
        // custHtml += '                                           <option value="">Select Item</option>';
        // if (items.length > 0 && items != '' && items != null) {
        //     for (var i = 0; i < items.length; i++) {
        //         custHtml += '<option value="' + items[i]?.varit_id + '"  data-id="' + gp_item_index + '"  >' + items[i]?.prod_name + ' ' + items[i]?.variation_name + ' ( ' + items[i]?.quantity + ' )</option>';
        //     }
        // }
        // custHtml += '                                           </select>';
        // custHtml += '                                      </div>';
        // custHtml += '                                 </td>';
        custHtml += '                               <td><input  class="bundleQty budle_quantity_' + gp_item_index + '"  type="text" value="1"  data-id="' + gp_item_index + '" /></td>';
        custHtml += '                               <td><input class="db_cost_price cost_price_d_' + gp_item_index + '"  type="text" value="0"   disabled data-id="' + gp_item_index + '"  /></td>';
        custHtml += '                               <td><input class=" db_sale_price sale_price_d_' + gp_item_index + '" type="text" value="0" disabled data-id="' + gp_item_index + '"  /></td>';
        custHtml += '                               <td class="al_close" style="width: 2%;">';
        custHtml += '                                   <iconify-icon icon="ic:round-close" onclick="removeCustomGroupItemField(this)" data-id="gp_rw_id_' + gp_item_index + '"></iconify-icon>';
        custHtml += '                                </td>';
        custHtml += '             </tr>';
        $(".append_group_item_d").find(".last_fixed").prev().after(custHtml);


        // ...
        initializeSuggestionInput();
        // ...

        gp_item_index = parseInt(gp_item_index) + 1;
        $(".row_index_d").val(gp_item_index);

        $(".js-example-placeholder-group-item-list").select2({
            placeholder: "Item",
        });
    }

    function removeCustomGroupItemField(event) {

        var indx_row = $(".row_index_d").val();
        indx_row = parseInt(indx_row) - 1;
        var rwid = $(event).attr("data-id");
        $("." + rwid).remove();
        $(".row_index_d").val(indx_row);
        get_total(rwid, 0)
    }

    $("body").on("input", ".bundleQty", function() {
        var indx = $(this).attr("data-id");
        var qty = parseInt($(this).val());
        var db_stock = parseInt($(this).attr("data-db-stock"));
        $(".error").remove();
        if (qty > db_stock) {
            $(this).after('<span class="error">Maximun bundle will be ' + db_stock + ' </span>');
        }
        var single_inital_stock = parseInt(db_stock / qty);

        $(this).attr("data-inital-stock", single_inital_stock);

        var purchase_price = $(".cost_price_d_" + indx);
        var sale_price = $(".sale_price_d_" + indx);

        var buy_Price = parseInt(purchase_price.attr("data-db-price")) * parseInt(qty);

        if (buy_Price != null && buy_Price != '' && buy_Price != NaN && buy_Price != undefined) {
            purchase_price.val(buy_Price);
        }

        var sPrice = parseInt(sale_price.attr("data-db-price")) * parseInt(qty);
        if (sPrice != null && sPrice != '' && sPrice != NaN && sPrice != undefined) {
            sale_price.val(sPrice);
        }




        get_total(indx, qty);

    });

    function get_total(indx, qty) {

        var bundleQty = $(".bundleQty");
        var db_cost_price = $(".db_cost_price");
        var db_sale_price = $(".db_sale_price");

        var total_cost_price = 0;
        for (var k = 0; k < db_cost_price.length; k++) {
            total_cost_price = parseFloat(total_cost_price) + parseFloat(db_cost_price[k]?.getAttribute("data-db-price") * bundleQty[k]?.value);
        }

        if (total_cost_price != null && total_cost_price != '' && total_cost_price != NaN && total_cost_price != undefined) {
            $(".total_cost_d").text(total_cost_price.toFixed(2));
            $(".gp_buying_price").val(total_cost_price.toFixed(2));
        }

        var total_sale_price = 0;
        for (var j = 0; j < db_sale_price.length; j++) {
            total_sale_price = parseFloat(total_sale_price) + parseFloat(db_sale_price[j]?.getAttribute("data-db-price") * bundleQty[j]?.value);
        }
        if (total_sale_price != null && total_sale_price != '' && total_sale_price != NaN && total_sale_price != undefined) {
            $(".total_sale_d").text(total_sale_price.toFixed(2));
            $(".gp_selling_price").val(total_sale_price.toFixed(2));
        }

        var min_stock = 1;
        var vals = bundleQty.map(function() {
            return parseInt($(this).attr('data-inital-stock'), 10) ? parseInt($(this).attr('data-inital-stock'), 10) : null;
        }).get();

        // then find their minimum
        var min_stock = Math.min.apply(Math, vals);
        $(".available_instail_stock").val(min_stock);
        $(".instail_stock_d").val(0);

    }

    $("body").on("input", ".instail_stock_d", function() {
        var current_stk_val = parseInt($(this).val());
        var available_stock_val = parseInt($(".available_instail_stock").val());
        $(".error").remove();

        if (current_stk_val > available_stock_val) {
            $('.instail_stock_d').after('<span class="error">Maximun stock will be ' + available_stock_val + ' </span>');
        }
    });

    function initializeSuggestionInput() {
        let suggestions = <?= json_encode($allGroupProducts); ?>;
        // getting all required elements
        const searchInputs = document.querySelectorAll(".searchInput");

        searchInputs.forEach((searchInput, index) => {
            const input = searchInput.querySelector("input");
            const resultBox = searchInput.querySelector(".resultBox");
            const icon = searchInput.querySelector(".icon");
            let linkTag = searchInput.querySelector("a");
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
                    searchInput.classList.add("active");
                    showSuggestions(emptyArray);
                    let allList = resultBox.querySelectorAll("li");
                    for (let i = 0; i < allList.length; i++) {
                        allList[i].setAttribute("onclick", `select(${index}, this)`);
                    }
                } else {
                    searchInput.classList.remove("active");
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
                resultBox.innerHTML = listData;
            }
        });

        function select(index, element) {
            const searchInput = document.querySelectorAll(".searchInput")[index];
            const input = searchInput.querySelector("input");
            const resultBox = searchInput.querySelector(".resultBox");
            input.value = element.textContent;
            var selected_id = element.getAttribute("data-id");
            input.setAttribute("data-id", selected_id);
            searchInput.classList.remove("active");

            console.log('index ', index)
            var pid = parseInt(index) + 1;
            get_productData(selected_id, pid);
            get_EditProductData(selected_id, pid);

        }

        document.addEventListener('click', (e) => {
            const searchInputs = document.querySelectorAll(".searchInput");
            searchInputs.forEach((searchInput) => {
                if (!searchInput.contains(e.target)) {
                    searchInput.classList.remove("active");
                }
            });
        });
    }
</script>
@endpush