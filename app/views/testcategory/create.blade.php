	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">Home</a></li>
		  <li>
		  	<a href="{{ URL::route('testcategory.index') }}">Lab Section</a>
		  </li>
		  <li class="active">Create Lab Section</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			Create Lab Section
		</div>
		<div class="panel-body">
		<!-- if there are creation errors, they will show here -->
			
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif

			{{ Form::open(array('url' => 'testcategory', 'id' => 'form-create-testcategory')) }}

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
						array('class' => 'btn btn-primary', 'onclick' => 'formsubmit("form-create-testcategory")')) }}
				</div>

			{{ Form::close() }}
		</div>
	</div>