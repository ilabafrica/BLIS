@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('Home')}}</a></li>
	  <li class="active">{{ Lang::choice('mH4lmapper',2) }}</li>
	</ol>
</div>

	<br>

@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif

<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{trans('List of mappings')}}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::route('mh4lmapper.create') }}">
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{trans('New Mapping')}}
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>{{trans('Blis Test')}}</th>
					<th>{{Lang::choice('mHealth Equivalent',1)}}</th>
					
					<th>{{trans('Actions')}}</th>
				</tr>
			</thead>
			<tbody>
			@foreach($mappings as $key => $mapping)
				<tr  @if(Session::has('activepatient'))
						{{(Session::get('activepatient') == $mapping->id)?"class='info'":""}}
					@endif
				>
					<td>{{ $mapping->TestType->name }}</td>
					<td>{{ $mapping->MH4Mapper->name }}</td>

					<td>
						<!-- edit this mapping (uses the edit method found at GET /mh4lmapper/{id}/edit -->
						<a class="btn btn-sm btn-info" href="{{ URL::route('mh4lmapper.edit', array($mapping->id)) }}" >
							<span class="glyphicon glyphicon-edit"></span>
							{{trans('Edit')}}
						</a>

						<a class="btn btn-sm btn-danger" href="{{ URL::route('mh4lmapper.delete', array($mapping->id)) }}" >
							<span class="glyphicon glyphicon-thumbs-down"></span>
							{{trans('Delete')}}
						</a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<?php echo $mappings->links(); 
		Session::put('SOURCE_URL', URL::full());?>
	</div>
</div>
@stop