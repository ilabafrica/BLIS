@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		  <li><a href="{{URL::route('measure.index')}}">{{ Lang::choice('messages.measure',1) }}</a></li>
		  <li class="active">{{ trans('messages.edit-measure') }}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-edit"></span>
			{{ trans('messages.edit-measure-details') }}
		</div>
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
			{{ Form::model($measure, array('route' => array('measure.update', $measure->id), 'method' => 'PUT',
				'id' => 'form-edit-measure')) }}

				<div class="form-group">
					{{ Form::label('name', Lang::choice('messages.name',1)) }}
					{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('measure_type_id', Lang::choice('messages.specimen-type',1)) }}
					{{ Form::select('measure_type_id', $measuretype, 
						Input::old('measure_type_id'), array('class' => 'form-control', 'id' => 'measuretype')) 
					}}
				</div>
				<div class="form-group">
					{{ Form::label('unit', trans('messages.unit')) }}
					{{ Form::text('unit', Input::old('unit'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('description', trans('messages.description')) }}
					{{ Form::textarea('description', Input::old('description'), array('class' => 'form-control',
						'rows'=>'2')) }}
				</div>
				<div class="form-group">
					<label for="measurerange">{{trans('messages.range-values')}}</label>
					<div class="form-pane panel panel-default">
						<div class="panel-body">
							<div class="measurevalue">
							@if ($measure->measure_type_id == 1)
								@foreach($measure->measureRanges as $key=>$value)
								<div class="numeric-range-measure">
									<button class="close" aria-hidden="true" type="button" title="Delete">×</button>
									<input value="{{{$value->id}}}" name="measurerangeid[]" type="hidden">
									<div>
										<span class="range-title">trans('messages.age-range'))</span>
										<input name="agemin[]" type="text" value="{{{$value->age_min}}}"
											title="trans('messages.lower-age-limit'))">
										<span>:</span>
										<input name="agemax[]" type="text" value="{{{$value->age_max}}}"
											title="trans('messages.upper-age-limit'))">
									</div>
									<div>
										<span class="range-title">trans('messages.gender'))</span>
										<?php $selection = array("","","");?>
										<?php $selection[$value->gender] = "selected='selected'"; ?>
										<select name="gender[]">
											<option value="0" {{$selection[0]}}>trans('messages.male'))</option>
											<option value="1" {{$selection[1]}}>trans('messages.female'))</option>
											<option value="2" {{$selection[2]}}>trans('messages.both'))</option>
										</select>
									</div>
									<div>
										<span class="range-title">trans('messages.measure-range'))</span>
										<input name="rangemin[]" type="text" value="{{{$value->range_lower}}}" 
											title="trans('messages.lower-range'))">
										<span>:</span>
										<input name="rangemax[]" type="text" value="{{{$value->range_upper}}}"
											title="trans('messages.upper-range'))">
									</div>
								</div>
								@endforeach
							@elseif ($measure->measure_type_id == 2)
								<?php $val = explode('/', $measure->measure_range); ?>
								@foreach($val as $key => $value)
									<div class="alphanumericInput">
										<input class="form-control input-small" value="{{{$value}}}" name="val[]"
										type="text"><span class="alphanumericSlash">/</span>
									</div>
								@endforeach
							@elseif ($measure->measure_type_id == 3)
								<div class="col-md-4">
									<input class="form-control" value="trans('messages.none'))" name="val[]" type="text">
								</div>
							@endif
							</div>
						</div>
					</div>
				</div>
				<div class="form-group actions-row">
					<a class="btn btn-default add-another-range" href="javascript:void(0);">
						<span class="glyphicon glyphicon-plus-sign"></span>{{trans('messages.add-range')}}</a>
					{{ Form::button('<span class="glyphicon glyphicon-save"></span> '.trans('messages.update-measure'),
						array('class' => 'btn btn-default', 'onclick' => 'submit()')) }}
				</div>

			{{ Form::close() }}
		</div>
	</div>
@stop