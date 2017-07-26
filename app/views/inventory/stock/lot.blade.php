@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
      <li><a href="{{{URL::route('item.index')}}}">{{ Lang::choice('messages.item', 2) }}</a></li>
      <li><a href="{{{URL::route('stocks.log',array($lt->stock->item->id))}}}">{{ Lang::choice('messages.stock', 2) }}</a></li>
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
    		   {{ Form::model($lt, array('route' => array('lt.update', $lt->id), 'method' => 'PUT', 'id' => 'form-edit-lt')) }}
                {{ Form::hidden('stock_id', $lt->stock_id) }}
                {{ Form::hidden('id', $lt->id) }}
                <div class="form-group">
                    {{ Form::label('signed-out', trans('messages.signed-out')) }}
                    {{ Form::text('quantity_used', Input::old('quantity_used'), array('class' => 'form-control')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('date-of-usage', trans('messages.date-of-usage')) }}
                    {{ Form::text('date_of_usage', Input::old('date_of_usage'), 
                            array('class' => 'form-control standard-datepicker')) }}
                </div>
                <div class="panel panel-default">
                    <table class="table table-striped table-hover table-condensed search-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>{{trans('messages.date')}}</th>
                                <th>{{trans('messages.requested-by')}}</th>
                                <th>{{Lang::choice('messages.test-category',1)}}</th>
                                <th>{{trans('messages.quantity')}}</th>
                                <th>{{trans('messages.remarks')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                    @foreach($requests as $record)
                            <tr>
                                <td>
                                    <input type="radio" name="request_id" id="request_id" value="{{$record->id}}" {{ ($request == $record->id) ? 'checked' : ''}}>
                                </td>
                                <td>{{ $record->created_at}}</td>
                                <td>{{ $record->user->name}}</td>
                                <td>{{$record->testCategory->name}}</td>
                                <td>{{(count($record->usage)>0?$record->quantity_ordered-$record->issued():$record->quantity_ordered)}}</td>
                                <td>{{$record->remarks}}</td>
                            </tr>
                    @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="form-group">
                    {{ Form::label('issued-by', trans('messages.issued-by')) }}
                    {{ Form::text('issued_by', Input::old('issued_by'), array('class' => 'form-control')) }}
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
                        {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.update'), 
                            array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
                </div>
            {{ Form::close() }}
    	</div>
        <div class="col-md-4">
            <ul class="list-group">
                <li class="list-group-item"><strong>{{ Lang::choice('messages.item', 1).': '.$lt->stock->item->name }}</strong></li>
                <li class="list-group-item"><h5><strong>{{ trans("messages.unit").': ' }}</strong>{{ $lt->stock->item->unit }}</h5></li>
                <li class="list-group-item"><h5><strong>{{ trans('messages.lt-no').': ' }}</strong>{{ $lt->stock->lt }}</h5></li>
                <li class="list-group-item"><h5><strong>{{ trans('messages.available-qty').': ' }}</strong>{{ $lt->stock->quantity() }}</h5></li>
            </ul>
        </div>
    </div>	
</div>
@stop
