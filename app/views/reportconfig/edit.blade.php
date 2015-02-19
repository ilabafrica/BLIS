@extends("layout")
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
	</div>
	{{ Form::open(array('url' => 'reportconfig.surveillance', 'id' => 'form-create-patient')) }}
		<div class="panel-body surveillance-input">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
			@foreach($diseaseTests as $diseaseTest)
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
		                <select class="form-control" name="test-type[{{ $diseaseTest->test_type_id }}]"> 
		                    <option value="0"></option>
		                    @foreach (TestType::all() as $testType)
		                        <option value="{{ $testType->id }}"
		                        	{{($testType->id == $diseaseTest->test_type_id) ? 'selected="selected"' : '' }}>
		                        	{{ $testType->name }}</option>
		                    @endforeach
		                </select>
					</div>
					<div class="col-md-6">
						<input class="form-control" name="disease[{{ $diseaseTest->id }}]"
							type="text" value="{{ $diseaseTest->disease }}">
					</div>
				</div>
            </div>
			@endforeach
		</div>
		<div class="panel-footer">
			<div class="form-group actions-row">
				{{ Form::button(
					'<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'), 
					['class' => 'btn btn-primary', 'onclick' => 'submit()']
				) }}
				{{ Form::button(trans('messages.cancel'), 
					['class' => 'btn btn-default', 'onclick' => 'javascript:history.go(-1)']
				) }}
				{{ Form::button(trans('messages.add-another-disease'), 
					['class' => 'btn btn-default add-another-disease']
				) }}
			</div>
		</div>
	{{ Form::close() }}
</div>
<div class="hidden addSurveillanceLoader">
	<div class="form-group">
		{{ Form::label('disease[]', TestType::find($diseaseTest->test_type_id)->name) }}
		<input class="form-control" name="disease[{{ $diseaseTest->id }}]"
			type="text" value="{{ $diseaseTest->disease }}">
	</div>
</div>
@stop