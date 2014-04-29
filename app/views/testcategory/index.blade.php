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
				<a class="btn btn-sm btn-info" href="javascript:void(0);" onclick="pageloader('{{ URL::to("testcategory/create") }}')">
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
				@foreach($testcategory as $key => $value)
					<tr>
						<td>{{ $value->name }}</td>
						<td>{{ $value->description }}</td>
						
						<td>

							<!-- show the test category (uses the show method found at GET /testcategory/{id} -->
							<a class="btn btn-sm btn-success" href="javascript:void(0);" onclick="pageloader('{{ URL::to("testcategory/" . $value->id) }}')">
								<span class="glyphicon glyphicon-user"></span>
								Show
							</a>

							<!-- edit this test category (uses the edit method found at GET /testcategory/{id}/edit -->
							<a class="btn btn-sm btn-info" href="javascript:void(0);" onclick="pageloader('{{ URL::to("testcategory/" . $value->id . "/edit") }}')">
								<span class="glyphicon glyphicon-edit"></span>
								Edit
							</a>
							<!-- delete this test category (uses the delete method found at GET /testcategory/{id}/delete -->
							<a class="btn btn-sm btn-danger" href="javascript:void(0);" onclick="pageloader('{{ URL::to("testcategory/" . $value->id . "/delete") }}')">
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