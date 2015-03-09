@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
       <li><a href="{{{URL::route('suppliers.index')}}}">{{trans('messages.suppliersList')}}</a></li>
	 	  <li class="active">{{ Lang::choice('messages.editSuppliers',2) }}</li>
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
		   {{ Form::model($suppliers, array('route' => array('suppliers.update', $suppliers->id), 'method' => 'PUT',
               'id' => 'form-edit-suppliers')) }}


            <div class="form-group">
                {{ Form::label('Suppliers Name', trans('messages.suppliers-name')) }}
                {{ Form::text('name', Input::old('name'), array('class' => 'form-control', 'rows' => '2')) }}
            </div>
             <div class="form-group">
                {{ Form::label('physical address', trans('messages.physical-address')) }}
                {{ Form::text('physical_address', Input::old('physical_address'), array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Phone No', trans('messages.phone-number')) }}
                {{ Form::text('phone_no', Input::old('phone_no'),array('class' => 'form-control', 'rows' => '2')) }}
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