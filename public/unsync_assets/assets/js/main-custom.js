$(document).ready(function () {

    // Dashboard JS
    $(document).ready(function(){
        $('#ngst').click(function(){
            $('.hide_gstn').removeClass('active');
            // $('.hide_gstn').addClass('active1').siblings().removeClass('active');
        });
        $('#ygst').click(function(){
            $('.hide_gstn').addClass('active');       
            // $('.hide_gstn').addClass('active').siblings().removeClass('active1');       
        });
    });


    // User Setting
    $(document).ready(function() {
        const sections = [
          '.profile_section',
          '.account_section',
          '.password_section',
          '.notification_section',
          '.business_profile',
          '.business_account'
        ];
      
        $('li[class^="op_"]').click(function() {
          const targetSection = '.' + this.className.slice(3);
          const targetLi = 'li.' + this.className;
      
          sections.forEach(section => {
            $(section).toggleClass('show', section === targetSection);
          });
      
          $('li[class^="op_"]').removeClass('active');
          $(targetLi).addClass('active');
        });
      });      


    // GST script
    $(".setup_wrapper .comn_card input:radio").change(function () {
        if ($(this).is(":checked")) {
            $(".have_gst").toggleClass("show");
        } else {
            $(".have_gst").toggleClass("show");
        }
    });
    // GST script
    $(".custom-control-inline input:radio").change(function () {
        if ($(this).is(":checked")) {
            $(".have_gst").toggleClass("show");
        } else {
            $(".have_gst").toggleClass("show");
        }
    });
    // GST script
    $(".setup_wrapper .comn_card input:radio").change(function () {
        if ($(this).is(":checked")) {
            $(".have_gstsetup").toggleClass("show");
        } else {
            $(".have_gstsetup").toggleClass("show");
        }
    });
    // GST script
    $(".business_account .comn_card input:radio").change(function () {
        if ($(this).is(":checked")) {
            $(".have_gstsetup1").toggleClass("show");
        } else {
            $(".have_gstsetup1").toggleClass("show");
        }
    });


    // Show GST number Field
    $(".table_card table#user-list-table .sd_check input:checkbox").change(function () {
        if ($(this).is(":checked")) {
            $(".show_check").addClass("show_option");
            $(".table_card .thead form.mr-3.position-relative").addClass("hide_search");
        } else {
            $(".show_check").removeClass("show_option");
            $(".table_card .thead form.mr-3.position-relative").removeClass("hide_search");
        }
    });

    // Show Master Delete Brand
    $(".part_gray .sd_check input:checkbox").change(function () {
        if ($(this).is(":checked")) {
            $(".show_check.dbrands").addClass("show_option");
        } else {
            $(".show_check.dbrands").removeClass("show_option");
        }
    });

    // Second script
    $("#demo").FancyFileUpload({
        params: {
            action: "fileuploader",
        },
        maxfilesize: 10000000,
    });

    // Third script
    $("#ngst").click(function () {
        $(".hide_gstn").removeClass("active");
        // $('.hide_gstn').addClass('active1').siblings().removeClass('active');
    });

    $("#ygst").click(function () {
        $(".hide_gstn").addClass("active");
        // $('.hide_gstn').addClass('active').siblings().removeClass('active1');
    });

    // Custom Dropdown 3 dots
    $("a#customdropdown").click(function(event) {
        event.stopPropagation();
        $(".customdropdown").toggleClass("active");
    });
    
    $(document).click(function() {
        $(".customdropdown").removeClass("active");
    });
    


    /// GST & NON GST
    $(".gst_btns a.have_gst").click(function () {
        $(".gst_btns a.have_gst").addClass("active");
        $(".gst_btns a.no_gst").removeClass("active");

        $(".hide_gst").addClass("active");
    });

    $(".gst_btns a.no_gst").click(function () {
        $(".gst_btns a.no_gst").addClass("active");
        $(".gst_btns a.have_gst").removeClass("active");
        
        $(".hide_gst").removeClass("active");
    });

    /// Create Customer
    $(".text_center button.btn_comman").click(function () {
        $(".customer_created").removeClass("hide_default");
    });

    /// Add Custom Field
    $(".acfield button.normal_btn").click(function () {
        $("tr.add_nre_group_column").addClass("show");
    });

    /// Create Brand & Category
    $("button.create_brand_btn").click(function () {
        $(".customer_created").removeClass("hide_default");
    });
    
    // Fourth script
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#imagePreview").css("background-image", "url(" + e.target.result + ")");
                $("#imagePreview").hide();
                $("#imagePreview").fadeIn(650);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload").change(function () {
        readURL(this);
    });

    /***************************** Date Range Picker */
    $(function () {
        var DATAPICKERAPI = {
            activeMonthRange: function () {
                return {
                    begin: moment().set({ date: 1, hour: 0, minute: 0, second: 0 }).format("YYYY-MM-DD HH:mm:ss"),
                    end: moment().set({ hour: 23, minute: 59, second: 59 }).format("YYYY-MM-DD HH:mm:ss"),
                };
            },
            shortcutMonth: function () {
                var nowDay = moment().get("date");
                var prevMonthFirstDay = moment().subtract(1, "months").set({ date: 1 });
                var prevMonthDay = moment().diff(prevMonthFirstDay, "days");
                return {
                    now: "-" + nowDay + ",0",
                    prev: "-" + prevMonthDay + ",-" + nowDay,
                };
            },
            shortcutPrevHours: function (hour) {
                var nowDay = moment().get("date");
                var prevHours = moment().subtract(hour, "hours");
                var prevDate = prevHours.get("date") - nowDay;
                var nowTime = moment().format("HH:mm:ss");
                var prevTime = prevHours.format("HH:mm:ss");
                return {
                    day: prevDate + ",0",
                    time: prevTime + "," + nowTime,
                    name: "Nearly " + hour + " Hours",
                };
            },
            rangeMonthShortcutOption1: function () {
                var result = DATAPICKERAPI.shortcutMonth();
                var resultTime = DATAPICKERAPI.shortcutPrevHours(18);
                return [
                    {
                        name: "Yesterday",
                        day: "-1,-1",
                        time: "00:00:00,23:59:59",
                    },
                    {
                        name: "This Month",
                        day: result.now,
                        time: "00:00:00,",
                    },
                    {
                        name: "Lasy Month",
                        day: result.prev,
                        time: "00:00:00,23:59:59",
                    },
                    {
                        name: resultTime.name,
                        day: resultTime.day,
                        time: resultTime.time,
                    },
                ];
            },
            rangeShortcutOption1: [
                {
                    name: "Last week",
                    day: "-7,0",
                },
                {
                    name: "Last Month",
                    day: "-30,0",
                },
                {
                    name: "Last Year",
                    day: "-365, 0",
                },
            ],
            singleShortcutOptions1: [
                {
                    name: "Today",
                    day: "0",
                    time: "00:00:00",
                },
                {
                    name: "Yesterday",
                    day: "-1",
                    time: "00:00:00",
                },
                {
                    name: "One Week Ago",
                    day: "-7",
                },
            ],
        };

        $(".J-datepicker-range-day").datePicker({
            hasShortcut: true,
            language: "en",
            format: "YYYY-MM-DD",
            isRange: true,
            shortcutOptions: DATAPICKERAPI.rangeShortcutOption1,
        });
    });


    // for password hide and show option
    let allShowHidePassword = document.querySelectorAll('.password-showHide')

    allShowHidePassword.forEach(item => {
        item.addEventListener('click', ()=> {
            item.classList.toggle('hide')
            if(item.closest('.form-input').querySelector('input').type === 'password') {
                item.closest('.form-input').querySelector('input').type = 'text'
            }else {
                item.closest('.form-input').querySelector('input').type = 'password'
            }
        })
    })

    // Image upload
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload").change(function() {
        readURL(this);
    });



    $(document).ready(function () {
        $(".bxslider").bxSlider({
            slideWidth: 622,
            minSlides: 1,
            maxSlides: 1,
            slideMargin: 5,
            auto: true,
            autoControls: true,
            stopAutoOnClick: true,
        });
    });


    $(document).ready(function () {
        // Get references to both toggle switches
        var $toggle1 = $("#pr_mode");
        var $toggle2 = $("#pr_mode1");

        // Add a "change" event listener to both toggle switches
        $toggle1.add($toggle2).change(function () {
            // Get the state of the toggle that was changed
            var toggleState = $(this).prop("checked");

            // Set the state of both toggle switches to match
            $toggle1.prop("checked", toggleState);
            $toggle2.prop("checked", toggleState);

            // Update the UI based on the new state
            if (toggleState) {
                setTimeout(function () {
                    $(".border").show();
                    $(".top_notch").show();
                    $(".bottom_notch").show();
                }, 500); // delay in milliseconds
            } else {
                setTimeout(function () {
                    $(".border").hide();
                    $(".top_notch").hide();
                    $(".bottom_notch").hide();
                }, 500); // delay in milliseconds
            }
        });
    });


    // Five script
    document.addEventListener("DOMContentLoaded", main);

    function main() {
        document.addEventListener("click", handleBgClick);

        const menuContainer = document.querySelector("#menu-container");
        const isMenuClosedAttrName = "data-is-closed";

        const menuBtn = document.querySelector("#menu-btn");
        const menu = document.querySelector("#menu");

        menuBtn.addEventListener("click", toggleMenu);
        menuBtn.addEventListener("click", preventDefault);

        menu.addEventListener("click", preventDefault);

        function preventDefault(e) {
            e.preventDefault();
        }

        function toggleMenu(e) {
            const isMenuClosed = menuContainer.getAttribute(isMenuClosedAttrName);
            if (isMenuClosed === "true") {
                openMenu();
            } else {
                closeMenu();
            }
        }

        function openMenu() {
            menu.scrollTop = 0;
            menuContainer.setAttribute(isMenuClosedAttrName, "false");
        }

        function closeMenu() {
            menuContainer.setAttribute(isMenuClosedAttrName, "true");
        }

        //   Click on background closes menu.
        function handleBgClick(e) {
            const wentEventNotThroughMenu = !e.path.includes(menu);
            const wentEventNotThroughMenuBtn = !e.path.includes(menuBtn);
            if (wentEventNotThroughMenu && wentEventNotThroughMenuBtn) {
                closeMenu();
            }
        }
    }


    // Six script
    $(".navbar-expand-lg .navbar-nav .dropdown-menu").on("click", function (e) {
        e.stopPropagation();
    });

    $(".iq-sub-dropdown.dropdown-menu").on("click", function (e) {
        e.stopPropagation();
    });

    // Seven script
    $(document).ready(function () {
        $(".bxslider").bxSlider({
            slideWidth: 622,
            minSlides: 1,
            maxSlides: 1,
            slideMargin: 5,
            auto: true,
            autoControls: true,
            stopAutoOnClick: true,
        });
    });

    // Eight script
    /*************************** Toggle Practise Mode */
    $(document).ready(function () {
        // Get references to both toggle switches
        var $toggle1 = $("#pr_mode");
        var $toggle2 = $("#pr_mode1");

        // Add a "change" event listener to both toggle switches
        $toggle1.add($toggle2).change(function () {
            // Get the state of the toggle that was changed
            var toggleState = $(this).prop("checked");

            // Set the state of both toggle switches to match
            $toggle1.prop("checked", toggleState);
            $toggle2.prop("checked", toggleState);

            // Update the UI based on the new state
            if (toggleState) {
                setTimeout(function () {
                    $(".border").show();
                    $(".top_notch").show();
                    $(".bottom_notch").show();
                }, 500); // delay in milliseconds
            } else {
                setTimeout(function () {
                    $(".border").hide();
                    $(".top_notch").hide();
                    $(".bottom_notch").hide();
                }, 500); // delay in milliseconds
            }
        });
    });


    // Nine script
    // $(function () {
    //     $(".ddl-select").each(function () {
    //         $(this).hide();
    //         var $select = $(this);
    //         var _id = $(this).attr("id");
    //         var wrapper = document.createElement("div");
    //         wrapper.setAttribute("class", "ddl ddl_" + _id);

    //         var input = document.createElement("input");
    //         input.setAttribute("type", "text");
    //         input.setAttribute("class", "ddl-input");
    //         input.setAttribute("id", "ddl_" + _id);
    //         input.setAttribute("readonly", "readonly");
    //         input.setAttribute("placeholder", $(this)[0].options[$(this)[0].selectedIndex].innerText);

    //         $(this).before(wrapper);
    //         var $ddl = $(".ddl_" + _id);
    //         $ddl.append(input);
    //         $ddl.append("<div class='ddl-options ddl-options-" + _id + "'></div>");
    //         var $ddl_input = $("#ddl_" + _id);
    //         var $ops_list = $(".ddl-options-" + _id);
    //         var $ops = $(this)[0].options;
    //         for (var i = 0; i < $ops.length; i++) {
    //             $ops_list.append("<div data-value='" + $ops[i].value + "'>" + $ops[i].innerText + "</div>");
    //         }

    //         $ddl_input.click(function () {
    //             $ddl.toggleClass("active");
    //         });
    //         $ddl_input.blur(function () {
    //             $ddl.removeClass("active");
    //         });
    //         $ops_list.find("div").click(function () {
    //             $select.val($(this).data("value")).trigger("change");
    //             $ddl_input.val($(this).text());
    //             $ddl.removeClass("active");
    //         });
    //     });
    // });


    // Ten script
    var langArray = [];
    $(".vodiapicker option").each(function () {
        var img = $(this).attr("data-thumbnail");
        var text = this.innerText;
        var value = $(this).val();
        var item = '<li><div><img src="' + img + '" alt="" value="' + value + '"/></div><span>' + text + "</span></li>";
        langArray.push(item);
    });

    $("#a").html(langArray);

    //Set the button value to the first el of the array
    $(".btn-select").html(langArray[0]);
    $(".btn-select").attr("value", "en");

    //change button stuff on click
    $("#a li").click(function () {
        var img = $(this).find("img").attr("src");
        var value = $(this).find("img").attr("value");
        var text = this.innerText;
        var item = '<li><div><img src="' + img + '" alt="" /></div><span>' + text + "</span></li>";
        $(".btn-select").html(item);
        $(".btn-select").attr("value", value);
        $(".b").toggle();
        $(".lang-select").toggleClass("arrow");
        //console.log(value);
    });

    $(".btn-select").click(function () {
        $(".b").toggle();
        $(".lang-select").toggleClass("arrow");
    });

    //check local storage for the lang
    var sessionLang = localStorage.getItem("lang");
    if (sessionLang) {
        //find an item with value of sessionLang
        var langIndex = langArray.indexOf(sessionLang);
        $(".btn-select").html(langArray[langIndex]);
        $(".btn-select").attr("value", sessionLang);
    } else {
        var langIndex = langArray.indexOf("ch");
        console.log(langIndex);
        $(".btn-select").html(langArray[langIndex]);
        //$('.btn-select').attr('value', 'en');
    }

    // Eleven script
    // Start upload preview image
    $(".gambar").attr("src", "assets/images/image_place.png");
    var $uploadCrop, tempFilename, rawImg, imageId;
    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(".upload-demo").addClass("ready");
                $("#cropImagePop").modal("show");
                rawImg = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            swal("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    $uploadCrop = $("#upload-demo").croppie({
        viewport: {
            width: 275,
            height: 100,
        },
        enforceBoundary: false,
        enableExif: true,
    });
    $("#cropImagePop").on("shown.bs.modal", function () {
        // alert('Shown pop');
        $uploadCrop
            .croppie("bind", {
                url: rawImg,
            })
            .then(function () {
                console.log("jQuery bind complete");
            });
    });

    $(".item-img").on("change", function () {
        imageId = $(this).data("id");
        tempFilename = $(this).val();
        $("#cancelCropBtn").data("id", imageId);
        readFile(this);
    });
    $("#cropImageBtn").on("click", function (ev) {
        $uploadCrop
            .croppie("result", {
                type: "base64",
                format: "jpeg",
                size: { width: 275, height: 100 },
            })
            .then(function (resp) {
                $("#item-img-output").attr("src", resp);
                $("#cropImagePop").modal("hide");
            });
    });
    // End upload preview image


    // Inner Table Hide/Show
    $("button.innerTable").click(function () {
        $(".inner_item").toggleClass("active");
    });

    $("button.innerTable").click(function () {
        $("button.innerTable").toggleClass("active");
    });


    // Item Single Image Upload
    function readURL(input, imgControlName) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
            $(imgControlName).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
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

    
    // WelcomeGST >> All Apps
    $("#opencreatecategory").click(function(e) {
        $('#createcategory').addClass('active');
        $('body').toggleClass('ov_hidden');
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


    // Create Team Link
    $("span.al_center a.ct_btn").click(function(e) {
        $('.invite_link').addClass('show');
    });

    // Full Screen Popup Open
    $("button#opencibsp, a#opencibsp").click(function(e) {
        $('#createItem').addClass('active');
        $('body').toggleClass('ov_hidden');
    });

    $("a.close_cibsp").click(function(e) {
        $('#createItem').removeClass('active');
    });

    // Full Screen Popup Open Edit Team member
    $("a#openeditcanvas").click(function(e) {
        $('#editcanvas').addClass('active');
        $('body').toggleClass('ov_hidden');
    });

    $("a.close_cibsp").click(function(e) {
        $('#editcanvas').removeClass('active');
    });

    // Full Screen Popup Open Create Item Group
    $("#opencibsp_group").click(function(e) {
        $('#createItemgroup').addClass('active');
        $('body').toggleClass('ov_hidden');
    });

    $("a.close_cibsp").click(function(e) {
        $('#createItemgroup').removeClass('active');
    });

    // Add Item Group
    $("button#add_group_item").click(function(e) {
        $('tr.add_nre_group_column').addClass('show');
        $('body').toggleClass('ov_hidden');
    });

    $("#createItemgroup tr.add_nre_group_column td.al_close a").click(function(e) {
        $('tr.add_nre_group_column').removeClass('show');
    });


    // Full Screen Popup Create Brand
    $("#opencreatebrand").click(function(e) {
        $('#createbrand').addClass('active');
        $('body').toggleClass('ov_hidden');
    });

    $("a#close_createbrand").click(function(e) {
        $('#createbrand').removeClass('active');
    });

    // Full Screen Popup Create Category
    $("#opencreatecategory").click(function(e) {
        $('#createcategory').addClass('active');
        $('body').toggleClass('ov_hidden');
    });

    $("a#close_createcategory").click(function(e) {
        $('#createcategory').removeClass('active');
    });

    // Full Screen Popup Create Brand
    $("#opencreatecustomer").click(function(e) {
        $('#createcustomer').addClass('active');
        $('body').toggleClass('ov_hidden');
    });

    $("a#close_cibsp").click(function(e) {
        $('#createcustomer').removeClass('active');
    });


    

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
