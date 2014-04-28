@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="#">Home</a></li>
		  <li><a href="{{ URL::to('test_category') }}">Test Category</a></li>
		  <li class="active">Patient Details</li>
		</ol>
	</div>
	<div class="panel panel-primary patient-create">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			Patient Details
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::to('test_category/'. $test_category->id .'/edit') }}">
					<span class="glyphicon glyphicon-edit"></span>
					Edit
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3><strong>Name:</strong>{{ $test_category->name }} </h3>
				<p><strong>Description:</strong>{{ $test_category->description }}</p>
				
			</div>
		</div>
	</div>
@stop