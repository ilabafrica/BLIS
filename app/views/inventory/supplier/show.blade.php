@extends("layout")
@section("content")

@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif

	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		  <li><a href="{{{URL::route('supplier.index')}}}">{{ Lang::choice('messages.supplier', 2) }}</a></li>
		  <li class="active">{{ trans('messages.supplier').' '.trans('messages.details') }}</li>
		</ol>
	</div>
	<div class="panel panel-primary ">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-adjust"></span>
			{{ trans('messages.supplier').' '.trans('messages.details') }}
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::route('supplier.edit', array($supplier->id)) }}">
					<span class="glyphicon glyphicon-edit"></span>
					{{ trans('messages.edit') }}
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3 class="view"><strong>{{ Lang::choice('messages.name', 1) }}:</strong>{{ $supplier->name }} </h3>
				<p class="view-striped"><strong>{{ trans('messages.phone') }}:</strong>
					{{ $drug->phone }}</p>
				<p class="view-striped"><strong>{{ trans('messages.email') }}:</strong>
					{{ $drug->email }}</p>
				<p class="view-striped"><strong>{{ trans('messages.address') }}:</strong>
					{{ $drug->address }}</p>
				
			</div>
		</div>
	</div>
@stop