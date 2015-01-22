@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.report',2) }}</li>
	  <li class="active">{{ trans('messages.user-statistics-report') }}</li>
	</ol>
</div>

{{ Form::open(array('route' => array('reports.aggregate.userStatistics'), 'class' => 'form-inline', 'role' => 'form')) }}

<div class='container-fluid'>
	<div class="row">
		<div class="col-md-4"><!-- From Datepicker-->
	    	<div class="row">
				<div class="col-md-2">
					{{ Form::label('start', trans("messages.from")) }}
				</div>
				<div class="col-md-10">
					{{ Form::text('start', isset($input['start'])?$input['start']:date('Y-m-d'), 
				        array('class' => 'form-control standard-datepicker')) }}
			    </div>
	    	</div><!-- /.row -->
	    </div>
	    <div class="col-md-4"><!-- To Datepicker-->
	    	<div class="row">
				<div class="col-md-4">
			    	{{ Form::label('end', trans("messages.to")) }}
			    </div>
				<div class="col-md-8">
				    {{ Form::text('end', isset($input['end'])?$input['end']:date('Y-m-d'), 
				        array('class' => 'form-control standard-datepicker')) }}
		        </div>
	    	</div><!-- /.row -->
	    </div>
    </div><!-- /.row -->
    <br />
	<div class="row">
       <div class="col-md-4">
	    	<div class="row">
		        <div class="col-md-2">
		        	{{ Form::label('user', Lang::choice('messages.user',1)) }}
		        </div>
		        <div class="col-md-10">
		            {{ Form::select('user', array(0 => '-- All --')+User::all()->sortBy('name')->lists('name','id'),
		            	isset($input['user'])?$input['user']:0, array('class' => 'form-control')) }}
		        </div>
	        </div>
        </div>
        <div class="col-md-4">
	    	<div class="row">
		        <div class="col-md-4">
		        	{{ Form::label('report_type', Lang::choice('messages.report-type',1)) }}
		        </div>
		        <div class="col-md-8">
		            {{ Form::select('report_type', $reportTypes,
		            	isset($input['report_type'])?$input['report_type']:0, array('class' => 'form-control')) }}
		        </div>
	        </div>
	    </div>
	    <div class="col-md-2">
		    {{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
		        array('class' => 'btn btn-info', 'id' => 'filter', 'type' => 'submit')) }}
        </div>
	</div><!-- /.row -->
</div><!-- /.container-fluid -->

{{ Form::close() }}

<br />

<div class="panel panel-primary">

	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.user-statistics-report') }}
	</div>

	<div class="panel-body">
		@if (Session::has('message'))
			<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
		@endif	

		<div class="table-responsive">
			<h4>User Summary Report for the period {{$input['start']}} to {{$input['end']}}</h4>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th></th>
						<th>{{Lang::choice('messages.name',1)}}</th>
						<th>{{Lang::choice('messages.received-tests',1)}}</th>
						<th>{{Lang::choice('messages.accepted-specimen',1)}}</th>
						<th>{{Lang::choice('messages.rejected-specimen',1)}}</th>
						<th>{{Lang::choice('messages.performed-tests',1)}}</th>
						<th>{{Lang::choice('messages.verified-tests',1)}}</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1;?>
					@forelse($reportData as $row)
						<tr>
							<td>{{$i++}}</td>
							<td>{{$row->name}}</td>
							<td>{{$row->created}}</td>
							<td>{{$row->specimen_registered}}</td>
							<td>{{$row->specimen_rejected}}</td>
							<td>{{$row->tested}}</td>
							<td>{{$row->verified}}</td>
						</tr>
					@empty
						<tr>
							<td>{{Lang::choice('messages.no-data-found',1)}}</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div><!--/.table-responsive -->
	</div>
</div><!--/.panel -->

@stop