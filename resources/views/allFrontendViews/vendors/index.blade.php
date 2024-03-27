@extends('allFrontendViews.layouts.app')
@section('page-title')
{{__('Vendors')}}
@endsection
@push('css-page')
<link href="{{asset('/assets/js/plugins/dropzone/css/dropzone.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        @if(!empty($venders) && $venders->count() > 0)
        <div class="col-lg-12 flush">
            <div class="page_head">
                <div class="actions_bar">
                    <div class="filter_main">
                        <span class="bg_yellow squre_icon"><iconify-icon icon="tabler:brand-abstract"></iconify-icon></span>
                        <select class="js-states form-control nosearch customer_top_dropdown " onchange="applyfillter(this)" id="list9" name="list">
                            <option value="">All Vendors ( {{ $totalCust }})</option>
                            <option value="yes">GST Vendors ( {{ !empty($totalGstCust) ? $totalGstCust: 0 }} )</option>
                            <option value="no">Non GST Vendors ({{ !empty($totalNonGstCust) ? $totalNonGstCust: 0 }})</option>
                        </select>
                    </div>
                    <div class="action_btns">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                            </button>
                            <ul class="dropdown-menu">
                                @if(@$has_edit_permission)
                                <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#importPopup"><iconify-icon icon="pajamas:import"></iconify-icon> Import Item</a></li>
                                @endif
                                <li><a class="dropdown-item all_export" href="#" data-toggle="modal" data-target="#exportPopup"><iconify-icon icon="pajamas:export"></iconify-icon> Export Item</a></li>
                            </ul>
                        </div>
                        <!-- <button class="subcta" type="button" data-toggle="modal" data-target="#importPopup"><iconify-icon icon="pajamas:import"></iconify-icon> Import Vendors</button>
                        <button class="subcta all_export" type="button"><iconify-icon icon="pajamas:export"></iconify-icon> Export Vendors</button> -->
                        @if(@$has_edit_permission)
                        <button class="opencreatecustomer" type="button" id="opencreatecustomer"><iconify-icon icon="pajamas:plus"></iconify-icon> Create Vendors</button>
                        @endif
                    </div>
                </div>
            </div>
            <div id="comn_wrapper">
                <div class="table_card">
                    <div class="thead">
                        <div class="row justify-content-between">
                            <div class="col-sm-4 col-md-4">
                                <div id="user_list_datatable_info" class="dataTables_filter">
                                    @if(@$has_edit_permission)
                                    <div class="show_check">
                                        <form action="{{url('/api/SelectedVender/Export', $enypt_id)}}" id="mulislectedCusExport" method="post">
                                            <div class="hiden_cust_export_val"></div>
                                            <button type="submit" class="export " data-url="{{url('/api/VenderPdf')}}">Export Selected Customer(s)</button>
                                        </form>
                                        <button class="delete selected_user_delete">Delete</button>
                                        <span class="selected_count">0 Vendor Selected</span>
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
                            <div class="col-sm-8 col-md-8">
                                <div class="user-list-files d-flex">
                                    <a class="bg-primary" data-bs-toggle="offcanvas" href="#offcanvasFilter" role="button" aria-controls="offcanvasFilter"> <iconify-icon icon="material-symbols:filter-alt-outline"></iconify-icon> Filter </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="page_listing">
                        <?php echo $response['content']; ?>
                    </div>
                </div>
            </div>
        </div>
        @else
        @if(@$has_edit_permission)
        @include('allFrontendViews.vendors.empty_view')
        @endif
        @endif
    </div>
</div>
@section('modals')
@include('allFrontendViews.vendors.edit')
@include('allFrontendViews.vendors.filter')
@include('allFrontendViews.vendors.create')
@include('allFrontendViews.vendors.import')
@include('allFrontendViews.vendors.export')
@endsection
@endsection


@push('custom-scripts')
<!-- File Upload Create Customer -->
<script src="https://unpkg.com/react@latest/umd/react.development.js"></script>
<script src="https://unpkg.com/react-dom@latest/umd/react-dom.development.js"></script>
<script src="https://unpkg.com/prop-types/prop-types.js"></script>
<script src="https://unpkg.com/react-quill@latest/dist/react-quill.js"></script>
<script src="{{asset('unsync_assets/assets/js/jquery.ui.widget.js')}}"></script>
<script src="{{asset('unsync_assets/assets/js/jquery.fileupload.js')}}"></script>
<script src="{{asset('unsync_assets/assets/js/jquery.iframe-transport.js')}}"></script>
<!-- <script src="{{asset('unsync_assets/assets/js/jquery.fancy-fileupload.js')}}"></script> -->
<script type="text/javascript" src="{{asset('/assets/js/plugins/dropzone/dropzone.min.js')}}"></script>
<script>
    var state_list = <?= json_encode($stateList) ?>;
    var has_edit_permission = <?= json_encode($has_edit_permission) ?>;
    var AddCustomerURL = APP_URL + "/api/VenderAdd";
    var UpdatCustomereURL = APP_URL + "/api/VenderUpdate";
    var CustomerShowURL = APP_URL + "/api/VenderShow";
    var CustomerEdit = APP_URL + "/api/VenderEdit";
    var DeleteCustomerURL = APP_URL + "/api/VenderDelete";
    var AddMediaURL = APP_URL + "/api/VenderAddMedia";
    var DeleteMediaURL = APP_URL + "/api/VenderMediadelete";
    var ExportExcelURL = APP_URL + "/api/VenderExport/"  + enyptID+'?guard=WEB&platform=Unesync';
    var ExportPdfURL = APP_URL + "/api/VenderPdf/"  + enyptID+'?guard=WEB&platform=Unesync';
    var CustomerImportURL = APP_URL + "/api/VenderImport";
    var CustomerMultipleDeleteURL = APP_URL + "/api/VenderMuilipleDelete";
</script>


<script src="{{asset('js/custom/customer.js')}}"></script>
@endpush