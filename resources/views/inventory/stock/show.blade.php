@extends("layout")
@section("content")

@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif

	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		  <li><a href="{{{URL::route('stock.index')}}}">{{ trans_choice('messages.stock', 2) }}</a></li>
		  <li class="active">{{ trans_choice('messages.lot', 1).' '.trans('messages.details') }}</li>
		</ol>
	</div>
	<div class="panel panel-primary ">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-adjust"></span>
			{{ trans_choice('messages.stock', 1).' '.trans('messages.details') }}
		</div>
		<div class="panel-body">
			<div class="col-md-12">
				<ul class="list-group" style="padding-bottom:5px;">
				  	<li class="list-group-item"><strong>{{ $stock->item->name }}</strong></li>
				  	<li class="list-group-item">
				  		<h5>
				  			<span><strong>{{ trans("messages.lot-no").': ' }}</strong> {{ $stock->lot }}</span>
				  			<span><strong>{{ trans("messages.available-qty").': ' }}</strong> {{ $stock->quantity() }}</span>
				  			<span><strong>{{ trans("messages.min-level").': ' }}</strong> {{ $stock->item->min_level }}</span>
				  			<span><strong>{{ trans("messages.max-level").': ' }}</strong> {{ $stock->item->max_level }}</span>
				  		</h5>
				  	</li>
				</ul>
			</div>
			<div class="col-md-12">
				<table class="table table-striped table-hover table-condensed search-table">
					<thead>
						<tr>
							<th>{{ trans('messages.id') }}</th>
							<th>{{ trans('messages.signed-out') }}</th>
							<th>{{ trans('messages.date-of-usage') }}</th>
							<th>{{ trans('messages.destination') }}</th>
							<th>{{ trans('messages.issued-by') }}</th>
							<th>{{ trans('messages.received-by') }}</th>
							<th>{{ trans('messages.remarks') }}</th>
							<th>{{ trans('messages.actions') }}</th>
						</tr>
					</thead>
					<tbody>
					@foreach($stock->usage as $key => $value)
						<tr @if(Session::has('activeusage'))
		                            {{(Session::get('activeusage') == $value->id)?"class='info'":""}}
		                        @endif
		                    >
		                 	<td>{{ $value->id }}</td>
							<td>{{ $value->quantity_used }}</td>
							<td>{{ $value->date_of_usage }}</td>
							<td>{{ $value->request->testCategory->name }}</td>
							<td>{{ $value->issued_by }}</td>
							<td>{{ $value->received_by }}</td>
							<td>{{ $value->remarks }}</td>
		                 	
							<td>
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