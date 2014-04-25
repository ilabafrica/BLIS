@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="#">Home</a></li>
		  <li><a href="{{ URL::to('specimentype') }}">Specimen Type</a></li>
		  <li class="active">Edit Specimen Type</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-edit"></span>
			Edit Specimen Type
		</div>
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
			{{ Form::model($specimentype, array('route' => array('specimentype.update', $specimentype->id), 'method' => 'PUT')) }}

				<div class="form-group">
					{{ Form::label('name', 'Name') }}
					{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('description', 'Description') }}
					{{ Form::textarea('description', Input::old('description'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group actions-row">
					{{ Form::button('<span class="glyphicon glyphicon-save"></span> Save', array('class' => 'btn btn-primary', 'type' => 'submit')) }}
				</div>

			{{ Form::close() }}
		</div>
	</div>
@stop