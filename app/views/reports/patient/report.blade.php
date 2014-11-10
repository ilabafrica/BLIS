@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active"><a href="{{ URL::route('reports.patient.index') }}">{{ Lang::choice('messages.report', 2) }}</a></li>
	  <li class="active">{{ trans('messages.patient-report') }}</li>
	</ol>
</div>
{{ Form::open(array('url' => 'patientreport/'.$patient->id, 'id' => 'form-patientreport-filter', 'method'=>'POST')) }}
	{{ Form::hidden('patient', $patient->id, array('id' => 'patient')) }}
	<div class="table-responsive">
	  <table class="table">
	    <tbody>
	    <tr>
	    	<td>
	        	<label class="checkbox-inline">
	              <!-- {{ Form::hidden('pending', false) }} -->
	              <input type="checkbox" id="tests" name="tests" value="1" @if(isset($pending)){{"checked='checked'"}}@endif> {{trans('messages.include-pending-tests')}}
				</label>
	        </td>
	        <td>{{ Form::label('name', trans("messages.from")) }}</td>
        	<td><input class="form-control standard-datepicker" name="start" type="text" 
                    value="{{ isset($from) ? $from : '' }}" id="start"></td>
	        <td>{{ Form::label('name', trans("messages.to")) }}</td>
        	<td><input class="form-control standard-datepicker" name="end" type="text" 
                    value="{{ isset($to) ? $to : '' }}" id="end"></td>
	        <td>{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
	                        array('class' => 'btn btn-primary', 'style' => 'width:125px', 'id' => 'filter', 'type' => 'submit')) }}</td>
	        <td>{{ Form::submit(trans('messages.export-to-word'), array('class' => 'btn btn-success', 'style' => 'width:160px', 'id' => 'word', 'name' => 'word')) }}</td>
	    </tr>
	</tbody>
</table>
</div>
{{ Form::close() }}
<div class="panel panel-primary" id="patientReport">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.patient-report') }}
	</div>
	<div class="panel-body">
		@if(Session::has('error'))
			<div class="alert alert-danger">{{ trans(Session::get('error')) }}</div>
		@endif

		<!-- if there are search errors, they will show here -->
		<div class="alert alert-danger" id="error" style="display:none"></div>
		<div id="report_content">
		<table class="table">
			<thead>
				<tr>
					<td><img src="{{ Config::get('kblis.organization-logo') }}" alt="" height="90" width="90"></td>
					<td colspan="3" style="text-align:center;">
						<strong><p>BUNGOMA DISTRICT HOSPITAL LABORATORY<br>
						BUNGOMA TOWN, HOSPITAL ROAD<br>
						OPPOSITE POLICE LINE/DISTRICT HEADQUARTERS<br>
						P.O. BOX 14,<br>
						BUNGOMA TOWN.<br>
						Phone: +254 055-30401 Ext 203/208</p>

						<p>LABORATORY REPORT<br>
						Patient Report @if($from!=$to){{'From '.$from.' To '.$to}}@else{{'For '.date('d-m-Y')}}@endif</p></strong>			
					</td>
					<td><img src="{{ Config::get('kblis.organization-logo') }}" alt="" height="90" width="90" style="float:right;"></td>
				</tr>
			</thead>
		</table>
		<table class="table table-bordered">
			<tbody>
				<tr>
					<th>{{ trans('messages.patient-name')}}</th>
					<td>{{ $patient->name }}</td>
					<th>{{ trans('messages.gender')}}</th>
					<td>{{ ($patient->gender==Patient::MALE?trans('messages.male'):trans('messages.female')) }}</td>
				</tr>
				<tr>
					<th>{{ trans("messages.patient-number")}}</th>
					<td>{{ $patient->patient_number}}</td>
					<th>{{ trans('messages.age')}}</th>
					<td>{{ $patient->getAge()}}</td>
				</tr>
				<tr>
					<th>{{ trans('messages.visit-number')}}</th>
					<td>{{ $patient->id }}</td>
					<th>{{ trans('messages.requesting-facility-department')}}</th>
					<td>{{ 'Bungoma District Hospital' }}</td>
				</tr>
			</tbody>
		</table>
		<table class="table table-bordered">
			<tbody>
				<tr>
					<th colspan="6">{{trans('messages.specimen')}}</th>
				</tr>
				<tr>
					<th>{{ trans('messages.specimen-type')}}</th>
					<th>{{ trans('messages.tests')}}</th>
					<th>{{ trans('messages.test-category')}}</th>
					<th>{{ trans('messages.specimen-status')}}</th>
					<th>{{ trans('messages.collected-by')."/".trans('messages.rejected-by')}}</th>
					<th>{{ trans('messages.date-checked')}}</th>
				</tr>
				@forelse($tests as $test)
					<tr>
						<td>{{ $test->specimen->specimenType->name }}</td>
						<td>{{ $test->testType->name }}</td>
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
						<td colspan="6">{{trans("messages.no-records-found")}}</td>
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
					<th>{{trans('messages.test-type')}}</th>
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
						<td>@foreach($test->testResults as $result)
								<p>{{Measure::find($result->measure_id)->name}}: {{$result->result}}</p>
							@endforeach</td>
						<td>{{ $test->interpretation }}</td>
						<td>{{ $test->testedBy->name or trans('messages.pending')}}</td>
						<td>@foreach($test->testResults as $result)
								<p>{{$result->time_entered}}</p>
							@endforeach</td>
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
		</div>
	</div>

</div>
@stop