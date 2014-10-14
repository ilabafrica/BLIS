<html>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-theme.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/layout.css') }}" />
<body>
<p>Laravel is beautiful !</p>
<img src="{{ asset('assets/img/butterfly.png') }}" alt="" />

<table>
	<tbody>
		<tr>
			<td><img src="{{ Config::get('kblis.organization-logo') }}" alt="" height="90" width="90"></td>
			<td colspan="3" style="text-align:center;">
				<strong><p>BUNGOMA DISTRICT HOSPITAL LABORATORY<br>
				BUNGOMA TOWN, HOSPITAL ROAD<br>
				OPPOSITE POLICE LINE/DISTRICT HEADQUARTERS<br>
				P.O. BOX 14,<br>
				BUNGOMA TOWN.<br>
				Phone: +254 055-30401 Ext 203/208</p>

				<p>LABORATORY REPORT<br>
				Patient Report for {{date('d-m-Y')}}</p></strong>			
			</td>
			<td><img src="{{ Config::get('kblis.organization-logo') }}" alt="" height="90" width="90" style="float:right;"></td>
		</tr>
	</tbody>
</table>
{{--*/ $patient = Patient::where('id', '=', '2')->get(); /*--}}
<table class="table">
	<tbody>
		<tr>
			<th>{{trans('messages.patient-name')}}</th>
			<td>{{ $patient->name }}</td>
			<th>{{trans('messages.gender')}}</th>
			<td>@if($patient->gender==0){{ 'Male' }} @else {{ 'Female' }} @endif</td>
		</tr>
		<tr>
			<th>{{trans('messages.external-patient-number')}}</th>
			<td>{{ $patient->patient_number."(".$patient->external_patient_number.")" }}</td>
			<th>{{trans('messages.age')}}</th>
			<td>{{ Report::dateDiff($patient->dob) }}</td>
		</tr>
		<tr>
			<th>{{trans('messages.patient-lab-number')}}</th>
			<td>{{ $patient->id }}</td>
			<th>{{trans('messages.requesting-facility-department')}}</th>
			<td></td>
		</tr>
	</tbody>
</table>
<table class="table">
	<tbody>
		<tr>
			<th colspan="6">{{trans('messages.specimens')}}</th>
		</tr>
		<tr>
			<th>{{trans('messages.specimen-type')}}</th>
			<th>{{trans('messages.tests')}}</th>
			<th>{{trans('messages.test-category')}}</th>
			<th>{{trans('messages.lab-receipt-date')}}</th>
			<th>{{trans('messages.collected-by')}}</th>
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
			<th colspan="10">{{trans('messages.test-results')}}</th>
		</tr>
		<tr>
			<th>{{trans('messages.test-results-values')}}</th>
			<th>{{trans('messages.results-entry-date')}}</th>
			<th>{{trans('messages.test-remarks')}}</th>
			<th>{{trans('messages.tested-by')}}</th>
			<th>{{trans('messages.date-tested')}}</th>
			<th>{{trans('messages.date-tested')}}</th>
			<th>{{trans('messages.date-verified')}}</th>
		</tr>
		@foreach($visits as $visit)
			{{--*/ $tests = Visit::with('tests')->find($visit->id)->tests /*--}}
			@foreach($tests as $test)
				{{--*/ $test_results = Test::with('testresults')->find($test->id)->test_results /*--}}
				<tr>
					<td>@foreach($test->testResults as $result)
							<p>{{Measure::find($result->measure_id)->name}}: {{$result->result}}</p>
						@endforeach</td>
					<td>@foreach($test->testResults as $result)
							<p>{{$result->time_entered}}</p>
						@endforeach</td>
					<td>{{ $test->interpretation }}</td>
					<td>{{$test->testedBy->name or trans('messages.unknown')}}</td>
					<td>{{ $test->time_completed }}</td>
					<td>{{$test->verifiedBy->name or trans('messages.verification-pending')}}</td>
					<td>{{ $test->time_verified }}</td>
				</tr>
			@endforeach
		@endforeach
	</tbody>
</table>

</body>
</html>