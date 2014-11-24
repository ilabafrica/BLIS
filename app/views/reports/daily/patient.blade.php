@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active"><a href="{{ URL::route('reports.patient.index') }}">{{ trans('messages.reports') }}</a></li>
	  <li class="active">{{ trans('messages.daily-log') }} - {{trans('messages.patient-records')}}</li>
	</ol>
</div>
{{ Form::open(array('route' => array('reports.daily.log'), 'class' => 'form-inline', 'role' => 'form')) }}
	<div class="table-responsive">
		<table class="table report-filter">
	    <thead>
		    <tr>
		        <td>{{ Form::label('start', trans("messages.from")) }}</td>
		        <td>
		            {{ Form::text('start', isset($input['start'])?$input['start']:date('Y-m-d'), 
		                array('class' => 'form-control standard-datepicker')) }}
		        </td>
		        <td>{{ Form::label('end', trans("messages.to")) }}</td>
		        <td>
		            {{ Form::text('end', isset($input['end'])?$input['end']:date('Y-m-d'), 
		                array('class' => 'form-control standard-datepicker')) }}
		        </td>
		        <td>{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
		                array('class' => 'btn btn-primary','id' => 'filter', 'type' => 'submit')) }}</td>
		    </tr>
		    <tr>
		        <td><label class="radio-inline">
					  {{ Form::radio('records', 'tests', false, 
					  	array('data-toggle' => 'radio', 'id' => 'tests')) }} {{trans('messages.test-records')}}
					</label></td>
		        <td><label class="radio-inline">
					  {{ Form::radio('records', 'patients', true, 
					  	array('data-toggle' => 'radio', 'id' => 'patients')) }} {{trans('messages.patient-records')}}
					</label></td>
		        <td><label class="radio-inline">
					  {{ Form::radio('records', 'rejections', false, 
					  	array('data-toggle' => 'radio', 'id' => 'specimens')) }} {{trans('messages.rejected-specimen')}}
					</label></td>
				<td>{{ Form::button("<span class='glyphicon glyphicon-eye-open'></span> ".trans('messages.show-hide'), 
		                array('class' => 'btn btn-default', 'id' => 'reveal')) }}</td>
		        <td>{{Form::submit(trans('messages.export-to-word'), 
		        		array('class' => 'btn btn-success', 'id'=>'word', 'name'=>'word'))}}</td>
		    </tr>
		</thead>
		<tbody>
		</tbody>
		</table>
	</div>
{{ Form::close() }}

<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.daily-log') }} - {{trans('messages.patient-records')}}
	</div>
	<div class="panel-body">
		<!-- if there are search errors, they will show here -->
		@if (Session::has('message'))
			<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
		@endif
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
						<th>{{trans('messages.tests')}}</th>
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
	</div> <!-- /.panel-body -->
</div> <!-- /.panel -->

@stop