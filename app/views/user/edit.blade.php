@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">Home</a></li>
		  <li><a href="{{ URL::route('user.index') }}">User</a></li>
		  <li class="active">Edit User</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-edit"></span>
			Edit User Details
		</div>
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
			{{ Form::model($user, array(
				'route' => array('user.update', $user->id), 
				'method' => 'PUT', 'role' => 'form', 'files' => true,
				'id' => 'form-edit-user'
			 )) }}

			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6">
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
		                    <div>{{ Form::radio('gender', '0', true) }}<span class='input-tag'>Male</span></div>
		                    <div>{{ Form::radio("gender", '1', false) }}<span class='input-tag'>Female</span></div>
		                </div>
					<div class="form-group">
					    {{ Form::label('verify', 'Can verify results: ') }}
					    {{Form::checkbox('verify', '1' ) }}&nbsp;&nbsp;&nbsp;&nbsp;Yes
					</div>
		            </div>
					<div class="col-md-6">
		                <div class="form-group">
		                	{{ Form::label('image', 'Photo: ') }}
		                    {{ Form::file("image") }}
		                </div>
		                <div class="form-group">
		                	<img class="img-responsive img-thumbnail user-image" src="{{ $user->image }}" alt="No photo available"></img>
		                </div>
		            </div>
		        </div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group actions-row">
							{{ Form::button('<span class="glyphicon glyphicon-save"></span> Update', array(
								'class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
						</div>
					</div>
				</div>
			</div>
			{{ Form::close() }}
		</div>
	</div>
@stop