<!-- View Filters Offcanvas -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.2.0/tailwind.min.css" />
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasFilter" aria-labelledby="offcanvasFilterLabel">
    <div class="offcanvas-header">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
            <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
        </button>
        <h5 class="offcanvas-title" id="offcanvasFilterLabel">Add Filters</h5>
        <span>&nbsp;</span>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvas_details">
            <div class="ft_item">
                <div class="od_card">
                    <div class="od_card_header">
                        <h3>Select Invoice Status</h3>
                    </div>
                    <div class="od_card_body">
                        <select class="js-example-placeholder-single-status  " id="filterinv_status">
                        <option value="" selected>All</option>
                            <option value="Paid">Paid</option>
                            <option value="Unpaid">Unpaid</option>
                            <option value="Cancelled">Cancelled</option>
                            <option value="Part Paid">Part Paid</option>
                        </select>
                    </div>
                </div>

                <div class="od_card">
                    <div class="od_card_header">
                        <h3>Search Client</h3>
                    </div>
                    <div class="od_card_body">
                        <select class="js-example-placeholder-single-client  " id="filter_inv_client_id">
                        <option value="" selected>Select</option>
                                    @foreach($commonData['customers'] as $customer)
                                    <option value="{{$customer->id}}">{{ $customer->name}}</option>
                                    @endforeach
                        </select>
                    </div>
                </div>

                <div class="od_card">
                    <div class="od_card_header">
                        <h3>Select Start Range</h3>
                    </div>
                    <div class="od_card_body">
                        <input type="date" name="" id="filter_inv_start_date" placeholder="Search by Date" />
                    </div>
                </div>
                <div class="od_card">
                    <div class="od_card_header">
                        <h3>Select End Date</h3>
                    </div>
                    <div class="od_card_body">
                        <input type="date" name="" id="filter_inv_end_date" placeholder="Search by Date" />
                    </div>
                </div>
            </div>

            <div class="bottom_bar_d filter_bar">
                <p class="filtered_total_result">0 Results shown</p>
                <span>
                    <a href="#" class="normal_style" onclick="ResetDomainPage(this)">Reset</a>
                    <a href="#" onclick="applyfillter(this)" class="cm_style">Apply</a>
                </span>
            </div>
        </div>
    </div>
</div>
@push('custom-scripts')
   <script>
$(".js-example-placeholder-single-status").select2({
    // placeholder: "Select Country",
});
$(".js-example-placeholder-single-client").select2({
    // placeholder: "Select Country",
});
</script>
@endpush