<!-- Filter Customer Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasFilter" aria-labelledby="offcanvasFilterLabel">
            <div class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h5 class="offcanvas-title" id="offcanvasFilterLabel">Add Filters</h5>
                <span>&nbsp;</span>
                <!-- <div class="card-header-toolbar">
                    <div class="dropdown">
                        <span class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown" aria-expanded="true">
                            <i class="ri-more-fill"></i>
                        </span>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton2" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-140px, 24px, 0px);">
                            <a class="dropdown-item" href="#">Edit Customer</a>
                            <a class="dropdown-item" href="#">Merge with another Customer</a>
                            <a class="dropdown-item" href="#">Delete Customer</a>
                        </div>
                    </div>
                </div> -->
            </div>
            <div class="offcanvas-body">
                <div class="offcanvas_details">
                    
                    <div class="ft_item">
                        <div class="od_card">
                            <div class="od_card_header">
                                <h3>Item name</h3>
                            </div>
                            <div class="od_card_body">
                                <input type="text" class="" name="" id="search_item_name" placeholder="Search by Item name">
                            </div>
                        </div>

                        <div class="od_card">
                            <div class="od_card_header">
                                <h3>Buying Price</h3>
                            </div>
                            <div class="od_card_body align_pr">
                                <input type="text" class="" name="" id="search_buying_from" placeholder="From">
                                <input type="text" class="" name="" id="search_buying_to" placeholder="To">
                            </div>
                        </div>

                        <div class="od_card">
                            <div class="od_card_header">
                                <h3>Selling Price</h3>
                            </div>
                            <div class="od_card_body align_pr">
                                <input type="text"  class="" name="" id="search_selling_from" placeholder="From">
                                <input type="text"  class="" name="" id="search_selling_to" placeholder="To">
                            </div>
                        </div>

                        <div class="od_card">
                            <div class="od_card_header">
                                <h3>Tax Rate(in %)</h3>
                            </div>
                            <div class="od_card_body">
                                <input type="text" class="" name="" id="search_tax_rate" placeholder="Search by Tax Rate">
                            </div>
                        </div>
                    </div>

                    <div class="bottom_bar_d filter_bar">
                        <p class="filtered_total_result" >0 Result shown</p>
                        <span>
                            <a href="#" class="normal_style" onclick="ResetDomainPage(this)">Reset</a>
                            <a href="#" class="cm_style" onclick="applyfillter(this)">Apply</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>   
