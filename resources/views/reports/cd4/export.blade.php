<html>
<head>
{{ HTML::style('css/bootstrap.min.css') }}
{{ HTML::style('css/bootstrap-theme.min.css') }}
</head>
<body>
@include("reportHeader")
<div id="content">
	<strong>
		<p>
			{{ trans('messages.cd4-report') }} - 
			<?php $from = isset($input['start'])?$input['start']:date('01-m-Y');?>
			<?php $to = isset($input['end'])?$input['end']:date('d-m-Y');?>
			@if($from!=$to)
				{{trans('messages.from').' '.$from.' '.trans('messages.to').' '.$to}}
			@else
				{{trans('messages.for').' '.date('d-m-Y')}}
			@endif
		</p>
	</strong>
	<br>
	<table class="table table-bordered"  width="100%">
		<tbody align="left">
			<tr>
			<th></th>
			@foreach($columns as $column)
				<th>{{ $column }}</th>
			@endforeach
			</tr>
			@foreach($rows as $row)
				<tr>
					<td>{{ $row }}</td>
					@foreach($columns as $column)
						<td>{{ $counts[$column][$row] }}</td>
					@endforeach
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
</body>
</html>