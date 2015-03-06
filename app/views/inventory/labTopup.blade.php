

@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{{URL::route('inventory.labTopup')}}}">{{ trans('messages.labTop-UpForm') }}</a></li>
	
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{trans('messages.labTop-UpForm')}}
		<div class="panel-btn">
            <a class="btn btn-sm btn-info" href="{{ URL::route('inventory.formLabTopup') }}">
                <span class="glyphicon glyphicon-plus-sign"></span>
                {{trans('messages.labTopUp')}}
            </a>
           
        </div>
	</div>
    
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed">
            <thead>
                <tr>
                    <th>{{Lang::choice('messages.date',1)}}</th>
                    <th>{{Lang::choice('messages.commodity',1)}}</th>
                    <th>{{Lang::choice('messages.current-bal',1)}}</th>
                    <th>{{Lang::choice('messages.tests-done',1)}}</th>
                    <th>{{Lang::choice('messages.order-qty',1)}}</th>
                    <th>{{Lang::choice('messages.issue-qty',1)}}</th>
                    <th>{{Lang::choice('messages.issued-by',1)}}</th>
                    <th>{{Lang::choice('messages.receivers-name',1)}}</th>
                    <th>{{Lang::choice('messages.remarks',1)}}</th>
                    <th>{{Lang::choice('messages.actions',1)}}</th>
                    
                </tr>
            </thead>
            <tbody>
            @foreach($commodities as $key => $commodity)
            <tr @if(Session::has('activecommodity'))
                            {{(Session::get('activecommodity') == $commodity->id)?"class='info'":""}}
                        @endif
                        >
                <tr>
                    <td>{{ $commodity->date}}</td>
                    <td>{{ $commodity->commodity->name }}</td>
                    <td>{{ $commodity->current_bal}}</td>
                    <td>{{ $commodity->tests_done }}</td>
                    <td>{{ $commodity->order_qty }}</td>
                    <td>{{ $commodity->issue_qty}}</td>
                    <td>{{ $commodity->user->name }}</td>
                    <td>{{ $commodity->receivers_name }}</td>
                    <td>{{ $commodity->remarks }}</td>
                    <td> 
                        <!-- edit this commodity (uses the edit method found at GET /inventory/{id}/edit -->
                    <a class="btn btn-sm btn-info" href="{{ URL::route('inventory.editLabTopup', array($value->id)) }}" >
                            <span class="glyphicon glyphicon-edit"></span>
                            {{trans('messages.edit')}}
                    </a>
                        <!-- delete this commodity (uses the delete method found at GET /inventory/{id}/delete -->
                    <button class="btn btn-sm btn-danger delete-item-link" 
                            data-toggle="modal" data-target=".confirm-delete-modal" 
                            data-id="{{ URL::route('inventory.deleteLabTopupCommodity', array($value->id)) }}">
                            <span class="glyphicon glyphicon-trash"></span>
                            {{trans('messages.delete')}}
                    </button>



                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
            </div>
       



		
		<?php  
		Session::put('SOURCE_URL', URL::full());?>
	</div>
	
</div>
@stop