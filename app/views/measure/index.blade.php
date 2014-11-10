@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		  <li class="active">{{ trans('messages.measure') }}</li>
		</ol>
	</div>
	@if (Session::has('message'))
		<div class="alert alert-info">{{ Session::get('message') }}</div>
	@endif
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			{{trans('messages.list-measures')}}
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::to('measure/create') }}">
					<span class="glyphicon glyphicon-plus-sign"></span>
					{{trans('messages.new-measure')}}
				</a>
			</div>
		</div>
		<div class="panel-body">
			<table class="table table-striped table-hover table-condensed">
				<thead>
					<tr>
						<th>{{ trans('messages.name') }}</th>
						<th>{{ trans('messages.measure-range') }}</th>
						<th>{{ trans('messages.unit') }}</th>
						<th>{{ trans('messages.description') }}</th>
					</tr>
				</thead>
				<tbody>
				@foreach($measures as $key => $value)
					<tr>
						<td>{{ $value->name }}</td>
						<td>{{ $value->measure_range }}</td>
						<td>{{ $value->unit }}</td>
						<td>{{ $value->description }}</td>
						<td>
							<!-- show the measure (uses the show method found at GET /measure/{id} -->
							<a class="btn btn-sm btn-success" href="{{ URL::route('measure.show', array($value->id)) }}">
								<span class="glyphicon glyphicon-eye-open"></span>
								{{ trans('messages.view') }}
							</a>

							<!-- edit this measure (uses the edit method found at GET /measure/{id}/edit -->
							<a class="btn btn-sm btn-info" href="{{ URL::route('measure.edit', array($value->id)) }}" >
								<span class="glyphicon glyphicon-edit"></span>
								{{ trans('messages.edit') }}
							</a>
							<!-- delete this measure (uses the delete method found at GET /measure/{id}/delete -->
							<button class="btn btn-sm btn-danger delete-item-link" 
								data-toggle="modal" data-target=".confirm-delete-modal"	
								data-id='{{ URL::route("measure.delete", array($value->id)) }}'>
								<span class="glyphicon glyphicon-trash"></span>
								{{ trans('messages.delete') }}
							</button>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			<?php echo $measures->links(); ?>
		</div>
	</div>
@stop