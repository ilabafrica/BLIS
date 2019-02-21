@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('Home')}}</a></li>
	  <li class="active">Test Result Mappings</li>
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
					<th>BLIS Name</th>
					<th>EMR Name</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			@foreach($emrResultAliases as $key => $emrResultAlias)
				<tr  @if(Session::has('activepatient'))
						{{(Session::get('activepatient') == $emrResultAlias->id)?"class='info'":""}}
					@endif
				>
					<td>{{ $emrResultAlias->name }}</td>
					<td>{{ $emrResultAlias->name }}</td>
					<td>
						<a class="btn btn-sm btn-danger"
							href="{{ URL::route('mh4mapper.mapresultdestroy', array($emrResultAlias->id)) }}" >
							<span class="glyphicon glyphicon-thumbs-down"></span>
							{{trans('Delete')}}
						</a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<?php echo $emrResultAliases->links();
		Session::put('SOURCE_URL', URL::full());?>
	</div>
</div>
@stop