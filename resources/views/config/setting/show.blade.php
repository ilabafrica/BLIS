@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li class="active"><i class="fa fa-toggle-off"></i> {!! trans('menu.lab-config') !!}</li>
            <li><a href="{!! route('barcode.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.barcode', 2) !!}</a></li>
            <li class="active">{!! trans('action.view').' '.trans_choice('menu.barcode', 1) !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="card">
		<div class="card-header">
		    <i class="fa fa-file-text"></i> <strong>{!! trans('general-terms.details-for').': '.$barcode->name !!}</strong>
		    <span>
		    	<a class="btn btn-sm btn-belize-hole" href="{!! url("barcode/create") !!}" >
					<i class="fa fa-plus-circle"></i>
					{!! trans('action.new').' '.trans_choice('menu.barcode', 1) !!}
				</a>
				<a class="btn btn-sm btn-info" href="{!! url("barcode/" . $barcode->id . "/edit") !!}" >
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
		    <li class="list-group-item"><h4>{!! trans('general-terms.name').': ' !!}<small>{!! $barcode->name !!}</small></h4></li>
		    <li class="list-group-item"><h5>{!! trans('general-terms.description').': ' !!}<small>{!! $barcode->description !!}</small></h5></li>
	  	</ul>
	</div>
</div>
@endsection	