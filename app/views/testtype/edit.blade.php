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
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
			{{ Form::model($testtype, array(
					'route' => array('testtype.update', $testtype->id), 'method' => 'PUT',
					'id' => 'form-edit-testtype'
				)) }}

				<div class="form-group">
					{{ Form::label('name', 'Name') }}
					{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('description', 'Description') }}
					{{ Form::textarea('description', Input::old('description'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('section_id', 'Section') }}
					{{ Form::select('section_id', $labsections, Input::old('section_id')) }}
				</div>
				<div class="form-group">
					{{ Form::label('targetTAT', 'Target Turnaround Time') }}
					{{ Form::text('targetTAT', Input::old('targetTAT'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('prevalence_threshold', 'Prevalence Threshold') }}
					{{ Form::text('prevalence_threshold', Input::old('prevalence_threshold'), array('class' => 'form-control')) }}
				</div>
				<div class="form-group actions-row">
				</div>
					{{ Form::button('<span class="glyphicon glyphicon-save"></span> Save', 
						['class' => 'btn btn-primary', 'onclick' => 'formsubmit("form-edit-testtype")']
					) }}

			{{ Form::close() }}
		</div>
	</div>
