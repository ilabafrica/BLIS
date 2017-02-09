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
                                                <td>{{ $moh706List['urineChemestryTotalExam'] }}</td>
                                                <td style="background-color: #CCCCCC;"></td>
                                            </tr>
                                            @foreach($moh706List['urineChemistryList'] as $measure)
                                                <tr>
                                                <td >{{ $measure['name'] }}</td>
                                                <td style="background-color: #CCCCCC;"></td>
                                                <td>{{ $measure['positive'] }}</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td style="font-weight: bold">Urine Microscopy</td>
                                                <td>{{ $moh706List['urineMicroscopyTotalExam'] }}</td>
                                                <td style="background-color: #CCCCCC;"></td>
                                            </tr>
                                            @foreach($moh706List['urineMicroscopyList'] as $measure)
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
                                            <!-- Blood sugar test -->
                                            @foreach($moh706List['bloodSugarTestList'] as $measure)
                                                <tr>
                                                <td >{{ $measure['name'] }}</td>
                                                <td>{{ $measure['total'] }}</td>
                                                <td>{{ $measure['low'] }}</td>
                                                <td>{{ $measure['high'] }}</td>
                                            </tr>
                                            @endforeach
                                            <!-- renal function test -->
                                            <tr>
                                                <td style="font-weight: bold">Renal Function Test</td> 
                                                <td>{{ $moh706List['renalFunctionTestTotalExam'] }}</td>
                                                <td style="background-color: #CCCCCC;"></td>
                                                <td style="background-color: #CCCCCC;"></td>
                                            </tr>
                                            @foreach($moh706List['renalFunctionTestList'] as $measure)
                                                <tr>
                                                <td >{{ $measure['name'] }}</td>
                                                <td style="background-color: #CCCCCC;"></td>
                                                <td>{{ $measure['low'] }}</td>
                                                <td>{{ $measure['high'] }}</td>
                                            </tr>
                                            @endforeach
                                            <!-- liver function test -->
                                            <tr>
                                                <td style="font-weight: bold">Liver Function Test</td> 
                                                <td>{{ $moh706List['liverFunctionTestTotalExam'] }}</td>
                                                <td style="background-color: #CCCCCC;"></td>
                                                <td style="background-color: #CCCCCC;"></td>
                                            </tr>
                                            @foreach($moh706List['liverFunctionTestList'] as $measure) 
                                            <tr>
                                                <td >{{ $measure['name'] }}</td>
                                                <td style="background-color: #CCCCCC;"></td>
                                                <td>{{ $measure['low'] }}</td>
                                                <td>{{ $measure['high'] }}</td>
                                            </tr>
                                            @endforeach
                                            <!-- Lipid Profile -->
                                            <tr>
                                                <td style="font-weight: bold">Lipid Profile</td> 
                                                <td>{{ $moh706List['lipidProfileTotalExam'] }}</td>
                                                <td style="background-color: #CCCCCC;"></td>
                                                <td style="background-color: #CCCCCC;"></td>
                                            </tr>
                                            @foreach($moh706List['lipidProfileList'] as $measure) 
                                                <tr>
                                                <td>{{ $measure['name'] }}</td>
                                                <td>{{ $measure['total'] }}</td>
                                                <td>{{ $measure['low'] }}</td>
                                                <td>{{ $measure['high'] }}</td>
                                            </tr>
                                            @endforeach
                                            <!-- Hormonal test -->
                                            <tr style="font-weight: bold">
                                                <td>Hormonal Test</td> 
                                                <td>Total Exam</td>
                                                <td>Low</td>
                                                <td>High</td>
                                            </tr>
                                            @foreach($moh706List['hormonalTestList'] as $measure) 
                                                <tr>
                                                <td >{{ $measure['name'] }}</td>
                                                <td>{{ $measure['total'] }}</td>
                                                <td>{{ $measure['low'] }}</td>
                                                <td>{{ $measure['high'] }}</td>
                                            </tr>
                                            @endforeach
                                            <!-- Tumor Makers -->
                                            <tr style="font-weight: bold">
                                                <td>Tumor Markers</td> 
                                                <td>Total Exam</td>
                                                <td colspan="2">Positive</td>
                                            </tr>
                                            @foreach($moh706List['tumorMarkersList'] as $measure) 
                                                <tr>
                                                <td>{{ $measure['name'] }}</td>
                                                <td>{{ $measure['total'] }}</td>
                                                <td colspan="2">{{ $measure['positive'] }}</td>
                                            </tr>
                                            @endforeach
                                            <!-- CSF Chemistry -->
                                            <tr>
                                                <td style="font-weight: bold">CSF Chemistry</td> 
                                                <td>Total Exam</td>
                                                <td>Low</td>
                                                <td>High</td>
                                            </tr>
                                            @foreach($moh706List['csfChemistryList'] as $measure) 
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
                                            @foreach($moh706List['malariaTestList'] as $measure) <!-- Blood sugar test -->
                                                <tr>
                                                <td >{{ $measure['name'] }}</td>
                                                <td colspan="2">{{ $measure['total'] }}</td>
                                                <td>{{ $measure['positive'] }}</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td style="font-weight: bold">Stool Examination</td> 
                                                <td colspan="2">{{ $moh706List['stoolAnalysisTotalExam'] }}</td>
                                                <td style="font-weight: bold">Number Positive</td>
                                            </tr>
                                            @foreach($moh706List['stoolAnalysisList'] as $measure)<!-- renal function test -->
                                                <tr>
                                                <td >{{ $measure['name'] }}</td>
                                                <td colspan="2" style="background-color: #CCCCCC;"></td>
                                                <td>{{ $measure['positive'] }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                     <!-- 4. HAEMATOLOGY -->
                                    <table class="table table-condensed report-table-border" style="width: 40%">
                                        <thead>
                                            <tr style="text-align: center;"><th colspan="4" ><strong>4. HAEMATOLOGY</strong></th> </tr>
                                            <tr>
                                                <th colspan="1" style="font-weight: bold">Haematology test</th>
                                                <th>Total Exam</th>
                                                <th>HB < 5g/dl</th>
                                                <th>HB between 5 - 10 g/dl</th>                                                
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($moh706List['haematologyTestList'] as $measure) <!-- Haematology test -->
                                            @if($measure['name'] == $moh706List['CD4_FLAG'])
                                                <tr>
                                                <td ></td>
                                                <td></td>
                                                <td colspan="2" style="font-weight: bold; align-content: center;">Number <500</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>{{ $measure['name'] }}</td>
                                                <td>{{ $measure['total'] }}</td>
                                                @if($measure['name'] == $moh706List['CD4_FLAG'])<!-- display CD4 count's only 'low' count -->
                                                    <td colspan="2">{{ $measure['low'] }}</td>
                                                    @else <!-- display the rest as low and high -->
                                                    <td>{{ $measure['low'] }}</td>
                                                    <td>{{ $measure['high'] }}</td>
                                                @endif
                                            </tr>
                                            @endforeach
                                            <tr style="font-weight: bold"> <!-- Other Haematology tests -->
                                                <td>Other Haematology tests</td> 
                                                <td>Total Exam</td>
                                                <td colspan="2">Positive</td>
                                            </tr>
                                            @foreach($moh706List['otherHaematologyTestsList'] as $measure) <!-- Tumor Makers -->
                                                @if($measure['name'] == $moh706List['ESR_FLAG'])
                                                <tr>
                                                    <td style="background-color: #CCCCCC;"</td>
                                                    <td style="background-color: #CCCCCC;"></td>
                                                    <td colspan="2" style="font-weight: bold">High</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $measure['name'] }}</td>
                                                    <td style="background-color: #CCCCCC;"></td>
                                                    <td colspan="2">{{ $measure['high'] }}</td>
                                                </tr>
                                                @else
                                                <tr>
                                                    <td>{{ $measure['name'] }}</td>
                                                    <td>{{ $measure['total'] }}</td>
                                                    <td colspan="2" style="background-color: #CCCCCC;"></td>
                                                </tr>
                                                @endif
                                            
                                            @endforeach
                                             <tr style="font-weight: bold"> <!-- Blood grouping -->
                                                 <td colspan="2">Blood grouping</td> 
                                                <td colspan="2">Number</td>
                                            </tr>
                                            @foreach($moh706List['bloodGroupingList'] as $measure) 
                                                @if($measure['name'] == $moh706List['BG_FLAG'])
                                                <tr>
                                                    <td colspan="2" style="font-weight: bold">Blood Safety</td>
                                                    <td colspan="2" style="font-weight: bold">Number</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="2">{{ $measure['name'] }}</td>
                                                    <td colspan="2">{{ $measure['total'] }}</td>
                                                </tr>                                                                                           
                                            @endforeach
                                            <tr style="font-weight: bold"> <!-- Blood screening at facility -->
                                                <td colspan="2">Blood screening at facility</td> 
                                                <td colspan="2">Number Positive</td>
                                            </tr>
                                            @foreach($moh706List['bloodScreeningList'] as $measure) 
                                                <tr>
                                                    <td colspan="2">{{ $measure['name'] }}</td>
                                                    <td colspan="2">{{ $measure['positive'] }}</td>
                                                </tr>                                                                                        
                                            @endforeach
                                        </tbody>
                                        <!-- 5. BACTERIOLOGY -->
                                    <table class="table table-condensed report-table-border" style="width: 40%">
                                        <thead>
                                            <tr style="text-align: center;"><th colspan="4" ><strong>5. BACTERIOLOGY</strong></th> </tr>
                                            <tr>
                                                <th colspan="1" style="font-weight: bold">Bacteriological Sample</th>
                                                <th>Total Exam</th>
                                                <th>Total Cultures</th>
                                                <th>No. Culture Positive</th>                                                
                                            </tr>
                                        </thead>

                                        <tbody>
                                        <!-- Tumor Makers -->
                                        @foreach($moh706List['bacterolgicalSampleList'] as $measure) 
                                            <tr>
                                                <td>{{ $measure['name'] }}</td>
                                                <td>{{ $measure['count'] }}</td>
                                                <td>{{ $measure['total'] }}</td>
                                                <td>{{ $measure['positive'] }}</td>
                                            </tr>                                           
                                        @endforeach
                                        <!-- Bacterial enteric pathogens -->
                                            <tr style="font-weight: bold"> 
                                                <td colspan="2">Bacterial enteric pathogens</td> 
                                                <td>Total Exam</td>
                                                <td>Number Positive</td>
                                            </tr>
                                        @foreach($moh706List['stoolCultureList'] as $measure) 
                                            <tr>
                                                <td colspan="2">{{ $measure['name'] }}</td>
                                                <td>{{ $measure['total'] }}</td>
                                                <td>{{ $measure['positive'] }}</td>
                                            </tr>                                                                                        
                                        @endforeach
                                        <tr style="font-weight: bold"> <!-- Stool Isolates -->
                                                <td colspan="2">Stool Isolates</td> 
                                                <td colspan="2">Number Positive</td>
                                            </tr>
                                        @foreach($moh706List['stoolIsolateList'] as $measure) 
                                            <tr>
                                                <td colspan="2">{{ $measure['name'] }}</td>
                                                <td colspan="2">{{ $measure['positive'] }}</td>
                                            </tr>                                                                                        
                                        @endforeach
                                         <!-- Bacterial Meningitis -->
                                        <tr><td colspan="4" style="font-weight: bold; align-content: center;">Bacterial Meningitis</td></tr>
                                        @foreach($moh706List['bacterialMeningitisList'] as $measure)
                                            @if($measure['name'] == $moh706List['CSF_FLAG'])
                                            <tr style="font-weight: bold;">
                                                <td>Bacterial Meningitis</td>
                                                <td>Total exam</td>
                                                <td>Number positive</td>
                                                <td>Number contaminated</td>
                                            </tr>
                                            @else
                                            <tr style="font-weight: bold;">
                                                <td colspan="2">Bacterial meningitis serotypes</td>
                                                <td colspan="2">Number positive</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                @if($measure['name'] == $moh706List['CSF_FLAG'])<!-- display CSF -->
                                                    <td>{{ $measure['name'] }}</td>
                                                    <td>{{ $measure['total'] }}</td>
                                                    <td>{{ $measure['positive'] }}</td>
                                                    <td>{{ $measure['contaminated'] }}</td>
                                                @else 
                                                    @if($measure['name'] == $moh706List['BP_FLAG'])
                                                        <tr>
                                                            <td colspan="4" style="font-weight: bold; align-content: center;">
                                                                Bacterial Pathogens from other types of specimen
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <td colspan="2">{{ $measure['name'] }}</td>
                                                    <td colspan="2">{{ $measure['positive'] }}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        <!-- Sputum -->
                                        <tr style="font-weight: bold">
                                            <td colspan="2">SPUTUM </td> 
                                            <td>Total Exam</td>
                                            <td>Positive</td>
                                        </tr>
                                        @foreach($moh706List['sputumList'] as $measure) 
                                        <tr>
                                            <td colspan="2">{{ $measure['name'] }}</td>
                                            <td>{{ $measure['total'] }}</td>
                                            <td>{{ $measure['positive'] }}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                         <!-- 6. HISTOLOGY AND CYTOLOGY -->
                                    <table class="table table-condensed report-table-border" style="width: 40%">
                                        <thead>
                                            <tr style="text-align: center;"><th colspan="4" ><strong>6. HISTOLOGY AND CYTOLOGY</strong></th> </tr>
                                            <tr>
                                                <th colspan="2" style="font-weight: bold">Smears</th>
                                                <th>Total Exam</th>
                                                <th>Malignant</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <!-- Smears -->
                                        @foreach($moh706List['smearsList'] as $measure) 
                                            <tr>
                                                <td colspan="2">{{ $measure['name'] }}</td>
                                                <td>{{ $measure['total'] }}</td>
                                                <td>{{ $measure['positive'] }}</td> <!-- malignant -->
                                            </tr>                                           
                                        @endforeach
                                        <!-- Fine Needles Aspirates -->
                                            <tr style="font-weight: bold"> 
                                                <td colspan="2">Fine Needles Aspirates</td> 
                                                <td>Total Exam</td>
                                                <td>Malignant</td>
                                            </tr>
                                        @foreach($moh706List['aspiratesList'] as $measure) 
                                            <tr>
                                                <td colspan="2">{{ $measure['name'] }}</td>
                                                <td>{{ $measure['total'] }}</td>
                                                <td>{{ $measure['positive'] }}</td> <!-- malignant -->
                                            </tr>                                                                                        
                                        @endforeach
                                        <!-- Fluid Cytology -->
                                            <tr style="font-weight: bold"> 
                                                <td colspan="2"> Fluid Cytology </td> 
                                                <td>Total Exam</td>
                                                <td>Malignant</td>
                                            </tr>
                                        @foreach($moh706List['fluidCytologyList'] as $measure) 
                                            <tr>
                                                <td colspan="2">{{ $measure['name'] }}</td>
                                                <td>{{ $measure['total'] }}</td>
                                                <td>{{ $measure['positive'] }}</td> <!-- malignant -->
                                            </tr>                                                                                        
                                        @endforeach
                                        <!-- Bone Marrow Studies -->
                                            <tr style="font-weight: bold"> 
                                                <td colspan="2">Bone Marrow Studies</td> 
                                                <td>Total Exam</td>
                                                <td>Malignant</td>
                                            </tr>
                                        @foreach($moh706List['boneMurrowStudiesList'] as $measure) 
                                            <tr>
                                                <td colspan="2">{{ $measure['name'] }}</td>
                                                <td>{{ $measure['total'] }}</td>
                                                <td>{{ $measure['positive'] }}</td> <!-- malignant -->
                                            </tr>                                                                                        
                                        @endforeach
                                        </tbody>
                                    </table>
                                              <!-- 7. SEROLOGY -->
                                    <table class="table table-condensed report-table-border" style="width: 40%">
                                        <thead>
                                            <tr style="text-align: center;"><th colspan="4" ><strong>7. SEROLOGY</strong></th> </tr>
                                            <tr>
                                                <th colspan="2" style="font-weight: bold">Serological Test</th>
                                                <th>Total Exam</th>
                                                <th>Number Positive</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <!-- Serological test -->
                                        @foreach($moh706List['serologyList'] as $measure) 
                                            <tr>
                                                <td colspan="2">{{ $measure['name'] }}</td>
                                                <td>{{ $measure['total'] }}</td>
                                                @if($measure['name'] != $moh706List['CRAG_FLAG'])
                                                    <td>{{ $measure['positive'] }}</td>
                                                @else
                                                    <td style="background-color: #CCCCCC;"></td>
                                                @endif                                                
                                            </tr>                                           
                                        @endforeach
                                        
                                        </tbody>
                                    </table>
                                              
                                    <!-- 8. SPECIMEN REFERRAL TO HIGHER LEVELS -->
                                    <table class="table table-condensed report-table-border" style="width: 40%">
                                        <thead>
                                            <tr style="text-align: center;"><th colspan="4" ><strong>8. SPECIMEN REFERRAL TO HIGHER LEVELS</strong></th> </tr>
                                            <tr>
                                                <th colspan="2" style="font-weight: bold">Specimen Referral</th>
                                                <th>No. of specimens</th>
                                                <th>No. of results received</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <!-- Specimen Referral -->
                                        @foreach($moh706List['specimenReferralList'] as $measure) 
                                            <tr>
                                                <td colspan="2">{{ $measure['name'] }}</td>
                                                <td>{{ $measure['total'] }}</td>
                                                <td>{{ $measure['positive'] }}</td>
                                            </tr>                                           
                                        @endforeach
                                        
                                        </tbody>
                                    </table>
                                    
                                    <!-- 9. DRUG SUSCEPTIBILITY TESTING -->
                                    <table class="table table-condensed report-table-border" style="width: 100%">
                                        <thead>
                                            <tr style="text-align: center;"><th colspan="32" ><strong>9. DRUG SUSCEPTIBILITY TESTING</strong></th> </tr>
                                            <tr>
                                                <th colspan="2" style="font-weight: bold">Drug Sensitivity Pattern</th>
                                                @foreach($moh706List['drugs'] as $drug)
                                                    <th colspan="3" style="font-size: 12px"> {{ $drug['name'] }}</th>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th colspan="2"></th>
                                                @foreach($moh706List['drugs'] as $drug)
                                                    <th style="font-size: 10px">S</th>
                                                    <th style="font-size: 10px">I</th>
                                                    <th style="font-size: 10px">R</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <!-- Specimen Referral -->
                                        @foreach($moh706List['organisms'] as $organism) 
                                            <tr>
                                                <td colspan="2">{{ $organism['name'] }}</td>
                                                @for ($i = 0; $i < count($moh706List['drugs']); $i++)<!-- populate each sensitivity on each drug per organism -->
                                                    <td style="font-size: 10px">{{ $organism['drug'][$i]['s']}}</td>
                                                    <td style="font-size: 10px">{{ $organism['drug'][$i]['i']}}</td>
                                                    <td style="font-size: 10px">{{ $organism['drug'][$i]['r']}}</td>
                                                @endfor
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