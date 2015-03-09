@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{{URL::route('inventory.labTopup')}}}">{{trans('messages.labTop-UpForm')}}</a></li>
	  <li class="active">{{ Lang::choice('messages.labTopUp',2) }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-edit"></span>
			{{trans('messages.edit-commodity-details')}}
		</div>
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
         {{ Form::model($commodity, array('route' => array('inventory.updateLabTopup', $commodity->id), 'method' => 'POST',
               'id' => 'form-edit-labTopup')) }}

		
           <div class="form-group">
                {{ Form::label('Date', Lang::choice('messages.date',1)) }}
                {{ Form::text('date', Input::old('date'), array('class' => 'form-control standard-datepicker')) }}
            </div>
           <div class="form-group">
                {{ Form::label('Commodity', trans('messages.commodity')) }}
                 {{ Form::text('commodity_id', Input::old('commodity_id'),array('class' => 'form-control', 'rows' => '2')) }}
                    
            </div>
            <div class="form-group">
                {{ Form::label('unit-of-issue', trans('messages.unit-of-issue')) }}
                {{ Form::text('unit_of_issue', Input::old('unit_of_issue'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('current-bal', trans('messages.current-bal')) }}
                {{ Form::text('current_bal', Input::old('current_bal'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('tests-done', trans('messages.tests-done')) }}
                {{ Form::text('tests_done', Input::old('tests_done'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('order-qty ', trans('messages.order-qty')) }}
                {{ Form::text('order_qty', Input::old('order_qty'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('issue-qty', Lang::choice('messages.issue-qty',1)) }}
                {{ Form::text('issue_qty', Input::old('issue_qty'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('issued-by ', trans('messages.issued-by')) }}
                {{ Form::text('issued_by', Input::old('issued_by'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Receivers Name ', trans('messages.receivers-name')) }}
                {{ Form::text('receivers_name', Input::old('receivers_name'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>   
            <div class="form-group">
                {{ Form::label('remarks ', trans('messages.remarks')) }}
                {{ Form::textarea('remarks', Input::old('remarks'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>           
            <div class="form-group actions-row">
                    {{ Form::button('<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'),
                         array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
                </div>

            {{ Form::close() }}
        </div>
    </div>
@stop   