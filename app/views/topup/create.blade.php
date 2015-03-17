@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{{URL::route('topup.index')}}}">{{ trans('messages.topup') }}</a></li>
	  <li class="active">{{ trans('messages.request-topup') }}</li>
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
		{{trans('messages.topup')}}
	</div>
	<div class="panel-body">
		  {{ Form::open(array('url' => 'topup', 'id' => 'form-labTopup', 'method' => 'POST')) }}
           <div class="form-group">
                {{ Form::label('lab_section', Lang::choice('messages.test-category', 1)) }}
                {{ Form::select('lab_section', array(null => '')+ $sections, Input::old('lab_section'),
                    array('class' => 'form-control', 'rows' => '2')) }}
            </div>
           <div class="form-group">
                {{ Form::label('commodity', trans('messages.commodity')) }}
                {{ Form::select('commodity', array(null => '')+ $commodities,
                    Input::old('commodity'), array('class' => 'form-control', 'id' => 'commodity-id')) }}
            </div>
            <div class="form-group">
                {{ Form::label('current_bal', trans('messages.current-bal')) }}
                {{ Form::text('current_bal', Input::old('current_bal'),array('class' => 'form-control', 'rows' => '2', 'disabled')) }}
            </div>
            <div class="form-group">
                {{ Form::label('order_quantity ', trans('messages.order-qty')) }}
                {{ Form::text('order_quantity', Input::old('order_quantity'),array('class' => 'form-control', 'rows' => '2')) }}
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
		<?php Session::put('SOURCE_URL', URL::full()); ?>
	</div>
</div>
@stop