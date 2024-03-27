<!-- Assign Items -->
<div class="modal fade twoside_modal same_cr_ec" id="addcateogryPopup" tabindex="-1" role="dialog" aria-labelledby="assignitemsPopupLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="shinvite">
                            <div class="shi_header">
                                <h5>Categories</h5>
                                <!-- <span>
                                    <a href="#" class="blue_purl"><iconify-icon icon="pajamas:plus"></iconify-icon> Add new item</a>
                                    <a href="#"><iconify-icon icon="ph:info"></iconify-icon></a>
                                </span> -->
                            </div>
                            <div class="shi_body">
                                @if(@$has_edit_permission)
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-xs-12">
                                        <h4>Create new category</h4>
                                        <br />
                                        <div class="form-group withbutton">
                                            <div class="inputGroup">
                                                <input type="text" class="new_category_name" name="new_category_name" placeholder="">
                                                <label for="name">Category Name</label>
                                            </div>
                                            <button class="create_brand_btn" onclick="createNewcategory(this)">Create Category</button>
                                        </div>
                                        <div class="customer_created hide_default hide-d">
                                            <div class="cc_card">
                                                <lottie-player src="https://lottie.host/a6963a1c-1049-4992-a95a-d016d2d07948/fVRIDbvFti.json" background="transparent" speed="1" style="width: 100px; height: 100px;" loop autoplay></lottie-player>
                                                <div class="content_cc">
                                                    <h6>Category created successfully</h6>
                                                    <p>This Category is created successfully now you can skip and go to dashboard</p>
                                                    <a href="#">Go to dashboard</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <market-divider class="market-divider" margin="medium" hydrated=""></market-divider>
                                <div class="table_view" style="display: block;">
                                    <div id="category_table_listing">
                                        <!-- //append HTML -->
                                        <?php echo $response['content']; ?>
                                    </div>
                                </div>  
                            </div>
                            <div class="shi_footer">
                                <!-- <button id="ch_to_table" class="done_btn" data-dismiss="modal" aria-label="Close">Save</button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom-scripts')
@push('custom-scripts')
<script>
    var singleCategoryUrl = <?= json_encode(route('fn.inventory.get_single_category')) ?>
    var prodUrl = <?= json_encode(route('fn.inventory', $enypt_id)) ?>;
</script>
<!-- <script src="{{asset('js/custom/category.js')}}"></script> -->
@endpush
<script>
    function createNewcategory(e) {
        if ($(".new_category_name").val() == '') {
            $(".new_category_name").css("border", "1px solid red");
            return false;
        } else {
            $(".new_category_name").css("border", "");

        }
        var form_data = new FormData();
        form_data.append('name', $(".new_category_name").val());
        form_data.append('parent_id', 0);
        form_data.append('platform', "Unesync");
        form_data.append('guard', "WEB");
        $.ajax({
            url: APP_URL + "/api/CategoryAdd",
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
                    $(".new_category_name").val('');
                    $(".category_d").attr('data-value', response.data?.id);
                    $("#searchInputCategory").val(response.data?.name);

                    $(".options-list").append('<li> <span class="option" data-value="' + response.data?.id + '">' + response.data?.name + '</span></li>')
                    $("#addcateogryPopup").modal("hide");
                    $(".form_view").removeClass("deactive");

                    $("#addsubcategoryPopup").modal("hide");
                    toastr.success(response?.message);
                    get_categories();
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

    function get_categories() {
        $.ajax({
            url: APP_URL + "/api/CategoryList",
            // data: form_data,
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
                    $(".new_category_name").val('');
                    toastr.success(response?.message);
                    // ReseCategoryPage();
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