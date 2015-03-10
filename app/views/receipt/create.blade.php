@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{{URL::route('receipt.index')}}}">{{ Lang::choice('messages.receipt',2) }}</a></li>
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
		{{trans('messages.add-receipts')}}
	</div>
	<div class="panel-body">
		   {{ Form::open  (array('url' => 'receipt', 'id' => 'form-receipts', 'method' => 'POST' )) }}
            <div class="form-group">
                {{ Form::label('commodity', trans('messages.commodity')) }}
               {{ Form::select('commodity', array(null => '')+ $commodities,
                    Input::old('commodity'), array('class' => 'form-control')) }}
              </div>
            <div class="form-group">
                {{ Form::label('supplier', Lang::choice('messages.supplier',1)) }}
                {{ Form::select('supplier', array(null => '')+ $suppliers,
                    Input::old('supplier'), array('class' => 'form-control')) }}
            </div>
            <div class="form-group">
                {{ Form::label('doc_no', trans('messages.doc-no')) }}
                {{ Form::text('doc_no', Input::old('doc-no'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('quantity', trans('messages.quantity')) }}
                {{ Form::text('quantity', Input::old('quantity'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('batch_no', trans('messages.batch-no')) }}
                {{ Form::text('batch_no', Input::old('quantity'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('expiry_date', Lang::choice('messages.expiry-date',1)) }}
                {{ Form::text('expiry_date', Input::old('expiry-date'), array('class' => 'form-control standard-datepicker')) }}
            </div>
            <div class="form-group">
                {{ Form::label('location ', trans('messages.location')) }}
                {{ Form::text('location', Input::old('location'),array('class' => 'form-control', 'rows' => '2')) }}
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