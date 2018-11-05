<html>
<head>
{{ HTML::style('css/bootstrap-theme.min.css') }}
<style type="text/css">
	#content table, #content th, #content td {
	   border: 1px solid black;
	   font-size:12px;
	}
	#content p{
		font-size:12px;
	 }
	.table {
		 border-collapse: collapse;
		 table-layout:fixed;
		 width: 600px;
	 }
</style>
</head>
<body>
	@include("reportHeader")
	<div id="content">
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
				</thead>
				<tbody>
					@foreach(Disease::all() as $disease)
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
	</div>
</body>
</html>