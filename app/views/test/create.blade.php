@extends("layout")
@section("content")

	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li>
		  	<a href="{{ URL::route('test.index') }}">{{trans('messages.tests')}}</a>
		  </li>
		  <li class="active">{{trans('messages.new-test')}}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-adjust"></span>
			{{trans('messages.new-test')}}
		</div>
		<div class="panel-body">
		<!-- if there are creation errors, they will show here -->
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif

			{{ Form::open(array('route' => 'test.saveNewTest', 'id' => 'form-new-test')) }}
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-7">
							<div class="form-group">
								{{ Form::label('specimentype', trans("messages.specimen-type")) }}
								{{ Form::select('specimentype', $specimentypes->lists('name', 'id'), null,
									 array('class' => 'form-control specimen-type')) }}
							</div>
							<div class="form-group">
								{{ Form::label('tests', trans("messages.tests")) }}
								{{ Form::select('tests', array(), null,
									 array('class' => 'form-control tests')) }}
							</div>
							<div class="form-group">
								{{ Form::label('physician', trans("messages.physician")) }}
								{{Form::text('physician', Input::old('physician'), array('class' => 'form-control'))}}
							</div>
							<div class="form-group actions-row">
								{{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
									array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
							</div>
						</div>
						<div class="col-md-5">
							<div class="panel panel-info">
								<div class="panel-heading">
									<h3 class="panel-title">{{trans("messages.patient-details")}}</h3>
								</div>
								<div class="panel-body display-details">
									<p><strong>{{trans("messages.patient-number")}}</strong> {{ $patient->patient_number }}</p>
									<p><strong>{{trans("messages.name")}}</strong> {{ $patient->name }}</p>
									<p><strong>{{trans("messages.age")}}</strong> {{ $patient->getAge() }}</p>
									<p><strong>{{trans("messages.gender")}}</strong>
										{{ $patient->gender==0?trans("messages.male"):trans("messages.female") }}</p>
								</div>
							</div>
						</div>
					</div>
				</div>

			{{ Form::close() }}
		</div>
	</div>
@stop	