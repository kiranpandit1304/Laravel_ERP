  <!-- Create Brand - Bottom Full Screen Popup -->
  <div class="cibsp" id="createbrand">
      <div class="cibsp_header">
          <a href="#" class="close_cibsp" id="close_createbrand"><iconify-icon icon="material-symbols:close-rounded"></iconify-icon></a>
          <!-- <a href="#" class="close_cibsp" id="close_createbrand"><iconify-icon icon="material-symbols:close-rounded"></iconify-icon></a> -->
          <!-- <button>Save</button> -->
      </div>
      <div class="mini_continer">
          <div class="cibsp_body">
              @if(@$has_edit_permission)
              <div class="row">
                  <div class="col-lg-12 col-sm-12 col-xs-12">
                      <h4>Create new brand</h4>
                      <br />
                      <div class="form-group withbutton">
                          <label>
                              <input type="text" class="brand_name" name="brand_name" required="" id=""  placeholder="Brand Name"/>
                              <span>Brand Name</span>
                              </label>
                          <button class="create_brand_btn" onclick="createBrand(this)">Create Brand</button>
                      </div>
                      <div class="customer_created hide_default hide-d">
                          <div class="cc_card">
                              <lottie-player src="https://lottie.host/a6963a1c-1049-4992-a95a-d016d2d07948/fVRIDbvFti.json" background="transparent" speed="1" style="width: 100px; height: 100px;" loop autoplay></lottie-player>
                              <div class="content_cc">
                                  <h6>Brand created successfully</h6>
                                  <p>This Brand is created successfully now you can skip and go to dashboard</p>
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
                              <h6 class="sp_div">List of Brands</h6>
                              <div class="show_check dbrands">
                                  <button class="delete">Delete Brand</button>
                                  <span>1 Brand Selected</span>
                              </div>
                              <form class="mr-3 position-relative">
                                  <div class="form-group mb-0">
                                      <input type="search" class="form-control brand_sch" id="brandInputSearch" placeholder="Search" aria-controls="user-list-table">
                                      <iconify-icon class="brnd_search_btn" icon="carbon:search" onclick="filterBrand(this)"></iconify-icon>
                                      <iconify-icon class="search_reset_btn hide-d" icon="system-uicons:reset" onclick="ResetFilterBrand(this)"></iconify-icon>
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
                  <div id="brand_table_listing">
                      <!-- //append HTML -->
                      <?php echo $response['content']; ?>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- .......................Edit Brand -->
  <div class="modal fade twoside_modal same_cr_ec" id="editbrandPopup" tabindex="-1" role="dialog" aria-labelledby="editbrandPopupLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
              <button type="button" class="close bd_edit_cross_btn" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
              </button>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-lg-12 col-sm-12 col-xs-12">
                          <div class="shinvite">
                              <div class="shi_header">
                                  <h5>Edit Brand</h5>
                                  <a href="#"><iconify-icon icon="ph:info"></iconify-icon></a>
                              </div>
                              <div class="shi_body">
                                  <div class="row">
                                      <div class="col-lg-12">
                                          <div class="form-group">
                                              <input type="text" class="brand_edit_name" placeholder="" value="Unesync">
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <input type="hidden" class="brand_edit_id" placeholder="" value="">

                              <div class="shi_footer">
                                  <button id="ch_to_table" class="done_btn save_brand_single">Save</button>
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
      $('body').on('click', '.brand_pagination a', function(e) {
          e.preventDefault();
          $('#load a').css('color', '#dfecf6');
          $('#load').append('<img style="position: absolute; left: 0; top: 0; articles/listingz-index: 100000;" src="/images/loading.gif" />');
          var url = $(this).attr('href');
          var page_number = get_parameter_val("page", url);
          var url = window.location.href;
          var url = updateQueryStringParameter(url, "page", page_number);
          // var data = make_final_parameters_object(url);
          // data = makeDataObject(data);
          ReseBrandPage('', page_number);
          window.history.pushState("", "", url);
      });
      $(document).on('keypress', ".brand_sch", function(e) {
          if (e.which == 13) {
              e.preventDefault();
              var search = $("#brandInputSearch").val();
              ReseBrandPage(search);
          }
      });

      function filterBrand() {
          var search = $("#brandInputSearch").val();
          ReseBrandPage(search);
          $(".brnd_search_btn").addClass("hide-d");
          $(".search_reset_btn").removeClass("hide-d");
      };

      function ResetFilterBrand() {
          $("#brandInputSearch").val('');
          $(".search_reset_btn").addClass("hide-d");
          $(".brnd_search_btn").removeClass("hide-d");
          ReseBrandPage();
      }
      $("body").on("click", "#close_createbrand", function() {
          var prodUrl = <?= json_encode(route('fn.inventory', $enypt_id)) ?>;
          $('#createbrand').removeClass('active');
          window.history.pushState('', 'Product', prodUrl);
          block_gui_start();
          window.location.reload();
      });

      function createBrand(e) {

          if ($(".brand_name").val() == '') {
              $(".brand_name").css("border", "1px solid red");
              return false;
          } else {
              $(".brand_name").css("border", "");

          }
          var form_data = new FormData();
          form_data.append('name', $(".brand_name").val());
          form_data.append('platform', "Unesync");
          form_data.append('guard', "WEB");
          $.ajax({
              url: APP_URL + "/api/BrandAdd",
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
                      $(".brand_name").val('');
                      toastr.success(response?.message);
                      ReseBrandPage();
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

      $("body").on("click", ".bd_edit_cross_btn", function() {
          $('#editbrandPopup').modal('hide');
      });

      function getSinglebrand(event) {
          var bid = $(event).attr("data-id");
          $.ajax({
              url: <?= json_encode(route('fn.inventory.get_single_brand')) ?> + '/' + bid,
              type: "GET",
              dataType: 'json',
              beforeSend: function(xhr) {
                  block_gui_start();

              },
              success: function(response) {
                  block_gui_end();
                  $('.brand_edit_id').val(response?.data?.id);
                  $('.brand_edit_name').val(response?.data?.name);
                  $('#editbrandPopup').modal('show');
              },
              error: function(response) {
                  block_gui_end();
                  console.log("server side error");
              }
          });
      }
      $("body").on("click", ".save_brand_single", function(e) {
          e.preventDefault();
          if ($(".brand_edit_id").val() == '') {
              $(".brand_edit_id").css("border", "1px solid red");
              return false;
          } else {
              $(".brand_edit_id").css("border", "");

          }
          var form_data = new FormData();
          form_data.append('id', $(".brand_edit_id").val());
          form_data.append('name', $(".brand_edit_name").val());
          form_data.append('platform', "Unesync");
          form_data.append('guard', "WEB");
          $.ajax({
              url: APP_URL + "/api/BrandEdit",
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
                      $('#editbrandPopup').modal('hide');

                      ReseBrandPage();
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

      function trashBrand(event) {
          var mid = $(event).attr("data-id");
          $.ajax({
              url: APP_URL + "/api/BrandDelete/" + mid,
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
                      ReseBrandPage();
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

      $("body").on("click", "#checkAllbrand", function() {
          $('input:checkbox').not(this).prop('checked', this.checked);
          $(".selected_count").html($('.customerChkBox').filter(':checked').length + ' User Selected');
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
  </script>
  @endpush