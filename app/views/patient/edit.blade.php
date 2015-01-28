@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li><a href="{{ URL::route('patient.index') }}">{{ Lang::choice('messages.patient',2)}}</a></li>
		  <li class="active">{{trans('messages.edit-patient')}}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-edit"></span>
			{{trans('messages.edit-patient-details')}}
		</div>
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
			{{ Form::model($patient, array('route' => array('patient.update', $patient->id), 'method' => 'PUT',
				'id' => 'form-edit-patient')) }}

				<div class="form-group">
					{{ Form::label('patient_number', trans('messages.patient-number')) }}
					{{ Form::text('patient_number', Input::old('patient_number'), 
						array('class' => 'form-control', 'readonly')) }}
				</div>
				<div class="form-group">
					{{ Form::label('name', Lang::choice('messages.name',1)) }}
					{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('dob', trans('messages.date-of-birth')) }}
					{{ Form::text('dob', Input::old('dob'), array('class' => 'form-control standard-datepicker')) }}
				</div>
                <div class="form-group">
                    {{ Form::label('gender', trans('messages.gender')) }}
                    <div>{{ Form::radio('gender', '0', true) }}
                    	<span class="input-tag">{{trans('messages.male')}}</span></div>
                    <div>{{ Form::radio("gender", '1', false) }}
                    	<span class="input-tag">{{trans('messages.female')}}</span></div>
                </div>
				<div class="form-group">
					{{ Form::label('address', trans('messages.physical-address')) }}
					{{ Form::text('address', Input::old('address'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('phone_number', trans('messages.phone-number')) }}
					{{ Form::text('phone_number', Input::old('phone_number'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('email', trans('messages.email-address')) }}
					{{ Form::email('email', Input::old('email'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group actions-row">
					{{ Form::button('<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'),
						 array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
				</div>

			{{ Form::close() }}
		</div>
	</div>
@stop	