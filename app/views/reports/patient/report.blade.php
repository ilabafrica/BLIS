@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active"><a href="{{ URL::route('reports.patient.index') }}">{{ Lang::choice('messages.report', 2) }}</a></li>
	  <li class="active">{{ trans('messages.patient-report') }}</li>
	</ol>
</div>
<div class='container-fluid'>
    {{ Form::open(array('url' => 'patientreport/'.$patient->id, 'class' => 'form-inline', 'id' => 'form-patientreport-filter', 'method'=>'POST')) }}
		{{ Form::hidden('patient', $patient->id, array('id' => 'patient')) }}
		<div class="row">
			<div class="col-sm-2">
				<label class="checkbox-inline">
	        		{{ Form::checkbox('pending', "1", isset($pending)) }}{{trans('messages.include-pending-tests')}}
				</label>
			</div>
			<div class="col-sm-3">
				<div class="row">
					<div class="col-sm-2">
						{{ Form::label('start', trans("messages.from")) }}</div><div class="col-sm-1">
			        	{{ Form::text('start', isset($input['start'])?$input['start']:null, 
			                array('class' => 'form-control standard-datepicker')) }}
			        </div>
		        </div>
	        </div>
	        <div class="col-sm-3">
				<div class="row">
			        <div class="col-sm-2">
				        {{ Form::label('end', trans("messages.to")) }}
				    </div>
				    <div class="col-sm-1">
		                {{ Form::text('end', isset($input['end'])?$input['end']:null, 
		                    array('class' => 'form-control standard-datepicker')) }}
		            </div>
	            </div>
            </div>
            <div class="col-sm-4">
				<div class="row">
		            <div class="col-sm-3">
			            {{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
			                    array('class' => 'btn btn-primary', 'id' => 'filter', 'type' => 'submit')) }}
		            </div>
		            @if(count($verified) == count($tests))
		            <div class="col-sm-3">
				        {{ Form::submit('Export word', array('class' => 'btn btn-success', 
				        	'id' => 'word', 'name' => 'word')) }}
				    </div>
				    <div class="col-sm-3">
				        {{ Form::submit('Export pdf', array('class' => 'btn btn-success', 
				        	'id' => 'pdf', 'name' => 'pdf')) }}
				    </div>
				    @endif
			    </div>
		    </div>
	    </div>
	    {{ Form::hidden('visit_id', $visit, array('id'=>'visit_id')) }}
	{{ Form::close() }}
</div>
<br />
<div class="panel panel-primary" id="patientReport">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.patient-report') }}
	</div>
	<div class="panel-body">
		@if($error!='')
		<!-- if there are search errors, they will show here -->
			<div class="alert alert-info">{{ $error }}</div>
		@else

		<div id="report_content">
		@include("reportHeader")
		<strong>
			<p>
				{{trans('messages.patient-report').' - '.date('d-m-Y')}}
			</p>
		</strong>
		<table class="table table-bordered">
			<tbody>
				<tr>
					<th>{{ trans('messages.patient-name')}}</th>
					@if(Entrust::can('view_names'))
						<td>{{ $patient->name }}</td>
					@else
						<td>N/A</td>
					@endif
					<th>{{ trans('messages.gender')}}</th>
					<td>{{ $patient->getGender(false) }}</td>
				</tr>
				<tr>
					<th>{{ trans('messages.patient-id')}}</th>
					<td>{{ $patient->patient_number}}</td>
					<th>{{ trans('messages.age')}}</th>
					<td>{{ $patient->getAge()}}</td>
				</tr>
				<tr>
					<th>{{ trans('messages.patient-lab-number')}}</th>
					<td>{{ $patient->external_patient_number }}</td>
					<th>{{ trans('messages.requesting-facility-department')}}</th>
					<td>{{ Config::get('kblis.organization') }}</td>
				</tr>
			</tbody>
		</table>
		<table class="table table-bordered">
			<tbody>
				<tr>
					<th colspan="7">{{trans('messages.specimen')}}</th>
				</tr>
				<tr>
					<th>{{ Lang::choice('messages.specimen-type', 1)}}</th>
					<th>{{ Lang::choice('messages.test', 2)}}</th>
					<th>{{ trans('messages.date-ordered') }}</th>
					<th>{{ Lang::choice('messages.test-category', 2)}}</th>
					<th>{{ trans('messages.specimen-status')}}</th>
					<th>{{ trans('messages.collected-by')."/".trans('messages.rejected-by')}}</th>
					<th>{{ trans('messages.date-checked')}}</th>
				</tr>
				@forelse($tests as $test)
						<tr>
							<td>{{ $test->specimen->specimenType->name }}</td>
							<td>{{ $test->testType->name }}</td>
							<td>{{ $test->isExternal()?$test->external()->request_date:$test->time_created }}</td>
							<td>{{ $test->testType->testCategory->name }}</td>
							@if($test->specimen->specimen_status_id == Specimen::NOT_COLLECTED)
								<td>{{trans('messages.specimen-not-collected')}}</td>
								<td></td>
								<td></td>
							@elseif($test->specimen->specimen_status_id == Specimen::ACCEPTED)
								<td>{{trans('messages.specimen-accepted')}}</td>
								<td>{{$test->specimen->acceptedBy->name}}</td>
								<td>{{$test->specimen->time_accepted}}</td>
							@elseif($test->specimen->specimen_status_id == Specimen::REJECTED)
								<td>{{trans('messages.specimen-rejected')}}</td>
								<td>{{$test->specimen->rejectedBy->name}}</td>
								<td>{{$test->specimen->time_rejected}}</td>
							@endif
						</tr>
				@empty
					<tr>
						<td colspan="7">{{trans("messages.no-records-found")}}</td>
					</tr>
				@endforelse

			</tbody>
		</table>
		<table class="table table-bordered">
			<tbody>
				<tr>
					<th colspan="8">{{trans('messages.test-results')}}</th>
				</tr>
				<tr>
					<th>{{Lang::choice('messages.test-type', 1)}}</th>
					<th>{{trans('messages.test-results-values')}}</th>
					<th>{{trans('messages.test-remarks')}}</th>
					<th>{{trans('messages.tested-by')}}</th>
					<th>{{trans('messages.results-entry-date')}}</th>
					<th>{{trans('messages.date-tested')}}</th>
					<th>{{trans('messages.verified-by')}}</th>
					<th>{{trans('messages.date-verified')}}</th>
				</tr>
				@forelse($tests as $test)
						<tr>
							<td>{{ $test->testType->name }}</td>
							<td>
								@foreach($test->testResults as $result)
									<p>
										{{ Measure::find($result->measure_id)->name }}: {{ $result->result }}
										{{ Measure::getRange($test->visit->patient, $result->measure_id) }}
										{{ Measure::find($result->measure_id)->unit }}
									</p>
								@endforeach</td>
							<td>{{ $test->interpretation == '' ? 'N/A' : $test->interpretation }}</td>
							<td>{{ $test->testedBy->name or trans('messages.pending')}}</td>
							<td>{{ $test->testResults->last()->time_entered }}</td>
							<td>{{ $test->time_completed }}</td>
							<td>{{ $test->verifiedBy->name or trans('messages.verification-pending')}}</td>
							<td>{{ $test->time_verified }}</td>
						</tr>
				@empty
					<tr>
						<td colspan="8">{{trans("messages.no-records-found")}}</td>
					</tr>
				@endforelse
			</tbody>
		</table></div>
		@endif
		</div>
	</div>

</div>
@stop