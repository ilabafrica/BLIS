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
				    {{--*/ $months = Report::getMonths() /*--}}
				    {{--*/ $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] /*--}}
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
	var info = JSON.stringify(<?php echo $test_types; ?>); 
	console.log(info);
	FusionCharts.ready(function(){
	    var revenueChart = new FusionCharts({
	      type: "msline",
	      renderAt: "chartContainer",
	      width: "98%",
	      height: "500",
	      dataFormat: "json",
	      dataSource: {
	       "chart": {
	        "caption": "Prevalence Rates",
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
	            <?php
	            	foreach ($months as $month) {
	            		 echo $month.",";}
	            ?>
	            ]
	        }
	    ],
	    "dataset": [
	    	<?php
            	foreach ($test_types as $test_type) {
            		?>
            		{
            			"seriesname": "<?php echo $test_type->name; ?>",
            			"data": [
            		<?php
            		foreach ($months as $month) {
	            		?>
		            		{
			                    "value": "<?php echo round((Report::positiveSpecimen($test_type->id)/Report::totalSpecimen($test_type->id))*100, 2); ?>",
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
	}); 

   function toggleGraph(){
   	$('#chartContainer').toggle('show');
   }
</script>
@stop