@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li><a href="{!! url('test') !!}"><i class="fa fa-user-md"></i> {!! trans_choice('menu.test', 2) !!}</a></li>
            <li class="active">{!! trans('action.edit').' '.trans_choice('menu.test', 1) !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="card">
		<div class="card-header">
		    <i class="fa fa-edit"></i> {!! $test->visit->patient->name.' - '.$test->testType->name !!} 
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
		            {!! Form::open(array('route' => array('test.saveResults', $test->id), 'method' => 'POST')) !!}
						@foreach($test->testType->measures as $measure)
							<div class="form-group row">
								<?php
								$ans = "";
								foreach ($test->testResults as $res) {
									if($res->measure_id == $measure->id)$ans = $res->result;
								}
								 ?>
							<?php
							$fieldName = "m_".$measure->id;
							?>
							@if ( $measure->isNumeric() ) 
		                        {!! Form::label($fieldName , $measure->name, array('class' => 'col-sm-2 form-control-label')) !!}
		                        <div class="col-sm-8"> 
			                        {!! Form::text($fieldName, $ans, array(
			                            'class' => 'form-control result-interpretation-trigger',
			                            'data-url' => route('test.resultinterpretation'),
			                            'data-age' => $test->visit->patient->dob,
			                            'data-gender' => $test->visit->patient->gender,
			                            'data-measureid' => $measure->id
			                            ))
			                        !!}
			                    </div>
	                            <span class='units'>
	                                {!! App\Models\Measure::getRange($test->visit->patient, $measure->id) !!}
	                                {!! $measure->unit !!}
	                            </span>
							@elseif ( $measure->isAlphanumeric() || $measure->isAutocomplete() ) 
		                        <?php
		                        $measure_values = array();
	                            $measure_values[] = '';
		                        foreach ($measure->measureRanges as $range) {
		                            $measure_values[$range->alphanumeric] = $range->alphanumeric;
		                        }
		                        ?>
	                            {!! Form::label($fieldName , $measure->name, array('class' => 'col-sm-2 form-control-label')) !!}
	                            <div class="col-sm-8"> 
		                            {!! Form::select($fieldName, $measure_values, array_search($ans, $measure_values),
		                                array('class' => 'form-control result-interpretation-trigger',
		                                'data-url' => route('test.resultinterpretation'),
		                                'data-measureid' => $measure->id
		                                )) 
		                            !!}
		                           </div>
							@elseif ( $measure->isFreeText() ) 
	                            {!! Form::label($fieldName, $measure->name, array('class' => 'col-sm-2 form-control-label')) !!}
	                            <?php
									$sense = '';
									if($measure->name=="Sensitivity"||$measure->name=="sensitivity")
										$sense = ' sense'.$test->id;
								?>
								<div class="col-sm-8"> 
	                            	{!!Form::text($fieldName, $ans, array('class' => 'form-control'.$sense))!!}
	                            </div>
							@endif
	                    </div>
	                @endforeach
	                <div class="form-group row">
	                    {!! Form::label('interpretation', trans('specific-terms.remarks'), array('class' => 'col-sm-2 form-control-label')) !!}
	                    <div class="col-sm-8"> 
	                    	{!! Form::textarea('interpretation', $test->interpretation, array('class' => 'form-control result-interpretation', 'rows' => '2')) !!}
	                    </div>
	                </div>
	                <div class="form-group row col-sm-offset-2">
						{!! Form::button("<i class='fa fa-check-circle'></i> ".trans('action.update'), 
							array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
						<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
					</div>
					{!! Form::close() !!}
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
			</div>
	  	</div>
	</div>
</div>
@endsection	