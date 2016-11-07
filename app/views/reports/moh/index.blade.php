@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li><a href="{{{URL::route('reports.patient.index')}}}">{{ Lang::choice('messages.report',2) }}</a></li>
	  <li class="active">{{ trans('messages.moh-706') }}</li>
	</ol>
</div>
<div class='container-fluid'>
    {{ Form::open(array('route' => array('reports.aggregate.moh706'), 'class' => 'form-inline')) }}
    <div class='row'>
    	<div class="col-sm-4">
	    	<div class="row">
				<div class="col-sm-2">
				    {{ Form::label('start', trans('messages.from')) }}
				</div>
				<div class="col-sm-2">
				    {{ Form::text('start', $from?$from:date('Y-m-01'),array('class' => 'form-control standard-datepicker')) }}
		        </div>
			</div>
		</div>
		<div class="col-sm-4">
	    	<div class="row">
				<div class="col-sm-2">
				    {{ Form::label('end', trans('messages.to')) }}
				</div>
				<div class="col-sm-2">{{ Form::text('end', $end?$end:date('Y-m-d'),array('class' => 'form-control standard-datepicker')) }}
		        </div>
			</div>
		</div>
		<div class="col-sm-4">
	    	<div class="row">
				<div class="col-sm-3">
				  	{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
		                array('class' => 'btn btn-info', 'id' => 'filter', 'type' => 'submit')) }}
		        </div>
		        <div class="col-sm-1">
					{{Form::submit(trans('messages.export-to-excel'), 
				    		array('class' => 'btn btn-success', 'id'=>'excel', 'name'=>'excel'))}}
				</div>
			</div>
		</div>
	</div>
	{{ Form::close() }}
</div>
<br />
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.moh-706') }}
	</div>
	<div class="panel-body">
	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif	
		<table width="100%">
			<thead>
	            <tr>
	            	<td colspan="3" style="text-align:center;">
	                    <strong><p>{{ strtoupper(Lang::choice('messages.moh', 1)) }}<br>
	                    {{ strtoupper(Lang::choice('messages.lab-tests-data-report', 1)) }}<br></p></strong>
	            	</td>
	            </tr>
            </thead>
		</table>
		<div class="table-responsive">
			<div class='container-fluid'>
				<strong>{{ Lang::choice('messages.facility', 1) }}: </strong><u>{{ strtoupper(Config::get('kblis.organization')) }}</u><strong> {{ Lang::choice('messages.reporting-period', 1) }} {{ Lang::choice('messages.begin-end', 1) }}: </strong><u>{{ $from }}</u>
				<strong> {{ Lang::choice('messages.begin-end', 2) }}: </strong><u>{{ $end }}</u><strong> {{ Lang::choice('messages.affiliation', 1) }}: </strong><u>{{ Lang::choice('messages.gok', 1) }}: </u>
				<br />
				<p>{{ Lang::choice('messages.no-service', 1) }}</p>
				<div class='row'>
                                    <!-- 1. URINE ANALYSIS -->
                                    <table class="table table-condensed report-table-border" style="width: 40%">
                                        <thead>
                                            <tr style="text-align: center;"><th colspan="3" ><strong>1. URINE ANALYSIS</strong></th> </tr>
                                            <tr>
                                                <th colspan="1"></th>
                                                <th>Total Exam</th>
                                                <th> Number positive</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td style="font-weight: bold">Urine Chemistry</td>
                                                <td>{{ $urineChemestryTotalExam }}</td>
                                                <td style="background-color: #CCCCCC;"></td>
                                            </tr>
                                            @foreach($urineChemistryList as $measure)
                                                <tr>
                                                <td >{{ $measure['name'] }}</td>
                                                <td style="background-color: #CCCCCC;"></td>
                                                <td>{{ $measure['positive'] }}</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td style="font-weight: bold">Urine Microscopy</td>
                                                <td>{{ $urineMicroscopyTotalExam }}</td>
                                                <td style="background-color: #CCCCCC;"></td>
                                            </tr>
                                            @foreach($urineMicroscopyList as $measure)
                                                <tr>
                                                <td >{{ $measure['name'] }}</td>
                                                <td style="background-color: #CCCCCC;"></td>
                                                <td>{{ $measure['positive'] }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- 2. BLOOD CHEMISTRY -->
                                    <table class="table table-condensed report-table-border" style="width: 40%">
                                        <thead>
                                            <tr style="text-align: center;"><th colspan="4" ><strong>2. BLOOD CHEMISTRY</strong></th> </tr>
                                            <tr>
                                                <th colspan="1" style="font-weight: bold">Blood Sugar Test Chemistry</th>
                                                <th>Total Exam</th>
                                                <th>Low</th>
                                                <th>High</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($bloodSugarTestList as $measure) <!-- Blood sugar test -->
                                                <tr>
                                                <td >{{ $measure['name'] }}</td>
                                                <td>{{ $measure['total'] }}</td>
                                                <td>{{ $measure['low'] }}</td>
                                                <td>{{ $measure['high'] }}</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td style="font-weight: bold">Renal Function Test</td> 
                                                <td>{{ $renalFunctionTestTotalExam }}</td>
                                                <td style="background-color: #CCCCCC;"></td>
                                                <td style="background-color: #CCCCCC;"></td>
                                            </tr>
                                            @foreach($renalFunctionTestList as $measure)<!-- renal function test -->
                                                <tr>
                                                <td >{{ $measure['name'] }}</td>
                                                <td style="background-color: #CCCCCC;"></td>
                                                <td>{{ $measure['low'] }}</td>
                                                <td>{{ $measure['high'] }}</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td style="font-weight: bold">Liver Function Test</td> 
                                                <td>{{ $liverFunctionTestTotalExam }}</td>
                                                <td style="background-color: #CCCCCC;"></td>
                                                <td style="background-color: #CCCCCC;"></td>
                                            </tr>
                                            @foreach($liverFunctionTestList as $measure) <!-- liver function test -->
                                            <tr>
                                                <td >{{ $measure['name'] }}</td>
                                                <td style="background-color: #CCCCCC;"></td>
                                                <td>{{ $measure['low'] }}</td>
                                                <td>{{ $measure['high'] }}</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td style="font-weight: bold">Lipid Profile</td> 
                                                <td>{{ $lipidProfileTotalExam }}</td>
                                                <td style="background-color: #CCCCCC;"></td>
                                                <td style="background-color: #CCCCCC;"></td>
                                            </tr>
                                            @foreach($lipidProfileList as $measure) <!-- Lipid Profile -->
                                                <tr>
                                                <td>{{ $measure['name'] }}</td>
                                                <td>{{ $measure['total'] }}</td>
                                                <td>{{ $measure['low'] }}</td>
                                                <td>{{ $measure['high'] }}</td>
                                            </tr>
                                            @endforeach
                                            <tr style="font-weight: bold">
                                                <td>Hormonal Test</td> 
                                                <td>Total Exam</td>
                                                <td>Low</td>
                                                <td>High</td>
                                            </tr>
                                            @foreach($hormonalTestList as $measure) <!-- Hormonal test -->
                                                <tr>
                                                <td >{{ $measure['name'] }}</td>
                                                <td>{{ $measure['total'] }}</td>
                                                <td>{{ $measure['low'] }}</td>
                                                <td>{{ $measure['high'] }}</td>
                                            </tr>
                                            @endforeach
                                            <tr style="font-weight: bold">
                                                <td>Tumor Markers</td> 
                                                <td>Total Exam</td>
                                                <td colspan="2">Positive</td>
                                            </tr>
                                            @foreach($tumorMarkersList as $measure) <!-- Tumor Makers -->
                                                <tr>
                                                <td>{{ $measure['name'] }}</td>
                                                <td>{{ $measure['total'] }}</td>
                                                <td colspan="2">{{ $measure['positive'] }}</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td style="font-weight: bold">CSF Chemistry</td> 
                                                <td>Total Exam</td>
                                                <td>Low</td>
                                                <td>High</td>
                                            </tr>
                                            @foreach($csfChemistryList as $measure) <!-- CSF Chemistry -->
                                                <tr>
                                                <td>{{ $measure['name'] }}</td>
                                                <td>{{ $measure['total'] }}</td>
                                                <td>{{ $measure['low'] }}</td>
                                                <td>{{ $measure['high'] }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- 3. PARASITOLOGY -->
                                    <table class="table table-condensed report-table-border" style="width: 40%">
                                        <thead>
                                            <tr style="text-align: center;"><th colspan="4" ><strong>3. PARASITOLOGY</strong></th> </tr>
                                            <tr>
                                                <th colspan="1" style="font-weight: bold">Malaria test</th>
                                                <th colspan="2">Total Exam</th>
                                                <th>Number Positive</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($malariaTestList as $measure) <!-- Blood sugar test -->
                                                <tr>
                                                <td >{{ $measure['name'] }}</td>
                                                <td colspan="2">{{ $measure['total'] }}</td>
                                                <td>{{ $measure['positive'] }}</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td style="font-weight: bold">Stool Examination</td> 
                                                <td colspan="2">{{ $stoolAnalysisTotalExam }}</td>
                                                <td style="font-weight: bold">Number Positive</td>
                                            </tr>
                                            @foreach($stoolAnalysisList as $measure)<!-- renal function test -->
                                                <tr>
                                                <td >{{ $measure['name'] }}</td>
                                                <td colspan="2" style="background-color: #CCCCCC;"></td>
                                                <td>{{ $measure['positive'] }}</td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
				</div>
			</div>
		</div>
	</div>
</div>
@stop