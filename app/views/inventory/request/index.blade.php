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
		<span class="glyphicon glyphicon-user"></span>
		{{ Lang::choice('messages.request', 2) }}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::route('request.create') }}">
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{ trans('messages.add').' '.Lang::choice('messages.request', 1) }}
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed search-table">
			<thead>
				<tr>
					<th>{{ Lang::choice('messages.item', 1) }}</th>
					<th>{{ trans('messages.quantity-remaining') }}</th>
					<th>{{ Lang::choice('messages.test-category', 1) }}</th>
					<th>{{ trans('messages.tests-done') }}</th>
					<th>{{ trans('messages.order-quantity') }}</th>
					<th>{{ trans('messages.status') }}</th>
					<th>{{ trans('messages.remarks') }}</th>
					<th>{{ trans('messages.actions') }}</th>
				</tr>
			</thead>
			<tbody>
			@foreach($requests as $key => $value)
				<tr @if(Session::has('activerequest'))
                            {{(Session::get('activerequest') == $value->id)?"class='info'":""}}
                        @endif
                    >
                 	<td>{{ $value->item->name }}</td>
                 	<td>{{ $value->quantity_remaining }}</td>
                 	<td>{{ $value->testCategory->name }}</td>
                 	<td>{{ $value->tests_done }}</td>
                 	<td>{{ $value->quantity_ordered }}</td>
                 	<td>@if(!$value->usage->first())<span class="label label-default">{{ trans('messages.not-issued') }}</span>@else <button class="btn btn-success btn-sm" type="button"> {{ trans('messages.issued') }} <span class="badge">{{ $value->issued() }}</span></button> @endif</td>
                 	<td>{{ $value->remarks }}</td>
                 	
					<td>
					<!-- show the request (uses the show method found at GET /request/{id} -->
						<a class="btn btn-sm btn-success" href="{{ URL::to("request/" . $value->id) }}" >
							<span class="glyphicon glyphicon-eye-open"></span>
							{{ trans('messages.view') }}
						</a> 
					<!-- edit this commodity (uses the edit method found at GET /inventory/{id}/edit -->
					<a class="btn btn-sm btn-info" href="{{ URL::route('request.edit', array($value->id)) }}" >
							<span class="glyphicon glyphicon-edit"></span>
							{{ trans('messages.edit') }}
					</a>

					<!-- Update dtock button -->
				    <a class="btn btn-sm btn-sun-flower" style="display:none;" href="{{ URL::to("stock/" . $value->id."/usage") }}" >
						<span class="glyphicon glyphicon-info-sign"></span>
						{{ trans('messages.update-stock') }}
					</a>
						<!-- delete this commodity (uses the delete method found at GET /inventory/{id}/delete -->
					<button class="btn btn-sm btn-danger delete-item-link" 
							data-toggle="modal" data-target=".confirm-delete-modal"	
							data-id="{{ URL::route('request.delete', array($value->id)) }}">
							<span class="glyphicon glyphicon-trash"></span>
							{{ trans('messages.delete') }}
					</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		{{ Session::put('SOURCE_URL', URL::full()) }}
	</div>
</div>
@stop