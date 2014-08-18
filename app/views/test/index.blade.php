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
						<?php 
							$patientId = Visit::find($value->visit_id)->patient_id; 
							$specimen_type_id = Specimen::find($value->specimen_id)->specimen_type_id; 
							$specimenTypeName = SpecimenType::find($specimen_type_id)->name;
							$patientNumber = Patient::find($patientId)->patient_number;
							$testTypeName = TestType::find($value->test_type_id)->name;
							$patientName = Patient::find($patientId)->name;
						 ?>
						<td>{{ $value->specimen_id }}</td><!--Specimen ID-->
						<td>{{ $value->time_created }}</td><!--Date Ordered-->
						<td>{{ $patientNumber }}</td><!--Patient No-->
						<td>{{ $value->visit_id }}</td><!--Visit No-->
						<td>{{ $patientName }}</td><!--Patient Name-->
						<td>{{ $specimenTypeName }}</td><!--Specimen Type-->
						<td>{{ $testTypeName }}</td><!--Test-->
						<td>{{ $value->visit_id }}</td><!--Order Stage|Need OrderStage Resource-->
						<!--Status-->
						@if (Specimen::find($value->specimen_id)->specimen_status_id == 2)<!-- Rejected -->
						<td>{{ SpecimenStatus::find(2)->name }}</td><!-- Rejected -->
						<td>
							<a class="btn btn-sm btn-success new-item-link" href="javascript:void(0)"
								onclick="pageloader('{{ URL::to('test/viewDetails') }}')">
								<span class="glyphicon glyphicon-eye-open"></span>
								View Details
							</a>
						</td>
						@elseif ($value->test_status_id == 1)<!-- Pending -->
						<td>{{ TestStatus::find($value->test_status_id)->name }}</td>
						<td>
							<a class="btn btn-sm btn-danger new-item-link" href="javascript:void(0)"
								onclick="pageloader('{{ URL::to('test/'.$value->specimen_id.'/reject') }}')">
								<span class="glyphicon glyphicon-thumbs-down"></span>
								Reject
							</a>
							<a class="btn btn-sm btn-success new-item-link" href="{{ URL::to('test/'.$value->id.'/start') }}"
								<span class="glyphicon glyphicon-eye-open"></span>
								Start Test
							</a>	
							<a class="btn btn-sm btn-success new-item-link" href="javascript:void(0)"
								onclick="pageloader('{{ URL::to('test/viewDetails') }}')">
								<span class="glyphicon glyphicon-eye-open"></span>
								View Details
							</a>
						</td>
						@elseif ($value->test_status_id == 2)<!-- Started -->
						<td>{{ TestStatus::find($value->test_status_id)->name }}</td>
						<td>
							<a class="btn btn-sm btn-info new-item-link" href="javascript:void(0)"
								onclick="pageloader('{{ URL::to('test/'.$value->id.'/enterResults') }}')">
								<span class="glyphicon glyphicon-pencil"></span>
								Enter Results
							</a>
							<a class="btn btn-sm btn-danger new-item-link" href="javascript:void(0)"
								onclick="pageloader('{{ URL::to('test/'.$value->specimen_id.'/reject') }}')">
								<span class="glyphicon glyphicon-thumbs-down"></span>
								Reject
							</a>
							<a class="btn btn-sm btn-success new-item-link" href="javascript:void(0)"
								onclick="pageloader('{{ URL::to('test/viewDetails') }}')">
								<span class="glyphicon glyphicon-eye-open"></span>
								View Details
							</a>
						</td>
						@elseif ($value->test_status_id == 3)<!-- Completed -->
						<td>{{ TestStatus::find($value->test_status_id)->name }}</td>
						<td>
							<a class="btn btn-sm btn-success new-item-link" href="javascript:void(0)"
								onclick="pageloader('{{ URL::to('test/viewDetails') }}')">
								<span class="glyphicon glyphicon-thumbs-up"></span>
								Verify
							</a>
							<a class="btn btn-sm btn-info new-item-link" href="javascript:void(0)"
								onclick="pageloader('{{ URL::to('test/edit') }}')">
								<span class="glyphicon glyphicon-edit"></span>
								Edit
							</a>
							<a class="btn btn-sm btn-danger new-item-link" href="javascript:void(0)"
								onclick="pageloader('{{ URL::to('test/'.$value->specimen_id.'/reject') }}')">
								<span class="glyphicon glyphicon-thumbs-down"></span>
								Reject
							</a>
							<a class="btn btn-sm btn-success new-item-link" href="javascript:void(0)"
								onclick="pageloader('{{ URL::to('test/viewDetails') }}')">
								<span class="glyphicon glyphicon-eye-open"></span>
								View Details
							</a>
						</td>
						@else<!-- Verified -->
						<td>{{ TestStatus::find($value->test_status_id)->name }}</td>
						<td>
							<a class="btn btn-sm btn-success new-item-link" href="javascript:void(0)"
								onclick="pageloader('{{ URL::to('test/viewDetails') }}')">
								<span class="glyphicon glyphicon-eye-open"></span>
								View Details
							</a>
						</td>
						@endif
					</tr>
				@endforeach
				</tbody>
			</table>
			<?php echo $tests->links(); ?>
		</div>
	</div>
@stop