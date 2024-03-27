<!-- View Items Offcanvas -->
<div class="offcanvas offcanvas-end big_view" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel" style="overflow: scroll;">
    <div class="offcanvas-header">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        @if(@$has_edit_permission)
        <div class="card-header-toolbar">
            <div class="dropdown">
                <span class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown" aria-expanded="true">
                    <i class="ri-more-fill"></i>
                </span>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton2" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-140px, 24px, 0px);">
                    <a class="dropdown-item delete_product" href="javascript:void(0)">Delete Item</a>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="offcanvas-body">
        <form method="post" action="javascript:void(0)" id="productDetailForm">
            <div class="offcanvas_details">
                <div class="item_det">
                    <h2 class="item_disp_name"></h2>
                    <ul class="nav nav-tabs" id="myTab-two" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab-two" data-toggle="tab" href="#home-two" role="tab" aria-controls="home" aria-selected="true">Item Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab-two" data-toggle="tab" href="#profile-two" role="tab" aria-controls="profile" aria-selected="false">Transactions</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent-1">
                        <div class="tab-pane fade show active" id="home-two" role="tabpanel" aria-labelledby="home-tab-two">
                            <div class="od_card">
                                <div class="od_card_header">
                                    <h3>Item Details</h3>
                                    @if(@$has_edit_permission)
                                    <a href="#" class="edit_btn item_detail_card_d" data-type="edit">Edit</a>
                                    @endif
                                </div>
                                <div class="od_card_body">
                                    <ul>
                                        <li>
                                            <label for="">Item name</label>
                                            <input type="text" class="item_name_d inp_item_detail" name="" value="" id="" disabled>
                                        </li>
                                        <li>
                                            <label for="">Description</label>
                                            <textarea class="item_description_d inp_item_detail" name="" id="" cols="" rows="" disabled>
                                                </textarea>
                                        </li>
                                        <li>
                                            <label for="">Currency</label>
                                            <select class="js-example-placeholder-single-currency js-states item_currency_d inp_item_detail" id="listinvc2" aria-label="Default select example" disabled>

                                                <option value=""> Select Currency</option>
                                                <option value="1">Indian Rupee(INR, ₹)</option>
                                                <option value="2">US Dollar(USD, $)</option>
                                                <option value="3">Ukrainian Hryvnia(UAH, ₴)</option>
                                            </select>
                                        </li>
                                        <li>
                                            <label for="">Brands</label>
                                            <select class="js-example-placeholder-single-brand js-states item_brand_d inp_item_detail" id="listinvbd12" aria-label="Default select example" disabled>
                                                <option value="">Select Brand</option>
                                                @foreach($brands as $brand)
                                                <option value="{{@$brand->id}}">{{@$brand->name}} </option>
                                                @endforeach
                                            </select>
                                        </li>
                                        <li>
                                            <label for="">Categories</label>
                                            <!-- <select class="form-select item_category_d inp_item_detail" aria-label="Default select example" disabled>
                                            <option value="">Select Categories</option>
                                            @foreach($categories as $category)
                                            <option value="{{@$category->id}}">{{@$category->name}} </option>
                                            @endforeach
                                        </select> -->

                                            <div class="searchable-select-container ondisable">
                                                <div class="witharrow">
                                                    <input type="text" id="searchInputCategory2" class="edit_category_d" placeholder="Select Category" readonly disabled />
                                                    <span class="selection__arrow" role="presentation"><b role="presentation"></b></span>
                                                </div>
                                                <div id="dropdownCategory2" class="dropdownCategory">
                                                    <div id="search_wrapper2" class="hiddenCategory">
                                                        <input type="text" id="dropdownSearchCategory2" placeholder="" class="hiddenCategory" inp_item_detail />
                                                    </div>
                                                    <ul id="optionsList2" class="options-list hiddenCategory">
                                                        @if(!empty($categories))
                                                        @foreach($categories as $category)
                                                        <li>
                                                            <span class="option" data-value="{{$category->id}}">{{$category->name}}</span>
                                                            @if ($category->subcategories)
                                                            @foreach($category->subcategories as $children)
                                                            <ul class="sub-options">
                                                                <li><span class="option" data-value="{{$children->id}}">{{$children->name}}</span></li>
                                                            </ul>
                                                            @endforeach
                                                            @endif
                                                        </li>
                                                        @endforeach
                                                        @endif
                                                    </ul>
                                                    <div class="dropdown-button-container2 hiddenCategory">
                                                        <!-- <button id="dropdownSubmitBtnCategory2"><iconify-icon icon="pajamas:plus"></iconify-icon> Create Category</button> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <input type="hidden" class="pid" value="">
                                </div>
                            </div>

                            <div class="od_card">
                                <div class="od_card_header">
                                    <h3>Product Information (Variation)</h3>
                                    @if(@$has_edit_permission)
                                    <div class="variant_btn">
                                        <button class="btn show_variation_btn" data-btn-type="edit"><iconify-icon icon="ic:round-add"></iconify-icon> Add variation</button>
                                    </div>
                                    @endif
                                </div>
                                <div class="od_card_body">
                                    <div class="table_view ediItemtable">
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
                                                        <th class="sale_col " scope="col" style="width: 7%;">Sale Price</th>
                                                        <th class="tax_col " scope="col" style="width: 7%;">Tax rate</th>
                                                        <th class="unit_col" scope="col" style="width: 10%;">Unit</th>
                                                        <th class="stock_col" scope="col" style="width: 10%;">Stock</th>
                                                        @if(@$has_edit_permission)
                                                        <th scope="col" style="width: 10%;">Action</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody class="variation_list edit_variation_list">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="od_card">
                                <div class="od_card_header">
                                    <h3>Item Image</h3>
                                    @if(@$has_edit_permission)
                                    <a href="#" class="edit_btn item_media_card_d" data-type="edit">File Upload</a>
                                    @endif
                                </div>
                                <div class="od_card_body">
                                    <!-- <div class="form-group fprof edit_single_up_box hide-d">
                                        <label for="">Item Image</label>
                                        <div class="single_image">
                                            <span class="btn_upload">
                                                <input type="file" id="imag" title="" name="edit_pro_image" class="input-img prod_single_img" />
                                                <iconify-icon icon="ic:round-plus"></iconify-icon> Upload Image
                                            </span>
                                            <img id="ImgPreview" src="" class="preview" />
                                            <button type="button" id="removeImage1" class="btn-rmv1"><iconify-icon icon="ic:round-close"></iconify-icon></button>
                                        </div>
                                    </div> -->
                                    <div class="dropzone dz-default      dz-message edit_single_up_box hide-d" id="desktop_single_item_media">
                                    </div>
                                    <div class="row" id="desktop_images">
                                    </div>
                                    <ul>
                                        <li class="show_db_single_media">
                                            <div class="file_item">
                                                <div>
                                                    <span>
                                                        <img src="" alt="">
                                                    </span>
                                                    <h6>No media found</h6>
                                                </div>
                                                <div class="iabtn">
                                                    <!-- <a href="#"><iconify-icon icon="mingcute:delete-2-line"></iconify-icon></a> -->
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="od_card last">
                                <div class="od_card_header">
                                    <h3>Item Original Images</h3>
                                    @if(@$has_edit_permission)
                                    <a href="#" class="edit_btn item_multi_media_card_d" data-type="edit">File Upload</a>
                                    @endif
                                </div>
                                <div class="od_card_body">
                                    <div class="dropzone dz-default dz-message edit_mul_up_box hide-d" id="desktop_multi_item_media">
                                    </div>
                                    <div class="row" id="desktop_multi_item_images">
                                    </div>
                                    <div class="form-group">
                                        <!-- <div class="upload__box edit_mul_up_box  hide-d">
                                            <div class="upload__btn-box">
                                            <label class="upload__btn">
                                                <p><iconify-icon icon="ic:round-plus"></iconify-icon> Upload images</p>
                                                <input type="file" id="multi_edit_product_images" name="product_image[]" multiple="" data-max_length="20" class="upload__inputfile ">
                                            </label>
                                        </div> 
                                            <div class="upload__img-wrap"></div>
                                           
                                        </div> -->
                                        <ul>
                                            <li class="show_db_multi_media">
                                                <div class="file_item">
                                                    <div>
                                                        <span>
                                                            <img src="" alt="">
                                                        </span>
                                                        <h6>No media found</h6>
                                                    </div>
                                                    <div class="iabtn">
                                                        <!-- <a href="#"><iconify-icon icon="mingcute:delete-2-line"></iconify-icon></a> -->
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile-two" role="tabpanel" aria-labelledby="profile-tab-two">
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
                                        <tbody id="item_transactional_history_tble">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- </form> -->
</div>

@push('custom-scripts')

<script id="rendered-js">
    document.addEventListener("DOMContentLoaded", () => {
        const searchInput = document.getElementById("searchInputCategory2");
        const dropdown = document.getElementById("dropdownCategory2");
        const dropdownSearch = document.getElementById("dropdownSearchCategory2");
        const optionsList = document.getElementById("optionsList2");
        const dropdownButtonContainer = document.querySelector(".dropdown-button-container2");
        const dropdownSubmitBtn = document.getElementById("dropdownSubmitBtnCategory2");
        const options = document.getElementsByClassName("option");
        const searchWrapper = document.getElementById("search_wrapper2");
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
                url: APP_URL + '/api/CategoryList',
                type: "GET",
                dataType: "json",
                beforeSend: function(xhr) {
                    block_gui_start();
                    xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

                },
                success: function(response) {
                    block_gui_end();
                    let newOptionsHtml = '';
                    $(".form_view").removeClass("deactive");
                    $(".mstk_btn").removeClass("hide-d");
                    for (var i = 0; i <= response.data.length; i++) {
                        if (response.data[i]?.name != '' && response.data[i]?.name != undefined && response.data[i]?.name != NaN) {
                            newOptionsHtml += ' <li>';
                            newOptionsHtml += '   <span class="option" data-value="' + response.data[i]?.id + '">' + response.data[i]?.name + '</span>';
                            for (var j = 0; j <= response.data[i]?.subcategories.length; j++) {
                                if (response.data[i]?.subcategories[j]?.name != '' && response.data[i]?.subcategories[j]?.name) {
                                    newOptionsHtml += '   <ul class="sub-options">';
                                    newOptionsHtml += '         <li><span class="option" data-value="' + response.data[i]?.subcategories[j]?.id + '">' + response.data[i]?.subcategories[j]?.name + '</span></li>';
                                    newOptionsHtml += '    </ul>';
                                }
                            }
                            newOptionsHtml += ' </li>';
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
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error reinitializing options: " + textStatus);
                }
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