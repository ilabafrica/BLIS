@extends("app")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{trans('messages.surveillance')}}</li>
	</ol>
</div>
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-edit"></span>
		{{trans('messages.surveillance')}}
		<div class="panel-btn">
			<a href="{{{URL::route('reportconfig.disease')}}}" 
				class="btn btn-info add-another-disease-for-real">
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{ trans('messages.new-disease') }}</a>		
		</div>
	</div>
	{{ Form::open(array('route' => 'reportconfig.surveillance', 'id' => 'form-edit-surveillance')) }}
		<div class="panel-body surveillance-input">
			<div class="alert alert-danger error-div hidden">
				<ul><li>Please enter all fields</li></ul>
				@if($errors->all())
					{{ HTML::ul($errors->all()) }}
				@endif
			</div>
			<div class="row">
				<div class="col-sm-5 col-md-3">
	                <label>{{ Lang::choice('messages.test-type',2) }}</label>
				</div>
				<div class="col-sm-5 col-md-3">
	                <label>{{ Lang::choice('messages.disease',2) }}</label>
				</div>
			</div>
			@foreach($diseaseTests as $diseaseTest)
			<div class="form-group">
				<div class="row">
					<div class="col-sm-5 col-md-3">
		                <select class="form-control" name="surveillance[{{ $diseaseTest->id }}][test_type]"> 
		                    <option value="0"></option>
		                    @foreach ($testTypes as $testType)
		                        <option value="{{ $testType->id }}"
		                        	{{($testType->id == $diseaseTest->test_type_id) ? 'selected="selected"' : '' }}>
		                        	{{ $testType->name }}</option>
		                    @endforeach
		                </select>
					</div>
					<div class="col-sm-5 col-md-3">
					    <select class="form-control" name="surveillance[{{ $diseaseTest->id }}][disease]"> 
					        <option value="0"></option>
					        @foreach ($diseases as $disease)
					            <option value="{{ $disease->id }}"
					            	{{($disease->id == $diseaseTest->disease_id) ? 'selected="selected"' : '' }}>
					            	{{ $disease->name }}</option>
					        @endforeach
					    </select>
					</div>
					<div class="col-md-1">
					    <button class="close" aria-hidden="true" type="button"
							title="{{trans('messages.delete')}}">×</button>
					</div>
				</div>
            </div>
			@endforeach
		</div>
		<div class="panel-footer">
			<div class="form-group actions-row">
				<input class="hidden" name="fromForm" type="text" value="fromForm">
				{{ Form::button(
					'<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'), 
					['class' => 'btn btn-primary', 'onclick' => 'authenticate("#form-edit-surveillance")']
				) }}
				{{ Form::button(trans('messages.cancel'), 
					['class' => 'btn btn-default', 'onclick' => 'javascript:history.go(-1)']
				) }}
				{{ Form::button(trans('messages.add-another'), 
					['class' => 'btn btn-default add-another-surveillance', 'data-new-surveillance' => '1']
				) }}
			</div>
		</div>
	{{ Form::close() }}
</div>
<div class="hidden addSurveillanceLoader">
	<div class="form-group new">
		<div class="row">
			<div class="col-sm-5 col-md-3">
                <select class="form-control test-type" name=""> 
					<option value="0"></option>
					@foreach ($testTypes as $testType)
					    <option value="{{ $testType->id }}">{{ $testType->name }}</option>
					@endforeach
            	</select>
			</div>
			<div class="col-sm-5 col-md-3">
			    <select class="form-control disease" name=""> 
			        <option value="0"></option>
			        @foreach ($diseases as $disease)
			            <option value="{{ $disease->id }}">{{ $disease->name }}</option>
			        @endforeach
			    </select>
			</div>
		    <div class="col-md-1">
			    <button class="close" aria-hidden="true" type="button"
	        		title="{{trans('messages.delete')}}">×</button>
		    </div>
		</div>
    </div>
</div>
@stop