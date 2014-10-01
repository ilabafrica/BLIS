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

	<!-- if there are search errors, they will show here -->
	@if($errors->all())
		<div class="alert alert-danger">
			{{ HTML::ul($errors->all()) }}
		</div>
	@endif
		
	{{ Form::open(array('url' => 'foo/bar', 'class' => 'form-inline', 'role' => 'form')) }}
	<div class="table-responsive">
  <table class="table">
    <thead>
    <tr>
        <td>{{ Form::label('from', trans("messages.from")) }}</td>
        <td>
            {{ Form::text('from', Input::old('from'), array('class' => 'form-control', 'id' => 'from')) }}
        </td>
        <td>{{ Form::label('to', trans("messages.to")) }}</td>
         <td>
             {{ Form::text('to', Input::old('to'), array('class' => 'form-control', 'id' => 'to')) }}
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
  <div id="chartContainer"></div>
  <div id="genderChartContainer" style="display:none;"></div>
  <div id="rejectionChartContainer" style="display:none;"></div>
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
				<td>{{ Report::dateDiff($visit->patient->dob) }}</td>
				<td>@if($visit->patient->gender==0){{ 'M' }} @else {{ 'F' }} @endif</td>
				<td>{{ $test->specimen->id }}</td>
				<td>{{ $test->specimen->specimenType->name }}</td>
				<td>{{ $test->testType->name }}</td>
			</tr>
			@empty
			<tr><td colspan="13">No records found.</td></tr>
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
			<tr><td colspan="13">No records found.</td></tr>
			@endforelse
		</tbody>
	</table>
  </div>
</div>

</div>
	</div>

</div>
<!-- Begin FusionCharts scripts -->
{{ HTML::script('fusioncharts/js/fusioncharts.js') }}
{{ HTML::script('fusioncharts/js/themes/fusioncharts.theme.ocean.js') }}
<!-- End fusioncharts scripts -->
<script type="text/javascript">
	FusionCharts.ready(function(){
	    var revenueChart = new FusionCharts({
	      type: "pie2d",
	      renderAt: "chartContainer",
	      width: "98%",
	      height: "400",
	      dataFormat: "json",
	      dataSource: {
		    "chart": {
		        "caption": "Daily Tests Log by Lab Section",
		        "subcaption": "From: | To:",
		        "numberprefix": "",
		        "plotgradientcolor": "",
		        "bgcolor": "FFFFFF",
		        "showalternatehgridcolor": "0",
		        "showplotborder": "0",
		        "divlinecolor": "CCCCCC",
		        "showvalues": "1",
		        "showcanvasborder": "0",
		        "canvasbordercolor": "CCCCCC",
		        "canvasborderthickness": "1",
		        "yaxismaxvalue": "30000",
		        "captionpadding": "30",
		        "linethickness": "3",
		        "sshowanchors": "0",
		        "yaxisvaluespadding": "15",
		        "showlegend": "1",
		        "use3dlighting": "0",
		        "showshadow": "0",
		        "legendshadow": "0",
		        "legendborderalpha": "0",
		        "showBorder": "1",
		        "palettecolors": "#EED17F,#97CBE7,#074868,#B0D67A,#2C560A,#DD9D82"
		    },
		    "data": [<?php foreach ($labsections as $labsection) { ?>
		    	{
		            "label": "<?php echo $labsection; ?>",
		            "value": "<?php echo Report::logTestsByLabSection($labsection); ?>"
		        },
			        <?php
		    } ?>
		    ]
		}
	 
	  });
	  revenueChart.render("chartContainer");

	  /*Begin gender chart*/
	  var genderChart = new FusionCharts({
	      type: "pie2d",
	      renderAt: "genderChartContainer",
	      width: "98%",
	      height: "400",
	      dataFormat: "json",
	      dataSource: {
		    "chart": {
		        "caption": "Patients Chart by Gender",
		        "showpercentageinlabel": "1",
		        "showvalues": "0",
		        "showlabels": "0",
		        "showlegend": "1",
		        "showBorder": "1",
		        "bgcolor": "FFFFFF"
		    },
		    "data": [<?php
		    		foreach ($gender = Report::getPatientsGender() as $sex) { ?>
		    			{
				            "value": "<?php echo Report::logPatientsByGender($sex) ?>",
				            "label": "<?php if($sex=='0'){echo 'Male';}else{ echo 'Female';} ?>"
				        },
		    	<?php
		    		}
		    	?>
		    ]
		}
	 
	  });
	  genderChart.render("genderChartContainer");
	  /*End age chart*/

	  /*Begin rejection reasons chart*/
	  var rejectionChart = new FusionCharts({
	      type: "pie3d",
	      renderAt: "rejectionChartContainer",
	      width: "98%",
	      height: "400",
	      dataFormat: "json",
	      dataSource: {
		    "chart": {
		        "caption": "Specimen rejection chart",
		        "subcaption": "For 2013",
		        "showvalues": "1",
		        "showpercentvalues": "1",
		        "showpercentintooltip": "0",
		        "bgcolor": "#FFFFFF",
		        "basefontcolor": "#400D1B",
		        "showshadow": "0",
		        "animation": "0",
		        "showBorder": "1",
		        "palettecolors": "#BE3243,#986667,#BE6F71,#CB999A,#DFC0B1,#E0D0D0"
		    },
		    "data": [
		        {
		            "label": "Twitter",
		            "value": "78242"
		        },
		        {
		            "label": "Facebook",
		            "value": "75223"
		        },
		        {
		            "label": "LinkedIn",
		            "value": "30343"
		        },
		        {
		            "label": "Pinterest",
		            "value": "22343"
		        },
		        {
		            "label": "Tumblr",
		            "value": "13343"
		        },
		        {
		            "label": "Others",
		            "value": "11343"
		        }
		    ]
		}
	 
	  });
	  rejectionChart.render("rejectionChartContainer");
	  /*End rejection reasons chart*/
	}); 

   function toggleGraph(){
   	$('#chartContainer').toggle('show');
   }
</script>
@stop