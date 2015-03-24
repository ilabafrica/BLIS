@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.report',2) }}</li>
	  <li class="active">{{ trans('messages.stock-level-report') }}</li>
	</ol>
</div>

{{ Form::open(array('route' => array('reports.inventory'), 'class' => 'form-inline', 'role' => 'form')) }}

<div class='container-fluid'>
	<div class="row">
		<div class="col-md-4"><!-- From Datepicker-->
	    	<div class="row">
				<div class="col-md-2">
					{{ Form::label('start', trans("messages.from")) }}
				</div>
				<div class="col-md-10">
					{{ Form::text('start', isset($input['start'])?$input['start']:date('Y-m-d'), 
				        array('class' => 'form-control standard-datepicker')) }}
			    </div>
	    	</div><!-- /.row -->
	    </div>
	    <div class="col-md-4"><!-- To Datepicker-->
	    	<div class="row">
				<div class="col-md-4">
			    	{{ Form::label('end', trans("messages.to")) }}
			    </div>
				<div class="col-md-8">
				    {{ Form::text('end', isset($input['end'])?$input['end']:date('Y-m-d'), 
				        array('class' => 'form-control standard-datepicker')) }}
		        </div>
	    	</div><!-- /.row -->
	    </div>
	    
    </div><!-- /.row -->
    <br />
	<div class="row">
          <div class="col-md-4">
	    	<div class="row">
		        <div class="col-md-4">
		        	{{ Form::label('report_type', Lang::choice('messages.report-type',1)) }}
		        </div>
		        <div class="col-md-8">
		            {{ Form::select('report_type', $reportTypes,
		            	isset($input['report_type'])?$input['report_type']:0, array('class' => 'form-control')) }}
		        </div>
	        </div>
	    </div>
	    <div class="col-md-4">
	    <div class="row">
	    <div class="col-md-8">
		    {{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
		        array('class' => 'btn btn-info', 'id' => 'filter', 'type' => 'submit')) }}
		        </div>
		        </div>
        </div>  
	</div><!-- /.row -->
</div><!-- /.container-fluid -->

{{ Form::close() }}

<br />

<div class="panel panel-primary">

	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.stock-level-report') }}
	</div>

	<div class="panel-body">
		@if (Session::has('message'))
			<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
		@endif	

		<div class="table-responsive">
			<div><strong>{{$reportTitle}}</strong></div><br />
			<table class="table table-striped table-hover table-condensed search-table">
				@if($selectedReport==0) <!-- monthly Report-->
					<thead>
						<tr>
							<th></th>
							<th>{{Lang::choice('messages.commodity',1)}}</th>
							<th>{{Lang::choice('messages.supplier',1)}}</th>
							<th>{{Lang::choice('messages.batch-no',1)}}</th>
							<th>{{Lang::choice('messages.quantity',1)}}</th>
							<th>{{Lang::choice('messages.expiry-date',1)}}</th>
							<th>{{Lang::choice('messages.qty-issued',1)}}</th>
							<th>{{Lang::choice('messages.current-bal',1)}}</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 1;?>
						@forelse($reportData as $row)
						
						
							<tr>
								<td>{{$i++}}</td>
								<td>{{Commodity::find($row->commodity_id)->name}}</td>
								<td>{{Supplier::find($row->supplier_id)->name}}</td>
								<td>{{$row->batch_no }}</td>
								<td>{{$row->quantity}}</td>
								<td>{{$row->expiry_date}}</td>
								<td>{{$row->quantity_issued}}</td>
								<td>{{$row->quantity-$row->quantity_issued}}</td>
							</tr>
						@empty
							<tr>
								<td>{{Lang::choice('messages.no-data-found',1)}}</td>
							</tr>
						@endforelse

					</tbody>

				@elseif($selectedReport == 1) <!-- quarterly Report-->
					<thead>
						<tr>
							<th></th>
							<th>{{Lang::choice('messages.commodity',1)}}</th>
							<th>{{Lang::choice('messages.supplier',1)}}</th>
							<th>{{Lang::choice('messages.batch-no',1)}}</th>
							<th>{{Lang::choice('messages.quantity',1)}}</th>
							<th>{{Lang::choice('messages.expiry-date',1)}}</th>
							<th>{{Lang::choice('messages.qty-issued',1)}}</th>
							<th>{{Lang::choice('messages.current-bal',1)}}</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 1;?>
						@forelse($reportData as $row)
							
							<tr>
								<td>{{$i++}}</td>
								<td>{{Commodity::find($row->commodity_id)->name}}</td>
								<td>{{Supplier::find($row->supplier_id)->name}}</td>
								<td>{{$row->batch_no }}</td>
								<td>{{$row->quantity}}</td>
								<td>{{$row->expiry_date}}</td>
								<td>{{$row->quantity_issued}}</td>
								<td>{{$row->quantity-$row->quantity_issued}}</td>
							</tr>
						@empty
							<tr>
								<td colspan='6'>{{Lang::choice('messages.no-data-found',1)}}</td>
							</tr>
						@endforelse
					</tbody>
				@endif

			</table>
		</div><!--/.table-responsive -->
	</div>
</div><!--/.panel -->

@stop