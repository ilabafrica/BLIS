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
					{{ Form::select('measure_type_id', $measuretype, Input::old('measure_type_id'), 
						array('class' => 'form-control measuretype-input-trigger', 'id' => 'measuretype')) 
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
					<label for="measurerange">{{trans('messages.measure-range-values')}}</label>
					<div class="form-pane panel panel-default">
						<div class="panel-body">
							<div class="{{($measure->measure_type_id == 1) ? 'col-md-12' : 'col-md-6' }} measurevalue">
							
							@if ($measure->measure_type_id == 1)
								<div class="col-md-12">
					                <div class="col-md-4">
					                	<span class="col-md-6 range-title">{{trans('messages.measure-age-range')}}</span>
					                	<span class="col-md-6 range-title">{{trans('messages.gender')}}</span>
					                </div>
					                <div class="col-md-3">
					                	<span class="col-md-12 range-title">{{trans('messages.measure-range')}}</span>
					                </div>
					                <div class="col-md-2">
					                	<span class="col-md-12 interpretation-title">{{trans('messages.interpretation')}}</span>
					                </div>
								</div>     
								@foreach($measure->measureRanges as $key=>$value)
						        <div class="col-md-12 measure-input">
						            <div class="col-md-4">
						                <input class="col-md-2" name="agemin[]" type="text" value="{{ $value->age_min }}"
						                	title="{{trans('messages.lower-age-limit')}}">
						                <span class="col-md-1">:</span>
						                <input class="col-md-2" name="agemax[]" type="text" value="{{ $value->age_max }}"
						                    title="{{trans('messages.upper-age-limit')}}">
											<?php $selection = array("","","");?>
											<?php $selection[$value->gender] = "selected='selected'"; ?>
										<span class="col-md-1"></span>
						                <select class="col-md-4" name="gender[]">
						                    <option value="0" {{ $selection[0] }}>{{trans('messages.male')}}</option>
						                    <option value="1" {{ $selection[1] }}>{{trans('messages.female')}}</option>
						                    <option value="2" {{ $selection[2] }}>{{trans('messages.both')}}</option>
						                </select>
						            </div>
						            <div class="col-md-3">
						                <input class="col-md-4" name="rangemin[]" type="text" value="{{ $value->range_lower }}" 
						                    title="{{trans('messages.lower-range')}}">
						                <span class="col-md-2">:</span>
						                <input class="col-md-4" name="rangemax[]" type="text" value="{{ $value->range_upper }}"
						                    title="{{trans('messages.upper-range')}}">
						            </div>
						            <div class="col-md-2">
						                <input class="col-md-10" name="interpretation[]" type="text" 
						                    value="{{ $value->interpretation }}">
							            <button class="col-md-2 close" aria-hidden="true" type="button" 
							            title="{{trans('messages.delete')}}">×</button>
							            <input value="{{ $value->id }}" name="measurerangeid[]" type="hidden">
						            </div>
						        </div>
								@endforeach

							@elseif ($measure->measure_type_id == 2 || $measure->measure_type_id == 3)
					            <div class="col-md-12">
					                <span class="col-md-5 interpretation-title">{{trans('messages.range')}}</span>
					                <span class="col-md-5 interpretation-title">{{trans('messages.interpretation')}}</span>
					            </div>
								@foreach($measure->measureRanges as $key=>$value)
						        <div class="col-md-12 measure-input">
						            <div class="col-md-5">
						                <input class="col-md-10 interpretation" value="{{ $value->alphanumeric }}"
						                name="val[]" type="text">
						            </div>
						            <div class="col-md-5">
						                <input class="col-md-10 interpretation" value="{{ $value->interpretation }}"
						                name="interpretation[]" type="text">
							            <button class="col-md-2 close" aria-hidden="true" type="button" 
							            	title="{{trans('messages.delete')}}">×</button>
							        	<input value="{{ $value->id }}" name="measurerangeid[]" type="hidden">
						            </div>
						        </div>  
								@endforeach

							@endif
							</div>
						</div>
					</div>
				</div>
				<div class="form-group actions-row">
					<a class="btn btn-default add-another-range" href="javascript:void(0);">
						<span class="glyphicon glyphicon-plus-sign"></span>{{trans('messages.add-new-measure-range')}}</a>
					{{ Form::button('<span class="glyphicon glyphicon-save"></span>'.trans('messages.update-measure'), 
						array('class' => 'btn btn-default', 'onclick' => 'submit()')) }}
				</div>
			{{ Form::close() }}
		</div>
	</div>
	@include("measure.measureinput")
@stop