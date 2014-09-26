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
				<td>{{ $test_type->targetTAT }}</td>
			</tr>
			@empty
			<tr><td colspan="13">No records found.</td></tr>
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