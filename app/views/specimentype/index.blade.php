@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">Home</a></li>
	  <li class="active">Specimen Type</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		List Specimen Types
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::to("specimentype/create") }}" >
				<span class="glyphicon glyphicon-plus-sign"></span>
				New Specimen Type
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
			@foreach($specimentypes as $key => $value)
				<tr>
					<td>{{ $value->name }}</td>
					<td>{{ $value->description }}</td>

					<td>

					<!-- show the specimentype (uses the show method found at GET /specimentype/{id} -->
						<a class="btn btn-sm btn-success" href="{{ URL::to("specimentype/" . $value->id) }}" >
							<span class="glyphicon glyphicon-eye-open"></span>
							View
						</a>

					<!-- edit this specimentype (uses the edit method found at GET /specimentype/{id}/edit -->
						<a class="btn btn-sm btn-info" href="{{ URL::to("specimentype/" . $value->id . "/edit") }}" >
							<span class="glyphicon glyphicon-edit"></span>
							Edit
						</a>
					<!-- delete this specimentype (uses delete method found at GET /specimentype/{id}/delete -->
						<button class="btn btn-sm btn-danger delete-item-link" 
							data-toggle="modal" data-target=".confirm-delete-modal"	
							data-id='{{ URL::to("specimentype/" . $value->id . "/delete") }}'>
							<span class="glyphicon glyphicon-trash"></span>
							Delete
						</button>

					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<?php echo $specimentypes->links(); ?>
	</div>
</div>
@stop