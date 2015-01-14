@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{Lang::choice('messages.facility',2)}}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-adjust"></span>
		{{ trans('messages.list-facilities') }}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::to("facility/create") }}" >
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{ trans('messages.add-facility') }}
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>{{ trans('messages.name') }}</th>
				</tr>
			</thead>
			<tbody>
			@foreach($facilities as $facility)
				<tr @if(Session::has('activefacility'))
                            {{(Session::get('activefacility') == $facility->id)?"class='info'":""}}
                        @endif
                    >
					<td>{{ $facility->name }}</td>
					<td>
					<!-- edit this facility (uses edit method found at GET /facility/{id}/edit -->
						<a class="btn btn-sm btn-info" href="{{ URL::to("facility/" . $facility->id . "/edit") }}" >
							<span class="glyphicon glyphicon-edit"></span>
							{{ trans('messages.edit') }}
						</a>
					<!-- delete this facility (uses delete method found at GET /facility/{id}/delete -->
						<button class="btn btn-sm btn-danger delete-item-link"
							data-toggle="modal" data-target=".confirm-delete-modal"
							data-id='{{ URL::to("facility/" . $facility->id . "/delete") }}'>
							<span class="glyphicon glyphicon-trash"></span>
							{{ trans('messages.delete') }}
						</button>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<?php echo $facilities->links();
		Session::put('SOURCE_URL', URL::full()); ?>
	</div>
</div>
@stop