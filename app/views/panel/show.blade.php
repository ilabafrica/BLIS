@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li><a href="{{ URL::route('panel.index') }}">{{Lang::choice('messages.panels',2)}}</a></li>
		  <li class="active">{{trans('messages.panel-details')}}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-cog"></span>
			{{trans('messages.panel-details')}}
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::route('panel.edit', array($panel->id)) }}">
					<span class="glyphicon glyphicon-edit"></span>
					{{trans('messages.edit')}}
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3 class="view"><strong>{{Lang::choice('messages.name',1)}}</strong>{{ $panel->name }} </h3>
				<p class="view-striped"><strong>{{trans('messages.description')}}</strong>
					{{ $panel->description }}</p>				
				<p class="view-striped"><strong>{{trans('messages.date-created')}}</strong>
					{{ $panel->created_at }}</p>
			</div>
		</div>
	</div>
@stop