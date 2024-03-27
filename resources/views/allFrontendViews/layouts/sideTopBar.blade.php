<div class="iq-sub-dropdown dropdown-menu advance_drop" aria-labelledby="dropdownMenuButton02">
            <div class="card shadow-none m-0">
                <div class="card-body p-0 notification_box">
                    <div class="card">
                        <div class="card-body">
                            <div class="main_bus">
                                <div class="lside_p">
                                    <span><img src="{{asset('unsync_assets/assets/images/logo.png')}}" class="" alt="logo" /></span>
                                    <h6>{{ (!empty($auth_user->active_business_id)) ? $commonData['active_business_data']->business_name : @$auth_user->mobile_no  }}</h6>
                                </div>
                                <div class="rside_p">
                                    <a href="#"><iconify-icon icon="ep:setting"></iconify-icon></a>
                                </div>
                            </div>
                            <label for="">Switch Business</label>
                            <div class="bu_list">
                                @foreach($commonData['business'] as $business) 
                                <div class="main_bus">
                                    <a href="#" onclick="switchBusiness(this)" data-id="{{@$business->id}}">
                                        <div class="lside_p">
                                            <span>
                                                @if(!empty($business->business_logo))
                                            <img src="{{@$business->business_logo}}" class="" alt="logo" />
                                            @else
                                            <?= substr($business->business_name, 0, 2); ?>
                                            @endif
                                        </span>
                                            <h6>{{@$business->business_name}}</h6>
                                        </div>
                                        <div class="rside_p">
                                            @if(!empty($auth_user->active_business_id) && $auth_user->active_business_id ==$business->id)
                                            <iconify-icon icon="charm:tick"></iconify-icon>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                                <!-- <div class="main_bus">
                                    <a href="javascript:void(0)" onclick="switchBusiness(this)" data-id="0">
                                        <div class="lside_p">
                                            <span><img src="{{asset('unsync_assets/assets/images/logo_crop.png')}}" class="" alt="logo" /></span>
                                            <h6>{{ @$auth_user->mobile_no  }}</h6>
                                        </div>
                                        <div class="rside_p">
                                        @if($auth_user->active_business_id =='0')
                                            <iconify-icon icon="charm:tick"></iconify-icon>
                                            @endif
                                        </div>
                                    </a>
                                </div> -->
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="main_bus">
                                <button type="button" id="opencreatenewbusiness">
                                    <div class="lside_p">
                                        <span class="animated tada"><iconify-icon icon="ic:round-add"></iconify-icon></span>
                                        <h6>Create New Business</h6>
                                    </div>
                                    <div class="rside_p">
                                        <!-- <iconify-icon icon="charm:tick"></iconify-icon> -->
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>