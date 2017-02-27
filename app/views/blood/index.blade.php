@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ trans('messages.blood-bank') }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-adjust"></span>
		{{ trans('messages.blood-bank') }}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::to("blood/create") }}" >
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{ trans('messages.add-new') }}
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed search-table">
			<thead>
				<tr>
					<th>{{ trans('messages.bag-number') }}</th>
					<th>{{ trans('messages.blood-group') }}</th>
					<th>{{ trans('messages.volume') }}</th>
					<th>{{ trans('messages.date-collected') }}</th>
					<th>{{ trans('messages.expiry') }}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			@foreach($bbs as $key => $value)
				<tr @if(Session::has('activebb'))
                            {{(Session::get('activebb') == $value->id)?"class='info'":""}}
                        @endif
                        >

					<td>{{ $value->bag_number }}</td>
					<td>{{ $value->bldgrp($value->blood_group) }}</td>
					<td>{{ $value->volume }}</td>
					<td>{{ $value->date_collected }}</td>
					<td>{{ $value->expiry_date }}</td>
					
					<td>

					<!-- show the blood (uses the show method found at GET /blood/{id} -->
						<a class="btn btn-sm btn-success" href="{{ URL::to("blood/" . $value->id) }}" >
							<span class="glyphicon glyphicon-eye-open"></span>
							{{ trans('messages.view') }}
						</a>

					<!-- edit this blood (uses edit method found at GET /blood/{id}/edit -->
						<a class="btn btn-sm btn-info" href="{{ URL::to("blood/" . $value->id . "/edit") }}" >
							<span class="glyphicon glyphicon-edit"></span>
							{{ trans('messages.edit') }}
						</a>
						
					<!-- delete this blood (uses delete method found at GET /blood/{id}/delete -->
						<button class="btn btn-sm btn-danger delete-item-link"
							data-toggle="modal" data-target=".confirm-delete-modal"	
							data-id='{{ URL::to("blood/" . $value->id . "/delete") }}'>
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