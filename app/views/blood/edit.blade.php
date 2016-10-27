@extends("layout")
@section("content")

	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		  <li>
		  	<a href="{{ URL::route('blood.index') }}">{{ trans('messages.blood-bank') }}</a>
		  </li>
		  <li class="active">{{ trans('messages.edit') }}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-edit"></span>
			{{ trans('messages.edit') }}
		</div>
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
			{{ Form::model($bb, array('route' => array('blood.update', $bb->id), 
				'method' => 'PUT', 'id' => 'form-edit-blood')) }}
				<div class="form-group">
					{{ Form::label('bag-number', trans('messages.bag-number')) }}
					{{ Form::text('bag_number', Input::old('bag_number'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('blood-group', trans('messages.blood-group')) }}
					{{ Form::select('blood_group', $groups, $group, array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('volume', trans('messages.volume')) }}
					{{ Form::text('volume', Input::old('volume'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('date-collected', trans('messages.date-collected')) }}
					{{ Form::text('date_collected', Input::old('date_of_reception'), array('class' => 'form-control standard-datepicker')) }}
				</div>
				<div class="form-group">
					{{ Form::label('expiry', trans('messages.expiry')) }}
					{{ Form::text('expiry_date', Input::old('expiry_date'), array('class' => 'form-control standard-datepicker')) }}
				</div>
				<div class="form-group actions-row">
					{{ Form::button('<span class="glyphicon glyphicon-save"></span> '. trans('messages.save'), 
						['class' => 'btn btn-primary', 'onclick' => 'submit()']) }}
				</div>

			{{ Form::close() }}
		</div>
	</div>
@stop	