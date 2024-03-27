$('body').on('change', '.base_unit_d', function () {
    var token =  $('meta[name="csrf-token"]').attr('content');
    var id = $(this).val();
    var url = "/productservice/get-sub-units";
    $.ajax({
        method: 'post',
        url: url,
        data: {'id':id, '_token':token},
        success: function (data) {
            if(data.length > 0){
           var html = [];
            for(var i=0; i<data.length; i++ ){
                html += '<option value='+data[i]?.id+' >'+data[i]?.name+' </option>'
            }
            $(".show_sub_unit").empty().html(html);
            $(".show_sub_unit").prop("required", false);

            commonLoader();
        }else{
            $(".show_sub_unit").empty()
            $(".show_sub_unit").prop("required", true);

          }
        },
        error: function (data) {
            data = data.responseJSON;
            show_toastr('Error', data.error, 'error')
        }
    });

});
$(document).on('change', '.category_d', function () {

    var token =  $('meta[name="csrf-token"]').attr('content');
    var id = $(this).val();
    var baseUrl = "productservice/get-sub-categories";
    $.ajax({
        method: 'post',
        url: baseUrl,
        data: {'id':id, '_token':token},
        success: function (resp) {
         if(resp.length > 0){
            var html = [];
            for(var i=0; i<resp.length; i++ ){
                html += '<option value='+resp[i]?.id+' >'+resp[i]?.name+' </option>'
            }
            $(".show_sub_category").empty().append(html);
            $(".show_sub_category").prop("required", true);
            $(".show_sub_div").removeClass("hide-d");
            commonLoader();
          }else{
            $(".show_sub_category").empty();
            $(".show_sub_category").prop("required", false);
            $(".show_sub_div").addClass("hide-d");
          }

        },
        error: function (resp) {
            resp = resp.responseJSON;
            show_toastr('Error', resp.error, 'error')
        }
    });
});