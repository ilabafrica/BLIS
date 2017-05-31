<html>
<head>
<style type="text/css">
	#content table, #content th, #content td {
	   border: 1px solid black;
	   font-size:12px;
	}
	#content p{
		font-size:12px;
	 }
	.table {
		 border-collapse: collapse;
	 }
</style>
</head>
<body>
<div id="wrap">
    <div class="container-fluid">
        <div class="row">
			@include("reportHeader")
			<div id="content">
			<strong>
				<p>
					{{trans('messages.patient-report').' - '.date('d-m-Y')}}

				</p>
			</strong>
			<table class="table table-bordered"  width="100%">
			<tbody>
				<tr align="left">
					<th>{{ trans('messages.patient-name')}}</th>
					<td>{{ $patient->name }}</td>
					<th>{{ trans('messages.gender')}}</th>
					<td>{{ $patient->getGender() }}</td>
				</tr>
				<tr align="left">
					<th>{{ trans("messages.patient-number")}}</th>
					<td>{{ $patient->patient_number}}</td>
					<th>{{ trans('messages.age')}}</th>
					<td>{{ $patient->getAge()}}</td>
				</tr>
				<tr align="left">
					<th>{{ trans('messages.patient-lab-number')}}</th>
					<td>{{ $patient->id }}</td>
					<th>{{ trans('messages.requesting-facility-department')}}</th>
					<td>{{ Config::get('kblis.organization') }}</td>
				</tr>
			</tbody>
		</table>
		<br>
		<table class="table table-bordered" width="100%">
			<tbody align="left">
				<tr>
					<th colspan="7">{{ trans('messages.specimen') }}</th>
				</tr>
				<tr>
					<th>{{ Lang::choice('messages.specimen-type', 1)}}</th>
					<th>{{ Lang::choice('messages.test', 2)}}</th>
					<th>{{ trans('messages.date-ordered') }}</th>
					<th>{{ Lang::choice('messages.test-category', 2)}}</th>
					<th>{{ trans('messages.specimen-status')}}</th>
					<th>{{ trans('messages.collected-by')."/".trans('messages.rejected-by')}}</th>
					<th>{{ trans('messages.date-checked')}}</th>
				</tr>
				@forelse($tests as $test)
					<tr>
						<td>{{ $test->specimen->specimenType->name }}</td>
						<td>{{ $test->testType->name }}</td>
						<td>{{ $test->isExternal()?$test->external()->request_date:$test->time_created }}</td>
						<td>{{ $test->testType->testCategory->name }}</td>
						@if($test->specimen->specimen_status_id == Specimen::NOT_COLLECTED)
							<td>{{trans('messages.specimen-not-collected') }}</td>
							<td></td>
							<td></td>
						@elseif($test->specimen->specimen_status_id == Specimen::ACCEPTED)
							<td>{{trans('messages.specimen-accepted')}}</td>
							<td>{{$test->specimen->acceptedBy->name}}</td>
							<td>{{$test->specimen->time_accepted}}</td>
						@elseif($test->specimen->specimen_status_id == Specimen::REJECTED)
							<td>{{trans('messages.specimen-rejected')}}</td>
							<td>{{$test->specimen->rejectedBy->name}}</td>
							<td>{{$test->specimen->time_rejected}}</td>
						@endif
					</tr>
				@empty
					<tr>
						<td colspan="7">{{ trans("messages.no-records-found") }}</td>
					</tr>
				@endforelse

			</tbody>
		</table>
		<br>
		<table class="table table-bordered"  width="100%">
			<tbody align="left">
				<tr>
					<th colspan="8">{{trans('messages.test-results')}}</th>
				</tr>
				<tr>
					<th>{{Lang::choice('messages.test-type', 1)}}</th>
					<th>{{trans('messages.test-results-values')}}</th>
					<th>{{trans('messages.test-remarks')}}</th>
					<th>{{trans('messages.tested-by')}}</th>
					<th>{{trans('messages.results-entry-date')}}</th>
					<th>{{trans('messages.date-tested')}}</th>
					<th>{{trans('messages.verified-by')}}</th>
					<th>{{trans('messages.date-verified')}}</th>
				</tr>
				@forelse($tests as $test)
					<tr>
						<td>{{ $test->testType->name }}</td>
						<td>
							@foreach($test->testResults as $result)
							<p>
								{{ Measure::find($result->measure_id)->name }}: {{ $result->result }}
								{{ Measure::getRange($test->visit->patient, $result->measure_id, $result->time_entered) }}
								{{ Measure::find($result->measure_id)->unit }}
							</p>
							@endforeach
						</td>
						<td>{{ $test->interpretation }}</td>
						<td>{{ $test->testedBy->name or trans('messages.pending')}}</td>
						<td>{{ $test->time_entered }}</td>
						<td>{{ $test->time_completed }}</td>
						<td>{{ $test->verifiedBy->name or trans('messages.verification-pending')}}</td>
						<td>{{ $test->time_verified }}</td>
					</tr>
				@empty
					<tr>
						<td colspan="8">{{trans("messages.no-records-found")}}</td>
					</tr>
				@endforelse
			</tbody>
		</table>
		</div>
		</div>
		<hr style="border: 1px solid black;">
		<table class="table table-bordered"  width="100%" style="font-size:12px;">
			<tbody>
				<tr>
					<td><strong>{{ trans('messages.authorized-by') }}</strong></td>
					<td>{{ trans('messages.signature-holder') }}</td>
					<td><strong>{{ Lang::choice('messages.name', 1).":" }}</strong>{{ trans('messages.signature-holder') }}</td>
				</tr>
				<tr>
					<td>{{ 'Antony Sangolo' }}</td>
					<td>{{ 'Joan Wasike' }}</td>
					<td>{{ 'Dr. Sylvester Mutoro' }}</td>
				</tr>
				<tr>
					<td><u><strong>{{ trans('messages.quality-manager') }}</strong></u></td>
					<td><u><strong>{{ trans('messages.lab-manager') }}</strong></u></td>
					<td><u><strong>{{ trans('messages.lab-director') }}</strong></u></td>
				</tr>
				<tr>
					<td><strong>{{ trans('messages.patient-report-no') }}</strong></td>
					<td></td>
					<td><strong>{{ trans('messages.patient-report-version') }}</strong></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</body>
</html>