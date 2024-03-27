{{ Form::open(array('url' => 'warehouse')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('name', __('Name'),['class'=>'form-label']) }}
            {{ Form::text('name', '', array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('email', __('Email'),['class'=>'form-label']) }}
            {{ Form::email('email', '', array('class' => 'form-control')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('phone', __('Phone'),['class'=>'form-label']) }}
            {{ Form::number('phone', '', array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('city_zip',__('Pin Code'),array('class'=>'form-label')) }}
            {{Form::text('city_zip',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('latitude', __('Latitude'),['class'=>'form-label']) }}
            {{ Form::text('latitude', '', array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('longitude', __('Longitude'),['class'=>'form-label']) }}
            {{ Form::text('longitude', '', array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group col-md-12">
            {{Form::label('address',__('Address'),array('class'=>'form-label')) }}
            {{Form::textarea('address',null,array('class'=>'form-control','rows'=>3))}}
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                {{ Form::label('country', __('Country'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                {!! Form::select('country', $countries, null,array('class' => 'form-control ucountry','required'=>'required')) !!}
            </div>
        </div>
        
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                {{ Form::label('state', __('State'),['class'=>'form-label ']) }}<span class="text-danger">*</span>
                {!! Form::select('state', [], null,array('class' => 'form-control ustate','required'=>'required')) !!}
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                {{ Form::label('city', __('City'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                {!! Form::select('city', [], null,array('class' => 'form-control ucities','required'=>'required')) !!}
            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{ Form::close() }}
