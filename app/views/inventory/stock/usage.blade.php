@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
       <li><a href="{{{URL::route('stock.index')}}}">{{ Lang::choice('messages.stock', 2) }}</a></li>
	 	  <li class="active">{{ trans('messages.stock-usage') }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
@if($errors->all())
                <div class="alert alert-danger">
                    {{ HTML::ul($errors->all()) }}
                </div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.stock-usage') }}
	</div>
	<div class="panel-body">
        <div class="col-md-8">
    		   {{ Form::open(array('route' => array('stock.saveUsage', $stock->id), 'method' => 'POST')) }}
                {{ Form::hidden('stock_id', $stock->id) }}
                <div class="form-group">
                    {{ Form::label('signed-out', trans('messages.signed-out')) }}
                    {{ Form::text('quantity_used', Input::old('quantity_used'), array('class' => 'form-control')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('date-of-usage', trans('messages.date-of-usage')) }}
                    {{ Form::text('date_of_usage', Input::old('date_of_usage'), 
                            array('class' => 'form-control standard-datepicker')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('request', Lang::choice('messages.top-up', 1)) }}
                    {{ Form::select('request_id', $requests, '', array('class' => 'form-control')) }}
                </div>
                 <div class="form-group">
                    {{ Form::label('remarks', trans("messages.remarks")) }}
                    {{ Form::textarea('remarks', Input::old('remarks'), array('class' => 'form-control', 'rows' => '2')) }}
                </div>

                <div class="form-group actions-row">
                        {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
                            array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
                </div>
            {{ Form::close() }}
    	</div>
        <div class="col-md-4">
            <ul class="list-group">
                <li class="list-group-item"><strong>{{ Lang::choice('messages.item', 1).': '.$stock->item->name }}</strong></li>
                <li class="list-group-item"><h6>{{ trans("messages.unit") }}<small> {{ $stock->item->unit }}</small></h6></li>
                <li class="list-group-item"><h6>{{ trans('messages.lot-no') }}<small> {{ $stock->lot }}</small></h6></li>
                <li class="list-group-item"><h6>{{ trans('messages.available-qty') }}<small> {{ $stock->quantity() }}</small></h6></li>                      
            </ul>
        </div>
    </div>	
</div>
@stop
