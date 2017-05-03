@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{Lang::choice('messages.task',2)}}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-adjust"></span>
		List Tasks
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::to("systemtask/create") }}" >
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{ trans('messages.add-task') }}
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed search-table">
			<thead>
				<tr>
					<th>{{ Lang::choice('messages.name', 1) }}</th>
					<th>{{ Lang::choice('messages.command', 1) }}</th>
					<th>{{ Lang::choice('messages.script_location', 1) }}</th>
					<th>{{ Lang::choice('messages.interval', 1) }}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			{{$tasks}}
			@foreach($tasks as $task)
				<tr @if(Session::has('activefacility'))
                            {{(Session::get('activefacility') == $task->id)?"class='info'":""}}
                        @endif
                    >
					<td>{{ $task->name }}</td>
					<td>{{ $task->command }}</td>
					<td>{{ $task->script_location }}</td>
					<td>{{ $task->intervals }}</td>
					<td>
					<!-- edit this facility (uses edit method found at GET /facility/{id}/edit -->
						<a class="btn btn-sm btn-info" href="{{ URL::to("systemtask/" . $task->id . "/edit") }}" >
							<span class="glyphicon glyphicon-edit"></span>
							{{ trans('messages.edit') }}
						</a>
					<!-- delete this facility (uses delete method found at GET /facility/{id}/delete -->
						<button class="btn btn-sm btn-danger delete-item-link"
							data-toggle="modal" data-target=".confirm-delete-modal"
							data-id='{{ URL::to("systemtask/" . $task->id . "/delete") }}'>
							<span class="glyphicon glyphicon-trash"></span>
							{{ trans('messages.delete') }}
						</button>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		
	</div>
</div>
@stop