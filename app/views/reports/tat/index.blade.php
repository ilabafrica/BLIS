@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ trans('messages.reports') }}</li>
	  <li class="active">{{ trans('messages.prevalence-rates-report') }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.prevalence-rates-report') }}
	</div>
	<div class="panel-body">
	<!-- if there are search errors, they will show here -->
	@if($errors->all())
		<div class="alert alert-danger">
			{{ HTML::ul($errors->all()) }}
		</div>
	@endif
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
         <td><button type="submit" class="btn btn-info" style="width:125px;" name="ok" id="ok" onClick=""> 
  		  		<i class="icon-filter"></i> View
  		  	</button></td>
        <td><button type="submit" class="btn btn-warning" style="width:125px;" name="ok" id="ok" onClick=""> 
  		  		<i class="icon-filter"></i> Close
  		  	</button></td>
    </tr>
    <tr>
        <td>{{ Form::label('description', trans("messages.test-category")) }}</td>
         <td>{{ Form::select('section_id', array('default' => 'Select Lab Section'), Input::old('section_id'), 
					array('class' => 'form-control')) }}</td>
         <td>{{ Form::label('test_type', trans("messages.test-type")) }}</td>
         <td>{{ Form::select('test_type', array('default' => 'Select Test Type'), Input::old('test_type'), 
					array('class' => 'form-control')) }}</td>
         <td>{{ Form::label('interval', trans("messages.interval")) }}</td>
         <td>{{ Form::select('interval', array('M' => 'Monthly', 'W' => 'Weekly', 'D' => 'Daily'), Input::old('interval'), 
					array('class' => 'form-control')) }}</td>
     </tr>
</thead>
<tbody>
	
</tbody>
  </table>
  <div id="chartContainer"></div>
  <div id="chartdivs">
  	<table class="table">
		<tbody>
			<th>Expected TAT</th>
			<th>Waiting Time</th>
			<th>Actual TAT</th>
			@forelse($test_types as $test_type)
			<tr>
				<td>{{ $test_type->targetTAT }}</td>
				<td>{{ Report::waitingTime($test_type->id) }}</td>
				<td>{{ Report::actualTurnAroundTime($test_type->id) }}</td>
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
{{--*/ $months = Report::getMonths() /*--}}
<!-- Begin FusionCharts scripts -->
{{ HTML::script('fusioncharts/js/fusioncharts.js') }}
{{ HTML::script('fusioncharts/js/themes/fusioncharts.theme.ocean.js') }}
<!-- End fusioncharts scripts -->
<script type="text/javascript">
	FusionCharts.ready(function(){
	    var revenueChart = new FusionCharts({
	      type: "msline",
	      renderAt: "chartContainer",
	      width: "98%",
	      height: "400",
	      dataFormat: "json",
	      dataSource: {
		    "chart": {
		        "caption": "Turnaround Time",
		        "subcaption": "Monthly view (from 08/02/2014 to 07/10/2014)",
		        "linethickness": "1",
		        "showvalues": "0",
		        "formatnumberscale": "0",
		        "anchorradius": "2",
		        "divlinecolor": "666666",
		        "divlinealpha": "30",
		        "divlineisdashed": "1",
		        "labelstep": "2",
		        "bgcolor": "FFFFFF",
		        "showalternatehgridcolor": "0",
		        "labelpadding": "10",
		        "canvasborderthickness": "1",
		        "legendiconscale": "1.5",
		        "legendshadow": "0",
		        "legendborderalpha": "0",
		        "canvasborderalpha": "50",
		        "numvdivlines": "5",
		        "vdivlinealpha": "20",
		        "showborder": "1"
		    },
		    "categories": [
		        {
		            "category": [
		            <?php
		            	foreach ($months as $month) {
		            		 echo $month.",";}
		            ?>
		            ]
		        }
		    ],
		    "dataset": [
		        {
		            "seriesname": "Waiting Time",
		            "color": "1D8BD1",
		            "anchorbordercolor": "1D8BD1",
		            "anchorbgcolor": "1D8BD1",
		            "data": [<?php
		            		foreach ($months as $month) {
		            			?>
		            			{
				                    "value": "<?php echo Report::totalWaitingTime(); ?>"
				                },
		            			<?php
		            		}
		            	?>
		            ]
		        },
		        {
		            "seriesname": "Actual TAT",
		            "color": "F1683C",
		            "anchorbordercolor": "F1683C",
		            "anchorbgcolor": "F1683C",
		            "data": [<?php
		            		foreach ($months as $month) {
		            			?>
		            			{
				                    "value": "<?php echo Report::totalActualTurnAroundTime(); ?>"
				                },
		            			<?php
		            		}
		            	?>
		            ]
		        },
		        {
		            "seriesname": "Expected TAT",
		            "color": "2AD62A",
		            "anchorbordercolor": "2AD62A",
		            "anchorbgcolor": "2AD62A",
		            "data": [<?php
		            		foreach ($months as $month) {
		            			?>
		            			{
				                    "value": "<?php echo Report::totalExpectedTurnAroundTime(); ?>"
				                },
		            			<?php
		            		}
		            	?>
		            ]
		        }
		    ]
		}
	 
	  });
	  revenueChart.render("chartContainer");

	  
	}); 

   function toggleGraph(){
   	$('#chartContainer').toggle('show');
   }
</script>
@stop