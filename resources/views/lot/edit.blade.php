@extends("layout")
@section("content")

	<div>
		<ol class="breadcrumb">
		<li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		<li><a href="{{{URL::route('lot.index')}}}">{{trans_choice('messages.lot',2)}}</a></li>
		<li class="active">{{trans('messages.edit-lot')}}</li>
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
					{{ Form::label('number', trans('messages.lot-number')) }}
					{{ Form::text('lot_no', Input::old('lot_no'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('description', trans('messages.description')) }}
					{{ Form::textarea('description', Input::old('description'), array('class' => 'form-control', 'rows' => '3' )) }}
				</div>
				<div class="form-group">
				{{ Form::label('expiry', trans('messages.expiry')) }}
				{{ Form::text('expiry', Input::old('expiry'), 
					array('class' => 'form-control standard-datepicker', 'rows' => '3' )) }}
				</div>
				<div class="form-group actions-row">
					{{ Form::button('<span class="glyphicon glyphicon-save"></span> '. trans('messages.save'),
						['class' => 'btn btn-primary', 'onclick' => 'submit()']) }}
				</div>
			{{ Form::close() }}
		</div>
	</div>
@stop