	<div>
		<ol class="breadcrumb">
		  <li><a href="#">Home</a></li>
		  <li><a href="javascript:void(0);" onclick="pageloader('{{ URL::to('measure') }}')">Measure</a></li>
		  <li class="active">Measure Details</li>
		</ol>
	</div>
	<div class="panel panel-primary patient-create">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			Measure Details
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="javascript:void(0);" onclick="pageloader('{{ URL::to('measure/'. $measure->id .'/edit') }}')">
					<span class="glyphicon glyphicon-edit"></span>
					Edit
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3><strong>Name:</strong>{{ $measure->name }} </h3>
				<p><strong>Description:</strong>{{ $measure->description }}</p>
				<p><strong>Measure Type:</strong>{{ $measure->measureType->name }}</p>
				<p><strong>Measure Range:</strong>{{ $measure->measure_range }}</p>
				<p><ul>
					<?php $gender = ['Male', 'Female', 'Both']; ?>
					@foreach($measure->measureRanges as $range)
					<li>Minimum Age: {{ $range->age_min }}</li>
					<li>Maximum Age: {{ $range->age_max }}</li>
					<li>Gender: {{ $gender[$range->sex - 1] }}</li>
					<li>Upper Limit: {{ $range->range_upper }}</li>
					<li>Lower Limit: {{ $range->range_lower }}</li>
					@endforeach
				</ul></p>
			</div>
		</div>
	</div>