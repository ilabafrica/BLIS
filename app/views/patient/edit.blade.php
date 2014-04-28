@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="#">Home</a></li>
		  <li><a href="{{ URL::to('patient') }}">Patient</a></li>
		  <li class="active">Edit Patient</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-edit"></span>
			Edit Patient Details
		</div>
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
			{{ Form::model($patient, array('route' => array('patient.update', $patient->id), 'method' => 'PUT')) }}

				<div class="form-group">
					{{ Form::label('patient_number', 'Patient Number') }}
					{{ Form::text('patient_number', Input::old('patient_number'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('name', 'Name') }}
					{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('dob', 'Date of Birth') }}
					{{ Form::text('dob', Input::old('dob'), array('class' => 'form-control standard-datepicker')) }}
				</div>
                <div class="form-group">
                    {{ Form::label('gender', 'Gender: ') }}
                    <div>{{ Form::radio('gender', '0', true) }} Male</div>
                    <div>{{ Form::radio("gender", '1', false) }} Female</div>
                </div>
				<div class="form-group">
					{{ Form::label('address', 'Physical Address') }}
					{{ Form::text('address', Input::old('address'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('phone_number', 'Phone Number') }}
					{{ Form::text('phone_number', Input::old('phone_number'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('email', 'Email Address') }}
					{{ Form::email('email', Input::old('email'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group actions-row">
					{{ Form::button('<span class="glyphicon glyphicon-save"></span> Save', array('class' => 'btn btn-primary', 'type' => 'submit')) }}
				</div>

			{{ Form::close() }}
		</div>
	</div>
@stop