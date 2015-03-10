@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{{URL::route('inventory.labStockCard')}}}">{{ Lang::choice('messages.issue',2) }}</a></li>
	  <li class="active">{{ Lang::choice('messages.add-issue',2) }}</li>
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
		{{trans('messages.add-issue')}}
	</div>
	<div class="panel-body">

           {{ Form::open(array('url' => 'issue', 'id' => 'form-issues', 'method' => 'POST')) }}
            <div class="form-group">
                {{ Form::label('doc_no', trans('messages.doc-no')) }}
                {{ Form::text('doc_no', Input::old('doc-no'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('commodity', trans('messages.commodity')) }}
                 {{ Form::select('commodity', array(null => '')+ $commodities,
                    Input::old('commodity'), array('class' => 'form-control', 'id' => 'commodity-id')) }}
            </div>
             <div class="form-group">
                {{ Form::label('batch_no', trans('messages.batch-no')) }}
                {{ Form::text('batch_no', Input::old('batch_no'),array('class' => 'form-control', 'rows' => '2', 'id' => 'batch_no')) }}
            </div>
            <div class="form-group">
                {{ Form::label('expiry_date', Lang::choice('messages.expiry-date',1)) }}
                {{ Form::text('expiry_date', Input::old('expiry_date'), array('class' => 'form-control standard-datepicker', 'id' => 'expiry_date')) }}
            </div>
            <div class="form-group">
                {{ Form::label('qty_avl', trans('messages.qty-avl')) }}
                {{ Form::text('qty_avl', Input::old('qty_avl'),array('class' => 'form-control', 'rows' => '2', 'id' => 'qty_avl', 'disabled')) }}
            </div>
            <div class="form-group">
                {{ Form::label('quantity_issued', trans('messages.qty-issued')) }}
                {{ Form::text('quantity_issued', Input::old('quantity_issued'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('destination ', trans('messages.destination')) }}
                {{ Form::text('destination', Input::old('destination'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('receivers_name', trans('messages.receivers-name')) }}
                {{ Form::text('receivers_name', Input::old('receivers_name'),array('class' => 'form-control', 'rows' => '2')) }}
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