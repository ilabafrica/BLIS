@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="active">{{ Lang::choice('messages.test-type',1) }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-cog"></span>
		{{trans('messages.list-test-types')}}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::to("testtype/create") }}" >
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{trans('messages.new-test-type')}}
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed search-table">
			<thead>
				<tr>
					<th>{{ Lang::choice('messages.name',1) }}</th>
					<th>{{trans('messages.description')}}</th>
					<th>{{trans('messages.target-turnaround-time')}}</th>
					<th>{{trans('messages.prevalence-threshold')}}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			@foreach($testtypes as $key => $value)
				<tr @if(Session::has('activetesttype'))
                            {{(Session::get('activetesttype') == $value->id)?"class='info'":""}}
                        @endif
                        >
					<td>{{ $value->name }}</td>
					<td>{{ $value->description }}</td>
					<td>{{ $value->targetTAT }}</td>
					<td>{{ $value->prevalence_threshold}}</td>
					<td>
						<!-- show the testtype (uses the show method found at GET /testtype/{id} -->
						<a class="btn btn-sm btn-success" href="{{ URL::to("testtype/" . $value->id) }}">
							<span class="glyphicon glyphicon-eye-open"></span>
							{{trans('messages.view')}}
						</a>

						<!-- edit this testtype (uses the edit method found at GET /testtype/{id}/edit -->
						<a class="btn btn-sm btn-info" href="{{ URL::to("testtype/" . $value->id . "/edit") }}" >
							<span class="glyphicon glyphicon-edit"></span>
							{{trans('messages.edit')}}
						</a>
						<!-- delete this testtype (uses the delete method found at GET /testtype/{id}/delete -->
						<button class="btn btn-sm btn-danger delete-item-link"
							data-toggle="modal" data-target=".confirm-delete-modal"	
							data-id='{{ URL::to("testtype/" . $value->id . "/delete") }}'>
							<span class="glyphicon glyphicon-trash"></span>
							{{trans('messages.delete')}}
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