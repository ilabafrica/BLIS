@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ trans('messages.reports') }}</li>
	  <li class="active">{{ trans('messages.counts') }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.counts') }}
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
        <td><label class="radio-inline">
			  {{ Form::radio('counts', '1', true, array('data-toggle' => 'radio', 'id' => 'tests_grouped')) }} {{trans('messages.test-count-grouped')}}
			</label></td>
        <td><label class="radio-inline">
			  {{ Form::radio('counts', '2', false, array('data-toggle' => 'radio', 'id' => 'tests_ungrouped')) }} {{trans('messages.test-count-ungrouped')}}
			</label></td>
        <td><label class="radio-inline">
			  {{ Form::radio('counts', '3', false, array('data-toggle' => 'radio', 'id' => 'specimens_grouped')) }} {{trans('messages.specimen-count-grouped')}}
			</label></td>
		<td><label class="radio-inline">
			  {{ Form::radio('counts', '4', false, array('data-toggle' => 'radio', 'id' => 'specimens_ungrouped')) }} {{trans('messages.specimen-count-ungrouped')}}
			</label></td>
		<td><label class="radio-inline">
			  {{ Form::radio('counts', '5', false, array('data-toggle' => 'radio', 'id' => 'doctor_statistics')) }} {{trans('messages.doctor-statistics')}}
			</label></td>
    </tr>
	</thead>
	<tbody>
		
	</tbody>
</table>
{{ Form::close() }}
<div id="tests_grouped_div" style="display:none;"></div>
<div id="specimenChartsDiv" style="display:none;">
<span id="chartContainer"></span>
<span id="rejectionChartContainer"></span>
</div>
<div id="testsChartContainer" style="display:none;"></div>
<div id="tests_ungrouped_div" style="display:none;">
<div class="table-responsive">
  <table class="table table-striped">
    <tbody>
	    <tr>
	    	<th>{{trans('messages.test-type')}}</th>
	    	<th>{{trans('messages.completed')}}</th>
	    	<th>{{trans('messages.pending')}}</th>
	    </tr>
	    {{--*/ $months = Report::getMonths() /*--}}
	    {{--*/ $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] /*--}}
		
	    @forelse($test_types as $test_type)
	    <tr>
	    	<td>{{ $test_type->name }}</td>
	    	<td>{{ Report::CompletedTestCount($test_type->id) }}</td>
	    	<td>{{ Report::PendingTestCount($test_type->id) }}</td>
	    </tr>
	    @empty
	    <tr>
	    	<td colspan="3">{{trans('messages.no-records-found')}}</td>
	    </tr>
	    @endforelse
    </tbody>
  </table>
</div>
</div>
<div id="specimens_grouped_div" style="display:none;"></div>
<div id="specimens_ungrouped_div" style="display:none;">
	<div class="table-responsive">
	  <table class="table table-striped">
	    <tbody>
		    <tr>
		    	<th>{{trans('messages.specimen-type')}}</th>
		    	<th>{{trans('messages.accepted')}}</th>
		    	<th>{{trans('messages.rejected')}}</th>
		    	<th>{{trans('messages.total')}}</th>
		    </tr>
		    @forelse($specimen_types as $specimen_type)
		    <tr>
		    	<td>{{ $specimen_type->name }}</td>
		    	<td>{{ Report::AcceptedSpecimenCount($specimen_type->id) }}</td>
		    	<td>{{ Report::RejectedSpecimenCount($specimen_type->id) }}</td>
		    	<td>{{ Report::AcceptedSpecimenCount($specimen_type->id)+Report::RejectedSpecimenCount($specimen_type->id) }}</td>
		    </tr>
		    @empty
		    <tr>
		    	<td colspan="3">{{trans('messages.no-records-found')}}</td>
		    </tr>
		    @endforelse
	    </tbody>
	  </table>
	</div>
<div id="ungrouped_specimen_chart_div" style="display:none;"></div>
</div>
<div id="doctor_statistics_div" style="display:none;"></div>		
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
	      type: "mscolumn2d",
	      renderAt: "chartContainer",
	      width: "58%",
	      height: "300",
	      dataFormat: "json",
	      dataSource: {
		    "chart": {
		        "caption": "Specimen Counts (Ungrouped)",
		        "subcaption": "In Billion $",
		        "showvalues": "0",
		        "numberprefix": "$",
		        "plotspacepercent": "50",
		        "plotgradientcolor": "",
		        "plotborderalpha": "0",
		        "canvasbordercolor": "#6E98AA",
		        "canvasborderalpha": "25",
		        "canvasborderthickness": "1",
		        "bgalpha": "0",
		        "alternatehgridalpha": "0",
		        "numbersuffix": "B",
		        "divlinecolor": "#6E98AA",
		        "basefontcolor": "#6E98AA",
		        "legendbordercolor": "#6E98AA",
		        "legendshadow": "0",
		        "divlinealpha": "25",
		        "tooltipbordercolor": "#6E98AA",
		        "bordercolor": "#6E98AA",
		        "legendborderalpha": "30",
		        "palettecolors": "#02295B,#FCB63C,#A8B1B8",
		        "showborder": "1"
		    },
		    "categories": [
		        {
		            "category": [<?php
		            			foreach (SpecimenType::all() as $specimen) {
		            				?>
		            				{
					                    "label": "<?php echo $specimen->name; ?>"
					                },
		            				<?php
		            			}
		            	?>
		            ]
		        }
		    ],
		    "dataset": [
		    	<?php
	            	foreach (SpecimenStatus::all() as $status) {
	            		?>
	            		{
	            			"seriesname": "<?php echo $status->name; ?>",
	            			"data": [
	            		<?php
	            		foreach (SpecimenType::all() as $specimen) {
		            		?>
			            		{
				                    "value": "<?php echo Specimen::where('specimen_type_id', '=', $specimen->id)->where('specimen_status_id', '=', $status->id)->count(); ?>",
				                },
		            		<?php
				    	}
				    	?>
				    	 ]
				    	},
				    	 <?php
				    }
	            ?>
		    ]
		}
	 
	  });
	  revenueChart.render("chartContainer");

	  /*Begin rejected specimen chart*/
	  var rejectionChart = new FusionCharts({
	      type: "pie3d",
	      renderAt: "rejectionChartContainer",
	      width: "40%",
	      height: "300",
	      dataFormat: "json",
	      dataSource: {
		    "chart": {
		        "caption": "Accepted/Rejected Specimen",
		        "subcaption": "2014",
		        "startingangle": "120",
		        "showlabels": "0",
		        "showlegend": "1",
		        "showborder": "1",
		        "enablemultislicing": "0",
		        "slicingdistance": "15",
		        "showpercentvalues": "1",
		        "showpercentintooltip": "0"
		    },
		    "data": [<?php
		    		foreach (SpecimenStatus::all() as $status) {
		    			?>
		    			{
				            "label": "<?php echo $status->name; ?>",
				            "value": "<?php echo Specimen::where('specimen_status_id', '=', $status->id)->count(); ?>"
				        },
		    			<?php
		    		}
		    	?>
		    ]
		}
	 
	  });
	  rejectionChart.render("rejectionChartContainer");
	  /*End rejected specimen chart*/

	  /*Begin test counts chart*/
	  var testsChart = new FusionCharts({
	      type: "mscolumn2d",
	      renderAt: "testsChartContainer",
	      width: "98%",
	      height: "300",
	      dataFormat: "json",
	      dataSource: {
		    "chart": {
		        "palette": "3",
		        "caption": "Test Counts (Ungrouped)",
		        "yaxisname": "Units",
		        "showvalues": "0",
		        "numvdivlines": "10",
		        "divlinealpha": "30",
		        "drawanchors": "0",
		        "labelpadding": "10",
		        "yaxisvaluespadding": "10",
		        "useroundedges": "1",
		        "legendborderalpha": "0",
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
		    	<?php
	            	foreach (TestStatus::all() as $status) {
	            		?>
	            		{
	            			"seriesname": "<?php echo $status->name; ?>",
	            			"data": [
	            		<?php
	            		foreach ($months as $month) {
		            		?>
			            		{
				                    "value": "<?php echo Test::where('test_status_id', '=', $status->id)->count(); ?>",
				                },
		            		<?php
				    	}
				    	?>
				    	 ]
				    	},
				    	 <?php
				    }
	            ?>
		    ]
		}
	 
	  });
	  testsChart.render("testsChartContainer");
	  /*End age chart*/

	}); 
</script>
@stop