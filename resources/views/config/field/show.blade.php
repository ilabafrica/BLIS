@extends("layout")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('messages.home') !!}</a></li>
            <li class="active"><i class="fa fa-toggle-off"></i> {!! trans('messages.lab-configuration') !!}</li>
            <li><a href="{!! route('field.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('messages.field', 2) !!}</a></li>
            <li class="active">{!! trans('messages.view').' '.trans_choice('messages.field', 1) !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="card">
		<div class="card-header">
		    <i class="fa fa-file-text"></i> <strong>{!! trans('messages.details-for').': '.$field->name !!}</strong>
		    <span>
		    	<a class="btn btn-sm btn-belize-hole" href="{!! url("field/create") !!}" >
					<i class="fa fa-plus-circle"></i>
					{!! trans('messages.new').' '.trans_choice('messages.field', 1) !!}
				</a>
				<a class="btn btn-sm btn-info" href="{!! url("field/" . $field->id . "/edit") !!}" >
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
		    <li class="list-group-item"><h4>{!! trans('messages.name').': ' !!}<small>{!! $field->name !!}</small></h4></li>
		    <li class="list-group-item"><h5>{!! trans_choice('messages.module', 1).': ' !!}<small>{!! $field->configurable->name !!}</small></h5></li>
		    <li class="list-group-item"><h6>{!! trans_choice('messages.field-type', 1).': ' !!}<small>{!! $field->field_type !!}</small></h6></li>
		    <li class="list-group-item"><h6>{!! trans_choice("menu.options", 2).': ' !!}<small>{!! implode(',', $field->options) !!}</small></h6></li>
	  	</ul>
	</div>
</div>
@endsection	