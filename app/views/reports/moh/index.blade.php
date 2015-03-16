@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li><a href="{{{URL::route('reports.patient.index')}}}">{{ Lang::choice('messages.report',2) }}</a></li>
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
	                    <strong><p>{{ strtoupper(Lang::choice('messages.moh', 1)) }}<br>
	                    {{ strtoupper(Lang::choice('messages.lab-tests-data-report', 1)) }}<br></p></strong>
	            	</td>
	            </tr>
            </thead>
		</table>
		<div class="table-responsive">
			<div class='container-fluid'>
				<strong>{{ Lang::choice('messages.facility', 1) }}: </strong><u>{{ strtoupper(Config::get('kblis.organization')) }}</u><strong> {{ Lang::choice('messages.reporting-period', 1) }} {{ Lang::choice('messages.begin-end', 1) }}: </strong><u>{{ date('01-m-Y') }}</u>
				<strong> {{ Lang::choice('messages.begin-end', 2) }}: </strong><u>{{ date('d-m-Y') }}</u><strong> {{ Lang::choice('messages.affiliation', 1) }}: </strong><u>{{ Lang::choice('messages.gok', 1) }}: </u>
				<br />
				<p>{{ Lang::choice('messages.no-service', 1) }}</p>
				<div class='row'>
					{{ $table }}
					
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('.sidebar').remove();
	$('#the-one-main').removeClass('col-md-10 col-md-offset-2');
	$('#the-one-main').addClass('col-md-12');
</script>
@stop