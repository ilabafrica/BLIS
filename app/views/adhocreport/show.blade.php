
<div id="report_content">
@include("reportHeader")

		<table class="table table-bordered">
			<tbody>
				<tr>
					<th>{{ trans('messages.patient-name')}}</th>
					@if(Entrust::can('view_names'))
						<td>{{ $patient->name }}</td>
					@else
						<td>N/A</td>
					@endif
					<th>{{ trans('messages.gender')}}</th>
					<td>{{ $patient->getGender(false) }}</td>
				</tr>
				<tr>
					<th>{{ trans('messages.patient-id')}}</th>
					<td>{{ $patient->patient_number}}</td>
					<th>{{ trans('messages.age')}}</th>
					<td>{{ $patient->getAge()}}</td>
				</tr>
				<tr>
					<th>{{ trans('messages.patient-lab-number')}}</th>
					<td>{{ $patient->external_patient_number }}</td>
					<th>{{ trans('messages.requesting-facility-department')}}</th>
					<td>{{ Config::get('kblis.organization') }}</td>
				</tr>
			</tbody>
		</table>

		<table class="table table-bordered">
			<tbody>
				<tr>
					<th colspan="{{count($specimenColumns)}}">{{trans('messages.specimen')}}</th>
				</tr>
				<tr>
                @foreach($specimenColumns as $specimen)
                    @if($specimen['name']==Lang::choice('messages.specimen-type', 1))
					<th>{{ Lang::choice('messages.specimen-type', 1)}}</th>
                    @endif
                    @if($specimen['name']==Lang::choice('messages.test', 2))
					<th>{{ Lang::choice('messages.test', 2)}}</th>
                    @endif
                    @if($specimen['name']==trans('messages.date-ordered'))
					<th>{{ trans('messages.date-ordered') }}</th>
                    @endif
                    @if($specimen['name']==Lang::choice('messages.test-category', 2))
					<th>{{ Lang::choice('messages.test-category', 2)}}</th>
                    @endif
                    @if($specimen['name']==trans('messages.specimen-status'))
					<th>{{ trans('messages.specimen-status')}}</th>
                    @endif
                    @if($specimen['name']==trans('messages.collected-by')."/".trans('messages.rejected-by'))
					<th>{{ trans('messages.collected-by')."/".trans('messages.rejected-by')}}</th>
                    @endif
                    @if($specimen['name']==trans('messages.date-checked'))
					<th>{{ trans('messages.date-checked')}}</th>
                    @endif
                @endforeach
				</tr>
				@forelse($tests as $test)
						<tr>
                        @foreach($specimenColumns as $specimen)
                            @if($specimen['name']==Lang::choice('messages.specimen-type', 1))
							<td>{{ $test->specimen->specimenType->name }}</td>
                            @endif
                            @if($specimen['name']==Lang::choice('messages.test', 2))
							<td>{{ $test->testType->name }}</td>
                            @endif
                            @if($specimen['name']==trans('messages.date-ordered'))
							<td>{{ $test->isExternal()?$test->external()->request_date:$test->time_created }}</td>
                            @endif
                            @if($specimen['name']==Lang::choice('messages.test-category', 2))
							<td>{{ $test->testType->testCategory->name }}</td>
                            @endif
                           
							@if($test->specimen->specimen_status_id == Specimen::NOT_COLLECTED)
                                @if($specimen['name']==trans('messages.specimen-status'))
								<td>{{trans('messages.specimen-not-collected')}}</td>
                                @endif
                                 @if($specimen['name']==trans('messages.collected-by')."/".trans('messages.rejected-by'))
								<td></td>
                                @endif
                                 @if($specimen['name']==trans('messages.date-checked'))
								<td></td>
                                 @endif
							@elseif($test->specimen->specimen_status_id == Specimen::ACCEPTED)
                                @if($specimen['name']==trans('messages.specimen-status'))
								<td>{{trans('messages.specimen-accepted')}}</td>
                                @endif
                                @if($specimen['name']==trans('messages.collected-by')."/".trans('messages.rejected-by'))
								<td>{{$test->specimen->acceptedBy->name}}</td>
                                 @endif
                                @if($specimen['name']==trans('messages.date-checked'))
								<td>{{$test->specimen->time_accepted}}</td>
                                @endif
                            
							@elseif($test->specimen->specimen_status_id == Specimen::REJECTED)
                                @if($specimen['name']==trans('messages.specimen-status'))
								<td>{{trans('messages.specimen-rejected')}}</td>
                                @endif
                                @if($specimen['name']==trans('messages.collected-by')."/".trans('messages.rejected-by'))
								<td>{{$test->specimen->rejectedBy->name}}</td>
                                @endif
                                @if($specimen['name']==trans('messages.date-checked'))
								<td>{{$test->specimen->time_rejected}}</td>
                                @endif
							
                            @endif
                            @endforeach
						</tr>
				@empty
					<tr>
						<td colspan="{{count($specimenColumns)}}">{{trans("messages.no-records-found")}}</td>
					</tr>
				@endforelse

			</tbody>
		</table>
		<table class="table table-bordered">
			<tbody>
				<tr>
					<th colspan="{{count($resultsColumns)}}">{{trans('messages.test-results')}}</th>
				</tr>
				<tr>
                @foreach($resultsColumns as $result)
                    @if($result['name']==Lang::choice('messages.test-type',1))
					<th>{{Lang::choice('messages.test-type', 1)}}</th>
                    @endif
                    @if($result['name']==trans('messages.test-results-values'))
					<th>{{trans('messages.test-results-values')}}</th>
                     @endif
                    @if($result['name']==trans('messages.test-remarks'))
					<th>{{trans('messages.test-remarks')}}</th>
                     @endif
                    @if($result['name']==trans('messages.tested-by'))
					<th>{{trans('messages.tested-by')}}</th>
                     @endif
                    @if($result['name']==trans('messages.results-entry-date'))
					<th>{{trans('messages.results-entry-date')}}</th>
                     @endif
                    @if($result['name']==trans('messages.date-tested'))
					<th>{{trans('messages.date-tested')}}</th>
                     @endif
                    @if($result['name']==trans('messages.verified-by'))
					<th>{{trans('messages.verified-by')}}</th>
                     @endif
                    @if($result['name']==trans('messages.date-verified'))
					<th>{{trans('messages.date-verified')}}</th>
                     @endif
                @endforeach
				</tr>
				@forelse($tests as $test)
						<tr>
                        @foreach($resultsColumns as $result)
                        @if($result['name']==Lang::choice('messages.test-type',1))
							<td>{{ $test->testType->name }}</td>
                             @endif
                             @if($result['name']==trans('messages.test-results-values'))
							<td>
								@foreach($test->testResults as $result)
									<p>
										{{ Measure::find($result->measure_id)->name }}: {{ $result->result }}
										{{ Measure::getRange($test->visit->patient, $result->measure_id) }}
										{{ Measure::find($result->measure_id)->unit }}
									</p>
								@endforeach</td>
                            @endif
                             @if($result['name']==trans('messages.test-remarks'))
							<td>{{ $test->interpretation == '' ? 'N/A' : $test->interpretation }}</td>
                             @endif
                             @if($result['name']==trans('messages.tested-by'))
							<td>{{ $test->testedBy->name or trans('messages.pending')}}</td>
                             @endif
                             @if($result['name']==trans('messages.results-entry-date'))
							<td>{{ $test->testResults->last()->time_entered }}</td>
                             @endif
                             @if($result['name']==trans('messages.date-tested'))
							<td>{{ $test->time_completed }}</td>
                             @endif
                            @if($result['name']==trans('messages.verified-by'))
							<td>{{ $test->verifiedBy->name or trans('messages.verification-pending')}}</td>
                             @endif
                             @if($result['name']==trans('messages.date-verified'))
							<td>{{ $test->time_verified }}</td>
                             @endif
                        @endforeach
						</tr>
				@empty
					<tr>
						<td colspan="{{count($resultsColumns)}}">{{trans("messages.no-records-found")}}</td>
					</tr>
				@endforelse
			</tbody>
		</table>
</div>