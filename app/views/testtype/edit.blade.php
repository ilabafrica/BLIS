<div>
	<ol class="breadcrumb">
	  <li><a href="#">Home</a></li>
	  <li><a href="javascript:void(0);" onclick="pageloader('{{ URL::to("testtype") }}')">Test Type</a></li>
	  <li class="active">Edit Test Type</li>
	</ol>
</div>
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-edit"></span>
		Edit Test Type
	</div>
	{{ Form::model($testtype, array(
			'route' => array('testtype.update', $testtype->id), 'method' => 'PUT',
			'id' => 'form-edit-testtype'
		)) }}
		<div class="panel-body">
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
					array('class' => 'form-control', 'rows' => '2' )) }}
			</div>
			<div class="form-group">
				{{ Form::label('section_id', 'Section') }}
				{{ Form::select('section_id', $labsections, Input::old('section_id'), 
					array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('specimen_types', 'Compatible Specimen Types') }}
				<div class="form-pane panel panel-default">
					<?php $tst = $testtype->specimenTypes->lists('id'); ?>
				@foreach($specimentypes as $key=>$value)
					<div class="col-md-3">
						<label  class="checkbox">
							<input type="checkbox" name="specimentypes[]" value="{{ $value->id}}" 
								{{ in_array($value->id, $tst)?"checked":"" }} />
								{{$value->name }}
						</label>
					</div>
				@endforeach
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('measures', 'Measures') }}
				<div class="form-pane panel panel-default">
					<div class="panel-body">
						<!-- Read from testtypes_measures -->
					</div>
					<div class="panel-footer">
						<a class="btn btn-sm btn-info" href="javascript:void(0);" 
							onclick="" data-toggle="modal" data-target=".add-measures-modal">
							<span class="glyphicon glyphicon-plus-sign"></span>
							Add Measures
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
				{{ Form::button('<span class="glyphicon glyphicon-save"></span> Save', 
					['class' => 'btn btn-primary', 'onclick' => 'formsubmit("form-edit-testtype")']
				) }}
			</div>
		</div>
	{{ Form::close() }}
</div>

<!-- Measures modal-->
<div class="modal fade add-measures-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add Measures</h4>
      </div>
      <div class="modal-body">
		<div class="form-group">
			<div class="form-pane">
				@foreach($measures as $key=>$value)
					<div class="col-md-4">
						<label  class="checkbox">
							<input type="checkbox" name="m_{{ $value->id}}" />{{$value->name}}
						</label>
					</div>
				@endforeach
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
