@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{ URL::route('instrument.index') }}">{{Lang::choice('messages.instrument',2)}}</a></li>
	  <li class="active">{{trans('messages.edit-instrument')}}</li>
	</ol>
</div>
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-edit"></span>
		{{trans('messages.edit-instrument')}}
	</div>
	{{ Form::model($instrument, array(
			'route' => array('instrument.update', $instrument->id), 'method' => 'PUT',
			'id' => 'form-edit-instrument'
		)) }}
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif

			<div class="form-group">
				{{ Form::label('name', Lang::choice('messages.name',1)) }}
				{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('description', trans('messages.description')) }}
				{{ Form::textarea('description', Input::old('description'), 
					array('class' => 'form-control', 'rows' => '2' )) }}
			</div>
			<div class="form-group">
				{{ Form::label('ip', trans('messages.ip')) }}
				{{ Form::text('ip', Input::old('ip'), array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('hostname', trans('messages.host-name')) }}
				{{ Form::text('hostname', Input::old('hostname'), array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('test_types', trans('messages.supported-test-types')) }}
				{{ Form::text('test_types', implode(",", $instrument->testTypes()->lists('name')),
					 array('class' => 'form-control', 'readonly')) }}
			</div>
		</div>
		<div class="panel-footer">
			<div class="form-group actions-row">
				{{ Form::button('<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'), 
					['class' => 'btn btn-primary', 'onclick' => 'submit()']
				) }}
				{{ Form::button(trans('messages.cancel'), 
					['class' => 'btn btn-default', 'onclick' => 'javascript:history.go(-1)']
				) }}
			</div>
		</div>
	{{ Form::close() }}
</div>
@stop