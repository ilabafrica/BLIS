@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li><a href="{{ URL::route('instrument.index') }}">{{Lang::choice('messages.instrument',2)}}</a></li>
		  <li class="active">{{trans('messages.instrument-details')}}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-cog"></span>
			{{trans('messages.instrument-details')}}
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::route('instrument.edit', array($instrument->id)) }}">
					<span class="glyphicon glyphicon-edit"></span>
					{{trans('messages.edit')}}
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3 class="view"><strong>{{Lang::choice('messages.name',1)}}</strong>{{ $instrument->name }} </h3>
				<p class="view-striped"><strong>{{trans('messages.description')}}</strong>
					{{ $instrument->description }}</p>
				<p class="view"><strong>{{trans('messages.ip')}}</strong>
					{{ $instrument->ip }}</p>
				<p class="view-striped"><strong>{{trans('messages.host-name')}}</strong>
					{{ $instrument->hostname }}</p>
				<p class="view-striped"><strong>{{trans('messages.compatible-test-types')}}</strong>
					{{ implode(", ", $instrument->testTypes->lists('name')) }}</p>
				<p class="view-striped"><strong>{{trans('messages.date-created')}}</strong>
					{{ $instrument->created_at }}</p>
			</div>
		</div>
	</div>
@stop