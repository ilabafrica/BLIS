@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li><a href="{{ URL::route('test.index') }}">{{trans('messages.test')}}</a></li>
		  <li class="active">{{trans('messages.test-details')}}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-cog"></span>
			{{trans('messages.test-details')}}
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::to('test/'.$test->id.'/edit') }}">
					<span class="glyphicon glyphicon-edit"></span>
					{{trans('messages.edit-test-results')}}
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3 class="view"><strong>{{trans('messages.test-type')}}</strong>
					{{ $test->testType->name or trans('messages.unknown') }}</h3>
				<p class="view-striped"><strong>{{trans('messages.specimen-number')}}</strong>
					{{$test->specimen->id or trans('messages.pending') }}</p>
				<p class="view"><strong>{{trans('messages.visit-number')}}</strong>
					{{$test->visit->id or trans('messages.unknown') }}</p>
				<p class="view-striped"><strong>{{trans('messages.patient-name')}}</strong>
					{{$test->visit->patient->name}}</p>
				<p class="view"><strong>{{trans('messages.lab-receipt-date')}}</strong>
					{{$test->time_created}}</p>
				<p class="view-striped"><strong>{{trans('messages.registered-by')}}</strong>
					{{$test->createdBy->name or trans('messages.unknown') }}</p>
				<p class="view"><strong>{{trans('messages.specimen-type')}}</strong>
					{{$test->specimen->specimenType->name or trans('messages.pending') }}</p>
				<p class="view-striped"><strong>{{trans('messages.physician')}}</strong>
					{{$test->requested_by or trans('messages.unknown') }}</p>
				<p class="view"><strong>{{trans('messages.tested-by')}}</strong>
					{{$test->testedBy->name or trans('messages.unknown')}}</p>
				<p class="view-striped"><strong>{{trans('messages.turnaround-time')}}</strong>
					<?php $tat = $test->getTurnaroundTime(); ?>
					{{$tat or trans('messages.pending')}}</p>
				<p class="view"><strong>{{trans('messages.verified-by')}}</strong>
					{{$test->verifiedBy->name or trans('messages.verification-pending')}}</p>
				<p class="view"><strong>{{trans('messages.test-results')}}</strong>
					<div>
					@foreach($test->testResults as $result)
						<p>{{Measure::find($result->measure_id)->name}}: {{$result->result}}</p>
					@endforeach
					</div>
				</p>
				<p class="view-striped"><strong>{{trans('messages.test-remarks')}}</strong>
					{{$test->interpretation}}</p>
			</div>
		</div>
	</div>
@stop