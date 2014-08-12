@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">Home</a></li>
		  <li class="active">Test</li>
		</ol>
	</div>
	@if (Session::has('message'))
		<div class="alert alert-info">{{ Session::get('message') }}</div>
	@endif
	<div class="panel panel-primary test-create">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			List Tests
			<div class="panel-btn">
				
			</div>
		</div>
		<div class="panel-body">
			<table class="table table-striped table-hover table-condensed">
				<thead>
					<tr>
						<th>Specimen ID</th>
						<th>Date Ordered</th>
						<th>Patient No</th>
						<th>Visit No</th>
						<th>Patient Name</th>
						<th>Specimen Type</th>
						<th>Test</th>
						<th>Order Stage</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
				@foreach($tests as $key => $value)
					<tr>
						<?php $patient_id = Visit::find($value->visit_id)->patient_id; ?>
						<?php $specimen_type_id = Specimen::find($value->specimen_id)->specimen_type_id; ?>
						<td>{{ $value->specimen_id }}</td><!--Specimen ID-->
						<td>{{ $value->time_created }}</td><!--Date Ordered-->
						<td>{{ $patient_id }}</td><!--Patient No-->
						<td>{{ $value->visit_id }}</td><!--Visit No-->
						<td>{{ Patient::find($patient_id)->name }}</td><!--Patient Name-->
						<td>{{ SpecimenType::find($specimen_type_id)->name }}</td><!--Specimen Type-->
						<td>{{ TestType::find($value->test_type_id)->name }}</td><!--Test-->
						<td>{{ $value->visit_id }}</td><!--Order Stage|???????from the test?????-->
						<td>{{ TestStatus::find($value->test_status_id)->name }}</td><!--Status-->
		
						<td>
							<a class="btn btn-sm btn-danger new-item-link" href="javascript:void(0)"
								onclick="pageloader('{{ URL::to('test/reject') }}')">
								<span class="glyphicon glyphicon-thumbs-down"></span>
								Reject
							</a>
							<a class="btn btn-sm btn-info new-item-link" href="javascript:void(0)"
								onclick="pageloader('{{ URL::to('test/enterResults') }}')">
								<span class="glyphicon glyphicon-pencil"></span>
								Enter Results
							</a>
							<a class="btn btn-sm btn-success new-item-link" href="javascript:void(0)"
								onclick="pageloader('{{ URL::to('test/viewDetails') }}')">
								<span class="glyphicon glyphicon-eye-open"></span>
								View Details
							</a>
							<a class="btn btn-sm btn-info new-item-link" href="javascript:void(0)"
								onclick="pageloader('{{ URL::to('test/viewDetails') }}')">
								<span class="glyphicon glyphicon-edit"></span>
								Edit
							</a>
							<a class="btn btn-sm btn-success new-item-link" href="javascript:void(0)"
								onclick="pageloader('{{ URL::to('test/viewDetails') }}')">
								<span class="glyphicon glyphicon-thumbs-up"></span>
								Verify
							</a>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			<?php echo $tests->links(); ?>
		</div>
	</div>
@stop