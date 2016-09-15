@extends("layout")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('messages.home') !!}</a></li>
            <li class="active"><i class="fa fa-toggle-off"></i> {!! trans('messages.lab-configuration') !!}</li>
            <li><a href="{!! route('analyser.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('messages.analyser', 2) !!}</a></li>
            <li class="active">{!! trans('messages.new').' '.trans_choice('messages.analyser', 1) !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="card">
		<div class="card-header">
		    <i class="fa fa-pencil"></i> {!! trans('messages.new').' '.trans_choice('messages.analyser', 1) !!} 
		    <span>
				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
					<i class="fa fa-step-backward"></i>
					{!! trans('messages.back') !!}
				</a>				
			</span>
		</div>
	  	<div class="card-block">	  		
			<!-- if there are creation errors, they will show here -->
			@if($errors->all())
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('messages.close') !!}</span></button>
                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
            </div>
            @endif

			{!! Form::open(array('route' => 'analyser.store', 'id' => 'form-create-analyser')) !!}
				<!-- CSRF Token -->
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                <!-- ./ csrf token -->
				<div class="form-group row">
					{!! Form::label('name', trans_choice('messages.name',1), array('class' => 'col-sm-2 form-control-label')) !!}
					<div class="col-sm-6">
						{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('version', trans('messages.version'), array('class' => 'col-sm-2 form-control-label')) !!}
					<div class="col-sm-6">
						{!! Form::text('version', old('version'), array('class' => 'form-control')) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('test_category_id', trans_choice('messages.lab-section', 1), array('class' => 'col-sm-2 form-control-label')) !!}
					<div class="col-sm-6">
						{!! Form::select('test_category_id', $testcategories, '', array('class' => 'form-control c-select')) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('comm-type', trans('messages.comm-type'), array('class' => 'col-sm-2 form-control-label')) !!}
					<div class="col-sm-6">
						{!! Form::select('comm_type', $commtypes, '', array('class' => 'form-control c-select')) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('feed-source', trans('messages.feed-source'), array('class' => 'col-sm-2 form-control-label')) !!}
					<div class="col-sm-6">
						{!! Form::select('feed_source', $feedsources, '', array('class' => 'form-control c-select')) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('config-file', trans('messages.config-file'), array('class' => 'col-sm-2 form-control-label')) !!}
					<div class="col-sm-6">
	                	<label class="file">
	  						{!! Form::file('config_file', '') !!}
	  						<span class="file-custom"></span>
						</label>
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('description', trans("terms.description"), array('class' => 'col-sm-2 form-control-label')) !!}</label>
					<div class="col-sm-6">
						{!! Form::textarea('description', old('description'), array('class' => 'form-control', 'rows' => '2')) !!}
					</div>
				</div>
				<div class="form-group row col-sm-offset-2">
					{!! Form::button("<i class='fa fa-plus-circle'></i> ".trans('messages.save'), 
						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
					<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('messages.cancel') !!}</a>
				</div>

			{!! Form::close() !!}
	  	</div>
	</div>
</div>
@endsection	