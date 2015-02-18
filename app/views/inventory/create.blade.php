@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="active">{{ Lang::choice('messages.inventory',2) }}</li>
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
			<a class="btn btn-sm btn-info" href="{{ URL::route('inventory.create') }}">
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{trans('messages.new-inventory')}}
			</a>
		</div>
	</div>
	<div class="panel-body">
		
		<?php  
		Session::put('SOURCE_URL', URL::full());?>
	</div>
	
</div>
@stop