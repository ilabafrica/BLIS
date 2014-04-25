@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="#">Home</a></li>
		  <li><a href="{{ URL::to('user') }}">User</a></li>
		  <li class="active">User Details</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			User Details
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::to('user/'. $user->id .'/edit') }}">
					<span class="glyphicon glyphicon-edit"></span>
					Edit
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6">
						<div class="display-details">
							<h3><strong>Full Name:</strong>{{ $user->name }} </h3>
							<p><strong>Username:</strong>{{ $user->username }}</p>
							<p><strong>Email Address:</strong>{{ $user->email }}</p>
							<p><strong>Designation:</strong>{{ $user->designation }}</p>
							<p><strong>Gender:</strong>{{ ($user->gender==0?"Male":"Female") }}</p>
							<p><strong>Date Created:</strong>{{ $user->created_at }}</p>
						</div>
					</div>
					<div class="col-md-6">
						<img class="img-responsive img-thumbnail" src="{{ $user->image }}" alt="No photo available"></img>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop