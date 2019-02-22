@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
			<li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
			<li><a href="{{ URL::route('tpaaccess.index') }}">Third Party Accesses</a></li>
			<li class="active">Third Party Access Create</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			Third Party Access Create
		</div>
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
			{{ Form::open(array('route' => 'tpaaccess.store')) }}
				<div class="panel-body">
					<div class="alert alert-danger error-div hidden">
						<ul><li>Please enter all fields</li></ul>
						@if($errors->all())
							{{ HTML::ul($errors->all()) }}
						@endif
					</div>
					<div class="form-group">
						<select class="form-control" name="user_id"> 
							<option value="0"></option>
							@foreach ($users as $user)
								<option value="{{ $user->id }}"
									{{ $user->name }}
								</option>
							@endforeach
						</select>
						<div class="form-group">
							{{ Form::label('username', 'Username') }}
							{{ Form::text('username', Input::old('username'), array('class' => 'form-control')) }}
						</div>
						<div class="form-group">
							{{ Form::label('email', 'Email') }}
							{{ Form::text('email', Input::old('email'), array('class' => 'form-control')) }}
						</div>
						<div class="form-group">
							{{ Form::label('password', 'Password') }}
							{{ Form::text('password', Input::old('password'), array('class' => 'form-control')) }}
						</div>
						<select class="form-control" name="grant_type"> 
							<option value="0"></option>
							@foreach ($grantTypes as $grantType)
								<option value="{{ $grantType }}"
									{{ $grantType }}
								</option>
							@endforeach
						</select>
						<div class="form-group">
							{{ Form::label('client_id', 'Client Id') }}
							{{ Form::text('client_id', Input::old('client_id'), array('class' => 'form-control')) }}
						</div>
						<div class="form-group">
							{{ Form::label('client_secret', 'Client Secret') }}
							{{ Form::text('client_secret', Input::old('client_secret'), array('class' => 'form-control')) }}
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<div class="form-group actions-row">
						<input class="hidden" name="from-form" type="text" value="from-form">
						{{ Form::button(
							'<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'), 
							['class' => 'btn btn-primary', 'type' => 'submit']
						)}}
					</div>
				</div>
			{{ Form::close() }}
		</div>
	</div>
@stop