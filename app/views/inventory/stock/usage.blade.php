@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
      <li><a href="{{{URL::route('item.index')}}}">{{ Lang::choice('messages.item', 2) }}</a></li>
      <li><a href="{{{URL::route('stocks.log',array($stock->item->id))}}}">{{ Lang::choice('messages.stock', 2) }}</a></li>
	  <li class="active">{{ trans('messages.issue')}} {{Lang::choice('stock', 2) }}</li>
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
		<span class="glyphicon glyphicon-shopping-cart"></span>
		{{ trans('messages.issue') }} {{$stock->item->name}}
	</div>
	<div class="panel-body">
        <div class="col-md-8">
    		   {{ Form::open(array('route' => array('stock.saveUsage', $stock->id), 'method' => 'POST')) }}
                {{ Form::hidden('stock_id', $stock->id) }}
                <div class="form-group">
                    {{ Form::label('signed-out', trans('messages.signed-out')) }}
                    {{ Form::number('quantity_used', Input::old('quantity_used'), array('class' => 'form-control')) }}
                    <p class="form-control-static"> {{$stock->item->unit}} </p>
                </div>
                <div class="form-group">
                    {{ Form::label('date-of-usage', trans('messages.date-of-usage')) }}
                    {{ Form::text('date_of_usage', Input::old('date_of_usage'), 
                            array('class' => 'form-control standard-datepicker')) }}
                </div>
                <div class="panel panel-default">
                    <!-- {{ Form::label('request', Lang::choice('messages.top-up', 1)) }} -->
                    <table class="table table-striped table-hover table-condensed">
                        <thead>
                            <tr>
                                <th></th>
                                <th>{{trans('messages.requested-by')}}</th>
                                <th>{{Lang::choice('messages.test-category',1)}}</th>
                                <th>{{trans('messages.quantity')}}</th>
                                <th>{{trans('messages.remarks')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $request)
                                @if( (count($request->usage)>0 && ($request->quantity_ordered-$request->issued())>0) || count($request->usage)==0)
                                <tr>
                                    <td>
                                        <input type="radio" name="request_id" id="request_id" value="{{$request->id}}" {{ ($record == $request->id||Input::old('request_id')) ? 'checked' : ''}}>
                                    </td>
                                    <td>{{ $request->user->name}}</td>
                                    <td>{{$request->testCategory->name}}</td>
                                    <td>{{(count($request->usage)>0?$request->quantity_ordered-$request->issued():$request->quantity_ordered)}}</td>
                                    <td>{{$request->remarks}}</td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="form-group">
                    {{ Form::label('issued-by', trans('messages.issued-by')) }}
                    <p class="form-control-static">{{Auth::user()->name}}</p>
                    {{ Form::hidden('issued_by', Auth::user()->name) }}
                </div>
                <div class="form-group">
                    {{ Form::label('received-by', trans('messages.received-by')) }}
                    {{ Form::text('received_by', Input::old('received_by'), array('class' => 'form-control')) }}
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
                <li class="list-group-item"><h5><strong>{{ trans("messages.unit").': ' }}</strong>{{ $stock->item->unit }}</h5></li>
                <li class="list-group-item"><h5><strong>{{ trans('messages.lot-no').': ' }}</strong>{{ $stock->lot }}</h5></li>
                <li class="list-group-item"><h5><strong>{{ trans('messages.available-qty').': ' }}</strong>{{ $stock->quantity() }}</h5></li>                      
            </ul>
        </div>
    </div>	
</div>
@stop
