@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{{URL::route('inventory.labStockCard')}}}">{{ trans('messages.inventory') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.labStockCardIssues',2) }}</li>
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
		{{trans('messages.labStockCardIssues')}}
		
	</div>
	<div class="panel-body">
		 
           {{ Form::open(array('url' => 'inventory/store_issues', 'id' => 'form-issues')) }}

            <div class="form-group">
                {{ Form::label( 'issue-date' , Lang::choice('messages.issue-date',1)) }}
                {{ Form::text('issue-date', Input::old('issue-date'), array('class' => 'form-control standard-datepicker')) }}
            </div>
            <div class="form-group">
                {{ Form::label('doc-no', trans('messages.doc-no')) }}
                {{ Form::text('doc-no', Input::old('doc-no'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('commodity', trans('messages.commodity')) }}
                 {{ Form::select('commodity', array(null => '')+ $commodities,
                    Input::old('commodity'), array('class' => 'form-control', 'id' => 'commodity-id')) }}
            </div>
             <div class="form-group">
                {{ Form::label('batch-no', trans('messages.batch-no')) }}
                {{ Form::text('batch-no', Input::old('batch-no'),array('class' => 'form-control', 'rows' => '2', 'id' => 'batch-no')) }}
            </div>
            <div class="form-group">
                {{ Form::label('expiry-date', Lang::choice('messages.expiry-date',1)) }}
                {{ Form::text('expiry-date', Input::old('expiry-date'), array('class' => 'form-control standard-datepicker', 'id' => 'expiry-date')) }}
            </div>
            <div class="form-group">
                {{ Form::label('qty-avl', trans('messages.qty-avl')) }}
                {{ Form::text('qty-avl', Input::old('qty-avl'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('qty-req', trans('messages.qty-req')) }}
                {{ Form::text('qty-req', Input::old('qty-req'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('destination ', trans('messages.destination')) }}
                {{ Form::text('destination', Input::old('destination'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('receivers-name', trans('messages.receivers-name')) }}
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