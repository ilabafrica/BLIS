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

			{{ Form::open(array('route' => 'testcategory.store', 'id' => 'form-new-test')) }}
				<div class="form-group">
					{{ Form::label('patient', trans("messages.patient-name")) }}
					{{ Form::text('patient', Input::old('patient'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('specimentype', trans("messages.specimen-type")) }}
					{{ Form::select('specimentype', $specimentypes->lists('name'), null, array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('tests', trans("messages.tests")) }}
					{{Form::text('tests', Input::old('tests'), array('class' => 'form-control'))}}
				</div>
				<div class="form-group">
					{{ Form::label('physician', trans("messages.physician")) }}
					{{Form::text('physician', Input::old('physician'), array('class' => 'form-control'))}}
				</div>
				<div class="form-group actions-row">
					{{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
						array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
				</div>

			{{ Form::close() }}
		</div>
	</div>
@stop	