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
				<h3><strong>Name:</strong>{{ $patient->name }} </h3>
				<p><strong>Patient Number:</strong>{{ $patient->patient_number }}</p>
				<p><strong>External Patient Number:</strong>{{ $patient->external_patient_number }}</p>
				<p><strong>Date of Birth:</strong>{{ $patient->dob }}</p>
				<p><strong>Gender:</strong>{{ ($patient->gender==0?"Male":"Female") }}</p>
				<p><strong>Physical Address:</strong>{{ $patient->address }}</p>
				<p><strong>Phone Number:</strong>{{ $patient->phone_number }}</p>
				<p><strong>Email Address:</strong>{{ $patient->email }}</p>
				<p><strong>Date Created:</strong>{{ $patient->created_at }}</p>
			</div>
		</div>
	</div>
