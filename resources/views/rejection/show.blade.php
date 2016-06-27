@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
            <li><a href="{!! route('rejection.index') !!}"><i class="fa fa-cube"></i> {!! trans('menu.specimen-rejection') !!}</a></li>
            <li class="active">{!! trans('action.view').' '.trans('terms.reject-reason') !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="card">
		<div class="card-header">
		    <i class="fa fa-file-text"></i> <strong>{!! trans('terms.details-for').': '.$rejection->reason !!}</strong>
		    <span>
		    	<a class="btn btn-sm btn-belize-hole" href="{!! url("rejection/create") !!}" >
					<i class="fa fa-plus-circle"></i>
					{!! trans('action.new').' '.trans('terms.reject-reason') !!}
				</a>
				<a class="btn btn-sm btn-info" href="{!! url("rejection/" . $rejection->id . "/edit") !!}" >
					<i class="fa fa-edit"></i>
					{!! trans('action.edit') !!}
				</a>
				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
					<i class="fa fa-step-backward"></i>
					{!! trans('action.back') !!}
				</a>				
			</span>
		</div>	  		
		<!-- if there are creation errors, they will show here -->
		@if($errors->all())
			<div class="alert alert-danger">
				{!! HTML::ul($errors->all()) !!}
			</div>
		@endif

		<ul class="list-group list-group-flush">
		    <li class="list-group-item"><h4>{!! trans('terms.name').': ' !!}<small>{!! $rejection->reason !!}</small></h4></li>
		    <li class="list-group-item"><h5>{!! trans('terms.description').': ' !!}<small>{!! $rejection->description !!}</small></h5></li>
	  	</ul>
	</div>
</div>
@endsection	