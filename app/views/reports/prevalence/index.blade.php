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
         <td><button type="submit" class="btn btn-info" style="width:125px;" name="ok" id="ok" onClick="javascript:toggleGraph();"> 
  		  		<i class="icon-filter"></i> Show/Hide Graph
  		  	</button></td>
        <td><button type="submit" class="btn btn-primary" style="width:125px;" name="ok" id="ok" onClick=""> 
  		  		<i class="icon-filter"></i> View
  		  	</button></td>
    </tr>
    <tr>
        <td>{{ Form::label('description', trans("messages.test-category")) }}</td>
         <td>{{ Form::select('section_id', $labsections->lists('name', 'id'), Input::old('section_id'), 
					array('class' => 'form-control', 'id' => 'section_id')) }}</td>
         <td>{{ Form::label('description', trans("messages.test-type")) }}</td>
         <td>{{ Form::select('test_type', array('default' => 'Select Test Type'), Input::old('test_type'), 
					array('class' => 'form-control', 'id' => 'test_type')) }}</td>
         <td><input type="button" class="btn btn-success" style="width:125px;" value="Print" onclick=""></td>
         <td><input type="button" class="btn btn-warning" style="width:125px;" value="Close" onclick=""></td>
     </tr>
</thead>
<tbody>
	
</tbody>
  </table>
  <!-- if there are search errors, they will show here -->
		@if($errors->all())
			<div class="alert alert-danger">
				{{ HTML::ul($errors->all()) }}
			</div>
		@endif
  <div id="chartContainer"></div>
  <div id="grid">
  	<div class="table-responsive">
	  <table class="table table-striped">
	    <tbody>
		    <tr>
		    	<th>Test Type</th>
		    	<th>Total Specimen</th>
		    	<th>Positive</th>
		    	<th>Negative</th>
		    	<th>Prevalence Rate <span class="danger">%</span></th>
		    </tr>
		    @forelse($test_types as $test_type)
		    <tr>
		    	<td>{{ $test_type->name }}</td>
		    	<td>{{ Report::totalSpecimen($test_type->id) }}</td>
		    	<td>{{ Report::positiveSpecimen($test_type->id) }}</td>
		    	<td>{{ Report::negativeSpecimen($test_type->id) }}</td>
		    	<td>{{ round((Report::positiveSpecimen($test_type->id)/Report::totalSpecimen($test_type->id))*100, 2) }}</td>
		    </tr>
		    @empty
		    <tr>
		    	<td colspan="5">No records found.</td>
		    </tr>
		    @endforelse
	    </tbody>
	  </table>
	</div>
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
	      type: "msline",
	      renderAt: "chartContainer",
	      width: "980",
	      height: "500",
	      dataFormat: "json",
	      dataSource: {
	       "chart": {
	        "caption": "Daily Visits",
	        "subcaption": "(from 8/6/2013 to 8/12/2013)",
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
	        "showborder": "0"
	    },
	    "categories": [
	        {
	            "category": [
	                {
	                    "label": "8/6/2006"
	                },
	                {
	                    "label": "8/7/2006"
	                },
	                {
	                    "label": "8/8/2006"
	                },
	                {
	                    "label": "8/9/2006"
	                },
	                {
	                    "label": "8/10/2006"
	                },
	                {
	                    "label": "8/11/2006"
	                },
	                {
	                    "label": "8/12/2006"
	                }
	            ]
	        }
	    ],
	    "dataset": [
	        {
	            "seriesname": "Offline Marketing",
	            "color": "1D8BD1",
	            "anchorbordercolor": "1D8BD1",
	            "anchorbgcolor": "1D8BD1",
	            "data": [
	                {
	                    "value": "1327"
	                },
	                {
	                    "value": "1826"
	                },
	                {
	                    "value": "1699"
	                },
	                {
	                    "value": "1511"
	                },
	                {
	                    "value": "1904"
	                },
	                {
	                    "value": "1957"
	                },
	                {
	                    "value": "1296"
	                }
	            ]
	        },
	        {
	            "seriesname": "Search",
	            "color": "F1683C",
	            "anchorbordercolor": "F1683C",
	            "anchorbgcolor": "F1683C",
	            "data": [
	                {
	                    "value": "2042"
	                },
	                {
	                    "value": "3210"
	                },
	                {
	                    "value": "2994"
	                },
	                {
	                    "value": "3115"
	                },
	                {
	                    "value": "2844"
	                },
	                {
	                    "value": "3576",
	                    "displayvalue": "New listing in Yahoo & Bing",
	                    "showvalue": "1"
	                },
	                {
	                    "value": "1862"
	                }
	            ]
	        },
	        {
	            "seriesname": "Paid Search",
	            "color": "2AD62A",
	            "anchorbordercolor": "2AD62A",
	            "anchorbgcolor": "2AD62A",
	            "data": [
	                {
	                    "value": "850"
	                },
	                {
	                    "value": "1010"
	                },
	                {
	                    "value": "1116"
	                },
	                {
	                    "value": "1234"
	                },
	                {
	                    "value": "1210"
	                },
	                {
	                    "value": "1054"
	                },
	                {
	                    "value": "802"
	                }
	            ]
	        },
	        {
	            "seriesname": "From Mail",
	            "color": "DBDC25",
	            "anchorbordercolor": "DBDC25",
	            "anchorbgcolor": "DBDC25",
	            "data": [
	                {
	                    "value": "541"
	                },
	                {
	                    "value": "781"
	                },
	                {
	                    "value": "920"
	                },
	                {
	                    "value": "754"
	                },
	                {
	                    "value": "840"
	                },
	                {
	                    "value": "893"
	                },
	                {
	                    "value": "451"
	                }
	            ]
	        }
	    ]
	      }
	 
	  });
	  revenueChart.render("chartContainer");
	}); 

   function toggleGraph(){
   	$('#chartdiv').toggle('show');
   }
</script>
@stop