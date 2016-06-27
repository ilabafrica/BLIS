@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
            <li><a href="{!! route('testtype.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.test-type', 2) !!}</a></li>
            <li class="active">{!! trans('action.view').' '.trans_choice('menu.test-type', 1) !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="card">
		<div class="card-header">
		    <i class="fa fa-file-text"></i> <strong>{!! trans('general-terms.details-for').': '.$testtype->name !!}</strong>
		    <span>
		    	<a class="btn btn-sm btn-belize-hole" href="{!! url("testtype/create") !!}" >
					<i class="fa fa-plus-circle"></i>
					{!! trans('action.new').' '.trans_choice('menu.test-type', 1) !!}
				</a>
				<a class="btn btn-sm btn-info" href="{!! url("testtype/" . $testtype->id . "/edit") !!}" >
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
		    <li class="list-group-item"><h4>{!! trans('general-terms.name').': ' !!}<small>{!! $testtype->name !!}</small></h4></li>
		    <li class="list-group-item"><h5>{!! trans('general-terms.description').': ' !!}<small>{!! $testtype->description !!}</small></h5></li>
		    <li class="list-group-item"><h6>{!! trans_choice('menu.lab-section', 1).': ' !!}<small>{!! $testtype->testCategory->name !!}</small></h6></li>
		    <li class="list-group-item"><h6>{!! trans_choice('menu.specimen-type', 2).': ' !!}<small>{!! implode(", ", $testtype->specimenTypes->lists('name')->toArray()) !!}</small></h6></li>
		    <li class="list-group-item"><h6>{!! trans_choice('menu.measure', 2).': ' !!}<small>{!! implode(", ", $testtype->measures->lists('name')->toArray()) !!}</small></h6></li>
		    <li class="list-group-item"><h6>{!! trans('general-terms.target-tat').': ' !!}<small>{!! $testtype->targetTAT !!}</small></h6></li>
		    <li class="list-group-item"><h6>{!! trans('general-terms.prevalence-threshold').': ' !!}<small>{!! $testtype->prevalence_threshold !!}</small></h6></li>
	  	</ul>
	</div>
</div>
@endsection	