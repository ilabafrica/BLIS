@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active"><a href="{{ URL::route('reports.patient.index') }}">{{ trans_choice('messages.report', 2) }}</a></li>
	  <li class="active">{{ trans('messages.daily-log') }}</li>
	</ol>
</div>
<div class='container-fluid'>
{{ Form::open(array('route' => array('reports.daily.log'), 'class' => 'form-inline', 'role' => 'form')) }}
<div class='row'>
	<div class="col-sm-4">
    	<div class="row">
			<div class="col-sm-2">
			    {{ Form::label('start', trans('messages.from')) }}
			</div>
			<div class="col-sm-2">
			    {{ Form::text('start', isset($input['start'])?$input['start']:date('Y-m-d'), 
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
	        <div class="col-sm-1">
				{{Form::submit(trans('messages.export-to-word'), 
		    		array('class' => 'btn btn-success', 'id'=>'word', 'name'=>'word'))}}
			</div>
		</div>
	</div>
</div>
<div class='row spacer'>
    <div class="col-sm-12">
    	<div class="row">
			<div class="col-sm-3">
			   	<label class="radio-inline">
				  {{ Form::radio('records', 'tests', false, 
				  	array('data-toggle' => 'radio', 'id' => 'tests')) }} {{trans('messages.test-records')}}
				</label>
			</div>
			<div class="col-sm-3">
				<label class="radio-inline">
				  {{ Form::radio('records', 'patients', true, 
				  	array('data-toggle' => 'radio', 'id' => 'patients')) }} {{trans('messages.patient-records')}}
				</label>
			</div>
			<div class="col-sm-3">
				<label class="radio-inline">
				  {{ Form::radio('records', 'rejections', false, 
				  	array('data-toggle' => 'radio', 'id' => 'specimens')) }} {{trans('messages.rejected-specimen')}}
				</label>
			</div>
			<div class="col-sm-3">
				{{ Form::button("<span class='glyphicon glyphicon-eye-open'></span> ".trans('messages.show-hide'), 
			        array('class' => 'btn btn-default', 'id' => 'reveal')) }}
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
		{{ trans('messages.daily-log') }} - {{trans('messages.patient-records')}}
	</div>
	<div class="panel-body">
		<!-- if there are search errors, they will show here -->
		@if ($error!='')
			<div class="alert alert-info">{{ $error }}</div>
		@else
	 	<div id="patient_records_div">
	  
			@include("reportHeader")
			<strong>
				<p>
				<?php $from = isset($input['start'])?$input['start']:date('Y-m-d'); ?>
				<?php $to = isset($input['end'])?$input['end']:date('Y-m-d'); ?>
					{{trans('messages.daily-visits')}} @if($from!=$to)
						{{trans('messages.from').' '.$from.' '.trans('messages.to').' '.$to}}
					@else
						{{trans('messages.for').' '.date('d-m-Y')}}
					@endif
				</p>
			</strong>
			<div id="summary">
				<table class="table table-bordered">
					<tbody>
						<tr>
							<th colspan="3">{{trans('messages.summary')}}</th>
						</tr>
						<th>{{trans('messages.total-visits')}}</th>
						<th>{{trans('messages.male')}}</th>
						<th>{{trans('messages.female')}}</th>
						<tr>
							<td>{{count($visits)}}</td>
							<td>
								{{--*/ $male = 0 /*--}}
								@forelse($visits as $visit)
								  @if($visit->patient->gender==Patient::MALE)
								   	{{--*/ $male++ /*--}}
								  @endif
								@endforeach
								{{$male}}
							</td>
							<td>{{count($visits)-$male}}</td>
						</tr>
					</tbody>
				</table>
			</div> <!-- /#summary -->
		  	<table class="table table-bordered">
				<tbody>
					<tr>
						<th>{{trans('messages.patient-number')}}</th>
						<th>{{trans('messages.patient-name')}}</th>
						<th>{{trans('messages.age')}}</th>
						<th>{{trans('messages.gender')}}</th>
						<th>{{trans('messages.specimen-number-title')}}</th>
						<th>{{trans('messages.specimen-type-title')}}</th>
						<th>{{ trans_choice('messages.test', 2) }}</th>
					</tr>
					@forelse($visits as $visit)
					<tr>
						<td>{{ $visit->patient->id }}</td>
						<td>{{ $visit->patient->name }}</td>
						<td>{{ $visit->patient->getAge() }}</td>
						<td>{{ $visit->patient->getGender()}}</td>
						<td>
							@foreach($visit->tests as $test)
								<p>{{ $test->specimen->id }}</p>
							@endforeach
						</td>
						<td>
							@foreach($visit->tests as $test)
								<p>{{ $test->specimen->specimenType->name }}</p>
							@endforeach
						</td>
						<td>
							@foreach($visit->tests as $test)
								<p>{{ $test->testType->name }}</p>
							@endforeach
						</td>
					</tr>
					@empty
					<tr><td colspan="13">{{trans('messages.no-records-found')}}</td></tr>
					@endforelse
				</tbody>
			</table>
	  	</div> <!-- /#patient_records_div -->
	  	@endif
	</div> <!-- /.panel-body -->
</div> <!-- /.panel -->

@stop