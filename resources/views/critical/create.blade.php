@extends("layout") 
@section("content")

	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li>
		  	<a href="{{ URL::route('critical.index') }}">{{ trans_choice('messages.critical',1) }}</a>
		  </li>
		  <li class="active">{{trans_choice('messages.critical', 2)}}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-adjust"></span>
			{{trans('messages.create-critical')}}
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
					{{ Form::label('measure_id', trans_choice('messages.measure', 1)) }}
					{{ Form::select('measure_id',$measures,
						Input::old('measure_id'),	array('class' => 'form-control')) }}
				</div>
                <div class="form-group">
                	{{ Form::label('gender', trans_choice('messages.gender', 1)) }}
                	<div>
                		<label class="radio-inline">{{ Form::radio('gender', App\Models\Patient::MALE, true) }}{{trans('messages.male')}}</label>
                        <label class="radio-inline">{{ Form::radio("gender", App\Models\Patient::FEMALE, false) }}{{trans('messages.female')}}</label>
                        <label class="radio-inline">{{ Form::radio("gender", App\Models\Patient::BOTH, false) }}{{trans('messages.both')}}</label>
                    </div>
                </div>
				<div class="form-group">
					{{ Form::label('age-min', trans_choice('messages.age-min', 1)) }}
					{{ Form::text('age_min', Input::old('age_min'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('age-max', trans_choice('messages.age-max', 1)) }}
					{{ Form::text('age_max', Input::old('age_max'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('normal-lower', trans_choice('messages.normal-lower', 1)) }}
					{{ Form::text('normal_lower', Input::old('normal_lower'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('normal-upper', trans_choice('messages.normal-upper', 1)) }}
					{{ Form::text('normal_upper', Input::old('normal_upper'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('critical-low', trans_choice('messages.critical-low', 1)) }}
					{{ Form::text('critical_low', Input::old('critical_low'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('critical-high', trans_choice('messages.critical-high', 1)) }}
					{{ Form::text('critical_high', Input::old('critical_high'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('unit', trans_choice('messages.unit', 1)) }}
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