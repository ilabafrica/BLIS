@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="">{{Lang::choice('messages.instrument',2)}}</li>
	  <li class="active">{{Lang::choice('messages.calibration',2)}}</li>
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
		{{trans('messages.list-calibrations')}}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::route('calibration.create') }}" >
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{trans('messages.new-calibration')}}
			</a>
			
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed search-table">
			<thead>
				<tr>
					<th>{{Lang::choice('messages.name',1)}}</th>
					<th>{{trans('messages.description')}}</th>
					<th>{{trans('messages.actions')}}</th>
				</tr>
			</thead>
			<tbody>
			@foreach($calibrations as $key => $value)
				<tr>
					<td>{{ $value->name }}</td>
					<td>{{ $value->description }}</td>

					<td>

						<!-- show the calibration details -->
						
						<!-- edit this calibration  -->
						<a class="btn btn-sm btn-info" href="{{ URL::route('calibration.edit', array($value->id)) }}" >
							<span class="glyphicon glyphicon-edit"></span>
							{{trans('messages.edit')}}
						</a>
						<!-- delete this calibration -->
						<button class="btn btn-sm btn-danger delete-item-link"
							data-toggle="modal" data-target=".confirm-delete-modal"	
							data-id="{{ URL::route('calibration.delete', array($value->id)) }}">
							<span class="glyphicon glyphicon-trash"></span>
							{{trans('messages.delete')}}
						</button>

					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		{{$calibrations->links()}}
	</div>
</div>


@stop