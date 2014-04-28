@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="#">Home</a></li>
		  <li class="active">Test Category</li>
		</ol>
	</div>
	@if (Session::has('message'))
		<div class="alert alert-info">{{ Session::get('message') }}</div>
	@endif
	<div class="panel panel-primary patient-create">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			List Test Categories
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::to('test_category/create') }}">
					New Test Category
				</a>
			</div>
		</div>
		<div class="panel-body">
			<table class="table table-striped table-hover table-condensed">
				<thead>
					<tr>
						<th>Name</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody>
				@foreach($test as $key => $value)
					<tr>
						<td>{{ $value->name }}</td>
						<td>{{ $value->description }}</td>
						
						<td>

							<!-- show the patient (uses the show method found at GET /patient/{id} -->
							<a class="btn btn-sm btn-success" href="{{ URL::to('test_category/' . $value->id) }}">
								<span class="glyphicon glyphicon-user"></span>
								Show
							</a>

							<!-- edit this patient (uses the edit method found at GET /patient/{id}/edit -->
							<a class="btn btn-sm btn-info" href="{{ URL::to('test_category/' . $value->id . '/edit') }}">
								<span class="glyphicon glyphicon-edit"></span>
								Edit
							</a>
							<!-- delete this patient (uses the delete method found at GET /patient/{id}/delete -->
							<a class="btn btn-sm btn-danger" href="{{ URL::to('test_category/' . $value->id . '/delete') }}">
								<span class="glyphicon glyphicon-remove"></span>
								Delete
							</a>

						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop