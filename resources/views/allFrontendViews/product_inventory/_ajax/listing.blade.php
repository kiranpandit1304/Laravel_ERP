<div class="table_upper_wrapper">
    <div class="add_field_drop">
        <a href="#" class="search-toggle dropdown-toggle circle-hover" id="dropdownMenuButton01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <iconify-icon icon="pajamas:plus"></iconify-icon>
        </a>
        <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton01">
            <div class="card shadow-none m-0">
                <div class="card-body p-0">
                    <div class="p-3">
                        <a href="#" class="iq-sub-card pt-0">
                            <div class="sd_check">
                                <input type="checkbox" class="tabel_col_sorting" value="item_col" name="layout" id="showshipping" checked />
                                <label class="pull-right text" for="showshipping">Item</label>
                            </div>
                        </a>
                        <a href="#" class="iq-sub-card pt-0">
                            <div class="sd_check">
                                <input type="checkbox" class="tabel_col_sorting" value="sku_col" name="layout" id="showshipping1" checked />
                                <label class="pull-right text" for="showshipping1">SKU</label>
                            </div>
                        </a>
                        <a href="#" class="iq-sub-card pt-0">
                            <div class="sd_check">
                                <input type="checkbox" class="tabel_col_sorting" value="hsn_col" name="layout" id="showshipping2" checked />
                                <label class="pull-right text" for="showshipping2">HSN/SAC</label>
                            </div>
                        </a>
                        <a href="#" class="iq-sub-card pt-0">
                            <div class="sd_check">
                                <input type="checkbox" class="tabel_col_sorting" value="buying_col" name="layout" id="showshipping3" checked />
                                <label class="pull-right text" for="showshipping3">Buying Price</label>
                            </div>
                        </a>
                        <a href="#" class="iq-sub-card pt-0">
                            <div class="sd_check">
                                <input type="checkbox" class="tabel_col_sorting" value="selling_col" name="layout" id="showshipping4" checked />
                                <label class="pull-right text" for="showshipping4">Selling Price</label>
                            </div>
                        </a>
                        <a href="#" class="iq-sub-card pt-0">
                            <div class="sd_check">
                                <input type="checkbox" class="tabel_col_sorting" value="tax_col" name="layout" id="showshipping5" checked />
                                <label class="pull-right text" for="showshipping5">Tax Rate(in %)</label>
                            </div>
                        </a>
                        <a href="#" class="iq-sub-card pt-0">
                            <div class="sd_check">
                                <input type="checkbox" class="tabel_col_sorting" value="manage_stock_col" name="manage_stock_col" id="showshipping6" checked />
                                <label class="pull-right text" for="showshipping6">Manage Stock</label>
                            </div>
                        </a>
                        <a href="#" class="iq-sub-card pt-0">
                            <div class="sd_check">
                                <input type="checkbox" class="tabel_col_sorting" value="stock_col" name="stock_col" id="showshipping7" />
                                <label class="pull-right text" for="showshipping7">Current Stock</label>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table id="user-list-table" class="table" role="grid" aria-describedby="user-list-page-info">
            <thead>
                <tr>
                    <th scope="col" style="width: 1%;" class="fixed-side"></th>
                    <th scope="col" style="width: 4%;" class="fixed-side">
                        <div class="sd_check">
                            <input type="checkbox" class="checkAllproduct" name="checkAllproduct" id="checkAllproduct" />
                            <label class="pull-right text" for="checkAllproduct"></label>
                        </div>
                    </th>
                    <th class="item_col" scope="col" style="width: 10%;">Item</th>
                    <th class="sku_col" scope="col" style="width: 10%;">SKU</th>
                    <th class="hsn_col" scope="col" style="width: 7%;">HSN/SAC</th>
                    <th class="buying_col" scope="col" style="width: 7%;">Buying Price</th>
                    <th class="selling_col" scope="col" style="width: 7%;">Selling Price</th>
                    <th class="tax_col" scope="col" style="width: 7%;">Tax Rate(in %)</th>
                    <th class="stock_col " scope="col" style="width: 7%;">Current Stock</th>
                    @if(@$has_edit_permission)
                    <th class="manage_stock_col " scope="col" style="width: 7%;">Manage Stock</th>
                    @endif
                    <th scope="col" style="width: 8%; text-align: right; padding-right: 3%;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($newproducts))
                @foreach($newproducts as $key=>$product)
                @php
                if($product->is_group !=1){
                    $productVariation = \App\Models\AdjustmentItem::where('adjustment_items.product_id', $product->id);
                    $productVariation->leftjoin('product_variation', 'adjustment_items.variation_id', 'product_variation.id');
                    $productVariation->leftjoin('base_unit', 'product_variation.unit_id', 'base_unit.id');
                    $productVariation->select('product_variation.*', 'adjustment_items.quantity as current_stock','adjustment_items.stock_alert', 'base_unit.name as unitName');
                   if($inventory_topbar_filter==1){
                     $productVariation->where('adjustment_items.quantity', '<=', 'adjustment_items.stock_alert');
                     $productVariation->groupby('adjustment_items.id');
                    }else if($inventory_topbar_filter==2){
                     $productVariation->where("adjustment_items.quantity", '=', '0');
                    }
                    $productVariation->orderBY('product_variation.id', 'ASC');
                    $productVariation = $productVariation->get();
                }else{
                    $productVariation = \App\Models\ProductVariation::where('product_variation.product_id', $product->id);
                    $productVariation = $productVariation->get(); 
                }
                @endphp
                <tr>
                    @if(!empty($productVariation) && count($productVariation) >1 && $product->is_group !=1)
                    <td>
                        <button class="innerTable collapsed" data-toggle="collapse" data-target="#demo{{@$product->id}}" class="accordion-toggle">
                            &nbsp;
                        </button>
                    </td>
                    @else
                    <td class="fixed-side">
                    </td>
                    @endif
                    <td class="fixed-side">
                        <div class="sd_check">
                            <input type="checkbox" class="customerChkBox" name="customerChkBox" data-id="<?= $key ?>" value="{{$product->id}}" id="tbin{{$key}}" />
                            <label class="pull-right text" for="tbin{{$key}}"></label>
                        </div>
                    </td>
                    @if(!empty($productVariation) && count($productVariation) >1 && $product->is_group !=1)
                    <td class="item_col offcanvasItemEditBtn" data-id="{{@$product->id}}" data-type="{{$product->is_group ==1 ? 'group_item' : ''}}" data-bs-toggle="offcanvas">
                        {{@$product->name}}
                        @if($product->is_group ==1)
                        <iconify-icon icon="system-uicons:cubes" class="big_i"></iconify-icon>
                        @endif
                    </td>
                    <td class="sku_col offcanvasItemEditBtn" data-id="{{@$product->id}}" data-bs-toggle="offcanvas">-</td>
                    <td class="hsn_col offcanvasItemEditBtn" data-id="{{@$product->id}}" data-bs-toggle="offcanvas">-</td>
                    <td class="buying_col offcanvasItemEditBtn" data-id="{{@$product->id}}" data-bs-toggle="offcanvas">{{@$productVariation->min('purchase_price')}} - {{@$productVariation->max('purchase_price')}}</td>
                    <td class="selling_col offcanvasItemEditBtn" data-id="{{@$product->id}}" data-bs-toggle="offcanvas">{{@$productVariation->min('sale_price')}} - {{@$productVariation->max('sale_price')}}</td>
                    <td class="tax_col offcanvasItemEditBtn" data-id="{{@$product->id}}" data-bs-toggle="offcanvas">- </td>
                    <td class="stock_col " data-bs-toggle="offcanvas"></td>
                    @else
                    <td class="item_col offcanvasItemEditBtn" data-id="{{@$product->id}}" data-type="{{$product->is_group ==1 ? 'group_item' : ''}}" data-bs-toggle="offcanvas">
                        {{@$product->name}}
                        @if($product->is_group ==1)
                        <iconify-icon icon="system-uicons:cubes" class="big_i"></iconify-icon>
                        @endif
                        @if($productVariation[0]->current_stock <= $productVariation[0]->stock_alert && $product->is_group !=1)
                            <span class="stock_alert" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Stock Alert"><iconify-icon icon="ion:alert-outline"></iconify-icon></span>
                            @endif
                    </td>
                    <td class="sku_col offcanvasItemEditBtn" data-id="{{@$product->id}}" data-type="{{$product->is_group ==1 ? 'group_item' : ''}}" data-bs-toggle="offcanvas">{{@$productVariation[0]->sku}}</td>
                    <td class="hsn_col offcanvasItemEditBtn" data-id="{{@$product->id}}" data-type="{{$product->is_group ==1 ? 'group_item' : ''}}" data-bs-toggle="offcanvas">{{@$productVariation[0]->hsn}}</td>
                    <td class="buying_col offcanvasItemEditBtn" data-id="{{@$product->id}}" data-type="{{$product->is_group ==1 ? 'group_item' : ''}}" data-bs-toggle="offcanvas">{{@$productVariation[0]->purchase_price}}</td>
                    <td class="selling_col offcanvasItemEditBtn" data-id="{{@$product->id}}" data-type="{{$product->is_group ==1 ? 'group_item' : ''}}" data-bs-toggle="offcanvas">{{@$productVariation[0]->sale_price}}</td>
                    <td class="tax_col offcanvasItemEditBtn" data-id="{{@$product->id}}" data-type="{{$product->is_group ==1 ? 'group_item' : ''}}" data-bs-toggle="offcanvas">{{@$productVariation[0]->tax_rate}}</td>
                    @if($product->is_group !=1)
                       <td class="stock_col" data-bs-toggle="offcanvas">{{!empty($productVariation[0]->current_stock) ? $productVariation[0]->current_stock : '-'}} </td>
                    @else
                       <td class="stock_col" data-bs-toggle="offcanvas">{{!empty($product->group_stock) ? $product->group_stock : '-'}} </td>
                    @endif
                    @endif
                    @if(@$has_edit_permission)
                    <td>
                        <label class="switch ">
                            <input class="update_stock_status" type="checkbox" data-id="{{@$product->id}}" id="is_manage_stock_d_{{@$product->id}}" value="1" {{@$product->is_manage_stock ==1 ? 'checked' : ''}}>
                            <span class="slider"></span>
                        </label>
                    </td>
                    @endif
                    <td>
                        <div class="action_btn_a">
                            @if(@$has_edit_permission)
                            <a href="javascript:void(0)" class="edit_cta adjustStock_btn" data-id="{{@$product->id}}" data-type="{{$product->is_group ==1 ? 'group_item' : ''}}"  data-name="{{@$product->name}}"><iconify-icon icon="material-symbols:edit"></iconify-icon> Adjust Stock</a>
                            @endif
                            <a href="javascript:void(0)" class="edit_cta blu_icon offcanvasItemEditBtn"  data-id="{{@$product->id}}" data-type="{{$product->is_group ==1 ? 'group_item' : ''}}" data-toggle="tooltip" data-placement="top" data-original-title="Edit">
                                <iconify-icon icon="ic:outline-remove-red-eye"></iconify-icon> View
                            </a>
                            @if(@$has_edit_permission)
                            <a href="javascript:void(0)" id="customdropdown1" data-id="{{@$product->id}}">
                                <span class="dropdown-toggle">
                                    <i class="ri-more-2-fill"></i>
                                </span>
                            </a>
                            @endif
                        </div>
                    </td>
                    <div class="customdropdown customdropdown2">
                        <div class="customdropdown-menu customdropdown-menu-right" style="">
                            <a href="javascript:void(0)" class="dropdown-item edit_cta offcanvasItemEditBtn" data-type="{{$product->is_group ==1 ? 'group_item' : ''}}" data-toggle="button" data-placement="top" data-original-title="Edit"><iconify-icon icon="material-symbols:edit"></iconify-icon> Edit item</a>
                            @if($product->is_group !=1)
                            <a href="javascript:void(0)" class="dropdown-item duplicate_item"><iconify-icon icon="humbleicons:duplicate"></iconify-icon> Duplicate item</a>
                            @endif
                            <a class="dropdown-item delete_product" href="javascript:void(0)" style="color: brown;"><iconify-icon icon="mingcute:delete-2-fill"></iconify-icon> Delete item</a>
                        </div>
                    </div>
                </tr>
                <tr>
                    <td colspan="12" class="hiddenRow">
                        <div class="accordian-body collapse" id="demo{{@$product->id}}">
                            <table class="table">
                                <thead class="hide">
                                    <tr>
                                        <th scope="col" style="width: 1%;" class="fixed-side"></th>
                                        <th scope="col" style="width: 4%;" class="fixed-side"></th>
                                        <th class="item_col" scope="col" style="width: 10%;"></th>
                                        <th class="sku_col" scope="col" style="width: 10%;"></th>
                                        <th class="hsn_col" scope="col" style="width: 7%;"></th>
                                        <th class="buying_col" scope="col" style="width: 7%;"></th>
                                        <th class="selling_col" scope="col" style="width: 7%;"></th>
                                        <th class="tax_col" scope="col" style="width: 7%;"></th>
                                        <th class="stock_col " scope="col" style="width: 7%;"></th>
                                        <th class="manage_stock_col " scope="col" style="width: 7%;"></th>
                                        <th scope="col" style="width: 8%; text-align: right; padding-right: 3%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($productVariation))
                                    @foreach($productVariation as $key=>$variation)
                                    <tr>
                                        <td scope="col" style="width: 3.5%;"></td>
                                        <td scope="col" style="width: 5%;"></td>
                                        @if($key == 0)
                                        <td scope="col" style="width: 10%;">
                                            {{@$product->name}} {{@$variation->variation_name}}

                                            @if($variation->current_stock <= $variation->stock_alert)
                                                <span class="stock_alert" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Stock Alert"><iconify-icon icon="ion:alert-outline"></iconify-icon></span>
                                                @endif
                                        </td>
                                        @else
                                        <td scope="col" style="width: 13.6%;">
                                            {{@$variation->variation_name}}
                                            @if($variation->current_stock <= $variation->stock_alert)
                                                <span class="stock_alert" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Stock Alert"><iconify-icon icon="ion:alert-outline"></iconify-icon></span>
                                                @endif
                                        </td>
                                        @endif
                                        <td scope="col" style="width: 9.5%;">{{@$variation->sku}}</td>
                                        <td scope="col" style="width: 9.5%;">{{@$variation->hsn}}</td>
                                        <td scope="col" style="width: 9.5%;">{{@$variation->purchase_price}}</td>
                                        <td scope="col" style="width: 9.5%;">{{@$variation->sale_price}}</td>
                                        <td scope="col" style="width: 9.5%;">{{@$variation->tax_rate}}</td>
                                        <td scope="col" class="stock_col" style="width: 9.5%;">{{!empty($variation->current_stock) ? $variation->current_stock : '-'}} </td>
                                        <td scope="col" class="stock_col" style="width: 15.6%;">&nbsp; </td>
                                        <td scope="col" class="stock_col" style="width: 15.6%;">&nbsp; </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@if($newproducts->hasPages())
<div class="tfooter">
    <div id="user-list-page-info" class="col-md-6">
        <span>Showing {{$newproducts->firstItem()}} to {{$newproducts->lastItem()}} of {{$newproducts->total()}} products</span>
    </div>
    <div class="col-md-6">
        <ul class="pagination product_pagination justify-content-end mb-0">
            {!! $newproducts->links( "pagination::bootstrap-4") !!}
        </ul>
    </div>
</div>
@endif