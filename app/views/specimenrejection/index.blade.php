@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="active">{{trans('messages.specimen-rejection')}}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{trans('messages.specimen-rejection')}}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::to("specimenrejection/create") }}" >
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{trans('messages.add-rejection-reason')}}
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>{{trans('messages.rejection-reason')}}</th>
				</tr>
			</thead>
			<tbody>
			@foreach($rejection as $key => $value)
				<tr>
					<td>{{ $value->reason }}</td>

					<td>

					<!-- edit this specimenrejection (uses the edit method found at GET /specimenrejection/{id}/edit -->
						<a class="btn btn-sm btn-info" href="{{ URL::to("specimenrejection/" . $value->id . "/edit") }}" >
							<span class="glyphicon glyphicon-edit"></span>
							{{trans('messages.edit')}}
						</a>
					<!-- delete this specimenrejection (uses delete method found at GET /specimenrejection/{id}/delete -->
						<button class="btn btn-sm btn-danger delete-item-link" 
							data-toggle="modal" data-target=".confirm-delete-modal"	
							data-id='{{ URL::route("specimenrejection.delete", array($value->id)) }}'>
							<span class="glyphicon glyphicon-trash"></span>
							{{trans('messages.delete')}}
						</button>

					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<?php echo $rejection->links(); 
		Session::put('SOURCE_URL', URL::full());?>
	</div>
</div>
@stop	
