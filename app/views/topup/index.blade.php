@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{{URL::route('topup.index')}}}">{{ trans('messages.topup') }}</a></li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{trans('messages.topup')}}
		<div class="panel-btn">
            <a class="btn btn-sm btn-info" href="{{ URL::route('topup.create') }}">
                <span class="glyphicon glyphicon-plus-sign"></span>
                {{trans('messages.request-topup')}}
            </a>
        </div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed search-table">
            <thead>
                <tr>
                    <th>{{Lang::choice('messages.date',1)}}</th>
                    <th>{{Lang::choice('messages.commodity',1)}}</th>
                    <th>{{Lang::choice('messages.test-category',1)}}</th>
                    <th>{{Lang::choice('messages.order-qty',1)}}</th>
                    <th>{{Lang::choice('messages.user',1)}}</th>
                    <th>{{Lang::choice('messages.remarks',1)}}</th>
                    <th>{{Lang::choice('messages.actions',1)}}</th>
                </tr>
            </thead>
            <tbody>
            @foreach($topupRequests as $topupRequest)
            <tr @if(Session::has('activecommodity')){{(Session::get('activecommodity') == $topupRequest->id)?"class='info'":""}} @endif >
                <tr>
                    <td>{{ $topupRequest->created_at}}</td>
                    <td>{{ $topupRequest->commodity->name }}</td>
                    <td>{{ $topupRequest->section->name }}</td>
                    <td>{{ $topupRequest->order_quantity }}</td>
                    <td>{{ $topupRequest->user->name }}</td>
                    <td>{{ $topupRequest->remarks }}</td>
                    <td>
                    @if(Entrust::can('manage_inventory'))
                        <!-- allows inventory manager to fullfil issue request -->
                        <a class="btn btn-sm btn-info" href="{{ URL::route('issue.dispatch', array($topupRequest->id)) }}" >
                                <span class="glyphicon glyphicon-edit"></span>
                                {{Lang::choice('messages.issue', 1)}}
                        </a>
                    @endif
                        <!-- edit this commodity (uses the edit method found at GET /inventory/{id}/edit -->
                        <a class="btn btn-sm btn-info" href="{{ URL::route('topup.edit', array($topupRequest->id)) }}" >
                                <span class="glyphicon glyphicon-edit"></span>
                                {{trans('messages.edit')}}
                        </a>
                            <!-- delete this commodity (uses the delete method found at GET /inventory/{id}/delete -->
                        <button class="btn btn-sm btn-danger delete-item-link" 
                                data-toggle="modal" data-target=".confirm-delete-modal" 
                                data-id="{{ URL::route('topup.delete', array($topupRequest->id)) }}">
                                <span class="glyphicon glyphicon-trash"></span>
                                {{trans('messages.delete')}}
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
            </div>
		<?php Session::put('SOURCE_URL', URL::full());?>
	</div>
</div>
@stop