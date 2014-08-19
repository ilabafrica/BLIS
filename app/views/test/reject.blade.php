	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">Home</a></li>
		  <li><a href="{{ URL::route('test.index') }}">Test</a></li>
		  <li class="active">Reject Specimen</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			Reject Specimen
		</div>
		<div class="panel-body">
		{{ Form::open(array('url' => 'test/'.$specimenId.'/rejectAction', 'method' => 'GET', 'id' => 'form-reject-specimen')) }}
			<div class="panel-body">
				<div class="form-group">
					{{ Form::label('rejectionReason', 'Rejection Reason') }}
					{{ Form::select('rejectionReason', $rejectionReason->lists('reason', 'id'), Input::old('rejectionReason'), 
						array('class' => 'form-control')) }}
				</div>
				<div class="form-group actions-row">
					{{ Form::submit('Reject',['class' => 'btn btn-danger',]) }}
				</div>
			</div>
		{{ Form::close() }}
		</div>
	</div>