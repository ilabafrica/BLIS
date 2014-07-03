	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">Home</a></li>
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
					{{ Form::label('measure_type_id', 'Type') }}
					{{ Form::select('measure_type_id', $measuretype, 
						Input::old('measure_type_id'), array('class' => 'form-control', 'id' => 'measuretype')) 
					}}
				</div>
				<div class="form-group">
					{{ Form::label('unit', 'Unit') }}
					{{ Form::text('unit', Input::old('unit'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('description', 'Description') }}
					{{ Form::textarea('description', Input::old('description'), array('class' => 'form-control', 'rows'=>'2')) }}
				</div>
				<div class="form-group">
					<label for="measurerange">Measure Value</label>				
					<div class="form-pane ">
						<div class="">
							<div class="row measurerange" name="measurerange">
								<div class="col-md-12 measurevalue"></div>
							</div>
						</div>
						<div class="">
							<a class="btn btn-sm btn-info add-another-measure" href="javascript:void(0);">
								<span class="glyphicon glyphicon-plus-sign"></span>
								Add another
							</a>
						</div>
					</div>
				</div>
				<div class="form-group actions-row">
					{{ Form::button('<span class="glyphicon glyphicon-save"></span> Save', array('class' => 'btn btn-primary', 'onclick' => 'formsubmit("form-create-measure")')) }}
				</div>
			{{ Form::close() }}
		</div>
	</div>