{{ Form::open(array('url' => 'product-category')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('name', __('Category Name'),['class'=>'form-label']) }}
            {{ Form::text('name', '', array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group col-md-12 "  >
        {{ Form::label('color', __('Type'),['class'=>'form-label']) }}
            <select  class="form-control is_parent" name="is_parent">
            <option value="0" selected >Parent</option>
            <option value="1">Sub category</option>
            </select>
        </div>
        <div class="form-group  col-md-12 parent_div hide-d"  >
            {{ Form::label('parent_id', __('Category'),['class'=>'form-label']) }}
            {{ Form::select('parent_id',$allCategories,null, array('class' => 'form-control select parent_categpry')) }}
        </div>
         <div class="form-group col-md-12">
            {{ Form::label('color', __('Category Color'),['class'=>'form-label']) }}
            {{ Form::text('color', '', array('class' => 'form-control jscolor','required'=>'required')) }}
            <small>{{__('For chart representation')}}</small>
        </div>
        <input type="hidden" name="type" value="0" />
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{ Form::close() }}
