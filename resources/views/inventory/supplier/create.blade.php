@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
       <li><a href="{{{URL::route('supplier.index')}}}">{{ trans_choice('messages.supplier', 2) }}</a></li>
	 	  <li class="active">{{ trans('messages.new').' '.trans_choice('messages.supplier', 1) }}</li>
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
		{{ trans_choice('messages.supplier', 2) }}
	</div>
	<div class="panel-body">
		   {{ Form::open(array('route' => 'supplier.store', 'id' => 'form-store_suppliers')) }}

            <div class="form-group">
                {{ Form::label('name', trans_choice('messages.name', 1)) }}
                {{ Form::text('name', Input::old('name'), array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('phone', trans('messages.phone')) }}
                {{ Form::text('phone', Input::old('phone'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('email', trans('messages.email')) }}
                {{ Form::text('email', Input::old('email'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
             <div class="form-group">
                {{ Form::label('address', trans('messages.address')) }}
                {{ Form::textarea('address', Input::old('address'), array('class' => 'form-control', 'rows' => '2')) }}
            </div>

            <div class="form-group actions-row">
                    {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
                        array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
            </div>
        {{ Form::close() }}
	</div>
	
</div>
@stop
