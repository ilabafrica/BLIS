@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	 
	  <li class="active">{{ Lang::choice('messages.commodityList',2) }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{trans('messages.commodityList')}}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::route('commodity.create') }}">
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{trans('messages.commodity')}}
			</a>
			
		</div>
	</div>
	<div class="panel-body">
		
<table class="table table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>{{Lang::choice('messages.commodity',1)}}</th>
					<th>{{Lang::choice('messages.description',1)}}</th>
					<th>{{Lang::choice('messages.unit-of-issue',1)}}</th>
					<th>{{Lang::choice('messages.unit-price',1)}}</th>
					<th>{{Lang::choice('messages.item-code',1)}}</th>
					<th>{{Lang::choice('messages.storage-req',1)}}</th>
					<th>{{Lang::choice('messages.min-level',1)}}</th>
					<th>{{Lang::choice('messages.max-level',1)}}</th>
					<th>{{trans('messages.actions')}}</th>
					
				</tr>
			</thead>
			<tbody>
			@foreach($commodity as $key => $value)

				<tr>
                 	<td>{{ $value->commodity}}</td>
                 	<td>{{ $value->description}}</td>
                 	<td>{{ Metrics::find($value->unit_of_issue)->name }}</td>
                 	<td>{{ $value->unit_price}}</td>
					<td>{{ $value->item_code }}</td>
					<td>{{ $value->storage_req }}</td>
					<td>{{ $value->min_level}}</td>
					<td>{{ $value->max_level }}</td>
					<td> 
					<!-- edit this commodity (uses the edit method found at GET /inventory/{id}/edit -->
					<a class="btn btn-sm btn-info" href="{{ URL::route('commodity.edit', array($value->id)) }}" >
							<span class="glyphicon glyphicon-edit"></span>
							{{trans('messages.edit')}}
					</a>
						<!-- delete this commodity (uses the delete method found at GET /inventory/{id}/delete -->
					<button class="btn btn-sm btn-danger delete-item-link" 
							data-toggle="modal" data-target=".confirm-delete-modal"	
							data-id="{{ URL::route('commodity.index', array($value->id)) }}">
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