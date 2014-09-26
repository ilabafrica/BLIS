@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ trans('messages.reports') }}</li>
	  <li class="active">{{ trans('messages.daily-log') }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.daily-log') }}
	</div>
	<div class="panel-body">
	{{ Form::open(array('url' => 'foo/bar', 'class' => 'form-inline', 'role' => 'form')) }}
	<div class="table-responsive">
  <table class="table">
    <thead>
    <tr>
        <td>{{ Form::label('from', trans("messages.from")) }}</td>
        <td>
            <input type='text' class="form-control" id='from' value='{{ date('d-m-Y') }}' />
        </td>
        <td>{{ Form::label('to', trans("messages.to")) }}</td>
         <td>
             <input type='text' class="form-control" id='to' value='{{ date('d-m-Y') }}' />
         </td>
        <td>{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
                        array('class' => 'btn btn-info', 'style' => 'width:125px', 'id' => 'filter', 'type' => 'submit')) }}</td>
    </tr>
    <tr>
        <td colspan="2"><label class="radio-inline">
			  {{ Form::radio('records', '1', true, array('data-toggle' => 'radio', 'id' => 'tests')) }} {{trans('messages.test-records')}}
			</label></td>
        <td><label class="radio-inline">
			  {{ Form::radio('records', '2', false, array('data-toggle' => 'radio', 'id' => 'patients')) }} {{trans('messages.patient-records')}}
			</label></td>
        <td colspan="2"><label class="radio-inline">
			  {{ Form::radio('records', '3', false, array('data-toggle' => 'radio', 'id' => 'specimens')) }} {{trans('messages.rejected-specimen')}}
			</label></td>
    </tr>
    <tr id="sections">
        <td>{{ Form::label('description', trans("messages.test-category")) }}</td>
        <td>{{ Form::select('section_id', array(''=>'Select Lab Section')+$labsections, Input::old('section_id'), 
					array('class' => 'form-control', 'id' => 'section_id')) }}</td>
		<td></td>
        <td>{{ Form::label('description', trans("messages.test-type")) }}</td>
        <td>{{ Form::select('test_type', array('default' => 'Select Test Type'), Input::old('test_type'), 
					array('class' => 'form-control', 'id' => 'test_type')) }}</td>
     </tr>
</thead>
<tbody>
	
</tbody>
  </table>
  {{ Form::close() }}
  <div id="chartdiv" style="display:none;"></div>
  <div id="test_records_div">
  	<table class="table">
		<tbody>
			<th>Patient</th>
			<th>Age</th>
			<th>Sex</th>
			<th>Specimen</th>
			<th>Receipt date</th>
			<th>Comments</th>
			<th>Tests</th>
			<th>Done by</th>
			<th>Results</th>
			<th>Remarks</th>
			<th>Entry date</th>
			<th>Verifier</th>
			@forelse($tests as $key => $test)
			<tr>
				<td>{{ $test->visit->patient->id }}</td>
				<td>{{ Report::dateDiff($test->visit->patient->dob) }}</td>
				<td>@if($test->visit->patient->gender==0){{ 'M' }} @else {{ 'F' }} @endif</td>
				<td>{{ $test->specimen->specimentype->name }}</td>
				<td>{{ $test->specimen->time_accepted }}</td>
				<td>{{ $test->visit->patient->id }}</td>
				<td>{{ $test->testType->name }}</td>
				<td>{{ $test->testedBy->name or trans('messages.unknown') }}</td>
				<td>@foreach($test->testResults as $result)
					<p>{{Measure::find($result->measure_id)->name}}: {{$result->result}}</p>
				@endforeach</td>
				<td>{{ $test->interpretation }}</td>
				<td>{{ $test->time_completed or trans('messages.pending') }}</td>
				<td>{{ $test->verifiedBy->name or trans('messages.verification-pending') }}</td>
			</tr>
			@empty
			<tr><td colspan="13">No records found.</td></tr>
			@endforelse
		</tbody>
	</table>
  </div>
  <div id="patient_records_div" style="display:none;">
  	<table class="table">
		<tbody>
			<th>Patient Number</th>
			<th>Age</th>
			<th>Sex</th>
			<th>Specimen Number</th>
			<th>Type</th>
			<th>Tests</th>
			@forelse($visits as $key => $visit)
			{{--*/ $tests = Visit::with('tests')->find($visit->id)->tests /*--}}
			{{--*/ $specimen = Test::with('specimen')->find($test->id)->specimen /*--}}
			<tr>
				<td>{{ $visit->patient->id }}</td>
				<td>{{ PatientReportController::dateDiff($visit->patient->dob) }}</td>
				<td>@if($visit->patient->gender==0){{ 'M' }} @else {{ 'F' }} @endif</td>
				<td>{{ $test->specimen->id }}</td>
				<td>{{ $test->specimen->specimenType->name }}</td>
				<td>{{ $test->testType->name }}</td>
			</tr>
			@empty
			<tr><td colspan="13">{{ date('Y-m-d') }}</td></tr>
			@endforelse
		</tbody>
	</table>
  </div>
  <div id="rejected_specimen_div" style="display:none">
  	<table class="table">
		<tbody>
			<th>Specimen ID</th>
			<th>Specimen Type</th>
			<th>Receipt date</th>
			<th>Tests</th>
			<th>Lab Section</th>
			<th>Reason for Rejection</th>
			<th>Talked To</th>
			<th>Date Rejected</th>
			@forelse($specimens as $key => $specimen)
			<tr>
				<td>{{ $specimen->id }}</td>
				<td>{{ $specimen->specimenType->name }}</td>
				<td>{{ $test->visit->patient->id }}</td>
				<td>{{ $test->specimen->specimentype->name }}</td>
				<td>{{ $test->specimen->time_accepted }}</td>
				<td>{{ $test->visit->patient->id }}</td>
				<td>{{ $test->testType->name }}</td>
				<td>{{ $test->testedBy->name or trans('messages.unknown') }}</td>
			</tr>
			@empty
			<tr><td colspan="13">{{ date('Y-m-d') }}</td></tr>
			@endforelse
		</tbody>
	</table>
  </div>
</div>

		<!-- if there are search errors, they will show here -->
		@if($errors->all())
			<div class="alert alert-danger">
				{{ HTML::ul($errors->all()) }}
			</div>
		@endif
		<!-- <div class="row">
			<div class="col-md-8">
		{{ Form::open(array('route' => 'reports.daily.search', 'id' => 'form-search-daily-log')) }}
		  	<div class="form-group">
				{{ Form::label('name', trans("messages.from")) }}
				{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('description', trans("messages.to")) }}</label>
				{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
			</div>
			
			<div class="form-group">
				{{ Form::label('description', trans("messages.test-category")) }}</label>
				{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
			</div>
			<div class="form-group actions-row">
				{{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.submit'), 
					array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
			</div>
		{{ Form::close() }}
		</div>
		<div class="col-md-4">
		<div class="alert alert-info" style="float:right" role="alert"><strong>Tips</strong>
		<p>{{ trans('messages.prevalence-rates-report-tip') }}</p>
		</div></div> -->
		
</div>
	</div>

</div>
<!-- Begin FusionCharts scripts -->
{{ HTML::script('FusionCharts/JSClass/FusionCharts.js') }}
<!-- End fusioncharts scripts -->
<script type="text/javascript">
   var chart = new FusionCharts("FusionCharts/Charts/MSLine.swf", "ChartId", "980", "550", "0", "0");
   chart.setDataURL("FusionCharts/Gallery/Data/MSLine.xml");		   
   chart.render("chartdiv");
</script>
@stop