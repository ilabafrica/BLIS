@extends("app")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{ URL::route('instrument.index') }}">{{Lang::choice('messages.lot',2)}}</a></li>
	  <li class="active">{{trans('messages.add-lot')}}</li>
	</ol>
</div>
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-cog"></span>
		{{trans('messages.add-lot')}}
	</div>
	{{ Form::open(array('route' => array('lot.index'), 'id' => 'form-add-lot')) }}
		<div class="panel-body" id="lot-create">
		<!-- if there are creation errors, they will show here -->
			
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
			<div class="form-group">
				{{ Form::label('number', Lang::choice('messages.lot-number',1)) }}
                {{ Form::text('number', Input::old('number'), array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('description', trans('messages.description')) }}
				{{ Form::textarea('description', Input::old('description'), 
					array('class' => 'form-control', 'rows' => '3' )) }}
			</div>
			<div class="form-group">
				{{ Form::label('expiry', trans('messages.expiry-date')) }}
				{{ Form::text('expiry', Input::old('expiry'), 
					array('class' => 'form-control standard-datepicker', 'rows' => '3' )) }}
			</div>
			<div class="form-group">
				{{ Form::label('instruments', Lang::choice('messages.instrument', 2)) }}
				{{ Form::select('instrument', array('') + $instruments, Input::old('instrument'), 
					array('class' => 'form-control')) }}
			</div>
			<div class="form-group" id="edit-control-ranges">
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