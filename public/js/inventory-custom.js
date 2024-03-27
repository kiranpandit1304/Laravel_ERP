jQuery(document).ready(function () {
    $("#imag").change(function() {
        // add your logic to decide which image control you'll use
        var imgControlName = "#ImgPreview";
        readURL(this, imgControlName);
        $('.preview1').addClass('it');
        $('.btn-rmv1').addClass('rmv');
    });
    
    
    $("#removeImage1").click(function(e) {
        e.preventDefault();
        $("#imag").val("");
        $("#ImgPreview").attr("src", "");
        $('.preview1').removeClass('it');
        $('.btn-rmv1').removeClass('rmv');
    });

    // Change to table
    $("button#ch_to_table").click(function(e) {
        $('.table_view').addClass('active');
        $('.form_view').addClass('deactive');
    });


    // Change to add_vendor
    $("#manageveriPopup button.add_more.add_vendor").click(function(e) {
        $('.vendor_show').removeClass('hide');
        $('#manageveriPopup button.add_more.add_vendor').hide();
    });

    // Add to Custom Field
    $("#manageveriPopup button.add_more.add_field").click(function(e) {
        $('.custom_field').addClass('show');
        // $('#manageveriPopup button.add_more.add_vendor').hide();
    });
    $("a.hide_bar").click(function(e) {
        $('.custom_field').removeClass('show');
        // $('#manageveriPopup button.add_more.add_vendor').hide();
    });

    // Add to Custom Field2
    $("#adjustStockPopup .tab-content button.add_more.add_field").click(function(e) {
        $('.custom_field').addClass('show');
        // $('#manageveriPopup button.add_more.add_vendor').hide();
    });
    $("a.hide_bar").click(function(e) {
        $('.custom_field').removeClass('show');
        // $('#manageveriPopup button.add_more.add_vendor').hide();
    });


    // Add to Custom Field3
    $("#manageveriPopup button.add_more.alert_btn").click(function(e) {
        $('.custom_field_alert').addClass('show');
        // $('#manageveriPopup button.add_more.add_vendor').hide();
    });
    $("a.hide_bar").click(function(e) {
        $('.custom_field_alert').removeClass('show');
        // $('#manageveriPopup button.add_more.add_vendor').hide();
    });

    
    $("a.mange_v").click(function(e) {
        $('#manageStockPopup').removeClass('show');
        $('.modal-backdrop').removeClass('show');

        $('#manageveriPopup').addClass('show');
    });

    $("button#ch_to_table.show_stock").click(function(e) {
        $('#manageveriPopup').removeClass('show');
        $('.modal-backdrop').removeClass('show');

        $('#manageStockPopup').addClass('show');
    });

    $("button#ch_to_table.save_confirm").click(function(e) {
        $('#adjustStockPopup').removeClass('show');
        $('.modal-backdrop').removeClass('show');

        $('#confirmStockPopup').addClass('show');
    });


    // Full Screen Popup Open
    $("#opencibsp").click(function(e) {
        $('#createItem').addClass('active');
    });

    $("a.close_cibsp").click(function(e) {
        $('#createItem').removeClass('active');
    });

    // Full Screen Popup Open Create Item Group
    $("#opencibsp_group").click(function(e) {
        $('#createItemgroup').addClass('active');
    });

    $("a.close_cibsp").click(function(e) {
        $('#createItemgroup').removeClass('active');
    });


    // Add Item Group
    $("button#add_group_item").click(function(e) {
        $('tr.add_nre_group_column').addClass('show');
    });

    $("#createItemgroup tr.add_nre_group_column td.al_close a").click(function(e) {
        $('tr.add_nre_group_column').removeClass('show');
    });


    // Full Screen Popup Create Brand
  

    $("a#close_createbrand").click(function(e) {
        // $('#createbrand').removeClass('active');
    });

    // Full Screen Popup Create Category
    $("#opencreatecategory").click(function(e) {
        $('#createcategory').addClass('active');
    });

    $("a#close_createcategory").click(function(e) {
        $('#createcategory').removeClass('active');
    });

     // Item Multiple Images uploader
     jQuery(document).ready(function () {
        ImgSingleUpload();
    });

    function ImgSingleUpload() {
        $("#imag").change(function() {
            // add your logic to decide which image control you'll use
            var imgControlName = "#ImgPreview";
            readURL(this, imgControlName);
            $('.preview1').addClass('it');
            $('.btn-rmv1').addClass('rmv');
        });
        
        
        $("#removeImage1").click(function(e) {
            e.preventDefault();
            $("#imag").val("");
            $("#ImgPreview").attr("src", "");
            $('.preview1').removeClass('it');
            $('.btn-rmv1').removeClass('rmv');
        });
    }

    // Item Multiple Images uploader
    jQuery(document).ready(function () {
        ImgUpload();
    });
    
    function ImgUpload() {
        var imgWrap = "";
        var imgArray = [];
    
        $('.upload__inputfile').each(function () {
        $(this).on('change', function (e) {
            imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
            var maxLength = $(this).attr('data-max_length');
    
            var files = e.target.files;
            var filesArr = Array.prototype.slice.call(files);
            var iterator = 0;
            filesArr.forEach(function (f, index) {
    
            if (!f.type.match('image.*')) {
                return;
            }
    
            if (imgArray.length > maxLength) {
                return false
            } else {
                var len = 0;
                for (var i = 0; i < imgArray.length; i++) {
                if (imgArray[i] !== undefined) {
                    len++;
                }
                }
                if (len > maxLength) {
                return false;
                } else {
                imgArray.push(f);
    
                var reader = new FileReader();
                reader.onload = function (e) {
                    var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                    imgWrap.append(html);
                    iterator++;
                }
                reader.readAsDataURL(f);
                }
            }
            });
        });
        });
    
        $('body').on('click', ".upload__img-close", function (e) {
        var file = $(this).parent().data("file");
        for (var i = 0; i < imgArray.length; i++) {
            if (imgArray[i].name === file) {
            imgArray.splice(i, 1);
            break;
            }
        }
        $(this).parent().parent().remove();
        });
    }

});
