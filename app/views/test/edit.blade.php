@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		  <li><a href="{{ URL::route('test.index') }}">{{ Lang::choice('messages.test',2) }}</a></li>
		  <li class="active">{{ trans('messages.edit') }}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
            <div class="container-fluid">
	            <div class="row less-gutter">
		            <div class="col-md-11">
						<span class="glyphicon glyphicon-filter"></span>{{ trans('messages.edit') }}
                        @if($test->testType->instruments->count() > 0)
                        <div class="panel-btn">
                            <a class="btn btn-sm btn-info fetch-test-data" href="javascript:void(0)"
                                title="{{trans('messages.fetch-test-data-title')}}"
                                data-test-type-id="{{$test->testType->id}}"
                                data-url="{{URL::route('instrument.getResult')}}"
                                data-instrument-count="{{$test->testType->instruments->count()}}">
                                <span class="glyphicon glyphicon-plus-sign"></span>
                                {{trans('messages.fetch-test-data')}}
                            </a>
                        </div>
                        @endif
                        @if($test->isCompleted() && $test->specimen->isAccepted())
						<div class="panel-btn">
							@if(Auth::user()->can('verify_test_results') && Auth::user()->id != $test->tested_by)
							<a class="btn btn-sm btn-success" href="{{ URL::route('test.verify', array($test->id)) }}">
								<span class="glyphicon glyphicon-thumbs-up"></span>
								{{trans('messages.verify')}}
							</a>
							@endif
							@if(Auth::user()->can('view_reports'))
								<a class="btn btn-sm btn-default" href="{{ URL::to('patientreport/'.$test->visit->patient->id) }}">
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
		</div>
		<div class="panel-body">
		<!-- if there are creation errors, they will show here -->
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
			<div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
					{{ Form::open(array('route' => array('test.saveResults', $test->id), 'method' => 'POST')) }}
						@foreach($test->testType->measures as $measure)
							<div class="form-group">
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
			                        {{ Form::label($fieldName , $measure->name) }}
			                        {{ Form::text($fieldName, $ans, array(
			                            'class' => 'form-control result-interpretation-trigger',
			                            'data-url' => URL::route('test.resultinterpretation'),
			                            'data-age' => $test->visit->patient->dob,
			                            'data-gender' => $test->visit->patient->gender,
			                            'data-measureid' => $measure->id
			                            ))
			                        }}
		                            <span class='units'>
		                                {{Measure::getRange($test->visit->patient, $measure->id)}}
		                                {{$measure->unit}}
		                            </span>
								@elseif ( $measure->isAlphanumeric() || $measure->isAutocomplete() ) 
			                        <?php
			                        $measure_values = array();
		                            $measure_values[] = '';
			                        foreach ($measure->measureRanges as $range) {
			                            $measure_values[$range->alphanumeric] = $range->alphanumeric;
			                        }
			                        ?>
		                            {{ Form::label($fieldName , $measure->name) }}
		                            {{ Form::select($fieldName, $measure_values, array_search($ans, $measure_values),
		                                array('class' => 'form-control result-interpretation-trigger',
		                                'data-url' => URL::route('test.resultinterpretation'),
		                                'data-measureid' => $measure->id
		                                )) 
		                            }}
								@elseif ( $measure->isFreeText() ) 
		                            {{ Form::label($fieldName, $measure->name) }}
		                            {{Form::text($fieldName, $ans, array('class' => 'form-control'))}}
								@endif
		                    </div>
		                @endforeach
		                <div class="form-group">
		                    {{ Form::label('interpretation', trans('messages.interpretation')) }}
		                    {{ Form::textarea('interpretation', $test->interpretation, 
		                        array('class' => 'form-control result-interpretation', 'rows' => '2')) }}
		                </div>
		                @if(count($test->testType->organisms)>0)
                        <div class="panel panel-success">  <!-- Patient Details -->
	                        <div class="panel-heading">
	                            <h3 class="panel-title">{{trans("messages.culture-worksheet")}}</h3>
	                        </div>
	                        <div class="panel-body">
                                <p><strong>{{trans("messages.culture-work-up")}}</strong></p>
                                <table class="table table-bordered">
									<tbody>
										<tr>
											<th width="15%">{{ trans('messages.date')}}</th>
											<th width="10%">{{ trans('messages.tech-initials')}}</th>
											<th>{{ trans('messages.observations-and-work-up')}}</th>
											<th width="10%"></th>
										</tr>
										<tr>
											<td>{{ Test::showTimeAgo(date('Y-m-d')) }}</td>
											<td>{{ Auth::user()->name }}</td>
											<td>{{ Form::textarea('observation', $test->interpretation, 
					                        	array('class' => 'form-control result-interpretation', 'rows' => '2', 'id' => 'observation_'.$test->id)) }}
					                        </td>
											<td><a class="btn btn-xs btn-success" href="javascript:void(0)" onclick="saveObservation(<?php echo $test->id; ?>, <?php echo Auth::user()->id; ?>)">
												<span class="glyphicon glyphicon-thumbs-up">{{ trans('messages.save') }}</span></a>
											</td>
										</tr>
									</tbody>
								</table>
								<p><strong>{{trans("messages.susceptibility-test-results")}}</strong></p>
                                <table class="table table-bordered">
									<tbody>
										<tr>
											<th width="15%">{{ trans('messages.date')}}</th>
											<th width="10%">{{ trans('messages.tech-initials')}}</th>
											<th>{{ trans('messages.observations-and-work-up')}}</th>
											<th width="10%"></th>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
									</tbody>
								</table>
	                        </div> <!-- ./ panel-body -->
	                    </div> <!-- ./ panel -->
                        @endif
						<div class="form-group actions-row">
							{{ Form::button('<span class="glyphicon glyphicon-save"></span> '.trans('messages.update-test-results'),
								array('class' => 'btn btn-default', 'onclick' => 'submit()')) }}
						</div>
					{{ Form::close() }}
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
	                                        {{$test->visit->patient->patient_number}}</div></div>
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
	                                        {{$test->specimen->id or trans('messages.pending') }}
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
	                            <h3 class="panel-title">{{trans("messages.test-details")}}</h3>
	                        </div>
	                        <div class="panel-body">
	                            <div class="container-fluid">
	                                <div class="display-details">
	                                    <p class="view"><strong>{{ Lang::choice('messages.test-type',1) }}</strong>
	                                        {{ $test->testType->name or trans('messages.unknown') }}</p>
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
	                                    @if($test->isCompleted())
	                                    <p class="view"><strong>{{trans('messages.tested-by')}}</strong>
	                                        {{$test->testedBy->name or trans('messages.unknown')}}</p>
	                                    @endif
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
	                        </div> <!-- ./ panel-body -->
	                    </div>  <!-- ./ panel -->
	                </div>
				</div>
			</div>
		</div>
@stop