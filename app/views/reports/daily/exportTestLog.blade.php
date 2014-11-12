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
@include("reportHeader")
<div id="content">
<strong><p>{{trans('messages.test-records')}} @if($from!=$to){{'From '.$from.' To '.$to}}@else{{'For '.date('d-m-Y')}}@endif</p></strong>
	<br>
	<table class="table table-bordered">
		<tbody>
			<th>{{trans('messages.specimen-number-title')}}</th>
			<th>{{trans('messages.specimen')}}</th>
			<th>{{trans('messages.lab-receipt-date')}}</th>
			<th>{{trans('messages.tests')}}</th>
			<th>{{trans('messages.tested-by')}}</th>
			<th>{{trans('messages.test-results')}}</th>
			<th>{{trans('messages.test-remarks')}}</th>
			<th>{{trans('messages.results-entry-date')}}</th>
			<th>{{trans('messages.verified-by')}}</th>
			@forelse($tests as $key => $test)
			<tr>
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
			<tr><td colspan="9">{{trans('messages.no-records-found')}}</td></tr>
			@endforelse
		</tbody>
	</table>
</div>
</body>
</html>