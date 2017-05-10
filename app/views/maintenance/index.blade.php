@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="">{{Lang::choice('messages.instrument',2)}}</li>
	  <li class="active">{{Lang::choice('messages.maintenance',2)}}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
@if($errors->all())
	<div class="alert alert-danger">
		{{ HTML::ul($errors->all()) }}
	</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-cog"></span>
		{{trans('messages.list-maintenance')}}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::route('maintenance.create') }}" >
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{trans('messages.new-maintenance')}}
			</a>
		
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed search-table">
			<thead>
				<tr>
					<th>{{Lang::choice('messages.performed_by',1)}}</th>
					<th>{{trans('messages.instrument_lbl')}}</th>
					<th>{{trans('messages.reason')}}</th>
					<th>{{trans('messages.start')}}</th>
					<th>{{trans('messages.end')}}</th>
				</tr>
			</thead>
			<tbody>
			@foreach($maintenance as $key => $value)
				<tr>
					<td>{{ $value->performed_by }}</td>
					<td>{{ $value->instrument }}</td>
					<td>{{ $value->reason }}</td>
					<td>{{ $value->start }}</td>
					<td>{{ $value->end }}</td>

					<td>

						<!-- show the maintenance details -->
					

						<!-- edit this maintenance  -->
						<a class="btn btn-sm btn-info" href="{{ URL::route('maintenance.edit', array($value->id)) }}" >
							<span class="glyphicon glyphicon-edit"></span>
							{{trans('messages.edit')}}
						</a>
						<!-- delete this maintenance -->
						<button class="btn btn-sm btn-danger delete-item-link"
							data-toggle="modal" data-target=".confirm-delete-modal"	
							data-id="{{ URL::route('maintenance.delete', array($value->id)) }}">
							<span class="glyphicon glyphicon-trash"></span>
							{{trans('messages.delete')}}
						</button>

					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		{{$maintenance->links()}}
	</div>
</div>


@stop