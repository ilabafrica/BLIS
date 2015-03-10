@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{{URL::route('receipt.index')}}}">{{Lang::choice('messages.receipt',2)}}</a></li>
	  <li class="active">{{ trans('messages.edit-receipt-details') }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-edit"></span>
			{{trans('messages.edit-receipt-details')}}
		</div>
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
            {{ Form::model($receipt, array('route' => array('receipt.update', $receipt->id), 'method' => 'PUT', 'id' => 'form-edit-receipt')) }}
			<div class="form-group">
                {{ Form::label('commodity', trans('messages.commodity')) }}
                {{ Form::select('commodity', array(null => '')+ $commodities, 
                    $receipt->commodity_id, array('class' => 'form-control')) }}
            </div>
            <div class="form-group">
                {{ Form::label('supplier', trans('messages.received-from')) }}
                  {{ Form::select('supplier', array(null => '')+ $suppliers, $receipt->supplier_id,
                    array('class' => 'form-control', 'id' => 'received_from')) }}
            </div>
            <div class="form-group">
                {{ Form::label('doc_no', trans('messages.doc-no')) }}
                {{ Form::text('doc_no', Input::old('doc_no'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('quantity', trans('messages.quantity')) }}
                {{ Form::text('quantity', Input::old('quantity'), array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('batch_no', trans('messages.batch-no')) }}
                {{ Form::text('batch_no', Input::old('batch_no'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('expiry_date', Lang::choice('messages.expiry-date',1)) }}
                {{ Form::text('expiry_date', Input::old('expiry_date'), array('class' => 'form-control standard-datepicker')) }}
            </div>
            <div class="form-group">
                {{ Form::label('location ', trans('messages.location')) }}
                {{ Form::text('location', Input::old('location'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
				<div class="form-group actions-row">
					{{ Form::button('<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'),
						 array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
				</div>

			{{ Form::close() }}
		</div>
	</div>
@stop	