@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.quality-control', 2) }}</li>
	</ol>
</div>
<!-- if there are filter errors, they will show here -->
	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif
	@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
	@endif
{{ Form::open(array('route' => array('reports.qualityControl'), 'id' => 'qc', 'method' => 'post')) }}
<div class="container-fluid">
  	<div class="row report-filter">
        <div class="col-md-3">
	        <div class="col-md-2">
	        	{{ Form::label('start_date', trans("messages.from")) }}
	        </div>
	        <div class="col-md-10">
	            {{ Form::text('start_date', isset($input['start_date'])?$input['start_date']:date('Y-m-d'), 
	                array('class' => 'form-control standard-datepicker')) }}
	        </div>
        </div>
        <div class="col-md-3">
	        <div class="col-md-2">
	        	{{ Form::label('end_date', trans("messages.to")) }}
	        </div>
	        <div class="col-md-10">
	            {{ Form::text('end_date', isset($input['end_date'])?$input['end_date']:date('Y-m-d'), 
	                array('class' => 'form-control standard-datepicker')) }}
	        </div>
        </div>
        <div class="col-md-4">
	        <div class="col-md-3">
	        	{{ Form::label('control', Lang::choice('messages.control',1)) }}
	        </div>
	        <div class="col-md-9">
	            {{ Form::select('control', array(null => '')+ $controls,
	            	isset($input['control'])?$input['control']:0, array('class' => 'form-control')) }}
	        </div>
        </div>
        <div class="col-md-2">
        	{{Form::submit(trans('messages.view'), 
	        	array('class' => 'btn btn-info', 'id'=>'filter', 'name'=>'filter'))}}
        </div>
  	</div>
</div>
{{ Form::close() }}
<br />
<div class="panel panel-primary">
	<div class="panel-heading ">
		<div class="container-fluid">
			<div class="row less-gutter">
				<div class="col-md-8">
					<span class="glyphicon glyphicon-user"></span>
					{{ trans('messages.controlresults') }}
				</div>
				<div class="col-md-4">
					<a class="btn btn-info pull-right" id="reveal" href="#" onclick="return false;"
                            alt="{{trans('messages.show-hide')}}" title="{{trans('messages.show-hide')}}">
                            <span class="glyphicon glyphicon-eye-open"></span> {{trans('messages.show-hide')}}</a>
				</div>
			</div>
		</div>
	</div>
	<div class="panel-body">
	<div id="highChart"></div>
	</div>
</div>
@stop