@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.report',2) }}</li>
	  <li class="active">{{ Lang::choice('messages.stock', 1) }} {{ Lang::choice('messages.count', 1) }}</li>
	</ol>
</div>


{{ Form::open(array('route' => array('reports.stockcount'), 'class' => 'form-inline', 'role' => 'form')) }}

<div class='container-fluid'>
	<div class="row">
		<div class="col-md-6"><!-- From Datepicker-->
	    	<div class="row">
				<div class="col-md-3">
					{{ Form::label('the_date', trans("messages.from")) }}
				</div>
				<div class="col-md-7">
					{{ Form::text('the_date', isset($input['the_date'])?$input['the_date']:date('Y-m-d'), 
				        array('class' => 'form-control standard-datepicker')) }}
			    </div>
			    <div class="col-md-2"> <!--View Button -->
		    		{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'),
		    		array('class' => 'btn btn-info', 'id' => 'filter', 'type' => 'submit')) }}
		     	</div>  
	    	</div><!-- /.row -->
	    </div>
    </div>
</div>
{{ Form::close() }}

<div class="panel panel-primary">

	<div class="panel-heading ">
		<span class="glyphicon glyphicon-notes"></span>
		{{ Lang::choice('messages.stock', 1) }} {{ Lang::choice('messages.count', 1) }} {{ Lang::choice('messages.report', 1) }} {{$reportTitle}}
	</div>

	<div class="panel-body">
		@if (Session::has('message'))
			<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
		@endif

		<div class="table-responsive">
			<table class="table table-striped table-hover table-condensed search-table">
				<thead>
					<tr>
						<th></th>
						<th>{{Lang::choice('messages.item',1)}}</th>
						<th>{{Lang::choice('messages.supplied',1)}}</th>
						<th>{{trans('messages.quantity')}} {{Lang::choice('messages.issued',1)}}</th>
						<th>{{Lang::choice('messages.balance',1)}}</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1;?> 
					@if (!empty($reportData)){
						@foreach($reportData as $row)
						<tr>
							<td>{{$i++}}</td>							
							<td>
								{{$row->name}}
								@if(intVal($row->quantity_supplied) - intVal($row->quantity_used) < 0)
									<span class="alert-danger" title="The quantity supplied is greater than that issued!">
										<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
										<span class="sr-only">Error:</span>
									</span>
								@endif
							</td>
							<td style="text-align: center;">{{$row->quantity_supplied}}</td>
							<td style="text-align: center;">{{$row->quantity_used}}</td>
							<td style="text-align: center;">
								{{intVal($row->quantity_supplied) - intVal($row->quantity_used)}}
							</td></tr>
						@endforeach
					@else
						<tr>
							<td>{{Lang::choice('messages.no-data-found',1)}}</td>
						</tr>
					
					@endif
				</tbody>
			</table>
		</div><!--/.table-responsive -->
	</div>
</div><!--/.panel -->

@stop