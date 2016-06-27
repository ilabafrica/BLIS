@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li class="active"><i class="fa fa-toggle-off"></i> {!! trans('menu.lab-config') !!}</li>
            <li><a href="{!! route('analyser.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.analyser', 2) !!}</a></li>
            <li class="active">{!! trans('action.view').' '.trans_choice('menu.analyser', 1) !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="card">
		<div class="card-header">
		    <i class="fa fa-file-text"></i> <strong>{!! trans('terms.details-for').': '.$analyser->name !!}</strong>
		    <span>
		    	<a class="btn btn-sm btn-belize-hole" href="{!! url("analyser/create") !!}" >
					<i class="fa fa-plus-circle"></i>
					{!! trans('action.new').' '.trans_choice('menu.analyser', 1) !!}
				</a>
				<a class="btn btn-sm btn-info" href="{!! url("analyser/" . $analyser->id . "/edit") !!}" >
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
		    <li class="list-group-item"><h4>{!! trans('terms.name').': ' !!}<small>{!! $analyser->name !!}</small></h4></li>
		    <li class="list-group-item"><h6>{!! trans('terms.version').': ' !!}<small>{!! $analyser->version !!}</small></h6></li>
		    <li class="list-group-item"><h6>{!! trans_choice('menu.lab-section', 1).': ' !!}<small>{!! $analyser->testCategory->name !!}</small></h6></li>
		    <li class="list-group-item"><h6>{!! trans('terms.description').': ' !!}<small>{!! $analyser->description !!}</small></h6></li>
	  	</ul>
	</div>
</div>
@endsection	