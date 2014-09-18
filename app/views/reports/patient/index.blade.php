@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ trans('messages.reports') }}</li>
	  <li class="active">{{ trans('messages.patient-report') }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.patient-report') }}
	</div>
	<div class="panel-body">
	<!-- if there are search errors, they will show here -->
		@if($errors->all())
			<div class="alert alert-danger">
				{{ HTML::ul($errors->all()) }}
			</div>
		@endif
<!-- 
		{{ Form::open(array('method' => 'POST', 'route' => 'reports.patient.search', 'id' => 'form-search-patient', 'class' => 'navbar-form navbar-left', 'role' => 'search')) }}
		  <div class="form-group">
		  	{{ Form::text('value', Input::old('value'), array('class' => 'form-control', 'placeholder' => 'Search')) }}
		  </div>
  		  {{ Form::button("<span class='glyphicon glyphicon-search'></span> ".trans('messages.search'), 
						array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
		{{ Form::close() }} -->
		<div class="alert alert-info" style="float:right" role="alert"><strong>Tips</strong>
		<p>{{ trans('messages.patient-report-tip') }}</p>
		
</div>
		{{ Datatable::table()
	    ->addColumn('ID','Patient number' ,'Registration number','Gender', 'Action(s)')       // these are the column headings to be shown
	    ->setUrl(route('api.patientreport'))   // this is the route where data will be retrieved
	    ->render() }}
	</div>

</div>
<script type="text/javascript">
	$(document).ready(function() { $('tbody').on('click', '.confirm-delete-user', function(){ alert('ok'); }); });
</script>
@stop