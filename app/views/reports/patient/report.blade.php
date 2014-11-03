@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active"><a href="{{ URL::route('reports.patient.index') }}">{{ trans('messages.reports') }}</a></li>
	  <li class="active">{{ trans('messages.patient-report') }}</li>
	</ol>
</div>
<div id="non-printable" >
{{ Form::open(array('url' => 'patientreport/'.$patient->id, 'id' => 'form-patientreport-filter', 'method'=>'POST')) }}
	{{ Form::hidden('patient', $patient->id, array('id' => 'patient')) }}
	<div class="table-responsive">
	  <table class="table">
	    <tbody>
	    <tr>
	        <td>{{ Form::label('name', trans("messages.from")) }}</td>
        	<td>{{ Form::text('start', Input::old('start'), array('class' => 'form-control', 'id' => 'start')) }}</td>
	        <td>{{ Form::label('name', trans("messages.to")) }}</td>
        	<td>{{ Form::text('end', Input::old('end'), array('class' => 'form-control', 'id' => 'end')) }}</td>
	        <td>{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
	                        array('class' => 'btn btn-primary', 'style' => 'width:125px', 'id' => 'filter', 'type' => 'submit')) }}</td>
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
	        <td><a href="{{ URL::to('/patientreport/word/'.$patient->id)}}" id="word" style="width:160px;" class='btn btn-success'><span class='glyphicon glyphicon-file'></span> {{trans('messages.export-to-word')}}</a></td>
	        <td><a href="{{ URL::to('/pdf/'.$patient->id)}}" id="pdf" style="width:160px;" class='btn btn-info'><span class='glyphicon glyphicon-bookmark'></span> {{trans('messages.export-to-pdf')}}</a></td>
	        <td>{{ Form::button("<span class='glyphicon glyphicon-send'></span> ".trans('messages.print'), 
	                        array('class' => 'btn btn-default', 'style' => 'width:125px', 'id' => 'print', 'onclick' => 'printContent("patientReport")')) }}</td>
	     </tr>
	</tbody>
</table>
</div>
{{ Form::close() }}
</div>
<div class="panel panel-primary" id="patientReport">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.patient-report') }}
	</div>
	<div class="panel-body">
		@if (Session::has('message'))
			<div class="alert alert-danger">{{ trans(Session::get('message')) }}</div>
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
						Patient Report for {{date('d-m-Y')}}</p></strong>			
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
					<td></td>
				</tr>
			</tbody>
		</table>
		<table class="table table-bordered">
			<tbody>
				<tr>
					<th colspan="5">{{trans('messages.specimen')}}</th>
				</tr>
				<tr>
					<th>{{ trans('messages.specimen-type')}}</th>
					<th>{{ trans('messages.tests')}}</th>
					<th>{{ trans('messages.test-category')}}</th>
					<th>{{ trans('messages.lab-receipt-date')}}</th>
					<th>{{ trans('messages.collected-by')}}</th>
				</tr>
				@forelse($visits as $visit)
					@foreach($visit->tests as $test)
						<tr>
							<td>{{ $test->specimen->specimenType->name }}</td>
							<td>{{ $test->testType->name }}</td>
							<td>{{ $test->testType->testCategory->name }}</td>
							<td>{{ $test->specimen->time_accepted }}</td>
							<td>{{ $test->specimen->acceptedBy->name or trans('messages.unknown')}}</td>
						</tr>
					@endforeach
				@empty
					<tr>
						<td colspan="5">{{trans("messages.no-records-found")}}</td>
					</tr>
				@endforelse

			</tbody>
		</table>
		<table class="table table-bordered">
			<tbody>
				<tr>
					<th colspan="7">{{trans('messages.test-results')}}</th>
				</tr>
				<tr>
					<th>{{trans('messages.test-results-values')}}</th>
					<th>{{trans('messages.results-entry-date')}}</th>
					<th>{{trans('messages.test-remarks')}}</th>
					<th>{{trans('messages.tested-by')}}</th>
					<th>{{trans('messages.date-tested')}}</th>
					<th>{{trans('messages.verified-by')}}</th>
					<th>{{trans('messages.date-verified')}}</th>
				</tr>
				@forelse($visits as $visit)
					@foreach($visit->tests as $test)
						<tr>
							<td>@foreach($test->testResults as $result)
									<p>{{Measure::find($result->measure_id)->name}}: {{$result->result}}</p>
								@endforeach</td>
							<td>@foreach($test->testResults as $result)
									<p>{{$result->time_entered}}</p>
								@endforeach</td>
							<td>{{ $test->interpretation }}</td>
							<td>{{ $test->testedBy->name or trans('messages.unknown')}}</td>
							<td>{{ $test->time_completed }}</td>
							<td>{{ $test->verifiedBy->name or trans('messages.verification-pending')}}</td>
							<td>{{ $test->time_verified }}</td>
						</tr>
					@endforeach
				@empty
					<tr>
						<td colspan="7">{{trans("messages.no-records-found")}}</td>
					</tr>
				@endforelse
			</tbody>
		</table></div>
		</div>
	</div>

</div>
<script type="text/javascript">
	$(document).ready(function(){
		reports();
	});
</script>
@stop