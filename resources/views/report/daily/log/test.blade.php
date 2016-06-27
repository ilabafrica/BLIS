@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li class="active"><i class="fa fa-chart"></i> {!! trans_choice('menu.report', 2) !!}</li>
            <li class="active"><i class="fa fa-clock-o"></i> {!! trans('menu.daily-report') !!}</li>
            <li class="active"> {!! trans_choice('menu.test', 2) !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
				    <i class="fa fa-book"></i> {!! trans_choice('menu.test', 2) !!} 
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
		                <div class='col-md-12' id="hideable">
		                	<div class='col-md-5'>
		                		{!! Form::label('lab-section', trans_choice('menu.lab-section', 1).':', array('class' => 'col-sm-4 form-control-label')) !!}
			                    <div class='col-md-8'>
			                        {!! Form::select('test_category_id', $labSections, '', array('class' => 'form-control c-select', 'id' => 'test_category_id', 'onchange' => "testTypes()")) !!}
			                    </div>
							</div>
							<div class='col-md-4'>
								{!! Form::label('test-type', trans_choice('menu.test', 1).':', array('class' => 'col-sm-2 form-control-label')) !!}
			                    <div class='col-md-10'>
			                        {!! Form::select('test_type_id', [], '', array('class' => 'form-control c-select', 'id' => 'test_type_id')) !!}
			                    </div>
							</div>
							<div class='col-md-3'>
								<div id="radioBtn" class="btn-group">
		                            <a class="btn btn-sm btn-asbestos btn {{($completePending==trans('menu.all'))?'active':'notActive'}}" data-toggle="completePending" data-title="{!! trans('menu.all') !!}" name="completePending">{!! trans('menu.all') !!}</a>
		                            <a class="btn btn-sm btn-asbestos btn {{($completePending==trans('menu.complete'))?'active':'notActive'}}" data-toggle="completePending" data-title="{!! trans('menu.complete') !!}" name="completePending">{!! trans('menu.complete') !!}</a>
		                        </div>
		                        <input type="hidden" name="completePending" id="completePending">
							</div>
		                </div>
			        {!! Form::close() !!}
		            <table class="table table-bordered table-sm search-table" style="font-size:13px;">
						<thead>
							<tr>
								<th>{!! trans('terms.patient-id') !!}</th>
								<th>{!! trans('terms.visit-no') !!}</th>
								<th>{!! trans('terms.specimen-id') !!}</th>
								<th>{!! trans_choice('menu.specimen-type', 1) !!}</th>
								<th>{!! trans('terms.date-received') !!}</th>
								<th>{!! trans_choice('menu.test-type', 1) !!}</th>
								<th>{!! trans('terms.performed-by') !!}</th>
								<th>{!! trans('terms.result') !!}</th>
								<th>{!! trans('terms.report-date') !!}</th>
								<th>{!! trans('terms.verified-by') !!}</th>
							</tr>
						</thead>
						<tbody>
						@forelse($tests as $test)
							<tr>
								<td>{!! $test->visit->patient->id !!}</td>
								<td>{!! $test->visit->visit_number?$test->visit->visit_number:$test->visit->id !!}</td>
								<td>{!! $test->getSpecimenId() !!}</td>
								<td>{!! $test->specimen->specimentype->name !!}</td>
								<td>{!! $test->specimen->time_accepted !!}</td>
								<td>{!! $test->testType->name !!}</td>
								<td>{!! $test->testedBy->name or trans('terms.test-pending') !!}</td>
								<td>
									@foreach($test->testResults as $result)
										<p>{!! App\Models\Measure::find($result->measure_id)->name !!}: {!! $result->result !!}</p>
									@endforeach
								</td>
								<td>{!! $test->time_completed or trans('messages.pending') !!}</td>
								<td>{!! $test->verifiedBy->name or trans('terms.verification-pending') !!}</td>
							</tr>
						@empty
						<tr><td colspan="11">{!! trans('terms.no-records') !!}</td></tr>
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