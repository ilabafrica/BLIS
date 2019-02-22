@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('Home') }}</a></li>
	  <li><a href="{{{URL::route('mh4lmapper.index')}}}">{{ trans('mH4lmapper') }}</a></li>
	  <li class="active">{{trans('edit mH4l mapping')}}</li>
	</ol>
</div>
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-edit"></span>
		{{trans('Edit Mapping')}}
	</div>
	{{ Form::open(array('route' => array('mh4lmapper.update', $emrTestTypeAlias->id), 'id' => 'form-edit-surveillance', 'method' => 'PUT',)) }}
		<div class="panel-body surveillance-input">
			<div class="alert alert-danger error-div hidden">
				<ul><li>Please enter all fields</li></ul>
				@if($errors->all())
					{{ HTML::ul($errors->all()) }}
				@endif
			</div>
			<div class="row">
				<div class="col-sm-5 col-md-3">
	                <label>{{ Lang::choice('Test Type',2) }}</label>
				</div>
				<div class="col-sm-5 col-md-3">
	                <label>{{ Lang::choice('mHealth Equivalent',2) }}</label>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-5 col-md-3">
		                <select class="form-control" name="blistest"> 
		                    <option value="0"></option>
		                    @foreach ($testtypes as $testType)
		                        <option value="{{ $testType->id }}"
		                        	{{($testType->id == $emrTestTypeAlias->test_type_id) ? 'selected="selected"' : '' }}>
		                        	{{ $testType->name }}</option>
		                    @endforeach
		                </select>
					</div>
					<div class="col-sm-5 col-md-3">
					    <select class="form-control" name="mhealthequivalent"> 
					        <option value="0"></option>
					        @foreach ($mh4lmapper as $mh4l)
					            <option value="{{ $mh4l->data_element_id }}"
					            	{{($mh4l->data_element_id == $emrTestTypeAlias->emr_alias) ? 'selected="selected"' : '' }}>
					            	{{ $mh4l->name }}</option>
					        @endforeach
					    </select>
					</div>
				</div>
            </div>
		</div>
		<div class="panel-footer">
			<div class="form-group actions-row">
				<input class="hidden" name="from-form" type="text" value="from-form">
				{{ Form::button(
					'<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'), 
					['class' => 'btn btn-primary', 'type' => 'submit']
				) }}
			</div>
		</div>
	{{ Form::close() }}
</div>
@stop