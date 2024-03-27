$("body").on("click", "#dropdownSubmitBtnCategory", function() {
    // $('#createcategory').addClass('active');
});
//assign popup
$("body").on("click", ".open_assignitems_btn", function(){
    var id = $(this).attr("data-id");
    //  id ='';
    $.ajax({
        url: APP_URL + "/api/CategoryAssignItem",
        type: 'post',
        data:{'id':id},
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                var itemHtml = [];

                for(var i=0; i<=response.data.length; i++){
                    if(response.data[i]?.productName!='' && response.data[i]?.productName!=null && response.data[i]?.productName!=undefined){
                        itemHtml += '<tr class="asign_tr_'+response.data[i]?.product_id+'">';
                        itemHtml += '<td>'+response.data[i]?.productName+'</td>';
                        itemHtml += '<td>'+response.data[i]?.vquantity+'</td>';
                        itemHtml += '<td style="text-align: right;">';
                        itemHtml += ' <div class="action_btn_a">';
                        itemHtml += '  <a href="javascript:void(0)" class="del_cta mange_v delete_assigne_item" data-id="'+response.data[i]?.product_id+'" ><iconify-icon icon="ic:round-delete"></iconify-icon> Remove Item</a>';
                        itemHtml += '   &nbsp;';
                        itemHtml += ' <a href = "javascript:void(0)" data-id="'+response.data[i]?.product_id+'"  class="edit_cta mange_v edit_assigne_item" > <iconify-icon icon="material-symbols:edit"></iconify-icon> Edit</a > ';
                        itemHtml += '</div>';
                        itemHtml += '  </td>';
                        itemHtml += '  </tr>';
                    }
                }

                $(".data_assign_item").empty().append(itemHtml);
                $(".category_id_d").val(id);
                $("#assignitemsPopup").modal("show");

            } else {
                toastr.error(response?.message);
            }
        },
        error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });

});

$("body").on("click", ".delete_assigne_item", function(){
   var id = $(this).attr("data-id");
    $.ajax({
        url: APP_URL + "/api/CategoryRemoveItem",
        data: {'product_id':id},
        type: 'post',
        beforeSend: function(xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
        },
        success: function(response) {
            block_gui_end();
            if (response.status == true) {
                $(".asign_tr_"+id).remove();
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
     window.history.pushState('', 'Product', produstURl);
     block_gui_start();
     window.location.reload();
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