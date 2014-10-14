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
        <td>{{ Form::label('name', trans("messages.from")) }}</td>
        <td>{{ Form::text('from', Input::old('from'), array('class' => 'form-control', 'id' => 'from')) }}</td>
        <td>{{ Form::label('name', trans("messages.to")) }}</td>
        <td>{{ Form::text('to', Input::old('to'), array('class' => 'form-control', 'id' => 'to')) }}</td>
        <td>{{ Form::button("<span class='glyphicon glyphicon-eye-open'></span> ".trans('messages.toggle-graph'), 
			        array('class' => 'btn btn-info', 'id' => 'toggle')) }}</td>
        <td>{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
			        array('class' => 'btn btn-primary', 'style' => 'width:125px', 'id' => 'filter', 'type' => 'submit')) }}</td>
  		<td>{{ Form::button("<span class='glyphicon glyphicon-remove'></span> ".trans('messages.close'), 
			        array('class' => 'btn btn-warning', 'style' => 'width:125px', 'id' => 'close')) }}</td>
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
				    	<th>{{trans('messages.test-type')}}</th>
				    	<th>{{trans('messages.total-specimen')}}</th>
				    	<th>{{trans('messages.positive')}}</th>
				    	<th>{{trans('messages.negative')}}</th>
				    	<th>{{trans('messages.prevalence-rate')}}</th>
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
				    	<td colspan="5">{{trans('messages.no-records-found')}}</td>
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
{{--*/ $months = Report::getMonths() /*--}}
{{--*/ $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] /*--}}
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

   $('#toggle').click(function(){
   		$('#chartContainer').toggle('show');
   });
</script>
@stop