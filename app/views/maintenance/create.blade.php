@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{ URL::route('instrument.index') }}">{{Lang::choice('messages.instrument',2)}}</a></li>
	  <li><a href="{{ URL::route('maintenance.index') }}">{{Lang::choice('messages.maintenance',2)}}</a></li>
	  <li class="active">{{trans('messages.new-maintenance')}}</li>
	</ol>
</div>
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-cog"></span>
		{{trans('messages.new-maintenance')}}
	</div>
	{{ Form::open(array('route' => array('maintenance.index'), 'id' => 'form-add-maintenance')) }}
		<div class="panel-body">
		<!-- if there are creation errors, they will show here -->
			
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
				{{ Form::label('instrument', Lang::choice('messages.instrument_lbl',1)) }}
                {{ Form::text('instrument', Input::old('instrument'), array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('reason', Lang::choice('messages.reason',1)) }}
                {{ Form::text('reason', Input::old('reason'), array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('start', Lang::choice('messages.start',1)) }}
                {{ Form::text('start', Input::old('start'), array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('end', trans('messages.end')) }}
				{{ Form::text('end', Input::old('end'), 
					array('class' => 'form-control' )) }}
			</div>
		</div>
		<div class="panel-footer">
			<div class="form-group actions-row">
				{{ Form::button(
					'<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'),
					[
						'class' => 'btn btn-primary', 
						'onclick' => 'submit()'
					] 
				) }}
			</div>
		</div>
	{{ Form::close() }}
</div>
@stop