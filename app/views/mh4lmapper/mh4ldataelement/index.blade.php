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
		EMR Test Type Identifiers
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::route('mh4ldataelement.create') }}">
				<span class="glyphicon glyphicon-plus-sign"></span>
				New EMR Test Type Identifier
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>Name</th>
					<th>Identifier</th>
					<th>{{trans('Actions')}}</th>
				</tr>
			</thead>
			<tbody>
			@foreach($dataElements as $key => $dataElement)
				<tr  @if(Session::has('activepatient'))
						{{(Session::get('activepatient') == $dataElement->id)?"class='info'":""}}
					@endif
				>
					<td>{{ $dataElement->data_element_id }}</td>
					<td>{{ $dataElement->name }}</td>
					<td>
						<a class="btn btn-sm btn-danger"
							href="{{ URL::route('mh4ldataelement.delete', array($dataElement->id)) }}" >
							<span class="glyphicon glyphicon-thumbs-down"></span>
							{{trans('Delete')}}
						</a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<?php echo $dataElements->links();
		Session::put('SOURCE_URL', URL::full());?>
	</div>
</div>
@stop