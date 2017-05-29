@extends("layout")
@section("content")

	<div>
		<ol class="breadcrumb">
		<li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		<li class="active">{{Lang::choice('messages.facility',2)}}</li>
		</ol>
	</div>
	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-edit"></span>
			{{ trans('messages.edit-facility') }}
		</div>
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
			{{ Form::model($task, array('route' => array('systemtask.update', $task->id),
				'method' => 'PUT', 'id' => 'form-edit-task')) }}
				<div class="form-group">
					{{ Form::label('name', trans('messages.name')) }}
					{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('name', 'Command') }}
					{{ Form::text('command', Input::old('command'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('name', 'Script Location') }}
					{{ Form::text('script_location', Input::old('script_location'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('name', 'Time Intervals') }}
					{{ Form::text('intervals', Input::old('interval'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group actions-row">
					{{ Form::button('<span class="glyphicon glyphicon-save"></span> '. trans('messages.save'),
						['class' => 'btn btn-primary', 'onclick' => 'submit()']) }}
				</div>
			{{ Form::close() }}
		</div>
	</div>
@stop