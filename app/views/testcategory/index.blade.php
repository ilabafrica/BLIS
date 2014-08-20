@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ trans('messages.test-category') }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary patient-create">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.list-test-categories') }}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::to("testcategory/create") }}" >
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{ trans('messages.create-test-category') }}
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>{{ trans('messages.name') }}</th>
					<th>{{ trans('messages.description') }}</th>
				</tr>
			</thead>
			<tbody>
			@foreach($testcategory as $key => $value)
				<tr>
					<td>{{ $value->name }}</td>
					<td>{{ $value->description }}</td>
					
					<td>

					<!-- show the test category (uses the show method found at GET /testcategory/{id} -->
						<a class="btn btn-sm btn-success" href="{{ URL::to("testcategory/" . $value->id) }}" >
							<span class="glyphicon glyphicon-eye-open"></span>
							{{ trans('messages.view') }}
						</a>

					<!-- edit this test category (uses edit method found at GET /testcategory/{id}/edit -->
						<a class="btn btn-sm btn-info" href="{{ URL::to("testcategory/" . $value->id . "/edit") }}" >							
							<span class="glyphicon glyphicon-edit"></span>
							{{ trans('messages.edit') }}
						</a>
					<!-- delete this test category (uses delete method found at GET /testcategory/{id}/delete -->
						<button class="btn btn-sm btn-danger delete-item-link"
							data-toggle="modal" data-target=".confirm-delete-modal"	
							data-id='{{ URL::to("testcategory/" . $value->id . "/delete") }}'>
							<span class="glyphicon glyphicon-trash"></span>
							{{ trans('messages.delete') }}
						</button>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<?php echo $testcategory->links(); ?>
	</div>
</div>
@stop