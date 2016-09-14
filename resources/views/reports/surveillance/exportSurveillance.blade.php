<html>
<head>
{{ HTML::style('css/bootstrap.min.css') }}
{{ HTML::style('css/bootstrap-theme.min.css') }}
</head>
<body>
	@include("reportHeader")
	<strong>
		<p> {{ trans('messages.surveillance') }} - 
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
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th rowspan="2">{{trans('messages.laboratory')}}</th>
					<th colspan="2">{{trans('messages.less-five')}}</th>
					<th colspan="2">{{trans('messages.greater-five')}}</th>
					<th colspan="2">{{trans_choice('messages.total',1)}}</th>
				</tr>
				<tr>
					<th>{{trans('messages.tested')}}</th>
					<th>{{trans('messages.positive')}}</th>
					<th>{{trans('messages.tested')}}</th>
					<th>{{trans('messages.positive')}}</th>
					<th>{{trans('messages.tested')}}</th>
					<th>{{trans('messages.positive')}}</th>
				</tr> 
			</thead>
			<tbody>
				@foreach(App\Models\Disease::all() as $disease)
					<?php if(empty(count($disease->reportDiseases))) continue; ?>
					<tr>
						<td>{{ $disease->name }}</td>
						<td>{{ $surveillance[$disease->id.
							'_less_five_total'] }}</td>
						<td>{{ $surveillance[$disease->id.
							'_less_five_positive'] }}</td>
						<td>{{ $surveillance[$disease->id.
							'_total'] - $surveillance[$disease->id.
							'_less_five_total'] }}</td>
						<td>{{ $surveillance[$disease->id.
							'_positive'] - $surveillance[$disease->id.
							'_less_five_positive'] }}</td>
						<td>{{ $surveillance[$disease->id.
							'_total'] }}</td>
						<td>{{ $surveillance[$disease->id.'_positive'] }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</body>
</html>