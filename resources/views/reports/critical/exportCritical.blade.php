<html>
<head>
{{ HTML::style('css/bootstrap.min.css') }}
{{ HTML::style('css/bootstrap-theme.min.css') }}
<style type="text/css">
	#content table, #content th, #content td {
	   border: 1px solid black;
	   font-size:12px;
	}
	#content p{
		font-size:12px;
	 }
</style>
</head>
<body>
<div id="wrap">
    <div class="container-fluid">
		<table width="100%" style="font-size:12px;">
			<thead>
				<tr>
					<td>{{ HTML::image(Config::get('blis.organization-logo'),  Config::get('blis.country') . trans('messages.court-of-arms'), array('width' => '90px')) }}</td>
					<td colspan="3" style="text-align:center;">
						<strong><p> {{ strtoupper(Config::get('blis.organization')) }}<br>
						{{ strtoupper(Config::get('blis.address-info')) }}</p>
						<p>{{ trans('messages.laboratory-report')}}<br>
					</td>
					<td>
						{{ HTML::image(Config::get('blis.organization-logo'),  Config::get('blis.country') . trans('messages.court-of-arms'), array('width' => '90px')) }}
					</td>
				</tr>
			</thead>
		</table>
    	<div id="content">
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
			</strong>
				<div class="table-responsive">
				@forelse($tc as $key)
				{{--*/ $testCat = App\Models\TestCategory::find($key) /*--}}
				{{ $testCat->name }}
				<table class="table table-striped table-bordered">
				  	<tbody>
				  		<tr>
				  			<th rowspan="2">{{trans('messages.parameter')}}</th>
				  			<th rowspan="2">{{trans('messages.gender')}}</th>
				  			<th colspan="{{ count($ageRanges) }}">{{trans('messages.age-ranges')}}</th>
				  			<th rowspan="2">{{trans('messages.mf-total')}}</th>
				  			<th rowspan="2">{{trans_choice('messages.total', 1)}}</th>
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
</div>
</body>
</html>