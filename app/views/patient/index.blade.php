@extends("layout")
@section("content")
	<div class="panel panel-primary patient-create">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			List Patients
		</div>
		<div class="panel-body">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<td>Patient Number</td>
						<td>Name</td>
						<td>Email</td>
						<td>Date of Birth</td>
						<td>Actions</td>
					</tr>
				</thead>
				<tbody>
				@foreach($patients as $key => $value)
					<tr>
						<td>{{ $value->patient_number }}</td>
						<td>{{ $value->name }}</td>
						<td>{{ $value->email }}</td>
						<td>{{ $value->dob }}</td>

						<!-- we will also add show, edit, and delete buttons -->
						<td>

							<!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
							<!-- we will add this later since its a little more complicated than the other two buttons -->

							<!-- show the nerd (uses the show method found at GET /nerds/{id} -->
							<a class="btn btn-small btn-success" href="{{ URL::to('patient/' . $value->id) }}">Show this Nerd</a>

							<!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
							<a class="btn btn-small btn-info" href="{{ URL::to('patient/' . $value->id . '/edit') }}">Edit this Nerd</a>

						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop