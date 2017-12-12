@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.request', 2) }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-shopping-cart"></span>
		{{ Lang::choice('messages.inventory', 1) }} {{ Lang::choice('messages.request', 2) }}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::route('request.create') }}">
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{trans('messages.new')}} {{ Lang::choice('messages.item',1)}} {{Lang::choice('messages.request', 1) }}
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed search-table">
			<thead>
				<tr>
					<th>{{ trans('messages.date') }}</th>
					<th>{{ trans('messages.requested-by') }}</th>
					<th>{{ Lang::choice('messages.item', 1) }}</th>
					<th>{{ trans('messages.quantity') }} {{ trans('messages.requested') }}</th>
					<th>{{ trans('messages.quantity') }} {{ trans('messages.issued') }}</th>
					<th>{{ trans('messages.actions') }}</th>
				</tr>
			</thead>
			<tbody>
			@foreach($requests as $key => $value)
				<tr @if(Session::has('activerequest'))
                        {{(Session::get('activerequest') == $value->id)?"class='info'":""}}
                    @endif
                    >
                 	<td>{{ $value->created_at }}</td>
                 	<td>{{ $value->user->name }}</td>
                 	<td>
                 		{{ $value->item->name }}
                 		@if(!$value->usage->first())
                 			<span class="label label-default">{{ trans('messages.not-issued') }}</span>
                 		@else 
                 			<span class="label label-success"> {{trans('messages.issued')}} </span>
                 		@endif
                 	</td>
                 	<td style="text-align: center;">{{ $value->quantity_ordered }}</td>
                 	<td style="text-align: center;">{{ $value->issued() }}</td>
					<td>
					<!-- show the request (uses the show method found at GET /request/{id} -->
						<a class="btn btn-sm btn-success" href='{{ URL::to("request/" . $value->id) }}' title="{{ trans('messages.view') }}">
							<span class="glyphicon glyphicon-eye-open"></span>
							{{ trans('messages.view') }}
						</a> 
						@if(!$value->usage->first())
						<!-- edit this commodity (uses the edit method found at GET /inventory/{id}/edit -->
						<a class="btn btn-sm btn-info" href="{{ URL::route('request.edit', array($value->id)) }}" title="{{ trans('messages.edit') }}">
								<span class="glyphicon glyphicon-edit"></span>
								{{ trans('messages.edit') }}
						</a>

						<!-- Update dtock button -->
					    <a class="btn btn-sm btn-sun-flower hide" href='{{ URL::to("stock/" . $value->id."/usage") }}' title="{{ trans('messages.update-stock') }}">
							<span class="glyphicon glyphicon-info-sign"></span>
							{{ trans('messages.update-stock') }}
						</a>
							<!-- delete this commodity (uses the delete method found at GET /inventory/{id}/delete -->
						<button class="btn btn-sm btn-danger delete-item-link" 
								data-toggle="modal" data-target=".confirm-delete-modal"	
								data-id="{{ URL::route('request.delete', array($value->id)) }}" title="{{ trans('messages.delete') }}">
								<span class="glyphicon glyphicon-trash"></span>
								{{ trans('messages.delete') }}
						</button>
                 		@endif
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		{{ Session::put('SOURCE_URL', URL::full()) }}
	</div>
</div>
@stop