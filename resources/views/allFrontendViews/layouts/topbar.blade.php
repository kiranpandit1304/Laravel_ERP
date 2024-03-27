<div class="iq-top-navbar">
    <div class="iq-navbar-custom">
        <nav class="navbar navbar-expand-lg navbar-light p-0">
            <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                <i class="ri-menu-line wrapper-menu"></i>
                <a href="index.html" class="header-logo">
                    <img src="{{asset('unsync_assets/assets/images/logo.png')}}" class="img-fluid rounded-normal light-logo" alt="logo" />
                    <img src="{{asset('unsync_assets/assets/images/logo-white.png')}}" class="img-fluid rounded-normal darkmode-logo" alt="logo" />
                </a>
            </div>
            <div class="iq-search-bar device-search">
                <form>
                    <div class="input-prepend input-append">
                        <div class="btn-group">
                            <label class="dropdown-toggle searchbox" data-toggle="dropdown">
                                <input class="dropdown-toggle search-query text search-input" type="text" placeholder="Type here to search..." /><span class="search-replace"></span>
                                <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                                <span class="caret"><!--icon--></span>
                            </label>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#">
                                        <div class="item bg_yellow squre_icon"><iconify-icon icon="tabler:brand-abstract"></iconify-icon>Clients & Vendors</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="item squre_icon bg_green"><iconify-icon icon="material-symbols:account-balance-wallet-outline"></iconify-icon>Accounting</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="item squre_icon bg_purple"><iconify-icon icon="material-symbols:leaderboard-outline-rounded"></iconify-icon>Leads & Tickets</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="item squre_icon bg_red"><iconify-icon icon="eos-icons:project-outlined"></iconify-icon>Projects</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="item squre_icon bg_darkblu"><iconify-icon icon="icon-park-outline:ad-product"></iconify-icon>Products & Inventory</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="item squre_icon bg_gray"><iconify-icon icon="ic:twotone-warehouse"></iconify-icon>Warehouse</div>
                                    </a>
                                </li>
                                @if(empty($auth_user->invitee_id) || $auth_user->invitee_id == null)
                                <li>

                                    <a href="#">
                                        <div class="item squre_icon bg_blue"><iconify-icon icon="fluent:people-team-16-regular"></iconify-icon>Team Management</div>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex align-items-center">
                <!-- <div class="change-mode">
                                <div class="custom-control custom-switch custom-switch-icon custom-control-inline">
                                    <div class="custom-switch-inner">
                                        <p class="mb-0"></p>
                                        <input type="checkbox" class="custom-control-input" id="dark-mode" data-active="true" />
                                        <label class="custom-control-label" for="dark-mode" data-mode="toggle">
                                            <span class="switch-icon-left"><i class="a-left"></i></span>
                                            <span class="switch-icon-right"><i class="a-right"></i></span>
                                        </label>
                                    </div>
                                </div>
                            </div> -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-label="Toggle navigation">
                    <i class="ri-menu-3-line"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-list align-items-center">
                        <li class="nav-item nav-icon search-content">
                            <a href="#" class="search-toggle rounded" id="dropdownSearch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ri-search-line"></i>
                            </a>
                            <div class="iq-search-bar iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownSearch">
                                <form action="#" class="searchbox p-2">
                                    <div class="form-group mb-0 position-relative">
                                        <input type="text" class="text search-input font-size-12" placeholder="type here to search..." />
                                        <a href="#" class="search-link"><i class="las la-search"></i></a>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <!-- <li class="nav-item nav-icon dropdown">
                                        <a href="#" class="search-toggle dropdown-toggle circle-hover" id="dropdownMenuButton01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ri-question-line"></i>
                                        </a>
                                        <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton01">
                                            <div class="card shadow-none m-0">
                                                <div class="card-body p-0">
                                                    <a href="#" class="iq-sub-card pt-0"><i class="ri-questionnaire-line"></i>Help</a>
                                                    <a href="#" class="iq-sub-card"><i class="ri-recycle-line"></i>Training</a>
                                                    <a href="#" class="iq-sub-card"><i class="ri-refresh-line"></i>Updates</a>
                                                    <a href="#" class="iq-sub-card"><i class="ri-service-line"></i>Terms and Policy</a>
                                                    <a href="#" class="iq-sub-card"><i class="ri-feedback-line"></i>Send Feedback</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li> -->
                        <li class="nav-item nav-icon dropdown notify">
                            <button class="search-toggle dropdown-toggle circle-hover" id="dropdownMenuButton02" data-bs-toggle="offcanvas" href="#offcanvasNotification" role="button" aria-controls="offcanvasNotification">
                                <i class="ri-notification-line"></i>
                                <div class="Canny_Badge">99</div>
                            </button>
                            <!-- <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton02">
                                            <div class="card shadow-none m-0">
                                                <div class="card-body p-0 notification_box">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4>Notifications</h4>
                                                            <a href="#">Mark as All Read</a>
                                                        </div>
                                                        <div class="card-body">
                                                            <a href="#">
                                                                <div class="card-item">
                                                                    <span class="bg_yellow squre_icon"><iconify-icon icon="tabler:brand-abstract"></iconify-icon></span>
                                                                    <div class="item-text">
                                                                        <h3>New Invoice Generated</h3>
                                                                        <p>2m ago</p>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <a href="#">
                                                                <div class="card-item">
                                                                    <span class="bg_green squre_icon"><iconify-icon icon="material-symbols:account-balance-wallet-outline"></iconify-icon></span>
                                                                    <div class="item-text">
                                                                        <h3>New Password created</h3>
                                                                        <p>2m ago</p>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <a href="#">
                                                                <div class="card-item">
                                                                    <span class="bg_purple squre_icon"><iconify-icon icon="material-symbols:leaderboard-outline-rounded"></iconify-icon></span>
                                                                    <div class="item-text">
                                                                        <h3>Your password has been saved.</h3>
                                                                        <p>2m ago</p>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="card-footer">
                                                            <a href="#">View all notifications</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                        </li>
                        <li class="nav-item nav-icon dropdown setting_drop">
                            <a href="#" class="search-toggle dropdown-toggle circle-hover" id="dropdownMenuButton02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ri-settings-3-line"></i>
                            </a>
                            <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton02">
                                <div class="card shadow-none m-0">
                                    <div class="card-body p-0">
                                        <div class="p-3">
                                            <!-- <a href="#" for="emailnotification" class="iq-sub-card pt-0 d-align">
                                                            <span><iconify-icon icon="icon-park-outline:dark-mode"></iconify-icon> Dark Mode</span>
                                                            <div class="change-mode">
                                                                <div class="custom-control custom-switch custom-switch-icon custom-control-inline">
                                                                    <div class="custom-switch-inner">
                                                                        <p class="mb-0"></p>
                                                                        <input type="checkbox" class="custom-control-input" id="dark-mode" data-active="true" />
                                                                        <label class="custom-control-label" for="dark-mode" data-mode="toggle">
                                                                            <span class="switch-icon-left"><i class="a-left"></i></span>
                                                                            <span class="switch-icon-right"><i class="a-right"></i></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a> -->
                                            <a href="#" for="emailnotification" class="iq-sub-card pt-0 d-align">
                                                <span><iconify-icon icon="ic:baseline-mode-standby"></iconify-icon> Practice Mode</span>
                                                <div class="pr-mode">
                                                    <input id="pr_mode" type="checkbox" hidden="hidden" />
                                                    <label class="switch" for="pr_mode"></label>
                                                </div>
                                            </a>
                                            <a href="team-member.html" class="iq-sub-card pt-0 tm_bar" data-toggle="modal" data-target="#teamPopup" type="button"> <iconify-icon icon="fluent:people-team-16-regular"></iconify-icon> Team Management </a>
                                            <a href="{{route('fn.business_setting', $enypt_id)}}" class="iq-sub-card pt-0"> <i class="ri-settings-3-line"></i> Business settings </a>
                                            <a href="settings.html" class="iq-sub-card pt-0"> <i class="ri-settings-3-line"></i> Account settings </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item nav-icon dropdown apps">
                            <a href="#" class="search-toggle dropdown-toggle circle-hover" id="dropdownMenuButton03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <iconify-icon icon="material-symbols:apps"></iconify-icon>
                            </a>
                            <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton03">
                                <div class="card mb-0">
                                    <div class="card-body wspace">
                                        <div class="icons-container">
                                            <a href="#" class="link bg-hover">
                                                <span class="bg_yellow squre_icon">
                                                    <iconify-icon icon="tabler:brand-abstract"></iconify-icon>
                                                </span>
                                                <span>Clients & Vendors</span>
                                            </a>
                                            <a href="#" class="link bg-hover">
                                                <span class="bg_green squre_icon">
                                                    <iconify-icon icon="material-symbols:account-balance-wallet-outline"></iconify-icon>
                                                </span>
                                                <span>Accounting</span>
                                            </a>

                                            <a href="#" class="link bg-hover">
                                                <span class="bg_purple squre_icon">
                                                    <iconify-icon icon="material-symbols:leaderboard-outline-rounded"></iconify-icon>
                                                </span>
                                                <span>Leads & Tickets</span>
                                            </a>

                                            <a href="#" class="link bg-hover">
                                                <span class="bg_red squre_icon">
                                                    <iconify-icon icon="eos-icons:project-outlined"></iconify-icon>
                                                </span>
                                                <span>Projects</span>
                                            </a>

                                            <a href="#" class="link bg-hover">
                                                <span class="bg_darkblu squre_icon">
                                                    <iconify-icon icon="icon-park-outline:ad-product"></iconify-icon>
                                                </span>
                                                <span>Products & Inventory</span>
                                            </a>

                                            <a href="#" class="link bg-hover">
                                                <span class="bg_gray squre_icon">
                                                    <iconify-icon icon="ic:twotone-warehouse"></iconify-icon>
                                                </span>
                                                <span>Warehouse</span>
                                            </a>
                                        </div>

                                        <div class="divider"></div>

                                        <div class="icons-container">
                                            <a href="#" class="link bg-hover">
                                                <span class="bg_orange squre_icon">
                                                    <iconify-icon icon="fluent:people-team-16-regular"></iconify-icon>
                                                </span>
                                                <span>Team Management</span>
                                            </a>

                                            <a href="#" class="link bg-hover">
                                                <span class="bg_dpurple squre_icon">
                                                    <iconify-icon icon="ri:apps-2-line"></iconify-icon>
                                                </span>
                                                <span>Manage Application</span>
                                            </a>

                                            <a href="#" class="link bg-hover">
                                                <span class="bg_light_Y squre_icon">
                                                    <iconify-icon icon="iconoir:profile-circle"></iconify-icon>
                                                </span>
                                                <span>User Profile</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item nav-icon dropdown caption-content account_box">
                            <a href="#" class="search-toggle dropdown-toggle" id="dropdownMenuButton03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="caption profile-blue line-height">MJ</div>
                            </a>
                            <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton03">
                                <div class="card mb-0">
                                    <div class="card-header d-flex justify-content-between mb-0">
                                        <div class="media my_media">
                                            <div class="rounded-circle iq-card-icon-small profile-green">
                                                MJ
                                            </div>
                                            <div class="media-body ml-3">
                                                <div class="media justify-content-between">
                                                    <h6 class="mb-0">Mo. Jafar</h6>
                                                </div>
                                                <p class="mb-0 font-size-12">9898 059598</p>
                                            </div>
                                        </div>
                                        <a  href="{{route('fn.business_setting', $enypt_id)}}">User Settings</a>
                                    </div>
                                    <div class="card-body">
                                        <div class="profile-header">
                                            <div class="profile-details mt-4 pt-4 border-top"></div>
                                            <a href="#" class="account">
                                                <div class="media align-items-center">
                                                    <div class="rounded-circle iq-card-icon-small profile-yellow">
                                                        US
                                                    </div>
                                                    <div class="media-body ml-2">
                                                        <div class="media justify-content-between">
                                                            <h6 class="mb-0">Unesync</h6>
                                                            <p class="mb-0 font-size-12"><i>Active</i></p>
                                                        </div>
                                                        <!-- <p class="mb-0 font-size-12">9898 059598</p> -->
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="account">
                                                <div class="media align-items-center">
                                                    <div class="rounded-circle iq-card-icon-small profile-red">
                                                        DS
                                                    </div>
                                                    <div class="media-body ml-2">
                                                        <div class="media justify-content-between">
                                                            <h6 class="mb-0">Decimal Space</h6>
                                                            <p class="mb-0 font-size-12"><i></i></p>
                                                        </div>
                                                        <!-- <p class="mb-0 font-size-12">9898 059598</p> -->
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="profile-details mt-2 pt-4 border-top"></div>
                                            <div class="st_menu">
                                                <a href="#" class="standerd_menu">
                                                    <iconify-icon icon="material-symbols:add-rounded"></iconify-icon>&nbsp;&nbsp;&nbsp;
                                                    Create New Business
                                                </a>
                                                <a href="#" class="standerd_menu tm">
                                                    <iconify-icon icon="fluent:people-team-16-regular"></iconify-icon>
                                                    Team Management
                                                </a>

                                                <a href="javascript:void(0)" onclick="logoutUser()" class="standerd_menu">
                                                    <svg height="24" viewBox="0 0 24 24" width="24" focusable="false" class="NMm5M">
                                                        <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"></path>
                                                        <path d="M0 0h24v24H0z" fill="none"></path>
                                                    </svg>
                                                    Sign out
                                                </a>
                                            </div>
                                            <div class="termsand">
                                                <a target="_blank" href="#">Privacy Policy</a>
                                                <span class="OtBgcb">&nbsp;•&nbsp;</span>
                                                <a target="_blank" href="#">Terms of Service</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>