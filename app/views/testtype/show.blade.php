@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li><a href="{{ URL::route('testtype.index') }}">{{ Lang::choice('messages.test-type',1) }}</a></li>
		  <li class="active">{{trans('messages.test-type-details')}}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-cog"></span>
			{{trans('messages.test-type-details')}}
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::to("testtype/". $testtype->id ."/edit") }}">
					<span class="glyphicon glyphicon-edit"></span>
					{{trans('messages.edit')}}
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3 class="view"><strong>{{ Lang::choice('messages.name',1) }}</strong>{{ $testtype->name }} </h3>
				<p class="view-striped"><strong>{{trans('messages.description')}}</strong>
					{{ $testtype->description }}</p>
				<p class="view"><strong>{{trans('messages.test-category')}}</strong>
					{{ $testtype->testCategory->name }}</p>
				<p class="view-striped"><strong>{{trans('messages.compatible-specimen')}}</strong>
					{{ implode(", ", $testtype->specimenTypes->lists('name')) }}</p>
				<p class="view"><strong>{{ Lang::choice('messages.measure',1) }}</strong>
					{{ implode(", ", $testtype->measures->lists('name')) }}</p>
				<p class="view-striped"><strong>{{trans('messages.turnaround-time')}}</strong>
					{{ $testtype->targetTAT }}</p>
				<p class="view"><strong>{{trans('messages.prevalence-threshold')}}</strong>
					{{ $testtype->prevalence_threshold }}</p>
				<p class="view-striped"><strong>{{trans('messages.date-created')}}</strong>
					{{ $testtype->created_at }}</p>
			</div>
		</div>
	</div>
@stop