@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	 	  <li class="active">{{ Lang::choice('messages.suppliers',2) }}</li>
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
		{{ Lang::choice('messages.suppliers',2) }}
	</div>
	<div class="panel-body">
		   {{ Form::open(array('url' => 'supplier/store_supplier', 'id' => 'form-commodity')) }}

            <div class="form-group">
                {{ Form::label('Suppliers Name', trans('messages.suppliers-name')) }}
                {{ Form::text('suppliers-name', Input::old('suppliers-name'), array('class' => 'form-control', 'rows' => '2')) }}
            </div>
             <div class="form-group">
                {{ Form::label('physical address', trans('messages.physical-address')) }}
                {{ Form::text('physical-address', Input::old('physical-address'), array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Phone No', trans('messages.phone-number')) }}
                {{ Form::text('phone-number', Input::old('phone-number'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('email', trans('messages.email')) }}
                {{ Form::text('email', Input::old('email'),array('class' => 'form-control', 'rows' => '2')) }}
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