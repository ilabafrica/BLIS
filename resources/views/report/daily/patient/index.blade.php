@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li class="active"><i class="fa fa-chart"></i> {!! trans_choice('menu.report', 2) !!}</li>
            <li class="active"><i class="fa fa-clock-o"></i> {!! trans('menu.daily-report') !!}</li>
            <li class="active"> {!! trans('menu.patient-report') !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
				    <i class="fa fa-book"></i> {!! trans('menu.patient-report') !!} 
				    <span>
					    <a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
							<i class="fa fa-step-backward"></i>
							{!! trans('action.back') !!}
						</a>				
					</span>
				</div>
			  	<div class="card-block">	  		
					@if (Session::has('message'))
						<div class="alert alert-info">{!! Session::get('message') !!}</div>
					@endif
					@if($errors->all())
		            <div class="alert alert-danger alert-dismissible" role="alert">
		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
		            </div>
		            @endif
		            <div class='col-md-12' style="padding-bottom:5px;">
						{!! Form::open(array('route' => array('patient.index'), 'class'=>'form-inline', 'role'=>'form', 'method'=>'GET')) !!}
							<div class="form-group">

							    {!! Form::label('search', "search", array('class' => 'sr-only')) !!}
					            {!! Form::text('search', Input::get('search'), array('class' => 'form-control test-search')) !!}
							</div>
							<div class="form-group">
								{!! Form::button("<i class='fa fa-search'></i> ".trans('general-terms.search'), 
							        array('class' => 'btn btn-sm btn-primary', 'type' => 'submit')) !!}
							</div>
						{!! Form::close() !!}
					</div>
				 	<table class="table table-bordered table-sm search-table">
						<thead>
							<tr>
								<th>{!! trans('specific-terms.patient-no') !!}</th>
								<th>{!! trans('specific-terms.patient-id') !!}</th>
								<th>{!! trans('general-terms.name') !!}</th>
								<th>{!! trans('general-terms.gender') !!}</th>
								<th>{!! trans('general-terms.age') !!}</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						@foreach($patients as $patient)
							<tr @if(session()->has('active_patient'))
				                    {!! (session('active_patient') == $value->id)?"class='warning'":"" !!}
				                @endif
				                >
								<td>{!! $patient->patient_number !!}</td>
								<td>{!! $patient->external_patient_number !!}</td>
								<td>{!! $patient->name !!}</td>
								<td>{!! ($patient->gender==0?trans_choice('specific-terms.sex', 1):trans_choice('specific-terms.sex', 2)) !!}</td>
								<td>{!! $patient->getAge() !!}</td>
								
								<td>
									<a class="btn btn-sm btn-wet-asphalt" 
										href="{!! url('patientreport/' . $patient->id) !!}">
										<i class="fa fa-file-text"></i>
										{!! trans('action.view').' '.trans_choice('menu.report', 1) !!}
									</a>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
			  	</div>
			</div>
		</div>
	</div>
	{!! session(['SOURCE_URL' => URL::full()]) !!}
</div>
@endsection