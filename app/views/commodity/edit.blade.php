@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
      <li><a href="{{{URL::route('commodity.index')}}}">{{trans('messages.commodityList')}}</a></li>
	 	<li class="active">{{ Lang::choice('messages.editCommodities',2) }}</li> 
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
		{{ Lang::choice('messages.commodities',2) }}
	</div>
	<div class="panel-body">
		  {{ Form::model($commodity, array('route' => array('commodity.update', $commodity->id), 'method' => 'PUT',
               'id' => 'form-edit-commodity')) }}
            <div class="form-group">
                {{ Form::label('Commodity', trans('messages.commodity')) }}
                {{ Form::text('commodity', Input::old('commodity'), array('class' => 'form-control', 'rows' => '2')) }}
            </div>
             <div class="form-group">
                {{ Form::label('description', trans('messages.description')) }}
                {{ Form::text('description', Input::old('description'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
             <div class="form-group">
                {{ Form::label('Unit of Issue', trans('messages.unit-of-issue')) }}
                {{ Form::select('unit_of_issue', array('' => '-- Select unit of issue--')+$metrics,
                    Request::old('metric') ? Request::old('metric') : $metric,
                    array('class' => 'form-control', 'id' => 'metrics_id')) }}
                
                  </div>
            <div class="form-group">
                {{ Form::label('unit-price', trans('messages.unit-price')) }}
                {{ Form::text('unit_price', Input::old('unit_price'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Item Code', trans('messages.item-code')) }}
                {{ Form::text('item_code', Input::old('item_code'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('storage req', trans('messages.storage-req')) }}
                {{ Form::text('storage_req', Input::old('storage_req'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('min level ', trans('messages.min-level')) }}
                {{ Form::text('min_level', Input::old('min_level'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('max level ', trans('messages.max-level')) }}
                {{ Form::text('max_level', Input::old('max_level'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
           

            <div class="form-group actions-row">
                    {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
                        array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
            </div>
        {{ Form::close() }}

		<?php  
		Session::put('SOURCE_URL', URL::full());?>
	</div>
	
</div>
@stop