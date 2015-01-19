@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ trans('messages.reports') }}</li>
	  <li class="active">{{ trans('messages.infection-report') }}</li>
	</ol>
</div>
<div class='container-fluid'>
{{ Form::open(array('route' => array('reports.aggregate.infection'), 'class' => 'form-inline', 'role' => 'form')) }}
<div class="row">
		<div class="col-sm-4">
	    	<div class="row">
				<div class="col-sm-2">
					{{ Form::label('start', trans("messages.from")) }}
				</div>
				<div class="col-sm-2">
					{{ Form::text('start', isset($input['start'])?$input['start']:date('Y-m-d'), 
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
				    {{ Form::text('end', isset($input['end'])?$input['end']:date('Y-m-d'), 
				        array('class' => 'form-control standard-datepicker')) }}
		        </div>
	    	</div>
	    </div>
	    <div class="col-sm-4">
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
		{{ trans('messages.infection-report') }}
	</div>
	<div class="panel-body">
	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif	
	@include("reportHeader")
	<strong>
		<p> {{ trans('messages.infection-report') }} - 
			<?php $from = isset($input['start'])?$input['start']:date('01-m-Y');?>
			<?php $to = isset($input['end'])?$input['end']:date('d-m-Y');?>
			@if($from!=$to)
				{{trans('messages.from').' '.$from.' '.trans('messages.to').' '.$to}}
			@else
				{{trans('messages.for').' '.date('d-m-Y')}}
			@endif
		</p>
	</strong>
		<div class="table-responsive">
			<table class="table table-bordered">
				<tbody>
					<tr>
						<th rowspan="2">{{ trans('messages.test') }}</th>
						<th rowspan="2">{{ trans('messages.measures') }}</th>
						<th rowspan="2">{{ trans('messages.test-results') }}</th>
						<th rowspan="2">{{ trans('messages.gender') }}</th>
						<th colspan="{{ count($ageRanges) }}">{{ trans('messages.measure-age-range') }}</th>
						<th rowspan="2">{{ trans('messages.mf-total') }}</th>
						<th rowspan="2">{{ trans('messages.total-tests') }}</th>
					</tr>
					<tr>
					@foreach($ageRanges as $ageRange)
						<th>{{ $ageRange }}</th>
				    @endforeach
					</tr>
					@forelse($tests as $testType)
					<tr>
						<td>{{ $testType->name }}</td>
						<td>@foreach($testType->measures as $measure)
								@if(count($testType->measures)>1)
								{{ $measure->name }}<br /><br /><br /><br /><br /><br />
								@else
								<p>{{ $measure->name }}</p>
								@endif
							@endforeach
						</td>
						<td>@foreach($testType->measures as $measure)
								@foreach($ranges as $measureRange)
									@if($measureRange==MeasureRange::LOW)
										{{ 'Low' }}<br /><br />
									@elseif($measureRange==MeasureRange::NORMAL)
										{{ 'Normal' }}<br /><br />
									@elseif($measureRange==MeasureRange::HIGH)
										{{ 'High' }}<br /><br />
									@endif
								@endforeach
							@endforeach
						</td>
						<td>@foreach($testType->measures as $measure)
								@foreach($ranges as $measureRange)
									@foreach($gender as $sex)
										{{ $sex==Patient::MALE?trans("messages.male"):trans("messages.female") }}<br />
									@endforeach
								@endforeach
							@endforeach
						</td>
						@foreach($ageRanges as $ageRange)
						<td>
						@foreach($testType->measures as $measure)
							@foreach($ranges as $measureRange)
								{{ 4 }}<br />
								{{ 5 }}<br />
							@endforeach
						@endforeach
						</td>
						@endforeach
						<td>@foreach($testType->measures as $measure)
								@foreach($ranges as $measureRange)
									{{ 0 }}<br />
									{{ 3 }}<br />
								@endforeach
							@endforeach
						</td>
						<td>{{ 5 }}</td>
					</tr>
					@empty
					<tr>
						<td colspan="9">
							{{trans('messages.no-records-found')}}
						</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>

@stop