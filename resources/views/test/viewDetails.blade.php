@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li><a href="{!! url('test') !!}"><i class="fa fa-user-md"></i> {!! trans_choice('menu.test', 2) !!}</a></li>
            <li class="active">{!! trans('action.view').' '.trans_choice('menu.test', 1) !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="card">
		<div class="card-header">
		    <i class="fa fa-folder-open"></i> {!! $test->visit->patient->name.' - '.$test->testType->name !!} 
		    <span>
				 @if($test->isCompleted() && $test->specimen->isAccepted())
				 	@if(Auth::user()->can('edit_test_results'))
					<a class="btn btn-sm btn-info" href="{!! url('test/'.$test->id.'/edit') !!}" >
						<i class="fa fa-edit"></i>
						{!! trans('action.edit') !!}
					</a>
					@endif
					@if(Auth::user()->can('verify_test_results') && Auth::user()->id != $test->tested_by)
					<a class="btn btn-sm btn-midnight-blue" href="{!! route('test.verify', array($test->id)) !!}">
	                    <i class="fa fa-check-square"></i>
	                    {!! trans('action.verify') !!}
	                </a>
	                @endif
	            @endif
	            @if($test->isCompleted() || $test->isVerified())
		            @if(Auth::user()->can('view_reports'))
					<a class="btn btn-sm btn-pomegranate" href="{!! route('test.viewDetails', array($test->id)) !!}">
	                    <i class="fa fa-file-text"></i>
	                    {!! trans_choice('menu.report', 1) !!}
	                </a>
	                @endif
                @endif
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
	            <div class="col-md-6">
		            <ul class="list-group" style="padding-bottom:5px;">
					  	<li class="list-group-item"><strong>{!! trans('general-terms.details-for').': '.$test->visit->patient->name.' - '.$test->testType->name !!}</strong></li>
					  	<li class="list-group-item"><h6>{!! trans_choice("menu.test-type", 1) !!}<small> {!! $test->testType->name or trans('messages.unknown') !!}</small></h6></li>
					  	<li class="list-group-item"><h6>{!! trans("specific-terms.visit-no") !!}<small> {!! $test->visit->visit_number or trans('messages.unknown') !!}</small></h6></li>
					  	<li class="list-group-item"><h6>{!! trans("specific-terms.date-ordered") !!}<small> {!! $test->isExternal()?$test->external()->request_date:$test->time_created !!}</small></h6></li>
					  	<li class="list-group-item"><h6>{!! trans("specific-terms.date-received") !!}<small> {!! $test->time_created !!}</small></h6></li>
					  	<li class="list-group-item"><h6>{!! trans("specific-terms.test-status") !!}<small> {!! trans('specific-terms.'.$test->testStatus->name) !!}</small></h6></li>
					  	<li class="list-group-item"><h6>{!! trans("general-terms.physician") !!}<small> {!! $test->requested_by or trans('messages.unknown') !!}</small></h6></li>
					  	<li class="list-group-item">
					  		<h6>{!! trans("specific-terms.origin") !!}
				  				<small>
				  					@if($test->specimen->isReferred() && $test->specimen->referral->status == Referral::REFERRED_IN)
										{!! trans("messages.in") !!}
									@else
										{!! $test->visit->visit_type !!}
									@endif
				  				</small>
					  		</h6>
					  	</li>
					  	<li class="list-group-item"><h6>{!! trans("specific-terms.registered-by") !!}<small> {!! $test->createdBy->name or trans('messages.unknown') !!}</small></h6></li>
					  	<li class="list-group-item"><h6>{!! trans("specific-terms.performed-by") !!}<small> {!! $test->testedBy->name or trans('messages.unknown') !!}</small></h6></li>
					  	@if($test->isVerified())
					  		<li class="list-group-item"><h6>{!! trans("specific-terms.verified-by") !!}<small> {!! $test->verifiedBy->name or trans('messages.verification-pending') !!}</small></h6></li>
					  	@endif
					  	@if((!$test->specimen->isRejected()) && ($test->isCompleted() || $test->isVerified()))
					  		<li class="list-group-item"><h6>{!! trans("menu.turn-around-time") !!}<small> {!! $test->getFormattedTurnaroundTime() !!}</small></h6></li>
					  	@endif
					</ul>
				</div>
				<div class="col-md-6">
					<ul class="list-group" style="padding-bottom:5px">
  						<li class="list-group-item"><strong>{!! trans_choice('menu.patient', 1) !!}</strong></li>
  						<li class="list-group-item">
  							<h6>
					  			<span>{!! trans("specific-terms.patient-no") !!}<small> {!! $test->visit->patient->patient_number !!}</small></span>
					  			<span>{!! trans("general-terms.age") !!}<small> {!! $test->visit->patient->getAge() !!}</small></span>
					  			<span>{!! trans("general-terms.gender") !!}<small> {!! ($test->visit->patient->gender==0?trans_choice('specific-terms.sex', 1):trans_choice('specific-terms.sex', 2)) !!}</small></span>
					  		</h6>
  						</li>
					</ul>
					<ul class="list-group" style="padding-bottom:5px">
  						<li class="list-group-item"><strong>{!! trans('general-terms.specimen') !!}</strong></li>
  						<li class="list-group-item">
  							<h6>
					  			<span>{!! trans("general-terms.type") !!}<small> {!! $test->specimen->specimenType->name or trans('messages.pending') !!}</small></span>
					  			<span>{!! trans("specific-terms.specimen-id") !!}<small> {!! $test->getSpecimenId() !!}</small></span>
					  			<span>{!! trans("specific-terms.test-status") !!}<small> {!! trans('specific-terms.'.$test->specimen->specimenStatus->name) !!}</small></span>

								@if($test->specimen->isRejected())
									<span>{!! trans("menu.reject-reason") !!}<small> {!! $test->specimen->rejectionReason->reason or trans('messages.pending') !!}</small></span>
									<span>{!! trans("specific-terms.explained-to") !!}<small> {!! $test->specimen->reject_explained_to or trans('messages.pending') !!}</small></span>
								@endif
								@if($test->specimen->isReferred())
								<br>
									<span>{!! trans("specific-terms.referred") !!}
										<small> 
											@if($test->specimen->referral->status == Referral::REFERRED_IN)
												{!! trans("messages.in") !!}
											@elseif($test->specimen->referral->status == Referral::REFERRED_OUT)
												{!! trans("messages.out") !!}
											@endif
										</small>
									</span>
									<span>{!! trans_choice("menu.facility", 1) !!}<small> {!! $test->specimen->referral->facility->name !!}</small></span>
									<span>
										@if($test->specimen->referral->status == Referral::REFERRED_IN)
											{!! trans("messages.originating-from") !!}
										@elseif($test->specimen->referral->status == Referral::REFERRED_OUT)
											{!! trans("messages.intended-reciepient") !!}
										@endif
										<small> {!! $test->specimen->referral->person !!}</small>
									</span>
									<span>{!! trans("general-terms.contacts") !!}<small> {!! $test->specimen->referral->contacts !!}</small></span>
									<span>
										@if($test->specimen->referral->status == Referral::REFERRED_IN)
											{!! trans("messages.recieved-by") !!}
										@elseif($test->specimen->referral->status == Referral::REFERRED_OUT)
											{!! trans("messages.referred-by") !!}
										@endif
										<small> {!! $test->specimen->referral->user->name !!}</small>
									</span>
									<span>{!! trans("specific-terms.specimen-id") !!}<small> {!! $test->getSpecimenId() !!}</small></span>
								@endif
					  		</h6>
  						</li>
					</ul>
					<ul class="list-group" style="padding-bottom:5px">
						<li class="list-group-item"><strong>{!! trans_choice('general-terms.result', 2) !!}</strong></li>
						@foreach($test->testResults as $result)
							<li class="list-group-item">
								<h6>
									{!! App\Models\Measure::find($result->measure_id)->name !!}
									<small> 
										{!! $result->result !!}
										{!! App\Models\Measure::getRange($test->visit->patient, $result->measure_id) !!}
										{!! App\Models\Measure::find($result->measure_id)->unit !!}
									</small>
								</h6>
							</li>
						@endforeach
						<li class="list-group-item"><h6>{!! trans('messages.test-remarks') !!}<small> {!! $test->interpretation !!}</small></h6></li>
					</ul>
				</div>
			</div>
	  	</div>
	</div>
</div>
@endsection	