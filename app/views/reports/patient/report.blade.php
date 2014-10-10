@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ trans('messages.reports') }}</li>
	  <li class="active">{{ trans('messages.patient-report') }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary" id="patientReport">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.patient-report') }}
	</div>
	<div class="panel-body">

		<!-- if there are search errors, they will show here -->
		@if($errors->all())
			<div class="alert alert-danger">
				{{ HTML::ul($errors->all()) }}
			</div>
		@endif
		{{ Form::open(array('route' => 'patientreport.filter', 'id' => 'form-patientreport-filter')) }}
			{{ Form::hidden('patient', $patient->id, array('id' => 'patient')) }}
			<div class="table-responsive">
			  <table class="table">
			    <thead>
			    <tr>
			        <td>{{ Form::label('name', trans("messages.from")) }}</td>
			        <td>{{ Form::text('from', Input::old('from'), array('class' => 'form-control', 'id' => 'from')) }}</td>
			        <td>{{ Form::label('name', trans("messages.to")) }}</td>
			         <td>{{ Form::text('to', Input::old('to'), array('class' => 'form-control', 'id' => 'to')) }}</td>
			        <td>{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
			                        array('class' => 'btn btn-primary', 'style' => 'width:125px', 'id' => 'filter', 'type' => 'submit')) }}</td>
			    </tr>
			    <tr>
			        <td><label class="radio-inline">
						  {{ Form::radio('layout', '1', true, array('data-toggle' => 'radio', 'id' => 'layout')) }} Portrait
						</label>
					 </td>
			         <td>
			         	<label class="radio-inline">
						  {{ Form::radio('layout', '2', false, array('data-toggle' => 'radio', 'id' => 'layout')) }} Landscape
						</label>
			         </td>
			         <td>{{ Form::button("<span class='glyphicon glyphicon-zoom-in'></span> ".trans('messages.increase-font'), 
			                        array('class' => 'btn btn-default', 'id' => 'increaseFont')) }}</td>
			         <td>{{ Form::button("<span class='glyphicon glyphicon-zoom-out'></span> ".trans('messages.reset-font'), 
			                        array('class' => 'btn btn-default', 'id' => 'resetFont')) }}</td>
			         <td>{{ Form::button("<span class='glyphicon glyphicon-send'></span> ".trans('messages.print'), 
			                        array('class' => 'btn btn-warning', 'style' => 'width:125px', 'id' => 'print')) }}</td>
			     </tr>
			     <tr>
			        <td>
			        	<label class="checkbox-inline">
			              <!-- {{ Form::hidden('pending', false) }} -->
						  {{ Form::checkbox('pending', 1, null, array('id' => 'pending')) }} {{trans('messages.include-pending-tests')}}
						</label>
			        </td>
			        <td>
			        	<label class="checkbox-inline">
						  {{ Form::checkbox('range', 'yes', false, array('id' => 'range')) }} {{trans('messages.include-range-visualization')}}
						</label>
			        </td>
			        <td>{{ Form::button("<span class='glyphicon glyphicon-file'></span> ".trans('messages.export-to-word'), 
			                        array('class' => 'btn btn-success', 'style' => 'width:160px', 'id' => 'word')) }}</td>
			        <td><a href="{{ URL::to('/pdf', $patient->id )}}" id="pdf" style="width:160px;" class='btn btn-info'><span class='glyphicon glyphicon-bookmark'></span>{{trans('messages.export-to-pdf')}}</a></td>
			        <td>{{ Form::button("<span class='glyphicon glyphicon-remove'></span> ".trans('messages.close'), 
			                        array('class' => 'btn btn-danger', 'style' => 'width:125px', 'id' => 'close')) }}</td>
			     </tr>
			</thead>
			<tbody>
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
						Patient Report for {{date('d-m-Y')}}</p></strong>			
					</td>
					<td><img src="{{ Config::get('kblis.organization-logo') }}" alt="" height="90" width="90" style="float:right;"></td>
				</tr>
			</tbody>
			  </table>
			  {{ Form::close() }}
			</div>
		<table class="table">
			<tbody>
				<tr>
					<th>{{trans('messages.patient-name')}}</th>
					<td>{{ $patient->name }}</td>
					<th>{{trans('messages.gender')}}</th>
					<td>@if($patient->gender==0){{ 'Male' }} @else {{ 'Female' }} @endif</td>
				</tr>
				<tr>
					<th>Patient Number(Sanitas)</th>
					<td>{{ $patient->patient_number."(".$patient->external_patient_number.")" }}</td>
					<th>Patient Age</th>
					<td>{{ Report::dateDiff($patient->dob) }}</td>
				</tr>
				<tr>
					<th>Lab Number [Serial No.]</th>
					<td>{{ $patient->id }}</td>
					<th>Requesting Department/Facility</th>
					<td></td>
				</tr>
			</tbody>
		</table>
		<table class="table">
			<tbody>
				<tr>
					<th colspan="6">Specimens</th>
				</tr>
				<tr>
					<th>Type</th>
					<th>Tests Requested</th>
					<th>Lab Section</th>
					<th>Lab Receipt Date</th>
					<th>Collected by</th>
				</tr>
				{{--*/ $visits = Patient::with('visits')->find($patient->id)->visits /*--}}
				@foreach($visits as $visit)
					{{--*/ $tests = Visit::with('tests')->find($visit->id)->tests /*--}}
					@foreach($tests as $test)
						{{--*/ $specimen = Test::with('specimen')->find($test->id)->specimen /*--}}
						<tr>
							<td>{{ $specimen->specimenType->name }}</td>
							<td>{{ $test->testType->name }}</td>
							<td>{{ $test->testType->testCategory->name }}</td>
							<td>{{ $specimen->time_accepted }}</td>
							<td>{{ $specimen->createdBy->name }}</td>
						</tr>
					@endforeach
				@endforeach

			</tbody>
		</table>
		<table class="table">
			<tbody>
				<tr>
					<th colspan="10">Test Results</th>
				</tr>
				<tr>
					<th>Test : Results(Value)</th>
					<th>Results Entry Date</th>
					<th>Remarks</th>
					<th>Tested by</th>
					<th>Date Tested</th>
					<th>Verified by</th>
					<th>Date Verified</th>
				</tr>
				@foreach($visits as $visit)
					{{--*/ $tests = Visit::with('tests')->find($visit->id)->tests /*--}}
					@foreach($tests as $test)
						{{--*/ $test_results = Test::with('testresults')->find($test->id)->test_results /*--}}
						<tr>
							<td>@foreach($test->testResults as $result)
									<p>{{Measure::find($result->measure_id)->name}}: {{$result->result}}</p>
								@endforeach</td>
							<td>@foreach($test->testResults as $result)
									<p>{{$result->time_entered}}</p>
								@endforeach</td>
							<td>{{ $test->interpretation }}</td>
							<td>{{$test->testedBy->name or trans('messages.unknown')}}</td>
							<td>{{ $test->time_completed }}</td>
							<td>{{$test->verifiedBy->name or trans('messages.verification-pending')}}</td>
							<td>{{ $test->time_verified }}</td>
						</tr>
					@endforeach
				@endforeach
			</tbody>
		</table>
	</div>

</div>
@stop