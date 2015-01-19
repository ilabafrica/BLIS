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
@include("reportHeader")
<div id="content">
	<strong>
		<p>
			{{trans('messages.daily-visits')}} @if($from!=$to)
				{{'From '.$from.' To '.$to}}
			@else
				{{'For '.date('d-m-Y')}}
			@endif
		</p>
	</strong>
	<br>
	<table class="table table-bordered"  width="100%">
		<tbody align="left">
			<tr>
				<th colspan="3">{{trans('messages.summary')}}</th>
			</tr>
			<th>{{trans('messages.total-visits')}}</th>
			<th>{{trans('messages.male')}}</th>
			<th>{{trans('messages.female')}}</th>
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
				<td>{{ $visit->patient->getGender()}}</td>
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