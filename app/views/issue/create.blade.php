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
		{{Lang::choice('messages.issue', 1)}} {{ trans('messages.commodity')}}
	</div>
	<div class="panel-body">

           {{ Form::open(array('url' => 'issue', 'id' => 'form-issues', 'method' => 'POST')) }}
            <div class="form-group">
                {{ Form::label('commodity', trans('messages.commodity')) }}
                 {{ Form::text('commodity', $topupRequest->commodity->name, 
                 array('class' => 'form-control', 'disabled')) }}
            </div>
            <div class="form-group">
                {{ Form::label('lab_section ', trans('messages.destination')) }}
                {{ Form::text('lab_section', $topupRequest->section->name,
                    array('class' => 'form-control', 'rows' => '2', 'disabled')) }}
            </div>
             <div class="form-group">
                {{ Form::label('batch_no', trans('messages.batch-no')) }}
                {{ Form::select('batch_no', array(null => '')+ $batches, Input::old('batch_no'),
                    array('class' => 'form-control', 'rows' => '2', 'id' => 'batch_no')) }}
            </div>
            <div class="form-group">
                {{ Form::label('quantity_available', trans('messages.qty-avl')) }}
                {{ Form::text('quantity_available', $topupRequest->commodity->available(), 
                    array('class' => 'form-control', 'rows' => '2', 'id' => 'quantity_available', 'disabled')) }}
            </div>
            <div class="form-group">
                {{ Form::label('quantity_required', trans('messages.quantity-required')) }}
                {{ Form::text('quantity_required', $topupRequest->order_quantity,
                    array('class' => 'form-control', 'rows' => '2', 'id' => 'quantity_required', 'disabled')) }}
            </div>
            <div class="form-group">
                {{ Form::label('quantity_issued', trans('messages.qty-issued')) }}
                {{ Form::text('quantity_issued', Input::old('quantity_issued'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('issued_to', trans('messages.receivers-name')) }}
                {{ Form::select('issued_to', array(null => '')+ $users, Input::old('issued_to'),
                    array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('remarks ', trans('messages.remarks')) }}
                {{ Form::textarea('remarks', Input::old('remarks'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            {{ Form::hidden('topup_request_id', $topupRequest->id) }}
            <div class="form-group actions-row">
                    {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
                        array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
            </div>
        {{ Form::close() }}

		<?php Session::put('SOURCE_URL', URL::full());?>
	</div>
	
</div>
@stop