@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		  <li><a href="{{ URL::route('measure.index') }}">{{ Lang::choice('messages.measure',1) }}</a></li>
		  <li class="active">{{ trans('messages.measure-details') }}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			{{ trans('messages.measure-details') }}
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::to('measure/'. $measure->id .'/edit') }}" >
					<span class="glyphicon glyphicon-edit"></span>
					{{ trans('messages.edit') }}
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3 class="view"><strong>{{ Lang::choice('messages.name',1) }}</strong>{{ $measure->name }}</h3>
				<p class="view-striped"><strong>{{trans('messages.description')}}</strong>{{ $measure->description }}</p>
				<p class="view"><strong>{{trans('messages.measure-type')}}</strong>{{ $measure->measureType->name }}</p>
				@if ($measure->measureType->isAlphanumeric())
					<p class="view-striped"><strong>{{trans('messages.measure-range')}}</strong>
					@foreach($measure->measureRanges as $range)
						{{ $range->alphanumeric }}/
					@endforeach
					</p>
				@elseif ($measure->measureType->isNumeric())
				<p class="view-striped"><strong>{{trans('messages.measure-range-values')}}</strong></p>
				<div class="table-responsive panel panel-default">
					<?php $gender = [trans('messages.male'), trans('messages.female'), trans('messages.both')]; ?>
					<table class="table table-condensed table-hover table-striped">
						<thead>
							<tr>
								<th>{{ trans('messages.agemin') }}</th>
								<th>{{ trans('messages.agemax') }}</th>
								<th>{{ trans('messages.gender') }}</th>
								<th>{{ trans('messages.rangemin') }}</th>
								<th>{{ trans('messages.rangemax') }}</th>
							</tr>
						</thead>
						<tbody>
							@foreach($measure->measureRanges as $range)
							<tr>
								<td>{{ $range->age_min }}</td>
								<td>{{ $range->age_max }}</td>
								<td>{{ $gender[$range->gender] }}</td>
								<td>{{ $range->range_lower }}</td>
								<td>{{ $range->range_upper }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				@endif
			</div>			
		</div>
	</div>
@stop