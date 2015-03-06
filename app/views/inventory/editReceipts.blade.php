@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{{URL::route('inventory.labStockCard')}}}">{{trans('messages.inventory')}}</a></li>
	  <li class="active">{{ Lang::choice('messages.labStockCardReceipts',2) }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-edit"></span>
			{{trans('messages.edit-commodity-details')}}
		</div>
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
         {{ Form::model($commodity, array('route' => array('inventory.updateReceipts', $commodity->id), 'method' => 'POST',
               'id' => 'form-edit-commodity')) }}

		
            <div class="form-group">
                {{ Form::label('Receipt Date', Lang::choice('messages.lab-receipt-date',1)) }}
                {{ Form::text('receipt_date', Input::old('receipt_date'), array('class' => 'form-control standard-datepicker')) }}
            </div>
			<div class="form-group">
                {{ Form::label('Commodity', trans('messages.commodity')) }}
                {{ Form::select('commodity', array(null => '')+ $commodities,
                    Input::old('commodity'), array('class' => 'form-control', 'id' => 'selectedCommodity')) }}
            </div> 
                     
            <div class="form-group">
                {{ Form::label('Received From', trans('messages.received-from')) }}
                        
                  {{ Form::select('received_from', array(null => '')+ $suppliers,
                    Input::old('received_from'), array('class' => 'form-control', 'id' => 'received_from')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Unit Price', trans('messages.unit-price')) }}
                 {{ Form::text('unit_price', Input::old('unit_price'), array('class' => 'form-control', 'rows' => '2')) }}
            
            </div> 

            <div class="form-group">
                {{ Form::label('Doc. No.', trans('messages.doc-no')) }}
                {{ Form::text('doc_no', Input::old('doc_no'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Quantity', trans('messages.qty')) }}
                {{ Form::text('qty', Input::old('qty'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Batch No. ', trans('messages.batch-no')) }}
                {{ Form::text('batch_no', Input::old('qty'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Expiry Date', Lang::choice('messages.expiry-date',1)) }}
                {{ Form::text('expiry_date', Input::old('expiry_date'), array('class' => 'form-control standard-datepicker')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Location ', trans('messages.location')) }}
                {{ Form::text('location', Input::old('location'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Receivers Name ', trans('messages.receivers-name')) }}
                {{ Form::text('receivers_name', Input::old('receivers_name'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>           
				<div class="form-group actions-row">
					{{ Form::button('<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'),
						 array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
				</div>

			{{ Form::close() }}
		</div>
	</div>
@stop	