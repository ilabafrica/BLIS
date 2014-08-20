@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">Home</a></li>
		  <li><a href="{{ URL::route('test.index') }}">Test</a></li>
		  <li class="active">Test Details</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-cog"></span>
			Test Details
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::to("#") }}">
					<span class="glyphicon glyphicon-edit"></span>
					Edit
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3 class="view"><strong>Type</strong>Whole Blood</h3>
				<p class="view-striped"><strong>Specimen Number</strong>PAR-773</p>
				<p class="view"><strong>Lab No.</strong>20140707-6</p>
				<p class="view-striped"><strong>Patient</strong>booh</p>
				<p class="view"><strong>Lab Receipt Date</strong>07-07-2014</p>
				<p class="view-striped"><strong>Registered By</strong>superadmin</p>
				<p class="view"><strong>Tests</strong>BS for mps</p>
				<p class="view-striped"><strong>Physician</strong>-</p>
				<p class="view"><strong>Results</strong>Positive</p>
				<p class="view-striped"><strong>Remarks</strong>gosh!!</p>
				<p class="view"><strong>Entered By</strong>superadmin</p>
				<p class="view-striped"><strong>Turnaround time</strong>4 d 21 hrs 23 min</p>
				<p class="view"><strong>Verified By</strong>Verification Pending</p>
			</div>
		</div>
	</div>
@stop