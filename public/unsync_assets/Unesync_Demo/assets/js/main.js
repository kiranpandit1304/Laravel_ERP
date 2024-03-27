(function(jQuery) {

    "use strict";

    jQuery(document).ready(function() {

        $("input#showshipping:checkbox").change(function () {
            if ($(this).is(":checked")) {
                $(".shipping_details").toggleClass("show");
            } else {
                $(".shipping_details").toggleClass("show");
            }
        });

        /**************************************** */

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

        /**************************************** */

        $( function() {
            $( "#datepicker" ).datepicker({
                dateFormat: "dd-mm-yy"
                ,	duration: "fast"
            });
        } );

        /**************************************** */

        $(".navbar-expand-lg .navbar-nav .dropdown-menu").on("click", function (e) {
            e.stopPropagation();
        });

        /**************************************** */

        $(document).ready(function () {
            $("#pr_mode").change(function () {
                $(".border").toggle();
                $(".top_notch").toggle();
                $(".bottom_notch").toggle();
            });
        });

        $(document).ready(function () {
            $("#pr_mode_top").change(function () {
                $(".border").toggle();
                $(".top_notch").toggle();
                $(".bottom_notch").toggle();
            });
        });

        $("button.subTitle").click(function () {
            $("input.hide_box").toggle();
            $("button.subTitle").toggle();
        });

        $("button.add_line").click(function () {
            $("li.hide_line").toggleClass("show");
        });
        $("a.close").click(function () {
            $("li.hide_line").toggleClass("show");
        });

        $(".biling_detail .miniCard button.add_line").click(function () {
            $(".biling_detail .miniCard li.hide_line").addClass("show");
        });
        $(".biling_detail .miniCard a.close").click(function () {
            $(".biling_detail .miniCard li.hide_line").removeClass("show");
        });

        $("button.addnewcolumn").click(function () {
            $(".tbody_column.inv").addClass("visible");
        });

        $("button.close_column").click(function () {
            $(".tbody_column.inv").removeClass("visible");
        });

        $("button.addnewgroup").click(function () {
            $(".tbody_column.group").addClass("visible");
        });

        $("button.close_group").click(function () {
            $(".tbody_column.group").removeClass("visible");
        });

        $("button.addnewline").click(function () {
            $(".item").removeClass("hide_i");
        });

        /**************************************** */

        $("button.showtcond").click(function () {
            $(".tcondition").toggleClass("hide");
        });
        $("button.showNote").click(function () {
            $(".addition_note").toggleClass("hide");
        });
        $("button.showAttch").click(function () {
            $(".attech").toggleClass("hide");
        });

        $("button.close_b").click(function () {
            $(".tcondition").toggleClass("hide");
        });
        $("button.close_c").click(function () {
            $(".addition_note").toggleClass("hide");
        });
        $("button.close_d").click(function () {
            $(".attech").toggleClass("hide");
        });


        $("button.signBtn").click(function () {
            $(".sign_box").toggleClass("show");
        });
        $(".sb_head button.close").click(function () {
            $(".sign_box").toggleClass("show");
        });

        $("button.add_line.add_more").click(function () {
            $(".item_info.hide").toggleClass("show");
        });
        $(".item_info.hide button.close").click(function () {
            $(".item_info.hide").toggleClass("show");
        });

        $("button.showadinfo").click(function () {
            $(".add_additional_info").toggleClass("show");
        });
        $(".item_info.all button.close").click(function () {
            $(".add_additional_info").toggleClass("show");
        });

        /**************************************** */

        // $("a.edit").click(function () {
        //     $(".page_minidetail .inner_left ul li.first").toggleClass("onSpot");
        //     $(".wrapper").toggleClass("blackOverlay");
        // });

        // $(".page_minidetail .inner_left ul li").click(function () {
        //     $(".page_minidetail .inner_left ul li.first").toggleClass("onSpot");
        //     $(".wrapper").toggleClass("blackOverlay");
        // });

        // $("button.cancel").click(function () {
        //     $(".page_minidetail .inner_left ul li.first").removeClass("onSpot");
        //     $(".wrapper").removeClass("blackOverlay");
        // });

        // $("button.save").click(function () {
        //     $(".page_minidetail .inner_left ul li.first").removeClass("onSpot");
        //     $(".wrapper").removeClass("blackOverlay");
        // });

        /**************************************** */

        // var ul = document.getElementById("sortable-list");

        // ul.addEventListener(
        //     "slip:beforereorder",
        //     function (e) {
        //         if (/demo-no-reorder/.test(e.target.className)) {
        //             e.preventDefault();
        //         }
        //     },
        //     false
        // );

        // ul.addEventListener(
        //     "slip:beforeswipe",
        //     function (e) {
        //         if (e.target.nodeName == "INPUT" || /no-swipe/.test(e.target.className)) {
        //             e.preventDefault();
        //         }
        //     },
        //     false
        // );

        // ul.addEventListener(
        //     "slip:beforewait",
        //     function (e) {
        //         if (e.target.className.indexOf("instant") > -1) e.preventDefault();
        //     },
        //     false
        // );

        /*ul.addEventListener('slip:afterswipe', function(e){
        e.target.parentNode.appendChild(e.target);
        }, false);*/

        // ul.addEventListener(
        //     "slip:reorder",
        //     function (e) {
        //         e.target.parentNode.insertBefore(e.target, e.detail.insertBefore);
        //         return false;
        //     },
        //     false
        // );

        // new Slip(ul);

        /**************************************** */

        $( function() {
            $( "#sortable" ).sortable();
        } );

        $( function() {
            $( "#sortable-list" ).sortable();
        } );

        /**************************************** */

        $(function () {
            $(".ddl-select").each(function () {
                $(this).hide();
                var $select = $(this);
                var _id = $(this).attr("id");
                var wrapper = document.createElement("div");
                wrapper.setAttribute("class", "ddl ddl_" + _id);

                var input = document.createElement("input");
                input.setAttribute("type", "text");
                input.setAttribute("class", "ddl-input");
                input.setAttribute("id", "ddl_" + _id);
                input.setAttribute("readonly", "readonly");
                input.setAttribute("placeholder", $(this)[0].options[$(this)[0].selectedIndex].innerText);

                $(this).before(wrapper);
                var $ddl = $(".ddl_" + _id);
                $ddl.append(input);
                $ddl.append("<div class='ddl-options ddl-options-" + _id + "'></div>");
                var $ddl_input = $("#ddl_" + _id);
                var $ops_list = $(".ddl-options-" + _id);
                var $ops = $(this)[0].options;
                for (var i = 0; i < $ops.length; i++) {
                    $ops_list.append("<div data-value='" + $ops[i].value + "'>" + $ops[i].innerText + "</div>");
                }

                $ddl_input.click(function () {
                    $ddl.toggleClass("active");
                });
                $ddl_input.blur(function () {
                    $ddl.removeClass("active");
                });
                $ops_list.find("div").click(function () {
                    $select.val($(this).data("value")).trigger("change");
                    $ddl_input.val($(this).text());
                    $ddl.removeClass("active");
                });
            });
        });

        /**************************************** */

        /**************************************** */

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


        /**************************************** */

        var langArray = [];
        $(".vodiapicker option").each(function () {
            var img = $(this).attr("data-thumbnail");
            var text = this.innerText;
            var value = $(this).val();
            var item = '<li><div><img src="' + img + '" alt="" value="' + value + '"/></div><span>' + text + "</span></li>";
            langArray.push(item);
        });
        $(".vodiapicker1 option.test1").each(function () {
            var img = $(this).attr("data-thumbnail");
            var text = this.innerText;
            var value = $(this).val();
            var item = '<li><div><img src="' + img + '" alt="" value="' + value + '"/></div><span>' + text + "</span></li>";
            langArray.push(item);
        });

        $("#a").html(langArray);
        $("#a1").html(langArray);

        //Set the button value to the first el of the array
        $(".btn-select").html(langArray[0]);
        $(".btn-select").attr("value", "en");

        $(".btn-select1").html(langArray[0]);
        $(".btn-select1").attr("value1", "en");

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

        $("#a1 li").click(function () {
            var img = $(this).find("img").attr("src");
            var value = $(this).find("img").attr("value");
            var text = this.innerText;
            var item = '<li><div><img src="' + img + '" alt="" /></div><span>' + text + "</span></li>";
            $(".btn-select1").html(item);
            $(".btn-select1").attr("value1", value);
            $(".b1").toggle();
            $(".lang-select1").toggleClass("arrow");
            //console.log(value);
        });

        $(".btn-select").click(function () {
            $(".b").toggle();
            $(".lang-select").toggleClass("arrow");
        });

        $(".btn-select1").click(function () {
            $(".b1").toggle();
            $(".lang-select1").toggleClass("arrow");
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

        var sessionLang = localStorage.getItem("lang1");
        if (sessionLang) {
            //find an item with value of sessionLang
            var langIndex = langArray.indexOf(sessionLang);
            $(".btn-select1").html(langArray[langIndex]);
            $(".btn-select1").attr("value", sessionLang);
        } else {
            var langIndex = langArray.indexOf("ch1");
            console.log(langIndex);
            $(".btn-select1").html(langArray[langIndex]);
            //$('.btn-select').attr('value', 'en');
        }


        /**************************************** */


        var birds = [
            { title: "Southern Screamer", id: 1 },
            { title: "Horned Screamer", id: 2 },
            { title: "Magpie-goose", id: 3 },
            { title: "Swan Goose", id: 4 },
            { title: "White-faced Whistling Duck", id: 5 },
            { title: "Greater White-fronted Goose", id: 6 },
            { title: "Greylag Goose", id: 7 },
            { title: "Bar-headed Goose", id: 8 },
            { title: "Snow Goose", id: 9 },
            { title: "Nene", id: 10 },
            { title: "Canada Goose", id: 11 },
            { title: "Brent Goose (Brant)", id: 12 },
        ];

        $("#autocomplete-0").tinyAutocomplete({
            data: birds,
            showNoResults: true,
            lastItemTemplate: '<li class="autocomplete-item autocomplete-item-last"><a href="#">Add new shipping details</a></li>',
            onSelect: function (el, val) {
                if (val == null) {
                    // $('.results').html('All results for "' + $(this).val() + '" would go here');
                } else {
                    $(this).val(val.title);
                    // $('.results').html('<h1>' + val.title + '</h1>');
                }
                return false;
            },
        });

        /**************************************** */


        // $("#summernote").summernote({
        //     placeholder: "Hello stand alone ui",
        //     tabsize: 2,
        //     height: 100,
        //     toolbar: [
        //         ["style", ["style"]],
        //         ["font", ["bold", "underline", "clear"]],
        //         ["color", ["color"]],
        //         ["para", ["ul", "ol", "paragraph"]],
        //         ["table", ["table"]],
        //         ["insert", ["link", "picture", "video"]],
        //         ["view", ["fullscreen", "codeview", "help"]],
        //     ],
        // });



        /**************************************** */


        const fileTempl = document.getElementById("file-template"),
            imageTempl = document.getElementById("image-template"),
            empty = document.getElementById("empty");

        // use to store pre selected files
        let FILES = {};

        // check if file is of type image and prepend the initialied
        // template to the target element
        function addFile(target, file) {
            const isImage = file.type.match("image.*"),
                objectURL = URL.createObjectURL(file);

            const clone = isImage ? imageTempl.content.cloneNode(true) : fileTempl.content.cloneNode(true);

            clone.querySelector("h1").textContent = file.name;
            clone.querySelector("li").id = objectURL;
            clone.querySelector(".delete").dataset.target = objectURL;
            clone.querySelector(".size").textContent = file.size > 1024 ? (file.size > 1048576 ? Math.round(file.size / 1048576) + "mb" : Math.round(file.size / 1024) + "kb") : file.size + "b";

            isImage &&
                Object.assign(clone.querySelector("img"), {
                    src: objectURL,
                    alt: file.name,
                });

            empty.classList.add("hidden");
            target.prepend(clone);
            console.log(objectURL);
            FILES[objectURL] = file;
        }

        const gallery = document.getElementById("gallery"),
            overlay = document.getElementById("overlay");

        // click the hidden input of type file if the visible button is clicked
        // and capture the selected files
        const hidden = document.getElementById("hidden-input");
        document.getElementById("button").onclick = () => hidden.click();
        hidden.onchange = (e) => {
            for (const file of e.target.files) {
                addFile(gallery, file);
            }
        };

        // use to check if a file is being dragged
        const hasFiles = ({ dataTransfer: { types = [] } }) => types.indexOf("Files") > -1;

        // use to track dragenter and dragleave events.
        // this is to know if the outermost parent is dragged over
        // without issues due to drag events on its children
        let counter = 0;

        // reset counter and append file to gallery when file is dropped
        function dropHandler(ev) {
            ev.preventDefault();
            for (const file of ev.dataTransfer.files) {
                addFile(gallery, file);
                overlay.classList.remove("draggedover");
                counter = 0;
            }
        }

        // only react to actual files being dragged
        function dragEnterHandler(e) {
            e.preventDefault();
            if (!hasFiles(e)) {
                return;
            }
            ++counter && overlay.classList.add("draggedover");
        }

        function dragLeaveHandler(e) {
            1 > --counter && overlay.classList.remove("draggedover");
        }

        function dragOverHandler(e) {
            if (hasFiles(e)) {
                e.preventDefault();
            }
        }

        // event delegation to caputre delete events
        // from the waste buckets in the file preview cards
        gallery.onclick = ({ target }) => {
            if (target.classList.contains("delete")) {
                const ou = target.dataset.target;
                document.getElementById(ou).remove(ou);
                gallery.children.length === 1 && empty.classList.remove("hidden");
                delete FILES[ou];
            }
        };

        // print all selected files
        document.getElementById("submit").onclick = () => {
            alert(`Submitted Files:\n${JSON.stringify(FILES)}`);
            console.log(FILES);
        };

        // clear entire selection
        document.getElementById("cancel").onclick = () => {
            while (gallery.children.length > 0) {
                gallery.lastChild.remove();
            }
            FILES = {};
            empty.classList.remove("hidden");
            gallery.append(empty);
        };


        /**************************************** */
        

        // Start upload preview image
        $(".gambar").attr("src", "assets/images/image_place.png");
        var $uploadCrop,
        tempFilename,
        rawImg,
        imageId;
        function readFile(input) {
            if (input.files && input.files[0]) {
            var reader = new FileReader();
                reader.onload = function (e) {
                    $('.upload-demo').addClass('ready');
                    $('#cropImagePop').modal('show');
                    rawImg = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
            else {
                swal("Sorry - you're browser doesn't support the FileReader API");
            }
        }

        $uploadCrop = $('#upload-demo').croppie({
            viewport: {
                width: 150,
                height: 200,
            },
            enforceBoundary: false,
            enableExif: true
        });
        $('#cropImagePop').on('shown.bs.modal', function(){
            // alert('Shown pop');
            $uploadCrop.croppie('bind', {
                url: rawImg
            }).then(function(){
                console.log('jQuery bind complete');
            });
        });

        $('.item-img').on('change', function () { imageId = $(this).data('id'); tempFilename = $(this).val();
        $('#cancelCropBtn').data('id', imageId); readFile(this); });
        $('#cropImageBtn').on('click', function (ev) {
            $uploadCrop.croppie('result', {
                type: 'base64',
                format: 'jpeg',
                size: {width: 150, height: 200}
            }).then(function (resp) {
                $('#item-img-output').attr('src', resp);
                $('#cropImagePop').modal('hide');
            });
        });
        // End upload preview image

        /***************************************** */

        /*!
        * Modified
        * Signature Pad v1.5.3
        * https://github.com/szimek/signature_pad
        *
        * Copyright 2016 Szymon Nowak
        * Released under the MIT license
        */
        var SignaturePad = (function(document) {
            "use strict";

            var log = console.log.bind(console);

            var SignaturePad = function(canvas, options) {
                var self = this,
                    opts = options || {};

                this.velocityFilterWeight = opts.velocityFilterWeight || 0.7;
                this.minWidth = opts.minWidth || 0.5;
                this.maxWidth = opts.maxWidth || 2.5;
                this.dotSize = opts.dotSize || function() {
                        return (self.minWidth + self.maxWidth) / 2;
                    };
                this.penColor = opts.penColor || "black";
                this.backgroundColor = opts.backgroundColor || "rgba(0,0,0,0)";
                this.throttle = opts.throttle || 0;
                this.throttleOptions = {
                    leading: true,
                    trailing: true
                };
                this.minPointDistance = opts.minPointDistance || 0;
                this.onEnd = opts.onEnd;
                this.onBegin = opts.onBegin;

                this._canvas = canvas;
                this._ctx = canvas.getContext("2d");
                this._ctx.lineCap = 'round';
                this.clear();

                // we need add these inline so they are available to unbind while still having
                //  access to 'self' we could use _.bind but it's not worth adding a dependency
                this._handleMouseDown = function(event) {
                    if (event.which === 1) {
                        self._mouseButtonDown = true;
                        self._strokeBegin(event);
                    }
                };

                var _handleMouseMove = function(event) {
                event.preventDefault();
                    if (self._mouseButtonDown) {
                        self._strokeUpdate(event);
                        if (self.arePointsDisplayed) {
                            var point = self._createPoint(event);
                            self._drawMark(point.x, point.y, 5);
                        }
                    }
                };

                this._handleMouseMove = _.throttle(_handleMouseMove, self.throttle, self.throttleOptions);
                //this._handleMouseMove = _handleMouseMove;

                this._handleMouseUp = function(event) {
                    if (event.which === 1 && self._mouseButtonDown) {
                        self._mouseButtonDown = false;
                        self._strokeEnd(event);
                    }
                };

                this._handleTouchStart = function(event) {
                    if (event.targetTouches.length == 1) {
                        var touch = event.changedTouches[0];
                        self._strokeBegin(touch);
                    }
                };

                var _handleTouchMove = function(event) {
                    // Prevent scrolling.
                    event.preventDefault();

                    var touch = event.targetTouches[0];
                    self._strokeUpdate(touch);
                    if (self.arePointsDisplayed) {
                        var point = self._createPoint(touch);
                        self._drawMark(point.x, point.y, 5);
                    }
                };
                this._handleTouchMove = _.throttle(_handleTouchMove, self.throttle, self.throttleOptions);
                //this._handleTouchMove = _handleTouchMove;

                this._handleTouchEnd = function(event) {
                    var wasCanvasTouched = event.target === self._canvas;
                    if (wasCanvasTouched) {
                        event.preventDefault();
                        self._strokeEnd(event);
                    }
                };

                this._handleMouseEvents();
                this._handleTouchEvents();
            };

            SignaturePad.prototype.clear = function() {
                var ctx = this._ctx,
                    canvas = this._canvas;

                ctx.fillStyle = this.backgroundColor;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                this._reset();
            };

            SignaturePad.prototype.showPointsToggle = function() {
                this.arePointsDisplayed = !this.arePointsDisplayed;
            };

            SignaturePad.prototype.toDataURL = function(imageType, quality) {
                var canvas = this._canvas;
                return canvas.toDataURL.apply(canvas, arguments);
            };

            SignaturePad.prototype.fromDataURL = function(dataUrl) {
                var self = this,
                    image = new Image(),
                    ratio = window.devicePixelRatio || 1,
                    width = this._canvas.width / ratio,
                    height = this._canvas.height / ratio;

                this._reset();
                image.src = dataUrl;
                image.onload = function() {
                    self._ctx.drawImage(image, 0, 0, width, height);
                };
                this._isEmpty = false;
            };

            SignaturePad.prototype._strokeUpdate = function(event) {
                var point = this._createPoint(event);
                if(this._isPointToBeUsed(point)){
                    this._addPoint(point);
                }
            };

            var pointsSkippedFromBeingAdded = 0;
            SignaturePad.prototype._isPointToBeUsed = function(point) {
                // Simplifying, De-noise
                if(!this.minPointDistance)
                    return true;

                var points = this.points;
                if(points && points.length){
                    var lastPoint = points[points.length-1];
                    if(point.distanceTo(lastPoint) < this.minPointDistance){
                        // log(++pointsSkippedFromBeingAdded);
                        return false;
                    }
                }
                return true;
            };

            SignaturePad.prototype._strokeBegin = function(event) {
                this._reset();
                this._strokeUpdate(event);
                if (typeof this.onBegin === 'function') {
                    this.onBegin(event);
                }
            };

            SignaturePad.prototype._strokeDraw = function(point) {
                var ctx = this._ctx,
                    dotSize = typeof(this.dotSize) === 'function' ? this.dotSize() : this.dotSize;

                ctx.beginPath();
                this._drawPoint(point.x, point.y, dotSize);
                ctx.closePath();
                ctx.fill();
            };

            SignaturePad.prototype._strokeEnd = function(event) {
                var canDrawCurve = this.points.length > 2,
                    point = this.points[0];

                if (!canDrawCurve && point) {
                    this._strokeDraw(point);
                }
                if (typeof this.onEnd === 'function') {
                    this.onEnd(event);
                }
            };

            SignaturePad.prototype._handleMouseEvents = function() {
                this._mouseButtonDown = false;

                this._canvas.addEventListener("mousedown", this._handleMouseDown);
                this._canvas.addEventListener("mousemove", this._handleMouseMove);
                document.addEventListener("mouseup", this._handleMouseUp);
            };

            SignaturePad.prototype._handleTouchEvents = function() {
                // Pass touch events to canvas element on mobile IE11 and Edge.
                this._canvas.style.msTouchAction = 'none';
                this._canvas.style.touchAction = 'none';

                this._canvas.addEventListener("touchstart", this._handleTouchStart);
                this._canvas.addEventListener("touchmove", this._handleTouchMove);
                this._canvas.addEventListener("touchend", this._handleTouchEnd);
            };

            SignaturePad.prototype.on = function() {
                this._handleMouseEvents();
                this._handleTouchEvents();
            };

            SignaturePad.prototype.off = function() {
                this._canvas.removeEventListener("mousedown", this._handleMouseDown);
                this._canvas.removeEventListener("mousemove", this._handleMouseMove);
                document.removeEventListener("mouseup", this._handleMouseUp);

                this._canvas.removeEventListener("touchstart", this._handleTouchStart);
                this._canvas.removeEventListener("touchmove", this._handleTouchMove);
                this._canvas.removeEventListener("touchend", this._handleTouchEnd);
            };

            SignaturePad.prototype.isEmpty = function() {
                return this._isEmpty;
            };

            SignaturePad.prototype._reset = function() {
                this.points = [];
                this._lastVelocity = 0;
                this._lastWidth = (this.minWidth + this.maxWidth) / 2;
                this._isEmpty = true;
                this._ctx.fillStyle = this.penColor;
            };

            SignaturePad.prototype._createPoint = function(event) {
                var rect = this._canvas.getBoundingClientRect();
                return new Point(
                    event.clientX - rect.left,
                    event.clientY - rect.top
                );
            };

            SignaturePad.prototype._addPoint = function(point) {
                var points = this.points,
                    c2, c3,
                    curve, tmp;

                points.push(point);

                if (points.length > 2) {
                    // To reduce the initial lag make it work with 3 points
                    // by copying the first point to the beginning.
                    if (points.length === 3) points.unshift(points[0]);

                    tmp = this._calculateCurveControlPoints(points[0], points[1], points[2]);
                    c2 = tmp.c2;
                    tmp = this._calculateCurveControlPoints(points[1], points[2], points[3]);
                    c3 = tmp.c1;
                    curve = new Bezier(points[1], c2, c3, points[2]);
                    this._addCurve(curve);

                    // Remove the first element from the list,
                    // so that we always have no more than 4 points in points array.
                    points.shift();
                }
            };

            SignaturePad.prototype._calculateCurveControlPoints = function(s1, s2, s3) {
                var dx1 = s1.x - s2.x,
                    dy1 = s1.y - s2.y,
                    dx2 = s2.x - s3.x,
                    dy2 = s2.y - s3.y,

                    m1 = {
                        x: (s1.x + s2.x) / 2.0,
                        y: (s1.y + s2.y) / 2.0
                    },
                    m2 = {
                        x: (s2.x + s3.x) / 2.0,
                        y: (s2.y + s3.y) / 2.0
                    },

                    l1 = Math.sqrt(1.0 * dx1 * dx1 + dy1 * dy1),
                    l2 = Math.sqrt(1.0 * dx2 * dx2 + dy2 * dy2),

                    dxm = (m1.x - m2.x),
                    dym = (m1.y - m2.y),

                    k = l2 / (l1 + l2),
                    cm = {
                        x: m2.x + dxm * k,
                        y: m2.y + dym * k
                    },

                    tx = s2.x - cm.x,
                    ty = s2.y - cm.y;

                return {
                    c1: new Point(m1.x + tx, m1.y + ty),
                    c2: new Point(m2.x + tx, m2.y + ty)
                };
            };

            SignaturePad.prototype._addCurve = function(curve) {
                var startPoint = curve.startPoint,
                    endPoint = curve.endPoint,
                    velocity, newWidth;

                velocity = endPoint.velocityFrom(startPoint);
                velocity = this.velocityFilterWeight * velocity +
                    (1 - this.velocityFilterWeight) * this._lastVelocity;

                newWidth = this._strokeWidth(velocity);
                this._drawCurve(curve, this._lastWidth, newWidth);

                this._lastVelocity = velocity;
                this._lastWidth = newWidth;
            };

            SignaturePad.prototype._drawPoint = function(x, y, size) {
                var ctx = this._ctx;

                ctx.moveTo(x, y);
                ctx.arc(x, y, size, 0, 2 * Math.PI, false);
                this._isEmpty = false;
            };

            SignaturePad.prototype._drawMark = function(x, y, size) {
                var ctx = this._ctx;

                ctx.save();
                ctx.moveTo(x, y);
                ctx.arc(x, y, size, 0, 2 * Math.PI, false);
                ctx.fillStyle = 'rgba(255, 0, 0, 0.2)';
                ctx.fill();
                ctx.restore();
            };

            SignaturePad.prototype._drawCurve = function(curve, startWidth, endWidth) {
                var ctx = this._ctx,
                    widthDelta = endWidth - startWidth,
                    drawSteps, width, i, t, tt, ttt, u, uu, uuu, x, y;

                drawSteps = Math.floor(curve.length());
                ctx.beginPath();
                for (i = 0; i < drawSteps; i++) {
                    // Calculate the Bezier (x, y) coordinate for this step.
                    t = i / drawSteps;
                    tt = t * t;
                    ttt = tt * t;
                    u = 1 - t;
                    uu = u * u;
                    uuu = uu * u;

                    x = uuu * curve.startPoint.x;
                    x += 3 * uu * t * curve.control1.x;
                    x += 3 * u * tt * curve.control2.x;
                    x += ttt * curve.endPoint.x;

                    y = uuu * curve.startPoint.y;
                    y += 3 * uu * t * curve.control1.y;
                    y += 3 * u * tt * curve.control2.y;
                    y += ttt * curve.endPoint.y;

                    width = startWidth + ttt * widthDelta;
                    this._drawPoint(x, y, width);
                }
                ctx.closePath();
                ctx.fill();
            };

            SignaturePad.prototype._strokeWidth = function(velocity) {
                return Math.max(this.maxWidth / (velocity + 1), this.minWidth);
            };

            var Point = function(x, y, time) {
                this.x = x;
                this.y = y;
                this.time = time || new Date().getTime();
            };

            Point.prototype.velocityFrom = function(start) {
                return (this.time !== start.time) ? this.distanceTo(start) / (this.time - start.time) : 1;
            };

            Point.prototype.distanceTo = function(start) {
                return Math.sqrt(Math.pow(this.x - start.x, 2) + Math.pow(this.y - start.y, 2));
            };

            var Bezier = function(startPoint, control1, control2, endPoint) {
                this.startPoint = startPoint;
                this.control1 = control1;
                this.control2 = control2;
                this.endPoint = endPoint;
            };

            // Returns approximated length.
            Bezier.prototype.length = function() {
                var steps = 10,
                    length = 0,
                    i, t, cx, cy, px, py, xdiff, ydiff;

                for (i = 0; i <= steps; i++) {
                    t = i / steps;
                    cx = this._point(t, this.startPoint.x, this.control1.x, this.control2.x, this.endPoint.x);
                    cy = this._point(t, this.startPoint.y, this.control1.y, this.control2.y, this.endPoint.y);
                    if (i > 0) {
                        xdiff = cx - px;
                        ydiff = cy - py;
                        length += Math.sqrt(xdiff * xdiff + ydiff * ydiff);
                    }
                    px = cx;
                    py = cy;
                }
                return length;
            };

            Bezier.prototype._point = function(t, start, c1, c2, end) {
                return start * (1.0 - t) * (1.0 - t) * (1.0 - t) +
                    3.0 * c1 * (1.0 - t) * (1.0 - t) * t +
                    3.0 * c2 * (1.0 - t) * t * t +
                    end * t * t * t;
            };

            return SignaturePad;
        })(document);

        var signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
            backgroundColor: 'rgba(255, 255, 255, 0)',
            penColor: 'rgb(0, 0, 0)',
            velocityFilterWeight: .7,
            minWidth: 0.5,
            maxWidth: 2.5,
            throttle: 16, // max x milli seconds on event update, OBS! this introduces lag for event update
            minPointDistance: 3,
        });
        var saveButton = document.getElementById('save'),
            clearButton = document.getElementById('clear'),
            showPointsToggle = document.getElementById('showPointsToggle');

        saveButton.addEventListener('click', function(event) {
            var data = signaturePad.toDataURL('image/png');
            window.open(data);
        });
        clearButton.addEventListener('click', function(event) {
            signaturePad.clear();
        });
        showPointsToggle.addEventListener('click', function(event) { 
            signaturePad.showPointsToggle();
            showPointsToggle.classList.toggle('toggle');
        });

    });

})(jQuery);
