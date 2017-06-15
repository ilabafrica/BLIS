@extends("layout")
@section("content")

	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li>
		  	<a href="{{ URL::route('critical.index') }}">{{ Lang::choice('messages.critical',1) }}</a>
		  </li>
		  <li class="active">{{Lang::choice('messages.critical', 2)}}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-adjust"></span>
			{{trans('messages.add-new')}}
		</div>
		<div class="panel-body">
		<!-- if there are creation errors, they will show here -->
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif

			{{ Form::open(array('route' => 'critical.store', 'id' => 'form-create-critical')) }}

				<div class="form-group">
					{{ Form::label('measure_id', Lang::choice('messages.measure', 1)) }}
					{{ Form::select('measure_id', array(0 => '')+$measures,
						Input::old('measure_id'),	array('class' => 'form-control')) }}
				</div>
                <div class="form-group">
                	{{ Form::label('gender', Lang::choice('messages.gender', 1)) }}
                	<div>
                		<label class="radio-inline">{{ Form::radio('gender', Patient::MALE, true) }}{{trans('messages.male')}}</label>
                        <label class="radio-inline">{{ Form::radio("gender", Patient::FEMALE, false) }}{{trans('messages.female')}}</label>
                        <label class="radio-inline">{{ Form::radio("gender", Patient::BOTH, false) }}{{trans('messages.both')}}</label>
                    </div>
                </div>
				<div class="form-group">
					{{ Form::label('age-units', "Age Units") }}			
					{{ Form::select('age_unit', array(0 => '')+$units,
						Input::old('age_unit'),	array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('age-min', Lang::choice('messages.age-min', 1)) }}
					{{ Form::text('age_min', Input::old('age_min'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('age-max', Lang::choice('messages.age-max', 1)) }}
					{{ Form::text('age_max', Input::old('age_max'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('normal-lower', Lang::choice('messages.normal-lower', 1)) }}
					{{ Form::text('normal_lower', Input::old('normal_lower'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('normal-upper', Lang::choice('messages.normal-upper', 1)) }}
					{{ Form::text('normal_upper', Input::old('normal_upper'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('critical-low', Lang::choice('messages.critical-low', 1)) }}
					{{ Form::text('critical_low', Input::old('critical_low'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('critical-high', Lang::choice('messages.critical-high', 1)) }}
					{{ Form::text('critical_high', Input::old('critical_high'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('unit', Lang::choice('messages.unit', 1)) }}
					{{ Form::text('unit', Input::old('unit'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group actions-row">
					{{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
						array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
				</div>

			{{ Form::close() }}
		</div>
	</div>
@stop	