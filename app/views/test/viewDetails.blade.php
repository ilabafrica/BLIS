@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li><a href="{{ URL::route('test.index') }}">{{trans('messages.test')}}</a></li>
		  <li class="active">{{trans('messages.test-details')}}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-cog"></span>
			{{trans('messages.test-details')}}
			@if($test->test_status_id != Test::VERIFIED && $test->specimen->specimen_status_id != Specimen::REJECTED)
			 <!-- Not Verified and Not Rejected-->
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::to('test/'.$test->id.'/edit') }}">
					<span class="glyphicon glyphicon-edit"></span>
					{{trans('messages.edit-test-results')}}
				</a>
			</div>
			@endif
		</div>
		<div class="panel-body">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6">
						<div class="display-details">
							<h3 class="view"><strong>{{trans('messages.test-type')}}</strong>
								{{ $test->testType->name or trans('messages.unknown') }}</h3>
							<p class="view-striped"><strong>{{trans('messages.patient-name')}}</strong>
								{{$test->visit->patient->name}}</p>
							<p class="view"><strong>{{trans('messages.visit-number')}}</strong>
								{{$test->visit->id or trans('messages.unknown') }}</p>
							<p class="view"><strong>{{trans('messages.lab-receipt-date')}}</strong>
								{{$test->time_created}}</p>
							<p class="view"><strong>{{trans('messages.test-status')}}</strong>
								{{trans('messages.'.$test->testStatus->name)}}</p>
							<p class="view-striped"><strong>{{trans('messages.physician')}}</strong>
								{{$test->requested_by or trans('messages.unknown') }}</p>
							<p class="view-striped"><strong>{{trans('messages.registered-by')}}</strong>
								{{$test->createdBy->name or trans('messages.unknown') }}</p>
							<p class="view"><strong>{{trans('messages.tested-by')}}</strong>
								{{$test->testedBy->name or trans('messages.unknown')}}</p>
							@if($test->test_status_id == Test::VERIFIED)
							<p class="view"><strong>{{trans('messages.verified-by')}}</strong>
								{{$test->verifiedBy->name or trans('messages.verification-pending')}}</p>
							@endif
							@if($test->specimen->specimen_status_id != Specimen::REJECTED && ($test->test_status_id == Test::COMPLETED || $test->test_status_id == Test::VERIFIED))
							<!-- Not Rejected and (Verified or Completed)-->
							<p class="view-striped"><strong>{{trans('messages.turnaround-time')}}</strong>
								<?php
									$tat = $test->getTurnaroundTime();
									$dtat = "";
									$tat_y = intval($tat/(365*24*60*60));
									$tat_w = intval(($tat-($tat_y*(365*24*60*60)))/(7*24*60*60));
									$tat_d = intval(($tat-($tat_y*(365*24*60*60))-($tat_w*(7*24*60*60)))/(24*60*60));
									$tat_h = intval(($tat-($tat_y*(365*24*60*60))-($tat_w*(7*24*60*60))-($tat_d*(24*60*60)))/(60*60));
									$tat_m = intval(($tat-($tat_y*(365*24*60*60))-($tat_w*(7*24*60*60))-($tat_d*(24*60*60))-($tat_h*(60*60)))/(60));
									$tat_s = intval(($tat-($tat_y*(365*24*60*60))-($tat_w*(7*24*60*60))-($tat_d*(24*60*60))-($tat_h*(60*60))-($tat_m*(60))));
									if($tat_y > 0) $dtat = $tat_y." years ";
									if($tat_w > 0) $dtat .= $tat_w." weeks ";
									if($tat_d > 0) $dtat .= $tat_d." days ";
									if($tat_h > 0) $dtat .= $tat_h." hours ";
									if($tat_m > 0) $dtat .= $tat_m." minutes ";
									if($tat_s > 0) $dtat .= $tat_s." seconds ";
								?>
								{{$dtat or trans('messages.pending')}}</p>
							@endif
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">{{trans("messages.specimen-details")}}</h3>
							</div>
							<div class="panel-body">
								<div class="container-fluid">
									<div class="row">
										<div class="col-md-4">
											<p><strong>{{trans('messages.specimen-type')}}</strong></p>
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
											{{$test->specimen->id or trans('messages.pending') }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<p><strong>{{trans('messages.specimen-status')}}</strong></p>
										</div>
										<div class="col-md-8">
											{{$test->specimen->specimenStatus->name or trans('messages.pending') }}
										</div>
									</div>
								@if($test->specimen->specimen_status_id == Specimen::REJECTED)
									<div class="row">
										<div class="col-md-4">
											<p><strong>{{trans('messages.rejection-reason-title')}}</strong></p>
										</div>
										<div class="col-md-8">
											{{$test->specimen->rejectionReason->reason or trans('messages.pending') }}
										</div>
									</div>
								@endif
								</div>
							</div>
						</div>
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">{{trans("messages.test-results")}}</h3>
							</div>
							<div class="panel-body">
								<div class="container-fluid">
								@foreach($test->testResults as $result)
									<div class="row">
										<div class="col-md-3">
											<p><strong>{{Measure::find($result->measure_id)->name}}</strong></p>
										</div>
										<div class="col-md-9">
											{{$result->result}}
										</div>
									</div>
								@endforeach
									<div class="row">
										<div class="col-md-3">
											<p><strong>{{trans('messages.test-remarks')}}</strong></p>
										</div>
										<div class="col-md-9">
											{{$test->interpretation}}
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop