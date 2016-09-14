@extends("layout")
@section("content")

	<div>
		<ol class="breadcrumb">
		<li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		<li class="active">{{trans_choice('messages.facility',2)}}</li>
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
			{{ Form::model($facility, array('route' => array('facility.update', $facility->id),
				'method' => 'PUT', 'id' => 'form-edit-facility')) }}
				<div class="form-group">
					{{ Form::label('name', trans('messages.name')) }}
					{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group actions-row">
					{{ Form::button('<span class="glyphicon glyphicon-save"></span> '. trans('messages.save'),
						['class' => 'btn btn-primary', 'onclick' => 'submit()']) }}
				</div>
			{{ Form::close() }}
		</div>
	</div>
@stop