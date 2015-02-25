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
                {{ Form::label('Issue Date', Lang::choice('messages.issue-date',1)) }}
                {{ Form::text('issue-date', Input::old('issue-date'), array('class' => 'form-control standard-datepicker')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Doc No. ', trans('messages.doc-no')) }}
                {{ Form::text('doc-no', Input::old('doc-no'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
           <div class="form-group">
                {{ Form::label('Commodity', trans('messages.commodity')) }}
                 {{ Form::select('commodity', array(0 => '-- Select Commodity--')+ $commodities,
                    isset($input['commodity'])?$input['commodity']:0, array('class' => 'form-control', 'id' => 'commodity_id')) }}
                    
            </div>
             <div class="form-group">
                {{ Form::label('Batch No. ', trans('messages.batch-no')) }}
                {{ Form::text('batch_no', Input::old('batch_no'),array('class' => 'form-control', 'rows' => '2', 'id' => 'batch_no')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Expiry Date', Lang::choice('messages.expiry-date',1)) }}
                {{ Form::text('expiry_date', Input::old('expiry_date'), array('class' => 'form-control standard-datepicker', 'id' => 'expiry_date')) }}
            </div>

            <div class="form-group">
                {{ Form::label('Quantity Available ', trans('messages.qty-avl')) }}
                {{ Form::text('qty_avl', Input::old('qty_avl'),array('class' => 'form-control', 'rows' => '2', 'id' => 'qty')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Quantity', trans('messages.qty-req')) }}
                {{ Form::text('qty-req', Input::old('qty-req'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Destination ', trans('messages.destination')) }}
                {{ Form::text('destination', Input::old('destination'),array('class' => 'form-control', 'rows' => '2')) }}
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



		
		<?php  
		Session::put('SOURCE_URL', URL::full());?>
	</div>
	
</div>
@stop