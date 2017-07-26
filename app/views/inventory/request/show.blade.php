@extends("layout")
@section("content")

@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif

	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		  <li><a href="{{{URL::route('request.index')}}}">{{ Lang::choice('messages.request', 2) }}</a></li>
		  <li class="active">{{ Lang::choice('messages.request', 1).' '.trans('messages.details') }}</li>
		</ol>
	</div>
	<div class="panel panel-primary ">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-adjust"></span>
			{{ Lang::choice('messages.request', 1).' '.trans('messages.details') }}
			<div class="panel-btn hide">
				<a class="btn btn-sm btn-info" href="{{ URL::route('request.edit', array($request->id)) }}">
					<span class="glyphicon glyphicon-edit"></span>
					{{ trans('messages.edit') }}
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3 class="view"><strong>{{ Lang::choice('messages.item', 1) }}:</strong>{{ $request->item->name }} </h3>
				<p class="view-striped"><strong>{{ Lang::choice('messages.test-category', 1) }}:</strong>
					{{ $request->testCategory->name }}</p>
				<p class="view-striped"><strong>{{ trans('messages.quantity') }} {{ trans('messages.requested') }}:</strong>
					{{ $request->quantity_ordered }}</p>
				<p class="view-striped"><strong>{{ trans('messages.requested-by') }}:</strong>
					{{ $request->user->name }}</p>
				<p class="view-striped"><strong>{{ trans('messages.quantity-remaining') }}:</strong>
					{{ $request->quantity_remaining }}</p>
				<p class="view-striped"><strong>{{ trans('messages.tests-done') }}:</strong>
					{{ $request->tests_done }}</p>
				<p class="view-striped"><strong>{{ trans('messages.remarks') }}:</strong>
					{{ $request->remarks }}</p>
			</div>
		</div>
	</div>
@stop