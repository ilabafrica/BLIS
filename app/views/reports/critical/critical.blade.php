@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.report',2) }}</li>
	  <li class="active">{{ trans('messages.crit-val') }}</li>
	</ol>
</div>
<div class='container-fluid'>
{{ Form::open(array('route' => array('reports.aggregate.critval'), 'class' => 'form-inline', 'role' => 'form')) }}
<div class="row">
		<div class="col-sm-4">
	    	<div class="row">
				<div class="col-sm-2">
					{{ Form::label('start', trans("messages.from")) }}
				</div>
				<div class="col-sm-2">
					{{ Form::text('start', isset($from)?$from:date('Y-m-d'), 
				        array('class' => 'form-control standard-datepicker')) }}
			    </div>
	    	</div>
	    </div>
	    <div class="col-sm-4">
	    	<div class="row">
				<div class="col-sm-2">
			    	{{ Form::label('end', trans("messages.to")) }}
			    </div>
				<div class="col-sm-2">
				    {{ Form::text('end', isset($to)?$to:date('Y-m-d'), 
				        array('class' => 'form-control standard-datepicker')) }}
		        </div>
	    	</div>
	    </div>
	    <div class="col-sm-4">
		    <div class="row">
				<div class="col-sm-3">
				  	{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
		                array('class' => 'btn btn-info', 'id' => 'filter', 'type' => 'submit')) }}
		        </div>
		        <div class="col-sm-1">
					{{Form::submit(trans('messages.export-to-word'), 
			    		array('class' => 'btn btn-success', 'id'=>'word', 'name'=>'word'))}}
				</div>
			</div>
	    </div>
	</div>
{{ Form::close() }}
</div>
<br />
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.crit-val') }}
	</div>
	<div class="panel-body">
	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif	
	<table width="100%" style="font-size:12px;">
		<thead>
			<tr>
				<td>{{ HTML::image(Config::get('kblis.organization-logo'),  Config::get('kblis.country') . trans('messages.court-of-arms'), array('width' => '90px')) }}</td>
				<td colspan="3" style="text-align:center;">
					<strong><p> {{ strtoupper(Config::get('kblis.organization')) }}<br>
					{{ strtoupper(Config::get('kblis.address-info')) }}</p>
					<p>{{ trans('messages.laboratory-report')}}<br>
				</td>
				<td>
					{{ HTML::image(Config::get('kblis.organization-logo'),  Config::get('kblis.country') . trans('messages.court-of-arms'), array('width' => '90px')) }}
				</td>
			</tr>
		</thead>
	</table>
	<strong>
		<p> {{ trans('messages.crit-val') }} - 
			<?php $start = isset($from)?$from:date('01-m-Y');?>
			<?php $end = isset($to)?$to:date('d-m-Y');?>
			@if($start!=$end)
				{{trans('messages.from').' '.$start.' '.trans('messages.to').' '.$end}}
			@else
				{{trans('messages.for').' '.date('d-m-Y')}}
			@endif
		</p>
	</strong
		<div class="table-responsive">

		  @forelse($tc as $key)
		  {{--*/ $testCat = TestCategory::find($key) /*--}}
		  {{ $testCat->name }}
		  <table class="table table-striped table-bordered">
		  	<tbody>
		  		<tr>
		  			<th rowspan="2">{{trans('messages.parameter')}}</th>
		  			<th rowspan="2">{{trans('messages.gender')}}</th>
		  			<th colspan="{{ count($ageRanges) }}">{{trans('messages.age-ranges')}}</th>
		  			<th rowspan="2">{{trans('messages.mf-total')}}</th>
		  			<th rowspan="2">{{Lang::choice('messages.total', 1)}}</th>
		  		</tr>
		  		<tr>
		  			@foreach($ageRanges as $ageRange)
		  				<th>{{ $ageRange }}</th>
		  			@endforeach
		  		</tr>
		  		@forelse($testCat->criticals()->groupBy('measure_id')->lists('measure_id') as $measureId)
		  		{{--*/ $measure = Measure::find($measureId) /*--}}
		  		<tr>
			  		<td>{{ $measure->name }}</td>
			  		<td>@foreach($gender as $sex)
			  				{{ $sex==Patient::MALE?trans("messages.male"):trans("messages.female") }}<br />
			  			@endforeach
			  		</td>
			  		@foreach($ageRanges as $ageRange)
			  			<td>
							{{ $measure->criticals($key, $ageRange, Patient::MALE, $from, $toPlusOne) }}<br />{{ $measure->criticals($key, $ageRange, Patient::FEMALE, $from, $toPlusOne) }}<br />
						</td>
					@endforeach
					<td>
						{{ $measure->criticals($key, NULL, Patient::MALE, $from, $toPlusOne) }}<br />{{ $measure->criticals($key, NULL, Patient::FEMALE, $from, $toPlusOne) }}<br />
			  		</td>
			  		<td>{{ $measure->criticals($key, NULL, NULL, $from, $toPlusOne) }}</td>
			  	</tr>
			  	@empty
			  	<tr>
			  		<td colspan="5">{{ trans('messages.no-records-found') }}</td>
			  	</tr>
			  	@endforelse
		  		
		  	</tbody>
		  </table>
		  @empty
		  <table class="table table-striped table-bordered">
		  	<tbody>
		  		<tr>
		  			<td colspan="5">{{ trans('messages.no-records-found') }}</td>
		  		</tr>
		  	</tbody>
		  </table>
		  @endforelse
		</div>
	</div>
</div>

@stop