{{ Form::open(array('url' => 'productservice','enctype' => "multipart/form-data")) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('name', __('Name'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                <div class="form-icon-user">
                    {{ Form::text('name', '', array('class' => 'form-control','required'=>'required')) }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('sku', __('SKU'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                <div class="form-icon-user">
                    {{ Form::text('sku', '', array('class' => 'form-control','required'=>'required')) }}
                </div>
            </div>
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('description', __('Description'),['class'=>'form-label']) }}
            {!! Form::textarea('description', null, ['class'=>'form-control','rows'=>'2']) !!}
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('sale_price', __('Sale Price'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                <div class="form-icon-user">
                    {{ Form::number('sale_price', '', array('class' => 'form-control','required'=>'required','step'=>'0.01')) }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('purchase_price', __('Purchase Price'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                <div class="form-icon-user">
                    {{ Form::number('purchase_price', '', array('class' => 'form-control','required'=>'required','step'=>'0.01')) }}
                </div>
            </div>
        </div>

       
        <div class="form-group col-md-6">
            {{ Form::label('category_id', __('Category'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::select('category_id', $category,null, array('placeholder' => 'Please select...', 'class' => 'form-control select category_d','required'=>'required')) }}

            <div class=" text-xs">
                {{__('Please add constant category. ')}}<a href="{{route('product-category.index')}}"><b>{{__('Add Category')}}</b></a>
            </div>
        </div>
        <div class="form-group col-md-6 show_sub_div hide-d">
            {{ Form::label('category_id', __('Sub Category'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::select('category_id', [],null, array('placeholder' => 'Please select...', 'class' => 'form-control select show_sub_category')) }}

        </div>
        <div class="form-group col-md-6">
            {{ Form::label('brand_id', __('Brand'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::select('brand_id', $brands,null, array('class' => 'form-control select','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('base_unit_id', __('Base Unit'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::select('base_unit_id', $baseUnits,'', array('placeholder' => 'Please select...', 'class' => 'form-control select base_unit_d','required'=>'required')) }}
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('unit_id', __('Purchase Unit'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::select('unit_id', [],null, array('class' => 'form-control select show_sub_unit','required'=>'required')) }}
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('sale_unit_id', __('sale Unit'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::select('sale_unit_id', [],null, array('class' => 'form-control select show_sub_unit ','required'=>'required')) }}
        </div>
        <!-- <div class="form-group col-md-6">
            {{ Form::label('tax_id', __('Tax'),['class'=>'form-label']) }}
            {{ Form::select('tax_id[]', $tax,null, array('class' => 'form-control select2','id'=>'choices-multiple1','multiple')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('quantity', __('Quantity'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::text('quantity',null, array('class' => 'form-control')) }}
        </div> -->
        <div class="form-group col-md-6">
            {{ Form::label('stock_alert', __('Stock Alert'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::text('stock_alert',null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('quantity_limit', __('Quantity Limitation'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::text('quantity_limit',null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="btn-box">
                    <label class="d-block form-label">{{__('Type')}}</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="customRadio5" name="type" value="product" checked="checked" onclick="hide_show(this)">
                                <label class="custom-control-label form-label" for="customRadio5">{{__('Product')}}</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="customRadio6" name="type" value="service" onclick="hide_show(this)">
                                <label class="custom-control-label form-label" for="customRadio6">{{__('Service')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 form-group">
            {{Form::label('pro_image',__('Product Image'),['class'=>'form-label'])}}
            <div class="choose-file ">
                <label for="pro_image" class="form-label">
                    <input type="file" class="form-control" name="pro_image" id="pro_image" data-filename="pro_image_create">
                    <img id="image" class="mt-3" style="width:25%;"/>

                </label>
            </div>
        </div>


        @if(!$customFields->isEmpty())
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                    @include('customFields.formBuilder')
                </div>
            </div>
        @endif
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{Form::close()}}


<script>
    document.getElementById('pro_image').onchange = function () {
        var src = URL.createObjectURL(this.files[0])
        document.getElementById('image').src = src
    }
</script>
