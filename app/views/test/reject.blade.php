	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">Home</a></li>
		  <li><a href="{{ URL::route('test.index') }}">Test</a></li>
		  <li class="active">Reject Test</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			Reject Test
		</div>
		<div class="panel-body">
		<p class=""><strong>Patient ID</strong>{{ $patientId }}</p>
		<p class=""><strong>Patient Number</strong>{{ Patient::find($patientId)->patient_number }}</p>
		<p class=""><strong>Patient Name</strong>{{ Patient::find($patientId)->name }}</p>
		<p class=""><strong>Specimen Type</strong>{{ SpecimenType::find($specimenTypeId)->name }}</p>
		<p class=""><strong>Tests</strong>{{ Test::find($patientId)-> }}</p>
		<p class=""><strong>Reasons for Rejection</strong>{{ DROP DOWN }}</p>
		{{ Form::open(array('url' => 'testtype', 'id' => 'form-reject-specimen')) }}
			<div class="panel-body">
			<!-- if there are creation errors, they will show here -->
				<div class="form-group">
					{{ Form::label('rejectionReason', 'Rejection Reason') }}
					{{ Form::select('rejectionReason', $rejectionReason->lists('name', 'id'), Input::old('rejectionReason'), 
						array('class' => 'form-control')) }}
				</div>
				<!-- <div class="form-group">
					{{ Form::label('name', 'Person Talked To') }}
					{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
				</div> -->
				<div class="form-group actions-row">
					{{ Form::button(
						'<span class="glyphicon glyphicon-save"></span> Reject',
						[
							'class' => 'btn btn-danger', 
							'onclick' => 'formsubmit("form-reject-specimen")'
						] 
					) }}
				</div>
			</div>
		{{ Form::close() }}
		</div>
	</div>