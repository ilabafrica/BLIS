@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.add-new',1) }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-adjust"></span>
		{{ Lang::choice('messages.critical',1) }}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::to("critical/create") }}" >
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{ trans('messages.add-new') }}
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed search-table">
			<thead>
				<tr>
					<th>{{ Lang::choice('messages.measure', 1) }}</th>
					<th>{{ trans('messages.gender') }}</th>
					<th>{{ trans('messages.age-min') }}</th>
					<th>{{ trans('messages.age-max') }}</th>
					<th>{{ trans('messages.normal-lower') }}</th>
					<th>{{ trans('messages.normal-upper') }}</th>
					<th>{{ trans('messages.critical-low') }}</th>
					<th>{{ trans('messages.critical-high') }}</th>
					<th>{{ trans('messages.unit') }}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			@foreach($criticals as $key => $value)
				<tr @if(Session::has('activecritical'))
                            {{(Session::get('activecritical') == $value->id)?"class='info'":""}}
                        @endif
                        >

					<td>{{ $value->measure->name }}</td>
					<td>
						@if($value->gender==0)
							{{ trans('messages.male') }}
						@elseif($value->gender==1)
							{{ trans('messages.female') }}
						@else
							{{ trans('messages.both') }}
						@endif
					</td>
					<td>{{ $value->age_min }}</td>
					<td>{{ $value->age_max }}</td>
					<td>{{ $value->normal_lower }}</td>
					<td>{{ $value->normal_upper }}</td>
					<td>{{ $value->critical_low }}</td>
					<td>{{ $value->critical_high }}</td>
					<td>{{ $value->unit }}</td>
					<td>

					<!-- show the critical (uses the show method found at GET /critical/{id} -->
						<a class="btn btn-sm btn-success" href="{{ URL::to("critical/" . $value->id) }}" >
							<span class="glyphicon glyphicon-eye-open"></span>
							{{ trans('messages.view') }}
						</a>

					<!-- edit this critical (uses edit method found at GET /critical/{id}/edit -->
						<a class="btn btn-sm btn-info" href="{{ URL::to("critical/" . $value->id . "/edit") }}" >
							<span class="glyphicon glyphicon-edit"></span>
							{{ trans('messages.edit') }}
						</a>
						
					<!-- delete this critical (uses delete method found at GET /critical/{id}/delete -->
						<button class="btn btn-sm btn-danger delete-item-link"
							data-toggle="modal" data-target=".confirm-delete-modal"	
							data-id='{{ URL::to("critical/" . $value->id . "/delete") }}'>
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