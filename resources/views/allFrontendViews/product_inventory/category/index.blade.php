 <style>
     div#createcategory {
         z-index: 999999;
     }
 </style>
 <!-- Create Brand - Bottom Full Screen Popup -->
 <div class="cibsp" id="createcategory" style="">
     <div class="cibsp_header">
         <a href="#" class="close_cibsp1" id="close_createcategory"><iconify-icon icon="material-symbols:close-rounded"></iconify-icon></a>
         <!-- <a href="#" class="close_cibsp" id="close_createcategory"><iconify-icon icon="material-symbols:close-rounded"></iconify-icon></a> -->
         <!-- <button>Save</button> -->
     </div>
     <div class="mini_continer">
         <div class="cibsp_body">
             @if(@$has_edit_permission)
             <div class="row">
                 <div class="col-lg-12 col-sm-12 col-xs-12">
                     <h4>Create new category</h4>
                     <br />
                     <div class="form-group withbutton">
                         <label>
                             <input type="text" class="category_name" name="category_name" placeholder="Category Name">
                             <span>Category Name</span>
                         </label>
                         <button class="create_brand_btn" onclick="createcategory(this)">Create Category</button>
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
             <div class="part_gray">
                 <div class="row">
                     <div class="col-lg-12 col-sm-12 col-xs-12">
                         <div class="align_search">
                             <h6 class="sp_div">List of Categories</h6>
                             <div class="show_check dbrands">
                                 <button class="delete">Delete Category</button>
                                 <span>1 Category Selected</span>
                             </div>
                             <form class="mr-3 position-relative">
                                 <div class="form-group mb-0">
                                     <input type="search" class="form-control category_sch" id="categoryInputSearch" placeholder="Search" aria-controls="user-list-table">
                                     <iconify-icon class="search_btn  " icon="carbon:search" onclick="filterCategory(this)"></iconify-icon>
                                     <iconify-icon class="search_reset_btn hide-d" icon="system-uicons:reset" onclick="ResetFilterCategory(this)"></iconify-icon>
                                 </div>
                             </form>
                         </div>
                     </div>
                 </div>
                 <div id="category_table_listing">
                     <!-- //append HTML -->
                     <?php echo $response['content']; ?>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- .......................Edit Category -->
 <div class="modal fade twoside_modal same_cr_ec" id="editCategoryopup" tabindex="-1" role="dialog" aria-labelledby="editCategoryopupLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <button type="button" class="close cat_edit_cross_btn" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">×</span>
             </button>
             <div class="modal-body">
                 <div class="row">
                     <div class="col-lg-12 col-sm-12 col-xs-12">
                         <div class="shinvite">
                             <div class="shi_header">
                                 <h5>Edit Category</h5>
                                 <a href="#"><iconify-icon icon="ph:info"></iconify-icon></a>
                             </div>
                             <div class="shi_body">
                                 <div class="row">
                                     <div class="col-lg-12">
                                         <div class="form-group">
                                             <input type="text" class="category_edit_name" placeholder="" value="Unesync">
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <input type="hidden" class="category_edit_id" placeholder="" value="">

                             <div class="shi_footer">
                                 <button id="ch_to_table" class="done_btn save_category_single">Save</button>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- Create Sub-Category -->
 <div class="modal fade twoside_modal same_cr_ec" id="addsubcategoryPopup" style="z-index: 999999;" tabindex="-1" role="dialog" aria-labelledby="addsubcategoryPopupLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <button type="button" class="close" data-dismiss="modal" id="crossbtnsubcategory" aria-label="Close">
                 <span aria-hidden="true">×</span>
             </button>
             <div class="modal-body">
                 <div class="row">
                     <div class="col-lg-12 col-sm-12 col-xs-12">
                         <div class="shinvite">
                             <div class="shi_header">
                                 <h5>Create Sub-Category</h5>
                                 <a href="#"><iconify-icon icon="ph:info"></iconify-icon></a>
                             </div>
                             <div class="shi_body">
                                 <div class="row">
                                     <div class="col-lg-12">
                                         <div class="form-group">
                                            <label>
                                                <input type="text" class="category_sub_name" placeholder="Enter Sub Category">
                                                <span>Enter Sub Category</span>
                                             </label>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <input type="hidden" class="parent_category_id">
                             <div class="shi_footer">
                                 <!-- <button id="ch_to_table" class="done_btn " data-dismiss="modal" aria-label="Close">Save & Create</button> -->
                                 <button id="ch_to_table" class="done_btn save_sub_category">Save & Create</button>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 @include('allFrontendViews.product_inventory.category.assignItem')

 @push('custom-scripts')
 <script>
     var singleCategoryUrl = <?= json_encode(route('fn.inventory.get_single_category')) ?>;
     var produstURl = <?= json_encode(route('fn.inventory', $enypt_id)) ?>;
 </script>
 <!-- <script src="{{asset('js/custom/category.js')}}"></script> -->
 <script>
     //assign popup
     $("body").on("click", ".open_assignitems_btn", function() {
        var id = $(this).attr("data-id");
         var type = $(this).attr("data-type");
         $(".cat_selcted_type").val(type);
         getAssignItem(id, type);
     });
     $("body").on("change", ".assignitems_dropdown", function() {
         var id = $(this).val();
         getAssignItem(id);
     });

     function getAssignItem(id, type='') {
        type=  $(".cat_selcted_type").val();
         $.ajax({
             url: APP_URL + "/api/CategoryAssignItem",
             type: 'post',
             data: {
                 'id': id
             },
             beforeSend: function(xhr) {
                 block_gui_start();
                 xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
             },
             success: function(response) {
                 block_gui_end();
                 if (response.status == true) {
                     var itemHtml = [];

                     for (var i = 0; i <= response.data.length; i++) {
                         if (response.data[i]?.variation_name != '' && response.data[i]?.variation_name != null && response.data[i]?.variation_name != undefined) {
                             itemHtml += '<tr class="asign_tr_' + response.data[i]?.product_id + '">';
                            //  if(response.data[i]?.variation_name=='Regular')
                            //  itemHtml += '<td>' + response.data[i]?.productName + ' ' + response.data[i]?.variation_name + '</td>';
                            //  else
                             itemHtml += '<td>' + response.data[i]?.productName + '</td>';

                             if (response.data[i]?.vquantity != '' && response.data[i]?.vquantity != null && response.data[i]?.vquantity != undefined)
                                 itemHtml += '<td>' + response.data[i]?.vquantity + '</td>';
                             else
                                 itemHtml += '<td>0</td>';

                             itemHtml += '<td style="text-align: right;">';
                             itemHtml += ' <div class="action_btn_a">';
                             itemHtml += '  <a href="javascript:void(0)" class="del_cta mange_v delete_assigne_item" data-id="' + response.data[i]?.product_id + '" ><iconify-icon icon="ic:round-delete"></iconify-icon> Remove Item</a>';
                             // itemHtml += '   &nbsp;';
                             // itemHtml += ' <a href = "javascript:void(0)" data-id="'+response.data[i]?.product_id+'"  class="edit_cta mange_v edit_assigne_item" > <iconify-icon icon="material-symbols:edit"></iconify-icon> Edit</a > ';
                             itemHtml += '</div>';
                             itemHtml += '  </td>';
                             itemHtml += '  </tr>';
                         }
                     }

                     $(".data_assign_item").empty().append(itemHtml);

                     var subCatHtml = [];
                     if(type == 'main_category'){
                     if(response.categorySubAssignItemList.length > 0 && response.categorySubAssignItemList.length != ''){
                     for (var j = 0; j <= response.categorySubAssignItemList.length; j++) {
                         if (response.categorySubAssignItemList[j]?.productName != '' && response.categorySubAssignItemList[j]?.productName != null && response.categorySubAssignItemList[j]?.productName != undefined) {
                             subCatHtml += '<option value="' + response.categorySubAssignItemList[j]?.product_id + '" >' + response.categorySubAssignItemList[j]?.productName + '</option>';
                         }
                     }
                       $(".shw_aprent_dropdown").removeClass("hide-d");
                    }
                  }else{
                    $(".shw_aprent_dropdown").addClass("hide-d");

                  }

                     $(".show_sub_cate_d").empty().append(subCatHtml);

                     $(".category_id_d").val(id);
                     $("#assignitemsPopup").modal("show");

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

     $("body").on("click", ".delete_assigne_item", function() {
         var id = $(this).attr("data-id");
         $.ajax({
             url: APP_URL + "/api/CategoryRemoveItem",
             data: {
                 'product_id': id
             },
             type: 'post',
             beforeSend: function(xhr) {
                 block_gui_start();
                 xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
             },
             success: function(response) {
                 block_gui_end();
                 if (response.status == true) {
                     $(".asign_tr_" + id).remove();
                     toastr.success(response?.message);
                     ReseCategoryPage();
                 } else {
                     toastr.error(response?.message);
                 }
             },
             error: function(response) {
                 block_gui_end();
                 console.log("server side error");
             }
         });

     });

     $('body').on('click', '.category_pagination a', function(e) {
         e.preventDefault();
         $('#load a').css('color', '#dfecf6');
         $('#load').append('<img style="position: absolute; left: 0; top: 0; articles/listingz-index: 100000;" src="/images/loading.gif" />');
         var url = $(this).attr('href');
         var page_number = get_parameter_val("page", url);
         var url = window.location.href;
         var url = updateQueryStringParameter(url, "page", page_number);
         // var data = make_final_parameters_object(url);
         // data = makeDataObject(data);
         ReseCategoryPage('', page_number);
         window.history.pushState("", "", url);
     });
     $(document).on('keypress', ".category_sch", function(e) {
         if (e.which == 13) {
             e.preventDefault();
             var search = $("#categoryInputSearch").val();
             ReseCategoryPage(search);
         }
     });

     function filterCategory() {
         var search = $("#categoryInputSearch").val();
         ReseCategoryPage(search);
         $(".search_btn").addClass("hide-d");
         $(".search_reset_btn").removeClass("hide-d");
     };

     function ResetFilterCategory() {
         $("#categoryInputSearch").val('');
         $(".search_reset_btn").addClass("hide-d");
         $(".search_btn").removeClass("hide-d");
         ReseCategoryPage();
     }

     $("body").on("click", "#close_createcategory", function() {
         $('#createcategory').removeClass('active');
         var purl = <?= json_encode(route('fn.inventory', $enypt_id)) ?>;
         window.history.pushState('', 'Product', purl);
         //  block_gui_start();
         //  window.location.reload();
     });

     function createcategory(e) {
         if ($(".category_name").val() == '') {
             $(".category_name").css("border", "1px solid red");
             return false;
         } else {
             $(".category_name").css("border", "");

         }
         var form_data = new FormData();
         form_data.append('name', $(".category_name").val());
         form_data.append('parent_id', 0);
         form_data.append('platform', "Unesync");
         form_data.append('guard', "WEB");
         categoryCreateRequest(form_data);
     }

     function categoryCreateRequest(form_data) {
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
                     $(".category_name").val('');
                     $(".category_sub_name").val('');
                     $("#addsubcategoryPopup").modal("hide");
                     toastr.success(response?.message);
                     ReseCategoryPage();
                     getBrandCategories();
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


     $("body").on("click", ".save_sub_category", function() {
         if ($(".category_sub_name").val() == '') {
             $(".category_sub_name").css("border", "1px solid red");
             return false;
         } else {
             $(".category_sub_name").css("border", "");

         }
         var id = '';
         var form_data = new FormData();
         form_data.append('name', $(".category_sub_name").val());
         form_data.append('parent_id', $(".parent_category_id").val());
         form_data.append('platform', "Unesync");
         form_data.append('guard', "WEB");
         categoryCreateRequest(form_data);
     });

     $("body").on("click", ".show_sub_cate_modal", function() {
         $(".category_sub_name").css("border", "");
         var cid = $(this).attr("data-id");
         $(".parent_category_id").val(cid);
         $("#addsubcategoryPopup").modal("show");
     });
     $("body").on("click", "#crossbtnsubcategory", function() {
         $(".category_sub_name").css("border", "");
         $("#addsubcategoryPopup").modal("hide");
     });

     $("body").on("click", ".cat_edit_cross_btn", function() {
         $('#editCategoryopup').modal('hide');
     });

     function getSingleCategory(event) {
         var bid = $(event).attr("data-id");
         $.ajax({
             url: singleCategoryUrl + '/' + bid,
             type: "GET",
             dataType: 'json',
             beforeSend: function(xhr) {
                 block_gui_start();

             },
             success: function(response) {
                 block_gui_end();
                 $('.category_edit_id').val(response?.data?.id);
                 $('.category_edit_name').val(response?.data?.name);
                 $('#editCategoryopup').modal('show');
             },
             error: function(response) {
                 block_gui_end();
                 console.log("server side error");
             }
         });
     }
     $("body").on("click", ".save_category_single", function(e) {
         e.preventDefault();
         if ($(".category_edit_name").val() == '') {
             $(".category_edit_name").css("border", "1px solid red");
             return false;
         } else {
             $(".category_edit_name").css("border", "");

         }
         var form_data = new FormData();
         form_data.append('id', $(".category_edit_id").val());
         form_data.append('name', $(".category_edit_name").val());
         form_data.append('platform', "Unesync");
         form_data.append('guard', "WEB");
         $.ajax({
             url: APP_URL + "/api/CategoryEdit",
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
                     $('#editCategoryopup').modal('hide');

                     ReseCategoryPage();
                 } else {
                     toastr.error(response?.message);
                 }
             },
             error: function(response) {
                 block_gui_end();
                 console.log("server side error");
             }
         });
     });

     function trashCategory(event) {
         var mid = $(event).attr("data-id");
         $.ajax({
             url: APP_URL + "/api/CategoryDelete/" + mid,
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
                     ReseCategoryPage();
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
     }

     $("body").on("click", "#checkAllcategory", function() {
         $('input:checkbox').not(this).prop('checked', this.checked);
     });
 </script>
 @endpush