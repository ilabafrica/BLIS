@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="active">{{ Lang::choice('messages.labStockCard',2) }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{trans('messages.inventory-list')}}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::route('inventory.receiptsList') }}">
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{trans('messages.labStockCardReceipts')}}
			</a>
			<a class="btn btn-sm btn-info" href="{{ URL::route('inventory.issuesList') }}">
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{trans('messages.labStockCardIssues')}}
			</a>
		</div>
	</div>
	<div class="panel-body">
		
<table class="table table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>{{Lang::choice('messages.lab-receipt-date',1)}}</th>
					<th>{{Lang::choice('messages.commodity',1)}}</th>
					<th>{{Lang::choice('messages.unit-price',1)}}</th>
					<th>{{Lang::choice('messages.batch-no',1)}}</th>
					<th>{{Lang::choice('messages.expiry-date',1)}}</th>
					<th>{{Lang::choice('messages.qty',1)}}</th>
					<th>{{Lang::choice('messages.stock-bal',1)}}</th>

					
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
					<td>{{ Commodity::find($value->commodity_id)->commodity }}</td>
					<td>{{ $value->unit_price}}</td>
					<td>{{ $value->batch_no }}</td>
					<td>{{ $value->expiry_date }}</td>
					<td>{{ $value->qty }}</td>
					<td>0</td>
				</tr>
				@endforeach
			</tbody>
			</table>

		<?php  
		Session::put('SOURCE_URL', URL::full());?>
	</div>
	
</div>
@stop