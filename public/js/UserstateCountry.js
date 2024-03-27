$('body').on('change', '.ucountry', function () {
    var token =  $('meta[name="csrf-token"]').attr('content');
    var country_id = $(this).val();
    var url = "/get-state-list";
    $.ajax({
        method: 'post',
        url: url,
        data: {'country_id':country_id, '_token':token},
        success: function (data) {
           var html = [];
            for(var i=0; i<data.length; i++ ){
                if(data[i]?.name)
                  html += '<option value='+data[i]?.id+' >'+data[i]?.name+' </option>'
            }
            $(".ustate").empty().html(html);
            commonLoader();
        },
        error: function (data) {
            data = data.responseJSON;
            show_toastr('Error', data.error, 'error')
        }
    });

});

$('body').on('change', '.profileCountry', function () {
     var country_id = $(this).val();
    var url = APP_URL +"/api/stateList/"+country_id;
    $.ajax({
        method: 'get',
        url: url,
        // data: {'id':country_id},
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

        },
        success: function (response) {
           var html = [];
           block_gui_end();
          var data=response.data;
            for(var i=0; i<data.length; i++ ){
                if(data[i]?.name)
                  html += '<option value='+data[i]?.id+' >'+data[i]?.name+' </option>'
            }
            $(".profileState").empty().html(html);
            commonLoader();
        },
        error: function (response) {
            block_gui_end();
            console.log("server side error");        }
    });

});

$('body').on('change', '.sv_shipping_country', function () {
    var token =  $('meta[name="csrf-token"]').attr('content');
    var country_id = $(this).val();
    var url = "/get-state-list";
    $.ajax({
        method: 'post',
        url: url,
        data: {'country_id':country_id, '_token':token},
        success: function (data) {
           var html = [];
            for(var i=0; i<data.length; i++ ){
                if(data[i]?.name)
                  html += '<option value='+data[i]?.id+' >'+data[i]?.name+' </option>'
            }
            $(".shp_state").empty().html(html);
            commonLoader();
        },
        error: function (data) {
            data = data.responseJSON;
            show_toastr('Error', data.error, 'error')
        }
    });

});
$('body').on('change', '.bk_country', function () {
    var token =  $('meta[name="csrf-token"]').attr('content');
    var country_id = $(this).val();
    var url = "/get-state-list";
    $.ajax({
        method: 'post',
        url: url,
        data: {'country_id':country_id, '_token':token},
        success: function (data) {
           var html = [];
            for(var i=0; i<data.length; i++ ){
                if(data[i]?.name)
                  html += '<option value='+data[i]?.id+' >'+data[i]?.name+' </option>'
            }
            $(".bnk_state").empty().html(html);
            commonLoader();
        },
        error: function (data) {
            data = data.responseJSON;
            show_toastr('Error', data.error, 'error')
        }
    });

});
$(document).on('change', '.ustate', function () {

    var token =  $('meta[name="csrf-token"]').attr('content');
    var state_id = $(this).val();
    var baseUrl = "/get-city-list";
    $.ajax({
        method: 'post',
        url: baseUrl,
        data: {'state_id':state_id, '_token':token},
        success: function (resp) {
            var html = [];
            for(var i=0; i<resp.length; i++ ){
                if(resp[i]?.name)
                 html += '<option value='+resp[i]?.id+' >'+resp[i]?.name+' </option>'
            }
            $(".ucities").empty().append(html);
            commonLoader();
        },
        error: function (resp) {
            resp = resp.responseJSON;
            show_toastr('Error', resp.error, 'error')
        }
    });
});