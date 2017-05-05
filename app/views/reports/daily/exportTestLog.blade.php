<html>
<head>
{{ HTML::style('css/bootstrap-theme.min.css') }}
</head>
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
<body>
@include("reportHeader")
<div id="content" class="Section2">
	<strong>
		<p>
			{{trans('messages.test-records')}} 

			@if($pendingOrAll == 'pending')
				{{' - '.trans('messages.pending-only')}}
			@elseif($pendingOrAll == 'all')
				{{' - '.trans('messages.all-tests')}}
			@else
				{{' - '.trans('messages.complete-tests')}}
			@endif

			@if($testCategory)
				{{' - '.TestCategory::find($testCategory)->name}}
			@endif

			@if($testType)
				{{' ('.TestType::find($testType)->name.') '}}
			@endif

			<?php $from = isset($input['start'])?$input['start']:date('01-m-Y');?>
			<?php $to = isset($input['end'])?$input['end']:date('d-m-Y');?>
			@if($from!=$to)
				{{trans('messages.from').' '.$from.' '.trans('messages.to').' '.$to}}
			@else
				{{trans('messages.for').' '.date('d-m-Y')}}
			@endif
		</p>
	</strong>
	<br>
	<table class="table table-bordered">
		<tbody>
			<tr>
			<th>{{ trans('messages.patient-id') }}</th>
			<th>{{ trans('messages.visit-number') }}</th>
			<th>{{ trans('messages.patient-name') }}</th>
			<th>{{trans('messages.specimen-number-title')}}</th>
			<th>{{trans('messages.specimen')}}</th>
			<th>{{trans('messages.lab-receipt-date')}}</th>
			<th>{{ Lang::choice('messages.test', 2) }}</th>
			<th>{{trans('messages.tested-by')}}</th>
			<th>{{trans('messages.test-results')}}</th>
			<th>{{trans('messages.test-remarks')}}</th>
			<th>{{trans('messages.results-entry-date')}}</th>
			<th>{{trans('messages.verified-by')}}</th>
			</tr>
			@forelse($tests as $key => $test)
			<tr>
				<td>{{ $test->visit->patient->id }}</td>
				<td>{{ isset($test->visit->visit_number)?$test->visit->visit_number:$test->visit->id }}</td>
				<td>{{ $test->visit->patient->name }}</td>
				<td>{{ $test->specimen->id }}</td>
				<td>{{ $test->specimen->specimentype->name }}</td>
				<td>{{ $test->specimen->time_accepted }}</td>
				<td>{{ $test->testType->name }}</td>
				<td>{{ $test->testedBy->name or trans('messages.pending') }}</td>
				<td>@foreach($test->testResults as $result)
					<p>{{Measure::find($result->measure_id)->name}}: {{$result->result}}</p>
				@endforeach</td>
				<td>{{ $test->interpretation }}</td>
				<td>{{ $test->time_completed or trans('messages.pending') }}</td>
				<td>{{ $test->verifiedBy->name or trans('messages.verification-pending') }}</td>
			</tr>
			@empty
			<tr><td colspan="12">{{trans('messages.no-records-found')}}</td></tr>
			@endforelse
		</tbody>
	</table>
</div>
</body>
</html>