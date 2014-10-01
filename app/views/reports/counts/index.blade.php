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
<div id="tests_grouped_div"  style="display:none;">
<div class="table-responsive">
  <table class="table table-striped">
    <tbody>
	    <tr>
	    	<th>Test Types</th>
	    	<th>Completed</th>
	    	<th>Pending</th>
	    </tr>
	    {{--*/ $months = Report::getMonths() /*--}}
	    {{--*/ $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] /*--}}
		
	    @forelse($test_types as $test_type)
	    <tr>
	    	<td>{{ $test_type->name }}</td>
	    	<td>{{ CountReportController::CompletedTestCount($test_type->id) }}</td>
	    	<td>{{ CountReportController::PendingTestCount($test_type->id) }}</td>
	    </tr>
	    @empty
	    <tr>
	    	<td colspan="3">No records found.</td>
	    </tr>
	    @endforelse
    </tbody>
  </table>
</div>
</div>
<div id="chartContainer" style="display:none;"></div>
<div id="testsChartContainer" style="display:none;"></div>
<div id="tests_ungrouped_div" style="display:none;"></div>
<div id="specimens_grouped_div" style="display:none;"></div>
<div id="specimens_ungrouped_div" style="display:none;">
	<div class="table-responsive" style="display:none;">
	  <table class="table table-striped">
	    <tbody>
		    <tr>
		    	<th>Specimen Types</th>
		    	<th>Accepted</th>
		    	<th>Rejected</th>
		    </tr>
		    @forelse($specimen_types as $specimen_type)
		    <tr>
		    	<td>{{ $specimen_type->name }}</td>
		    	<td>{{ CountReportController::AcceptedSpecimenCount($specimen_type->id) }}</td>
		    	<td>{{ CountReportController::RejectedSpecimenCount($specimen_type->id) }}</td>
		    </tr>
		    @empty
		    <tr>
		    	<td colspan="3">No records found.</td>
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
	      width: "98%",
	      height: "500",
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
        "showborder": "0"
    },
    "categories": [
        {
            "category": [
                {
                    "label": "iPhone"
                },
                {
                    "label": "iPad"
                },
                {
                    "label": "Mac"
                },
                {
                    "label": "iPod & iTunes"
                }
            ]
        }
    ],
    "dataset": [
        {
            "seriesname": "2011",
            "visible": "0",
            "data": [
                {
                    "value": "47.06"
                },
                {
                    "value": "20.36"
                },
                {
                    "value": "28.27"
                },
                {
                    "value": "35.16 "
                }
            ]
        },
        {
            "seriesname": "2012",
            "visible": "0",
            "data": [
                {
                    "value": "40.48"
                },
                {
                    "value": "32.42"
                },
                {
                    "value": "20.36"
                },
                {
                    "value": "31.3"
                }
            ]
        },
        {
            "seriesname": "2013",
            "data": [
                {
                    "value": "42.36"
                },
                {
                    "value": "20.67"
                },
                {
                    "value": "25.3"
                },
                {
                    "value": "22.5"
                }
            ]
        }
    ]
}
	 
	  });
	  revenueChart.render("chartContainer");

	  /*Begin test counts chart*/
	  var testsChart = new FusionCharts({
	      type: "mscolumn2d",
	      renderAt: "testsChartContainer",
	      width: "98%",
	      height: "500",
	      dataFormat: "json",
	      dataSource: {
		    "chart": {
		        "caption": "Test Counts (Ungrouped)",
		        "showlabels": "1",
		        "showvalues": "1",
		        "decimals": "0",
		        "numberprefix": "$",
		        "placevaluesinside": "0",
		        "rotatevalues": "1",
		        "bgcolor": "FFFFFF",
		        "legendshadow": "0",
		        "legendborderalpha": "50",
		        "canvasborderthickness": "1",
		        "canvasborderalpha": "50",
		        "palettecolors": "#AFD8F8,#F6BD0F,#8BBA00",
		        "showBorder": "0"
		    },
		    "categories": [
		        {
		            "category": [
		                {
		                    "label": "Austria"
		                },
		                {
		                    "label": "Brazil"
		                },
		                {
		                    "label": "France"
		                },
		                {
		                    "label": "Italy"
		                },
		                {
		                    "label": "USA"
		                }
		            ]
		        }
		    ],
		    "dataset": [
		        {
		            "seriesname": "2011",
		            "data": [
		                {
		                    "value": "25601.34"
		                },
		                {
		                    "value": "20148.82"
		                },
		                {
		                    "value": "17372.76"
		                },
		                {
		                    "value": "35407.15"
		                },
		                {
		                    "value": "38105.68"
		                }
		            ]
		        },
		        {
		            "seriesname": "2012",
		            "data": [
		                {
		                    "value": "57401.85"
		                },
		                {
		                    "value": "41941.19"
		                },
		                {
		                    "value": "45263.37"
		                },
		                {
		                    "value": "117320.16"
		                },
		                {
		                    "value": "114845.27"
		                }
		            ]
		        },
		        {
		            "seriesname": "2013",
		            "data": [
		                {
		                    "value": "45000.65"
		                },
		                {
		                    "value": "44835.76"
		                },
		                {
		                    "value": "18722.18"
		                },
		                {
		                    "value": "77557.31"
		                },
		                {
		                    "value": "92633.68"
		                }
		            ]
		        }
		    ]
		}
	 
	  });
	  testsChart.render("testsChartContainer");
	  /*End age chart*/

	}); 
</script>
@stop