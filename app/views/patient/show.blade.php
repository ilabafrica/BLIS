	<div>
		<ol class="breadcrumb">
		  <li><a href="#">Home</a></li>
		  <li><a href="javascript:void(0);" onclick="pageloader('{{ URL::to('patient') }}')">Patient</a></li>
		  <li class="active">Patient Details</li>
		</ol>
	</div>
	<div class="panel panel-primary patient-create">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			Patient Details
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="javascript:void(0);" onclick="pageloader('{{ URL::to('patient/'. $patient->id .'/edit') }}')">
					<span class="glyphicon glyphicon-edit"></span>
					Edit
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3 class="view"><strong>Name:</strong>{{ $patient->name }} </h3>
				<p class="view-striped"><strong>Patient Number:</strong>{{ $patient->patient_number }}</p>
				<p class="view"><strong>External Patient Number:</strong>{{ $patient->external_patient_number }}</p>
				<p class="view-striped"><strong>Date of Birth:</strong>{{ $patient->dob }}</p>
				<p class="view"><strong>Gender:</strong>{{ ($patient->gender==0?"Male":"Female") }}</p>
				<p class="view-striped"><strong>Physical Address:</strong>{{ $patient->address }}</p>
				<p class="view"><strong>Phone Number:</strong>{{ $patient->phone_number }}</p>
				<p class="view-striped"><strong>Email Address:</strong>{{ $patient->email }}</p>
				<p class="view"><strong>Date Created:</strong>{{ $patient->created_at }}</p>
			</div>
		</div>
	</div>
