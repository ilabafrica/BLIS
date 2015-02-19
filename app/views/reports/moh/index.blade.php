@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.report',2) }}</li>
	  <li class="active">{{ trans('messages.moh-706') }}</li>
	</ol>
</div>
<div class="panel panel-primary" style="font-size:8px;">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.moh-706') }}
	</div>
	<div class="panel-body">
	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif	
		<table width="100%">
			<thead>
	            <tr>
	            	<td colspan="3" style="text-align:center;">
	                    <strong><p>MINISTRY OF HEALTH<br>
	                    LABORATORY TESTS DATA SUMMARY REPORT FORM<br></p></strong>
	            	</td>
	            </tr>
            </thead>
		</table>
		<div class="table-responsive">
			<div class='container-fluid'>
				<strong>Facility Name: </strong><u>Bungoma District Hospital</u><strong> Reporting Period Begining: </strong><u>Bungoma District Hospital</u>
				<strong> Ending: </strong><u>Bungoma District Hospital</u><strong> Affilliation: </strong><u>GOK</u>
				<br />
				<p>N/B: INDICATE N/S Where there is no service</p>
				<div class='row'>
					{{ $table }}
					
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#sidebar').remove();
	$('#the-one-main').removeClass('col-md-10 col-md-offset-2');
	$('#the-one-main').addClass('col-md-12');
</script>
@stop