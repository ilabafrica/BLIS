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
    		   {{ Form::model($lot, array('route' => array('lot.update', $lot->id), 'method' => 'PUT', 'id' => 'form-edit-lot')) }}
                {{ Form::hidden('stock_id', $lot->stock_id) }}
                {{ Form::hidden('id', $lot->id) }}
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
                    @foreach($requests as $record)
                    <div class="radio col-sm-offset-3">
                        <label>
                            <input type="radio" name="request_id" id="request_id" value="{{$record->id}}" {{ ($request == $record->id) ? 'checked' : ''}}>
                            {{ $record->item->name.'('.$record->quantity_ordered.') - '.$record->testCategory->name.'('.$record->remarks.')' }}
                        </label>
                    </div>
                    @endforeach
                </div>
                 <div class="form-group">
                    {{ Form::label('remarks', trans("messages.remarks")) }}
                    {{ Form::textarea('remarks', Input::old('remarks'), array('class' => 'form-control', 'rows' => '2')) }}
                </div>

                <div class="form-group actions-row">
                        {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.update'), 
                            array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
                </div>
            {{ Form::close() }}
    	</div>
        <div class="col-md-4">
            <ul class="list-group">
                <li class="list-group-item"><strong>{{ Lang::choice('messages.item', 1).': '.$lot->stock->item->name }}</strong></li>
                <li class="list-group-item"><h6>{{ trans("messages.unit") }}<small> {{ $lot->stock->item->unit }}</small></h6></li>
                <li class="list-group-item"><h6>{{ trans('messages.lot-no') }}<small> {{ $lot->stock->lot }}</small></h6></li>
                <li class="list-group-item"><h6>{{ trans('messages.available-qty') }}<small> {{ $lot->stock->quantity() }}</small></h6></li>                      
            </ul>
        </div>
    </div>	
</div>
@stop
