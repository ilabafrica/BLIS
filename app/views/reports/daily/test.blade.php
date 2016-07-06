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
		    	<div class="col-lg-6">
		    		<div class="panel panel-default">
		    			 <div class="panel-body">
	    			 		<div class="col-sm-3">
							  	<label class="radio-inline">
									{{ Form::radio('records', 'tests', true, array('data-toggle' => 'radio', 
									  'id' => 'tests')) }} {{trans('messages.test-records')}}
								</label>
							</div>
							<div class="col-sm-3">
							    <label class="radio-inline">
									{{ Form::radio('records', 'patients', false, array('data-toggle' => 'radio',
									  'id' => 'patients', Entrust::can('can_access_ccc_reports')?'disabled':'' )) }} {{trans('messages.patient-records')}}
								</label>
							</div>
							<div class="col-sm-3">
							    <label class="radio-inline">
									{{ Form::radio('records', 'rejections', false, array('data-toggle' => 'radio',
									  'id' => 'specimens', Entrust::can('can_access_ccc_reports')?'disabled':'' )) }} {{trans('messages.rejected-specimen')}}
								</label>
							</div>
	    			 	</div>
		    		</div>
		    	</div>

		    	<div class="col-lg-6">
		    		<div class="panel panel-default">
		    			 <div class="panel-body">
	    			 		<div class="col-sm-3">
								<label class="radio-inline">
						    		{{ Form::radio('pending_or_all', 'pending', ($pendingOrAll=='pending')?true:false, array('data-toggle' => 'radio',
									'id' => 'pending')) }} {{trans('messages.pending-tests')}}
								</label>
							</div>
							<div class="col-sm-3">
								<label class="radio-inline">
									{{ Form::radio('pending_or_all', 'complete', ($pendingOrAll=='complete')?true:false, array('data-toggle' => 'radio',
									'id' => 'pending')) }} {{trans('messages.complete-tests')}}
								</label>
							</div>
							<div class="col-sm-3">
							    <label class="radio-inline">
							    	{{ Form::radio('pending_or_all', 'all', ($pendingOrAll=='all')?true:false, array('data-toggle' => 'radio',
									  'id' => 'all')) }} {{trans('messages.all-tests')}}
								</label>
							</div>
	    			 	</div>
		    		</div>
		    	</div>
		  	</div>
	  	</div>
  	</div>
  	@if(!Entrust::can('can_access_ccc_reports'))
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
	@else
		{{ Form::hidden('section_id', TestCategory::getTestCatIdByName('VIROLOGY')) }}
		{{ Form::hidden('test_type', TestType::getTestTypeIdByTestName('Viral Load')) }}
	@endif
	{{ Form::close() }}
</div>
<br />
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span> {{ trans('messages.daily-log') }} - {{ trans('messages.test-records') }}
	</div>

	<div class="panel-body">
	<!-- if there are search errors, they will show here -->
		@if ($error!='')
			<div class="alert alert-info">{{ $error }}</div>
		@else
		<div id="test_records_div">
			@include("reportHeader")
			<strong>
				<p>
					{{trans('messages.test-records')}} 

					@if($pendingOrAll == 'pending')
						{{' - '.trans('messages.pending-only')}}
					@elseif($pendingOrAll == 'all')
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
					{{ Lang::choice('messages.total',1).' '.$counts .'<br>'}}
					<?php $from = isset($input['start'])?$input['start']:date('d-m-Y');?>
					<?php $to = isset($input['end'])?$input['end']:date('d-m-Y');?>
					@if($from!=$to)
						{{trans('messages.from').' '.$from.' '.trans('messages.to').' '.$to}}
					@else
						{{trans('messages.for').' '.date('d-m-Y')}}
					@endif
				</p>
			</strong>
			<table class="table table-bordered table-responsive">
				<tbody>
					<tr>
						<th>{{ trans('messages.patient-id') }}</th>
						<th>{{ trans('messages.visit-number') }}</th>
						<th>{{ trans('messages.patient-name') }}</th>
						<th>{{ trans('messages.specimen-number-title') }}</th>
						<th>{{ trans('messages.specimen') }}</th>
						<th>{{ trans('messages.lab-receipt-date') }}</th>
						<th>{{ Lang::choice('messages.test', 2) }}</th>
						<th>{{ trans('messages.tested-by') }}</th>
						<th>{{ trans('messages.test-results') }}</th>
						<th>{{ trans('messages.test-remarks') }}</th>
						<th>{{ trans('messages.results-entry-date') }}</th>
						<th>{{ trans('messages.verified-by') }}</th>
						<th>{{ trans('messages.turnaround-time') }}</th>
					</tr>
					@forelse($tests as $key => $test)
					<tr>
						<td>{{ $test->visit->patient->id }}</td>
						<td>{{ isset($test->visit->visit_number)?$test->visit->visit_number:$test->visit->id }}</td>
						<td>{{ $test->visit->patient->name }}</td>
						<td>{{ $test->getSpecimenId() }}</td>
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
						<td>{{ $test->isCompleted()?$test->getFormattedTurnaroundTime():trans('messages.pending') }}</td>
					</tr>
					@empty
					<tr><td colspan="13">{{trans('messages.no-records-found')}}</td></tr>
					@endforelse
				</tbody>
			</table>
		</div>
		@endif
	</div>
</div>

@stop