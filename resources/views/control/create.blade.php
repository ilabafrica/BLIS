@extends("app")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{!! URL::route('user.home')!!}}">{!!trans('menu.home')!!}</a></li>
	  <li><a href="{!! URL::route('instrument.index') !!}">{!!Lang::choice('menu.control',2)!!}</a></li>
	  <li class="active">{!!trans('terms.add-control')!!}</li>
	</ol>
</div>
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-cog"></span>
		{!!trans('terms.add-control')!!}
	</div>
	{!! Form::open(array('route' => array('control.index'), 'id' => 'form-add-control')) !!}
		<div class="panel-body">
		<!-- if there are creation errors, they will show here -->
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
			<div class="form-group">
				{!! Form::label('name', Lang::choice('terms.name',1)) !!}
                {!! Form::text('name', '', array('class' => 'form-control')) !!}
			</div>
			<div class="form-group">
				{!! Form::label('description', trans('terms.description')) !!}
				{!! Form::textarea('description', '', array('class' => 'form-control', 'rows' => '3' )) !!}
			</div>
			<div class="form-group">
				{!! Form::label('lot', Lang::choice('terms.lot', 1)) !!}
				{!! Form::select('lot', $lots, array('class' => 'form-control')) !!}
			</div>
			<div class="form-group">
				{!! Form::label('measures', Lang::choice('terms.measure',2)) !!}
				<div class="form-pane panel panel-default">
					<div class="container-fluid measure-container">
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
					[
						'class' => 'btn btn-primary', 
						'onclick' => 'submit()'
					] 
				) !!}
			</div>
		</div>
	{!! Form::close() !!}
</div>
@include("control.measureCreate")
@stop