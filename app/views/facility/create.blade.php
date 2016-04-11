@extends("layout")
@section("content")
  <br />
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li class="active"><a href="{{ URL::route('facility.index') }}">{{Lang::choice('messages.facility',2)}}</a></li>
		  <li class="active">{{trans('messages.add-facility')}}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-adjust"></span>
			{{trans('messages.add-facility')}}
		</div>
		<div class="panel-body">
		<!-- if there are creation errors, they will show here -->
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif

			{{ Form::open(array('route' => 'facility.store', 'id' => 'form-add-facility')) }}

				<div class="form-group">
					{{ Form::label('name', Lang::choice('messages.name',2)) }}
					{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
				</div>
				 <div class="form-group">
                    {{ Form::label('county_id', Lang::choice('messages.county', 2)) }}
               
                    {{ Form::select('county_id', array(''=>trans('messages.select-county'))+$counties,'', 
                            array('class' => 'form-control', 'id' => 'county_id')) }}
                  
                </div>
                
				<div class="form-group actions-row">
					{{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
						array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
				</div>

			{{ Form::close() }}
		</div>
	</div>
@stop