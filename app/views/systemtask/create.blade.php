@extends("layout")
@section("content")

	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li class="active"><a href="{{ URL::route('facility.index') }}">{{Lang::choice('messages.task',2)}}</a></li>
		  <li class="active">{{trans('messages.add-task')}}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-adjust"></span>
			{{trans('messages.add-task')}}
		</div>
		<div class="panel-body">
		<!-- if there are creation errors, they will show here -->
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif

			{{ Form::open(array('route' => 'systemtask.store', 'id' => 'form-add-task')) }}

				<div class="form-group">
					{{ Form::label('name', Lang::choice('messages.name',2)) }}
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
					{{ Form::text('interval', Input::old('interval'), array('class' => 'form-control', 'placeholder'=>'Choose between 0-59 minutes')) }}
				</div>
				<div class="form-group actions-row">
					{{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
						array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
				</div>

			{{ Form::close() }}
		</div>
	</div>
@stop