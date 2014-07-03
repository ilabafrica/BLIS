	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">Home</a></li>
		  <li>
		  	<a href="javascript:void(0);" onclick="pageloader('{{ URL::to("testcategory") }}')">
		  		Lab Section
		  	</a>
		  </li>
		  <li class="active">Edit Lab Section</li>
		</ol>
	</div>
	<div class="panel panel-primary patient-create">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-edit"></span>
			Edit Lab Section Details
		</div>
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
			{{ Form::model($testcategory, array('route' => array('testcategory.update', $testcategory->id), 
				'method' => 'PUT', 'id' => 'form-edit-testcategory')) }}

				<div class="form-group">
					{{ Form::label('name', 'Name') }}
					{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
				</div>
				
                
				<div class="form-group">
					{{ Form::label('description', 'Description') }}
					{{ Form::textarea('description', Input::old('description'), 
						array('class' => 'form-control', 'rows' => '2')) }}
				</div>
				<div class="form-group actions-row">
					{{ Form::button('<span class="glyphicon glyphicon-save"></span> Save', 
						['class' => 'btn btn-primary', 'onclick' => 'formsubmit("form-edit-testcategory")']) }}
				</div>

			{{ Form::close() }}
		</div>
	</div>