@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{ URL::route('maintenance.index') }}">{{Lang::choice('messages.maintenance',2)}}</a></li>
	  <li class="active">{{trans('messages.edit-maintenance')}}</li>
	</ol>
</div>
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-edit"></span>
		{{trans('messages.edit-maintenance')}}
	</div>
	{{ Form::model($maintenance, array(
			'route' => array('maintenance.update', $maintenance->id), 'method' => 'PUT',
			'id' => 'form-edit-maintenance'
		)) }}
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif

			<div class="form-group">
				{{ Form::label('performed_by', Lang::choice('messages.performed_by',1)) }}
				{{ Form::text('performed_by', Input::old('performed_by'), array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('instrument', trans('messages.instrument')) }}
				{{ Form::textarea('instrument', Input::old('instrument'), 
					array('class' => 'form-control', 'rows' => '2' )) }}
			</div>
			<div class="form-group">
				{{ Form::label('reason', trans('messages.reason')) }}
				{{ Form::text('reason', Input::old('reason'), array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('start', trans('messages.start')) }}
				{{ Form::text('start', Input::old('start'), array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('end', trans('messages.end')) }}
				{{ Form::text('end', Input::old('end'), array('class' => 'form-control')) }}
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