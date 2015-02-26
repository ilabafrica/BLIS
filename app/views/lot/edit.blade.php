@extends("layout")
@section("content")

	<div>
		<ol class="breadcrumb">
		<li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		<li class="active">{{Lang::choice('messages.lots',2)}}</li>
		</ol>
	</div>
	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-edit"></span>
			{{ trans('messages.edit-lot') }}
		</div>
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
			{{ Form::model($lot, array('route' => array('lot.update', $lot->id), 'method' => 'PUT', 'id' => 'form-edit-lot')) }}
				<div class="form-group">
					{{ Form::label('number', trans('messages.number')) }}
					{{ Form::text('number', Input::old('number'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('description', trans('messages.description')) }}
					{{ Form::textarea('description', Input::old('description'), array('class' => 'form-control', 'rows' => '3' )) }}
				</div>
				<div class="form-group">
					{{ Form::label('instruments', trans('messages.instrument')) }}
					{{ Form::select('instrument', $instruments, Input::old('instrument'), 
					array('class' => 'form-control')) }}
				</div>
				<div class="form-group actions-row">
					{{ Form::button('<span class="glyphicon glyphicon-save"></span> '. trans('messages.save'),
						['class' => 'btn btn-primary', 'onclick' => 'submit()']) }}
				</div>
			{{ Form::close() }}
		</div>
	</div>
@stop