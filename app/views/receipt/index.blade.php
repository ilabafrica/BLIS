@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{{URL::route('receipt.index')}}}">{{trans('messages.inventory')}}</a></li>
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
			<a class="btn btn-sm btn-info" href="{{ URL::route('receipt.create') }}">
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
					<th>{{Lang::choice('messages.received-from',1)}}</th>
					<th>{{Lang::choice('messages.unit-price',1)}}</th>
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
			@foreach($receipts as $key => $receipt)
			<tr class='info'>
				<tr>
					<td>{{ $receipt->receipt_date}}</td>
					<td>{{ $receipt->commodity->name }}</td>
					<td>{{ $receipt->supplier->name }}</td>
					<td>{{ $receipt->unit_price}} </td>
					<td>{{ $receipt->doc_no }}</td>
					<td>{{ $receipt->qty }}</td>
					<td>{{ $receipt->batch_no }}</td>
					<td>{{ $receipt->expiry_date }}</td>
					<td>{{ $receipt->location}}</td>
					<td>{{ $receipt->receivers_name}}</td>
					<td> 
						<!-- edit this commodity (uses the edit method found at GET /inventory/{id}/edit -->
					<a class="btn btn-sm btn-info" href="{{ URL::route('receipt', array($receipt->id)) }}" >
							<span class="glyphicon glyphicon-edit"></span>
							{{trans('messages.edit')}}
					</a>
						<!-- delete this commodity (uses the delete method found at GET /inventory/{id}/delete -->
					<button class="btn btn-sm btn-danger delete-item-link" 
							data-toggle="modal" data-target=".confirm-delete-modal"	
							data-id="{{ URL::route('receipt.delete', array($receipt->id)) }}">
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