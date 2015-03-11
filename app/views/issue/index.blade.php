@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="active">{{ Lang::choice('messages.issue',2) }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{trans('messages.issuesList')}}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::route('issue.create') }}">
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{trans('messages.add-issue')}}
			</a>
		</div>
	</div>
	<div class="panel-body">
		
<table class="table table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>{{Lang::choice('messages.issue-date',1)}}</th>
					<th>{{Lang::choice('messages.commodity',1)}}</th>
					<th>{{Lang::choice('messages.batch-no',1)}}</th>
					<th>{{Lang::choice('messages.expiry-date',1)}}</th>
					<th>{{Lang::choice('messages.destination',1)}}</th>
					<th>{{Lang::choice('messages.receivers-name',1)}}</th>
					<th>{{trans('messages.actions')}}</th>
				</tr>
			</thead>
			<tbody>
			@foreach($issues as $issue)
				<tr>
					<td>{{ $issue->created_at}}</td>
					<td>{{ $issue->commodity->name }}</td>
					<td>{{ $issue->receipt->batch_no}}</td>
					<td>{{ $issue->quantity_issued}}</td>
					<td>{{ $issue->section->name }}</td>
					<td>{{ $issue->user->name }}</td>
					<td> 
						<!-- edit this commodity (uses the edit method found at GET /inventory/{id}/edit -->
					<a class="btn btn-sm btn-info" href="{{ URL::route('issue.edit', array($issue->id)) }}" >
							<span class="glyphicon glyphicon-edit"></span>
							{{trans('messages.edit')}}
					</a>
						<!-- delete this commodity (uses the delete method found at GET /inventory/{id}/delete -->
					<button class="btn btn-sm btn-danger delete-item-link" 
							data-toggle="modal" data-target=".confirm-delete-modal"	
							data-id="{{ URL::route('issue.delete', array($issue->id)) }}">
							<span class="glyphicon glyphicon-trash"></span>
							{{trans('messages.delete')}}
					</button>
					</td>
				</tr>
				@endforeach
				
			</tbody>
			</table>
		<?php Session::put('SOURCE_URL', URL::full());?>
	</div>
</div>
@stop