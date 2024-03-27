{{ Form::model($unit, array('route' => array('product-unit.update', $unit->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('name', __('Unit Name'),['class'=>'form-label']) }}
            {{ Form::text('name', null, array('class' => 'form-control','required'=>'required')) }}
            @error('name')
            <small class="invalid-name" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('short_name', __('Short Name'),['class'=>'form-label']) }}
            {{ Form::text('short_name', $unit->short_name, array('class' => 'form-control','required'=>'required')) }}
            @error('short_name')
                <small class="invalid-name" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
        <div class="form-group  col-md-12">
            {{ Form::label('base_unit_id', __('Base Unit'),['class'=>'form-label']) }}
            {{ Form::select('base_unit_id',$baseUnits,null, array('class' => 'form-control select','required'=>'required')) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn btn-primary">
</div>
{{ Form::close() }}
