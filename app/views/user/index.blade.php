@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">Home</a></li>
	  <li class="active">User</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		List Users
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="javascript:void(0);" 
				onclick="pageloader('{{ URL::to("user/create") }}')">
				<span class="glyphicon glyphicon-plus-sign"></span>
				New User
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>User Name</th>
					<th>Name</th>
					<th>Email</th>
					<th>Gender</th>
					<th>Designation</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			@foreach($users as $key => $value)
				<tr>
					<td>{{ $value->username }}</td>
					<td>{{ $value->name }}</td>
					<td>{{ $value->email }}</td>
					<td>{{ ($value->gender==0?"Male":"Female") }}</td>
					<td>{{ $value->designation }}</td>

					<td>

						<!-- show the user (uses the show method found at GET /user/{id} -->
						<a class="btn btn-sm btn-success" href="javascript:void(0);" 
							onclick="pageloader('{{ URL::to("user/" . $value->id) }}')">
							<span class="glyphicon glyphicon-eye-open"></span>
							View
						</a>

						<!-- edit this user (uses the edit method found at GET /user/{id}/edit -->
						<a class="btn btn-sm btn-info" href="javascript:void(0);" 
							onclick="pageloader('{{ URL::to("user/" . $value->id . "/edit") }}')">
							<span class="glyphicon glyphicon-edit"></span>
							Edit
						</a>
						<!-- delete this user (uses the delete method found at GET /user/{id}/delete -->
						<a class="btn btn-sm btn-danger delete-item-link" href="javascript:void(0);" 
							data-toggle="modal" data-target=".confirm-delete-modal"	
							data-id='{{ URL::to("user/" . $value->id . "/delete") }}'>
							<span class="glyphicon glyphicon-trash"></span>
							Delete
						</a>

					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<?php echo $users->links(); ?>
	</div>
</div>
@stop