@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="active">{{trans('messages.test-type')}}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-cog"></span>
		{{trans('messages.list-test-types')}}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::to("testtype/create") }}" >
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{trans('messages.new-test-type')}}
			</a>
		</div>
	</div>
	<div class="panel-body">
	
		<div>
			<div>
					<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
					<script type="text/javascript" src="js/jquery.js"></script>
					<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>

					<body>

						{{ Datatable::table()
					    ->addColumn('Name','Description','Target Turnaround Time ', 'Prevalence Threshold', 'Actions')       // these are the column headings to be shown
					    ->setUrl(route('testtyp.datatables'))   // this is the route where data will be retrieved
					    ->render() }}
				
		</div>
	
		<?php //echo $testtypes->links(); 
		//Session::put('SOURCE_URL', URL::full());?>
	</div>


</div>

@stop