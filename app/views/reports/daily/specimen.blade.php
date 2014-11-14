@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active"><a href="{{ URL::route('reports.patient.index') }}">{{ trans('messages.reports') }}</a></li>
	  <li class="active">{{ trans('messages.daily-log') }}</li>
	</ol>
</div>
{{ Form::open(array('route' => array('reports.daily.log'), 'class' => 'form-inline', 'role' => 'form')) }}
<div class="table-responsive">
  <table class="table">
    <thead>
    <tr>
        <td>{{ Form::label('from', trans("messages.from")) }}</td>
        <td>
            <input class="form-control standard-datepicker" name="start" type="text" 
                    value="{{ isset($from) ? $from : date('Y-m-d') }}" id="start">
        </td>
        <td>{{ Form::label('to', trans("messages.to")) }}</td>
         <td>
            <input class="form-control standard-datepicker" name="end" type="text" 
                    value="{{ isset($to) ? $to : date('Y-m-d') }}" id="end">
         </td>
        <td>{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
                        array('class' => 'btn btn-info', 'style' => 'width:125px', 'id' => 'filter', 'type' => 'submit')) }}</td>
    </tr>
    <tr>
        <td colspan="2"><label class="radio-inline">
			  {{ Form::radio('records', 'tests', false, array('data-toggle' => 'radio', 'id' => 'tests')) }} {{trans('messages.test-records')}}
			</label></td>
        <td><label class="radio-inline">
			  {{ Form::radio('records', 'patients', false, array('data-toggle' => 'radio', 'id' => 'patients')) }} {{trans('messages.patient-records')}}
			</label></td>
        <td><label class="radio-inline">
			  {{ Form::radio('records', 'rejections', true, array('data-toggle' => 'radio', 'id' => 'rejections')) }} {{trans('messages.rejected-specimen')}}
			</label></td>
		<td>{{Form::submit('Export to Word', array('class' => 'btn btn-success', 'id'=>'word', 'name'=>'word'))}}</td>
    </tr>
    <tr id="sections">
        <td>{{ Form::label('description', trans("messages.test-category")) }}</td>
        <td>{{ Form::select('section_id', array(''=>'Select Lab Section')+$labSections, Request::old('testCategory') ? Request::old('testCategory') : $testCategory, 
					array('class' => 'form-control', 'id' => 'section_id')) }}</td>
		<td></td>
        <td>{{ Form::label('description', trans("messages.test-type")) }}</td>
        <td>{{ Form::select('test_type', array('' => 'Select Test Type'), Request::old('testType') ? Request::old('testType') : $testType, 
					array('class' => 'form-control', 'id' => 'test_type')) }}</td>
     </tr>
</thead>
<tbody>
{{ Form::hidden('test_type_id', Request::old('testType') ? Request::old('testType') : $testType, array('id' => 'test_type')) }}
</tbody>
</table>
{{ Form::close() }}
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.daily-log') }}
	</div>
	<div class="panel-body">

	<!-- if there are search errors, they will show here -->
	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif
  <div id="specimen_records_div">
  @include("reportHeader")
	<strong>
		<p>
			{{trans('messages.rejected-specimen')}} 
			@if($testCategory)
				{{' - '.TestCategory::find($testCategory)->name}}
			@endif
			@if($testType)
				{{' ('.TestType::find($testType)->name.') '}}
			@endif
			@if($from!=$to)
				{{'From '.$from.' To '.$to}}
			@else
				{{'For '.date('d-m-Y')}}
			@endif
		</p>
	</strong>
	<table class="table table-bordered">
		<tbody>
			<th>{{trans('messages.specimen-number-title')}}</th>
			<th>{{trans('messages.specimen')}}</th>
			<th>{{trans('messages.lab-receipt-date')}}</th>
			<th>{{trans('messages.tests')}}</th>
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
</div>

</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		reportScripts();
	});
</script>
@stop