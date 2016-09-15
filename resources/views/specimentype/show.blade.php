@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li><a href="{{ URL::route('specimentype.index') }}">{{ trans_choice('messages.specimen-type',2) }}</a></li>
		  <li class="active">{{trans('messages.specimen-type-details')}}</li>
		</ol>
	</div>
	<div class="panel panel-primary specimentype-create">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			{{trans('messages.specimen-type-details')}}
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::to("specimentype/". $specimentype->id ."/edit") }}">
					<span class="glyphicon glyphicon-edit"></span>
					{{trans('messages.edit')}}
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3 class="view"><strong>{{ trans_choice('messages.name',1) }}</strong>{{ $specimentype->name }} </h3>
				<p class="view-striped"><strong>{{trans('messages.description')}}</strong>
					{{ $specimentype->description }}</p>
				<p class="view"><strong>{{trans('messages.date-created')}}</strong>{{ $specimentype->created_at }}</p>
			</div>
		</div>
	</div>
@stop