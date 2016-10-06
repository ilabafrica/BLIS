@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		  <li class="active">{{ Lang::choice('messages.report', 2) }}</li>
		</ol>
	</div>
	{{ Form::open(array('route' => array('reports.patient.index'), 'class'=>'form-inline', 'role'=>'form', 'method'=>'POST')) }}
		<div class="form-group">

		    {{ Form::label('search', "search", array('class' => 'sr-only')) }}
            {{ Form::text('search', Input::get('search'), array('class' => 'form-control test-search')) }}
		</div>
		<div class="form-group">
			{{ Form::button("<span class='glyphicon glyphicon-search'></span> ".trans('messages.search'), 
		        array('class' => 'btn btn-primary', 'id' => 'filter', 'type' => 'submit')) }}
		</div>
	{{ Form::close() }}
	<br>
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.patient-report') }}
	</div>
	<div class="panel-body">

	    @if(Session::has('message'))
			<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
		@endif
	    <table class="table table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>{{ trans('messages.patient-id') }}</th>
					<th>{{trans('messages.patient-number')}}</th>
					@if(Entrust::can('view_names'))
						<th>{{trans('messages.full-name')}}</th>
					@endif
					<th>{{trans('messages.gender')}}</th>
					<th>{{trans('messages.age')}}</th>
					<th>{{trans('messages.actions')}}</th>
				</tr>
			</thead>
			<tbody>
			@forelse($patients as $key => $patient)
				<tr>
					<td>{{ $patient->id }}</td>
					<td>{{ $patient->patient_number }}</td>
					@if(Entrust::can('view_names'))
						<td>{{ $patient->name }}</td>
					@endif
					<td>{{ $patient->getGender() }}</td>
					<td>{{ $patient->getAge() }}</td>
					<td>
					<!-- show the patient report(uses the show method found at GET /patient/{id} -->
						<a class="btn btn-sm btn-info" href="{{ URL::to('patientreport/' . $patient->id) }}" >
							<span class="glyphicon glyphicon-eye-open"></span>
							{{trans('messages.view-report')}}
						</a>
					</td>
				</tr>
			@empty
				<tr>
					<td colspan="5">{{trans('messages.no-records-found')}}</td>
				</tr>
			@endforelse
			</tbody>
		</table>
		{{$patients->links()}}
	</div>

</div>
@stop