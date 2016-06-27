@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
            <li><a href="{!! route('organism.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.organism', 2) !!}</a></li>
            <li class="active">{!! trans('action.view').' '.trans_choice('menu.organism', 1) !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="card">
		<div class="card-header">
		    <i class="fa fa-file-text"></i> <strong>{!! trans('general-terms.details-for').': '.$organism->name !!}</strong>
		    <span>
		    	<a class="btn btn-sm btn-belize-hole" href="{!! url("organism/create") !!}" >
					<i class="fa fa-plus-circle"></i>
					{!! trans('action.new').' '.trans_choice('menu.organism', 1) !!}
				</a>
				<a class="btn btn-sm btn-info" href="{!! url("organism/" . $organism->id . "/edit") !!}" >
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
		    <li class="list-group-item"><h4>{!! trans('general-terms.name').': ' !!}<small>{!! $organism->name !!}</small></h4></li>
		    <li class="list-group-item"><h5>{!! trans('general-terms.description').': ' !!}<small>{!! $organism->description !!}</small></h5></li>
		    <li class="list-group-item"><h5>{!! trans_choice('menu.drug', 2).': ' !!}<small>{!! implode(", ", $organism->drugs->lists('name')->toArray()) !!}</small></h5></li>
	  	</ul>
	</div>
</div>
@endsection	