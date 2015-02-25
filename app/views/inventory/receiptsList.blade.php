@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{{URL::route('inventory.labStockCard')}}}">{{trans('messages.inventory')}}</a></li>
	  <li class="active">{{ Lang::choice('messages.labStockCardReceipts',2) }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{trans('messages.receiptsList')}}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::route('inventory.receipts') }}">
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{trans('messages.labStockCardReceipts')}}
			</a>
			
		</div>
	</div>
	<div class="panel-body">
		
<table class="table table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>{{Lang::choice('messages.lab-receipt-date',1)}}</th>
					<th>{{Lang::choice('messages.commodity',1)}}</th>
					<th>{{Lang::choice('messages.unit-of-issue',1)}}</th>
					<th>{{Lang::choice('messages.received-from',1)}}</th>
					<th>{{Lang::choice('messages.doc-no',1)}}</th>
					<th>{{Lang::choice('messages.qty',1)}}</th>
					<th>{{Lang::choice('messages.batch-no',1)}}</th>
					<th>{{Lang::choice('messages.expiry-date',1)}}</th>
					<th>{{Lang::choice('messages.location',1)}}</th>
					<th>{{Lang::choice('messages.receivers-name',1)}}</th>
					<th>{{trans('messages.actions')}}</th>
					
				</tr>
			</thead>
			<tbody>
			@foreach($commodities as $key => $value)
			<tr @if(Session::has('activecommodity'))
            {{(Session::get('activecommodity') == $value->id)?"class='info'":""}}
                        @endif
                        >
				<tr>
                 	<td>{{ $value->receipt_date}}</td>
					<td>{{ $value->commodity }}</td>
					<td>{{ $value->unit_of_issue}}</td>
					<td>{{ $value->received_from }}</td>
					<td>{{ $value->doc_no }}</td>
					<td>{{ $value->qty }}</td>
					<td>{{ $value->batch_no }}</td>
					<td>{{ $value->expiry_date }}</td>
					<td>{{ $value->location}}</td>
					<td>{{ $value->receivers_name}}</td>
					<td> 
						<!-- edit this commodity (uses the edit method found at GET /inventory/{id}/edit -->
					<a class="btn btn-sm btn-info" href="{{ URL::route('inventory.editReceipts', array($value->id)) }}" >
							<span class="glyphicon glyphicon-edit"></span>
							{{trans('messages.edit')}}
					</a>
						<!-- delete this commodity (uses the delete method found at GET /inventory/{id}/delete -->
					<button class="btn btn-sm btn-danger delete-item-link" 
							data-toggle="modal" data-target=".confirm-delete-modal"	
							data-id="{{ URL::route('inventory.deleteReceipts', array($value->id)) }}">
							<span class="glyphicon glyphicon-trash"></span>
							{{trans('messages.delete')}}
					</button>



					</td>

				</tr>
				@endforeach
			</tbody>
			</table>

		<?php  
		Session::put('SOURCE_URL', URL::full());?>
	</div>
	
</div>
@stop