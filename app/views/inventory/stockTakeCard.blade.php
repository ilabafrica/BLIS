@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="active">{{ Lang::choice('messages.stockTakeCard',2) }}</li>
	</ol>
</div>


<div class="container-fluid">
	{{ Form::open(array('route' => array('reports.aggregate.tat'), 'id' => 'turnaround', 'class' => 'form-inline')) }}
	<div class="row">
	<div class="col-sm-5">
		    	<div class="row">
					<div class="col-sm-2">
						{{ Form::label('start', trans("messages.monthly")) }}
					</div>
					<div class="col-sm-3">
					{{ Form::checkbox('agree', 0, false) }}
				    </div>
		    	</div>
		    </div>
		     <div class="col-sm-5">
		    	<div class="row">
					<div class="col-sm-2">
				    	{{ Form::label('end', trans("messages.quarterly")) }}
				    </div>
					<div class="col-sm-3">
					    {{ Form::checkbox('agree', 0, false) }}
			        </div>
		    	</div>
		    </div>


	</div>
	  	<div class="row">
			<div class="col-sm-5">
		    	<div class="row">
					<div class="col-sm-2">
						{{ Form::label('start', trans("messages.from")) }}
					</div>
					<div class="col-sm-3">
						{{ Form::text('start', isset($input['start'])?$input['start']:date('Y-m-01'), 
					        array('class' => 'form-control standard-datepicker')) }}
				    </div>
		    	</div>
		    </div>
		    <div class="col-sm-5">
		    	<div class="row">
					<div class="col-sm-2">
				    	{{ Form::label('end', trans("messages.to")) }}
				    </div>
					<div class="col-sm-3">
					    {{ Form::text('end', isset($input['end'])?$input['end']:date('Y-m-d'), 
					        array('class' => 'form-control standard-datepicker')) }}
			        </div>
		    	</div>
		    </div>
		 		</div>











@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		Monthly/Quarterly Stock Take(Inventory Control) Card
			</div>
	<div class="panel-body">
		
<table class="table table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>{{Lang::choice('messages.code',1)}}</th>
					<th>{{Lang::choice('messages.commodity',1)}}</th>
					<th>{{Lang::choice('messages.unit-of-issue',1)}}</th>
					<th>{{Lang::choice('messages.batch-no',1)}}</th>
					<th>{{Lang::choice('messages.expiry-date',1)}}</th>
					<th>{{Lang::choice('messages.stock-bal',1)}}</th>
					<th>{{Lang::choice('messages.physicalCount',1)}}</th>
					<th>{{Lang::choice('messages.unitPrice',1)}}</th>
					<th>{{Lang::choice('messages.totalPrice',1)}}</th>
					<th>{{Lang::choice('messages.discrepancy',1)}}</th>


					
				</tr>
			</thead>

			<tbody>
			<tr>
				</tr>				
			</tbody>
			</table>




		<?php  
		Session::put('SOURCE_URL', URL::full());?>
	</div>
	
</div>
@stop