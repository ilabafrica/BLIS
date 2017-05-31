@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{ URL::route('calibration.index') }}">{{Lang::choice('messages.calibration',2)}}</a></li>
	  <li class="active">{{trans('messages.edit-calibration')}}</li>
	</ol>
</div>
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-edit"></span>
		{{trans('messages.edit-calibration')}}
	</div>
	{{ Form::model($calibration, array(
			'route' => array('calibration.update', $calibration->id), 'method' => 'PUT',
			'id' => 'form-edit-calibration'
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