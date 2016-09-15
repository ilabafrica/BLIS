@extends("layout")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('messages.home') !!}</a></li>
            <li class="active"><i class="fa fa-toggle-off"></i> {!! trans('messages.lab-configuration') !!}</li>
            <li><a href="{!! route('analyser.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('messages.analyser', 2) !!}</a></li>
            <li class="active">{!! trans('messages.view').' '.trans_choice('messages.analyser', 1) !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="card">
		<div class="card-header">
		    <i class="fa fa-file-text"></i> <strong>{!! trans('messages.details-for').': '.$analyser->name !!}</strong>
		    <span>
		    	<a class="btn btn-sm btn-belize-hole" href="{!! url("analyser/create") !!}" >
					<i class="fa fa-plus-circle"></i>
					{!! trans('messages.new').' '.trans_choice('messages.analyser', 1) !!}
				</a>
				<a class="btn btn-sm btn-info" href="{!! url("analyser/" . $analyser->id . "/edit") !!}" >
					<i class="fa fa-edit"></i>
					{!! trans('messages.edit') !!}
				</a>
				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
					<i class="fa fa-step-backward"></i>
					{!! trans('messages.back') !!}
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
		    <li class="list-group-item"><h4>{!! trans('messages.name').': ' !!}<small>{!! $analyser->name !!}</small></h4></li>
		    <li class="list-group-item"><h6>{!! trans('messages.version').': ' !!}<small>{!! $analyser->version !!}</small></h6></li>
		    <li class="list-group-item"><h6>{!! trans_choice('messages.lab-section', 1).': ' !!}<small>{!! $analyser->testCategory->name !!}</small></h6></li>
		    <li class="list-group-item"><h6>{!! trans('messages.description').': ' !!}<small>{!! $analyser->description !!}</small></h6></li>
	  	</ul>
	</div>
</div>
@endsection	