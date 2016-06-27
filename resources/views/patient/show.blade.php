@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li><a href="{!! url('patient') !!}"><i class="fa fa-street-view"></i> {!! trans('menu.patient-register') !!}</a></li>
            <li class="active">{!! trans('action.view').' '.trans_choice('menu.patient', 1) !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="card">
		<div class="card-header">
		    <i class="fa fa-file-text"></i> <strong>{!! trans('terms.details-for').': '.$patient->name !!}</strong>
		    <span>
		    	<a class="btn btn-sm btn-belize-hole" href="{!! url("patient/create") !!}" >
					<i class="fa fa-plus-circle"></i>
					{!! trans('action.new').' '.trans_choice('menu.patient', 1) !!}
				</a>
				<a class="btn btn-sm btn-info" href="{!! url("patient/" . $patient->id . "/edit") !!}" >
					<i class="fa fa-edit"></i>
					{!! trans('action.edit') !!}
				</a>
				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
					<i class="fa fa-step-backward"></i>
					{!! trans('action.back') !!}
				</a>
				<a class="btn btn-sm btn-wet-asphalt" 
					href="{!! route('test.create', array('patient_id' => $patient->id)) !!}">
					<i class="fa fa-eyedropper"></i>
					{!! trans('action.new').' '.trans_choice('menu.test', 1) !!}
				</a>				
			</span>
		</div>	  		
		<!-- if there are creation errors, they will show here -->
		@if($errors->all())
			<div class="alert alert-danger">
				{!! HTML::ul($errors->all()) !!}
			</div>
		@endif

		<ul class="list-group list-group-flush">
		    <li class="list-group-item"><h4>{!! trans('terms.name').': ' !!}<small>{!! $patient->name !!}</small></h4></li>
		    <li class="list-group-item"><h5>{!! trans('terms.patient-no').': ' !!}<small>{!! $patient->patient_number !!}</small></h5></li>
		    <li class="list-group-item"><h6>{!! trans('terms.external-no').': ' !!}<small>{!! $patient->external_patient_number !!}</small></h6></li>
		    <li class="list-group-item"><h6>{!! trans('terms.date-of-birth').': ' !!}<small>{!! $patient->dob !!}</small></h6></li>
		    <li class="list-group-item"><h6>{!! trans('terms.gender').': ' !!}<small>{!! ($patient->gender==0?trans_choice('terms.sex', 1):trans_choice('terms.sex', 2)) !!}</small></h6></li>
		    <li class="list-group-item"><h6>{!! trans('terms.phone').': ' !!}<small>{!! $patient->phone_number !!}</small></h6></li>
		    <li class="list-group-item"><h6>{!! trans('terms.address').': ' !!}<small>{!! $patient->address !!}</small></h6></li>
	  	</ul>
	</div>
</div>
@endsection	