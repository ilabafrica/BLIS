@extends("layout")
@section("content")

	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		  <li>
		  	<a href="{{ URL::route('specimenrejection.index') }}">{{ trans('messages.specimen-rejection') }}</a>
		  </li>
		  <li class="active">{{trans('messages.add-rejection-reason')}}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-adjust"></span>
			{{ trans('messages.add-rejection-reason') }}
		</div>
		<div class="panel-body">
		<!-- if there are creation errors, they will show here -->
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif

			{{ Form::open(array('route' => 'specimenrejection.store', 'id' => 'form-add-rejection-reason')) }}

				<div class="form-group">
					{{ Form::label('reason', trans('messages.rejection-reason')) }}
					{{ Form::text('reason', Input::old('reason'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group actions-row">
					{{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
						array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
				</div>

			{{ Form::close() }}
		</div>
	</div>
@stop	
