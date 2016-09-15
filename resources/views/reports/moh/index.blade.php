@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li><a href="{{{URL::route('reports.patient.index')}}}">{{ trans_choice('messages.report',2) }}</a></li>
	  <li class="active">{{ trans('messages.moh-706') }}</li>
	</ol>
</div>
<div class='container-fluid'>
    {{ Form::open(array('route' => array('reports.aggregate.moh706'), 'class' => 'form-inline')) }}
    <div class='row'>
    	<div class="col-sm-4">
	    	<div class="row">
				<div class="col-sm-2">
				    {{ Form::label('start', trans('messages.from')) }}
				</div>
				<div class="col-sm-2">
				    {{ Form::text('start', $from?$from:date('Y-m-01'),array('class' => 'form-control standard-datepicker')) }}
		        </div>
			</div>
		</div>
		<div class="col-sm-4">
	    	<div class="row">
				<div class="col-sm-2">
				    {{ Form::label('end', trans('messages.to')) }}
				</div>
				<div class="col-sm-2">{{ Form::text('end', $end?$end:date('Y-m-d'),array('class' => 'form-control standard-datepicker')) }}
		        </div>
			</div>
		</div>
		<div class="col-sm-4">
	    	<div class="row">
				<div class="col-sm-3">
				  	{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
		                array('class' => 'btn btn-info', 'id' => 'filter', 'type' => 'submit')) }}
		        </div>
		        <div class="col-sm-1">
					{{Form::submit('Export to Excel', 
			    		array('class' => 'btn btn-success', 'id'=>'excel', 'name'=>'excel'))}}
				</div>
			</div>
		</div>
	</div>
	{{ Form::close() }}
</div>
<br />
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.moh-706') }}
	</div>
	<div class="panel-body">
	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif	
		<table width="100%">
			<thead>
	            <tr>
	            	<td colspan="3" style="text-align:center;">
	                    <strong><p>{{ strtoupper(trans_choice('messages.moh', 1)) }}<br>
	                    {{ strtoupper(trans_choice('messages.lab-tests-data-report', 1)) }}<br></p></strong>
	            	</td>
	            </tr>
            </thead>
		</table>
		<div class="table-responsive">
			<div class='container-fluid'>
				<strong>{{ trans_choice('messages.facility', 1) }}: </strong><u>{{ strtoupper(Config::get('blis.organization')) }}</u><strong> {{ trans_choice('messages.reporting-period', 1) }} {{ trans_choice('messages.begin-end', 1) }}: </strong><u>{{ $from }}</u>
				<strong> {{ trans_choice('messages.begin-end', 2) }}: </strong><u>{{ $end }}</u><strong> {{ trans_choice('messages.affiliation', 1) }}: </strong><u>{{ trans_choice('messages.gok', 1) }}: </u>
				<br />
				<p>{{ trans_choice('messages.no-service', 1) }}</p>
				<div class='row'>
					{{ $table }}					
				</div>
			</div>
		</div>
	</div>
</div>
@stop
