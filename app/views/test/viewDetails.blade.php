@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li><a href="{{ URL::route('test.index') }}">{{ Lang::choice('messages.test',2) }}</a></li>
		  <li class="active">{{trans('messages.test-details')}}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
            <div class="container-fluid">
                <div class="row less-gutter">
                    <div class="col-md-11">
						<span class="glyphicon glyphicon-cog"></span>{{trans('messages.test-details')}}

						@if($test->isCompleted() && $test->specimen->isAccepted())
						<div class="panel-btn">
							@if(Auth::user()->can('edit_test_results'))
								<a class="btn btn-sm btn-info" href="{{ URL::to('test/'.$test->id.'/edit') }}">
									<span class="glyphicon glyphicon-edit"></span>
									{{trans('messages.edit-test-results')}}
								</a>
							@endif
							@if(Auth::user()->can('verify_test_results') && Auth::user()->id != $test->tested_by)
							<a class="btn btn-sm btn-success" href="{{ URL::route('test.verify', array($test->id)) }}">
								<span class="glyphicon glyphicon-thumbs-up"></span>
								{{trans('messages.verify')}}
							</a>
							@endif
							@if(Auth::user()->can('view_reports'))
								<a class="btn btn-sm btn-default" href="{{ URL::to('patientreport/'.$test->visit->patient->id.'/'.$test->visit->id) }}">
									<span class="glyphicon glyphicon-eye-open"></span>
									{{trans('messages.view-report')}}
								</a>
							@endif
						</div>
						@endif
                    </div>
                    <div class="col-md-1">
                        <a class="btn btn-sm btn-primary pull-right" href="#" onclick="window.history.back();return false;"
                            alt="{{trans('messages.back')}}" title="{{trans('messages.back')}}">
                            <span class="glyphicon glyphicon-backward"></span></a>
                    </div>
                </div>
            </div>
		</div> <!-- ./ panel-heading -->
		<div class="panel-body">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6">
						<div class="display-details">
							<h3 class="view"><strong>{{ Lang::choice('messages.test-type',1) }}</strong>
								{{ $test->testType->name or trans('messages.unknown') }}</h3>
							<p class="view"><strong>{{trans('messages.visit-number')}}</strong>
								{{$test->visit->visit_number or trans('messages.unknown') }}</p>
							<p class="view"><strong>{{trans('messages.lab-receipt-date')}}</strong>
								{{$test->time_created}}</p>
							<p class="view"><strong>{{trans('messages.test-status')}}</strong>
								{{trans('messages.'.$test->testStatus->name)}}</p>
							<p class="view-striped"><strong>{{trans('messages.physician')}}</strong>
								{{$test->requested_by or trans('messages.unknown') }}</p>
							<p class="view-striped"><strong>{{trans('messages.request-origin')}}</strong>
								@if($test->specimen->isReferred() && $test->specimen->referral->status == Referral::REFERRED_IN)
									{{ trans("messages.in") }}
								@else
									{{ $test->visit->visit_type }}
								@endif</p>
							<p class="view-striped"><strong>{{trans('messages.registered-by')}}</strong>
								{{$test->createdBy->name or trans('messages.unknown') }}</p>
							<p class="view"><strong>{{trans('messages.tested-by')}}</strong>
								{{$test->testedBy->name or trans('messages.unknown')}}</p>
							@if($test->isVerified())
							<p class="view"><strong>{{trans('messages.verified-by')}}</strong>
								{{$test->verifiedBy->name or trans('messages.verification-pending')}}</p>
							@endif
							@if((!$test->specimen->isRejected()) && ($test->isCompleted() || $test->isVerified()))
							<!-- Not Rejected and (Verified or Completed)-->
							<p class="view-striped"><strong>{{trans('messages.turnaround-time')}}</strong>
								{{$test->getFormattedTurnaroundTime()}}</p>
							@endif
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-info">  <!-- Patient Details -->
							<div class="panel-heading">
								<h3 class="panel-title">{{trans("messages.patient-details")}}</h3>
							</div>
							<div class="panel-body">
								<div class="container-fluid">
									<div class="row">
										<div class="col-md-3">
											<p><strong>{{trans("messages.patient-number")}}</strong></p></div>
										<div class="col-md-9">
											{{$test->visit->patient->external_patient_number}}</div></div>
									<div class="row">
										<div class="col-md-3">
											<p><strong>{{ Lang::choice('messages.name',1) }}</strong></p></div>
										<div class="col-md-9">
											{{$test->visit->patient->name}}</div></div>
									<div class="row">
										<div class="col-md-3">
											<p><strong>{{trans("messages.age")}}</strong></p></div>
										<div class="col-md-9">
											{{$test->visit->patient->getAge()}}</div></div>
									<div class="row">
										<div class="col-md-3">
											<p><strong>{{trans("messages.gender")}}</strong></p></div>
										<div class="col-md-9">
											{{$test->visit->patient->gender==0?trans("messages.male"):trans("messages.female")}}
										</div></div>
								</div>
							</div> <!-- ./ panel-body -->
						</div> <!-- ./ panel -->
						<div class="panel panel-info"> <!-- Specimen Details -->
							<div class="panel-heading">
								<h3 class="panel-title">{{trans("messages.specimen-details")}}</h3>
							</div>
							<div class="panel-body">
								<div class="container-fluid">
									<div class="row">
										<div class="col-md-4">
											<p><strong>{{ Lang::choice('messages.specimen-type',1) }}</strong></p>
										</div>
										<div class="col-md-8">
											{{$test->specimen->specimenType->name or trans('messages.pending') }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<p><strong>{{trans('messages.specimen-number')}}</strong></p>
										</div>
										<div class="col-md-8">
											{{$test->specimen->getSpecimenId() }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<p><strong>{{trans('messages.specimen-status')}}</strong></p>
										</div>
										<div class="col-md-8">
											{{trans('messages.'.$test->specimen->specimenStatus->name) }}
										</div>
									</div>
								@if($test->specimen->isRejected())
									<div class="row">
										<div class="col-md-4">
											<p><strong>{{trans('messages.rejection-reason-title')}}</strong></p>
										</div>
										<div class="col-md-8">
											{{$test->specimen->rejectionReason->reason or trans('messages.pending') }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<p><strong>{{trans('messages.reject-explained-to')}}</strong></p>
										</div>
										<div class="col-md-8">
											{{$test->specimen->reject_explained_to or trans('messages.pending') }}
										</div>
									</div>
								@endif
								@if($test->specimen->isReferred())
								<br>
									<div class="row">
										<div class="col-md-4">
											<p><strong>{{trans("messages.specimen-referred-label")}}</strong></p>
										</div>
										<div class="col-md-8">
											@if($test->specimen->referral->status == Referral::REFERRED_IN)
												{{ trans("messages.in") }}
											@elseif($test->specimen->referral->status == Referral::REFERRED_OUT)
												{{ trans("messages.out") }}
											@endif
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<p><strong>{{Lang::choice("messages.facility", 1)}}</strong></p>
										</div>
										<div class="col-md-8">
											{{$test->specimen->referral->facility->name }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<p><strong>{{trans("messages.person-involved")}}</strong></p>
										</div>
										<div class="col-md-8">
											{{$test->specimen->referral->person }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<p><strong>{{trans("messages.contacts")}}</strong></p>
										</div>
										<div class="col-md-8">
											{{$test->specimen->referral->contacts }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<p><strong>{{trans("messages.referred-by")}}</strong></p>
										</div>
										<div class="col-md-8">
											{{ $test->specimen->referral->user->name }}
										</div>
									</div>
								@endif
								</div>
							</div>
						</div> <!-- ./ panel -->
						<div class="panel panel-info">  <!-- Test Results -->
							<div class="panel-heading">
								<h3 class="panel-title">{{trans("messages.test-results")}}</h3>
							</div>
							<div class="panel-body">
								<div class="container-fluid">
								@foreach($test->testResults as $result)
									<div class="row">
										<div class="col-md-4">
											<p><strong>{{ Measure::find($result->measure_id)->name }}</strong></p>
										</div>
										<div class="col-md-3">
											{{$result->result}}	
										</div>
										<div class="col-md-5">
	        								{{ Measure::getRange($test->visit->patient, $result->measure_id) }}
											{{ Measure::find($result->measure_id)->unit }}
										</div>
									</div>
								@endforeach
									<div class="row">
										<div class="col-md-2">
											<p><strong>{{trans('messages.test-remarks')}}</strong></p>
										</div>
										<div class="col-md-10">
											{{$test->interpretation}}
										</div>
									</div>
								</div>
							</div> <!-- ./ panel-body -->
						</div>  <!-- ./ panel -->
					</div>
				</div>
			</div> <!-- ./ container-fluid -->
		</div> <!-- ./ panel-body -->
	</div> <!-- ./ panel -->
@stop