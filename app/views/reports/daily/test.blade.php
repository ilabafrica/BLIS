@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ trans('messages.reports') }}</li>
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
            {{ Form::text('start', isset($input['from'])?$input['from']:'', 
                            array('class' => 'form-control standard-datepicker')) }}
        </td>
        <td>{{ Form::label('to', trans("messages.to")) }}</td>
         <td>
             {{ Form::text('end', isset($input['to'])?$input['to']:'', 
                            array('class' => 'form-control standard-datepicker')) }}
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
              <input type="checkbox" id="pending" name="pending" value="1" @if(isset($pending)){{"checked='checked'"}}@endif> {{trans('messages.include-pending-tests')}}
			</label>
        </td>
        <td>
        	<label class="checkbox-inline">
              <input type="checkbox" id="all" name="all" value="1" @if(isset($all)){{"checked='checked'"}}@endif> {{trans('messages.include-pending-tests')}}
			</label>
        </td>
    </tr>
    <tr id="sections">
        <td>{{ Form::label('description', trans("messages.test-category")) }}</td>
        <td colspan="2">{{ Form::select('section_id', array(''=>'Select Lab Section')+$labsections, Input::old('section_id'), 
					array('class' => 'form-control', 'id' => 'section_id')) }}</td>
		<td>{{ Form::label('description', trans("messages.test-type")) }}</td>
        <td colspan="2">{{ Form::select('test_type', array('default' => 'Select Test Type'), Input::old('test_type'), 
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
  <div id="chartContainer"></div>
  <div id="genderChartContainer" style="display:none;"></div>
  <div id="rejectionChartContainer" style="display:none;"></div>
  <div id="test_records_div">
  	<table class="table table-bordered">
		<tbody>
			<!-- <th>{{trans('messages.patient-name')}}</th>
			<th>{{trans('messages.age')}}</th>
			<th>{{trans('messages.gender')}}</th> -->

			<th>{{trans('messages.specimen-number-title')}}</th>
			<th>{{trans('messages.specimens')}}</th>
			<th>{{trans('messages.lab-receipt-date')}}</th>
			<th>{{trans('messages.tests')}}</th>
			<th>{{trans('messages.performed-by')}}</th>
			<th>{{trans('messages.test-results')}}</th>
			<th>{{trans('messages.test-remarks')}}</th>
			<th>{{trans('messages.results-entry-date')}}</th>
			<th>{{trans('messages.verified-by')}}</th>
			@forelse($tests as $key => $test)
			<tr>
				<!-- <td>{{ $test->visit->patient->id }}</td>
				<td></td>
				<td>@if($test->visit->patient->gender==0){{ 'M' }} @else {{ 'F' }} @endif</td>
				 -->
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
			<tr><td colspan="13">{{trans('messages.no-records-found')}}</td></tr>
			@endforelse
		</tbody>
	</table>
  </div>
</div>

</div>
	</div>

</div>
@stop