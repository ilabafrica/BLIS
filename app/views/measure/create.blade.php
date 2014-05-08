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
					{{ Form::label('type', 'Type') }}
					{{ Form::select('type', 
						array(''=>'','1'=>'Numeric Range','2'=>'Alphanumeric Values',  '3'=>'Autocomplete', '4'=>'Free Text',), 
						Input::old('type'), array('class' => 'form-control', 'id' => 'measuretype')) 
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
				<label for="measurerange">Value</label>				
					<div class="form-pane panel panel-default">
						<div class="panel-body">
							<div class="row measurerange" name="measurerange">
								<div class="col-md-12 measurevalue">
								</div>
							</div>
						</div>
						<div class="panel-footer">
							<a class="btn btn-sm btn-info addanother" href="javascript:void(0);" id="addmeasure" onclick="addmeasure()">
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

	<script type="text/javascript">
			/* load measure range input UI for the selected measure type */
		$( "#measuretype" ).change(function() {
			if ($(this).val() === '1') 
			{
				$( ".measurevalue" ).html(
					'<div class="col-md-12">'
						+'<div class="col-md-4">Age Range</div>'
						+'<div class="col-md-4">Gender</div>'
						+'<div class="col-md-4">Measure Range</div>'
					+'</div>'
					+'<div class="col-md-4">'
						+'<label for="agemin" class="hide">agemin</label>'						
						+'<input class="form-control input-small" name="agemin[]" type="text">'
						+'<label for="agemax" class="">:</label>'						
						+'<input class="form-control input-small" name="agemax[]" type="text">'						
					+'</div>'
					+'<div class="col-md-4">'
						+'<label for="gender" class="hide">gender</label>'						
						+'<select class="form-control input-small" name="gender[]">'
						+'<option value="1">M</option>'
						+'<option value="2">F</option>'
						+'<option value="3">B</option>'
						+'</select>'						
					+'</div>'
					+'<div class="col-md-4">'
						+'<label for="rangemin" class="hide">Min</label>'						
						+'<input class="form-control input-small" name="rangemin[]" type="text">'
						+'<label for="rangemax" class="">:</label>'						
						+'<input class="form-control input-small" name="rangemax[]" type="text">'						
					+'</div>'
					);
					$( ".addanother" ).show();
			}
			else if ($(this).val() === '2') 
			{
				$(".measurevalue").html(
					'<div class="col-md-4">'
						+'<label for="val" class="hide"></label>'						
						+'<input class="form-control input-small" name="val" type="text">/'
					+'</div>'
				);
				$( ".addanother" ).show();
			}
			else if ($(this).val() === '3') 
			{
				$(".measurevalue").html(
					'<div class="col-md-4">'
						+'<label for="val" class="hide"></label>'						
						+'<input class="form-control input-small" name="val" type="text">'
					+'</div>'
				);
				$( ".addanother" ).show();
			}
			else if ($(this).val() === '4') 
			{
				$(".measurevalue").html(
					'<p>A text box will appear for result entry</p>'
				);
				$( ".addanother" ).hide();
			}
		});
	</script>