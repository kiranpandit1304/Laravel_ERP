{{ Form::open(array('url' => 'charges-types')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('name', __('Name'),['class'=>'form-label']) }}
            {{ Form::text('name', '', array('class' => 'form-control','required'=>'required')) }}
            @error('name')
                <small class="invalid-name" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('Type', __('Slug'),['class'=>'form-label']) }}
           <select class="form-control" name="slug" >
            <option value="tax">Tax</option>
            <option value="shipping">Shipping </option>
           </select>
            @error('slug')
                <small class="invalid-name" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{ Form::close() }}
