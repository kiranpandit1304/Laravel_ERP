{{ Form::model($expenseCategory, array('route' => array('expense-category.update', $expenseCategory->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
    <div class="form-group col-md-12">
            {{ Form::label('name', __('Name'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::text('name',$expenseCategory->name, array('class' => 'form-control','required'=>'required')) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Save')}}" class="btn  btn-primary">
</div>
{{Form::close()}}
