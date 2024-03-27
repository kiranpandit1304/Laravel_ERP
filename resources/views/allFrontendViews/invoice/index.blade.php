@extends('allFrontendViews.layouts.app')
@section('page-title')
{{__('Invoices')}}
@endsection
@push('css-page')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
@endpush
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 flush">
            <div class="page_head">
                <div class="actions_bar">
                    <div class="filter_main">
                        <span class="bg_green squre_icon"><iconify-icon icon="tabler:brand-abstract"></iconify-icon></span>
                        <h2>Invoices</h2>
                    </div>
                    <div class="action_btns">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#importPopup"><iconify-icon icon="pajamas:import"></iconify-icon> Import Item</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#exportPopup"><iconify-icon icon="pajamas:export"></iconify-icon> Export Item</a>
                                </li>
                            </ul>
                        </div>
                        <a href="{{route('fn.invoice_step1', $enypt_id)}}" class="main_btn" type="button"><iconify-icon icon="pajamas:plus"></iconify-icon> Create New Invoice</a>
                    </div>
                </div>
            </div>
            <div class="page_action_and_titlebar">
                <div class="icon_showcase">
                    <div class="overview_cards">
                        <div class="ov_card">
                            <div class="inner_ov">
                                <div class="cl_icon">
                                    <iconify-icon icon="basil:invoice-outline"></iconify-icon>
                                </div>
                                <div class="ov_content">
                                    <h6>Invoices Number <span><iconify-icon icon="ph:info"></iconify-icon></span></h6>
                                    <h3>{{ @$totalInvoice }}</h3>
                                    <span class="tag_pre">(FY 2023-24)</span>
                                </div>
                            </div>
                            <div class="inner_ov no_br">
                                <div class="cl_icon">
                                    <iconify-icon icon="uiw:date"></iconify-icon>
                                </div>
                                <div class="ov_content">
                                    <h6>Invoice Due <span><iconify-icon icon="ph:info"></iconify-icon></span></h6>
                                    <h3>{{ @$dueInvoice }}</h3>
                                    <span class="tag_pre">(FY 2023-24)</span>
                                </div>
                            </div>
                        </div>
                        <div class="ov_card">
                            <div class="inner_ov">
                                <div class="cl_icon">
                                    <iconify-icon icon="majesticons:rupee-circle"></iconify-icon>
                                </div>
                                <div class="ov_content">
                                    <h6>Invoice Amount <span><iconify-icon icon="ph:info"></iconify-icon></span></h6>
                                    <h3>{{ @$saleInvoices[0]['unit'] }} {{ @$totalAmount }}</h3>
                                    <span class="tag_pre">(FY 2023-24)</span>
                                </div>
                            </div>
                            <div class="inner_ov no_br">
                                <div class="cl_icon">
                                    <iconify-icon icon="basil:invoice-outline"></iconify-icon>
                                </div>
                                <div class="ov_content">
                                    <h6>GST Amount <span><iconify-icon icon="ph:info"></iconify-icon></span></h6>
                                    <h3>{{ @$saleInvoices[0]['unit'] }} {{ @$totalGst }}</h3>
                                    <span class="tag_pre">(FY 2023-24)</span>
                                </div>
                            </div>
                        </div>
                        <div class="ov_card last_card_faq">
                            <div class="faq">
                                <a href="#"><iconify-icon icon="tabler:file-dollar"></iconify-icon> Delivery Challans</a>
                                <a href="#"><iconify-icon icon="tabler:file-dollar"></iconify-icon> Quotations & Estimates</a>
                                <a href="#"><iconify-icon icon="grommet-icons:tag"></iconify-icon> Proforma Invoices</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="comn_wrapper" class="home_tabs_table">
                <ul class="nav nav-tabs" id="myTab-1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active current_inv_tab" data-id="0" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Active Invoice</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link current_inv_tab" data-id="1" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Deleted Invoice</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent-2">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="table_card">
                            <div class="thead">
                                <div class="row justify-content-between">
                                    <div class="col-sm-6 col-md-6">
                                        <div id="user_list_datatable_info" class="dataTables_filter">
                                            <!-- <h2>Customer Management</h2> -->
                                            @if(@$has_edit_permission)
                                            <div class="show_check">
                                                <form action="{{url('/api/SaleInvoiceExport/Export', $enypt_id)}}" id="mulislectedCusExport" method="post">
                                            <div class="hiden_cust_export_val"></div>
                                            <button type="submit" class="export " data-url="{{url('/api/CustomerPdf')}}">Export Selected Invoice(s)</button>
                                        </form>
                                                <button class="delete selected_user_delete">Delete</button>
                                                <span class="selected_count">0 invoices Selected</span>
                                            </div>
                                            @endif
                                            <form class="mr-3 position-relative">
                                                <div class="form-group mb-0">
                                                    <input type="search" class="form-control" id="search_field_filter" placeholder="Search" aria-controls="user-list-table" />
                                                    <iconify-icon icon="carbon:search" onclick="applyfillter(this)"></iconify-icon>
                                                    <button type="button" class="btn btn-danger reset_bt hide-d" onclick="ResetDomainPage(this)">Reset</button>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="user-list-files d-flex">
                                            <a class="bg-primary showOffcanvasFilter" role="button" aria-controls="offcanvasFilter">
                                                <!-- <a class="bg-primary showOffcanvasFilter" data-bs-toggle="offcanvas" href="#offcanvasFilter" role="button" aria-controls="offcanvasFilter"> -->
                                                <iconify-icon icon="material-symbols:filter-alt-outline"></iconify-icon> Filter
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="page_listing">
                                <?php echo $response['content']; ?>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="current_inv_mode" value="" />
                </div>
            </div>
        </div>
    </div>
</div>
@section('modals')
@include('allFrontendViews.invoice.modals.add_payment_record_popup')
@include('allFrontendViews.invoice.filter')
@include('allFrontendViews.invoice.export')

@endsection
@endsection

@push('custom-scripts')
<script src="{{asset('unsync_assets/assets/js/app.js')}}"></script>
<script src="{{asset('unsync_assets/assets/js/main.js')}}"></script>


<script>
    $("body").on("click", "#checkAllCustomer", function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
        $(".selected_count").html($('.customerChkBox').filter(':checked').length + ' User Selected');
        if ($('.customerChkBox').filter(':checked').length > 0) {
            $(".show_check").addClass('show_option')
            $('.table_card .thead form.mr-3.position-relative').addClass("hide_search");
        } else {
            $(".show_check").removeClass('show_option')
            $('.table_card .thead form.mr-3.position-relative').removeClass("hide_search");
        }
        var index = 0;
        var exportHtml = [];
        $('input[name="customerChkBox"]:checked').each(function() {
            if ($(this).val() != '') {
                exportHtml += ' <input type="hidden" class="hidden_exported_id" name="id[' + index + ']" value="' + $(this).val() + '" />';
                index++;
            }
        });
        $(".hiden_cust_export_val").empty().append(exportHtml);
    });
</script>


<script>
    $(document).on("click", "[data-toggle=popover]", function(e) {
        initializePopovers();
        e.stopPropagation();
        togglePopover($(this));
    });

    function initializePopovers() {
        $("[data-toggle=popover]").popover({
            html: true,
            trigger: 'manual',
            placement: 'left',
            content: function() {
                var content = $(this).attr("data-popover-content");
                return $(content).children(".popover-body").html();
            }
        })
    }
    $(document).on("click", function() {
        hideAllPopovers();
    });
    $(document).on("click", ".btn", function() {
        hideAllPopovers();
    });
    // Function to toggle popover
    function togglePopover(popover) {
        var isOpen = popover.attr("aria-describedby") !== undefined && popover.attr("aria-describedby") !== null;
        hideAllPopovers();
        if (!isOpen) {
            popover.popover("show");
        }
    }

    // Function to hide all popovers
    function hideAllPopovers() {
        $("[data-toggle=popover]").each(function() {
            $(this).popover('hide');
        });
    }
</script>
<script>
    $(document).ready(function() {
        initializePopovers();
    });
</script>

<script>
    var enyptID = "<?= $enypt_id; ?>";
    let suggestions = <?= json_encode($commonData['allProducts']); ?>;
    var ExportExcelURL = APP_URL + "/api/SaleInvoiceExport /" + enyptID+'?guard=WEB&platform=Unesync';
    var ExportPdfURL = APP_URL + "/api/SaleInvoicepdf/" + enyptID+'?guard=WEB&platform=Unesync';
</script>


<script src="{{asset('js/custom/main_invoice.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush