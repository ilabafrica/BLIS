@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="#">Home</a></li>
		  <li><a href="{{ URL::to('testcategory') }}">Test Category</a></li>
		  <li class="active">Test Category Details</li>
		</ol>
	</div>
	<div class="panel panel-primary patient-create">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			Test Category Details
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::to('testcategory/'. $testcategory->id .'/edit') }}">
					<span class="glyphicon glyphicon-edit"></span>
					Edit
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3><strong>Name:</strong>{{ $testcategory->name }} </h3>
				<p><strong>Description:</strong>{{ $testcategory->description }}</p>
				
			</div>
		</div>
	</div>
@stop