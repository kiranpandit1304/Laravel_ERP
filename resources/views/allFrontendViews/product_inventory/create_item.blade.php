<!-- Create Item - Bottom Full Screen Popup -->
<div class="cibsp" id="createItem" style="overflow: scroll;">
    <div class="cibsp_header">
        <a href="#" class="close_cibsp"><iconify-icon icon="material-symbols:close-rounded"></iconify-icon></a>
        <h2>Create an Item</h2>
        <button class="creatNewItem_d" onclick="creatNewItem(this)">Save</button>
    </div>
    <div class="mini_continer">
        <div class="cibsp_body">
            <form method="post" action="javascript:void(0)" id="create_item_form">
                <div class="inner_model_wrapper">
                    <div class="row">
                        <div class="col-lg-9 col-12">
                            <h4>Details</h4>
                            <div class="form-group">
                                <label>
                                    <input type="text" class="item_name" name="name" required="" placeholder="Item Name" />
                                    <span>Item Name</span>
                                </label>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <div class="searchable-select-container">
                                        <div class="witharrow">
                                            <input type="text" id="searchInputCategory" name="category_id_d" class="category_d" placeholder="Select Category" readonly />
                                            <span class="selection__arrow" role="presentation"><b role="presentation"></b></span>
                                        </div>
                                        <div id="dropdownCategory" class="dropdownCategory">
                                            <div id="search_wrapper" class="hiddenCategory">
                                                <input type="text" id="dropdownSearchCategory" placeholder="" class="hiddenCategory" />
                                            </div>
                                            <ul id="optionsList" class="options-list hiddenCategory">
                                                @if(!empty($categories)) @foreach($categories as $category)
                                                <li class="single_item">
                                                    <span class="option" data-value="{{$category->id}}">{{$category->name}}</span>
                                                    @if ($category->subcategories) @foreach($category->subcategories as $children)
                                                    <ul class="sub-options">
                                                        <li><span class="option" data-value="{{$children->id}}">{{$children->name}}</span></li>
                                                    </ul>
                                                    @endforeach @endif
                                                </li>
                                                @endforeach @endif
                                            </ul>
                                            <div class="dropdown-button-container hiddenCategory">
                                                <button type="button" id="dropdownSubmitBtnCategory"><iconify-icon icon="pajamas:plus"></iconify-icon> Create Category</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 select-full">
                                    <select class="js-example-placeholder-single-brand js-states brand_id" id="listinvbd1" name="brand_id">
                                        <option value="">Select Brands</option>
                                        @foreach($brands as $brand)
                                        <option value="{{@$brand->id}}">{{@$brand->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-12">
                            <!-- <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type="file" class="input-img prod_single_img" id="imageNewUpload" name="pro_image" accept=".png, .jpg, .jpeg" />
                                    <label for="imageNewUpload"><iconify-icon icon="material-symbols:edit"></iconify-icon> Edit</label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="addItemimagePreview" style='background: url("{{asset('unsync_assets/assets/images/image_placeholder.jpg')}}")'>
                                </div>
                            </div>
                        </div> -->
                        <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type="file" class="imageUpload prod_single_img"  name="pro_image" accept=".png, .jpg, .jpeg" />
                                        <a href="#" class="editLink"><iconify-icon class="editIcon" icon="material-symbols:edit"></iconify-icon> Edit</a>
                                    </div>
                                    <div class="avatar-preview">
                                        <div class="imagePreview iprev" style='background-image: url("{{asset('unsync_assets/assets/images/image_placeholder.jpg')}}")'></div>
                                    </div>
                                </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>
                                <textarea class="description" name="description" id="" cols="30" rows="10" placeholder="Description" required=""></textarea>
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
                                        <input type="file" name="product_image[]" multiple="" data-max_length="20" class="upload__inputfile multi_product_images" />
                                    </label>
                                </div>
                                <div class="upload__img-wrap"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 select-full b-space">
                        <select class="js-example-placeholder-single-currency js-states currency_id" id="listinvc1" name="currency">
                            <option value="">Currency</option>
                            <option value="1">Indian Rupee(INR, ₹)</option>
                            <option value="2">US Dollar(USD, $)</option>
                            <option value="3">Ukrainian Hryvnia(UAH, ₴)</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" class="is_duplicate" name="is_duplicate" value="false" />
                <input type="hidden" class="adjustment_id_d" name="adjustment_id" value="" />
            </form>
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="set_up">Product Information <span>(Variation)</span></h4>
                    <div class="form_view">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>
                                        <input type="text" class="fst_sku_d" name="" placeholder="SKU" required="" />
                                        <span>SKU</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>
                                        <input type="text" class="fst_purchase_price_d" name="" placeholder="Buying Price" required="" />
                                        <span>Buying Price</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>
                                        <input type="text" class="fst_sale_price_d" name="" placeholder="Selling Price" required="" />
                                        <span>Selling Price</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group end">
                                    <label>
                                        <input type="text" class="fst_tax_rate_d" name="" placeholder="Tax Rate" required="" />
                                        <span>Tax Rate</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group end">
                                    <label>
                                        <input type="text" class="fst_hsn_d" name="" placeholder="HSN" required="" />
                                        <span>HSN</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12 my-2">
                                <div class="form-group end">
                                    <!-- <select class="ddl-select fst_unit_id" name="" name="list"> -->
                                    <select class="js-example-placeholder-single-unit js-unit fst_unit_id" id="listaddunitt2">
                                        <option value="">Select Unit</option>
                                        @if(!empty($productUnits)) @foreach($productUnits as $unit)
                                        <option value="{{@$unit->id}}">{{@$unit->name}}</option>
                                        @endforeach @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="fst_variation_name_d" value="Regular" placeholder="Variation Name" />
                    <!-- </form> -->

                    <div class="table_view cretetable">
                        <div class="table-responsive">
                            <table id="" class="table" role="grid">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 4%;">
                                            <div class="sd_check">
                                                <input type="checkbox" name="layout" id="checkAllvariation" />
                                                <label class="pull-right text" for="checkAllvariation">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th class="variation_col" scope="col" style="width: 10%;">Variation</th>
                                        <th class="sku_col" scope="col" style="width: 10%;">SKU</th>
                                        <th class="purchase_col" scope="col" style="width: 7%;">Purchase Price</th>
                                        <th class="sale_col" scope="col" style="width: 7%;">Sale Price</th>
                                        <th class="tax_col" scope="col" style="width: 7%;">Tax rate</th>
                                        <th class="unit_col" scope="col" style="width: 10%;">Unit</th>
                                        <th class="stock_col" scope="col" style="width: 10%;">Stock</th>
                                        <th class="" scope="col" style="width: 10%;">Action</th>
                                    </tr>
                                    <div class="add_field_drop">
                                        <a href="#" class="search-toggle dropdown-toggle circle-hover" id="dropdownMenuButton01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <iconify-icon icon="pajamas:plus"></iconify-icon>
                                        </a>
                                        <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton01">
                                            <div class="card shadow-none m-0">
                                                <div class="card-body p-0">
                                                    <div class="p-3">
                                                        <a href="#" class="iq-sub-card pt-0">
                                                            <div class="sd_check">
                                                                <input type="checkbox" class="tabel_invtry_col_sorting" value="variation_col" name="variation_col_chk" id="showinvshipping" checked />
                                                                <label class="pull-right text" for="showinvshipping">Variation</label>
                                                            </div>
                                                        </a>
                                                        <a href="#" class="iq-sub-card pt-0">
                                                            <div class="sd_check">
                                                                <input type="checkbox" class="tabel_invtry_col_sorting" value="sku_col" name="sku_col_chk" id="showinvshipping1" checked />
                                                                <label class="pull-right text" for="showinvshipping1">SKU</label>
                                                            </div>
                                                        </a>
                                                        <a href="#" class="iq-sub-card pt-0">
                                                            <div class="sd_check">
                                                                <input type="checkbox" class="tabel_invtry_col_sorting" value="purchase_col" name="purchase_col_chk" id="showinvshipping2" checked />
                                                                <label class="pull-right text" for="showinvshipping2">Buying Price</label>
                                                            </div>
                                                        </a>
                                                        <a href="#" class="iq-sub-card pt-0">
                                                            <div class="sd_check">
                                                                <input type="checkbox" class="tabel_invtry_col_sorting" value="sale_col" name="sale_col_chk" id="showinvshipping3" />
                                                                <label class="pull-right text" for="showinvshipping3">Selling Price</label>
                                                            </div>
                                                        </a>
                                                        <a href="#" class="iq-sub-card pt-0">
                                                            <div class="sd_check">
                                                                <input type="checkbox" class="tabel_invtry_col_sorting" value="tax_col" name="tax_col_chk" id="showinvshipping5" />
                                                                <label class="pull-right text" for="showinvshipping5">Tax Rate(in %)</label>
                                                            </div>
                                                        </a>
                                                        <a href="#" class="iq-sub-card pt-0">
                                                            <div class="sd_check">
                                                                <input type="checkbox" class="tabel_invtry_col_sorting" value="stock_col" name="layout" id="showshipping6" checked />
                                                                <label class="pull-right text" for="showshipping6">Stock</label>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </thead>
                                <tbody class="variation_list">
                                    @foreach($productVariations as $productVariation)
                                    <tr class="hide-d">
                                        <td>
                                            <div class="sd_check">
                                                <input type="checkbox" name="layout" id="mtb2" />
                                                <label class="pull-right text" for="mtb2">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>{{$productVariation->variation_name}}</td>
                                        <td>{{$productVariation->variation_name}}</td>
                                        <td>{{$productVariation->purchase_price}}</td>
                                        <td>
                                            <div class="action_btn_a">
                                                <a href="#" class="edit_cta" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><iconify-icon icon="material-symbols:edit"></iconify-icon> Manage</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="variant_btn">
                        <button type="button" class="normal_btn fst_btn" onclick="AddFirstvarit(this)"><iconify-icon icon="ic:round-add"></iconify-icon> Add variation</button>
                        <button type="button" class="normal_btn show_variation_btn hide-d" data-btn-type="add"><iconify-icon icon="ic:round-add"></iconify-icon> Add variation</button>
                        <button type="button" class="normal_btn mstk_btn"><iconify-icon icon="ep:setting"></iconify-icon> Manage stock</button>
                    </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ............................add category popup -->
@include('allFrontendViews.product_inventory.category.popup.single_popup')

<!-- ............................add brand popup -->
<div class="modal fade twoside_modal same_cr_ec" id="addBrandPopup" tabindex="-1" role="dialog" aria-labelledby="manageStockPopupLabel" aria-hidden="true">
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
                                    <h5>Create New brand</h5>
                                    <a href="#"><iconify-icon icon="ph:info"></iconify-icon></a>
                                </div>
                                <div class="shi_body">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <input type="text" class="new_brand_name" name="new_brand_name" placeholder="Brand Name" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" class="edit_varit_id" value="" />
                                <div class="shi_footer">
                                    <button id="ch_to_table" class="done_btn show_stock" onclick="createAndAppendBrand(this)">Create Brand</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@push('custom-scripts')
<script>
    $("body").on("click", "#dropdownSubmitBtnCategory", function () {
        $("#createcategory").addClass("active");
        ReseCategoryPage();
    });

    function createAndAppendcategory(e) {
        if ($(".new_category_name").val() == "") {
            $(".new_category_name").css("border", "1px solid red");
            return false;
        } else {
            $(".new_category_name").css("border", "");
        }
        var form_data = new FormData();
        form_data.append("name", $(".new_category_name").val());
        form_data.append("parent_id", $(".parent_category_id").val());
        form_data.append("platform", "Unesync");
        form_data.append("guard", "WEB");
        $.ajax({
            url: APP_URL + "/api/CategoryAdd",
            data: form_data,
            type: "post",
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function (xhr) {
                block_gui_start();
                xhr.setRequestHeader("Authorization", "Bearer " + tokenString);
            },
            success: function (response) {
                block_gui_end();
                if (response.status == true) {
                    $(".new_category_name").val("");
                    $(".category_d").attr("data-value", response.data?.id);
                    $("#searchInputCategory").val(response.data?.name);

                    $(".options-list").append('<li> <span class="option" data-value="' + response.data?.id + '">' + response.data?.name + "</span></li>");
                    $("#addcateogryPopup").modal("hide");
                    $(".form_view").removeClass("deactive");

                    toastr.success(response?.message);
                } else {
                    toastr.error(response?.message);
                }
            },
            error: function (response) {
                block_gui_end();
                console.log("server side error");
            },
        });
    }
</script>

<!-- ....................................Add brand -->
<script>
    $("body").on("click", "#custom-button", function (e) {
        e.preventDefault();
        $(".js-example-placeholder-single-brand").select2("close");
        $("#addBrandPopup").modal("show");
    });

    function createAndAppendBrand(e) {
        if ($(".new_brand_name").val() == "") {
            $(".new_brand_name").css("border", "1px solid red");
            return false;
        } else {
            $(".new_brand_name").css("border", "");
        }
        var form_data = new FormData();
        form_data.append("name", $(".new_brand_name").val());
        form_data.append("platform", "Unesync");
        form_data.append("guard", "WEB");
        $.ajax({
            url: APP_URL + "/api/BrandAdd",
            data: form_data,
            type: "post",
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function (xhr) {
                block_gui_start();
                xhr.setRequestHeader("Authorization", "Bearer " + tokenString);
            },
            success: function (response) {
                block_gui_end();
                if (response.status == true) {
                    $(".new_brand_name").val("");
                    $(".brand_id").append('<option value="' + response.data?.id + '" > ' + response.data?.name + " <option/>");
                    $(".brand_id").val(response.data?.id);
                    $("#select2-listinvbd1-container").text(response.data?.name);
                    $("#addBrandPopup").modal("hide");
                    $(".form_view").removeClass("deactive");
                    $("#manageStockPopup").removeClass("show");

                    toastr.success(response?.message);
                } else {
                    toastr.error(response?.message);
                }
            },
            error: function (response) {
                block_gui_end();
                console.log("server side error");
            },
        });
    }
</script>

<script id="rendered-js">
    document.addEventListener("DOMContentLoaded", () => {
        const searchInput = document.getElementById("searchInputCategory");
        const dropdown = document.getElementById("dropdownCategory");
        const dropdownSearch = document.getElementById("dropdownSearchCategory");
        const optionsList = document.getElementById("optionsList");
        const dropdownButtonContainer = document.querySelector(".dropdown-button-container");
        const dropdownSubmitBtn = document.getElementById("dropdownSubmitBtnCategory");
        const options = document.getElementsByClassName("option");
        const searchWrapper = document.getElementById("search_wrapper");
        const result = document.getElementById("result");

        function clearPreviousSelection() {
            const selectedOption = document.querySelector(".option.selected");
            if (selectedOption) {
                selectedOption.classList.remove("selected");
            }
        }

        function selectOption(option) {
            clearPreviousSelection();
            option.classList.add("selected");
            updateSearchInputValue();
            closeDropdown();
        }

        Array.from(options).forEach((option) => {
            option.addEventListener("click", () => {
                selectOption(option);
                $(".witharrow").removeClass("open_arrow");
            });
        });

        function updateSearchInputValue() {
            const selectedOption = document.querySelector(".option.selected");
            if (selectedOption) {
                searchInput.value = selectedOption.innerText;
                searchInput.setAttribute("data-value", selectedOption.getAttribute("data-value"));
            } else {
                searchInput.value = "";
            }
        }

        function displaySelectedValue() {
            const selectedOption = document.querySelector(".option.selected");
            if (selectedOption) {
                // result.innerText = `Selected value: ${selectedOption.innerText}`;
            } else {
                // result.innerText = "No value selected";
            }
        }

        function openDropdown() {
            dropdownSearch.classList.remove("hiddenCategory");
            optionsList.classList.remove("hiddenCategory");
            dropdownButtonContainer.classList.remove("hiddenCategory");
            searchWrapper.classList.remove("hiddenCategory");
            setTimeout(() => {
                dropdownSearch.focus();
            }, 100);
            reinitializeOptions();
        }

        function closeDropdown() {
            dropdownSearch.classList.add("hiddenCategory");
            optionsList.classList.add("hiddenCategory");
            searchWrapper.classList.add("hiddenCategory");
            dropdownButtonContainer.classList.add("hiddenCategory");
        }

        function toggleDropdown() {
            if (dropdownSearch.classList.contains("hiddenCategory")) {
                openDropdown();
                $(".witharrow").addClass("open_arrow");
            } else {
                closeDropdown();
                $(".witharrow").removeClass("open_arrow");
            }
        }

        searchInput.addEventListener("click", toggleDropdown);
        // searchInput.addEventListener("click", openDropdown);

        dropdownSearch.addEventListener("input", () => {
            const searchText = dropdownSearch.value.toLowerCase();
            filterOptions(searchText);
        });

        function filterOptions(searchText) {
            const allOptions = document.querySelectorAll(".option, .sub-option");

            allOptions.forEach((option) => {
                const optionText = option.innerText.toLowerCase();

                option.style.display = optionText.includes(searchText) ? "block" : "none";
                const isExpanded = option.classList.contains("collapsed");
                if (!optionText.includes(searchText)) {
                    option.classList.remove("collapsed");
                    option.classList.add("expanded");

                    const subOptions = option.nextElementSibling;
                    if (subOptions && subOptions.classList.contains("sub-options")) {
                        subOptions.style.display = "block";
                    }
                }
            });
        }

        function reinitializeOptions() {
            $.ajax({
                url: APP_URL + "/api/CategoryList",
                type: "GET",
                dataType: "json",
                beforeSend: function (xhr) {
                    block_gui_start();
                    xhr.setRequestHeader("Authorization", "Bearer " + tokenString);
                },
                success: function (response) {
                    block_gui_end();
                    let newOptionsHtml = "";
                    $(".form_view").removeClass("deactive");
                    $(".mstk_btn").removeClass("hide-d");
                    for (var i = 0; i <= response.data.length; i++) {
                        if (response.data[i]?.name != "" && response.data[i]?.name != undefined && response.data[i]?.name != NaN) {
                            if(response.data[i]?.subcategories!='' && response.data[i]?.subcategories!=null && response.data[i]?.subcategories.length > 0){
                              newOptionsHtml += ' <li >';
                            }else{
                              newOptionsHtml += ' <li class="single_item">';    
                            }
                            newOptionsHtml += '   <span class="option" data-value="' + response.data[i]?.id + '">' + response.data[i]?.name + "</span>";
                            for (var j = 0; j <= response.data[i]?.subcategories.length; j++) {
                                if (response.data[i]?.subcategories[j]?.name != "" && response.data[i]?.subcategories[j]?.name) {
                                    newOptionsHtml += '   <ul class="sub-options">';
                                    newOptionsHtml += '         <li><span class="option" data-value="' + response.data[i]?.subcategories[j]?.id + '">' + response.data[i]?.subcategories[j]?.name + "</span></li>";
                                    newOptionsHtml += "    </ul>";
                                }
                            }
                            newOptionsHtml += " </li>";
                        }
                    }

                    optionsList.innerHTML = newOptionsHtml;
                    // Re-attach event listeners to the new options
                    const newOptions = document.getElementsByClassName("option");
                    Array.from(newOptions).forEach((option) => {
                        option.addEventListener("click", () => {
                            selectOption(option);
                            $(".witharrow").removeClass("open_arrow");
                        });
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("Error reinitializing options: " + textStatus);
                },
            });
        }

        Array.from(options).forEach((option) => {
            option.addEventListener("click", (event) => {
                const isExpanded = option.classList.contains("expanded");
                if (isExpanded) {
                    option.classList.remove("expanded");
                    option.classList.add("collapsed");
                } else {
                    option.classList.remove("collapsed");
                    option.classList.add("expanded");
                }

                // Hide/show suboptions
                const subOptions = option.nextElementSibling;
                if (subOptions && subOptions.classList.contains("sub-options")) {
                    subOptions.style.display = option.classList.contains("expanded") ? "block" : "none";
                }

                event.stopPropagation();
            });
        });

        dropdownSubmitBtn.addEventListener("click", () => {
            displaySelectedValue();
            closeDropdown();
        });

        document.addEventListener("click", (event) => {
            if (!dropdown.contains(event.target) && !searchInput.contains(event.target)) {
                closeDropdown();
            }
        });
    });
</script>

@endpush
