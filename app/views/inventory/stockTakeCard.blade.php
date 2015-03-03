@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="active">{{ Lang::choice('messages.stockTakeCard',2) }}</li>
	</ol>
</div>


<div class="container-fluid">
{{ Form::open(array('url' => 'inventory/store_stockTake', 'id' => 'form-stocktake')) }}
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
					<th>{{Lang::choice('messages.batch-no',1)}}</th>
					<th>{{Lang::choice('messages.expiry-date',1)}}</th>
					<th>{{Lang::choice('messages.stock-bal',1)}}</th>
					<th>{{Lang::choice('messages.physical-count',1)}}</th>
					<th>{{Lang::choice('messages.unit-price',1)}}</th>
					<th>{{Lang::choice('messages.total-price',1)}}</th>
					<th>{{Lang::choice('messages.discrepancy',1)}}</th>
					<!--<th>{{Lang::choice('messages.remarks',1)}}</th>-->


					
				</tr>
			</thead>

			<tbody>
			@foreach($commodities as $key => $value)
			<tr @if(Session::has('activecommodity'))
            {{(Session::get('activecommodity') == $value->id)?"class='info'":""}}
                        @endif
                        >
				<tr>
                 	<td>{{ $value->doc_no}}</td>
					<td>{{ Commodity::find($value->commodity_id)->commodity }}</td>
					<td>{{ $value->batch_no }}</td>
					<td>{{ $value->expiry_date }}</td>
					<td>{{ $value->qty }}</td>
					
					<td>            
					<div class="">
					{{ Form::text('physical-count', Input::old('physical-count'),array('class' => 'form-control', 'rows' => '2')) }}
                </div></td>
					<td>{{ $value->unit_price}}</td>
					<td><div class="">
                        {{ Form::text('total-price', Input::old('total-price'),array('class' => 'form-control', 'rows' => '2')) }}
                     </div></td>
					<td><div class="">
                
                {{ Form::text('discrepancy', Input::old('discrepancy'),array('class' => 'form-control', 'rows' => '2')) }}
                </div></td>
			
			   	</tr>
				@endforeach
				<tr> 
				<td>
				<div class="">
                    {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
                        array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
            </div>
            </td>
				</tr>
			</tbody>
			</table>
{{ Form::close() }}
		<?php  
		Session::put('SOURCE_URL', URL::full());?>
	</div>
	
</div>
@stop 