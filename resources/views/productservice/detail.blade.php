<div class="modal-body">
    <div class="card ">
        <div class="card-body table-border-style full-card">
        <div class="table-responsive">
                <table class="table">
                    <tbody>
                        @if(!empty($productServices))
                            <tr>
                                <td>Image </td>
                                <td>{{ !empty($productServices->pro_image) ? $productServices->pro_image : ''}}</td>
                            </tr>
                            <tr>
                                <td>Code </td>
                                <td>{{ !empty($productServices->sku) ? $productServices->sku : ''}}</td>
                            </tr>
                            <tr>
                                <td>Product</td>
                                <td>{{ !empty($productServices->name) ? $productServices->name : ''}}</td>
                            </tr>
                            <tr>
                                <td>Category</td>
                                <td>{{ !empty($productServices->category->name) ? $productServices->category->name : ''}}</td>
                            </tr>
                            <tr>
                                <td>Brand</td>
                                <td>{{ !empty($productServices->brand->name) ? $productServices->brand->name : ''}}</td>
                            </tr>
                            <tr>
                                <td>Cost</td>
                                <td>{{ !empty($productServices->purchase_price) ? $productServices->purchase_price : ''}}</td>
                            </tr>
                            <tr>
                                <td>Price</td>
                                <td>{{ !empty($productServices->sale_price) ? $productServices->sale_price : ''}}</td>
                            </tr>
                            <tr>
                                <td>Unit</td>
                                <td>{{ !empty($productServices->unit_id) ? $productServices->unit_id : ''}}</td>
                            </tr>
                            
                             <tr>
                                <td>Stock Alert</td>
                                <td>{{ !empty($productServices->stock_alert) ? $productServices->stock_alert : ''}}</td>
                            </tr>
                        @endif
                    </tbody>
                </table> <hr/><br/>
            <!-- ...ware house -->
                <table class="table">
                    <thead>
                    <tr>
                        <th>{{__('Warehouse') }}</th>
                        <th>{{__('Quantity')}}</th>

                    </tr>
                    </thead>
                     <tbody>

                    @foreach ($products as $product)
                        @if(!empty($product['warehouse']))
                            <tr>
                                <td>{{ @$product['warehouse'] }}</td>
                                <td>{{ @$product['quantity'] }}</td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                {{--                    @else--}}
                {{--                        <div class="mt-2 text-center">--}}
                {{--                            No Warehouse Found!--}}
                {{--                        </div>--}}
                {{--                    @endif--}}
            </div>
        </div>
    </div>
</div>
