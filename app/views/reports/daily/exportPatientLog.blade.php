<html>
<head>
{{ HTML::style('css/bootstrap.min.css') }}
{{ HTML::style('css/bootstrap-theme.min.css') }}
<style type="text/css">
	#content table, #content th, #content td {
   border: 1px solid black;
}
</style>
</head>
<body>
<div id="content">
<table width="100%">
		<thead>
			<tr>
				<td>{{ HTML::image('i/org_logo_90x90.png', 'Kenya Court of Arms', array('width' => '90px')) }}</td>
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
				<td>{{ HTML::image('i/org_logo_90x90.png', 'Kenya Court of Arms', array('width' => '90px')) }}</td>td>
			</tr>
		</thead>
	</table>
	<br>
	<table class="table table-bordered"  width="100%">
		<tbody align="left">
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
	<br>
  	<table class="table table-bordered"  width="100%">
		<tbody align="left">
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
			<tr><td colspan="7">{{trans('messages.no-records-found')}}</td></tr>
			@endforelse
		</tbody>
	</table>
</div>
</body>
</html>