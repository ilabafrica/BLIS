	<div>
		<ol class="breadcrumb">
		  <li><a href="#">Home</a></li>
		  <li><a href="javascript:void(0);" onclick="pageloader('{{ URL::to("testcategory") }}')">Lab Section</a></li>
		  <li class="active">Lab Section Details</li>
		</ol>
	</div>
	<div class="panel panel-primary ">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			Lab Section Details
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="javascript:void(0);"
					onclick="pageloader('{{ URL::to("testcategory/" . $testcategory->id . "/edit") }}')">
					<span class="glyphicon glyphicon-edit"></span>
					Edit
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3 class="view"><strong>Name:</strong>{{ $testcategory->name }} </h3>
				<p class="view-striped"><strong>Description:</strong>{{ $testcategory->description }}</p>
				
			</div>
		</div>
	</div>
