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
	<div class="card">
		<div class="card-header">
		    <i class="fa fa-file-text"></i> {!! trans('menu.patient-report') !!}
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
				<div class='col-md-12' style="padding-bottom:5px;">
			        {!! Form::open(array('url' => 'patientreport/'.$patient->id, 'class' => 'form-inline', 'id' => 'form-patientreport-filter', 'method'=>'POST')) !!}
						{!! Form::hidden('patient', $patient->id, array('id' => 'patient')) !!}			            
			            <div class='col-md-12'>
			            	<div class='col-md-2'>
			            		{!! Form::checkbox('pending', "1", isset($pending)) !!}&nbsp;&nbsp;<strong>{!! trans('terms.include-pending') !!}</strong>
			            	</div>
			                <div class='col-md-4'>
			                    {!! Form::label('date_from', trans('terms.from').':', array('class' => 'col-sm-3 form-control-label')) !!}
			                    <div class='col-md-9 input-group date datepicker'>
			                        {!! Form::text('from', old('from') ? old('from') : $from, array('class' => 'form-control')) !!}
			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			                    </div>
			                </div>
			                <div class='col-md-3'>
			                    {!! Form::label('date_to', trans('terms.to').':', array('class' => 'col-sm-2 form-control-label')) !!}
			                    <div class='col-md-10 input-group date datepicker'>
			                        {!! Form::text('to', old('to') ? old('to') : $to, array('class' => 'form-control')) !!}
			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			                    </div>
			                </div>
			                <div class='col-md-3'>
								{!! Form::button("<i class='fa fa-filter'></i> ".trans('action.filter'), array('class' => 'btn btn-sm btn-primary', 'type' => 'submit', 'id' => 'filter')) !!}
								{!! Form::button("<i class='fa fa-file-word-o'></i> ".trans('action.export'), array('class' => 'btn btn-sm btn-midnight-blue', 'type' => 'submit', 'id' => 'word', 'value' => 'word', 'name' => 'word')) !!}
			                </div>
		                </div>
		                {!! Form::hidden('visit_id', $visit, array('id'=>'visit_id')) !!}
			        {!! Form::close() !!}
			    </div>
            </div>
            @if($error!='')
			<!-- if there are search errors, they will show here -->
				<div class="alert alert-info">{!! $error !!}</div>
			@else
            <div class="row">
            	<div class="col-sm-1"></div>
            	<div class="col-sm-3">
            		<img src="{{ Config::get('blis.organization-logo') }}" height="60px" align="center">
            	</div>
            	<div class="col-sm-4">
            		<h6 align="center"><small>
	            		{!! strtoupper(Config::get('blis.organization')) !!}<br>
	                    {!! strtoupper(Config::get('blis.address-info')) !!}<br>
                    </small></h6>
            	</div>
            	<div class="col-sm-3">
            		<img src="{{ Config::get('blis.organization-logo') }}" height="60px" align="center">
            	</div>
            	<div class="col-sm-1"></div>
            </div>
            <div class="row">
            	<div class="col-md-12">
					<ul class="list-group" style="padding-bottom:5px;">
					  	<li class="list-group-item"><strong>{!! $patient->name !!}</strong></li>
					  	<li class="list-group-item">
					  		<h6>
					  			<span>{!! trans("terms.patient-id").':' !!}<small> {!! $patient->patient_number !!}</small></span>&nbsp;&nbsp;
					  			<span>{!! trans("terms.lab-no").':' !!}<small> {!! $patient->external_patient_number !!}</small></span>&nbsp;&nbsp;
					  			<span>{!! trans("terms.age").'/'.trans("terms.gender").'/'.trans("terms.dob").':' !!}<small> {!! $patient->getAge().'/'.($patient->gender==0?trans_choice('terms.sex', 1):trans_choice('terms.sex', 2)).'/'.Carbon::parse($patient->dob)->toDateString() !!}</small></span>
					  		</h6>
					  	</li>
					</ul>
				</div>
			</div>
			<div class="row">
				@forelse($tests as $test)
				<div class="col-md-12">
					<ul class="list-group" style="padding-bottom:5px;">
					  	<li class="list-group-item">
					  		<h6>
					  			<span>{!! trans("terms.lab-ref").':' !!}<small> {!! $patient->id !!}</small></span>&nbsp;&nbsp;
					  			<span>{!! trans("terms.spec-id").':' !!}<small> {!! $test->specimen->id !!}</small></span>&nbsp;&nbsp;
					  			<span>
					  				{!! trans("terms.test-status").':' !!}
					  				<small> 
					  					@if($test->specimen->specimen_status_id == App\Models\Specimen::NOT_COLLECTED)
					  						{!! trans('terms.specimen-not-collected') !!}
					  					@elseif($test->specimen->specimen_status_id == App\Models\Specimen::ACCEPTED)
					  						{!! trans('terms.specimen-accepted') !!}
					  					@elseif($test->specimen->specimen_status_id == App\Models\Specimen::REJECTED)
					  						{!! trans('terms.specimen-rejected') !!}
					  					@endif
					  				</small>
					  			</span>&nbsp;&nbsp;
					  			@if($test->specimen->specimen_status_id == App\Models\Specimen::ACCEPTED)
					  				<span>{!! trans("terms.collect-date").':' !!}<small> {!! $test->specimen->time_accepted !!}</small></span>&nbsp;&nbsp;
						  			<span>{!! trans("terms.accepted-by").':' !!}<small> {!! $test->specimen->acceptedBy->name !!}</small></span>
					  			@elseif($test->specimen->specimen_status_id == App\Models\Specimen::REJECTED)
					  				<span>{!! trans("terms.reject-date").':' !!}<small> {!! $test->specimen->time_rejected !!}</small></span>&nbsp;&nbsp;
						  			<span>{!! trans("terms.rejected-by").':' !!}<small> {!! $test->specimen->rejectedBy->name !!}</small></span>
					  			@endif
					  		</h6>
					  	</li>
					  	<li class="list-group-item">
					  		<h6>
					  			<span>{!! trans("terms.requested").':' !!}<small> {!! $test->testType->name !!}</small></span>&nbsp;&nbsp;
					  			<span>{!! trans("terms.performed-by").':' !!}<small> {!! $test->testedBy->name or trans('terms.pending') !!}</small></span>&nbsp;&nbsp;
					  			<span>{!! trans("terms.report-date").':' !!}<small> {!! $test->testResults->last()->time_entered !!}</small></span>&nbsp;&nbsp;
					  			<span>{!! trans("terms.verified-by").':' !!}<small> {!! $test->verifiedBy->name or trans('terms.verification-pending') !!}</small></span>&nbsp;&nbsp;
					  			<span>{!! trans("terms.date-verified").':' !!}<small> {!! $test->time_verified or trans('terms.verification-pending') !!}</small></span>
					  		</h6>
					  	</li>
					</ul>
				</div>
				@empty
        			<div class="col-sm-12">
            			{!! trans('terms.no-records-found') !!}
            		</div>
        		@endforelse
        	</div>
			@forelse($tests as $test)
			<div class="row">
				<div class="col-md-12">
					<div class="card card-block">
						<div class="row">				
							<strong>
								<div class="col-md-12">
									<div class="col-sm-4">{!! trans_choice('menu.test', 1) !!}</div>
								  	<div class="col-sm-4">{!! trans('terms.result') !!}</div>
								  	<div class="col-sm-4">{!! trans('terms.reference') !!}</div>
							  	</div>
							</strong>
						  	<div class="col-sm-12">
		            			<div class="col-sm-4">
		            				{!! $test->testType->name !!}           				
		            			</div>
		            		</div>
		            		<hr>
		            		@foreach($test->testResults as $result)
		            			<div class="col-sm-12">
			            			<div class="col-sm-4">
			            				{!! App\Models\Measure::find($result->measure_id)->name !!}           				
			            			</div>
			            			<div class="col-sm-4">
			            				{!! $result->result !!}           				
			            			</div>
			            			<div class="col-sm-4">
			            				{!! App\Models\Measure::getRange($test->visit->patient, $result->measure_id).' '.App\Models\Measure::find($result->measure_id)->unit !!}
			            			</div>
			            		</div>
		            		@endforeach
		            	</div>
	            	</div>
            	</div>
    		@empty
    			<div class="col-sm-12">
        			{!! trans('terms.no-records-found') !!}
        		</div>
			</div>
    		@endforelse
    		@endif
	  	</div>
	</div>
</div>
@endsection	