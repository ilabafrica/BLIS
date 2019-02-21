@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		  <li><a href="{{ URL::route('patient.index') }}">{{ Lang::choice('mH4lmapper',2) }}</a></li>
		  <li class="active">Test Type Identifier</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			New EMR Test Type Identifier
		</div>
		<div class="panel-body">
		<!-- if there are creation errors, they will show here -->
			
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif

			{{ Form::open(array('route' => 'mh4ldataelement.store')) }}
				<div class="panel-body surveillance-input">
					<div class="alert alert-danger error-div hidden">
						<ul><li>Please enter all fields</li></ul>
						@if($errors->all())
							{{ HTML::ul($errors->all()) }}
						@endif
					</div>
					<div class="row">
						<div class="col-sm-5 col-md-3">
			                <label>{{ Lang::choice('Blis Test',2) }}</label>
						</div>
						<div class="col-sm-5 col-md-3">
			                <label>{{ Lang::choice('mHealth Equivalent',2) }}</label>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-5 col-md-3">
								{{ Form::label('name', 'Name') }}
								{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
							</div>
							<div class="col-sm-5 col-md-3">
								{{ Form::label('data_element_id', 'Identifier') }}
								{{ Form::text('data_element_id', Input::old('data_element_id'), array('class' => 'form-control')) }}
							</div>
							<div class="col-md-1">
							    <button class="close" aria-hidden="true" type="button"
									title="{{trans('messages.delete')}}">×</button>
							</div>
						</div>
		            </div>
				</div>
				<div class="panel-footer">
					<div class="form-group actions-row">
						<input class="hidden" name="from-form" type="text" value="from-form">
						{{ Form::button(
							'<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'), 
							['class' => 'btn btn-primary', 'type' => 'submit']
						) }}
						{{ Form::button(trans('messages.cancel'), 
							['class' => 'btn btn-default']
						) }}
					</div>
				</div>
			{{ Form::close() }}
		</div>
	</div>
@stop	