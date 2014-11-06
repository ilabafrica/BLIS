@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="active">{{Lang::choice('messages.instrument',2)}}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-cog"></span>
		{{trans('messages.list-instruments')}}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::route('instrument.create') }}" >
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{trans('messages.new-instrument')}}
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>{{Lang::choice('messages.name',1)}}</th>
					<th>{{trans('messages.ip')}}</th>
					<th>{{trans('messages.host-name')}}</th>
					<th>{{trans('messages.actions')}}</th>
				</tr>
			</thead>
			<tbody>
			@foreach($instruments as $key => $value)
				<tr>
					<td>{{ $value->name }}</td>
					<td>{{ $value->ip }}</td>
					<td>{{ $value->hostname }}</td>

					<td>

						<!-- show the instrument details -->
						<a class="btn btn-sm btn-success" href="{{ URL::route('instrument.show', array($value->id)) }}">
							<span class="glyphicon glyphicon-eye-open"></span>
							{{trans('messages.view')}}
						</a>

						<!-- edit this instrument  -->
						<a class="btn btn-sm btn-info" href="{{ URL::route('instrument.edit', array($value->id)) }}" >
							<span class="glyphicon glyphicon-edit"></span>
							{{trans('messages.edit')}}
						</a>
						<!-- delete this instrument -->
						<button class="btn btn-sm btn-danger delete-item-link"
							data-toggle="modal" data-target=".confirm-delete-modal"	
							data-id="{{ URL::route('instrument.delete', array($value->id)) }}">
							<span class="glyphicon glyphicon-trash"></span>
							{{trans('messages.delete')}}
						</button>

					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<?php echo $instruments->links(); ?>
	</div>
</div>
@stop