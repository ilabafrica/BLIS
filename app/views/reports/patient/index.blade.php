@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ trans('messages.reports') }}</li>
	</ol>
</div>
{{ Form::open(array('route' => array('reports.patient.index'), 'class'=>'form-inline', 'method'=>'POST')) }}
  <table class="table">
    <thead>
	    <tr>
	    	<td>
	    		<div class="form-group">
	                <label for="search" class="sr-only">search</label>
	                <input class="form-control test-search" placeholder="{{trans('messages.search')}}" 
	                value="{{isset($search) ? $search : ''}}" name="search" type="text" id="search">
	            </div>
	    	</td>
	        <td>{{ Form::label('name', trans("messages.from")) }}</td>
        	<td>{{ Form::text('start', Input::old('start'), array('class' => 'form-control', 'id' => 'start')) }}</td>
	        <td>{{ Form::label('name', trans("messages.to")) }}</td>
        	<td>{{ Form::text('end', Input::old('end'), array('class' => 'form-control', 'id' => 'end')) }}</td>
	        <td>{{ Form::button("<span class='glyphicon glyphicon-search'></span> ".trans('messages.search'), 
	                        array('class' => 'btn btn-primary', 'id' => 'filter', 'type' => 'submit')) }}</td>
	    </tr>
	</thead>
  </table>
  {{ Form::close() }}
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.patient-report') }}
	</div>
	<div class="panel-body">

	    @if (Session::has('message'))
			<div class="alert alert-danger">{{ trans(Session::get('message')) }}</div>
		@endif
	    <table class="table table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>{{trans('messages.patient-number')}}</th>
					<th>{{trans('messages.visit-number')}}</th>
					<th>{{trans('messages.gender')}}</th>
					<th>{{trans('messages.date-of-birth')}}</th>
					<th>{{trans('messages.actions')}}</th>
				</tr>
			</thead>
			<tbody>
			@forelse($patients as $key => $value)
				<tr>
					<td>{{ $value->patient_number }}</td>
					<td>{{ $value->external_patient_number }}</td>
					<td>{{ ($value->gender==Patient::MALE?trans('messages.male'):trans('messages.female')) }}</td>
					<td>{{ $value->dob }}</td>

					<td>
					<!-- show the patient report(uses the show method found at GET /patient/{id} -->
						<a class="btn btn-sm btn-info" href="{{ URL::to('patientreport/' . $value->id) }}" >
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
<script type="text/javascript">
	$(document).ready(function(){
		reports();
	});
</script>
@stop