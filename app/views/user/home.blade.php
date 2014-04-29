@extends("layout")
@section("content")
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-home	"></span>
			Home Page
		</div>
		<div class="panel-body">
			Welcome {{ Auth::user()->name }}!
		</div>
	</div>
@stop