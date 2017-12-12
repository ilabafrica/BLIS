@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
       <li><a href="{{{URL::route('request.index')}}}">{{ Lang::choice('messages.request', 2) }}</a></li>
	 	  <li class="active">{{ trans('messages.new').' '.Lang::choice('messages.request', 1) }}</li>
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
		Make {{ Lang::choice('messages.request', 1) }}
	</div>
	<div class="panel-body">
		   {{ Form::open(array('route' => 'request.store', 'id' => 'form-store-requests')) }}

            <div class="form-group">
                {{ Form::label('item', Lang::choice('messages.item', 1)) }}
                {{ Form::select('item_id', $items, '', array('class' => 'form-control')) }}
            </div>
            <div class="form-group">
                {{ Form::label('quantity-remaining', trans('messages.quantity-remaining')) }}
                {{ Form::number('quantity_remaining', Input::old('quantity_remaining'), array('class' => 'form-control')) }}
            </div>
            <div class="form-group">
                {{ Form::label('test-category', Lang::choice('messages.test-category', 1)) }}
                {{ Form::select('test_category_id', $testCategories, '', array('class' => 'form-control')) }}
            </div>            
            <div class="form-group">
                {{ Form::label('tests', trans('messages.tests-done')) }}
                {{ Form::number('tests_done', Input::old('tests_done'), array('class' => 'form-control')) }}
            </div>            
            <div class="form-group">
                {{ Form::label('quantity', trans('messages.quantity')." ".trans('messages.requested')) }}
                {{ Form::number('quantity_ordered', Input::old('quantity_ordered'), array('class' => 'form-control')) }}
            </div>
             <div class="form-group">
                {{ Form::label('remarks', trans('messages.remarks')) }}
                {{ Form::textarea('remarks', Input::old('remarks'), array('class' => 'form-control', 'rows' => '2')) }}
            </div>

            <div class="form-group actions-row">
                    {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
                        array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
            </div>
        {{ Form::close() }}
	</div>
	
</div>
@stop
