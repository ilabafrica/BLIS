@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li class="active"><i class="fa fa-users"></i> {!! trans('menu.access-control') !!}</li>
            <li><a href="{!! route('user.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.user', 2) !!}</a></li>
            <li class="active">{!! trans('action.new').' '.trans_choice('menu.user', 1) !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="card">
		<div class="card-header">
		    <i class="fa fa-pencil"></i> {!! trans('action.new').' '.trans_choice('menu.user', 1) !!} 
		    <span>
				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
					<i class="fa fa-step-backward"></i>
					{!! trans('action.back') !!}
				</a>				
			</span>
		</div>
	  	<div class="card-block">	  		  		
			<!-- if there are creation errors, they will show here -->
			@if($errors->all())
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
            </div>
            @endif
			<div class="row">
				{!! Form::model($user, array('route' => array('user.update', $user->id), 
        		'method' => 'PUT', 'enctype' => 'multipart/form-data', 'id' => 'form-edit-user', 'class' => 'form-horizontal', 'files' => 'true')) !!}
				<!-- CSRF Token -->
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                <!-- ./ csrf token -->
				<div class="col-md-8"> 
					<div class="form-group row">
						{!! Form::label('name', trans_choice('general-terms.name',1), array('class' => 'col-sm-4 form-control-label')) !!}
						<div class="col-sm-6">
							{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
						</div>
					</div>
					<div class="form-group row">
						{!! Form::label('gender', trans('specific-terms.gender'), array('class' => 'col-sm-4 form-control-label')) !!}
						<div class="col-sm-6">
							<label class="radio-inline">{!! Form::radio('gender', App\Models\User::MALE, true) !!}{{ trans_choice('specific-terms.sex', 1) }}</label>
	                        <label class="radio-inline">{!! Form::radio("gender", App\Models\User::FEMALE, false) !!}{{ trans_choice('specific-terms.sex', 2) }}</label>
						</div>
					</div>
					<div class="form-group row">
						{!! Form::label('email', trans('specific-terms.email-address'), array('class' => 'col-sm-4 form-control-label')) !!}
						<div class="col-sm-6">
							{!! Form::text('email', old('email'), array('class' => 'form-control')) !!}
						</div>
					</div>
	                <div class="form-group row">
	                    {!! Form::label('phone', trans('specific-terms.phone'), array('class' => 'col-sm-4 form-control-label')) !!}
	                    <div class="col-sm-6">
	                        {!! Form::text('phone', old('phone'), array('class' => 'form-control')) !!}
	                    </div>
	                </div>
	                <div class="form-group row">
	                    {!! Form::label('address', trans('specific-terms.address'), array('class' => 'col-sm-4 form-control-label')) !!}
	                    <div class="col-sm-6">
	                        {!! Form::textarea('address', old('address'), 
	                            array('class' => 'form-control', 'rows' => '3')) !!}
	                    </div>
	                </div>
	                <div class="form-group row">
	                    {!! Form::label('username', trans('specific-terms.username'), array('class' => 'col-sm-4 form-control-label')) !!}
	                    <div class="col-sm-6">
	                        {!! Form::text('username', old('username'), array('class' => 'form-control')) !!}
	                    </div>
	                </div>
	                <div class="form-group row">
	                    <div class="col-sm-offset-4 col-sm-6">
	                        <label class="checkbox-inline">
	                            {!! Form::checkbox("default_password", '1', '', array('onclick' => 'toggle(".pword", this)')) !!}{{ trans('specific-terms.use-default') }}
	                        </label>
	                    </div>
	                </div>
	                <div class="pword">
		                <div class="form-group row">
		                    {!! Form::label('password', trans_choice('specific-terms.password', 1), array('class' => 'col-sm-4 form-control-label')) !!}
		                    <div class="col-sm-6">
		                        {!! Form::password('password', array('class' => 'form-control')) !!}
		                    </div>
		                </div>
		                <div class="form-group row">
		                    {!! Form::label('password_confirmation', trans_choice('specific-terms.password', 2), array('class' => 'col-sm-4 form-control-label')) !!}
		                    <div class="col-sm-6">
		                        {!! Form::password('password_confirmation', array('class' => 'form-control')) !!}
		                    </div>
		                </div>
	                </div>
					<div class="form-group row col-sm-offset-4 col-sm-8">
						{!! Form::button("<i class='fa fa-check-circle'></i> ".trans('action.update'), 
						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
						<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
					</div>
				</div>				
		        <div class="col-md-4">
		            <div class="row">
		                <div class="col-md-12">
		                    <div class="thumbnail">
		                        {!! HTML::image('images/profile1.jpg', trans('specific-terms.no-photo'), array('class'=>'img-responsive img-thumbnail user-image')) !!}
		                    </div>
		                </div>
		                <div class="col-md-8 col-sm-offset-1">
		                    <div class="form-group">
		                        <label>{{ trans('specific-terms.profile-photo') }}</label>
		                        {!! Form::file('photo', null, ['class' => 'form-control']) !!}
		                    </div>
		                </div>
		            </div>
		        </div>
				{!! Form::close() !!}
			</div>
	  	</div>
	</div>
</div>
@endsection	