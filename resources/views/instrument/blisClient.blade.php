@extends("layout")
@section("content")

	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{ URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		  <li><a href="{{ URL::route('blisclient.index') }}">{{ trans('messages.interfaced-equipment') }}</a></li>
		</ol>
	</div>	
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-edit"></span>
			{{ trans('messages.select-equipment') }}
		</div>
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
			@if (Session::has('message'))
				<div class="alert alert-info">{{ Session::get('message') }}</div>
			@endif
				<div class="col-md-7"> 
				{{ Form::open(array('method' => 'PUT', 'id' => 'form-edit-client')) }}
					<div class="form-group">
						{{ Form::label('equipment', trans('messages.equipment')) }}
						{{ Form::select('client', $client,
							'', array('class' => 'form-control', 'id' => 'client', 'onchange' => "fetch_equipment_details()")) }}
					</div>
					<div id="eq_con_details" name="eq_con_details"></div>

				{{ Form::close() }}
				</div>
				<div class="col-md-5">
					<ul class="list-group">
						<li class="list-group-item disabled"><strong>Page Help</strong></li>
						<li class="list-group-item">This Page list all interfaced equipment</li>
						<li class="list-group-item">Please select the equipment and see how it is interfaced with BLIS</li>
						<li class="list-group-item">Check the configurations that must be set in the <strong>BLISInterfaceClient.ini</strong> file</li>
					</ul>
				</div>
			</div>
		{{ Session::put('SOURCE_URL', URL::full()) }}
	</div>
@stop	