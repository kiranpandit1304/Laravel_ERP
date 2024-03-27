{{ Form::model($expense, array('route' => array('expense.update', $expense->id), 'method' => 'PUT')) }}
<div class="modal-body">
<div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('warehouse_id', __('Warehouse'),['class'=>'form-label']) }}
            {{ Form::select('warehouse_id', $warehouse,null, array('class' => 'form-control select warehouse_d','required'=>'required')) }}
          </div>
        <div class="form-group col-md-6">
            {{ Form::label('expense_category_id', __('Expense Category'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::select('expense_category_id', $expenseCategory, null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('date', __('Date'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::date('date',null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('title', __('Title'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::text('title',null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('amount', __('Amount'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::text('amount',null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('payment_status', __('Payment Status'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {!! Form::select('payment_status', $pstatus= array(""=>"Select Type","unpaid"=>"Unpaid","paid" => "Paid"),null,  ['class' => 'form-control pstatus', 'required'=>'required']) !!}
        </div>
        @php
        $hide = $expense->payment_status && $expense->payment_status == 'unpaid' ? 'hide-d' : '';
        @endphp
        <div class="form-group col-md-6 paymen_div {{$hide}}">
            {{ Form::label('payment_type', __('Payment Type'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {!! Form::select('payment_type', $ptype= array(""=>"Select Type","cash"=>"Cash","check" => "Check"),null,  ['class' => 'form-control ptype']) !!}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('details', __('Detail'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::textarea('details', null, ['class'=>'form-control','rows'=>'3','placeholder'=>__('Description')]) }}</div>
        </div>
    </div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Save')}}" class="btn  btn-primary">
</div>
{{Form::close()}}
