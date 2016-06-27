@extends("app")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{!! URL::route('user.home')!!}">{!! trans('menu.home') !!}</a></li>
	  <li class="active">{!!trans_choice('menu.control',2)!!}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{!! Session::get('message') !!}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-adjust"></span>
		{!! trans('terms.list-controls') !!}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{!! URL::to("control/create") !!}" >
				<span class="glyphicon glyphicon-plus-sign"></span>
				{!! trans('terms.add-control') !!}
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed search-table">
			<thead>
				<tr>
					<th>{!! trans_choice('terms.name', 1) !!}</th>
					<th>{!! trans_choice('terms.lot', 1) !!}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			@foreach($controls as $control)
					<td>{!! $control->name !!}</td>
					<td>{!! $control->lot->number !!}</td>
					<td>
						<a class="btn btn-sm btn-info" href="{!! URL::to("control/" . $control->id . "/edit") !!}" >
							<span class="glyphicon glyphicon-edit"></span>
							{!! trans('action.edit') !!}
						</a>
						<button class="btn btn-sm btn-danger delete-item-link"
							data-toggle="modal" data-target=".confirm-delete-modal"
							data-id='{!! URL::to("control/" . $control->id . "/delete") !!}'>
							<span class="glyphicon glyphicon-trash"></span>
							{!! trans('action.delete') !!}
						</button>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		{!! Session::put('SOURCE_URL', URL::full()) !!}
	</div>
</div>
@stop