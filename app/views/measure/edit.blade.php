	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">Home</a></li>
		  <li><a href="{{URL::route('measure.index')}}">Measure</a></li>
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
					<label for="measurerange">Range Values</label>				
					<div class="form-pane panel panel-default">
						<div class="panel-body">
							<div class="measurevalue">
							@if ($measure->measure_type_id == 1)
								@foreach($measure->measureRanges as $key=>$value)
								<div class="numeric-range-measure">
									<button class="close" aria-hidden="true" type="button" title="Delete">×</button>
									<input value="{{{$value->id}}}" name="measurerangeid[]" type="hidden">
									<div>
										<span class="range-title">Age Range:</span>
										<input name="agemin[]" type="text" value="{{{$value->age_min}}}" title="Lower Age Limit">
										<span>:</span>
										<input name="agemax[]" type="text" value="{{{$value->age_max}}}" title="Upper Age Limit">
									</div>
									<div>
										<span class="range-title">Gender:</span>
										<?php $selection = array("","","");?>
										<?php $selection[$value->gender] = "selected='selected'"; ?>
										<select name="gender[]">
											<option value="0" {{$selection[0]}}>Male</option>
											<option value="1" {{$selection[1]}}>Female</option>
											<option value="2" {{$selection[2]}}>Both</option>
										</select>
									</div>
									<div>
										<span class="range-title">Measure Range:</span>
										<input name="rangemin[]" type="text" value="{{{$value->range_lower}}}" title="Lower Range">
										<span>:</span>
										<input name="rangemax[]" type="text" value="{{{$value->range_upper}}}" title="Upper Range">
									</div>
								</div>
								@endforeach
							@elseif ($measure->measure_type_id == 2)
								<?php $val = explode('/', $measure->measure_range); ?>
								@foreach($val as $key => $value)
									<div class="alphanumericInput">
										<input class="form-control input-small" value="{{{$value}}}" name="val[]" type="text">
										<span class="alphanumericSlash">/</span>
									</div>
								@endforeach
							@elseif ($measure->measure_type_id == 3)
								<div class="col-md-4">
									<input class="form-control" value="None" name="val[]" type="text">
								</div>
							@endif
							</div>
						</div>
					</div>
				</div>
				<div class="form-group actions-row">
					<a class="btn btn-default add-another-range" href="javascript:void(0);">
						<span class="glyphicon glyphicon-plus-sign"></span>Add Range</a>
					{{ Form::button('<span class="glyphicon glyphicon-save"></span> Update Measure', 
						array('class' => 'btn btn-default', 'onclick' => 'formsubmit("form-edit-measure")')) }}
				</div>

			{{ Form::close() }}
		</div>
	</div>