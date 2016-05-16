@extends("layout")
@section("content")

	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{ URL::route('user.home')}}}">{{trans('messages.home') }}</a></li>
		  <li><a href="{{ URL::route('billing.index') }}">{{trans('messages.billing') }}</a></li>
		</ol>
	</div>	
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-edit"></span>
			{{ trans('messages.billing') }}
		</div>
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
			@if (Session::has('message'))
				<div class="alert alert-info">{{ Session::get('message') }}</div>
			@endif
			<div class="row">
				<div class="col-md-7"> 
				{{ Form::model($billing, array('route' => array('billing.update', $billing->id), 'method' => 'PUT', 'id' => 'form-edit-billing', 'files' => true)) }}
					<div class="checkbox col-md-offset-3">
					    <label>
					      	{{ Form::checkbox('enabled', '1', false) }} <strong>{{ trans('messages.enable-billing') }}</strong>
					    </label>
					</div>
					<div class="form-group">
						{{ Form::label('default_currency', trans('messages.default-currency')) }}
						{{ Form::text('default_currency', Input::old('default_currency'), array('class' => 'form-control')) }}
					</div>
					<div class="form-group">
						{{ Form::label('currency_delimiter', trans('messages.currency-delimiter')) }}
						{{ Form::text('currency_delimiter', Input::old('currency_delimiter'), array('class' => 'form-control')) }}
					</div>
					<div class="form-group">
	                	{{ Form::label('image', trans('messages.currency-logo')) }}
	                    {{ Form::file("image") }}
	                </div>
					<div class="form-group col-md-offset-3">
	                	<img class="img-responsive img-thumbnail user-image"
	                		src="{{ $billing->image }}" 
	                		alt="{{trans('messages.image-alternative')}}"></img>
	                </div>
					<div class="form-group actions-row">
						{{ Form::button('<span class="glyphicon glyphicon-save"></span> '. trans('messages.save'), 
							['class' => 'btn btn-primary', 'onclick' => 'submit()']) }}
					</div>
				{{ Form::close() }}
				</div>
				<div class="col-md-5">
					<ul class="list-group">
						<li class="list-group-item disabled"><strong>Page Help</strong></li>
						<li class="list-group-item">Enable Billing: Toggles whether or not your lab uses the billing engine.</li>
						<li class="list-group-item">Currency Name: Denotes what name will be used when printing monetary amounts in the billing engine.</li>
						<li class="list-group-item">Currency Delimiter: Denotes what is used to separate 'shillings' from 'cents' when printing monetary amounts in the billing engine. For example, the '.' in 10.50</li>
					</ul>
				</div>
			</div>
		</div>
		{{ Session::put('SOURCE_URL', URL::full()) }}
	</div>
@stop	