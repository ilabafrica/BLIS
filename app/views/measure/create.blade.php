	<div>
		<ol class="breadcrumb">
		  <li><a href="#">Home</a></li>
		  <li><a href="javascript:void(0);" onclick="pageloader('{{ URL::to('measure') }}')">Measure</a></li>
		  <li class="active">Create Measure</li>
		</ol>
	</div>
	<div class="panel panel-primary patient-create">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			Create Measure
		</div>
		<div class="panel-body">
		<!-- if there are creation errors, they will show here -->
			
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif

			{{ Form::open(array('url' => 'measure', 'id' => 'form-create-measure')) }}
				<div class="form-group">
					{{ Form::label('name', 'Name') }}
					{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('measure_range', 'Measure Range') }}
					{{ Form::text('measure_range', Input::old('measure_range'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('unit', 'Unit') }}
					{{ Form::text('unit', Input::old('unit'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('description', 'Description') }}
					{{ Form::textarea('description', Input::old('description'), array('class' => 'form-control', 'rows'=>'2')) }}
				</div>
				<label for="measurerange" >Measure Range</label>
				<div class="row measurerange" name="measurerange">
					<div class="col-md-4"><strong>Type</strong></div>
					<div class="col-md-8"><strong>Values</strong></div>
					<div class="col-md-4">
						{{ Form::label('type', 'Type', array('class'=>'hide')) }}
						{{ Form::select('type', 
							array('1'=>'Alphanumeric Values', '2'=>'Numeric Range', '3'=>'Autocomplete', '4'=>'Free Text',), 
							Input::old('type'), array('class' => 'form-control')) 
						}}
					</div>
					<div class="col-md-8">
						<div class="col-md-4">
						{{ Form::label('agemin', 'agemin', array('class'=>'hide')) }}
										{{ Form::text('agemin', Input::old('agemin'), array('class' => 'form-control input-small')) }}
										{{ Form::label('agemax', ':', array('class'=>'')) }}
										{{ Form::text('agemax', Input::old('agemax'), array('class' => 'form-control input-small')) }}
									
						</div>
						<div class="col-md-4">
						{{ Form::label('gender', 'gender', array('class'=>'hide')) }}
										{{ Form::select('gender', array('1'=>'M', '2'=>'F', '3'=>'Both'), Input::old('gender'), array('class' => 'form-control input-small','style'=>'width: 90px')) }}
									
						</div>
						<div class="col-md-4">
						{{ Form::label('rangemin', 'Min', array('class'=>'hide')) }}
										{{ Form::text('rangemin', Input::old('rangemin'), array('class' => 'form-control input-small')) }}
										{{ Form::label('rangemax', ':', array('class'=>'')) }}
										{{ Form::text('rangemax', Input::old('rangemax'), array('class' => 'form-control input-small')) }}
									
						</div>
						<div class="col-md-4">Age Range</div>
						<div class="col-md-4">Gender</div>
						<div class="col-md-4">Measure Range</div>
					</div>
				</div>
				<div class="form-group actions-row">
					{{ Form::button('<span class="glyphicon glyphicon-save"></span> Save', array('class' => 'btn btn-primary', 'onclick' => 'formsubmit("form-create-measure")')) }}
				</div>

			{{ Form::close() }}
		</div>
	</div>