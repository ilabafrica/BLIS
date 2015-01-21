@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.report',2) }}</li>
	  <li class="active">{{ trans('messages.infection-report') }}</li>
	</ol>
</div>
<div class='container-fluid'>
{{ Form::open(array('route' => array('reports.aggregate.infection'), 'class' => 'form-inline', 'role' => 'form')) }}
<div class="row">
		<div class="col-sm-4 col-md-4">
	    	<div class="row">
				<div class="col-sm-2 col-md-2">
					{{ Form::label('start', trans("messages.from")) }}
				</div>
				<div class="col-sm-10 col-md-10">
					{{ Form::text('start', isset($input['start'])?$input['start']:date('Y-m-d'), 
				        array('class' => 'form-control standard-datepicker')) }}
			    </div>
	    	</div>
	    </div>
	    <div class="col-sm-4 col-md-4">
	    	<div class="row">
				<div class="col-sm-2 col-md-2">
			    	{{ Form::label('end', trans("messages.to")) }}
			    </div>
				<div class="col-sm-2 col-md-10">
				    {{ Form::text('end', isset($input['end'])?$input['end']:date('Y-m-d'), 
				        array('class' => 'form-control standard-datepicker')) }}
		        </div>
	    	</div>
	    </div>
	    <div class="col-sm-4 col-md-4">
		    {{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
		        array('class' => 'btn btn-info', 'id' => 'filter', 'type' => 'submit')) }}
	    </div>
	</div>
{{ Form::close() }}
</div>
<br />
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.infection-report') }}
	</div>
	<div class="panel-body">
	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif	
	<strong>
		<p> {{ trans('messages.infection-report') }} - 
			<?php $from = isset($input['start'])?$input['start']:date('01-m-Y');?>
			<?php $to = isset($input['end'])?$input['end']:date('d-m-Y');?>
			@if($from!=$to)
				{{trans('messages.from').' '.$from.' '.trans('messages.to').' '.$to}}
			@else
				{{trans('messages.for').' '.date('d-m-Y')}}
			@endif
		</p>
	</strong>
		<div class="table-responsive">
			<table class="table table-bordered">
				<tbody>
					<tr>
						<th rowspan="2">{{ Lang::choice('messages.test',1) }}</th>
						<th rowspan="2">{{ Lang::choice('messages.measure',1) }}</th>
						<th rowspan="2">{{ trans('messages.test-results') }}</th>
						<th rowspan="2">{{ trans('messages.gender') }}</th>
						<th colspan="{{ count($ageRanges) }}">{{ trans('messages.measure-age-range') }}</th>
						<th rowspan="2">{{ trans('messages.mf-total') }}</th>
						<th rowspan="2">{{ Lang::choice('messages.total',1) }}</th>
						<th rowspan="2">{{ trans('messages.total-tests') }}</th>
					</tr>
					<tr>
					@foreach($ageRanges as $ageRange)
						<th>{{ $ageRange }}</th>
				    @endforeach
					</tr>
					<?php 
						$testRow = "";

						$currentTest = "";
						$currentMeasure = "";
						$currentResult = "";

						$testCount = 0;
						$measureCount = 0;
						$resultCount = 0;

						$testTotal = 0;
						$resultTotal = 0;
					?>
					@forelse($infectionData as $inf)
						<?php
						$testCount++;
						$measureCount++;
						$resultCount++;

						if(strcmp($currentTest, $inf->test_name) == 0){
							$testRow.="<tr>";

							if(strcmp($currentMeasure, $inf->measure_name) != 0){
								$testRow = str_replace("NEW_MEASURE", $measureCount, $testRow);
								$testRow = str_replace("NEW_RESULT", $resultCount, $testRow);
								$testRow = str_replace("RESULT_TOTAL", $resultTotal, $testRow);

								$measureCount=0;
								$resultCount=0;
								$resultTotal = 0;

								$currentMeasure = $inf->measure_name;
								$currentResult = $inf->result;

								$testRow.="<td rowspan='NEW_MEASURE'>".$inf->measure_name."</td>";
								$testRow.="<td rowspan='NEW_RESULT'>".$inf->result."</td>";
							}else{
								if(strcmp($currentResult, $inf->result) != 0){
									$testRow = str_replace("NEW_RESULT", $resultCount, $testRow);
									$testRow = str_replace("RESULT_TOTAL", $resultTotal, $testRow);

									$resultCount=0;
									$resultTotal = 0;

									$currentResult = $inf->result;
									$testRow.="<td rowspan='NEW_RESULT'>".$inf->result."</td>";
								}
							}
						}else{
							$testRow = str_replace("NEW_TEST", $testCount, $testRow);
							$testRow = str_replace("NEW_MEASURE", $measureCount, $testRow);
							$testRow = str_replace("NEW_RESULT", $resultCount, $testRow);

							$testRow = str_replace("RESULT_TOTAL", $resultTotal, $testRow);
							$testRow = str_replace("TEST_TOTAL", $testTotal, $testRow);

							echo $testRow;

							$testCount=0;
							$measureCount=0;
							$resultCount=0;

							$testTotal = 0;
							$resultTotal = 0;

							$currentTest = $inf->test_name;
							$currentMeasure = $inf->measure_name;
							$currentResult = $inf->result;

							$testRow="<tr>";
							$testRow.="<td rowspan='NEW_TEST'>".$inf->test_name."</td>";
							$testRow.="<td rowspan='NEW_MEASURE'>".$inf->measure_name."</td>";
							$testRow.="<td rowspan='NEW_RESULT'>".$inf->result."</td>";
						}

						$testRow.="<td>".$inf->gender."</td>";
						$testRow.="<td>".$inf->RC_U_5."</td>";
						$testRow.="<td>".$inf->RC_5_15."</td>";
						$testRow.="<td>".$inf->RC_A_15."</td>";
						$testRow.="<td>".($inf->RC_U_5 + $inf->RC_5_15 + $inf->RC_A_15)."</td><!-- Male|Female Total-->";

						$testTotal += $inf->RC_U_5 + $inf->RC_5_15 + $inf->RC_A_15;
						$resultTotal += $inf->RC_U_5 + $inf->RC_5_15 + $inf->RC_A_15;

						if(strcmp($currentResult, $inf->result) == 0 && $resultCount == 0){
							$testRow.="<td rowspan='NEW_RESULT'>RESULT_TOTAL</td>";
						}

						if(strcmp($currentTest, $inf->test_name) == 0 && $testCount == 0){
							$testRow.="<td rowspan='NEW_TEST'>TEST_TOTAL</td>";
						}

						$testRow.="</tr>";
						?>
					@empty
						<tr>
							<td colspan="9">
								{{trans('messages.no-records-found')}}
							</td>
						</tr>
					@endforelse
					<?php
						$testRow = str_replace("NEW_TEST", $testCount+1, $testRow);
						$testRow = str_replace("NEW_MEASURE", $measureCount+1, $testRow);
						$testRow = str_replace("NEW_RESULT", $resultCount+1, $testRow);
						$testRow = str_replace("RESULT_TOTAL", $resultTotal, $testRow);
						$testRow = str_replace("TEST_TOTAL", $resultTotal, $testRow);
					?>
					{{$testRow}}
				</tbody>
			</table>
		</div>
	</div>
</div>

@stop