@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active"><a href="{{ URL::route('reports.patient.index') }}">{{ trans('messages.reports') }}</a></li>
	  <li class="active">{{ trans('messages.daily-log') }} - {{trans('messages.patient-records')}}</li>
	</ol>
</div>
{{ Form::open(array('route' => array('reports.daily.log'), 'class' => 'form-inline', 'role' => 'form')) }}
	<div class="table-responsive">
  <table class="table">
    <thead>
    <tr>
        <td>{{ Form::label('from', trans("messages.from")) }}</td>
        <td>
            <input class="form-control standard-datepicker" name="start" type="text" 
                    value="{{ isset($from) ? $from : '' }}" id="start">
        </td>
        <td>{{ Form::label('to', trans("messages.to")) }}</td>
         <td>
             <input class="form-control standard-datepicker" name="end" type="text" 
                    value="{{ isset($to) ? $to : '' }}" id="end">
         </td>
        <td>{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
                        array('class' => 'btn btn-primary', 'style' => 'width:125px', 'id' => 'filter', 'type' => 'submit')) }}</td>
    </tr>
    <tr>
        <td><label class="radio-inline">
			  {{ Form::radio('records', '1', false, array('data-toggle' => 'radio', 'id' => 'tests')) }} {{trans('messages.test-records')}}
			</label></td>
        <td><label class="radio-inline">
			  {{ Form::radio('records', '2', true, array('data-toggle' => 'radio', 'id' => 'patients')) }} {{trans('messages.patient-records')}}
			</label></td>
        <td><label class="radio-inline">
			  {{ Form::radio('records', '3', false, array('data-toggle' => 'radio', 'id' => 'specimens')) }} {{trans('messages.rejected-specimen')}}
			</label></td>
		<td>{{ Form::button("<span class='glyphicon glyphicon-eye-open'></span> ".trans('messages.show-hide'), 
                        array('class' => 'btn btn-default', 'id' => 'reveal')) }}</td>
        <td>{{Form::submit('Export to Word', array('class' => 'btn btn-success', 'id'=>'word', 'name'=>'word'))}}</td>
    </tr>
</thead>
<tbody>
	
</tbody>
  </table>
  {{ Form::close() }}

<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.daily-log') }} - {{trans('messages.patient-records')}}
	</div>
	<div class="panel-body">

	<!-- if there are search errors, they will show here -->
	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif
  <div id="patient_records_div">
  <table class="table">
		<thead>
			<tr>
				<td><img src="{{ Config::get('kblis.organization-logo') }}" alt="" height="90" width="90"></td>
				<td colspan="3" style="text-align:center;">
					<strong><p>BUNGOMA DISTRICT HOSPITAL LABORATORY<br>
					BUNGOMA TOWN, HOSPITAL ROAD<br>
					OPPOSITE POLICE LINE/DISTRICT HEADQUARTERS<br>
					P.O. BOX 14,<br>
					BUNGOMA TOWN.<br>
					Phone: +254 055-30401 Ext 203/208</p>

					<p>LABORATORY REPORT<br>
					Daily Patient Records @if($from!=$to){{'From '.$from.' To '.$to}}@else{{'For '.date('d-m-Y')}}@endif</p></strong>			
				</td>
				<td><img src="{{ Config::get('kblis.organization-logo') }}" alt="" height="90" width="90" style="float:right;"></td>
			</tr>
		</thead>
	</table>
	<div id="summary">
	<table class="table table-bordered">
		<tbody>
			<tr>
				<th colspan="3">Summary</th>
			</tr>
			<th>Total Patients Seen</th>
			<th>Male</th>
			<th>Female</th>
			<tr>
				<td>{{count($visits)}}</td>
				<td>
					{{--*/ $male = 0 /*--}}
					@forelse($visits as $visit)
					  @if($visit->patient->gender==Patient::MALE)
					   	{{--*/ $male++ /*--}}
					  @endif
					@endforeach
					{{$male}}
				</td>
				<td>{{count($visits)-$male}}</td>
			</tr>
		</tbody>
	</table>
	</div>
  	<table class="table table-bordered">
		<tbody>
			<th>{{trans('messages.patient-number')}}</th>
			<th>{{trans('messages.patient-name')}}</th>
			<th>{{trans('messages.age')}}</th>
			<th>{{trans('messages.gender')}}</th>
			<th>{{trans('messages.specimen-number-title')}}</th>
			<th>{{trans('messages.specimen-type-title')}}</th>
			<th>{{trans('messages.tests')}}</th>
			@forelse($visits as $visit)
			<tr>
				<td>{{ $visit->patient->id }}</td>
				<td>{{ $visit->patient->name }}</td>
				<td>{{ $visit->patient->getAge() }}</td>
				<td>@if($visit->patient->gender==0){{ 'M' }} @else {{ 'F' }} @endif</td>
				<td>@foreach($visit->tests as $test)
						<p>{{ $test->specimen->id }}</p>
					@endforeach
				</td>
				<td>@foreach($visit->tests as $test)
						<p>{{ $test->specimen->specimenType->name }}</p>
					@endforeach
				</td>
				<td>@foreach($visit->tests as $test)
						<p>{{ $test->testType->name }}</p>
					@endforeach
				</td>
			</tr>
			@empty
			<tr><td colspan="13">{{trans('messages.no-records-found')}}</td></tr>
			@endforelse
		</tbody>
	</table>
  </div>
</div>

</div>
	</div>

</div>
<script type="text/javascript">
	$(document).ready(function(){
		reportScripts();
	});
</script>
@stop