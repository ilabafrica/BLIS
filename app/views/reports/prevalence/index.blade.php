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
  <div id="chartdiv"></div>
  <div id="grid"></div>
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

   var myGrid = new FusionCharts("FusionCharts/Charts/SSGrid.swf", "myGrid1", "900", "400", "0", "1");
	myGrid.setDataURL("FusionCharts/Gallery/Grid/Data.xml");
	//Set Grid specific parameters
	myGrid.addVariable('showPercentValues', '1');
	myGrid.addVariable('showShadow', '1');
	myGrid.render("grid");
</script>
@stop