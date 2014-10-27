@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}} </a></li>
		  <li><a href="{{ URL::route('user.index') }}">{{Lang::choice('messages.user',1)}}</a></li>
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

			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<!-- For Users to edit their own profiles -->
						@if(Auth::id() == $user->id || !Entrust::hasRole(Role::getAdminRole()->name))
						<ul class="nav nav-tabs" role="tablist">
							<li class="active">
								<a href="#edit-profile" role="tab" data-toggle="tab">
									{{trans('messages.edit-profile')}}</a></li>
							<li>
								<a href="#change-password" role="tab" data-toggle="tab">
									{{trans('messages.change-password')}}</a></li>
						</ul>
						<br />
						@endif
						<div class="tab-content">
							<div class="tab-pane fade in active" id="edit-profile">
								{{ Form::model($user, array(
									'route' => array('user.update', $user->id), 
									'method' => 'PUT', 'role' => 'form', 'files' => true,
									'id' => 'form-edit-user'
								 )) }}
								<div class="container-fluid">
									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												{{ Form::label('username', trans('messages.username')) }}
												{{ Form::text('username', Input::old('username'), 
													["placeholder" => "jsiku", 'class' => 'form-control']) }}
											</div>
											<div class="form-group">
												{{ Form::label('name', trans('messages.full-name')) }}
												{{ Form::text('name', Input::old('name'), ["placeholder" => "Jay Siku",
													'class' => 'form-control']) }}
											</div>
											<div class="form-group">
												{{ Form::label('email', trans('messages.email-address')) }}
												{{ Form::email('email', Input::old('email'), 
													["placeholder" => "j.siku@ilabafrica.ac.ke",
													'class' => 'form-control']) }}
											</div>
											<div class="form-group">
												{{ Form::label('designation', trans('messages.designation')) }}
												{{ Form::text('designation', Input::old('designation'), 
													["placeholder" => "Lab Technologist", 'class' => 'form-control'])}}
											</div>
							                <div class="form-group">
							                    {{ Form::label('gender', trans('messages.gender')) }}
							                    <div>{{ Form::radio('gender', '0', true) }}<span class='input-tag'>
							                    	{{trans('messages.male')}}</span></div>
							                    <div>{{ Form::radio('gender', '1', false) }}<span class='input-tag'>
							                    	{{trans('messages.female')}}</span></div>
							                </div>
											@if(Auth::id() != $user->id && Entrust::hasRole(Role::getAdminRole()->name))
												<!-- For the administrator to reset other users' passwords -->
								                <div class="form-group">
								                	<label for="reset-password"><a class="reset-password" 
								                		href="javascript:void(0)">{{trans('messages.reset-password')}}
								                		</label></a>
													{{ Form::password('reset-password', 
														['class' => 'form-control reset-password hidden']) }}
								                </div>
							                @endif
							                <div class="form-group actions-row">
												{{ Form::button('<span class="glyphicon glyphicon-save"></span> '.
													trans('messages.update'), 
													['class' => 'btn btn-primary', 'onclick' => 'submit()']) }}
											</div>
							            </div>
										<div class="col-md-4">
											<div class="profile-photo">
								                <div class="form-group">
								                	{{ Form::label('image', trans('messages.photo')) }}
								                    {{ Form::file("image") }}
								                </div>
								                <div class="form-group">
								                	<img class="img-responsive img-thumbnail user-image"
								                		src="{{ $user->image }}" 
								                		alt="{{trans('messages.image-alternative')}}"></img>
								                </div>
											</div>
							            </div>
						            </div>
					            </div>
								{{ Form::close() }}
				            </div>
							<!-- For users to edit their own passwords -->
							<div class="tab-pane fade" id="change-password">
								{{ Form::model($user, array(
									'route' => array('user.updateOwnPassword', $user->id), 
									'method' => 'PUT', 'role' => 'form', 'id' => 'form-edit-password'
								 )) }}
								<div class="form-group">
									{{ Form::label('current-password', trans('messages.current-password')) }}
									{{ Form::password('current-password', ['class' => 'form-control']) }}
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
									<a class="btn btn-primary update-reset-password" href="javascript:void(0);">
										<span class="glyphicon glyphicon-save"></span>{{trans('messages.update')}}
									</a>
								</div>
								{{ Form::close() }}
							</div>
			            </div>
					</div>
		        </div>
			</div>
		</div>
	</div>
@stop