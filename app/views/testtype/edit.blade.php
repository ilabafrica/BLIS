@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">Home</a></li>
	  <li><a href="{{ URL::route('testtype.index') }}">Test Type</a></li>
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
				{{ Form::select('section_id', $labsections->lists('name', 'id'), Input::old('section_id'), 
					array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('specimen_types', 'Select Specimen Types') }}
				<div class="form-pane panel panel-default">
					<div class="container-fluid">
						<?php 
							$cnt = 0;
							$zebra = "";
						?>
					@foreach($specimentypes as $key=>$value)
						{{ ($cnt%4==0)?"<div class='row $zebra'>":"" }}
						<?php
							$cnt++;
							$zebra = (((int)$cnt/4)%2==1?"row-striped":"");
						?>
						<div class="col-md-3">
							<label  class="checkbox">
								<input type="checkbox" name="specimentypes[]" value="{{ $value->id}}" 
									{{ in_array($value->id, $testtype->specimenTypes->lists('id'))?"checked":"" }} />
									{{$value->name }}
							</label>
						</div>
						{{ ($cnt%4==0)?"</div>":"" }}
					@endforeach
					</div>
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('measures', 'Select Measures') }}
				<div class="form-pane panel panel-default">
					<div class="container-fluid">
						<?php 
							$cnt = 0;
							$zebra = "";
						?>
					@foreach($measures as $key=>$value)
						{{ ($cnt%4==0)?"<div class='row $zebra'>":"" }}
						<?php
							$cnt++;
							$zebra = (((int)$cnt/4)%2==1?"row-striped":"");
						?>
						<div class="col-md-3 ">
							<label  class="checkbox">
								<input type="checkbox" name="measures[]" value="{{ $value->id}}" 
									{{ in_array($value->id, $testtype->measures->lists('id'))?"checked":"" }} />
									{{$value->name }}
							</label>
						</div>
						{{ ($cnt%4==0)?"</div>":"" }}
					@endforeach
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
				{{ Form::button('Cancel', 
					['class' => 'btn btn-default', 'onclick' => 'pageloader("'.URL::to('testtype').'")']
				) }}
			</div>
		</div>
	{{ Form::close() }}
</div>
@stop