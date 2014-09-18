@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ trans('messages.reports') }}</li>
	  <li class="active">{{ trans('messages.daily-log') }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.daily-log') }}
	</div>
	<div class="panel-body">

		<!-- if there are search errors, they will show here -->
		@if($errors->all())
			<div class="alert alert-danger">
				{{ HTML::ul($errors->all()) }}
			</div>
		@endif
		<div class="alert alert-info" style="float:right" role="alert"><strong>Tips</strong>
		<p>{{ trans('messages.patient-report-tip') }}</p>
		</div>
		{{$results=''}}
		@if($results!='')
		<table class="table table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>{{ trans('messages.registration-number') }}</th>
					<th>{{ trans('messages.name') }}</th>
					<th>{{ trans('messages.gender') }}</th>
				</tr>
			</thead>
			<tbody>
			@foreach($results as $key => $value)
				<tr>
					<td>{{ $value->patient_number }}</td>
					<td>{{ $value->name }}</td>
					<td>@if($value-gender==0) M @else F @endif</td>
					<td>

					<!-- show the test category (uses the show method found at GET /testcategory/{id} -->
						<a class="btn btn-sm btn-success" href="" >
							<span class="glyphicon glyphicon-eye-open"></span>
							{{ trans('messages.view-report') }}
						</a>

					<!-- edit this test category (uses edit method found at GET /testcategory/{id}/edit -->
						<a class="btn btn-sm btn-info" href="" >							
							<span class="glyphicon glyphicon-edit"></span>
							{{ trans('messages.select-tests') }}
						</a>
					<!-- delete this test category (uses delete method found at GET /testcategory/{id}/delete -->
						<button class="btn btn-sm btn-danger delete-item-link"
							data-toggle="modal" data-target=".confirm-delete-modal"	
							data-id=''>
							<span class="glyphicon glyphicon-trash"></span>
							{{ trans('messages.generate-bill') }}
						</button>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		@endif
</div>
	</div>

</div>
@stop