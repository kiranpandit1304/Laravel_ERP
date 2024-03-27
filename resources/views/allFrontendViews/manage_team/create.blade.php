<!-- Create Team Member - Bottom Full Screen Popup -->
<div class="cibsp" id="createItem">
            <div class="cibsp_header">
                <a href="#" class="close_cibsp"><iconify-icon icon="material-symbols:close-rounded"></iconify-icon></a>
                <h2>Create team member</h2>
                <span>&nbsp;</span>
            </div>
            <div class="mini_continer">
                <div class="cibsp_body">
                    <h4>Contact information</h4>
                    <br/>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>
                                    <input class="member_name" type="text" required="" id="" placeholder="Name">
                                    <span>Name</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>
                                    <input class="email" type="email" required="" id="" placeholder="Email Address">
                                    <span>Email Address</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <h4 class="set_up">Permissions <span>(Apps)</span></h4>
                    <div class="apps_list create_member">
                        <ul>
                        @foreach($modules as $key=>$module)
                            <li>
                                <h5>
                                    <span class="bg_yellow squre_icon"><iconify-icon icon="tabler:brand-abstract"></iconify-icon></span>{{@$module->name}}
                                </h5>
                                <div class="selec_s">
                                    <select class="js-states form-control nosearch permission_id" id="list{{@$key}}" name="module_list[]">
                                        <option value="">No Access</option>
                                        <option value="1">Edit</option>
                                        <option value="2">View</option>
                                    </select>
                                </div>
                            </li>
                            <input type="hidden" class="moduleList" value="{{$module->id}}" />
                            @endforeach
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <span class="al_center">
                            <a href="#" class="blue primary_cta ct_btn save_btn"><iconify-icon icon="pajamas:plus"></iconify-icon> Create</a>
                                <a href="#" class="blue primary_cta ct_btn add_another_btn hide-d"><iconify-icon icon="pajamas:plus"></iconify-icon> Add another team member</a>
                            </span>
                        </div>
                    </div>
                    <div class="invite_link">
                        <h4>Invite Link</h4>
                        <br />
                        <div class="link_box">
                            <input class="" type="text" value="" id="linkcopborad" disabled>
                            <a href="#" onclick="copyText()"><iconify-icon icon="basil:copy-outline"></iconify-icon></a>
                            <p class="link_copied hide-d"><iconify-icon icon="mdi:tick-circle"></iconify-icon> Link Copied</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>