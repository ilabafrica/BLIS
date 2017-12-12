@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="active">{{Lang::choice('messages.panels',2)}}</li>
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
		{{trans('messages.list-panel')}}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::route('panel.create') }}" >
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{trans('messages.new-panel')}}
			</a>			
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed search-table">
			<thead>
				<tr>					
					<th>{{trans('messages.panel_name')}}</th>
					<th>{{trans('messages.panel_description')}}</th>
					<th>{{trans('messages.actions')}}</th>
				</tr>
			</thead>
		<tbody>
			@foreach($panels as $key => $value)
				<tr {{{ ($value->active == '0') ? 'class=warning' : ''}}}>
					<td>{{$value->name}}</td>
					<td>{{$value->description}}</td>
					<td>
						<!-- show the panel details -->
						<a class="btn btn-sm btn-success" href="{{ URL::route('panel.show', array($value->id)) }}">
							<span class="glyphicon glyphicon-eye-open"></span>
							{{trans('messages.view')}}
						</a>

						<!-- edit this panel  -->
						<a class="btn btn-sm btn-info" href="{{ URL::route('panel.edit', array($value->id)) }}" >
							<span class="glyphicon glyphicon-edit"></span>
							{{trans('messages.edit')}}
						</a>
						<!-- delete this panel -->
						<button class="btn btn-sm {{{ ($value->active == '0') ? 'btn-warning' : 'btn-danger'}}} delete-item-link"
							data-toggle="modal" data-target=".confirm-delete-modal"
							data-id="{{URL::route('panel.delete',array($value->id))}}">
							<span class="glyphicon glyphicon-trash"></span>
							{{{ ($value->active == '0') ? 'activate' : 'deactivate'}}}
						</button>

					</td>
				</tr>
			@endforeach			
			</tbody> 
		</table>		
	</div>
</div>
@stop
