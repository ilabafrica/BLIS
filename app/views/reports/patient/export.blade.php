<html>
<head>
{{ HTML::style('css/bootstrap.min.css') }}
{{ HTML::style('css/bootstrap-theme.min.css') }}
<style type="text/css">
	#content table, #content th, #content td {
   border: 1px solid black;
}
</style>
</head>
<body>
<div id="wrap">
    <div class="container-fluid">
        <div class="row">
			@include("reportHeader")
			<strong>
				<p>
					{{ trans('messages.patient-report') }} @if($from!=$to)
						{{ 'From '.$from.' To '.$to }}
					@else
						{{ 'For '.date('d-m-Y') }}
					@endif
				</p>
			</strong>
			<div id="content">
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
					<th colspan="6">{{ trans('messages.specimen') }}</th>
				</tr>
				<tr>
					<th>{{ trans('messages.specimen-type')}}</th>
					<th>{{ Lang::choice('messages.test', 2)  }}</th>
					<th>{{ trans('messages.test-category')}}</th>
					<th>{{ trans('messages.specimen-status')}}</th>
					<th>{{ trans('messages.collected-by')."/".trans('messages.rejected-by')}}</th>
					<th>{{ trans('messages.date-checked')}}</th>
				</tr>
				@forelse($tests as $test)
					<tr>
						<td>{{ $test->specimen->specimenType->name }}</td>
						<td>{{ $test->testType->name }}</td>
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
						<td colspan="6">{{ trans("messages.no-records-found") }}</td>
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
					<th>{{trans('messages.test-type')}}</th>
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
						<td>@foreach($test->testResults as $result)
								<p>{{Measure::find($result->measure_id)->name}}: {{$result->result}}</p>
							@endforeach</td>
						<td>{{ $test->interpretation }}</td>
						<td>{{ $test->testedBy->name or trans('messages.pending')}}</td>
						<td>@foreach($test->testResults as $result)
								<p>{{$result->time_entered}}</p>
							@endforeach</td>
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
	</div>
</div>
</body>
</html>