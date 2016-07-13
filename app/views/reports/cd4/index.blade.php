@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active"><a href="{{ URL::route('reports.patient.index') }}">{{ Lang::choice('messages.report', 2) }}</a></li>
	  <li class="active">{{ trans('messages.daily-log') }}</li>
	</ol>
</div>
<div class='container-fluid'>
	{{ Form::open(array('route' => array('reports.aggregate.cd4'), 'class' => 'form-inline', 'role' => 'form')) }}
		<div class='row'>
	    	<div class="col-sm-4">
		    	<div class="row">
					<div class="col-sm-2">
					    {{ Form::label('start', trans('messages.from')) }}
					</div>
					<div class="col-sm-2">
					    {{ Form::text('start', isset($input['start'])?$input['start']:date('Y-m-01'), 
				                array('class' => 'form-control standard-datepicker')) }}
			        </div>
				</div>
			</div>
			<div class="col-sm-4">
		    	<div class="row">
					<div class="col-sm-2">
					    {{ Form::label('end', trans('messages.to')) }}
					</div>
					<div class="col-sm-2">
					    {{ Form::text('end', isset($input['end'])?$input['end']:date('Y-m-d'), 
				                array('class' => 'form-control standard-datepicker')) }}
			        </div>
				</div>
			</div>
			<div class="col-sm-4">
		    	<div class="row">
					<div class="col-sm-3">
					  	{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
			                array('class' => 'btn btn-info', 'id' => 'filter', 'type' => 'submit')) }}
			        </div>
			        <div class="col-sm-3">
						{{Form::submit(trans('messages.export-to-word'), 
				    		array('class' => 'btn btn-success', 'id'=>'word', 'name'=>'word'))}}
					</div>
					<div class="col-sm-1">
						{{Form::submit(trans('messages.export-to-excel'), 
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
		{{ trans('messages.cd4-report') }}
	</div>
	<div class="panel-body">
		<div id="specimen_records_div">
		  @include("reportHeader")
		  	@if (Session::has('message'))
				<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
			@endif	
			<strong>
				<p> {{ trans('messages.cd4-report') }} - 
					<?php $from = isset($input['start'])?$input['start']:date('01-m-Y');?>
					<?php $to = isset($input['end'])?$input['end']:date('d-m-Y');?>
					@if($from!=$to)
						{{trans('messages.from').' '.$from.' '.trans('messages.to').' '.$to}}
					@else
						{{trans('messages.for').' '.date('d-m-Y')}}
					@endif
				</p>
			</strong>
			<table class="table table-bordered">
				<tbody>
					<tr>
					<th></th>
					@foreach($columns as $column)
						<th>{{ $column }}</th>
					@endforeach
					</tr>
					@foreach($rows as $row)
						<tr>
							<td>{{ $row }}</td>
							@foreach($columns as $column)
								<td>{{ $counts[$column][$row] }}</td>
							@endforeach
						</tr>
					@endforeach
				</tbody>
			</table>
		</div> <!-- /#specimen_records_div -->
	</div> <!-- /.panel-body -->
</div> <!-- /.panel -->
@stop