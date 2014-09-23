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
<div id="chartdiv"></div>
</div>
<div id="tests_ungrouped_div"></div>
<div id="specimens_grouped_div"></div>
<div id="specimens_ungrouped_div">
	<div class="table-responsive">
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
<div id="ungrouped_specimen_chart_div"></div>
</div>
<div id="doctor_statistics_div"></div>		
</div>
	</div>

</div>
<!-- Begin FusionCharts scripts -->
{{ HTML::script('FusionCharts/JSClass/FusionCharts.js') }}
<!-- End fusioncharts scripts -->
<script type="text/javascript">
   var chart = new FusionCharts("FusionCharts/Charts/MSColumn2D.swf", "ChartId", "980", "550", "0", "0");
   
   chart.setDataURL("fusion_data/specimen_counts_ungrouped.php");		   
   chart.render("ungrouped_specimen_chart_div");
</script>
@stop