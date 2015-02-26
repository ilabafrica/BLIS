@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{ URL::route('instrument.index') }}">{{Lang::choice('messages.control',2)}}</a></li>
	  <li class="active">{{trans('messages.add-control')}}</li>
	</ol>
</div>
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-cog"></span>
		{{trans('messages.add-control')}}
	</div>
	{{ Form::open(array('route' => array('control.index'), 'id' => 'form-add-control')) }}
		<div class="panel-body">
		<!-- if there are creation errors, they will show here -->
			
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
					array('class' => 'form-control', 'rows' => '3' )) }}
			</div>
			<div class="form-group">
				{{ Form::label('instruments', trans('messages.instrument')) }}
				{{ Form::select('instrument', array('') + $instruments, Input::old('instrument'), 
					array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('measures', Lang::choice('messages.measure',2)) }}
				<div class="form-pane panel panel-default">
					<div class="container-fluid measure-container">
					</div>
		        	<a class="btn btn-default add-control-measure" href="javascript:void(0);" data-new-measure="1">
		         		<span class="glyphicon glyphicon-plus-sign"></span>{{trans('messages.add-new-measure')}}</a>
				</div>
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
@include("control.measureCreate")
@stop