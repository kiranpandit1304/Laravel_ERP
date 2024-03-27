    {{ Form::model($category, array('route' => array('product-category.update', $category->id), 'method' => 'PUT')) }}
<div class="modal-body">

    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('name', __('Category Name'),['class'=>'form-label']) }}
            {{ Form::text('name', null, array('class' => 'form-control font-style','required'=>'required')) }}
        </div>
        <div class="form-group col-md-12 "  >
        {{ Form::label('color', __('Type'),['class'=>'form-label']) }}
            <select  class="form-control is_parent" name="is_parent">
            <option value="0"  {{$category->parent_id == 0 ? 'selected' : ''}} >Parent</option>
            <option value="1"  {{$category->parent_id != 0 ? 'selected' : ''}}  >Sub category</option>
            </select>
        </div>
        @php $hide = !$category->parent_id ? 'hide-d' : ''  @endphp
        <div class="form-group  col-md-12 parent_div  {{$hide}}"  >
            {{ Form::label('parent_id', __('Category'),['class'=>'form-label']) }}
            {{ Form::select('parent_id',$allCategories,null, array('class' => 'form-control select parent_categpry')) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('color', __('Category Color'),['class'=>'form-label']) }}
            {{ Form::text('color', null, array('class' => 'form-control jscolor','required'=>'required')) }}
            <p class="small">{{__('For chart representation')}}</p>
        </div>
        <input type="hidden" name="type" value="0" />

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>
{{ Form::close() }}
