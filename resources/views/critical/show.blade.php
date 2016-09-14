@extends("layout")
@section("content")

@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif

	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		  <li><a href="{{ URL::route('critical.index') }}">{{ trans_choice('messages.critical',1) }}</a></li>
		  <li class="active">{{ trans_choice('messages.critical', 1) }}</li>
		</ol>
	</div>
	<div class="panel panel-primary ">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-adjust"></span>
			{{ trans_choice('messages.critical', 1) }}
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::route('critical.edit', array($critical->id)) }}">
					<span class="glyphicon glyphicon-edit"></span>
					{{ trans('messages.edit') }}
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3 class="view"><strong>{{ trans_choice('messages.name',1) }}:</strong>{{ $critical->measure->name }} </h3>
				<p class="view-striped"><strong>{{ trans('messages.gender') }}:</strong>
					@if($critical->gender==0)
						{{ trans('messages.male') }}
					@elseif($critical->gender==1)
						{{ trans('messages.female') }}
					@else
						{{ trans('messages.both') }}
					@endif
				</p>
				<p class="view-striped"><strong>{{ trans('messages.age-min') }}:</strong>
					{{ $critical->age_min }}</p>
				<p class="view-striped"><strong>{{ trans('messages.age-max') }}:</strong>
					{{ $critical->age_max }}</p>
				<p class="view-striped"><strong>{{ trans('messages.normal-lower') }}:</strong>
					{{ $critical->normal_lower }}</p>
				<p class="view-striped"><strong>{{ trans('messages.normal-upper') }}:</strong>
					{{ $critical->normal_upper }}</p>
				<p class="view-striped"><strong>{{ trans('messages.critical-low') }}:</strong>
					{{ $critical->critical_low }}</p>
				<p class="view-striped"><strong>{{ trans('messages.critical-high') }}:</strong>
					{{ $critical->critical_high }}</p>
				<p class="view-striped"><strong>{{ trans('messages.unit') }}:</strong>
					{{ $critical->unit }}</p>
			</div>
		</div>
	</div>
@stop