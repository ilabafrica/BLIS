@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ trans('messages.reports') }}</li>
	  <li class="active">{{ trans('messages.patient-report') }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.patient-report') }}
	</div>
	<div class="panel-body">
	@include("report_header")

		<!-- if there are search errors, they will show here -->
		@if($errors->all())
			<div class="alert alert-danger">
				{{ HTML::ul($errors->all()) }}
			</div>
		@endif
<!-- 
		{{ Form::open(array('method' => 'POST', 'route' => 'reports.patient.search', 'id' => 'form-search-patient', 'class' => 'navbar-form navbar-left', 'role' => 'search')) }}
		  <div class="form-group">
		  	{{ Form::text('value', Input::old('value'), array('class' => 'form-control', 'placeholder' => 'Search')) }}
		  </div>
  		  {{ Form::button("<span class='glyphicon glyphicon-search'></span> ".trans('messages.search'), 
						array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
		{{ Form::close() }} -->
		<table class="table">
			<tbody>
				<tr>
					<th>{{trans('messages.patient-name')}}</th>
					<td>{{ $patient->name }}</td>
					<th>{{trans('messages.gender')}}</th>
					<td>@if($patient->gender==0){{ 'Male' }} @else {{ 'Female' }} @endif</td>
				</tr>
				<tr>
					<th>Patient Number(Sanitas)</th>
					<td>{{ $patient->patient_number."(".$patient->external_patient_number.")" }}</td>
					<th>Patient Age</th>
					<td>{{ Report::dateDiff($patient->dob) }}</td>
				</tr>
				<tr>
					<th>Lab Number [Serial No.]</th>
					<td>{{ $patient->id }}</td>
					<th>Requesting Department/Facility</th>
					<td></td>
				</tr>
			</tbody>
		</table>
		<table class="table">
			<tbody>
				<tr>
					<th colspan="6">Specimens</th>
				</tr>
				<tr>
					<th>Type</th>
					<th>Tests Requested</th>
					<th>Lab Section</th>
					<th>Lab Receipt Date</th>
					<th>Collected by</th>
				</tr>
				{{--*/ $visits = Patient::with('visits')->find($patient->id)->visits /*--}}
				@foreach($visits as $visit)
					{{--*/ $tests = Visit::with('tests')->find($visit->id)->tests /*--}}
					@foreach($tests as $test)
						{{--*/ $specimen = Test::with('specimen')->find($test->id)->specimen /*--}}
						<tr>
							<td>{{ $specimen->specimenType->name }}</td>
							<td>{{ $test->testType->name }}</td>
							<td>{{ $test->testType->testCategory->name }}</td>
							<td>{{ $specimen->time_accepted }}</td>
							<td>{{ $specimen->createdBy->name }}</td>
						</tr>
					@endforeach
				@endforeach

			</tbody>
		</table>
		<table class="table">
			<tbody>
				<tr>
					<th colspan="10">Test Results</th>
				</tr>
				<tr>
					<th>Test : Results(Value)</th>
					<th>Results Entry Date</th>
					<th>Remarks</th>
					<th>Tested by</th>
					<th>Date Tested</th>
					<th>Date Entered</th>
					<th>Verified by</th>
					<th>Date Verified</th>
				</tr>
				@foreach($visits as $visit)
					{{--*/ $tests = Visit::with('tests')->find($visit->id)->tests /*--}}
					@foreach($tests as $test)
						{{--*/ $test_results = Test::with('testresults')->find($test->id)->test_results /*--}}
						<tr>
							<td>@foreach($test->testResults as $result)
									<p>{{Measure::find($result->measure_id)->name}}: {{$result->result}}</p>
								@endforeach</td>
							<td>{{ $test->interpretation }}</td>
							<td>{{ $test->interpretation }}</td>
							<td>{{ $test->id }}</td>
							<td>{{ $test->time_completed }}</td>
							<td>{{ "" }}</td>
							<td>{{ $test->id }}</td>
							<td>{{ $test->time_verified }}</td>
						</tr>
					@endforeach
				@endforeach
			</tbody>
		</table>
	</div>

</div>
@stop