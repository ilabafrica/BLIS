@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active"><a href="{{ URL::route('reports.patient.index') }}">{{ Lang::choice('messages.report', 2) }}</a></li>
	  <li class="active">{{ trans('messages.daily-log') }}</li>
	</ol>
</div>
<div class='container-fluid'>
</div>
<br />
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.daily-log') }} - {{ trans('messages.rejected-specimen') }}
	</div>
	<div class="panel-body">
		<!-- if there are search errors, they will show here -->
		

		<div id="specimen_records_div">
		  @include("reportHeader")
			<strong>
				<p>
				</p>
			</strong>
			<table class="table table-bordered">
				<tbody>
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
		</div> <!-- /#specimen_records_div -->
	</div> <!-- /.panel-body -->
</div> <!-- /.panel -->
@stop