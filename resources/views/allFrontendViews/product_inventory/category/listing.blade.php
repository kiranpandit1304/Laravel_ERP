<div class="table-responsive">
    <table id="user-list-table" class="table" role="grid" aria-describedby="user-list-page-info">
        <thead>
            <tr>
                <td style="width: 0.5%;"></td>
                <th scope="col" style="width: 4%;">
                    <div class="sd_check">
                        <input type="checkbox" name="layout" id="checkAllcategory" />
                        <label class="pull-right text" for="checkAllcategory"></label>
                    </div>
                </th>
                <th scope="col">Category Name</th>
                <th scope="col">Items</th>
                @if(@$has_edit_permission)
                <th scope="col">Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @if(!empty($categories))
            @foreach($categories as $category)
            <tr>
                @if (!empty($category->subcategories) && count($category->subcategories) > 0)
                <td>
                    <button class="innerTable" data-toggle="collapse" data-target="#demo{{$category->id}}" class="accordion-toggle">
                        &nbsp;
                    </button>
                </td>
                @else
                <td></td>
                @endif

                <td>
                    <div class="sd_check">
                        <input type="checkbox" name="layout" id="cc2{{@$category->id}}" />
                        <label class="pull-right text" for="cc2{{@$category->id}}"></label>
                    </div>
                </td>
                <td>{{$category->name}} </td>
                <td> <?= \App\Models\ProductService::where('category_id', $category->id)->count(); ?> </td>
                @if(@$has_edit_permission)
                <td>
                    <div class="action_btn_a">
                        <a href="#" class="edit_cta show_sub_cate_modal" type="button" data-id="{{$category->id}}">
                            Sub-Category</a>
                        <a href="#" class="edit_cta open_assignitems_btn" data-type="main_category" data-id="{{$category->id}}" data-toggle="tooltip" data-placement="top" data-original-title="Edit">
                            Assign Items</a>
                        <div class="dropdown">
                            <span class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-2-fill"></i>
                            </span>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton2" style="">
                                <a class="dropdown-item" onclick="getSingleCategory(this)" data-id="{{$category->id}}" href="#">Edit</a>
                                <a class="dropdown-item" href="#" onclick="trashCategory(this)" data-id="{{$category->id}}" style="color: brown;">Delete</a>
                            </div>
                        </div>
                    </div>
                </td>
                @endif
            </tr>
            @if ($category->subcategories)
            @foreach($category->subcategories as $children)
            <tr>
                <td colspan="12" class="hiddenRow">
                    <div class="accordian-body collapse" id="demo{{$category->id}}">
                        <table class="table">
                            <tr>
                                <td style="width: 7%;"></td>
                                <td style="width: 7%;">
                                    <div class="sd_check">
                                        <input type="checkbox" name="layout" id="cc2{{@$children->id}}" />
                                        <label class="pull-right text" for="cc2{{@$children->id}}"></label>
                                    </div>
                                </td>
                                <td>{{$children->name}} </td>
                                <td>0 Items</td>
                                @if(@$has_edit_permission)
                                <td>
                                    <div class="action_btn_a">
                                        <!-- <a href="#" class="edit_cta show_sub_cate_modal" type="button" data-id="{{$children->id}}">
                                            Sub-Category</a>
                                        <a href="#" class="edit_cta" data-toggle="tooltip" data-placement="top" data-original-title="Edit">
                                            Assign Items</a> -->
                                        <a href="#" class="edit_cta open_assignitems_btn" data-type="sub_category" data-id="{{$children->id}}" data-toggle="tooltip" data-placement="top" data-original-title="Edit">
                                            Assign Items</a>
                                        <div class="dropdown">
                                            <span class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-2-fill"></i>
                                            </span>
                                            @if(@$has_edit_permission)
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton2" style="">
                                                <a class="dropdown-item" onclick="getSingleCategory(this)" data-id="{{$children->id}}" href="#">Edit</a>
                                                <a class="dropdown-item" href="#" onclick="trashCategory(this)" data-id="{{$children->id}}" style="color: brown;">Delete</a>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>


                                @endif
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            @endforeach
            @endif
            @endforeach
            @endif
        </tbody>
    </table>
</div>
@if($categories->hasPages())
<div class="tfooter">
    <div id="user-list-page-info" class="col-md-6">
        <span>Showing {{$categories->firstItem()}} to {{$categories->lastItem()}} of {{$categories->total()}} categories</span>
    </div>
    <div class="col-md-6">
        <ul class="pagination category_pagination justify-content-end mb-0">
            {!! $categories->links( "pagination::bootstrap-4") !!}
        </ul>
    </div>
</div>
@endif

@push('custom-scripts')

<script src="{{asset('js/custom/customer.js')}}"></script>
@endpush