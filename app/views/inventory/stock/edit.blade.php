@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
      <li><a href="{{{URL::route('item.index')}}}">{{ Lang::choice('messages.item', 2) }}</a></li>
      <li><a href="{{{URL::route('stocks.log',array($stock->item->id))}}}">{{ Lang::choice('messages.stock', 2) }}</a></li>
	  <li class="active">{{ trans('messages.edit').' '.Lang::choice('messages.stock', 1) }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
@if($errors->all())
    <div class="alert alert-danger">
        {{ HTML::ul($errors->all()) }}
    </div>
@endif
<div class="panel panel-primary"
@if(!Entrust::hasRole(Role::getAdminRole()->name))
    {{' style="display:none;"'}}
@endif
>
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-shopping-cart"></span>
		{{ trans('messages.edit') }} {{ Lang::choice('messages.stock',2) }}
	</div>
	<div class="panel-body">
		   {{ Form::model($stock, array('route' => array('stock.update', $stock->id), 'method' => 'PUT',
               'id' => 'form-edit-stocks')) }}
            {{ Form::hidden('item_id', $stock->item->id) }}
            <div class="form-group">
                {{ Form::label('lot-no', trans('messages.lot-no')) }}
                {{ Form::text('lot', Input::old('lot'), array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('batch-no', trans('messages.batch-no')) }}
                {{ Form::text('batch_no', Input::old('batch_no'), array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('manufacturer', trans('messages.manufacturer')) }}
                {{ Form::text('manufacturer', Input::old('manufacturer'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('supplier', Lang::choice('messages.supplier', 1)) }}
                {{ Form::select('supplier_id', $suppliers, Input::old('supplier') ? Input::old('supplier') : $supplier, array('class' => 'form-control')) }}
            </div>
            <div class="form-group">
                {{ Form::label('supplied', trans('messages.supplied')) }}
                {{ Form::number('quantity_supplied', Input::old('quantity_supplied'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('cost-per-unit', trans('messages.cost-per-unit')) }}
                {{ Form::number('cost_per_unit', Input::old('cost_per_unit'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('expiry', trans('messages.expiry')) }}
                {{ Form::text('expiry_date', Input::old('expiry_date'), 
                        array('class' => 'form-control standard-datepicker')) }}
            </div>
            <div class="form-group">
                {{ Form::label('date-received', trans('messages.date-received')) }}
                {{ Form::text('date_of_reception', Input::old('date_of_reception'), 
                        array('class' => 'form-control standard-datepicker')) }}
            </div>
            <div class="form-group">
                {{ Form::label('remarks', trans('messages.remarks')) }}
                {{ Form::textarea('remarks', Input::old('remarks'), array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group actions-row">
                    {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
                        array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
            </div>
        {{ Form::close() }}
	</div>
	
</div>
@stop