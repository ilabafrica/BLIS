@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.report',2) }}</li>
	  <li class="active">{{ trans('messages.surveillance') }}</li>
	</ol>
</div>
<div class='container-fluid'>
{{ Form::open(array('route' => array('reports.aggregate.surveillance'), 'class' => 'form-inline', 'role' => 'form')) }}
<div class="row">
		<div class="col-sm-5">
	    	<div class="row">
				<div class="col-sm-2">
					{{ Form::label('start', trans("messages.from")) }}
				</div>
				<div class="col-sm-3">
	    </div>
	    	</div>
	    </div>
	    <div class="col-sm-5">
	    	<div class="row">
				<div class="col-sm-2">
			    	{{ Form::label('end', trans("messages.to")) }}
			    </div>
				<div class="col-sm-3">
				  </div>
	    	</div>
	    </div>
	    <div class="col-sm-2">
		    {{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
		        array('class' => 'btn btn-info', 'id' => 'filter', 'type' => 'submit')) }}
	    </div>
	</div>
{{ Form::close() }}
</div>
<br />
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.surveillance') }}
	</div>
	<div class="panel-body">
	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif	
	<strong>
		<p> {{ trans('messages.surveillance') }} - 
			<?php //$from = isset($input['start'])?$input['start']:date('01-m-Y');?>
			<?php //$to = isset($input['end'])?$input['end']:date('d-m-Y');?>
		</p>
	</strong
	<?php Log::info($reportData)?>
		<div class="table-responsive">
		  <table class="table table-striped table-bordered">
		  	<thead>
		  		<tr>
		  			<th rowspan="2">{{trans('messages.laboratory')}}</th>
		  			<th colspan="2">{{trans('messages.less-five')}}</th>
		  			<th colspan="2">{{trans('messages.greater-five')}}</th>
		  			<th colspan="2">{{Lang::choice('messages.total',1)}}</th>
		  		</tr>
		  		<tr>
		  			<th>{{trans('messages.tested')}}</th>
		  			<th>{{trans('messages.positive')}}</th>
		  			<th>{{trans('messages.tested')}}</th>
		  			<th>{{trans('messages.positive')}}</th>
		  			<th>{{trans('messages.tested')}}</th>
		  			<th>{{trans('messages.positive')}}</th>
		  		</tr>
		  		<tr>
		  				<td>{{ trans('messages.malaria') }}</td>
		  				<td>{{ 'malaria_total' }}</td>
		  				<td>{{ 'malaria_positive' }}</td>
		  				<td>{{ 'malaria_total' }}</td>
		  				<td>{{ 'malaria_positive' }}</td>
		  				<td>{{ $reportData['malaria_total'] }}</td>
		  				<td>{{ $reportData['malaria_positive'] }}</td>
		  		</tr>
		  		<tr>
		  				<td>{{ trans('messages.dysentry') }}</td>
		  				<td>{{ 'dysentry_total' }}</td>
		  				<td>{{ 'dysentry_positive' }}</td>
		  				<td>{{ 'dysentry_total' }}</td>
		  				<td>{{ 'dysentry_positive' }}</td>
		  				<td>{{ $reportData['dysentry_total'] }}</td>
		  				<td>{{ $reportData['dysentry_positive'] }}</td>
		  		</tr>
		  		<tr>
		  				<td>{{ trans('messages.typhoid') }}</td>
		  				<td>{{ 'typhoid_total' }}</td>
		  				<td>{{ 'typhoid_positive' }}</td>
		  				<td>{{ 'typhoid_total' }}</td>
		  				<td>{{ 'typhoid_positive' }}</td>
		  				<td>{{ $reportData['typhoid_total'] }}</td>
		  				<td>{{ $reportData['typhoid_positive'] }}</td>
		  		</tr>
		  	</tbody>
		  </table>
		</div>
	</div>
</div>

@stop