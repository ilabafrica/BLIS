@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li class="active"><i class="fa fa-chart"></i> {!! trans_choice('menu.report', 2) !!}</li>
            <li class="active"><i class="fa fa-clock-o"></i> {!! trans('menu.daily-report') !!}</li>
            <li class="active"> {!! trans_choice('menu.patient', 2) !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
				    <i class="fa fa-book"></i> {!! trans_choice('menu.patient', 2) !!} 
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
		            {!! Form::open(array('route' => array('reports.daily.log'))) !!}
			            <div class='col-md-12'>
			            	<div class='col-md-4'>
			                    {!! Form::label('date_from', trans('terms.from').':', array('class' => 'col-sm-3 form-control-label')) !!}
			                    <div class='col-md-9 input-group date datepicker'>
			                        {!! Form::text('from', old('from') ? old('from') : $from, array('class' => 'form-control')) !!}
			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			                    </div>
			                </div>
			                <div class='col-md-4'>
			                    {!! Form::label('date_to', trans('terms.to').':', array('class' => 'col-sm-2 form-control-label')) !!}
			                    <div class='col-md-10 input-group date datepicker'>
			                        {!! Form::text('to', old('to') ? old('to') : $to, array('class' => 'form-control')) !!}
			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			                    </div>
			                </div>
			                <div class='col-md-4'>
								{!! Form::button("<i class='fa fa-filter'></i> ".trans('action.filter'), array('class' => 'btn btn-sm btn-primary', 'type' => 'submit', 'id' => 'filter')) !!}
								{!! Form::button("<i class='fa fa-file-word-o'></i> ".trans('action.export'), array('class' => 'btn btn-sm btn-midnight-blue', 'type' => 'submit', 'id' => 'word', 'value' => 'word', 'name' => 'word')) !!}
			                </div>
		                </div>
		                <div class='col-md-12' style="padding-bottom:5px;">
		                	<div class='col-md-8'>
		                		<div id="radioBtn" class="btn-group">
		                            <a class="btn btn-sm btn-asbestos btn {{($records==trans('menu.test-records'))?'active':'notActive'}}" data-toggle="records" data-title="{!! trans('menu.test-records') !!}" name="records">{!! trans('menu.test-records') !!}</a>
		                            <a class="btn btn-sm btn-asbestos btn {{($records==trans('menu.patient-records'))?'active':'notActive'}}" data-toggle="records" data-title="{!! trans('menu.patient-records') !!}" name="records">{!! trans('menu.patient-records') !!}</a>
		                            <a class="btn btn-sm btn-asbestos btn {{($records==trans('menu.specimen-rej-rec'))?'active':'notActive'}}" data-toggle="records" data-title="{!! trans('menu.specimen-rej-rec') !!}" name="records">{!! trans('menu.specimen-rej-rec') !!}</a>
		                        </div>
                				<input type="hidden" name="records" id="records">
							</div>
							<div class='col-md-4'>
								{!! Form::button("<i class='fa fa-toggle-on'></i> ".trans('action.show-hide'), array('class' => 'btn btn-sm btn-belize-hole', 'type' => 'submit', 'id' => 'filter')) !!}
							</div>
		                </div>
			        {!! Form::close() !!}
				 	<table class="table table-bordered table-sm search-table" style="font-size:13px;">
						<thead>
							<tr>
								<th>{!! trans('terms.patient-id') !!}</th>
								<th>{!! trans('terms.name') !!}</th>
								<th>{!! trans('terms.age') !!}</th>
								<th>{!! trans('terms.gender') !!}</th>
								<th>{!! trans('terms.specimen-id') !!}</th>
								<th>{!! trans('terms.type') !!}</th>
								<th>{!! trans_choice('menu.test', 2) !!}</th>
							</tr>
						</thead>
						<tbody>
						@forelse($visits as $visit)
							<tr>
								<td>{!! $visit->patient->id !!}</td>
								<td>{!! $visit->patient->name !!}</td>
								<td>{!! $visit->patient->getAge() !!}</td>
								<td>{!! $visit->patient->getGender() !!}</td>
								<td>
									@foreach($visit->tests as $test)
										<p>{!! $test->specimen->id !!}</p>
									@endforeach
								</td>
								<td>
									@foreach($visit->tests as $test)
										<p>{!! $test->specimen->specimenType->name !!}</p>
									@endforeach
								</td>
								<td>
									@foreach($visit->tests as $test)
										<p>{!! $test->testType->name !!}</p>
									@endforeach
								</td>
							</tr>
						@empty
						<tr><td colspan="7">{!! trans('terms.no-records') !!}</td></tr>
						@endforelse
						</tbody>
					</table>
			  	</div>
			</div>
		</div>
	</div>
	{!! session(['SOURCE_URL' => URL::full()]) !!}
</div>
@endsection