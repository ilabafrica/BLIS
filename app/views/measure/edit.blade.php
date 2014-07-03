	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">Home</a></li>
		  <li><a href="javascript:void(0);" onclick="pageloader('{{ URL::to('measure') }}')">Measure</a></li>
		  <li class="active">Edit Measure</li>
		</ol>
	</div>
	<div class="panel panel-primary patient-create">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-edit"></span>
			Edit Measure Details
		</div>
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
			{{ Form::model($measure, array('route' => array('measure.update', $measure->id), 'method' => 'PUT', 'id' => 'form-edit-measure')) }}

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
				<label for="measurerange">Value</label>				
					<div class="form-pane panel panel-default">
						<div class="panel-body">
							<div class="row measurerange" name="measurerange">
								<div class="col-md-12 measurevalue">
								<?php if ($measure->measure_type_id == 1) { ?>
									<div class="col-md-12">
										<div class="col-md-4">Age Range</div>
										<div class="col-md-4">Gender</div>
										<div class="col-md-4">Measure Range</div>
									</div>
									@foreach($measurerange as $key=>$value)
									<input class="hide" value="<?php echo $value->id;?>" name="measurerangeid[]" type="text">
									<div class="col-md-4">
										<label for="agemin" class="hide">agemin</label>						
										<input class="form-control input-small" value="<?php echo $value->age_min; ?>" name="agemin[]" type="text">
										<label for="agemax" class="">:</label>						
										<input class="form-control input-small" value="<?php echo $value->age_max; ?>" name="agemax[]" type="text">						
									</div>
									<div class="col-md-4">
										<label for="gender" class="hide">gender</label>						
										<select class="form-control input-small" name="gender[]">
										<?php $gender = ['1'=>'Male', '2'=>'Female', '3'=>'Both']; ?>
										 <?php for ($i=1; $i<4; $i++) { ?>
										<option value="<?php echo $i; ?>" <?php if ($value->sex == $i) {?>selected="selected"<?php } ?>><?php echo $gender[$i]; ?></option>
										 <?php }?>
										</select>						
									</div>
									<div class="col-md-4">
										<label for="rangemin" class="hide">Min</label>						
										<input class="form-control input-small" value="<?php echo $value->range_lower; ?>" name="rangemin[]" type="text">
										<label for="rangemax" class="">:</label>					
										<input class="form-control input-small" value="<?php echo $value->range_upper; ?>" name="rangemax[]" type="text">						
									</div>
									@endforeach
									<?php } else if ($measure->measure_type_id == 2) { 
										$val = explode('/', $measure->measure_range);
									?>
									@foreach($val as $key => $value)
									<div class="alphanumericInput">
										<label for="val" class="hide"></label>						
										<input class="form-control input-small" value="<?php echo $value; ?>" name="val[]" type="text">
										<span class="alphanumericSlash">/</span>
									</div>
									@endforeach
									<?php } else if ($measure->measure_type_id == 3) { ?>
									<div class="col-md-4">
										<label for="val" class="hide"></label>						
										<input class="form-control" value="<?php echo "None"; ?>" name="val[]" type="text">
									</div>
									<?php } ?>
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
					{{ Form::button('<span class="glyphicon glyphicon-save"></span> Save', array('class' => 'btn btn-primary', 'onclick' => 'formsubmit("form-edit-measure")')) }}
				</div>

			{{ Form::close() }}
		</div>
	</div>