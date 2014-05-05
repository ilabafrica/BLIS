<div>
	<ol class="breadcrumb">
	  <li><a href="#">Home</a></li>
	  <li><a href="javascript:void(0);" onclick="pageloader('{{ URL::to("testtype") }}')">Test Type</a></li>
	  <li class="active">Create Test Type</li>
	</ol>
</div>
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-cog"></span>
		Create Test Type
	</div>
	{{ Form::open(array('url' => 'testtype', 'id' => 'form-create-testtype')) }}
	<div class="panel-body">
	<!-- if there are creation errors, they will show here -->
		
		@if($errors->all())
			<div class="alert alert-danger">
				{{ HTML::ul($errors->all()) }}
			</div>
		@endif

			<div class="form-group">
				{{ Form::label('name', 'Name') }}
				{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('description', 'Description') }}
				{{ Form::textarea('description', Input::old('description'), 
					array('class' => 'form-control', 'rows' => '2')) }}
			</div>
			<div class="form-group">
				{{ Form::label('section_id', 'Lab Section') }}
				{{ Form::select('section_id', $labsections, Input::old('section_id'), 
					array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('specimen_types', 'Compatible Specimen Types') }}
				<div class="form-pane panel panel-default">
				@foreach($specimentypes as $key=>$value)
					<div class="col-md-3">
						<label  class="checkbox">
							<input type="checkbox" name="specimentypes[]" value="{{ $value->id}}" />{{$value->name}}
						</label>
					</div>
				@endforeach
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('measures', 'Measures') }}
				<div class="form-pane panel panel-default">
					<div class="panel-body">
					@foreach($measures as $key=>$value)
						<div class="col-md-3">
							<label  class="checkbox">
								<input type="checkbox" name="measures[]" value="{{ $value->id}}" />{{$value->name}}
							</label>
						</div>
					@endforeach
					</div>
					<div class="panel-footer">
						<a class="btn btn-sm btn-info" href="javascript:void(0);" 
							onclick="">
							<span class="glyphicon glyphicon-plus-sign"></span>
							Create New Measure
						</a>
					</div>
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('targetTAT', 'Target Turnaround Time') }}
				{{ Form::text('targetTAT', Input::old('targetTAT'), array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('prevalence_threshold', 'Prevalence Threshold') }}
				{{ Form::text('prevalence_threshold', Input::old('prevalence_threshold'), 
					array('class' => 'form-control')) }}
			</div>
		</div>
		<div class="panel-footer">
			<div class="form-group actions-row">
				{{ Form::button(
					'<span class="glyphicon glyphicon-save"></span> Save',
					[
						'class' => 'btn btn-primary', 
						'onclick' => 'formsubmit("form-create-testtype")'
					] 
				) }}
			</div>
		</div>
	{{ Form::close() }}
</div>
