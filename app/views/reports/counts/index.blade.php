@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ trans('messages.reports') }}</li>
	  <li class="active">{{ trans('messages.counts') }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.counts') }}
	</div>
	<div class="panel-body">

		<!-- if there are search errors, they will show here -->
		@if($errors->all())
			<div class="alert alert-danger">
				{{ HTML::ul($errors->all()) }}
			</div>
		@endif
		<div class="row">
			<div class="col-md-8">
		{{ Form::open(array('route' => 'reports.daily.search', 'id' => 'form-search-daily-log')) }}
		  	<div class="form-group">
				{{ Form::label('name', trans("messages.from")) }}
				{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('description', trans("messages.to")) }}</label>
				{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('description', trans("messages.count-type")) }}</label>
				<div class="radio">
				  <label>
				    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>{{ trans('messages.test-count-ungrouped') }}
				  </label>
				</div>
				<div class="radio">
				  <label>
				    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2" checked>{{ trans('messages.test-count-grouped') }}
				  </label>
				</div>
				<div class="radio">
				  <label>
				    <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3" checked>{{ trans('messages.specimen-count-ungrouped') }}
				  </label>
				</div>
				<div class="radio">
				  <label>
				    <input type="radio" name="optionsRadios" id="optionsRadios4" value="option4" checked>{{ trans('messages.specimen-count-grouped') }}
				  </label>
				</div>
				<div class="radio">
				  <label>
				    <input type="radio" name="optionsRadios" id="optionsRadios5" value="option5" checked>{{ trans('messages.doctor-statistics') }}
				  </label>
				</div>
			</div>
			<div class="form-group actions-row">
				{{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.submit'), 
					array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
			</div>
		{{ Form::close() }}
		</div>
		<div class="col-md-4">
		<div class="alert alert-info" style="float:right" role="alert"><strong>Tips</strong>
		<p>{{ trans('messages.counts-report-tip') }}</p>
		</div></div>
		
</div>
	</div>

</div>
@stop