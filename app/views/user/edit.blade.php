@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li><a href="{{ URL::route('user.index') }}">{{trans('messages.user')}}</a></li>
		  <li class="active">{{trans('messages.edit-user')}}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-edit"></span>
			{{trans('messages.edit-user-details')}}
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
							{{ Form::label('username', trans('messages.username')) }}
							{{ Form::text('username', Input::old('username'), ["placeholder" => "jsiku", 'class' => 'form-control']) }}
						</div>
						<div class="form-group">
							{{ Form::label('name', trans('messages.full-name')) }}
							{{ Form::text('name', Input::old('name'), ["placeholder" => "Jay Siku", 'class' => 'form-control']) }}
						</div>
						<div class="form-group">
							{{ Form::label('email', trans('messages.email-address')) }}
							{{ Form::email('email', Input::old('email'), ["placeholder" => "j.siku@ilabafrica.ac.ke", 'class' => 'form-control']) }}
						</div>
						<div class="form-group">
							{{ Form::label('designation', trans('messages.designation')) }}
							{{ Form::text('designation', Input::old('designation'), ["placeholder" => "Lab Technologist", 'class' => 'form-control']) }}
						</div>
		                <div class="form-group">
		                    {{ Form::label('gender', trans('messages.gender')) }}
		                    <div>{{ Form::radio('gender', '0', true) }}<span class='input-tag'>Male</span></div>
		                    <div>{{ Form::radio("gender", '1', false) }}<span class='input-tag'>Female</span></div>
		                </div>
					<div class="form-group">
					    {{ Form::label('verify', trans('messages.can-verify-results')) }}
					    {{Form::checkbox('verify', '1' ) }}<span class='checkbox-label'>Yes</span>
					</div>
		            </div>
					<div class="col-md-6">
		                <div class="form-group">
		                	{{ Form::label('image', trans('messages.photo')) }}
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
						{{ Form::button('<span class="glyphicon glyphicon-save"></span>'.trans('messages.update'), array(
								'class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
						</div>
					</div>
				</div>
			</div>
			{{ Form::close() }}
		</div>
	</div>
@stop