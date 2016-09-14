@extends("layout")
@section("content")

@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif

	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		  <li><a href="{{ URL::route('microcritical.index') }}">{{ trans_choice('messages.microcritical',1) }}</a></li>
		  <li class="active">{{ trans('messages.microcritical-details') }}</li>
		</ol>
	</div>
	<div class="panel panel-primary ">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-adjust"></span>
			{{ trans('messages.microcritical-details') }}
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::route('microcritical.edit', array($microcritical->id)) }}">
					<span class="glyphicon glyphicon-edit"></span>
					{{ trans('messages.edit') }}
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3 class="view"><strong>{{ trans('messages.description') }}:</strong>{{ $microcritical->description }} </h3>				
			</div>
		</div>
	</div>
@stop