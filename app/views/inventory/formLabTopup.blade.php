@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{{URL::route('inventory.labTopup')}}}">{{ trans('messages.labTop-UpForm') }}</a></li>
	  <li>{{ trans('messages.labTopUp') }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{trans('messages.labTop-UpForm')}}
	</div>
    
	<div class="panel-body">
		  {{ Form::open(array('url' => 'inventory/store_FormLabTopup', 'id' => 'form-labTopup')) }}

            <div class="form-group">
                {{ Form::label('Date', Lang::choice('messages.date',1)) }}
                {{ Form::text('date', Input::old('date'), array('class' => 'form-control standard-datepicker')) }}
            </div>
           <div class="form-group">
                {{ Form::label('Commodity', trans('messages.commodity')) }}
                {{ Form::select('commodity', array(0 => '-- Select Commodity--')+ Inventory::getCommodities(),
                    isset($input['commodity'])?$input['commodity']:0, array('class' => 'form-control', 'id' => 'commodity_id')) }}
                    
                    
            </div>
            <div class="form-group">
                {{ Form::label('unit-of-issue', trans('messages.unit-of-issue')) }}
                {{ Form::text('unit-of-issue', Input::old('unit-of-issue'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('current-bal', trans('messages.current-bal')) }}
                {{ Form::text('current-bal', Input::old('current-bal'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('tests-done', trans('messages.tests-done')) }}
                {{ Form::text('tests-done', Input::old('tests-done'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('order-qty ', trans('messages.order-qty')) }}
                {{ Form::text('order-qty', Input::old('order-qty'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('issue-qty', Lang::choice('messages.issue-qty',1)) }}
                {{ Form::text('issue-qty', Input::old('issue-qty'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('issued-by ', trans('messages.issued-by')) }}
                {{ Form::text('issued-by', Input::old('issued-by'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Receivers Name ', trans('messages.receivers-name')) }}
                {{ Form::text('receivers-name', Input::old('receivers-name'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>   
            <div class="form-group">
                {{ Form::label('remarks ', trans('messages.remarks')) }}
                {{ Form::textarea('remarks', Input::old('remarks'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>           





            <div class="form-group actions-row">
                    {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
                        array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
            </div>
        {{ Form::close() }}



		
		<?php  
		Session::put('SOURCE_URL', URL::full());?>
	</div>
	
</div>
@stop