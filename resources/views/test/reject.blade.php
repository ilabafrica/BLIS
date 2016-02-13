@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li><a href="{!! url('test') !!}"><i class="fa fa-user-md"></i> {!! trans_choice('menu.test', 2) !!}</a></li>
            <li class="active">{!! trans('menu.specimen-rejection') !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="card">
		<div class="card-header">
		    <i class="fa fa-stop-cirle"></i> {!! $specimen->test->visit->patient->name.' - '.$specimen->specimenType->name !!}
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
            <div class="row">
	            <div class="col-md-8">
				{!! Form::open(array('route' => 'test.rejectAction')) !!}
					<!-- CSRF Token -->
	                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	                <!-- ./ csrf token -->
					{!! Form::hidden('specimen_id', $specimen->id) !!}
	                <div class="form-group row">
						{!! Form::label('rejectionReason', trans('general-terms.reject-reason'), array('class' => 'col-sm-3 form-control-label')) !!}
						<div class="col-sm-9">
							{!! Form::select('rejectionReason', $reasons, old('rejectionReason'), array('class' => 'form-control c-select')) !!}
						</div>
					</div>
					<div class="form-group row">
						{!! Form::label('reject_explained_to', trans("general-terms.explained-to"), array('class' => 'col-sm-3 form-control-label')) !!}
						<div class="col-sm-9">
							{!!Form::text('reject_explained_to', old('reject_explained_to'), array('class' => 'form-control'))!!}
						</div>
					</div>
					<div class="form-group row" align="right">
						{!! Form::button("<i class='fa fa-plus-circle'></i> ".trans('action.save'), 
							array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
						<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
					</div>
				{!! Form::close() !!}
				</div>
				<div class="col-md-4">
					<ul class="list-group">
						<li class="list-group-item"><strong>{!! trans_choice('menu.specimen-type', 1).': '.$specimen->specimenType->name !!}</strong></li>
						<li class="list-group-item"><h6>{!! trans("specific-terms.specimen-id") !!}<small> {!! $specimen->id !!}</small></h6></li>
						<li class="list-group-item"><h6>{!! trans_choice('menu.test-type', 1) !!}<small> {!! $specimen->test->testType->name !!}</small></h6></li>
					</ul>
				</div>
			</div>
	  	</div>
	</div>
</div>
@endsection	