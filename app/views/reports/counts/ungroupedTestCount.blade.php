@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active"><a href="{{ URL::route('reports.patient.index') }}">{{ trans('messages.reports') }}</a></li>
	  <li class="active">{{ trans('messages.counts') }}</li>
	</ol>
</div>
{{ Form::open(array('route' => array('reports.aggregate.counts'), 'class' => 'form-inline', 'role' => 'form')) }}
<div class="table-responsive">
  <table class="table">
    <thead>
    <tr>
        <td>{{ Form::label('start', trans("messages.from")) }}</td>
	    <td>
            {{ Form::text('start', isset($input['start'])?$input['start']:date('Y-m-01'), 
                array('class' => 'form-control standard-datepicker')) }}
	    </td>
	    <td>{{ Form::label('end', trans("messages.to")) }}</td>
	    <td>
            {{ Form::text('end', isset($input['end'])?$input['end']:date('Y-m-d'), 
                array('class' => 'form-control standard-datepicker')) }}
	     </td>    
        <td>{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
                        array('class' => 'btn btn-info', 'style' => 'width:125px', 'id' => 'filter', 'type' => 'submit')) }}</td>
    </tr>
	</thead>
	<tbody>
		
	</tbody>
</table>
</div>
{{ Form::close() }}
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.counts') }}
	</div>
	<div class="panel-body">
	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@else	
		<div class="table-responsive">
		  <table class="table table-striped table-bordered">
		    <tbody>
			    <tr>
			    	<th>{{trans('messages.test-type')}}</th>
			    	<th>{{trans('messages.completed-tests')}}</th>
			    	<th>{{trans('messages.pending-tests')}}</th>
			    </tr>
			    @forelse($data as $datum)
			    <tr>
			    	<td>{{ TestType::find($datum->test_type_id)->name }}</td>
			    	<td>{{ $datum->complete }}</td>
			    	<td>{{ $datum->pending }}</td>
			    </tr>
			    @empty
			    <tr>
			    	<td colspan="3">{{trans('messages.no-records-found')}}</td>
			    </tr>
			    @endforelse
		    </tbody>
		  </table>
		</div>
		@endif
	{{$data->links()}}
	</div>
</div>

@stop