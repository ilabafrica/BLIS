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
        <td class="inline">{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
                        array('class' => 'btn btn-info', 'style' => 'width:125px', 'id' => 'filter', 'type' => 'submit')) }}
        </td>
        <td>{{Form::submit('Export to Word', array('class' => 'btn btn-success', 'id'=>'word', 'name'=>'word'))}}</td>
    </tr>
    <tr>
        <td><label class="radio-inline">
			  {{ Form::radio('records', 'tests', true, array('data-toggle' => 'radio', 'id' => 'tests')) }} {{trans('messages.test-records')}}
			</label></td>
        <td><label class="radio-inline">
			  {{ Form::radio('records', 'patients', false, array('data-toggle' => 'radio', 'id' => 'patients')) }} {{trans('messages.patient-records')}}
			</label></td>
        <td><label class="radio-inline">
			  {{ Form::radio('records', 'rejections', false, array('data-toggle' => 'radio', 'id' => 'specimens')) }} {{trans('messages.rejected-specimen')}}
			</label></td>
		<td colspan="2">
        	<label class="checkbox-inline">
              <input type="checkbox" id="pending" name="pending" value="1" @if(isset($pending)){{"checked='checked'"}}@endif> {{trans('messages.pending-only')}}
			</label>
        </td>
        <td>
        	<label class="checkbox-inline">
              <input type="checkbox" id="all" name="all" value="1" @if(isset($all)){{"checked='checked'"}}@endif> {{trans('messages.all-tests')}}
			</label>
        </td>
    </tr>
    <tr id="sections">
        <td>{{ Form::label('description', trans("messages.test-category")) }}</td>
        <td colspan="2">{{ Form::select('section_id', array(''=>'Select Lab Section')+$labsections, Input::old('section_id'), 
					array('class' => 'form-control', 'id' => 'section_id')) }}</td>
		<td>{{ Form::label('description', trans("messages.test-type")) }}</td>
        <td colspan="2">{{ Form::select('test_type', array('' => 'Select Test Type'), Input::old('test_type'), 
					array('class' => 'form-control', 'id' => 'test_type')) }}</td>
     </tr>
</thead>
<tbody>
	
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
  <div id="test_records_div">
  @include("reportHeader")
	<strong>
		<p>
			{{trans('messages.test-records')}} @if($from!=$to)
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