@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.report',2) }}</li>
	  <li class="active">{{ trans('messages.counts') }}</li>
	</ol>
</div>
<div class='container-fluid'>
{{ Form::open(array('route' => array('reports.aggregate.counts'), 'class' => 'form-inline', 'role' => 'form')) }}
<div class="row">
		<div class="col-sm-5">
	    	<div class="row">
				<div class="col-sm-2">
					{{ Form::label('start', trans("messages.from")) }}
				</div>
				<div class="col-sm-3">
					{{ Form::text('start', isset($input['start'])?$input['start']:date('Y-m-d'), 
				        array('class' => 'form-control standard-datepicker')) }}
			    </div>
	    	</div>
	    </div>
	    <div class="col-sm-5">
	    	<div class="row">
				<div class="col-sm-2">
			    	{{ Form::label('end', trans("messages.to")) }}
			    </div>
				<div class="col-sm-3">
				    {{ Form::text('end', isset($input['end'])?$input['end']:date('Y-m-d'), 
				        array('class' => 'form-control standard-datepicker')) }}
		        </div>
	    	</div>
	    </div>
	    <div class="col-sm-2">
		    {{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
		        array('class' => 'btn btn-info', 'id' => 'filter', 'type' => 'submit')) }}
	    </div>
	</div>
	<div class='row spacer'>
		<div class="col-sm-12">
	    	<div class="row">
				<div class="col-sm-3">
				  	<label class="radio-inline">
						{{ Form::radio('counts', trans('messages.ungrouped-test-counts'), false, array('data-toggle' => 'radio', 
						  'id' => 'tests')) }} {{trans('messages.ungrouped-test-counts')}}
					</label>
				</div>
				<div class="col-sm-3">
				    <label class="radio-inline">
						{{ Form::radio('counts', trans('messages.grouped-test-counts'), false, array('data-toggle' => 'radio',
						  'id' => 'patients')) }} {{trans('messages.grouped-test-counts')}}
					</label>
				</div>
				<div class="col-sm-3">
				    <label class="radio-inline">
						{{ Form::radio('counts', trans('messages.ungrouped-specimen-counts'), false, array('data-toggle' => 'radio',
						  'id' => 'specimens')) }} {{trans('messages.ungrouped-specimen-counts')}}
					</label>
				</div>
				<div class="col-sm-3">
					<label class="radio-inline">
			    		{{ Form::radio('counts', trans('messages.grouped-specimen-counts'), true, array('data-toggle' => 'radio',
						  'id' => 'specimens')) }} {{trans('messages.grouped-specimen-counts')}}
					</label>
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
		{{ trans('messages.counts') }}
	</div>
	<div class="panel-body">
	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif	
	<strong>
		<p> {{ trans('messages.grouped-specimen-counts') }} - 
			<?php $from = isset($input['start'])?$input['start']:date('01-m-Y');?>
			<?php $to = isset($input['end'])?$input['end']:date('d-m-Y');?>
			@if($from!=$to)
				{{trans('messages.from').' '.$from.' '.trans('messages.to').' '.$to}}
			@else
				{{trans('messages.for').' '.date('d-m-Y')}}
			@endif
		</p>
	</strong
		<div class="table-responsive">

		  <table class="table table-striped table-bordered">
		  	<tbody>
		  		<tr>
		  			<th rowspan="2">{{Lang::choice('messages.test-type',2)}}</th>
		  			<th rowspan="2">{{trans('messages.gender')}}</th>
		  			<th colspan="{{ count($ageRanges) }}">{{trans('messages.age-ranges')}}</th>
		  			<th rowspan="2">{{trans('messages.mf-total')}}</th>
		  			<th rowspan="2">{{trans('messages.total-specimen')}}</th>
		  		</tr>
		  		<tr>
		  			@foreach($ageRanges as $ageRange)
		  				<th>{{ $ageRange }}</th>
		  			@endforeach
		  		</tr>
		  		@forelse($specimenTypes as $specimenType)
		  		<tr>
			  		<td>{{ $specimenType->name }}</td>
			  		<td>@foreach($gender as $sex)
			  				{{ $sex==Patient::MALE?trans("messages.male"):trans("messages.female") }}<br />
			  			@endforeach
			  		</td>
			  		@foreach($ageRanges as $ageRange)
			  			<td>
							{{ $perAgeRange[$specimenType->id][$ageRange]["male"] }}<br />{{ $perAgeRange[$specimenType->id][$ageRange]["female"] }}<br />
						</td>
					@endforeach
					<td>
						{{ $perSpecimenType[$specimenType->id]['countMale'] }}<br />{{ $perSpecimenType[$specimenType->id]['countFemale'] }}<br />
			  		</td>
			  		<td>{{ $perSpecimenType[$specimenType->id]['countAll'] }}</td>
			  	</tr>
			  	@empty
			  	<tr>
			  		<td>{{ trans('messages.no-records-found') }}</td>
			  	</tr>
			  	@endforelse
		  	</tbody>
		  </table>
		  @include("loader")
		</div>
	</div>
</div>

@stop