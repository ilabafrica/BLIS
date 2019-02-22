@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">Third Party Accesses</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		List Third Party Accesses
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::to("tpaaccess/create") }}" >
				<span class="glyphicon glyphicon-plus-sign"></span>
				New Third Party Access
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>UserName</th>
				</tr>
			</thead>
			<tbody>
			@foreach($thirdPartyAccesses as $thirdPartyAccess)
				<tr>
					<td>{{ $thirdPartyAccess->username }}</td>
					<td>
						<a class="btn btn-sm btn-info" href="{{ URL::to("tpaaccess/" . $thirdPartyAccess->id . "/edit") }}" >
							<span class="glyphicon glyphicon-edit"></span>
							{{ trans('messages.edit') }}
						</a>
						<button class="btn btn-sm btn-danger delete-item-link {{($thirdPartyAccess == User::getAdminUser()) ? 'disabled': ''}}"
							data-toggle="modal" data-target=".confirm-delete-modal"	
							data-id='{{ URL::to("tpaaccess/" . $thirdPartyAccess->id . "/delete") }}'>
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