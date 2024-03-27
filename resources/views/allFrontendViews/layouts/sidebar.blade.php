<div class="iq-sidebar sidebar-default">
    <div class="iq-sidebar-logo d-flex align-items-center justify-content-between advance_logo">
        <a href="#" class="dropdown-toggle circle-hover header-logo" id="dropdownMenuButton02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="{{asset('unsync_assets/assets/images/logo.png')}}" class="img-fluid rounded-normal light-logo" alt="logo" />
            <iconify-icon icon="bx:rotate-left"></iconify-icon>
            <!-- <img src="assets/images/logo-white.png" class="img-fluid rounded-normal darkmode-logo" alt="logo" /> -->
        </a>
        @include('allFrontendViews.layouts.sideTopBar')
        <!-- <a href="index.html" class="header-logo">
                        <img src="assets/images/logo.png" class="img-fluid rounded-normal light-logo" alt="logo" />
                        <img src="assets/images/logo-white.png" class="img-fluid rounded-normal darkmode-logo" alt="logo" />
                    </a> -->
        <div class="iq-menu-bt-sidebar">
            <i class="las la-bars wrapper-menu"></i>
        </div>
    </div>
    <div class="data-scrollbar" data-scroll="1">
        <div class="new-create select-dropdown input-prepend input-append">
            <div class="btn-group">
                <label data-toggle="dropdown">
                    <div class="search-query selet-caption">
                        <svg fill="#8C14FC" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" viewBox="0 0 45.402 45.402" xml:space="preserve">
                            <g>
                                <path d="M41.267,18.557H26.832V4.134C26.832,1.851,24.99,0,22.707,0c-2.283,0-4.124,1.851-4.124,4.135v14.432H4.141
                                            c-2.283,0-4.139,1.851-4.138,4.135c-0.001,1.141,0.46,2.187,1.207,2.934c0.748,0.749,1.78,1.222,2.92,1.222h14.453V41.27
                                            c0,1.142,0.453,2.176,1.201,2.922c0.748,0.748,1.777,1.211,2.919,1.211c2.282,0,4.129-1.851,4.129-4.133V26.857h14.435
                                            c2.283,0,4.134-1.867,4.133-4.15C45.399,20.425,43.548,18.557,41.267,18.557z" />
                            </g>
                        </svg>
                        Create New
                    </div>
                    <span class="search-replace"></span>
                    <span class="caret"><!--icon--></span>
                </label>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">
                            <span class="bg_yellow squre_icon"><iconify-icon icon="tabler:brand-abstract"></iconify-icon></span><span>Clients & Vendors</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="{{route('fn.customers', $enypt_id)}}">Customer</a></li>
                            <li><a tabindex="-1" href="{{route('fn.vendors', $enypt_id)}}">Vendor</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">
                            <span class="bg_green squre_icon"><iconify-icon icon="material-symbols:account-balance-wallet-outline"></iconify-icon></span><span>Accounting</span>
                        </a>
                        <ul class="dropdown-menu"> 
                            <li><a tabindex="-1" href="create-invoice.html">Invoices</a></li>
                            <li><a tabindex="-1" href="#">Banking</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">
                            <span class="bg_purple squre_icon"><iconify-icon icon="material-symbols:leaderboard-outline-rounded"></iconify-icon></span><span>Leads & Tickets</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="#">Form</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">
                            <span class="bg_red squre_icon"><iconify-icon icon="eos-icons:project-outlined"></iconify-icon></span><span>Projects</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="#">Timesheet</a></li>
                        </ul>
                    </li>
                    @if(!empty($permissions) && array_key_exists("products_inventory", $permissions) || $auth_user->parent_id==0)

                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">
                            <span class="bg_darkblu squre_icon"><iconify-icon icon="icon-park-outline:ad-product"></iconify-icon></span><span>Products & Inventory</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="{{route('fn.inventory', $enypt_id)}}">Product</a></li>
                        </ul>
                    </li>
                    @endif
                    @if(!empty($permissions) && array_key_exists("warehouse", $permissions) || $auth_user->parent_id==0)
                    <li class="dropdown-submenu">
                        <a tabindex="-1" href="#">
                            <span class="bg_gray squre_icon"><iconify-icon icon="ic:twotone-warehouse"></iconify-icon></span><span>Warehouse</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="#">POSM</a></li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">
                <li class="active">
                    <a href="{{route('fn.dashboard', $enypt_id)}}" class="">
                        <iconify-icon style="opacity: 0;" icon="ic:baseline-arrow-right" class="iq-arrow-right arrow-active"></iconify-icon>
                        <span class="bg_blue squre_icon"><iconify-icon icon="tabler:home"></iconify-icon></span><span>Dashboard</span>
                    </a>
                    <ul id="dashboard" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle"></ul>
                </li>
                @if(!empty($permissions) && array_key_exists("Client_Vendors", $permissions) || $auth_user->parent_id==0)

                <li class=" ">
                    <a href="#mydrive" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <iconify-icon icon="ic:baseline-arrow-right" class="iq-arrow-right arrow-active"></iconify-icon>
                        <iconify-icon icon="ic:baseline-arrow-drop-down" class="iq-arrow-right arrow-hover"></iconify-icon>
                        <span class="bg_yellow squre_icon"><iconify-icon icon="tabler:brand-abstract"></iconify-icon></span><span>Clients & Vendors</span>
                    </a>
                    <ul id="mydrive" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class=" ">
                            <a href="{{route('fn.customers', $enypt_id)}}">
                                <span class="squre_icon"><iconify-icon icon="fluent-mdl2:recruitment-management"></iconify-icon></span><span>Customer management</span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="{{route('fn.vendors', $enypt_id)}}">
                                <span class="squre_icon"><iconify-icon icon="fluent-mdl2:recruitment-management"></iconify-icon></span><span>Vendor management</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                @if(!empty($permissions) && array_key_exists("accounting", $permissions) || $auth_user->parent_id==0)
                <li class=" ">
                    <a href="#accounting" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <iconify-icon icon="ic:baseline-arrow-right" class="iq-arrow-right arrow-active"></iconify-icon>
                        <iconify-icon icon="ic:baseline-arrow-drop-down" class="iq-arrow-right arrow-hover"></iconify-icon>
                        <span class="bg_green squre_icon"><iconify-icon icon="material-symbols:account-balance-wallet-outline"></iconify-icon></span><span>Accounting</span>
                    </a>
                    <ul id="accounting" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class=" ">
                            <a href="{{route('fn.invoices', $enypt_id)}}">
                                <span class="squre_icon"><iconify-icon icon="uil:invoice"></iconify-icon></span><span>Invoices</span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="#">
                                <span class="squre_icon"><iconify-icon icon="fluent:payment-32-regular"></iconify-icon></span><span>Quotations & Estimates</span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="#">
                                <span class="squre_icon"><iconify-icon icon="ri:bank-line"></iconify-icon></span><span>Proforma Invoices</span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="#">
                                <span class="squre_icon"><iconify-icon icon="ep:memo"></iconify-icon></span><span>Expense Management</span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="#">
                                <span class="squre_icon"><iconify-icon icon="ep:memo"></iconify-icon></span><span>Payment Receipts</span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="#">
                                <span class="squre_icon"><iconify-icon icon="uil:bill"></iconify-icon></span><span>Purchase Orders</span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="#">
                                <span class="squre_icon"><iconify-icon icon="material-symbols:settings-account-box-outline"></iconify-icon></span><span>Delivery Challans</span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="#">
                                <span class="squre_icon"><iconify-icon icon="material-symbols:account-tree-outline-rounded"></iconify-icon></span><span>Credit Notes</span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="#">
                                <span class="squre_icon"><iconify-icon icon="material-symbols:payments-outline-rounded"></iconify-icon></span><span>Debit Notes</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                <li class="">
                    <a href="#products" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <iconify-icon icon="ic:baseline-arrow-right" class="iq-arrow-right arrow-active"></iconify-icon>
                        <iconify-icon icon="ic:baseline-arrow-drop-down" class="iq-arrow-right arrow-hover"></iconify-icon>
                        <span class="bg_darkblu squre_icon"><iconify-icon icon="icon-park-outline:ad-product"></iconify-icon></span><span>Inventory & Warehouse</span>
                    </a>
                    <ul id="products" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        @if(!empty($permissions) && array_key_exists("products_inventory", $permissions) || $auth_user->parent_id==0)

                        <li class="">
                            <a href="{{route('fn.inventory', $enypt_id)}}">
                                <span class="squre_icon"><iconify-icon icon="icon-park-outline:ad-product"></iconify-icon></span><span>Inventory</span>
                            </a>
                        </li>
                        @endif
                        @if(!empty($permissions) && array_key_exists("warehouse", $permissions) || $auth_user->parent_id==0)
                        <li class="">
                            <a href="">
                                <span class="squre_icon"><iconify-icon icon="icon-park-outline:ad-product"></iconify-icon></span><span>Warehouse</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                <!-- <li class=" ">
                                <a href="#leads" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                    <iconify-icon icon="ic:baseline-arrow-right" class="iq-arrow-right arrow-active"></iconify-icon>
                                    <iconify-icon icon="ic:baseline-arrow-drop-down" class="iq-arrow-right arrow-hover"></iconify-icon>
                                    <span class="bg_purple squre_icon"><iconify-icon icon="material-symbols:leaderboard-outline-rounded"></iconify-icon></span><span>Leads & Tickets</span>
                                </a>
                                <ul id="leads" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                    <li class=" ">
                                        <a href="#">
                                            <span class="squre_icon"><iconify-icon icon="material-symbols:leaderboard-outline-rounded"></iconify-icon></span><span>Leads</span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="#">
                                            <span class="squre_icon"><iconify-icon icon="mdi:deal-outline"></iconify-icon></span><span>Deals</span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="#">
                                            <span class="squre_icon"><iconify-icon icon="clarity:form-line"></iconify-icon></span><span>Form Builder</span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="#">
                                            <span class="squre_icon"><iconify-icon icon="material-symbols:system-update-alt"></iconify-icon></span><span>CRM system setup</span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="#">
                                            <span class="squre_icon"><iconify-icon icon="carbon:cloud-service-management"></iconify-icon></span><span>Ticket management</span>
                                        </a>
                                    </li>
                                </ul>
                            </li> -->
                <!-- <li class=" ">
                                <a href="#projects" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                    <iconify-icon icon="ic:baseline-arrow-right" class="iq-arrow-right arrow-active"></iconify-icon>
                                    <iconify-icon icon="ic:baseline-arrow-drop-down" class="iq-arrow-right arrow-hover"></iconify-icon>
                                    <span class="bg_red squre_icon"><iconify-icon icon="eos-icons:project-outlined"></iconify-icon></span><span>Projects</span>
                                </a>
                                <ul id="projects" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                    <li class=" ">
                                        <a href="#">
                                            <span class="squre_icon"><iconify-icon icon="eos-icons:project-outlined"></iconify-icon></span><span>Projects</span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="#">
                                            <span class="squre_icon"><iconify-icon icon="fe:list-task"></iconify-icon></span><span>Task</span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="#">
                                            <span class="squre_icon"><iconify-icon icon="ic:round-more-time"></iconify-icon></span><span>Timesheet</span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="#">
                                            <span class="squre_icon"><iconify-icon icon="material-symbols:calendar-month"></iconify-icon></span><span>Task Calendar</span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="#">
                                            <span class="squre_icon"><iconify-icon icon="fluent-mdl2:trackers"></iconify-icon></span><span>Tracker</span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="#">
                                            <span class="squre_icon"><iconify-icon icon="mdi:report-bell-curve"></iconify-icon></span><span>Project report</span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="#">
                                            <span class="squre_icon"><iconify-icon icon="octicon:project-roadmap-24"></iconify-icon></span><span>Project system setup</span>
                                        </a>
                                    </li>
                                </ul>
                            </li> -->
            </ul>
        </nav>
        <div class="sidebar-addnew">
            <nav class="iq-sidebar-menu">
                <ul id="iq-sidebar-toggle" class="iq-menu">
                    <li>
                        <a type="button" data-bs-toggle="offcanvas" href="#offcanvasFilter" role="button" aria-controls="offcanvasFilter">
                            <!-- <iconify-icon style="opacity: 0;" icon="ic:baseline-arrow-right" class="iq-arrow-right arrow-active"></iconify-icon> -->
                            <span class="squre_icon"><iconify-icon icon="material-symbols:add-rounded"></iconify-icon></span><span>Manage applications</span>
                        </a>
                        <ul id="page-files" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle"></ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="sidebar-bottom">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">
                <li>
                    @if(empty($auth_user->invitee_id) || $auth_user->invitee_id == null)
                    <a href="{{route('fn.team_management', $enypt_id)}}" type="button" id="showTeaModal1">
                        <!-- <a href="#" type="button" data-toggle="modal" data-target="#teamPopup"> -->
                        <iconify-icon style="opacity: 0;" icon="ic:baseline-arrow-right" class="iq-arrow-right arrow-active"></iconify-icon>
                        <span class="squre_icon"><iconify-icon icon="fluent:people-team-16-regular"></iconify-icon></span><span>Team Management</span>
                    </a>
                    @endif
                    <ul id="page-files" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle"></ul>
                </li>
            </ul>
        </nav>
    </div>
</div>

@include('allFrontendViews.layouts.topbar')

