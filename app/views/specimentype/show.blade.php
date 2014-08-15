@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">Home</a></li>
		  <li><a href="{{ URL::route('specimentype.index') }}">Specimen Type</a></li>
		  <li class="active">Specimen Type Details</li>
		</ol>
	</div>
	<div class="panel panel-primary specimentype-create">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			Specimen Type Details
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::to("specimentype/". $specimentype->id ."/edit") }}">
					<span class="glyphicon glyphicon-edit"></span>
					Edit
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3 class="view"><strong>Name:</strong>{{ $specimentype->name }} </h3>
				<p class="view-striped"><strong>Description:</strong>{{ $specimentype->description }}</p>
				<p class="view"><strong>Date Created:</strong>{{ $specimentype->created_at }}</p>
			</div>
		</div>
	</div>
@stop