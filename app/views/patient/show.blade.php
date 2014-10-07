@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		  <li><a href="{{ URL::route('patient.index') }}">{{ trans('messages.patient') }}</a></li>
		  <li class="active">{{ trans('messages.patient-details') }}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<span class="glyphicon glyphicon-user"></span>
			{{ trans('messages.patient-details') }}
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::to('patient/'. $patient->id .'/edit') }}">
					<span class="glyphicon glyphicon-edit"></span>
					{{ trans('messages.edit') }}
				</a>
				<a class="btn btn-sm btn-info" href="{{ URL::route('test.create', array('patient_id' => $patient->id)) }}">
					<span class="glyphicon glyphicon-edit"></span>
					{{ trans('messages.new-test') }}
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3 class="view"><strong>{{ trans('messages.name') }}</strong>{{ $patient->name }} </h3>
				<p class="view-striped"><strong>{{ trans('messages.patient-number') }}</strong>{{ $patient->patient_number }}</p>
				<p class="view"><strong>{{ trans('messages.external-patient-number') }}</strong>{{ $patient->external_patient_number }}</p>
				<p class="view-striped"><strong>{{ trans('messages.date-of-birth') }}</strong>{{ $patient->dob }}</p>
				<p class="view"><strong>{{ trans('messages.gender') }}</strong>{{ ($patient->gender==0?"Male":"Female") }}</p>
				<p class="view-striped"><strong>{{ trans('messages.physical-address') }}</strong>{{ $patient->address }}</p>
				<p class="view"><strong>{{ trans('messages.phone-number') }}</strong>{{ $patient->phone_number }}</p>
				<p class="view-striped"><strong>{{ trans('messages.email-address') }}</strong>{{ $patient->email }}</p>
				<p class="view"><strong>{{ trans('messages.date-created') }}</strong>{{ $patient->created_at }}</p>
			</div>
		</div>
	</div>
@stop