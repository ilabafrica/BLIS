@extends("app")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{!! URL::route('user.home')!!}">{!!trans('menu.home')!!}</a></li>
	  <li><a href="{!! URL::route('control.index') !!}">{!! trans_choice('menu.control',1) !!}</a></li>
	  <li class="active">{!!trans('terms.edit-control')!!}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{!! Session::get('message') !!}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-edit"></span>
		{!!trans('terms.edit-control')!!}
	</div>
	{!! Form::model($control, array(
			'route' => array('control.update', $control->id), 'method' => 'PUT',
			'id' => 'form-edit-control'
		)) !!}
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{!! HTML::ul($errors->all()) !!}
				</div>
			@endif

			<div class="form-group">
				{!! Form::label('name', trans_choice('terms.name',1)) !!}
				{!! Form::text('name', Input::old('name'), array('class' => 'form-control')) !!}
			</div>
			<div class="form-group">
				{!! Form::label('description', trans('terms.description')) !!}
				{!! Form::textarea('description', Input::old('description'), 
					array('class' => 'form-control', 'rows' => '2' )) !!}
			</div>
			<div class="form-group">
					{!! Form::label('lot', trans_choice('terms.lot', 1)) !!}
					{!! Form::select('lot', $lots, Input::old('lot'), 
					array('class' => 'form-control')) !!}
			</div>
			<div class="form-group">
				{!! Form::label('measures', trans_choice('terms.measure',2)) !!}
				<div class="form-pane panel panel-default">
					<div class="container-fluid measure-container">
						@include("control.measureEdit")
					</div>
			        <a class="btn btn-default add-another-measure" href="javascript:void(0);" data-new-measure="1">
			        	<span class="glyphicon glyphicon-plus-sign"></span>{!!trans('terms.add-new-measure')!!}</a>
				</div>
			</div>
		</div>
		<div class="panel-footer">
			<div class="form-group actions-row">
				{!! Form::button(
					'<span class="glyphicon glyphicon-save"></span> '.trans('action.save'), 
					['class' => 'btn btn-primary', 'onclick' => 'submit()']
				) !!}
				{!! Form::button(trans('action.cancel'), 
					['class' => 'btn btn-default', 'onclick' => 'javascript:history.go(-1)']
				) !!}
			</div>
		</div>
	{!! Form::close() !!}
</div>
@include("control.measureCreate")
@stop