<html>
<head>
	<link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('css/font.css') }}" rel="stylesheet">
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
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
		  	</div>
		</div>
	</div>
</body>
</html>