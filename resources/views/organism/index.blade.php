@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ trans_choice('messages.organism',1) }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-adjust"></span>
		{{ trans_choice('messages.organism',1) }}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::to("organism/create") }}" >
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{ trans('messages.create-organism') }}
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed search-table">
			<thead>
				<tr>
					<th>{{ trans_choice('messages.name',1) }}</th>
					<th>{{ trans('messages.description') }}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			@foreach($organisms as $key => $value)
				<tr @if(Session::has('activeorganism'))
                            {{(Session::get('activeorganism') == $value->id)?"class='info'":""}}
                        @endif
                        >

					<td>{{ $value->name }}</td>
					<td>{{ $value->description }}</td>
					
					<td>

					<!-- show the organism (uses the show method found at GET /organism/{id} -->
						<a class="btn btn-sm btn-success" href="{{ URL::to("organism/" . $value->id) }}" >
							<span class="glyphicon glyphicon-eye-open"></span>
							{{ trans('messages.view') }}
						</a>

					<!-- edit this organism (uses edit method found at GET /organism/{id}/edit -->
						<a class="btn btn-sm btn-info" href="{{ URL::to("organism/" . $value->id . "/edit") }}" >
							<span class="glyphicon glyphicon-edit"></span>
							{{ trans('messages.edit') }}
						</a>
						
					<!-- delete this organism (uses delete method found at GET /organism/{id}/delete -->
						<button class="btn btn-sm btn-danger delete-item-link"
							data-toggle="modal" data-target=".confirm-delete-modal"	
							data-id='{{ URL::to("organism/" . $value->id . "/delete") }}'>
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