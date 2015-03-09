@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{{URL::route('inventory.labStockCard')}}}">{{ trans('messages.inventory') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.labStockCardReceipts',2) }}</li>
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
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{trans('messages.labStockCard')}}
		{{trans('messages.labStockCardReceipts')}}
		
	</div>
	<div class="panel-body">
		   {{ Form::open(array('url' => 'inventory/store_receipts', 'id' => 'form-receipts')) }}
           <div class="form-group">
                {{ Form::label('Receipt Date', Lang::choice('messages.lab-receipt-date',1)) }}
                {{ Form::text('lab-receipt-date', Input::old('lab-receipt-date'), array('class' => 'form-control standard-datepicker')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Commodity', trans('messages.commodity')) }}
               {{ Form::select('commodity', array(null => '')+ $commodities,
                    Input::old('commodity'), array('class' => 'form-control', 'id' => 'commodity_id')) }}
              </div>
            <div class="form-group">
                {{ Form::label('Received From', trans('messages.received-from')) }}
                {{ Form::select('received-from', array(null => '')+ $suppliers,
                    Input::old('received-from'), array('class' => 'form-control', 'id' => 'supplier_id')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Doc. No.', trans('messages.doc-no')) }}
                {{ Form::text('doc-no', Input::old('doc-no'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Quantity', trans('messages.quantity')) }}
                {{ Form::text('quantity', Input::old('quantity'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Batch No. ', trans('messages.batch-no')) }}
                {{ Form::text('batch-no', Input::old('quantity'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Expiry Date', Lang::choice('messages.expiry-date',1)) }}
                {{ Form::text('expiry-date', Input::old('expiry-date'), array('class' => 'form-control standard-datepicker')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Location ', trans('messages.location')) }}
                {{ Form::text('location', Input::old('location'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Receivers Name ', trans('messages.receivers-name')) }}
                {{ Form::text('receivers-name', Input::old('receivers-name'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>

            <div class="form-group actions-row">
                    {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
                        array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
            </div>
        {{ Form::close() }}
		<?php Session::put('SOURCE_URL', URL::full());?>
	</div>
	
</div>
@stop