<div>
	<ol class="breadcrumb">
	  <li><a href="#">Home</a></li>
	  <li class="active">Test Type</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		List Test Types
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="javascript:void(0);" 
				onclick="pageloader('{{ URL::to("testtype/create") }}')">
				<span class="glyphicon glyphicon-plus-sign"></span>
				New Test Type
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
			@foreach($testtypes as $key => $value)
				<tr>
					<td>{{ $value->name }}</td>
					<td>{{ $value->description }}</td>

					<td>

						<!-- show the testtype (uses the show method found at GET /testtype/{id} -->
						<a class="btn btn-sm btn-success" href="javascript:void(0);" 
							onclick="pageloader('{{ URL::to("testtype/" . $value->id) }}')">
							<span class="glyphicon glyphicon-eye-open"></span>
							View
						</a>

						<!-- edit this testtype (uses the edit method found at GET /testtype/{id}/edit -->
						<a class="btn btn-sm btn-info" href="javascript:void(0);" 
							onclick="pageloader('{{ URL::to("testtype/" . $value->id . "/edit") }}')">
							<span class="glyphicon glyphicon-edit"></span>
							Edit
						</a>
						<!-- delete this testtype (uses the delete method found at GET /testtype/{id}/delete -->
						<a class="btn btn-sm btn-danger delete-item-link" href="javascript:void(0);" 
							data-toggle="modal" data-target=".confirm-delete-modal"	
							data-id='{{ URL::to("testtype/" . $value->id . "/delete") }}'>
							<span class="glyphicon glyphicon-trash"></span>
							Delete
						</a>

					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<?php echo $testtypes->links(); ?>
	</div>
</div>
