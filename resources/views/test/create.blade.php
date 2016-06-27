@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li><a href="{!! url('test') !!}"><i class="fa fa-user-md"></i> {!! trans_choice('menu.test', 2) !!}</a></li>
            <li class="active">{!! trans('action.new').' '.trans_choice('menu.test', 1) !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="card">
		<div class="card-header">
		    <i class="fa fa-pencil"></i> {!! trans('action.new').' '.trans_choice('menu.test', 1) !!} 
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
            <ul class="list-group" style="padding-bottom:5px;">
			  	<li class="list-group-item"><strong>{!! trans('terms.details-for').': '.$patient->name !!}</strong></li>
			  	<li class="list-group-item">
			  		<h6>
			  			<span>{!! trans("terms.patient-no") !!}<small> {!! $patient->patient_number !!}</small></span>
			  			<span>{!! trans("terms.name") !!}<small> {!! $patient->name !!}</small></span>
			  			<span>{!! trans("terms.age") !!}<small> {!! $patient->getAge() !!}</small></span>
			  			<span>{!! trans("terms.gender") !!}<small> {!! ($patient->gender==0?trans_choice('terms.sex', 1):trans_choice('terms.sex', 2)) !!}</small></span>
			  		</h6>
			  	</li>
			</ul>
			{!! Form::open(array('route' => 'test.saveNewTest', 'id' => 'form-new-test')) !!}
				<!-- CSRF Token -->
                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
                <!-- ./ csrf token -->
                {!! Form::hidden('patient_id', $patient->id) !!}
                <div class="form-group row">
					{!! Form::label('visit_type', trans('terms.visit-type'), array('class' => 'col-sm-2 form-control-label')) !!}
					<div class="col-sm-6">
						{!! Form::select('visit_type', [' ' => '--- Select visit type ---','0' => trans("terms.out-patient"),'1' => trans("terms.in-patient")], null, array('class' => 'form-control c-select')) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('physician', trans("terms.physician"), array('class' => 'col-sm-2 form-control-label')) !!}
					<div class="col-sm-6">
						{!!Form::text('physician', old('physician'), array('class' => 'form-control'))!!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('tests', trans_choice("menu.test", 2),  array('class' => 'col-sm-2 form-control-label')) !!}
				</div>					
				<div class="col-sm-12 card card-block">	
					@foreach($testtypes as $key=>$value)
						<div class="col-md-3">
							<label  class="checkbox">
								<input type="checkbox" name="drugs[]" value="{!! $value->id!!}" />{!!$value->name!!}
							</label>
						</div>
					@endforeach
				</div>
				<div class="form-group row" align="right">
					{!! Form::button("<i class='fa fa-plus-circle'></i> ".trans('action.save'), 
						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
					<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
				</div>
			{!! Form::close() !!}
	  	</div>
	</div>
</div>
@endsection	