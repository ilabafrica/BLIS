@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="active">{{trans('messages.patients')}}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{trans('messages.list-patients')}}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::route('patient.create') }}">
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{trans('messages.new-patient')}}
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>{{trans('messages.patient-number')}}</th>
					<th>{{trans('messages.name')}}</th>
					<th>{{trans('messages.email')}}</th>
					<th>{{trans('messages.gender')}}</th>
					<th>{{trans('messages.date-of-birth')}}</th>
					<th>{{trans('messages.actions')}}</th>
				</tr>
			</thead>
			<tbody>
			@foreach($patients as $key => $value)
				<tr  @if(Session::has('activepatient'))
                            {{(Session::get('activepatient') == $value->id)?"class='info'":""}}
                        @endif
                        >
					<td>{{ $value->patient_number }}</td>
					<td>{{ $value->name }}</td>
					<td>{{ $value->email }}</td>
					<td>{{ ($value->gender==0?trans('messages.male'):trans('messages.female')) }}</td>
					<td>{{ $value->dob }}</td>

					<td>

						<!-- show the patient (uses the show method found at GET /patient/{id} -->
						<a class="btn btn-sm btn-success" href="{{ URL::route('patient.show', array($value->id)) }}" >
							<span class="glyphicon glyphicon-eye-open"></span>
							{{trans('messages.view')}}
						</a>

						<!-- edit this patient (uses the edit method found at GET /patient/{id}/edit -->
						<a class="btn btn-sm btn-info" href="{{ URL::route('patient.edit', array($value->id)) }}" >
							<span class="glyphicon glyphicon-edit"></span>
							{{trans('messages.edit')}}
						</a>
						<!-- delete this patient (uses the delete method found at GET /patient/{id}/delete -->
						<button class="btn btn-sm btn-danger delete-item-link" 
							data-toggle="modal" data-target=".confirm-delete-modal"	
							data-id="{{ URL::route('patient.delete', array($value->id)) }}">
							<span class="glyphicon glyphicon-trash"></span>
							{{trans('messages.delete')}}
						</button>

					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<?php echo $patients->links(); 
		Session::put('SOURCE_URL', URL::full());?>
	</div>
</div>
@stop