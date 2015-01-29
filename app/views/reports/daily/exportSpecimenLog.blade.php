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
	<strong>
		<p>
			{{trans('messages.rejected-specimen')}} 
			@if($testCategory)
				{{' - '.TestCategory::find($testCategory)->name}}
			@endif
			@if($testType)
				{{' ('.TestType::find($testType)->name.') '}}
			@endif
			<?php $from = isset($input['start'])?$input['start']:date('Y-m-d'); ?>
			<?php $to = isset($input['end'])?$input['end']:date('Y-m-d'); ?>
			@if($from)
				{{trans('messages.for').' '.$from}}
			@else
				{{trans('messages.for').' '.date('d-m-Y')}}
			@endif
		</p>
	</strong>
	<br>
	<table class="table table-bordered">
		<tbody>
			<th>{{trans('messages.specimen-number-title')}}</th>
			<th>{{trans('messages.specimen')}}</th>
			<th>{{trans('messages.lab-receipt-date')}}</th>
			<th>{{ Lang::choice('messages.test', 2) }}</th>
			<th>{{trans('messages.test-category')}}</th>
			<th>{{trans('messages.rejection-reason-title')}}</th>
			<th>{{trans('messages.reject-explained-to')}}</th>
			<th>{{trans('messages.date-rejected')}}</th>
			@forelse($specimens as $specimen)
			<tr>
				<td>{{ $specimen->id }}</td>
				<td>{{ $specimen->specimenType->name }}</td>
				<td>{{ $specimen->test->time_created }}</td>
				<td>{{ $specimen->test->testType->name }}</td>
				<td>{{ $specimen->test->testType->testCategory->name }}</td>
				<td>{{ $specimen->rejectionReason->reason }}</td>
				<td>{{ $specimen->reject_explained_to }}</td>
				<td>{{ $specimen->time_rejected }}</td>
			</tr>
			@empty
			<tr><td colspan="8">{{trans('messages.no-records-found')}}</td></tr>
			@endforelse
		</tbody>
	</table>
</div>
</body>
</html>