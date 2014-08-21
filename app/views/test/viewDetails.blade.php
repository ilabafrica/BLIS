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
				<a class="btn btn-sm btn-info" href="{{ URL::to("#") }}">
					<span class="glyphicon glyphicon-edit"></span>
					{{trans('messages.edit')}}
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3 class="view"><strong>{{trans('messages.test-type')}}</strong>{{ $test->testType->name }}</h3>
				<p class="view-striped"><strong>{{trans('messages.specimen-number')}}</strong>PAR-773</p>
				<p class="view"><strong>{{trans('messages.visit-number')}}Lab No.</strong>20140707-6</p>
				<p class="view-striped"><strong>{{trans('messages.patient-name')}}t</strong>booh</p>
				<p class="view"><strong>{{trans('messages.lab-receipt-date')}}</strong>07-07-2014</p>
				<p class="view-striped"><strong>{{trans('messages.registered-by')}}</strong>superadmin</p>
				<p class="view"><strong>{{trans('messages.test')}}</strong>BS for mps</p>
				<p class="view-striped"><strong>{{trans('messages.physician')}}</strong>-</p>
				<p class="view"><strong>Results</strong>Positive</p>
				<p class="view-striped"><strong>Remarks</strong>gosh!!</p>
				<p class="view"><strong>Entered By</strong>superadmin</p>
				<p class="view-striped"><strong>Turnaround time</strong>4 d 21 hrs 23 min</p>
				<p class="view"><strong>Verified By</strong>Verification Pending</p>
			</div>
		</div>
	</div>
@stop