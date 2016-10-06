@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.report',2) }}</li>
	  <li class="active">{{ trans('messages.surveillance') }}</li>
	</ol>
</div>
<div class='container-fluid'>
{{ Form::open(array('route' => array('reports.aggregate.surveillance'), 'class' => 'form-inline', 'role' => 'form')) }}
<div class="row">
		<div class="col-sm-4">
	    	<div class="row">
				<div class="col-sm-2">
					{{ Form::label('start', trans("messages.from")) }}
				</div>
				<div class="col-sm-3">
					{{ Form::text('start', isset($input['start'])?$input['start']:date('Y-m-01'), 
				        array('class' => 'form-control standard-datepicker')) }}
	   			</div>
	    	</div>
	    </div>
	    <div class="col-sm-4">
	    	<div class="row">
				<div class="col-sm-2">
					{{ Form::label('end', trans("messages.to")) }}
				</div>
				<div class="col-sm-3">
					{{ Form::text('end', isset($input['end'])?$input['end']:date('Y-m-d'), 
					    array('class' => 'form-control standard-datepicker')) }}
				</div>
	    	</div>
	    </div>
	    <div class="col-sm-4">
			<div class="col-sm-6">
			  	{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'),
	                array('class' => 'btn btn-info', 'id' => 'filter', 'type' => 'submit')) }}
	        </div>
	        <div class="col-sm-6">
				{{Form::submit(trans('messages.export-to-word'),
		    		array('class' => 'btn btn-success', 'id'=>'word', 'name'=>'word'))}}
			</div>
	    </div>
	</div>
{{ Form::close() }}
</div>
<br />
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.surveillance') }}
	</div>
	<div class="panel-body">
	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif	
	@include("reportHeader")
	<strong>
		<p> {{ trans('messages.surveillance') }} - 
			<?php $from = isset($input['start'])?$input['start']:date('01-m-Y');?>
			<?php $to = isset($input['end'])?$input['end']:date('d-m-Y');?>
			@if($from!=$to)
				{{trans('messages.from').' '.$from.' '.trans('messages.to').' '.$to}}
			@else
				{{trans('messages.for').' '.date('d-m-Y')}}
			@endif
		</p>
	</strong>
		<div class="table-responsive">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th rowspan="2">{{trans('messages.laboratory')}}</th>
						<th colspan="2">{{trans('messages.less-five')}}</th>
						<th colspan="2">{{trans('messages.greater-five')}}</th>
						<th colspan="2">{{Lang::choice('messages.total',1)}}</th>
					</tr>
					<tr>
						<th>{{trans('messages.tested')}}</th>
						<th>{{trans('messages.positive')}}</th>
						<th>{{trans('messages.tested')}}</th>
						<th>{{trans('messages.positive')}}</th>
						<th>{{trans('messages.tested')}}</th>
						<th>{{trans('messages.positive')}}</th>
					</tr>
				</thead>
				<tbody>
					@foreach(Disease::all() as $disease)
						 <?php
                                                        $disease_count;
                                                        if(method_exists($disease, 'reportDiseases')) //check if the method exists first otherwise a no value returns 
                                                                                                        //results to 'connect reset html page' a problem noted in in ubuntu 12.04
                                                        {$disease_count = count($disease->reportDiseases); } else
                                                        {$disease_count = null; }
                                                        if(empty($disease_count)) continue; 
                                                ?>

						<tr>
							<td>{{ $disease->name }}</td>
							<td>{{ $surveillance[$disease->id.
								'_less_five_total'] }}</td>
							<td>{{ $surveillance[$disease->id.
								'_less_five_positive'] }}</td>
							<td>{{ $surveillance[$disease->id.
								'_total'] - $surveillance[$disease->id.
								'_less_five_total'] }}</td>
							<td>{{ $surveillance[$disease->id.
								'_positive'] - $surveillance[$disease->id.
								'_less_five_positive'] }}</td>
							<td>{{ $surveillance[$disease->id.
								'_total'] }}</td>
							<td>{{ $surveillance[$disease->id.'_positive'] }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@stop
