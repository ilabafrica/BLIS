@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">Home</a></li>
		  <li><a href="{{ URL::route('measure.index') }}">Measure</a></li>
		  <li class="active">Measure Details</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			Measure Details
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::to('measure/'. $measure->id .'/edit') }}" >
					<span class="glyphicon glyphicon-edit"></span>
					Edit
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3 class="view"><strong>Name</strong>{{ $measure->name }}</h3>
				<p class="view-striped"><strong>Description</strong>{{ $measure->description }}</p>
				<p class="view"><strong>Measure Type</strong>{{ $measure->measureType->name }}</p>
				@if ($measure->measureType->id == 2)
				<p class="view-striped"><strong>Measure Range</strong>{{ $measure->measure_range }}</p>
				@elseif ($measure->measureType->id == 1)
				<p class="view-striped"><strong>Range Values</strong></p>
				<div class="table-responsive panel panel-default">
					<?php $gender = ['Male', 'Female', 'Both']; ?>
					<table class="table table-condensed table-hover table-striped">
						<thead>
							<tr>
								<th>Age Min</th>
								<th>Age Max</th>
								<th>Gender</th>
								<th>Range Lower Limit</th>
								<th>Range Upper Limit</th>
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