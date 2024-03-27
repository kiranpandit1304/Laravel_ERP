<div class="table-responsive">
    <table id="user-list-table" class="table" role="grid" aria-describedby="user-list-page-info">
        <thead>
            <tr>
                <th scope="col" style="width: 4%;">
                    <div class="sd_check">
                        <input type="checkbox" name="layout" id="checkAllbrand" />
                        <label class="pull-right text" for="checkAllbrand"></label>
                    </div>
                </th>
                <th scope="col">Brand Name</th>
                @if(@$has_edit_permission)
                <th scope="col">Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @if(!empty($Brands))
            @foreach($Brands as $key=>$brand)
            <tr>
                <td>
                    <div class="sd_check">
                        <input type="checkbox" name="layout" id="brd{{@$key}}" />
                        <label class="pull-right text" for="brd{{@$key}}"></label>
                    </div>
                </td>
                <td role="button" aria-controls="offcanvasExample">{{$brand->name}} </td>
                @if(@$has_edit_permission)
                <td>
                    <div class="action_btn_a">
                        <!-- <a href="#" class="edit_cta" type="button" data-toggle="modal" data-target="#editbrandPopup"><iconify-icon icon="material-symbols:edit"></iconify-icon> Edit</a> -->
                        <a href="#" class="edit_cta" onclick="getSinglebrand(this)" data-id="{{$brand->id}}" type="button"><iconify-icon icon="material-symbols:edit"></iconify-icon> Edit</a>
                        <a href="#" class="del_cta" onclick="trashBrand(this)" data-id="{{$brand->id}}" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><iconify-icon icon="mingcute:delete-2-line"></iconify-icon></a>
                    </div>
                </td>
                @endif
            </tr>
            @endforeach
            @endif

        </tbody>
    </table>
</div>
@if($Brands->hasPages())
<div class="tfooter">
    <div id="user-list-page-info" class="col-md-6">
        <span>Showing {{$Brands->firstItem()}} to {{$Brands->lastItem()}} of {{$Brands->total()}} Brands</span>
    </div>
    <div class="col-md-6">
        <ul class="pagination brand_pagination justify-content-end mb-0">
            {!! $Brands->links( "pagination::bootstrap-4") !!}
        </ul>
    </div>
</div>
@endif

@push('custom-scripts')

<script src="{{asset('js/custom/customer.js')}}"></script>
@endpush