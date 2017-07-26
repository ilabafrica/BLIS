@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.report',2) }}</li>
	  <li class="active">{{ trans('messages.stock-usage') }}</li>
	</ol>
</div>

{{ Form::open(array('route' => array('reports.inventoryusage'), 'class' => 'form-inline', 'role' => 'form')) }}
	{{ Form::hidden('search_item_id', '', array('id' => 'search_item_id')) }}

<div class='container-fluid'>
	<div class="row">
		<div class="col-md-3"><!-- From Datepicker-->
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
	    <div class="col-md-3"><!-- To Datepicker-->
	    	<div class="row">
				<div class="col-md-2">
			    	{{ Form::label('end', trans("messages.to")) }}
			    </div>
				<div class="col-md-10">
				    {{ Form::text('end', isset($input['end'])?$input['end']:date('Y-m-d'), 
				        array('class' => 'form-control standard-datepicker')) }}
		        </div>
	    	</div>
	    </div>
	     <div class="col-md-4"><!-- Select type of item -->
	    	<div class="row">
		        <div class="col-md-2">
		        	{{ Form::label('item', Lang::choice('messages.item',1)) }}
		        </div>
		        <div class="col-md-10">
		             {{ Form::text('search_item', '', array('class' => 'form-control', 'id' => 'search_item', 'placeholder' => 'Search Item'))}}
		        </div>
	        </div>
	    </div>	
	    <div class="col-md-2"> <!--View Button -->
    		{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'),
    		array('class' => 'btn btn-info', 'id' => 'filter', 'type' => 'submit')) }}
     	</div>   
    </div><!-- /.row -->
   
</div><!-- /.container-fluid -->

{{ Form::close() }}

<br/>

<div class="panel panel-primary">

	<div class="panel-heading ">
		<span class="glyphicon glyphicon-notes"></span>
		{{ trans('messages.stock-usage') }}
	</div>

	<div class="panel-body">
		@if (Session::has('message'))
			<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
		@endif	

		<div class="table-responsive">
			<table class="table table-striped table-hover table-condensed search-table">
				
					<thead>
						<tr>
							<th>No.</th>							
							<th>{{Lang::choice('messages.item',1)}}</th>
							<th>{{Lang::choice('messages.supplier',1)}}</th>
							<th>{{Lang::choice('messages.date-of-usage',1)}}</th>
							<th>{{Lang::choice('messages.signed-out',1)}}</th>
							<th>{{Lang::choice('messages.available-qty',1)}}</th>
							<th>{{Lang::choice('messages.issued-by',1)}}</th>
							<th>{{Lang::choice('messages.received-by',1)}}</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 1; 
						if (!empty($reportData)){?>
						@foreach($reportData as $row)
						<tr>
							<td>{{$i++}}</td>							
							<td>{{$row->stock->item->name}}</td>
							<td>{{$row->stock->supplier->name}}</td>
							<td>{{$row->date_of_usage}}</td>
							<td>{{$row->quantity_used}}</td>
							<td>{{$row->stock->item->quantity()}}</td>
							<td>{{$row->issued_by}}</td>
							<td>{{$row->received_by}}</td>
						@endforeach

						<?php } else {?>
							<tr>
								<td>{{Lang::choice('messages.no-data-found',1)}}</td>
							</tr>
						
							<?php } ?>
					</tbody>

				

			</table>
		</div><!--/.table-responsive -->
	</div>
</div><!--/.panel -->

@stop