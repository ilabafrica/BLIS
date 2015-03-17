@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
        <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
        <li><a href="{{{URL::route('metric.index')}}}">{{trans('messages.metricsList')}}</a></li>
        <li class="active">{{ Lang::choice('messages.metrics',2) }}</li>
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
		{{ Lang::choice('messages.metrics',2) }}
	</div>
	<div class="panel-body">
		   {{ Form::open(array('route' => 'metric.store', 'id' => 'form-store_metrics')) }}

            <div class="form-group">
                {{ Form::label('unit-of-issue', trans('messages.unit-of-issue')) }}
                {{ Form::text('unit-of-issue', Input::old('unit-of-issue'), array('class' => 'form-control', 'rows' => '2')) }}
            </div>
             <div class="form-group">
                {{ Form::label('description', trans('messages.description')) }}
                {{ Form::textarea('description', Input::old('description'), array('class' => 'form-control', 'rows' => '2')) }}
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