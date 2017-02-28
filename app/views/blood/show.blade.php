@extends("layout")
@section("content")

@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif

	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		  <li><a href="{{ URL::route('blood.index') }}">{{ trans('messages.blood-bank') }}</a></li>
		  <li class="active">{{ trans('messages.blood-details') }}</li>
		</ol>
	</div>
	<div class="panel panel-primary ">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-adjust"></span>
			{{ trans('messages.blood-details') }}
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::route('blood.edit', array($bb->id)) }}">
					<span class="glyphicon glyphicon-edit"></span>
					{{ trans('messages.edit') }}
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h4 class="view"><strong>{{ trans('messages.bag-number') }}:</strong>{{ $bb->bag_number }} </h4>
				<p class="view-striped"><strong>{{ trans('messages.blood-group') }}:</strong>
					{{ $bb->bldgrp($bb->blood_group) }}</p>
				<p class="view-striped"><strong>{{ trans('messages.volume') }}:</strong>
					{{ $bb->volume }}</p>
				<p class="view-striped"><strong>{{ trans('messages.date-collected') }}:</strong>
					{{ $bb->date_collected }}</p>
				<p class="view-striped"><strong>{{ trans('messages.expiry') }}:</strong>
					{{ $bb->expiry_date }}</p>
				
			</div>
		</div>
	</div>
@stop