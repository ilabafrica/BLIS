@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}} </a></li>
		  <li><a href="{{ URL::route('user.index') }}">{{trans('messages.user')}}</a></li>
		  <li class="active">{{trans('messages.edit-user')}}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-edit"></span>
			{{trans('messages.edit-user-details')}}
		</div>
		<div class="panel-body 
			{{(Auth::id() == $user->id || !Entrust::hasRole(Role::getAdminRole()->name)) ? 'user-profile': ''}}">
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
					@if(Auth::id() == $user->id || !Entrust::hasRole(Role::getAdminRole()->name))
					<div class="col-md-2 profile-tabs">
						<!-- For Users to edit thier own profiles -->
						<a class="edit-user active" id="edit-profile" href="javascript:void(0)">
							{{trans('messages.edit-profile')}}
						</a>
						<a class="edit-user" id="change-password" href="javascript:void(0)">
							{{trans('messages.change-password')}}
						</a>
					</div>
					@endif
					<div class="col-md-10">
						<div class="row profile-pane">
							<div class="col-md-8">
								<br>
								<div class="edit-profile">
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
					                    <div>{{ Form::radio('gender', '0', true) }}<span class='input-tag'>{{trans('messages.male')}}</span></div>
					                    <div>{{ Form::radio('gender', '1', false) }}<span class='input-tag'>{{trans('messages.female')}}</span></div>
					                </div>
									@if(Auth::id() != $user->id && Entrust::hasRole(Role::getAdminRole()->name))
									<!-- For the administrator to reset other users' passwords -->
					                <div class="form-group">
					                	<label for="reset-password"><a class="reset-password" href="javascript:void(0)">{{trans('messages.reset-password')}}</label></a>
										{{ Form::password('reset-password', ['class' => 'form-control reset-password hidden']) }}
					                </div>
					                @endif
					                <div class="form-group actions-row">
										<a class="btn btn-primary submit-profile-edit" href="javascript:void(0);">
											<span class="glyphicon glyphicon-save"></span>{{trans('messages.update')}}
										</a>
									</div>
								</div>	
								@if(Auth::id() == $user->id || !Entrust::hasRole(Role::getAdminRole()->name))
								<!-- For users to edit thier own passwords -->
								<div class="change-pass hidden">
									<div class="form-group">
										{{ Form::label('current-password', trans('messages.current-password')) }}
										{{ Form::password('current-password', ['class' => 'form-control']) }}
										<!-- Input to indicate change of password to the User Contorller -->
										<input class="form-control change-pass-trigger hidden" name="passwordedit" type="text" id="current-password">
										<span class="curr-pwd-empty hidden" >{{trans('messages.field-required')}}</span>
									</div>
									<div class="form-group">
										{{ Form::label('new-password', trans('messages.new-password')) }}
										{{ Form::password('new-password', ['class' => 'form-control']) }}
										<span class="new-pwd-empty hidden" >{{trans('messages.field-required')}}</span>
									</div>
									<div class="form-group">
										{{ Form::label('repeat-password', trans('messages.re-enter-password')) }}
										{{ Form::password('repeat-password', ['class' => 'form-control']) }}
										<span class="new-pwdrepeat-empty hidden" >{{trans('messages.field-required')}}</span>
										<span class="new-pwdmatch-error hidden" >{{trans('messages.password-mismatch')}}</span>
									</div>
									<div class="form-group actions-row">
										<a class="btn btn-primary submit-profile-edit" href="javascript:void(0);">
											<span class="glyphicon glyphicon-save"></span>{{trans('messages.update')}}
										</a>
									</div>
								</div>
								@endif
				            </div>
							<div class="col-md-4">
								<div class="profile-photo">
					                <div class="form-group">
					                	{{ Form::label('image', trans('messages.photo')) }}
					                    {{ Form::file("image") }}
					                </div>
					                <div class="form-group">
					                	<img class="img-responsive img-thumbnail user-image" src="{{ $user->image }}" alt="{{trans('messages.image-alternative')}}"></img>
					                </div>
								</div>
				            </div>
			            </div>
		            </div>
		        </div>
			</div>
			{{ Form::close() }}
		</div>
	</div>
@stop