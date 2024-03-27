@extends('allFrontendViews.layouts.app')
@section('page-title')
{{__('Customer')}}
@endsection
@push('css-page')
<link href="{{asset('/assets/js/plugins/dropzone/css/dropzone.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 flush">
            <div class="page_head">
                <div class="actions_bar">
                    <div class="filter_main">
                        <span class="bg_darkblu squre_icon"><iconify-icon icon="icon-park-outline:ad-product"></iconify-icon></span>

                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" id="opencreatebrand" class="scta"><iconify-icon icon="ep:setting"></iconify-icon> Create Brands</button>
                            <button type="button" id="opencreatecategory" class="scta"><iconify-icon icon="ep:setting"></iconify-icon> Create Category</button>
                        </div>
                    </div>
                    @if(@$has_edit_permission)
                    <div class="action_btns">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#importPopup"><iconify-icon icon="pajamas:import"></iconify-icon> Import Item</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#exportPopup"><iconify-icon icon="pajamas:export"></iconify-icon> Export Item</a>
                                </li>
                            </ul>
                        </div>
                        <!-- <button class="subcta" type="button" data-toggle="modal" data-target="#importPopup"><iconify-icon icon="pajamas:import"></iconify-icon> Import Item</button>
                        <button class="subcta" type="button" data-toggle="modal" data-target="#exportPopup"><iconify-icon icon="pajamas:export"></iconify-icon> Export Item</button> -->
                        <button class="scta adj_space" id="opencibsp_group" type="button"><iconify-icon icon="system-uicons:cubes" width="22" height="22"></iconify-icon> Create Item Group</button>
                        <button type="button" class="opencibsp" id="opencibsp"><iconify-icon icon="pajamas:plus"></iconify-icon> Create Item</button>
                    </div>
                    @endif
                </div>
            </div>
            <div id="comn_wrapper">
                <div class="table_card">
                    <div class="thead">
                        <div class="row justify-content-between">
                            <div class="col-sm-6 col-md-6">
                                <div id="user_list_datatable_info" class="dataTables_filter">
                                    <!-- <h2>Customer Management</h2> -->
                                    <div class="align_fil">
                                        <div class="low_stalert">
                                            <!-- <span class="stock_alert" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Stock Alert"><iconify-icon icon="ion:alert-outline"></iconify-icon></span> -->
                                            <select class="js-states form-control nosearch inventory_topbar_filter" id="listi1" onchange="applyfillter(this)" name="list">
                                                <option value="">All Inventory</option>
                                                <option value="1">Low stock alert</option>
                                                <option value="2">Sold out</option>
                                            </select>
                                        </div>
                                        <form class="mr-3 position-relative">
                                            <div class="form-group mb-0">
                                                <input type="search" class="form-control product_sch" id="search_field_filter" placeholder="Search" aria-controls="user-list-table" />
                                                <iconify-icon icon="carbon:search" class="item_search_btn" onclick="filterProductItem(this)"></iconify-icon>
                                                <iconify-icon class="item_search_reset_btn hide-d" icon="system-uicons:reset" onclick="ResetFilterItem(this)"></iconify-icon>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- <div class="show_check">
                                        <button class="export">Export Selected Item(s)</button>
                                        <button class="delete">Delete</button>
                                        <span>1 Item Selected</span>
                                    </div> -->
                                    @if(@$has_edit_permission)
                                    <div class="show_check">
                                        <form action="{{url('/api/SelectedProduct/Export', $enypt_id)}}" id="mulislectedCusExport" method="post">
                                            <div class="hiden_cust_export_val"></div>
                                            <button type="submit" class="export " data-url="{{url('/api/ProductPdf')}}">Export Selected Item(s)</button>
                                        </form>
                                        <button class="delete selected_user_delete">Delete</button>
                                        <span class="selected_count">0 Item Selected</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="user-list-files d-flex">
                                    <a class="bg-primary" data-bs-toggle="offcanvas" href="#offcanvasFilter" role="button" aria-controls="offcanvasFilter"> <iconify-icon icon="material-symbols:filter-alt-outline"></iconify-icon> Filter </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="product_table_listing">
                        <?php echo $response['content']; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@section('modals')

<!-- Create Brand - Bottom Full Screen Popup -->
@include('allFrontendViews.product_inventory.brand.index')
<!-- Create Category - Bottom Full Screen Popup -->

@include('allFrontendViews.product_inventory.category.index')
<!-- Filter Product Offcanvas -->
@include('allFrontendViews.product_inventory.filter')
<!-- Import Popup -->
@include('allFrontendViews.product_inventory.import')
<!-- ExportModel -->
@include('allFrontendViews.product_inventory.export')

<!-- manage variration -->
<!-- Create Group - Bottom Full Screen Popup -->
@include('allFrontendViews.product_inventory.item_group.create_group')
<!-- Edit Group - Bottom Full Screen Popup -->
@include('allFrontendViews.product_inventory.item_group.edit_group')
<!-- Create Item - Bottom Full Screen Popup -->
@include('allFrontendViews.product_inventory.create_item')


<!-- Add Variation -->
@include('allFrontendViews.product_inventory.variation.index')
<!-- Add Manage Stock -->
@include('allFrontendViews.product_inventory.manage_stock.add_stock')

<!-- Add Manage Variation Stock -->
@include('allFrontendViews.product_inventory.manage_stock.manage_variation')
<!-- Adjust Stock -->
@include('allFrontendViews.product_inventory.manage_stock.index')
<!-- Edit Items Offcanvas -->
@include('allFrontendViews.product_inventory.edit_item')
<!-- Confirm Stock -->
@include('allFrontendViews.product_inventory.manage_stock.confirm_stock')


@endsection

@endsection


@push('custom-scripts')

<script type="text/javascript" src="{{asset('/assets/js/plugins/dropzone/dropzone.min.js')}}"></script>
<script src="{{asset('js/custom/product_services.js')}}"></script>
<script>
    function getBrandCategories() {
        $.ajax({
            url: APP_URL + '/api/CategoryList',
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
                    // $(".options-list").empty().append(itemHtml);
                    var lastItem = response.data.shift();
                    $(".category_d").attr('data-value', lastItem?.id);
                    $("#searchInputCategory").val(lastItem?.name);

                } else {
                    toastr.error(response.message);
                }
            },
            error: function(response) {
                block_gui_end();
                console.log("server side error");
            }
        });

    }

    // Custom Dropdown 3 dots
    $("body").on("click", "a#customdropdown1", function(event) {
        event.stopPropagation();
        var id = $(this).attr("data-id");
        $(".offcanvasItemEditBtn").attr("data-id", id)
        $(".delete_product").attr("data-id", id)
        $(".duplicate_item").attr("data-id", id)
        $(".customdropdown2").toggleClass("active");
    });

    $(document).click(function() {
        $(".customdropdown2").removeClass("active");
    });

    $("body").on("click", ".duplicate_item", function() {

        var id = $(this).attr('data-id');
        $.ajax({
            url: APP_URL + '/api/ProductShow/' + id,
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
                    $('.item_name').val(response?.data?.name);
                    $('.description').val(response?.data?.description);
                    $('.brand_id').val(response?.data?.brand_id).change();
                    $('.dropdownSearchCategory').val(response?.data?.category_id);
                    $(".category_d").attr('data-value', response.data?.id);
                    $("#searchInputCategory").val(response.data?.catName);
                    $('.currency_id').val(response?.data?.currency).change();
                    $('.fst_sku_d').val(response?.productVariation[0]?.sku);
                    $('.fst_purchase_price_d').val(response?.productVariation[0]?.purchase_price);
                    $('.fst_sale_price_d').val(response?.productVariation[0]?.sale_price);
                    $('.fst_tax_rate_d').val(response?.productVariation[0]?.tax_rate);
                    $('.fst_hsn_d').val(response?.productVariation[0]?.hsn);
                    $('.fst_unit_id').val(response?.productVariation[0]?.unit_id).change();
                    $('.is_duplicate').val("true");


                    $(".form_view").addClass("deactive");
                    $(".mstk_btn").addClass("hide-d")
                    $(".variation_list").empty();
                    if (response?.productVariation != null && response?.productVariation != '' && response?.productVariation != undefined && response?.productVariation.length > 0) {
                        var variationHtml = [];
                        for (var i = 0; i <= response?.productVariation.length; i++) {
                            if (response?.productVariation[i]?.variation_name != '' && response?.productVariation[i]?.variation_name != undefined && response?.productVariation[i]?.variation_name != null) {


                                variationHtml += ' <tr class="variat_rw_' + response?.productVariation[i]?.id + '">';
                                variationHtml += ' <td >';
                                variationHtml += '     <div class="sd_check">';
                                // if (response?.data?.id != '')
                                //     variationHtml += '         <input type="checkbox" class="variat_checkItem"  value="' + response?.productVariation[i]?.id + '" id="mtb_' + response?.productVariation[i]?.id + '" />';
                                // else
                                variationHtml += '         <input type="checkbox" class="variation_d variat_checkItem"  value="' + response?.productVariation[i]?.id + '" id="mtb_' + response?.productVariation[i]?.id + '" />';

                                variationHtml += '         <label class="pull-right text" for="mtb_' + response?.productVariation[i]?.id + '">&nbsp;</label>';
                                variationHtml += '     </div>';
                                variationHtml += ' </td>';
                                variationHtml += ' <td class="variation_col" >' + response?.productVariation[i]?.variation_name + '</td>';
                                variationHtml += ' <td class="sku_col" >' + response?.productVariation[i]?.sku + '</td>';
                                variationHtml += ' <td class="purchase_col" >' + response?.productVariation[i]?.purchase_price + '</td>';
                                variationHtml += ' <td class="sale_col " >' + response?.productVariation[i]?.sale_price + '</td>';
                                variationHtml += ' <td class="tax_col " >' + response?.productVariation[i]?.tax_rate + '</td>';
                                variationHtml += ' <td class="tax_col" >' + response?.productVariation[i]?.unitName + '</td>';

                                variationHtml += ' <td class="stock_col" >';
                                variationHtml += '     <div class="action_btn_a">';
                                variationHtml += '         <a href="#" class="edit_cta manage_stock_btn" data-id="' + response?.data?.id + '"  data-varit-name="' + response?.data?.variation_name + '"  data-toggle="tooltip" data-placement="top" data-original-title="Edit"><iconify-icon icon="material-symbols:edit"></iconify-icon> Manage </a>';
                                variationHtml += '     </div>';
                                variationHtml += ' </td>';
                                if (has_edit_permission != '' && has_edit_permission != null && has_edit_permission != undefined) {
                                    variationHtml += ' <td class="" >';
                                    variationHtml += '     <div class="action_btn_a">';
                                    variationHtml += '         <a href="#" class="edit_cta show_edit_variation_modal" data-id="' + response?.productVariation[i]?.id + '" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><iconify-icon icon="material-symbols:edit"></iconify-icon> Edit </a>';
                                    variationHtml += '         <a class="delete_variation" href="#"   data-id="' + response?.productVariation[i]?.id + '" style="color: brown;">Delete</a>';
                                    variationHtml += '     </div>';
                                    variationHtml += ' </td>';
                                }
                                variationHtml += '</tr>';
                            }
                        }
                        $(".variation_list").empty().append(variationHtml);
                        $(".cretetable").css("display", "block");
                    }

                    $('#createItem').addClass('active');

                } else {
                    toastr.error(response.message);
                }

            },
            error: function(response) {
                block_gui_end();
                console.log("server side error");
            }
        });

        // $('#createItem').addClass('active');

    });


    //    ..............................Create Item SECTION START.................................
    $('body').on('click', '.product_pagination a', function(e) {
        e.preventDefault();
        $('#load a').css('color', '#dfecf6');
        $('#load').append('<img style="position: absolute; left: 0; top: 0; articles/listingz-index: 100000;" src="/images/loading.gif" />');
        var url = $(this).attr('href');
        var page_number = get_parameter_val("page", url);
        var url = window.location.href;
        var url = updateQueryStringParameter(url, "page", page_number);
        ReseProductItemPage('', page_number);
        window.history.pushState("", "", url);
    });

    function ReseProductItemPage(search = '', page_number = '') {
        var bdUrl = <?= json_encode(route('fn.inventory', $enypt_id)) ?> + '?search=' + search + '&page=' + page_number;
        $.ajax({
            url: bdUrl,
            // type: "GET",
            dataType: 'json',
            beforeSend: function(xhr) {
                block_gui_start();

            },
            success: function(response) {
                block_gui_end();
                $('#product_table_listing').html(response?.content);
                window.history.pushState('page1', 'Product', bdUrl);
            },
            error: function(response) {
                block_gui_end();
                console.log("server side error");
            }
        });
    }

    $(document).on('keypress', ".product_sch", function(e) {
        if (e.which == 13) {
            e.preventDefault();
            var search = $("#search_field_filter").val();
            ReseProductItemPage(search);
        }
    });


    function filterProductItem() {
        var search = $("#search_field_filter").val();
        ReseProductItemPage(search);
        $(".item_search_btn").addClass("hide-d");
        $(".item_search_reset_btn").removeClass("hide-d");
    };

    function ResetFilterItem() {
        $("#search_field_filter").val('');
        $(".item_search_reset_btn").addClass("hide-d");
        $(".item_search_btn").removeClass("hide-d");
        ReseProductItemPage();
    }

    $("body").on("click", ".update_stock_status", function() {
        var pro_id = $(this).attr("data-id");
        var formData = new FormData();
        formData.append('id', pro_id);
        formData.append('is_manage_stock', $("#is_manage_stock_d_" + pro_id).is(":checked") ? 1 : 0);
        $.ajax({
            url: APP_URL + "/api/ProductManageStockUpdate",
            type: "post",
            data: formData,
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
                    ResetFilterItem();
                    toastr.success(response.message);
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
    $(".opencibsp").click(function(e) {
        $(".item_name").val('');
        $(".description").val('');
        $(".currency_id").val('').change();
        $(".brand_id").val('').change();
        $(".category_id").val('');
        $(".variation_list").empty();

        // $(".fst_variation_name_d").val('');
        $(".fst_sku_d").val('');
        $(".fst_purchase_price_d").val('');
        $(".fst_sale_price_d").val('');
        $(".fst_tax_rate_d").val('');
        $(".fst_hsn_d").val('');


        $(".variation_screen_type").val("add");
        $(".variation_name_d").val('');
        $(".sku_d").val('');
        $(".purchase_price_d").val('');
        $(".sale_price_d").val('');
        $(".tax_rate_d").val('');
        $(".hsn_d").val('');
        $(".unit_id").val('').change();
        $(".vid").val('');

        $(".cretetable ").css("display", "none");
        $(".form_view").removeClass("deactive");
        $(".mstk_btn").removeClass("hide-d");
        $(".fst_btn").removeClass("hide-d");
        $(".show_variation_btn").addClass("hide-d");
        $(".is_duplicate").val("false");
        // getBrandCategories();
        $('#createItem').addClass('active');
    });
    $("a.close_cibsp").click(function(e) {
        $('#createItem').removeClass('active');
        $(".is_duplicate").val("false");

    });

    $("body").on("click", ".creatNewItem_d", function() {
        // function creatNewItem(event) {
        event.preventDefault();
        $(".error").remove();
        if ($(".item_name").val().length < 1) {
            $('.item_name').after('<span class="error">This field is required</span>');
            return false;
        }

        if ($(".description").val().length < 1) {
            $('.description').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".fst_variation_name_d").val().length < 1) {
            $('.fst_variation_name_d').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".fst_purchase_price_d").val().length < 1) {
            $('.fst_purchase_price_d').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".fst_sale_price_d").val().length < 1) {
            $('.fst_sale_price_d').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".fst_tax_rate_d").val().length < 1) {
            $('.fst_tax_rate_d').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".fst_hsn_d").val().length < 1) {
            $('.fst_hsn_d').after('<span class="error">This field is required</span>');
            return false;
        }

        var formData = new FormData($("#create_item_form")[0]);
        $(".variation_d").each(function(index) {
            formData.append('variation_id[' + index + ']', $(this).val());
        });

        formData.append('category_id', $('.category_d').attr("data-value"));
        formData.append('variation_name', $('.fst_variation_name_d').val());
        formData.append('sku', $('.fst_sku_d').val());
        formData.append('purchase_price', $('.fst_purchase_price_d').val());
        formData.append('sale_price', $('.fst_sale_price_d').val());
        formData.append('tax_rate', $('.fst_tax_rate_d').val());
        formData.append('hsn', $('.fst_hsn_d').val());
        formData.append('unit_id', $('.fst_unit_id').val());

        $.ajax({
            url: APP_URL + '/api/ProductAdd',
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
    });

    function mapItemGroupEditValues(response) {

        $('.edit_pid').val(response?.data?.id);
        $('.edit_variation_id').val(response?.data?.variation_id);
        $('.edit_group_item_name').val(response?.data?.name);
        $('.edit_group_sku_d').val(response?.data?.vsku);
        $('.edit_group_item_decription').val(response?.data?.description);
        $('.edit_currency_group_id').val(response?.data?.currency).change();
        $('.edit_gp_buying_price').val(response?.data?.vpurchase_price);
        $('.edit_gp_selling_price').val(response?.data?.vsale_price);
        $('.edit_instail_stock_d').val(response?.data?.group_stock);
        $('.edit_group_tax_rate').val(response?.data?.tax_rate);
        $('.edit_group_hsn').val(response?.data?.hsn);
        var rowID = parseInt(response?.AdjustmentItem.length) + 1;
        $(".edit_row_index_d").val(rowID);
        var items = <?= json_encode($allProducts); ?>;
        // $(".append_edit_group_item_d").find(".last_fixed").prev().empty();
        if (response?.AdjustmentItem != null && response?.AdjustmentItem != '' && response?.AdjustmentItem != undefined && response?.AdjustmentItem.length > 0) {
            var custHtml = [];
            var totalCost = 0;
            var totalSale = 0;
            for (var k = 0; k <= response?.AdjustmentItem.length; k++) {
                if (response?.AdjustmentItem[k]?.id != '' && response?.AdjustmentItem[k]?.id != undefined && response?.AdjustmentItem[k]?.id != null) {
                    var resData = response?.AdjustmentItem[k];
                    var db_stock = response?.AdjustmentItem[k]?.quantity;
                    var rwID = k + 1;
                    custHtml += ' <tr class="edi_gp_rw_id_' + rwID + '" >';

                    custHtml += '                               <td>';
                    custHtml += '<div class="searchEditInput">';
                    custHtml += '                                               <input class="edit_grp_item" type="text" disabled placeholder="item" data-id="' + response?.AdjustmentItem[k]?.id + '" value="' + response?.AdjustmentItem[k]?.prod_name + ' ' + response?.AdjustmentItem[k]?.variation_name + '">';
                    custHtml += '                                               <div class="resultEditBox">';
                    custHtml += '                                               </div>';
                    custHtml += '                                           </div>';
                    custHtml += '                                   </td>';

                    // custHtml += '                               <td>';
                    // custHtml += '                                   <div class="form-group end">';
                    // custHtml += '                                       <select class="js-example-placeholder-group-item-list edit_product_item_dp " id="">';
                    // custHtml += '                                           <option value="">Select Item</option>';
                    // if (items.length > 0 && items != '' && items != null) {
                    //     for (var j = 0; j < items.length; j++) {
                    //         if (items[j]?.varit_id == resData?.variation_id)
                    //             custHtml += '<option value="' + items[j]?.varit_id + '" selected data-id="' + rwID + '"  >' + items[j]?.prod_name + ' ' + items[j]?.variation_name + ' ( ' + items[j]?.quantity + ' ) </option>';
                    //         else
                    //             custHtml += '<option value="' + items[j]?.varit_id + '"  data-id="' + rwID + '"  >' + items[j]?.prod_name + ' ' + items[j]?.variation_name + '</option>';
                    //     }
                    // }
                    // custHtml += '                                           </select>';
                    // custHtml += '                                      </div>';
                    // custHtml += '                                 </td>';

                    // custHtml += '                               <td>';
                    custHtml += '                                          <div class="searchInput">';
                    custHtml += '                                               <input class="" type="text" placeholder="item" value="">';
                    custHtml += '                                               <div class="resultBox">';
                    custHtml += '                                               </div>';
                    custHtml += '                                           </div>';
                    custHtml += '                                   </td>';
                    custHtml += '                               <td><input  class="edit_bundleQty edit_budle_quantity_' + rwID + '" data-bundle-id="' + resData?.id + '" data-variat-id="' + resData.variation_id + '" data-db-stock="' + db_stock + '", db_stock  type="text" value="' + resData?.bundle_quantity + '"  data-id="' + rwID + '" /></td>';
                    custHtml += '                               <td><input class="edit_db_cost_price edit_cost_price_d_' + rwID + '" data-db-price="' + resData?.purchase_price + '"  type="text" value="' + resData?.total_cost_price + '"   disabled data-id="' + rwID + '"  /></td>';
                    custHtml += '                               <td><input class="edit_db_sale_price edit_sale_price_d_' + rwID + '" data-db-price="' + resData?.sale_price + '" type="text" value="' + resData?.total_selling_price + '" disabled data-id="' + rwID + '"  /></td>';
                    custHtml += '                               <td class="al_close" style="width: 2%;">';
                    custHtml += '                                   <iconify-icon icon="ic:round-close" onclick="removeEditCustomGroupItemField(this)" data-id="edi_gp_rw_id_' + rwID + '"></iconify-icon>';
                    custHtml += '                                </td>';
                    custHtml += '             </tr>';

                    totalCost = parseFloat(totalCost) + parseFloat(resData?.total_cost_price);
                    totalSale = parseFloat(totalSale) + parseFloat(resData?.total_selling_price);



                }
            }
            custHtml += ' <tr class="last_fixed">';
            custHtml += '                                                          <td>Total</td>';
            custHtml += '                                            <td>&nbsp;</td>';
            custHtml += '                                            <td class="edit_total_cost_d">' + totalCost + '</td>';
            custHtml += '                                            <td class="edit_total_sale_d">' + totalSale + '</td>';
            custHtml += '                                            <td class="al_close" style="width: 2%;">';
            custHtml += '                                            </td>';
            custHtml += '                                        </tr>';
            $(".append_edit_group_item_d").empty().append(custHtml);
        }


        if (response?.mediaGet != null && response?.mediaGet != '' && response?.mediaGet != undefined && response?.mediaGet.length > 0) {
            var mediaGetHtml = [];
            for (var i = 0; i <= response?.mediaGet.length; i++) {
                if (response?.mediaGet[i]?.product_image != '' && response?.mediaGet[i]?.product_image != undefined && response?.mediaGet[i]?.product_image != null) {
                    mediaGetHtml += '<li class="md_multi_row_' + response?.mediaGet[i]?.id + '">';
                    mediaGetHtml += '<div class="file_item">';
                    mediaGetHtml += ' <div>';
                    mediaGetHtml += '       <span>';
                    mediaGetHtml += '        <img src="' + response?.mediaGet[i]?.product_image + '" alt=""> ';
                    mediaGetHtml += '     </span>';
                    mediaGetHtml += '    <a href=" ' + response?.mediaGet[i]?.product_image + '" target="_blank" > <h6>' + response?.mediaGet[i]?.product_image_name + '</h6> </a>';
                    mediaGetHtml += ' </div>';

                    if (has_edit_permission != '' && has_edit_permission != null && has_edit_permission != undefined) {
                        mediaGetHtml += ' <div class="iabtn">';
                        mediaGetHtml += '     <a href="#"  class="delte_multi_media_btn" data-id="' + response?.mediaGet[i]?.id + '" ><iconify-icon icon="mingcute:delete-2-line"></iconify-icon></a>';
                        mediaGetHtml += ' </div>';
                    }
                    mediaGetHtml += '</div>';
                    mediaGetHtml += ' </li>';
                }
            }
            $(".show_group_db_multi_media").empty().append(mediaGetHtml);
        }


        var transactionHtml = [];
        if (response?.stockHistory != null && response?.stockHistory != '' && response?.stockHistory != undefined && response?.stockHistory.length > 0) {
            for (var indx = 0; indx <= response?.stockHistory.length; indx++) {
                if (response?.stockHistory[indx]?.id != '' && response?.stockHistory[indx]?.id != undefined && response?.stockHistory[indx]?.id != null) {
                    transactionHtml += ' <tr>';
                    if (response?.stockHistory[indx]?.variation_name != '' && response?.stockHistory[indx]?.variation_name != undefined && response?.stockHistory[indx]?.variation_name != null)
                        transactionHtml += '<td>' + response?.stockHistory[indx]?.variation_name + '</td>';
                    else
                        transactionHtml += '<td></td>';
                    transactionHtml += '<td>' + response?.stockHistory[indx]?.stock + '</td>';
                    if (response?.stockHistory[indx]?.vendor_client_name != '' && response?.stockHistory[indx]?.vendor_client_name != undefined && response?.stockHistory[indx]?.vendor_client_name != null)
                        transactionHtml += '<td>' + response?.stockHistory[indx]?.vendor_client_name + '</td>';
                    else
                        transactionHtml += '<td></td>';

                    if (response?.stockHistory[indx]?.method_type == 1)
                        transactionHtml += '<td>Incoming</td>';
                    else if (response?.stockHistory[indx]?.method_type == 2)
                        transactionHtml += '<td>Outgoing</td>';
                    else
                        transactionHtml += '<td></td>';

                    transactionHtml += '<td>' + response?.stockHistory[indx]?.adjust_reason + '</td>';
                    transactionHtml += '<td>' + format_custom_date(response?.stockHistory[indx]?.created_at) + '</td>';

                    var customArray = JSON.parse(response?.stockHistory[indx]?.custome_field);
                    var cutomHtml = [];
                    if (customArray != null && customArray != '' && customArray != undefined) {
                        $.each(customArray, function(key, customval) {
                            $.each(customval, function(key, value) {
                                cutomHtml += key + ' = ' + value + '<br/>';
                            });
                        });
                    }
                    transactionHtml += '<td>' + cutomHtml + '</td>';

                    transactionHtml += '</tr>';
                }
            }
            $("#edit_item_transactional_history_tble").empty().append(transactionHtml);
        }
        var min_stock = 0;
        var vals = $(".edit_bundleQty").map(function() {
            return parseInt($(this).attr('data-db-stock'), 10) ? parseInt($(this).attr('data-db-stock'), 10) : null;
        }).get();

        var min_stock = Math.min.apply(Math, vals);
        $(".edit_available_instail_stock").val(min_stock);

        $(".js-example-placeholder-group-item-list").select2();
        $("#offcanvasExampleGroupItem").offcanvas("show");
    }
    //For Item Edit
    $("body").on("click", ".offcanvasItemEditBtn", function() {

        var id = $(this).attr('data-id');
        var editType = $(this).attr('data-type');
        var uRl = APP_URL + '/api/ProductShow/' + id;

        if (editType == 'group_item')
            uRl = APP_URL + '/api/GroupProductShow/' + id;

        $.ajax({
            url: uRl,
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
                    $(".error").remove();
                    $(".show_variation_btn").removeClass("hide-d");

                    dropzones.forEach(function(dropzone) {
                        dropzone.removeAllFiles(true);
                    });

                    if (editType == 'group_item')
                        mapItemGroupEditValues(response)
                    else
                        mapItemDbValues(response);

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

    function mapItemDbValues(response) {

        $('.pid').val(response?.data?.id);
        $(".delete_product").attr("data-id", response?.data?.id);
        $('.item_disp_name').html(response?.data?.name);
        $('.item_name_d').val(response?.data?.name);
        $('.item_description_d').val(response?.data?.description);
        $('.item_brand_d').val(response?.data?.brand_id).change();
        $('.item_category_d').val(response?.data?.category_id);
        $('.item_currency_d').val(response?.data?.currency).change();
        $(".edit_variation_list").empty();

        $(".edit_category_d").attr('data-value', response.data?.category_id);
        $("#searchInputCategory2").val(response.data?.catName);

        $(".edit_image_prev").css("background-image", 'url(' + response?.data?.pro_image + ')');
        if (response?.productVariation != null && response?.productVariation != '' && response?.productVariation != undefined && response?.productVariation.length > 0) {
            var variationHtml = [];
            for (var i = 0; i <= response?.productVariation.length; i++) {
                if (response?.productVariation[i]?.variation_name != '' && response?.productVariation[i]?.variation_name != undefined && response?.productVariation[i]?.variation_name != null) {
                    variationHtml += ' <tr class="variat_rw_' + response?.productVariation[i]?.id + '">';
                    variationHtml += ' <td >';
                    variationHtml += '     <div class="sd_check">';
                    if (response?.data?.id != '')
                        variationHtml += '         <input type="checkbox" class="variat_checkItem"  value="' + response?.productVariation[i]?.id + '" id="mtb_' + response?.productVariation[i]?.id + '" />';
                    else
                        variationHtml += '         <input type="checkbox" class="variation_d variat_checkItem"  value="' + response?.productVariation[i]?.id + '" id="mtb_' + response?.productVariation[i]?.id + '" />';

                    variationHtml += '         <label class="pull-right text" for="mtb_' + response?.productVariation[i]?.id + '">&nbsp;</label>';
                    variationHtml += '     </div>';
                    variationHtml += ' </td>';
                    variationHtml += ' <td class="variation_col" >' + response?.productVariation[i]?.variation_name + '</td>';
                    variationHtml += ' <td class="sku_col" >' + response?.productVariation[i]?.sku + '</td>';
                    variationHtml += ' <td class="purchase_col" >' + response?.productVariation[i]?.purchase_price + '</td>';
                    variationHtml += ' <td class="sale_col" >' + response?.productVariation[i]?.sale_price + '</td>';
                    variationHtml += ' <td class="tax_col" >' + response?.productVariation[i]?.tax_rate + '</td>';
                    variationHtml += ' <td class="tax_col" >' + response?.productVariation[i]?.unitName + '</td>';
                    variationHtml += ' <td class="stock_col" >';
                    variationHtml += '     <div class="action_btn_a">';
                    variationHtml += '         <a href="#" class="edit_cta edit_stock_alert" data-stock="' + response?.productVariation[i]?.vstock_alert + '"  data-id="' + response?.productVariation[i]?.id + '" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><iconify-icon icon="material-symbols:edit"></iconify-icon> Manage </a>';
                    variationHtml += '     </div>';
                    variationHtml += ' </td>';
                    if (has_edit_permission != '' && has_edit_permission != null && has_edit_permission != undefined) {
                        variationHtml += ' <td class="" >';
                        variationHtml += '     <div class="action_btn_a">';
                        variationHtml += '         <a href="#" class="edit_cta show_edit_variation_modal" data-id="' + response?.productVariation[i]?.id + '" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><iconify-icon icon="material-symbols:edit"></iconify-icon> Edit </a>';
                        variationHtml += '         <a class="delete_variation" href="#"   data-id="' + response?.productVariation[i]?.id + '" style="color: brown;">Delete</a>';
                        variationHtml += '     </div>';
                        variationHtml += ' </td>';
                    }
                    variationHtml += '</tr>';
                }
            }
            $(".edit_variation_list").empty().append(variationHtml);
            $(".ediItemtable").css("display", "block");
        }

        if (response?.mediaGet != null && response?.mediaGet != '' && response?.mediaGet != undefined && response?.mediaGet.length > 0) {
            var mediaGetHtml = [];
            for (var i = 0; i <= response?.mediaGet.length; i++) {
                if (response?.mediaGet[i]?.product_image != '' && response?.mediaGet[i]?.product_image != undefined && response?.mediaGet[i]?.product_image != null) {
                    mediaGetHtml += '<li class="md_multi_row_' + response?.mediaGet[i]?.id + '">';
                    mediaGetHtml += '<div class="file_item">';
                    mediaGetHtml += ' <div>';
                    mediaGetHtml += '       <span>';
                    mediaGetHtml += '        <img src="' + response?.mediaGet[i]?.product_image + '" alt=""> ';
                    mediaGetHtml += '     </span>';
                    mediaGetHtml += '    <a href=" ' + response?.mediaGet[i]?.product_image + '" target="_blank" > <h6>' + response?.mediaGet[i]?.product_image_name + '</h6> </a>';
                    mediaGetHtml += ' </div>';

                    if (has_edit_permission != '' && has_edit_permission != null && has_edit_permission != undefined) {
                        mediaGetHtml += ' <div class="iabtn">';
                        mediaGetHtml += '     <a href="#"  class="delte_multi_media_btn" data-id="' + response?.mediaGet[i]?.id + '" ><iconify-icon icon="mingcute:delete-2-line"></iconify-icon></a>';
                        mediaGetHtml += ' </div>';
                    }
                    mediaGetHtml += '</div>';
                    mediaGetHtml += ' </li>';
                }
            }
            $(".show_db_multi_media").empty().append(mediaGetHtml);
        }
        if (response?.data?.pro_image != '' && response?.data?.pro_image != undefined && response?.data?.pro_image != null) {

            var mediaHtml = '<li class="md_row_' + response?.data.id + '">';
            mediaHtml += '<div class="file_item">';
            mediaHtml += ' <div>';
            mediaHtml += '       <span>';
            mediaHtml += '        <img src="' + response?.data?.pro_image + '" alt=""> ';
            mediaHtml += '     </span>';
            mediaHtml += '    <a href=" ' + response?.data?.pro_image + '" target="_blank" > <h6>' + response?.data?.pro_image_name + '</h6> </a>';
            mediaHtml += ' </div>';
            if (has_edit_permission != '' && has_edit_permission != null && has_edit_permission != undefined) {
                mediaHtml += ' <div class="iabtn">';
                mediaHtml += '     <a href="#"  class="delte_media_btn" data-id="' + response?.data?.id + '" ><iconify-icon icon="mingcute:delete-2-line"></iconify-icon></a>';
                mediaHtml += ' </div>';
            }
            mediaHtml += '</div>';
            mediaHtml += ' </li>';
            $(".show_db_single_media").empty().append(mediaHtml);
        }

        if (response?.stockHistory != null && response?.stockHistory != '' && response?.stockHistory != undefined && response?.stockHistory.length > 0) {
            var transactionHtml = [];
            for (var indx = 0; indx <= response?.stockHistory.length; indx++) {
                if (response?.stockHistory[indx]?.id != '' && response?.stockHistory[indx]?.id != undefined && response?.stockHistory[indx]?.id != null) {
                    transactionHtml += ' <tr>';
                    if (response?.stockHistory[indx]?.variation_name != '' && response?.stockHistory[indx]?.variation_name != undefined && response?.stockHistory[indx]?.variation_name != null)
                        transactionHtml += '<td>' + response?.stockHistory[indx]?.variation_name + '</td>';
                    else
                        transactionHtml += '<td></td>';
                    transactionHtml += '<td>' + response?.stockHistory[indx]?.stock + '</td>';
                    if (response?.stockHistory[indx]?.vendor_client_name != '' && response?.stockHistory[indx]?.vendor_client_name != undefined && response?.stockHistory[indx]?.vendor_client_name != null)
                        transactionHtml += '<td>' + response?.stockHistory[indx]?.vendor_client_name + '</td>';
                    else
                        transactionHtml += '<td></td>';

                    if (response?.stockHistory[indx]?.method_type == 1)
                        transactionHtml += '<td>Incoming</td>';
                    else if (response?.stockHistory[indx]?.method_type == 2)
                        transactionHtml += '<td>Outgoing</td>';
                    else
                        transactionHtml += '<td></td>';

                    transactionHtml += '<td>' + response?.stockHistory[indx]?.adjust_reason + '</td>';
                    transactionHtml += '<td>' + format_custom_date(response?.stockHistory[indx]?.created_at) + '</td>';

                    var customArray = JSON.parse(response?.stockHistory[indx]?.custome_field);
                    var cutomHtml = [];
                    if (customArray != null && customArray != '' && customArray != undefined) {
                        // for (var j = 0; j <= customArray.length; j++) {
                        $.each(customArray, function(key, customval) {
                            console.log('customval ', customval);
                            // if (customval != null && customval != '' && customval != undefined) {
                            console.log('customval ', customval);
                            $.each(customval, function(key, value) {
                                cutomHtml += key + ' = ' + value + '<br/>';
                            });
                            // }
                        });
                    }
                    transactionHtml += '<td>' + cutomHtml + '</td>';

                    transactionHtml += '</tr>';
                }
            }
            $("#item_transactional_history_tble").empty().append(transactionHtml);
        }

        $("#offcanvasExample").offcanvas("show");
    }

    var format_custom_date = function(input) {
        var d = new Date(input);
        var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        var date = d.getDate() + " " + month[d.getMonth()] + ", " + d.getFullYear();
        var time = d.toLocaleTimeString().toLowerCase().replace(/([\d]+:[\d]+):[\d]+(\s\w+)/g, "$1$2");
        return (date + " " + time);
    };

    // Delete Products
    $("body").on("click", ".delete_product", function() {
        var pid = $(this).attr("data-id");
        $.ajax({
            url: APP_URL + "/api/ProductDelete/" + pid,
            type: "get",
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(xhr) {
                if (confirm("Are you sure?")) {
                    block_gui_start();
                    xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
                } else {
                    // stop the ajax call
                    return false;
                }

            },
            success: function(response) {
                block_gui_end();
                if (response.status == true) {
                    $("#offcanvasExample").offcanvas("toggle");
                    ResetFilterItem();
                    toastr.success(response.message);
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

    $("body").on("click", ".delete_variation", function() {
        var mid = $(this).attr("data-id");
        $.ajax({
            url: APP_URL + "/api/VariationProductdelete/" + mid,
            type: "get",
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(xhr) {
                if (confirm("Are you sure?")) {
                    block_gui_start();
                    xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
                } else {
                    // stop the ajax call
                    return false;
                }

            },
            success: function(response) {
                block_gui_end();
                if (response.status == true) {
                    toastr.success(response.message);
                    $(".variat_rw_" + mid).remove();
                    ResetFilterItem();

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

    $("body").on("click", ".delte_multi_media_btn", function() {
        var mid = $(this).attr("data-id");
        $.ajax({
            url: APP_URL + "/api/ProductMediadelete/" + mid,
            type: "get",
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(xhr) {
                if (confirm("Are you sure?")) {
                    block_gui_start();
                    xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
                } else {
                    // stop the ajax call
                    return false;
                }

            },
            success: function(response) {
                block_gui_end();
                if (response.status == true) {
                    toastr.success(response.message);
                    $(".md_multi_row_" + mid).remove();
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

    $("body").on("click", ".delte_media_btn", function() {
        var mid = $(this).attr("data-id");
        $.ajax({
            url: APP_URL + "/api/ProductSingleMediadelete/" + mid,
            type: "get",
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(xhr) {
                if (confirm("Are you sure?")) {
                    block_gui_start();
                    xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
                } else {
                    // stop the ajax call
                    return false;
                }

            },
            success: function(response) {
                block_gui_end();
                if (response.status == true) {
                    toastr.success(response.message);
                    $(".md_row_" + mid).remove();
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

    //handle itemdetail  changes
    $(".item_detail_card_d").on("click", function() {
        var type = $(this).attr("data-type");
        if (type == 'edit') {
            $('.inp_item_detail').prop("disabled", false);
            $('.edit_category_d').prop("disabled", false);
            $('.searchable-select-container').removeClass("ondisable");

            $(this).attr("data-type", 'save');
            $(this).removeClass('item_update_btn');
            $(this).html('Save');
        } else {
            $('.inp_item_detail').prop("disabled", true);
            $('.edit_category_d').prop("disabled", true);
            $('.searchable-select-container').addClass("ondisable");
            $(this).attr("data-type", 'edit');
            $(this).addClass('item_update_btn');
            $(this).html('Edit');
        }
    });
    //handle edit media form changes
    $(".item_media_card_d").on("click", function() {
        var type = $(this).attr("data-type");
        if (type == 'edit') {
            $('.edit_single_up_box').removeClass("hide-d");
            $(this).attr("data-type", 'save');
            $(this).removeClass('item_update_btn');
            $(this).html('Save');
        } else {
            $('.edit_single_up_box').addClass("hide-d");
            $(this).attr("data-type", 'edit');
            $(this).addClass('item_update_btn');
            $(this).html('File Upload');
        }
    });
    //handle edit multi media form changes
    $(".item_multi_media_card_d").on("click", function() {
        var type = $(this).attr("data-type");
        if (type == 'edit') {
            $('.edit_mul_up_box').removeClass("hide-d");
            $(this).attr("data-type", 'save');
            $(this).removeClass('item_update_btn');
            $(".upload__img-wrap").empty();
            $(this).html('Save');
        } else {
            $('.edit_mul_up_box').addClass("hide-d");
            $(this).attr("data-type", 'edit');
            $(this).addClass('item_update_btn');
            $(this).html('File Upload');
        }
    });
    // ..........# Save edit form...........
    $("body").on("click", ".item_update_btn", function() {
        var form = $("#productDetailForm")[0];
        var formData = new FormData(form);
        formData.append('name', $(".item_name_d").val());
        formData.append('description', $(".item_description_d").val());
        formData.append('brand_id', $(".item_brand_d").val());
        formData.append('category_id', $('.edit_category_d').attr("data-value"));
        formData.append('currency', $(".item_currency_d").val());
        formData.append('id', $('.pid').val());


        var dsk = 0;
        var mb = 0;
        dropzones.forEach(function(dropzone) {

            var element = dropzone.element;
            var cindex = $(element).get(0).id;
            var paramName = dropzone.options;
            var fiels = dropzone.getAcceptedFiles();
            fiels.forEach(function(file, i) {
                if (cindex && cindex == "desktop_single_item_media") {
                    formData.append('edit_pro_image[' + dsk + ']', file);
                    dsk++
                } else if (cindex && cindex == "desktop_multi_item_media") {
                    formData.append('product_image[' + mb + ']', file);
                    mb++;
                }
            });
        });

        $.ajax({
            url: APP_URL + '/api/ProductEdit',
            type: "POST",
            data: formData,
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
                    $("#offcanvasExample").offcanvas("toggle");
                    $(".upload__img-wrap").empty();
                    toastr.success(response.message);
                    ResetFilterItem();
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

    // expot option
    $("body").on("click", ".export_option", function() {
        var type = $(this).val();
        var url = '';
        if (type == 'pdf') {
            url = APP_URL + "/api/ProductPdf/" + enyptID;;
        } else if (type == 'excel') {
            url = APP_URL + "/api/ProductExport/" + enyptID;;
        } else if (type == 'tally') {
            url = '';
        }
        $(".export_cut_btn").attr('data-url', url);

    });

    $(".export_cut_btn").on("click", function() {
        var routeUrl = $(this).attr('data-url');
        if (routeUrl != '') {
            var win = window.open(routeUrl, '_blank');
            if (win) {
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }

        }
    });
    //.........Import csv file into db

    $(".cust_import_file").on("click", function() {
        var form = $("#cusForm_import_d")[0];
        var formData = new FormData(form);
        formData.append('id', $('.cid').val());
        var dsk = 0;
        var mb = 0;
        dropzones.forEach(function(dropzone) {

            var element = dropzone.element;
            var cindex = $(element).get(0).id;
            var paramName = dropzone.options;
            var fiels = dropzone.getAcceptedFiles();
            fiels.forEach(function(file, i) {
                if (cindex && cindex == "desktop_media") {
                    formData.append('product_file', file);
                    // formData.append('customer_file['+dsk+']', file);
                    dsk++

                } else if (cindex && cindex == "mobile_media") {
                    formData.append('product_file', file);
                    // formData.append('customer_file['+mb+']', file);
                    mb++;
                }
            });
        });
        $.ajax({
            url: APP_URL + '/api/ProductImport',
            type: "POST",
            data: formData,
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
                    $(".next_imp_btn").removeClass("hide-d");
                    $(".cust_import_file").addClass("hide-d");
                    toastr.success(response.message);
                    ReseProductItemPage();
                    window.location.reload();
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
    //    ..............................Variation SECTION START..................................
    $("body").on("click", ".show_add_variation_btn", function(e) {
        e.preventDefault();
        $(".variation_name_d").val('');
        $(".sku_d").val('');
        $(".purchase_price_d").val('');
        $(".sale_price_d").val('');
        $(".tax_rate_d").val('');
        $(".hsn_d").val('');
        $(".unit_id").val('');
        $("#addvariationPopup").modal("show");

    });
    $("body").on("click", ".closeaddvaripopup", function(e) {
        $("#addvariationPopup").modal("hide");
    });

    $("body").on("click", ".show_variation_btn", function(e) {
        e.preventDefault();
        var btn_type = $(this).attr("data-btn-type");
        $(".variation_screen_type").val(btn_type);
        $(".variation_name_d").val('');
        $(".sku_d").val('');
        $(".purchase_price_d").val('');
        $(".sale_price_d").val('');
        $(".tax_rate_d").val('');
        $(".hsn_d").val('');
        $(".unit_id").val('').change();
        $(".addboth_stk_btn").attr("onclick", "addAssignNewVariation(this)");
        $(".vid").val('');
        $("#addvariationPopup").modal("show");

    });

    $("body").on("click", ".show_edit_variation_modal", function() {
        var id = $(this).attr('data-id');
        $.ajax({
            url: APP_URL + '/api/VariationProductShow/' + id,
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
                    $(".variation_name_d").val(response?.data[0]?.variation_name);
                    $(".sku_d").val(response?.data[0]?.sku);
                    $(".purchase_price_d").val(response?.data[0]?.purchase_price);
                    $(".sale_price_d").val(response?.data[0]?.sale_price);
                    $(".tax_rate_d").val(response?.data[0]?.tax_rate);
                    $(".hsn_d").val(response?.data[0]?.hsn);
                    $(".unit_id").val(response?.data[0]?.unit_id);
                    $(".vid").val(response?.data[0]?.id);
                    $(".addboth_stk_btn").attr("onclick", "addNewVariation(this)");
                    $(".addboth_stk_btn").removeClass("hide-d");
                    //  $(".addboth_stk_btn").attr("onclick", "addAssignNewVariation(this)");
                    $(".variation_screen_type").val("edit");
                    $("#addvariationPopup").modal("show");
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
    //update 
    $("body").on("click", ".edit_stock_alert", function() {
        var vari_id = $(this).attr("data-id")
        var last_stock_alert = $(this).attr("data-stock")

        $(".varit_updated_low_qty").val(last_stock_alert);
        $(".edit_varit_id").val(vari_id);
        $("#manageStockPopup").modal("show");
    });

    $("body").on("click", ".close_stk_alert", function() {
        $(".varit_updated_low_qty").val('');
        $("#manageStockPopup").modal("hide");
    });

    function UpdateStocklaert() {
        var formData = new FormData();
        formData.append('variation_id', $('.edit_varit_id').val());
        formData.append('stock_alert', $('.varit_updated_low_qty').val());
        $.ajax({
            url: APP_URL + "/api/ProductlowStockUpdate",
            type: "post",
            data: formData,
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
                    ResetFilterItem();
                    toastr.success(response.message);
                    $("#manageStockPopup").modal("hide");

                } else {
                    toastr.error(response.message);
                }

            },
            error: function(response) {
                block_gui_end();
                console.log("server side error");
            }
        });
    }


    $("body").on("click", ".tabel_invtry_col_sorting", function() {
        var col = $(this).val();
        if ($(this).is(":checked")) {
            $("." + col).removeClass("hide-d");
        } else {
            console.log("unChecked");
            $("." + col).addClass("hide-d");
        }

    });

    function is_variationFormValid() {
        $(".error").remove();
        if ($(".variation_name_d").val().length < 1) {
            $('.variation_name_d').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".sku_d").val().length < 1) {
            $('.sku_d').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".purchase_price_d").val().length < 1) {
            $('.purchase_price_d').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".sale_price_d").val().length < 1) {
            $('.sale_price_d').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".tax_rate_d").val().length < 1) {
            $('.tax_rate_d').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".hsn_d").val().length < 1) {
            $('.hsn_d').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".unit_id").val().length < 1) {
            $('.unit_id').after('<span class="error">This field is required</span>');
            return false;
        }
        return true;
    }

    function addBothNewVariation(event) {
        if (!is_variationFormValid()) {
            return false
        }
        for (var i = 1; i < 3; i++) {
            if (i == 1) {
                addFirstNewVariation(event)
            } else if (i = 2) {
                addNewVariation();
            }
        }

    }

    function AddFirstvarit(event) {

        $(".error").remove();
        if ($(".fst_variation_name_d").val().length < 1) {
            $('.fst_variation_name_d').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".fst_sku_d").val().length < 1) {
            $('.fst_sku_d').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".fst_purchase_price_d").val().length < 1) {
            $('.fst_purchase_price_d').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".fst_sale_price_d").val().length < 1) {
            $('.fst_sale_price_d').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".fst_tax_rate_d").val().length < 1) {
            $('.fst_tax_rate_d').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".fst_hsn_d").val().length < 1) {
            $('.fst_hsn_d').after('<span class="error">This field is required</span>');
            return false;
        }

        if ($(".fst_unit_id").val().length < 1) {
            $('.fst_unit_id').after('<span class="error">This field is required</span>');
            return false;
        }

        

        var is_fist_time_stock = $(".fist_time_stock_d").val();
        if (is_fist_time_stock == 1) {
            $(".addboth_stk_btn").attr("onclick", "addBothNewVariation(this)");

        } else {
            $(".addboth_stk_btn").attr("onclick", "addNewVariation(this)");

        }

        $("#addvariationPopup").modal("show");
    }



    function addFirstNewVariation(event) {
        $(".error").remove();
        if ($(".fst_variation_name_d").val().length < 1) {
            $('.fst_variation_name_d').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".fst_purchase_price_d").val().length < 1) {
            $('.fst_purchase_price_d').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".fst_sale_price_d").val().length < 1) {
            $('.fst_sale_price_d').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".fst_tax_rate_d").val().length < 1) {
            $('.fst_tax_rate_d').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".fst_hsn_d").val().length < 1) {
            $('.fst_hsn_d').after('<span class="error">This field is required</span>');
            return false;
        }
        if ($(".fst_unit_id").val().length < 1) {
            $('.fst_unit_id').after('<span class="error">This field is required</span>');
            return false;
        }

        // var formData = new FormData($("#addFirstVariationForm_d")[0]);
        var formData = new FormData();
        formData.append('variation_name', $('.fst_variation_name_d').val());
        formData.append('sku', $('.fst_sku_d').val());
        formData.append('purchase_price', $('.fst_purchase_price_d').val());
        formData.append('sale_price', $('.fst_sale_price_d').val());
        formData.append('tax_rate', $('.fst_tax_rate_d').val());
        formData.append('hsn', $('.fst_hsn_d').val());
        formData.append('unit_id', $('.fst_unit_id').val());

        var vURl = APP_URL + '/api/ProductVariationAdd';
        variationAjaxRequest(vURl, formData, false);
    }

    function addNewVariation() {

        if (!is_variationFormValid()) {
            return false
        }
        var formData = new FormData($("#addVariationForm_d")[0]);
        var is_edit_mode = false;
        var vURl = APP_URL + '/api/ProductVariationAdd';
        if ($(".vid").val() != '' && $(".vid").val() != null && $(".vid").val() != undefined) {
            is_edit_mode = true;
            vURl = APP_URL + '/api/VariationProductEdit';
            formData.append('id', $('.vid').val());
        }
        variationAjaxRequest(vURl, formData, is_edit_mode);

    }

    function variationAjaxRequest(vURl, formData, is_edit_mode = false) {
        $.ajax({
            url: vURl,
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
                    $("#addvariationPopup").modal("hide");
                    $(".fst_btn").addClass("hide-d");
                    $(".show_variation_btn").removeClass("hide-d");
                    $(".cretetable").css("display", "block");
                    $(".form_view").addClass("deactive");
                    $(".mstk_btn").addClass("hide-d");

                    variatHtml(response?.data, is_edit_mode);

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

    function variatHtml(data, is_edit_mode) {
        var is_low_stock_req = $(".variation_screen_type").val();
        manage_popupClass = 'manage_stock_btn'
        if (is_low_stock_req == "edit") {
            manage_popupClass = 'edit_stock_alert'
        }

        // console.log("edit", is_edit_mode);
        if (is_edit_mode == true) {
            data = data[0];
        }
        var variationHtml = [];
        if (data?.variation_name != '' && data?.variation_name != null && data?.variation_name != undefined) {
            if ($(".vid").val() != '' && $(".vid").val() != null && $(".vid").val() != undefined) {
                $('.variat_rw_' + $(".vid").val()).empty();
            }
            variationHtml += ' <tr class="variat_rw_' + data?.id + '">';
            variationHtml += ' <td >';
            variationHtml += '     <div class="sd_check">';
            variationHtml += '         <input type="checkbox" class="variation_d variat_checkItem"  value="' + data?.id + '" id="mtb_' + data?.id + '" />';
            variationHtml += '         <label class="pull-right text" for="mtb_' + data?.id + '">&nbsp;</label>';
            variationHtml += '     </div>';
            variationHtml += ' </td>';
            variationHtml += ' <td class="variation_col" >' + data?.variation_name + '</td>';
            variationHtml += ' <td class="sku_col" >' + data?.sku + '</td>';
            variationHtml += ' <td class="purchase_col" >' + data?.purchase_price + '</td>';
            variationHtml += ' <td class="sale_col " >' + data?.sale_price + '</td>';
            variationHtml += ' <td class="tax_col " >' + data?.tax_rate + '</td>';
            if (data?.unitName != '' && data?.unitName != null && data?.unitName != undefined)
                variationHtml += ' <td class="tax_col" >' + data?.unitName + '</td>';
            else
                variationHtml += ' <td class="tax_col" ></td>';

            variationHtml += ' <td class="stock_col" >';
            variationHtml += '     <div class="action_btn_a">';
            variationHtml += '         <a href="#" class="edit_cta ' + manage_popupClass + ' " data-id="' + data?.id + '"  data-varit-name="' + data?.variation_name + '"  data-toggle="tooltip" data-placement="top" data-original-title="Edit"><iconify-icon icon="material-symbols:edit"></iconify-icon> Manage </a>';
            variationHtml += '     </div>';
            variationHtml += ' </td>';
            variationHtml += ' <td class="" >';
            variationHtml += '     <div class="action_btn_a">';
            variationHtml += '         <a href="#" class="edit_cta show_edit_variation_modal" data-id="' + data?.id + '" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><iconify-icon icon="material-symbols:edit"></iconify-icon> Edit </a>';
            variationHtml += '         <a class="delete_variation" href="#"   data-id="' + data?.id + '" style="color: brown;">Delete</a>';
            variationHtml += '     </div>';
            variationHtml += ' </td>';
            variationHtml += '</tr>';
            $(".variation_list").append(variationHtml);
        }

    }

    var cust_index = 0

    function addCustomField() {
        var custHtml = [];
        custHtml += '<div class="col-lg-4 rw_d_' + cust_index + '">';
        custHtml += '<input type="text" class="stk_custom_key" placeholder="Field Name">';
        custHtml += ' </div>';
        custHtml += ' <div class="col-lg-7  rw_d_' + cust_index + '">';
        custHtml += '    <div class="form-group">';
        custHtml += '       <input type="text" class="stk_custom_value" placeholder="value">';
        custHtml += '    </div>';
        custHtml += ' </div>';
        custHtml += '<div class="col-lg-1  rw_d_' + cust_index + '">';
        custHtml += '     <a href="javascript:void(0)" onclick="removeCustomField(this)" data-id="rw_d_' + cust_index + '" class="hide_bar remove_tr"><iconify-icon icon="material-symbols:close-rounded"></iconify-icon></a>';
        custHtml += ' </div>';
        $(".custom_field").append(custHtml);
        cust_index++
    }

    function removeCustomField(event) {
        var rwid = $(event).attr("data-id");
        $("." + rwid).remove();
    }

    function addAssignNewVariation() {
        if (!is_variationFormValid()) {
            return false
        }
        var formData = new FormData($("#addVariationForm_d")[0]);
        formData.append('product_id', $('.pid').val());
        var vURl = APP_URL + '/api/VariationProductAddAssign';

        variationAjaxRequest(vURl, formData, false);
    }






    $("body").on("click", ".manage_stock_btn", function() {
        $(".varit_name").val($(this).attr("data-varit-name"));
        $(".save_varit_id").val($(this).attr("data-id"));

        $('.varit_vedor_id').val('');
        $('.varit_qty').val('');
        $('.varit_low_qty').val('');
        $(".varit_custom_key").val('');
        $(".varit_custom_value").val('');
        $(".custom_field").empty();
        $(".fist_time_stock_d").val("0")

        $("#manageveriPopup").modal("show");
    });

    $("body").on("click", ".mstk_btn", function() {
        $(".varit_name").val($(this).attr("data-varit-name"));
        $(".save_varit_id").val($(this).attr("data-id"));

        $('.varit_vedor_id').val('');
        $('.varit_qty').val('');
        $('.varit_low_qty').val('');
        $(".varit_custom_key").val('');
        $(".varit_custom_value").val('');
        $(".custom_field").empty();
        $(".variation_screen_type").val("add");
        $(".fist_time_stock_d").val("1");

        $("#manageveriPopup").modal("show");
    });

    $("body").on("click", ".close_manageveriPopup", function() {
        $("#manageveriPopup").modal("hide");
    });

    function UpdateNewStock() {

        var isfirst_stock = $(".fist_time_stock_d").val();
        var formData = new FormData($("#manageVariationForm_d")[0]);

        if (isfirst_stock == 1) {
            formData.append('variation_name', $('.fst_variation_name_d').val());
            formData.append('sku', $('.fst_sku_d').val());
            formData.append('purchase_price', $('.fst_purchase_price_d').val());
            formData.append('sale_price', $('.fst_sale_price_d').val());
            formData.append('tax_rate', $('.fst_tax_rate_d').val());
            formData.append('hsn', $('.fst_hsn_d').val());
            formData.append('unit_id', $('.fst_unit_id').val());
        }

        formData.append('quantity', $('.varit_qty').val());
        formData.append('vendor_id', $('.varit_vedor_id').val());
        formData.append('stock_alert', $('.varit_low_qty').val());
        formData.append('variation_id', $('.save_varit_id').val());
        formData.append('method_type ', 1);
        formData.append('is_first_stock ', true);

        $(".varit_custom_key").each(function(index) {
            form_data.append('custome_key[' + index + ']', $(this).val());
        });

        $(".varit_custom_value").each(function(index) {
            form_data.append('custome_value[' + index + ']', $(this).val());
        });


        $.ajax({
            url: APP_URL + '/api/AdjustmentUpdate',
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
                    toastr.success(response?.message);
                    $(".adjustment_id_d").val(response?.data?.id);
                    if (isfirst_stock == 1)
                        $(".form_view").removeClass("deactive");

                    $(".mstk_btn").addClass("hide-d");
                    $("#manageveriPopup").modal("hide");
                    // $("#manageStockPopup").modal("hide");
                    $('#manageStockPopup').removeClass('show');
                    if (isfirst_stock == 1) {
                        variatHtml(response?.productVariation);
                        //   $(".addboth_stk_btn").addClass("hide-d");
                    }
                    $(".fist_time_stock_d").val("0");
                    ReseProductItemPage();

                    $(".addboth_stk_btn").attr("onlick", "addNewVariation(this)");
                }

            },
            error: function(response) {
                block_gui_end();
                console.log("server side error");
            }
        });

    }

    $("body").on("click", "#checkAllvariation", function() {
        // $('input:checkbox').not(this).prop('checked', this.checked);
        $(':checkbox.variat_checkItem').prop('checked', this.checked);
    });
    $("body").on("click", "#checkAllproduct", function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
        $(".selected_count").html($('.customerChkBox').filter(':checked').length + ' Product Selected');
        if ($('.customerChkBox').filter(':checked').length > 0) {
            $(".show_check").addClass('show_option')
            $('.table_card .thead form.mr-3.position-relative').addClass("hide_search");
        } else {
            $(".show_check").removeClass('show_option')
            $('.table_card .thead form.mr-3.position-relative').removeClass("hide_search");
        }
        var index = 0;
        var exportHtml = [];
        $('input[name="customerChkBox"]:checked').each(function() {
            if ($(this).val() != '') {
                exportHtml += ' <input type="hidden" class="hidden_exported_id" name="id[' + index + ']" value="' + $(this).val() + '" />';
                index++;
            }
        });
        $(".hiden_cust_export_val").empty().append(exportHtml);
    });

    $("body").on("click", ".customerChkBox", function() {
        $(".selected_count").html($('.customerChkBox').filter(':checked').length + ' Item Selected');
        if ($('.customerChkBox').filter(':checked').length > 0) {
            $(".show_check").addClass('show_option')
            $('.table_card .thead form.mr-3.position-relative').addClass("hide_search");
        } else {
            $(".show_check").removeClass('show_option')
            $('.table_card .thead form.mr-3.position-relative').removeClass("hide_search");

        }
        var index = 0;
        var exportHtml = [];
        $('input[name="customerChkBox"]:checked').each(function() {
            if ($(this).val() != '') {
                exportHtml += ' <input type="hidden" class="hidden_exported_id" name="id[' + index + ']" value="' + $(this).val() + '" />';
                index++;
            }
        });
        $(".hiden_cust_export_val").empty().append(exportHtml);
    });

    $("body").on('click', '.selected_user_delete', function() {
        var form_data = new FormData();
        var idx = 0;
        // $(".customerChkBox").each(function (i) {
        $('input[name="customerChkBox"]:checked').each(function() {
            if ($(this).val() != '') {
                form_data.append('id[' + idx + ']', $(this).val());
                idx++;
            }
        });
        form_data.append('_token', csrfTokenVal);
        $.ajax({
            url: APP_URL + "/api/ProductMultipleDelete",
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
                    $(".show_check").removeClass('show_option')
                    $('.table_card .thead form.mr-3.position-relative').removeClass("hide_search");
                    toastr.success(response?.message);
                    ResetDomainPage();
                } else {
                    toastr.error(response?.message);
                }

            },
            error: function(response) {
                block_gui_end();
                console.log("server side error");
            }
        })
    });
    $("body").on("click", ".selected_export_option", function() {
        var type = $(this).val();
        if (type == 'pdf') {
            $(".pdf_select_form").removeClass("hide-d");
            $(".excel_select_form").addClass("hide-d");
        } else if (type == 'excel') {
            $(".pdf_select_form").removeClass("hide-d");
            $(".excel_select_form").addClass("hide-d");
        } else if (type == 'tally') {
            $(".pdf_select_form").addClass("hide-d");
            $(".excel_select_form").addClass("hide-d");
        }
        // $(".export_cut_btn").attr('data-url', url);
    });
    // .............................End Item SECTION...............................................
    function ReseBrandPage(search = '', page_number = '') {
        var bdUrl = <?= json_encode(route('fn.inventory.brand', $enypt_id)) ?> + '?search=' + search + '&page=' + page_number;
        $.ajax({
            url: bdUrl,
            // type: "GET",
            dataType: 'json',
            beforeSend: function(xhr) {
                block_gui_start();

            },
            success: function(response) {
                block_gui_end();
                $('#brand_table_listing').html(response?.content);
                window.history.pushState('page2', 'Brand', bdUrl);
                $('#createbrand').addClass('active');
            },
            error: function(response) {
                block_gui_end();
                console.log("server side error");
            }
        });
    }
    $("body").on("click", "#opencreatebrand", function(e) {
        e.preventDefault();
        ReseBrandPage();
    });

    function ReseCategoryPage(search = '', page_number = '') {
        var bdUrl = <?= json_encode(route('fn.inventory.category', $enypt_id)) ?> + '?search=' + search + '&page=' + page_number;
        $.ajax({
            url: bdUrl,
            // type: "GET",
            dataType: 'json',
            beforeSend: function(xhr) {
                block_gui_start();

            },
            success: function(response) {
                block_gui_end();
                $('#category_table_listing').html(response?.content);
                window.history.pushState('page1', 'Category', bdUrl);
                $('#createcategory').addClass('active');
            },
            error: function(response) {
                block_gui_end();
                console.log("server side error");
            }
        });
    }
    $("body").on("click", "#opencreatecategory", function(e) {
        e.preventDefault();
        ReseCategoryPage();
    });
</script>

<script src="{{asset('js/inventory-custom.js')}}"></script>
<script>
    $(document).ready(function() {

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;
        var current = 1;
        var steps = $("fieldset").length;

        setProgressBar(current);

        $(".next").click(function() {

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            //Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 500
            });
            setProgressBar(++current);
        });

        $(".previous").click(function() {

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            //Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();

            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 500
            });
            setProgressBar(--current);
        });

        function setProgressBar(curStep) {
            var percent = parseFloat(100 / steps) * curStep;
            percent = percent.toFixed();
            $(".progress-bar")
                .css("width", percent + "%")
        }

        $(".submit").click(function() {
            return false;
        })

    });
</script>

<script>
    // Brand with Button
    $(".js-example-placeholder-single-brand").select2().data("select2").$dropdown.addClass("my-container");

    var $customDiv = $('<div class="inner_box"><button id="custom-button"><iconify-icon icon="pajamas:plus"></iconify-icon> Create Brand</button></div>');

    $(".js-example-placeholder-single-brand").on("select2:open", function() {
        // Append the custom div to the select2-dropdown element
        $(".my-container .select2-dropdown").append($customDiv);

    });
</script>



<script>
    $(document).ready(function() {
        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;
        var current = 1;
        var steps = $("fieldset").length;

        setProgressBar(current);

        $(".next").click(function() {
            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            //Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        display: "none",
                        position: "relative",
                    });
                    next_fs.css({
                        opacity: opacity
                    });
                },
                duration: 500,
            });
            setProgressBar(++current);
        });

        $(".previous").click(function() {
            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            //Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();

            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        display: "none",
                        position: "relative",
                    });
                    previous_fs.css({
                        opacity: opacity
                    });
                },
                duration: 500,
            });
            setProgressBar(--current);
        });

        function setProgressBar(curStep) {
            var percent = parseFloat(100 / steps) * curStep;
            percent = percent.toFixed();
            $(".progress-bar").css("width", percent + "%");
        }

        $(".submit").click(function() {
            return false;
        });
    });
</script>



<script>
    //  $("#imageeditUpload").change(function() {
    //     readURL(this);
    // });
    //     $("#imag1").change(function() {
    //     // add your logic to decide which image control you'll use
    //     var imgControlName = "#ImgPreview2";
    //     readURL(this, imgControlName);
    //     $('.preview2').addClass('it');
    //     $('.btn-rmv1').addClass('rmv');
    // });
    // function readURL(input) {
    //     if (input.files && input.files[0]) {
    //         var reader = new FileReader();
    //         reader.onload = function(e) {
    //             $("#addItemimagePreview").css("background-image", "url(" + e.target.result + ")");
    //             $("#addItemimagePreview").hide();
    //             $("#addItemimagePreview").fadeIn(650);
    //         };
    //         reader.readAsDataURL(input.files[0]);
    //     }
    // }
    // $("#imageNewUpload").change(function() {
    //     readURL(this);
    // });
</script>


<script>
    function readURL(input, previewElement) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                previewElement.style.backgroundImage = "url(" + e.target.result + ")";
                previewElement.style.display = "none";
                previewElement.style.display = "block";
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    var editIcons = document.querySelectorAll('.editLink');
    var uploadInputs = document.querySelectorAll('.imageUpload');
    var previewElements = document.querySelectorAll('.imagePreview');

    editIcons.forEach(function(icon, index) {
        icon.addEventListener('click', function() {
            uploadInputs[index].click();
        });
    });

    uploadInputs.forEach(function(input, index) {
        input.addEventListener('change', function() {
            readURL(this, previewElements[index]);
        });
    });
</script>

@endpush