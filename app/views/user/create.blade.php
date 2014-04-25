@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="#">Home</a></li>
		  <li><a href="{{ URL::to('user') }}">User</a></li>
		  <li class="active">Create User</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			Create User
		</div>
		<div class="panel-body">
		<!-- if there are creation errors, they will show here -->
			
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif

			{{ Form::open(array('url' => 'user')) }}

				<div class="form-group">
					{{ Form::label('username', 'Username') }}
					{{ Form::text('username', Input::old('username'), ["placeholder" => "jsiku", 'class' => 'form-control']) }}
				</div>
				<div class="form-group">
					{{ Form::label('name', 'Full Name') }}
					{{ Form::text('name', Input::old('name'), ["placeholder" => "Jay Siku", 'class' => 'form-control']) }}
				</div>
				<div class="form-group">
					{{ Form::label('email', 'Email Address') }}
					{{ Form::email('email', Input::old('email'), ["placeholder" => "j.siku@ilabafrica.ac.ke", 'class' => 'form-control']) }}
				</div>
				<div class="form-group">
					{{ Form::label('designation', 'Designation') }}
					{{ Form::text('designation', Input::old('designation'), ["placeholder" => "Lab Technologist", 'class' => 'form-control']) }}
				</div>
                <div class="form-group">
                    {{ Form::label('gender', 'Gender: ') }}
                    <div>{{ Form::radio('gender', '0', true) }} Male</div>
                    <div>{{ Form::radio("gender", '1', false) }} Female</div>
                </div>
                <div class="form-group">
                	{{ Form::label('image', 'Photo: ') }}
                    {{ Form::file("image") }}
                </div>
				<div class="form-group actions-row">
					{{ Form::button('<span class="glyphicon glyphicon-save"></span> Save', array('class' => 'btn btn-primary', 'type' => 'submit')) }}
				</div>

			{{ Form::close() }}
		</div>
	</div>
@stop
