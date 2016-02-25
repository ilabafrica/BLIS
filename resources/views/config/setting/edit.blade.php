@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li class="active"><i class="fa fa-toggle-off"></i> {!! trans('menu.lab-config') !!}</li>
            <li class="active">{!! trans('action.edit').' '.$setting->name !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="card">
		<div class="card-header">
		    <i class="fa fa-edit"></i> {!! trans('action.edit').' <span id="setting">'.$setting->name.'</span>' !!} 
		    <span>
				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
					<i class="fa fa-step-backward"></i>
					{!! trans('action.back') !!}
				</a>				
			</span>
		</div>
	  	<div class="card-block">	  		
			<!-- if there are creation errors, they will show here -->
			@if($errors->all())
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
            </div>
            @endif
            @if (Session::has('message'))
				<div class="alert alert-info">{!! Session::get('message') !!}</div>
			@endif
			@if(Request::segment(2)=='equipment')
			<div class="row">            	
				<div class='col-md-12' style="padding-bottom:5px;">
			        {!! Form::open() !!}
	                    <div class='col-md-8'>
	                        {!! Form::select('analyser_id', $analysers, '', array('class' => 'form-control c-select', 'id' => 'analyser_id', 'onchange' => "reloadable()")) !!}
	                    </div>
			        {!! Form::close() !!}
			    </div>
            </div>
            @endif
            <div class="row">
	            <div class="col-md-8">
					{!! Form::model($setting, array('route' => array('setting.update', $setting->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'files' => true, 'id' => 'form-edit-setting')) !!}
					<!-- CSRF Token -->
	                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	                <!-- ./ csrf token -->
	                	{!! Form::hidden('equi', '', ['id' => 'equi']) !!}
						<div id="reloadable">
		                @if(Request::segment(2)=='equipment')
		                	<div class="form-group row">
								{!! Form::label('name', trans_choice('general-terms.name',1), array('class' => 'col-sm-4 form-control-label')) !!}
								<div class="col-sm-6">
									<h6><small>{!! $analyser->name !!}</small></h6>
								</div>
							</div>
							<div class="form-group row">
								{!! Form::label('version', trans('general-terms.version'), array('class' => 'col-sm-4 form-control-label')) !!}
								<div class="col-sm-6">
									<h6><small>{!! $analyser->version !!}</small></h6>
								</div>
							</div>
							<div class="form-group row">
								{!! Form::label('test_category_id', trans_choice('menu.lab-section', 1), array('class' => 'col-sm-4 form-control-label')) !!}
								<div class="col-sm-6">
									<h6><small>{!! $analyser->testCategory->name !!}</small></h6>
								</div>
							</div>
							<div class="form-group row">
								{!! Form::label('comm-type', trans('general-terms.comm-type'), array('class' => 'col-sm-4 form-control-label')) !!}
								<div class="col-sm-6">
									<h6><small>{!! $analyser->commtype() !!}</small></h6>
								</div>
							</div>
							<div class="form-group row">
								{!! Form::label('feed-source', trans('general-terms.feed-source'), array('class' => 'col-sm-4 form-control-label')) !!}
								<div class="col-sm-6">
									<h6><small>{!! $analyser->feedsource() !!}</small></h6>
								</div>
							</div>
							<div class="form-group row">
								{!! Form::label('config-file', trans('general-terms.config-file'), array('class' => 'col-sm-4 form-control-label')) !!}
								<div class="col-sm-6">
				                	<h6><small>{!! $analyser->config_file !!}</small></h6>
								</div>
							</div>
		                @endif
						</div>
						<div id="dataInput"> 
						@foreach($fields as $field)
		                	@if($field->field_type == App\Models\Field::CHECKBOX)
		                		<div class="form-group row">
									{!! Form::label('field', $field->field_name, array('class' => 'col-sm-4 form-control-label')) !!}
									<div class="col-sm-8">
										{!! Form::checkbox('pending', "1", '', array('class' => 'form-control checkbox-inline')) !!}
									</div>
								</div>
		                	@elseif($field->field_type == App\Models\Field::FILEBROWSER)
		                		<div class="form-group row">
									{!! Form::label('field', $field->field_name, array('class' => 'col-sm-4 form-control-label')) !!}
									<div class="col-sm-8">
					                	<label class="file">
					  						{!! Form::file('field_'.$field->id, '') !!}
					  						<span class="file-custom"></span>
										</label>
									</div>
								</div>
		                	@elseif($field->field_type == App\Models\Field::RADIOBUTTON)
		                		<div class="form-group row">
									{!! Form::label('field', $field->field_name, array('class' => 'col-sm-4 form-control-label')) !!}
									<div class="col-sm-8">
										{!! Form::radio('pending', "1", '', array('class' => 'form-control radio-inline')) !!}
									</div>
								</div>
		                	@elseif($field->field_type == App\Models\Field::SELECTLIST)	
		                		<?php
		                			$exploeded = [];
		                			$items = explode(',', $field->options);
		                			foreach($items as $item)
		                			{
		                				$exploded[$item] = $item;
		                			}
		                		?>
		                		<div class="form-group row">
									{!! Form::label('field', $field->field_name, array('class' => 'col-sm-4 form-control-label')) !!}
									<div class="col-sm-8">
										{!! Form::select('field_'.$field->id, $exploded, $field->conf($setting->id)?$field->conf($setting->id)->setting->value:'', array('class' => 'form-control c-select')) !!}
									</div>
								</div>
								<?php unset($exploded);  ?>
		                	@elseif($field->field_type == App\Models\Field::TEXTFIELD)
		                		<div class="form-group row">
									{!! Form::label('field', $field->field_name, array('class' => 'col-sm-4 form-control-label')) !!}
									<div class="col-sm-8">
										{!! Form::text('field_'.$field->id, $field->conf($setting->id)?$field->conf($setting->id)->setting->value:'', array('class' => 'form-control')) !!}
									</div>
								</div>
		                	@elseif($field->field_type == App\Models\Field::TEXTAREA)
		                		<div class="form-group row">
									{!! Form::label('field', $field->field_name, array('class' => 'col-sm-4 form-control-label')) !!}
									<div class="col-sm-8">
										{!! Form::textarea('field_'.$field->id, $field->conf($setting->id)?$field->conf($setting->id)->setting->value:'', array('class' => 'form-control', 'rows' => '2')) !!}
									</div>
								</div>
		                	@endif
		                @endforeach
		                </div>
						<div class="form-group row col-sm-offset-4">
							{!! Form::button("<i class='fa fa-check-circle'></i> ".trans('action.update'), 
								array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
							<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
							@if(Request::segment(2)=='equipment')
								<a href="#" class="btn btn-sm btn-pomegranate" onclick="generateICfile()"><i class="fa fa-cog"></i> {!! trans('action.generate-config') !!}</a>
							@endif
						</div>
					{!! Form::close() !!}
				</div>
				<div class="col-md-4" id="equipment">
					<ul class="list-group">
						<li class="list-group-item"><strong>{!! '<span id="setting_2">'.$setting->name.'</span> '.trans('menu.summary') !!}</strong></li>
						<div id="conf">
						@foreach($fields as $field)
							<li class="list-group-item">
								<h6>
									{!! $field->field_name !!}
									<small> 
										@if($field->field_type == App\Models\Field::FILEBROWSER)
											<div class="thumbnail">
												@if($field->setting)
						                        	{!! HTML::image(url().'/img/'.$field->conf($setting->id)->setting->value, 'Image not found', array('class'=>'img-responsive img-thumbnail')) !!}
						                        @endif
						                    </div>
										@else
											{!! $field->conf($setting->id)?$field->conf($setting->id)->setting->value:'' !!}
										@endif
									</small>
								</h6>
							</li>
						@endforeach
						</div>
					</ul>
				</div>
			</div>
	  	</div>
	</div>
</div>
{!! session(['SOURCE_URL' => URL::full()]) !!}
@endsection