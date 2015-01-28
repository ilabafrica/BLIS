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
    {{ Form::open(array('route' => array('reports.daily.log'), 'class' => 'form-inline')) }}
    <div class='row'>
    	<div class="col-sm-6">
	    	<div class="row">
				<div class="col-sm-3">
				    {{ Form::label('start', "Select Date") }}
				</div>
				<div class="col-sm-3">
				    {{ Form::text('start', isset($input['start'])?$input['start']:date('Y-m-d'), 
			                array('class' => 'form-control standard-datepicker')) }}
		        </div>
			</div>
		</div>
		<div class="col-sm-6">
	    	<div class="row">
				<div class="col-sm-3">
				  	{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
		                array('class' => 'btn btn-info', 'id' => 'filter', 'type' => 'submit')) }}
		        </div>
		        <div class="col-sm-3">
					{{Form::submit(trans('messages.export-to-word'), 
			    		array('class' => 'btn btn-success', 'id'=>'word', 'name'=>'word'))}}
				</div>
			</div>
		</div>
	</div>
	<div class='row spacer'>
		<div class="col-sm-12">
	    	<div class="row">
				<div class="col-sm-2">
				  	<label class="radio-inline">
						{{ Form::radio('records', 'tests', true, array('data-toggle' => 'radio', 
						  'id' => 'tests')) }} {{trans('messages.test-records')}}
					</label>
				</div>
				<div class="col-sm-2">
				    <label class="radio-inline">
						{{ Form::radio('records', 'patients', false, array('data-toggle' => 'radio',
						  'id' => 'patients')) }} {{trans('messages.patient-records')}}
					</label>
				</div>
				<div class="col-sm-3">
				    <label class="radio-inline">
						{{ Form::radio('records', 'rejections', false, array('data-toggle' => 'radio',
						  'id' => 'specimens')) }} {{trans('messages.rejected-specimen')}}
					</label>
				</div>
				<div class="col-sm-3">
					<label class="radio-inline">
			    		{{ Form::radio('pending_or_all', 'pending', ($pendingOrAll=='pending')?true:false, array('data-toggle' => 'radio',
					  	  'id' => 'pending')) }} {{trans('messages.pending-only')}}
					</label>
				</div>
				<div class="col-sm-2">
				    <label class="radio-inline">
				    	{{ Form::radio('pending_or_all', 'all', ($pendingOrAll=='all')?true:false, array('data-toggle' => 'radio',
						  'id' => 'all')) }} {{trans('messages.all-tests')}}
					</label>
				</div>
		  	</div>
	  	</div>
  	</div>
  	<div class='row spacer'>
	  	<div class="col-sm-6">
	    	<div class="row">
				<div class="col-sm-3">
				  	{{ Form::label('description',  Lang::choice('messages.test-category', 2)) }}
				 </div>
			  	<div class="col-sm-3">
				  	{{ Form::select('section_id', array(''=>trans('messages.select-lab-section'))+$labSections, 
							    		Request::old('testCategory') ? Request::old('testCategory') : $testCategory, 
											array('class' => 'form-control', 'id' => 'section_id')) }}
				</div>
			</div>
		</div>
		<div class="col-sm-6">
	    	<div class="row">
				<div class="col-sm-3">
					{{ Form::label('description', Lang::choice('messages.test-type', 1)) }}
				</div>
				<div class="col-sm-3">
					{{ Form::select('test_type', array('' => trans('messages.select-test-type'))+$testTypes, 
							    		Request::old('testType') ? Request::old('testType') : $testType, 
											array('class' => 'form-control', 'id' => 'test_type')) }}
				</div>
			</div>
		</div>
	</div>
	{{ Form::close() }}
</div>
<br />
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span> {{ trans('messages.daily-log') }} - {{ trans('messages.test-records') }}
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
					@if($from)
						{{trans('messages.for').' '.$from}}
					@else
						{{trans('messages.for').' '.date('d-m-Y')}}
					@endif
				</p>
			</strong>
			<table class="table table-bordered">
				<tbody>
					<tr>
						<th>{{ trans('messages.specimen-number-title') }}</th>
						<th>{{ trans('messages.specimen') }}</th>
						<th>{{ trans('messages.lab-receipt-date') }}</th>
						<th>{{ Lang::choice('messages.test', 2) }}</th>
						<th>{{ trans('messages.tested-by') }}</th>
						<th>{{ trans('messages.test-results') }}</th>
						<th>{{ trans('messages.test-remarks') }}</th>
						<th>{{ trans('messages.results-entry-date') }}</th>
						<th>{{ trans('messages.verified-by') }}</th>
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