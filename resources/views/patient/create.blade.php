@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li><a href="{!! url('patient') !!}"><i class="fa fa-street-view"></i> {!! trans('menu.patient-register') !!}</a></li>
            <li class="active">{!! trans('action.new').' '.trans_choice('menu.patient', 1) !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="card">
		<div class="card-header">
		    <i class="fa fa-pencil"></i> {!! trans('action.new').' '.trans_choice('menu.patient', 1) !!} 
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
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
            </div>
            @endif

			{!! Form::open(array('route' => 'patient.store', 'id' => 'form-create-patient')) !!}
				<!-- CSRF Token -->
                <input type="hidden" name="_token" value="{!! csrf_token() !!}}" />
                <!-- ./ csrf token -->
                <div class="form-group row">
					{!! Form::label('patient_number', trans('specific-terms.patient-no'), array('class' => 'col-sm-2 form-control-label')) !!}
					<div class="col-sm-6">
						{!! Form::text('patient_number', $lastInsertId, array('class' => 'form-control')) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('name', trans_choice('general-terms.name',1), array('class' => 'col-sm-2 form-control-label')) !!}
					<div class="col-sm-6">
						{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
					</div>
				</div>
                <div class="form-group row">
                    {!! Form::label('dob', trans('specific-terms.date-of-birth'), array('class' => 'col-sm-2 form-control-label')) !!}
                    <div class="col-sm-6 input-group date datepicker"  style="padding-left:15px;">
                        {!! Form::text('dob', old('dob'), array('class' => 'form-control')) !!}
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('gender', trans('general-terms.gender'), array('class' => 'col-sm-2 form-control-label')) !!}
                    <div class="col-sm-6">
                        <label class="radio-inline">{!! Form::radio('gender', App\Models\User::MALE, true) !!}{!! trans_choice('specific-terms.sex', 1) !!}</label>
                        <label class="radio-inline">{!! Form::radio("gender", App\Models\User::FEMALE, false) !!}{!! trans_choice('specific-terms.sex', 2) !!}</label>
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('phone', trans('specific-terms.phone'), array('class' => 'col-sm-2 form-control-label')) !!}
                    <div class="col-sm-6">
                        {!! Form::text('phone', old('phone'), array('class' => 'form-control')) !!}
                    </div>
                </div>
				<div class="form-group row">
					{!! Form::label('address', trans("specific-terms.address"), array('class' => 'col-sm-2 form-control-label')) !!}</label>
					<div class="col-sm-6">
						{!! Form::textarea('address', old('address'), array('class' => 'form-control', 'rows' => '2')) !!}
					</div>
				</div>
				<div class="form-group row col-sm-offset-2">
					{!! Form::button("<i class='fa fa-plus-circle'></i> ".trans('action.save'), 
						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
					<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
				</div>

			{!! Form::close() !!}
	  	</div>
	</div>
</div>
@endsection	