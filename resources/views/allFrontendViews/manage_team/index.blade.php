@extends('allFrontendViews.layouts.app')
@section('page-title')
{{__('Manage Team')}}
@endsection
@push('css-page')
@endpush
@section('content')
<div class="container-fluid">
    @if(!empty($invitees))
    <div class="row">
        <div class="col-lg-12 flush">
            <div class="page_head">
                <div class="actions_bar">
                    <div class="filter_main">
                        <span class="bg_red squre_icon"><iconify-icon icon="fluent:people-team-16-regular"></iconify-icon></span>
                        <select class="js-states form-control nosearch top_bar_filter" onchange="applyfillter(this)" id="list9" name="list">
                            <option value="">Status (All)</option>
                            <option value="Accepted">Status (Accepted)</option>
                            <option value="Pending">Status (Pending)</option>
                        </select>
                    </div>
                    <div class="action_btns">
                        <button type="button" id="opencibsp"><iconify-icon icon="pajamas:plus"></iconify-icon> Create Team Member</button>
                    </div>
                </div>
            </div>
            <div id="comn_wrapper">
                <div class="table_card">
                    <div class="thead">
                        <div class="row justify-content-between">
                            <div class="col-sm-4 col-md-4">
                                <div id="user_list_datatable_info" class="dataTables_filter">
                                    <div class="show_check">
                                        <form action="{{url('/api/sendInviteExport', $enypt_id)}}" id="mulislectedCusExport" method="post">
                                            <div class="hiden_cust_export_val"></div>
                                            <button type="submit" class="export " data-url="{{url('/api/sendInviteExport')}}">Export Selected Customer(s)</button>
                                        </form>

                                        <button class="delete selected_user_delete">Delete</button>
                                        <span class="selected_count">0 Customer Selected</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 col-md-8">
                                <!-- <div class="user-list-files d-flex">
                                                    <a class="bg-primary" data-bs-toggle="offcanvas" href="#offcanvasFilter" role="button" aria-controls="offcanvasFilter"> <iconify-icon icon="material-symbols:filter-alt-outline"></iconify-icon> Filter </a>
                                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div id="page_listing">
                        <?php echo $response['content']; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @else
    @include('allFrontendViews.manage_team.empty_team')
    @endif
</div>
@endsection
@include('allFrontendViews.manage_team.edit')
@include('allFrontendViews.manage_team.create')
@include('allFrontendViews.manage_team.view')
@push('custom-scripts')
<script>
      var modules = <?= json_encode($modules) ?>;
</script>
<script src="{{asset('js/custom/team.js')}}"></script>
<script>
    // Full Screen Popup Open
    $("button#opencibsp, a#opencibsp").click(function(e) {
        $('#createItem').addClass('active');
        $('body').toggleClass('ov_hidden');
    });
    $("a.close_cibsp").click(function(e) {
        $('#createItem').removeClass('active');
        resetcreateFormFields();
    });
    // Full Screen Popup Open Create Item Group
    $("#opencibsp_group").click(function(e) {
        $('#createItemgroup').addClass('active');
        $('body').toggleClass('ov_hidden');
    });
    $("a.close_edit_cibsp").click(function(e) {
        $('#editItem').removeClass('active');
    });


    
</script>
@endpush