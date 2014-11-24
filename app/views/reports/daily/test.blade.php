@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active"><a href="{{ URL::route('reports.patient.index') }}">{{ trans('messages.reports') }}</a></li>
	  <li class="active">{{ trans('messages.daily-log') }}</li>
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
				    <td class="inline">
				    	{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
		                    array('class' => 'btn btn-info', 'id' => 'filter', 'type' => 'submit')) }}
				    </td>
				    <td>{{Form::submit(trans('messages.export-to-word'), 
				    		array('class' => 'btn btn-success', 'id'=>'word', 'name'=>'word'))}}</td>
				</tr>
				<tr>
				    <td><label class="radio-inline">
						  {{ Form::radio('records', 'tests', true, array('data-toggle' => 'radio', 
						  	'id' => 'tests')) }} {{trans('messages.test-records')}}
						</label></td>
				    <td><label class="radio-inline">
						  {{ Form::radio('records', 'patients', false, array('data-toggle' => 'radio',
						  	'id' => 'patients')) }} {{trans('messages.patient-records')}}
						</label></td>
				    <td><label class="radio-inline">
						  {{ Form::radio('records', 'rejections', false, array('data-toggle' => 'radio',
						  	'id' => 'specimens')) }} {{trans('messages.rejected-specimen')}}
						</label></td>
					<td colspan="2">
				    	<label class="checkbox-inline">
				    		{{Form::checkbox('pending', '1', isset($input['pending']))}} {{trans('messages.pending-only')}}
						</label>
				    </td>
				    <td>
				    	<label class="checkbox-inline">
				    		{{Form::checkbox('all', '1', isset($input['all']))}} {{trans('messages.all-tests')}}
						</label>
				    </td>
				</tr>
				<tr id="sections">
				    <td>{{ Form::label('description', trans("messages.test-category")) }}</td>
				    <td colspan="2">
				    	{{ Form::select('section_id', array(''=>'Select Lab Section')+$labSections, 
				    		Request::old('testCategory') ? Request::old('testCategory') : $testCategory, 
								array('class' => 'form-control', 'id' => 'section_id')) }}</td>
					<td>{{ Form::label('description', trans("messages.test-type")) }}</td>
				    <td colspan="2">
				    	{{ Form::select('test_type', array('' => 'Select Test Type')+$testTypes, 
				    		Request::old('testType') ? Request::old('testType') : $testType, 
								array('class' => 'form-control', 'id' => 'test_type')) }}</td>
				 </tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
{{ Form::close() }}
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span> {{ trans('messages.daily-log') }}
	</div>

	<div class="panel-body">
	<!-- if there are search errors, they will show here -->
		@if (Session::has('message'))
			<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
		@endif
		@if (Session::has('error'))
			<div class="alert alert-danger">{{ trans(Session::get('message')) }}</div>
		@endif
		<div id="test_records_div">
			@include("reportHeader")
			<strong>
				<p>
					{{trans('messages.test-records')}} 

					@if(isset($input['pending']))
						{{' - '.trans('messages.pending-only')}}
					@elseif(isset($input['all']))
						{{' - '.trans('messages.all-tests')}}
					@else
						{{' - '.trans('messages.complete-tests')}}
					@endif

					@if($testCategory)
						{{' - '.TestCategory::find($testCategory)->name}}
					@endif

					@if($testType)
						{{' ('.TestType::find($testType)->name.') '}}
					@endif

					<?php $from = isset($input['start'])?$input['start']:date('d-m-Y');?>
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
						<th>{{trans('messages.specimen-number-title')}}</th>
						<th>{{trans('messages.specimen')}}</th>
						<th>{{trans('messages.lab-receipt-date')}}</th>
						<th>{{trans('messages.tests')}}</th>
						<th>{{trans('messages.tested-by')}}</th>
						<th>{{trans('messages.test-results')}}</th>
						<th>{{trans('messages.test-remarks')}}</th>
						<th>{{trans('messages.results-entry-date')}}</th>
						<th>{{trans('messages.verified-by')}}</th>
					</tr>
					@forelse($tests as $key => $test)
					<tr>
						<td>{{ $test->specimen->id }}</td>
						<td>{{ $test->specimen->specimentype->name }}</td>
						<td>{{ $test->specimen->time_accepted }}</td>
						<td>{{ $test->testType->name }}</td>
						<td>{{ $test->testedBy->name or trans('messages.pending') }}</td>
						<td>
							@foreach($test->testResults as $result)
								<p>{{Measure::find($result->measure_id)->name}}: {{$result->result}}</p>
							@endforeach
						</td>
						<td>{{ $test->interpretation }}</td>
						<td>{{ $test->time_completed or trans('messages.pending') }}</td>
						<td>{{ $test->verifiedBy->name or trans('messages.verification-pending') }}</td>
					</tr>
					@empty
					<tr><td colspan="9">{{trans('messages.no-records-found')}}</td></tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>

@stop