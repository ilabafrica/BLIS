@extends("layout")
@section("content")

@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif

	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
      	  <li><a href="{{{URL::route('item.index')}}}">{{ Lang::choice('messages.item', 2) }}</a></li>
		  <li><a href="{{{URL::route('stocks.log',array($stock->item->id))}}}">{{ Lang::choice('messages.stock', 2) }}</a></li>
		  <li class="active">{{ Lang::choice('messages.lot', 1).' '.trans('messages.details') }}</li>
		</ol>
	</div>
	<div class="panel panel-primary ">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-adjust"></span>
			{{ Lang::choice('messages.stock', 1).' '.trans('messages.details') }}
			@if(Entrust::hasRole(Role::getAdminRole()->name))
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::route('stock.edit', array($stock->id)) }}">
					<span class="glyphicon glyphicon-plus-sign"></span>
					{{ trans('messages.edit')}} {{Lang::choice('messages.stock', 1) }}
				</a>
			</div>
			@endif
		</div>
		<div class="panel-body">
			<div class="col-md-12">
				<ul class="list-group" style="padding-bottom:5px;">
				  	<li class="list-group-item"><strong>{{ $stock->item->name }}</strong></li>
				  	<li class="list-group-item">
			  			<strong style="min-width: 150px;display: inline-block;">
			  				{{ trans("messages.lot-no").': ' }}
			  			</strong>
			  			{{ $stock->lot }}<br />
			  			<strong style="min-width: 150px;display: inline-block;">
			  				{{ trans("messages.available-qty").': ' }}
			  			</strong>
			  			{{ $stock->quantity() }}<br />
			  			<strong style="min-width: 150px;display: inline-block;">
			  				{{ trans("messages.min-level").': ' }}
			  			</strong>
			  			{{ $stock->item->min_level }}<br />
			  			<strong style="min-width: 150px;display: inline-block;">
			  				{{ trans("messages.max-level").': ' }}
			  			</strong>
			  			{{ $stock->item->max_level }}<br />
			  			<strong style="min-width: 150px;display: inline-block;">
			  				{{ trans("messages.batch-no").': ' }}
			  			</strong>
			  			{{ $stock->batch_no }}<br />
			  			<strong style="min-width: 150px;display: inline-block;">
			  				{{ trans("messages.manufacturer").': ' }}
			  			</strong>
			  			{{ $stock->manufacturer }}<br />
			  			<strong style="min-width: 150px;display: inline-block;">
			  				{{ Lang::choice("messages.supplier",1).': ' }}
			  			</strong>
			  			{{ $stock->supplier->name }}<br />
			  			<strong style="min-width: 150px;display: inline-block;">
			  				{{ trans("messages.supplied").': ' }}
			  			</strong>
			  			{{ $stock->quantity_supplied }}<br />
			  			<strong style="min-width: 150px;display: inline-block;">
			  				{{ trans("messages.cost-per-unit").': ' }}
			  			</strong>
			  			{{ $stock->cost_per_unit }}<br />
			  			<strong style="min-width: 150px;display: inline-block;">
			  				{{ trans("messages.expiry").': ' }}
			  			</strong>
			  			{{ $stock->expiry_date }}<br />
			  			<strong style="min-width: 150px;display: inline-block;">
			  				{{ trans("messages.date-received").': ' }}
			  			</strong>
			  			{{ $stock->created_at }}<br />
			  			<strong style="min-width: 150px;display: inline-block;">
			  				{{ trans("messages.remarks").': ' }}
			  			</strong>
			  			{{ $stock->remarks }}<br />
				  	</li>
				</ul>
			</div>
			<div class="col-md-12">
				<table class="table table-striped table-hover table-condensed search-table">
					<thead>
						<tr>
							<th>{{ trans('messages.quantity') }} {{ trans('messages.issued') }}</th>
							<th>{{ trans('messages.date-of-usage') }}</th>
							<th>{{ trans('messages.destination') }}</th>
							<th>{{ trans('messages.issued-by') }}</th>
							<th>{{ trans('messages.received-by') }}</th>
							<th>{{ trans('messages.remarks') }}</th>
							<th class="hide">{{ trans('messages.actions') }}</th>
						</tr>
					</thead>
					<tbody>
					@foreach($stock->usage as $key => $value)
						<tr @if(Session::has('activeusage'))
		                            {{(Session::get('activeusage') == $value->id)?"class='info'":""}}
		                        @endif
		                    >
							<td>{{ $value->quantity_used }}</td>
							<td>{{ $value->date_of_usage }}</td>
							<td>{{ $value->request->testCategory->name }}</td>
							<td>{{ $value->issued_by }}</td>
							<td>{{ $value->received_by }}</td>
							<td>{{ $value->remarks }}</td>
		                 	
							<td class="hide">
								<a class="btn btn-sm btn-info" href="{{ URL::to("stock/" . $value->id . "/lot") }}" >
										<span class="glyphicon glyphicon-edit"></span>
										{{ trans('messages.edit') }}
								</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	{{ Session::put('SOURCE_URL', URL::full()) }}
@stop