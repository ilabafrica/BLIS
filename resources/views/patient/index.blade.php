@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li class="active"><i class="fa fa-street-view"></i> {!! trans('menu.patient-register') !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
				    <i class="fa fa-book"></i> {!! trans('menu.patient-register') !!} 
				    <span>
					    <a class="btn btn-sm btn-belize-hole" href="{!! url("patient/create") !!}" >
							<i class="fa fa-plus-circle"></i>
							{!! trans('action.new').' '.trans_choice('menu.patient', 1) !!}
						</a>
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
						{!! Form::open(array('route' => array('patient.index'), 'class'=>'form-inline',
							'role'=>'form', 'method'=>'GET')) !!}
							<div class="form-group">

							    {!! Form::label('search', "search", array('class' => 'sr-only')) !!}
					            {!! Form::text('search', Input::get('search'), array('class' => 'form-control test-search')) !!}
							</div>
							<div class="form-group">
								{!! Form::button("<i class='fa fa-search'></i> ".trans('terms.search'), 
							        array('class' => 'btn btn-sm btn-primary', 'type' => 'submit')) !!}
							</div>
						{!! Form::close() !!}
					</div>
				 	<table class="table table-bordered table-sm search-table">
						<thead>
							<tr>
								<th>{!! trans('terms.patient-no') !!}</th>
								<th>{!! trans('terms.name') !!}</th>
								<th>{!! trans('terms.phone') !!}</th>
								<th>{!! trans('terms.gender') !!}</th>
								<th>{!! trans('terms.date-of-birth') !!}</th>
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
								<td>{!! $patient->name !!}</td>
								<td>{!! $patient->phone_number !!}</td>
								<td>{!! ($patient->gender==0?trans_choice('terms.sex', 1):trans_choice('terms.sex', 2)) !!}</td>
								<td>{!! $patient->dob !!}</td>
								
								<td>
									<a class="btn btn-sm btn-wet-asphalt" 
										href="{!! route('test.create', array('patient_id' => $patient->id)) !!}">
										<i class="fa fa-eyedropper"></i>
										{!! trans('action.new').' '.trans_choice('menu.test', 1) !!}
									</a>
								<!-- show the test category (uses the show method found at GET /patient/{id} -->
									<a class="btn btn-sm btn-success" href="{!! url("patient/" . $patient->id) !!}" >
										<i class="fa fa-folder-open-o"></i>
										{!! trans('action.view') !!}
									</a>

								<!-- edit this test category (uses edit method found at GET /patient/{id}/edit -->
									<a class="btn btn-sm btn-info" href="{!! url("patient/" . $patient->id . "/edit") !!}" >
										<i class="fa fa-edit"></i>
										{!! trans('action.edit') !!}
									</a>
									
								<!-- delete this test category (uses delete method found at GET /patient/{id}/delete -->
									<button class="btn btn-sm btn-danger delete-item-link"
										data-toggle="modal" data-target=".confirm-delete-modal"	
										data-id='{!! url("patient/" . $patient->id . "/delete") !!}'>
										<i class="fa fa-trash-o"></i>
										{!! trans('action.delete') !!}
									</button>
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