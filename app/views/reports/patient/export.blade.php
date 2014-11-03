<html>
<head>
{{ HTML::style('css/bootstrap.min.css') }}
{{ HTML::style('css/bootstrap-theme.min.css') }}
</head>
<body>
<div id="wrap">
    <div class="container-fluid">
        <div class="row">
			<table>
				<tbody>
					<tr>
						<td>{{ HTML::image('i/org_logo_90x90.png', 'Kenya Court of Arms', array('width' => '90px')) }}</td>
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
						<td>{{ HTML::image('i/org_logo_90x90.png', 'Kenya Court of Arms', array('width' => '90px')) }}</td>
					</tr>
				</tbody>
			</table>
			<table class="table table-bordered">
			<tbody>
				<tr>
					<th>{{ trans('messages.patient-name')}}</th>
					<td>{{ $patient->name }}</td>
					<th>{{ trans('messages.gender')}}</th>
					<td>{{ ($patient->gender==Patient::MALE?trans('messages.male'):trans('messages.female')) }}</td>
				</tr>
				<tr>
					<th>{{ trans("messages.patient-number")}}</th>
					<td>{{ $patient->patient_number}}</td>
					<th>{{ trans('messages.age')}}</th>
					<td>{{ $patient->getAge()}}</td>
				</tr>
				<tr>
					<th>{{ trans('messages.visit-number')}}</th>
					<td>{{ $patient->id }}</td>
					<th>{{ trans('messages.requesting-facility-department')}}</th>
					<td></td>
				</tr>
			</tbody>
		</table>
		<table class="table table-bordered">
			<tbody>
				<tr>
					<th colspan="5">{{trans('messages.specimen')}}</th>
				</tr>
				<tr>
					<th>{{ trans('messages.specimen-type')}}</th>
					<th>{{ trans('messages.tests')}}</th>
					<th>{{ trans('messages.test-category')}}</th>
					<th>{{ trans('messages.lab-receipt-date')}}</th>
					<th>{{ trans('messages.collected-by')}}</th>
				</tr>
				@forelse($visits as $visit)
					@foreach($visit->tests as $test)
						<tr>
							<td>{{ $test->specimen->specimenType->name }}</td>
							<td>{{ $test->testType->name }}</td>
							<td>{{ $test->testType->testCategory->name }}</td>
							<td>{{ $test->specimen->time_accepted }}</td>
							<td>{{ $test->specimen->acceptedBy->name or trans('messages.unknown')}}</td>
						</tr>
					@endforeach
				@empty
					<tr>
						<td colspan="5">{{trans("messages.no-records-found")}}</td>
					</tr>
				@endforelse

			</tbody>
		</table>
		<table class="table table-bordered">
			<tbody>
				<tr>
					<th colspan="7">{{trans('messages.test-results')}}</th>
				</tr>
				<tr>
					<th>{{trans('messages.test-results-values')}}</th>
					<th>{{trans('messages.results-entry-date')}}</th>
					<th>{{trans('messages.test-remarks')}}</th>
					<th>{{trans('messages.tested-by')}}</th>
					<th>{{trans('messages.date-tested')}}</th>
					<th>{{trans('messages.verified-by')}}</th>
					<th>{{trans('messages.date-verified')}}</th>
				</tr>
				@forelse($visits as $visit)
					@foreach($visit->tests as $test)
						<tr>
							<td>@foreach($test->testResults as $result)
									<p>{{Measure::find($result->measure_id)->name}}: {{$result->result}}</p>
								@endforeach</td>
							<td>@foreach($test->testResults as $result)
									<p>{{$result->time_entered}}</p>
								@endforeach</td>
							<td>{{ $test->interpretation }}</td>
							<td>{{ $test->testedBy->name or trans('messages.unknown')}}</td>
							<td>{{ $test->time_completed }}</td>
							<td>{{ $test->verifiedBy->name or trans('messages.verification-pending')}}</td>
							<td>{{ $test->time_verified }}</td>
						</tr>
					@endforeach
				@empty
					<tr>
						<td colspan="7">{{trans("messages.no-records-found")}}</td>
					</tr>
				@endforelse
			</tbody>
		</table>
		</div>
	</div>
</div>
</body>
</html>