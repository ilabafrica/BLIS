@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="#">Home</a></li>
		  <li class="active">Measure</li>
		</ol>
	</div>
	@if (Session::has('message'))
		<div class="alert alert-info">{{ Session::get('message') }}</div>
	@endif
	<div class="panel panel-primary patient-create">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			List Measures
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::to('measure/create') }}">
					<span class="glyphicon glyphicon-plus-sign"></span>
					New Measure
				</a>
			</div>
		</div>
		<div class="panel-body">
			<table class="table table-striped table-hover table-condensed">
				<thead>
					<tr>
						<th>Name</th>
						<th>Measure Range</th>
						<th>Unit</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody>
				@foreach($measures as $key => $value)
					<tr>
						<td>{{ $value->name }}</td>
						<td>{{ $value->measure_range }}</td>
						<td>{{ $value->unit }}</td>
						<td>{{ $value->description }}</td>
						<td>
							<!-- show the measure (uses the show method found at GET /measure/{id} -->
							<a class="btn btn-sm btn-success" href="{{ URL::to('measure/' . $value->id) }}">
								<span class="glyphicon glyphicon-eye-open"></span>
								View
							</a>

							<!-- edit this measure (uses the edit method found at GET /measure/{id}/edit -->
							<a class="btn btn-sm btn-info" href="{{ URL::to('measure/' . $value->id . '/edit') }}">
								<span class="glyphicon glyphicon-edit"></span>
								Edit
							</a>
							<!-- delete this measure (uses the delete method found at GET /measure/{id}/delete -->
							<a class="btn btn-sm btn-danger delete-item-link" href="javascript:void(0);" 
								data-toggle="modal" data-target=".confirm-delete-modal"	
								data-id='{{ URL::to("measure/" . $value->id . "/delete") }}'>
								<span class="glyphicon glyphicon-trash"></span>
								Delete
							</a>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			<?php echo $measures->links(); ?>
		</div>
	</div>
@stop