<!-- Team Popup -->
<div class="modal fade twoside_modal" id="teamPopup" tabindex="-1" role="dialog" aria-labelledby="teamPopupLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close close_team_ppup" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-5 col-sm-5 col-xs-12">
                        <div class="team_list">
                            <div class="tl_header">
                                <h5>Team Members</h5>
                            </div>
                            <div class="team_invitee_list">

                            </div>
                            <!-- <div class="tlfooter">
                                        <div class="card-item">
                                            <span class="circle_icon"><iconify-icon icon="material-symbols:lock-outline"></iconify-icon></span>
                                            <div class="item-text">
                                                <h3>Restricted</h3>
                                                <p>Only people with access can open with the link</p>
                                            </div>
                                        </div>
                                    </div> -->
                        </div>
                    </div>
                    <div class="col-lg-7 col-sm-7 col-xs-12 flush">
                        <div class="shinvite">
                            <div class="shi_header">
                                <h5>Sent Invite</h5>
                                <a href="#"><iconify-icon icon="ph:info"></iconify-icon></a>
                            </div>
                            <div class="shi_body">
                                <div class="search_in">
                                    <input type="text" id="exist-values" class="tagged form-control email" data-removeBtn="true" name="tag-2" value="" placeholder="Add people">
                                </div>
                                <div class="add_message">
                                    <textarea name="" id="" cols="30" rows="5" placeholder="Message"></textarea>
                                </div>
                                <h6>Applications</h6>
                                <div class="apps_list">
                                    <ul class="moduleList_d">
                                        @foreach($modules as $key=>$module)
                                        <li>
                                            <h5><span class="bg_green squre_icon"><iconify-icon icon="material-symbols:account-balance-wallet-outline"></iconify-icon></span> {{@$module->name}}</h5>
                                            <div class="selec_s">
                                                <select class="ddl-select permission_id" id="list{{@$key}}" name="module_list[]">
                                                    <option value="">Give Access</option>
                                                    <option value="1">Edit and View</option>
                                                    <option value="2">Only View</option>
                                                </select>
                                            </div>
                                        </li>
                                        <input type="hidden" class="moduleList" value="{{$module->id}}" />
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="shi_footer">
                                <span>
                                    <!-- <p class="hide-d" id="linkcopborad">hello</p> -->
                                    <input class="hide-d" type="text" value="" id="linkcopborad">
                                    <button class="copy_link hide-d" onclick="copyText()"><iconify-icon icon="ic:baseline-insert-link"></iconify-icon> Copy link</button>
                                    <p class="link_copied hide-d"><iconify-icon icon="mdi:tick-circle"></iconify-icon> Link Copied</p>
                                </span>
                                <button class="done_btn save_btn ">Done</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ...........Edit -->
<div class="modal fade twoside_modal" id="teamEditPopup" tabindex="-1" role="dialog" aria-labelledby="teamPopupLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close close_team_edit_ppup" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-2 col-sm-2 col-xs-12">
                        <!-- <div class="team_list">
                            <div class="tl_header">
                                <h5>Team Member</h5>
                            </div>
                        </div> -->
                    </div>
                    <div class="col-lg-9 col-sm-9 col-xs-12 flush">
                        <div class="shinvite">
                            <div class="shi_header">
                                <h5>Team Member</h5>
                                <a href="#"><iconify-icon icon="ph:info"></iconify-icon></a>
                            </div>
                            <div class="shi_body">
                                <div class="search_in">
                                    <label>Name: </label> <span class="team_user_name"> </span><br />
                                    <label>Email: </label> <span class="team_user_email">  </span><br />
                                    <label>Phone: </label> <span class="team_user_phone"> </span>
                                   <input type="hidden" class="edit_user_id" value="" />
                                    <hr />
                                </div>
                                <h6>Applications</h6>
                                <div class="apps_list">
                                    <ul class="moduleList_d module_edit_list">
                                        @foreach($modules as $key=>$module)
                                        <li>
                                            <h5><span class="bg_green squre_icon"><iconify-icon icon="material-symbols:account-balance-wallet-outline"></iconify-icon></span> {{@$module->name}}</h5>
                                            <div class="selec_s">
                                                <select class="ddl-select edit_permission_id" id="editlist{{@$key}}" name="module_list[]">
                                                    <option value="">Give Access</option>
                                                    <option value="1">Edit and View</option>
                                                    <option value="2">Only View</option>
                                                </select>
                                            </div>
                                        </li>
                                        <input type="hidden" class="moduleList" value="{{$module->id}}" />
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="shi_footer">
                                <span>
                                </span>
                                <button class="done_btn update_btn " onclick="updateTeamPermission()" >Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End Modal -->

@push('custom-scripts')
<script src="{{asset('js/custom/jquery.validate.min.js')}}"></script>
<script src="{{ asset('js/tags.js')}}"></script>

<script>
    function copyText() {
        $(".copy_link").addClass("hide-d");
        $(".link_copied").removeClass("hide-d");
        // Get the text field
        var copyText = document.getElementById("linkcopborad");

        // Select the text field
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);
    }

    var tags = new Tags('.tagged');
    $("body").on("focusout", ".tag-input", function() {
        tags.addTags($(".tag-input").val());
    });
</script>
<script>

    $("body").on("click", ".close_team_ppup", function(){
          $("#teamPopup").modal("hide");
    });
    $("body").on("click", ".close_team_edit_ppup", function(){
          $("#teamEditPopup").modal("hide");
    });

    $("body").on("click", "#showTeaModal", function() {
        $(".copy_link").addClass("hide-d");
        $(".link_copied").addClass("hide-d");
        var user = JSON.parse(localStorage.getItem("user"));
        $.ajax({
            url: APP_URL + "/api/inviteeUsersList/" + user.id,
            type: "GET",
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
                    if (response?.data != null && response?.data != '' && response?.data.length > 0) {
                        var inviteeHtml = [];
                        for (var i = 0; i <= response?.data.length; i++) {
                            if (response?.data[i]?.id != '' && response?.data[i]?.id != undefined && response?.data[i]?.id != null) {
                                inviteeHtml += '<div class="card-item">';
                                inviteeHtml += '       <span class="circle_icon">R</span>';
                                inviteeHtml += '       <div class="item-text">';
                                inviteeHtml += '          <h3>' + response?.data[i]?.mobile_no + '</h3>';
                                inviteeHtml += '      </div>';
                                inviteeHtml += '      <a href="#" onclick="editTeamMember(this)" data-id="'+response?.data[i]?.id+'" ><iconify-icon icon="material-symbols:edit"></iconify-icon> Edit</a>';
                                inviteeHtml += '  </div>';
                            }
                        }
                        $(".team_invitee_list").empty().append(inviteeHtml);
                    }
                    // $('.cid').val(response?.id);

                }
                //    $("#teamPopup").modal("show")

            },
            error: function(response) {
                block_gui_end();
                console.log("server side error");
            }
        });
        $(".tag-input").val('');
        $(".tag").remove();
        $(".email").val('');
        $(".permission_id").val('');
        $("#teamPopup").modal("show")
    });

    function editTeamMember(event) {
      var uid = $(event).attr("data-id");
        $.ajax({
            url: APP_URL + "/api/teamMemberUserDetail/"+uid,
            type: 'get',
            data: '',
            beforeSend: function(xhr) {
                block_gui_start();
                xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

            },
            success: function(resp) {
                block_gui_end();

                if (resp.status == true) {
                } 
         $(".team_user_name").text(resp?.data?.name);
         $(".team_user_email").text(resp?.data?.email);
         $(".team_user_phone").text(resp?.data?.mobile_no);
         $(".edit_user_id").val(resp?.data?.id);

        var modules = <?= json_encode($modules) ?>;
        var moduleHtml = [];
        for (var j = 0; j < modules.length; j++) {
            var selected_permision = '';
            var is_edit_pemission = '';
            var is_view_pemission = '';
            let user_permisson = resp?.permisson.filter((item) => item.module_id === modules[j]?.id);
            selected_permision= user_permisson[0]?.permission_id;
            if(selected_permision==1){
                is_edit_pemission='selected'
            }else if(selected_permision==2){
                is_view_pemission='selected'
            }
            moduleHtml += '<li>';
            moduleHtml += '                  <h5><span class="bg_green squre_icon"><iconify-icon icon="material-symbols:account-balance-wallet-outline"></iconify-icon></span>' + modules[j]?.name + '</h5>';
            moduleHtml += '                  <div class="selec_s">';
            moduleHtml += '                      <select class="form-select edit_permission_id"  id="editlist1'+j+'" name="module_list[]" aria-label="Default select example">';
            moduleHtml += '                          <option value="" >Give Access</option>';
            moduleHtml += '                          <option value="1" '+is_edit_pemission+' >Edit and View</option>';
            moduleHtml += '                          <option value="2" '+is_view_pemission+' >Only View</option>';
            moduleHtml += '                      </select>';
            moduleHtml += '                  </div>';
            moduleHtml += '              </li>';
            moduleHtml += '              <input type="hidden" class="edit_moduleList" value="' + modules[j]?.id + '" />';
        }
        $(".module_edit_list").empty().append(moduleHtml);
        $("#teamEditPopup").modal("show");
            },
            error: function(resp) {
                block_gui_end();
                console.log("server side error");
            },
        });

       
    }

    function updateTeamPermission(){
        
        var form_data = new FormData();
        var limit = $(".edit_permission_id").length;
        var indx = 0;
        for (var j = 0; j <= limit; j++) {
            if ($(".edit_permission_id") && $(".edit_permission_id")[j]?.value != '' && $(".edit_permission_id")[j]?.value != undefined) {
                form_data.append('module_id[' + indx + ']', $(".edit_moduleList")[j]?.value);
                form_data.append('permission_id[' + indx + ']', $(".edit_permission_id")[j]?.value);
                indx++;
            }
        }
        
        form_data.append('user_id', $(".edit_user_id").val());
        $.ajax({
            url: APP_URL + "/api/UserPermissonEdit",
            data: form_data,
            type: "post",
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
                    $("#teamEditPopup").modal("hide");
                    toastr.success(response?.message)
                } else {
                    toastr.error(response?.message)
                }
            },
            error: function(response) {
                block_gui_end();
                toastr.error(response?.message)
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        $.ajax({
            url: APP_URL + "/api/moduleList",
            type: 'get',
            data: '',
            success: function(resp) {
                if (resp.status == true) {
                    var dataList = resp.data;
                    var html = [];
                    for (var i = 0; i <= dataList.length; i++) {
                        if (dataList[i]?.id != undefined) {
                            html += '<li>';
                            html += '<h5><span class="bg_yellow squre_icon"><iconify-icon icon="tabler:brand-abstract"></iconify-icon></span>' + dataList[i]?.name + '  </h5>';
                            html += ' <div class="selec_s">';
                            html += ' <select class="ddl-select" id="list"' + dataList[i]?.id + ' name="list">';
                            html += '   <option>No Access</option>';
                            html += '   <option value="1">Edit</option>';
                            html += '   <option value="2">View</option>';
                            html += ' </select>';
                            html += ' </div>';
                            html += ' </li>';
                        }
                    }
                    //    $(".moduleList_d").append(html);
                    //    setSelectValue();
                } else {
                    toastr.error(resp?.message)
                }
                console.log('data ', data);
            },
            error: function(resp) {
                console.log("server side error");
            },
        });
    });
</script>
<script>


    $("body").on("click", '.save_btn', function() {
       
        var form_data = new FormData();
        var email = '';
        if ($(".email").val() != '' && $(".email").val() != undefined)
            email = $(".email").val();
        else
            email = $(".tag-input").val();

        form_data.append('email', email);

        var limit = $(".permission_id").length;
        var index = 0;
        for (var j = 0; j <= limit; j++) {
            if ($(".permission_id") && $(".permission_id")[j]?.value != '' && $(".permission_id")[j]?.value != undefined) {
                form_data.append('module_id[' + index + ']', $(".moduleList")[j]?.value);
                form_data.append('permission_id[' + index + ']', $(".permission_id")[j]?.value);
                index++;
            }
        }
        form_data.append('_token', csrfTokenVal);
        $.ajax({
            url: APP_URL + "/api/send_invite",
            data: form_data,
            type: "post",
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(xhr) {
                block_gui_start();
                xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

            },
            success: function(response) {
                block_gui_end();
                $("#save_btn").prop("disabled", false);
                if (response.status == true) {
                    $(".email").val('');
                    $(".tag-input").val('');
                    toastr.success(response?.message)
                    $("#linkcopborad").val(response?.link);
                    $(".copy_link").removeClass("hide-d");
                    $(".link_copied").addClass("hide-d");
                    setTimeout(function () {
                        $(".link_copied").addClass("hide-d");
                    }, 5000);
                } else {
                    toastr.error(response?.message)
                }
            },
            error: function(response) {
                block_gui_end();
                $("#save_btn").prop("disabled", false);
                toastr.error(response?.message)
            }
        });
    });

    function validateEmail(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
          return regex.test(email);
    }
</script>
@endpush