@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.quality-control', 2) }}</li>
	</ol>
</div>
{{ Form::open(array('route' => array('reports.qualityControl'), 'id' => 'qc', 'method' => 'post')) }}
<div class="container-fluid">
  	<div class="row report-filter">
        <div class="col-md-3">
	        <div class="col-md-2">
	        	{{ Form::label('start_date', trans("messages.from")) }}
	        </div>
	        <div class="col-md-10">
	            {{ Form::text('start_date', isset($input['start_date'])?$input['start_date']:date('Y-m-d'), 
	                array('class' => 'form-control standard-datepicker')) }}
	        </div>
        </div>
        <div class="col-md-3">
	        <div class="col-md-2">
	        	{{ Form::label('end_date', trans("messages.to")) }}
	        </div>
	        <div class="col-md-10">
	            {{ Form::text('end_date', isset($input['end_date'])?$input['end_date']:date('Y-m-d'), 
	                array('class' => 'form-control standard-datepicker')) }}
	        </div>
        </div>
        <div class="col-md-4">
	        <div class="col-md-3">
	        	{{ Form::label('control', Lang::choice('messages.control',1)) }}
	        </div>
	        <div class="col-md-9">
	            {{ Form::select('control', array(null => '')+ $control->lists('name', 'id'),
	            	isset($input['control'])?$input['control']:0, array('class' => 'form-control')) }}
	        </div>
        </div>
        <div class="col-md-2">
        	{{Form::submit(trans('messages.view'), 
	        	array('class' => 'btn btn-info', 'id'=>'filter', 'name'=>'filter'))}}
        </div>
  	</div>
</div>
{{ Form::close() }}
<br />
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span> {{ trans('messages.controlresults') }}
	</div>

	<div class="panel-body">
	<!-- if there are search errors, they will show here -->
		@include("reportHeader")
	</div>
		<div id="test_records_div">
			<table class="table table-bordered">
				<tbody>
					<tr>
						<th>{{ trans('messages.date-performed')}}</th>
						@foreach($control->controlMeasures as $controlMeasure)
							<th> {{ $controlMeasure->name . ' ('. $controlMeasure->controlMeasureRanges->first()->getRangeUnit() . ')' }} </th>
						@endforeach
					</tr>
					@foreach($controlTests as $key => $controlTest)
						<tr>
							<td>{{ $controlTest->created_at }} </td>
							@foreach($controlTest->controlResults as $controlResult)
							<td>{{ $controlResult->results}}</td>
							@endforeach
						</tr>
					@endforeach
				</tbody>
			</table>
			{{ $leveyJennings }}
		</div>
</div>

@stop