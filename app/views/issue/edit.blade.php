@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{{URL::route('issues.index')}}}">{{trans('messages.issues')}}</a></li>
	  <li class="active">{{ Lang::choice('messages.add-issues',2) }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-edit"></span>
			{{trans('messages.edit-issue-details')}}
		</div>
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
         {{ Form::model($commodity, array('route' => array('issues.update', $issue->id), 'method' => 'PUT',
               'id' => 'form-edit-issue')) }}
            <div class="form-group">
                {{ Form::label('Doc No. ', trans('messages.doc-no')) }}
                {{ Form::text('doc_no', Input::old('doc_no'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
           <div class="form-group">
                {{ Form::label('commodity', trans('messages.commodity')) }}
                 {{ Form::select('commodity', array(null => '')+ $commodities,
                    $commodity->id, array('class' => 'form-control', 'id' => 'commodity-id')) }}
            </div>
             <div class="form-group">
                {{ Form::label('Batch No. ', trans('messages.batch-no')) }}
                {{ Form::text('batch_no', Input::old('batch_no'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Expiry Date', Lang::choice('messages.expiry-date',1)) }}
                {{ Form::text('expiry_date', Input::old('expiry_date'), array('class' => 'form-control standard-datepicker')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Quantity Available ', trans('messages.qty-avl')) }}
                {{ Form::text('qty_avl', Input::old('qty_avl'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Quantity', trans('messages.qty-req')) }}
                {{ Form::text('qty_req', Input::old('qty_req'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Destination ', trans('messages.destination')) }}
                {{ Form::text('destination', Input::old('destination'), array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('Receivers Name ', trans('messages.receivers-name')) }}
                {{ Form::text('receivers_name', Input::old('receivers_name'),array('class' => 'form-control', 'rows' => '2')) }}
            <div class="form-group actions-row">
                    {{ Form::button('<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'),
                         array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
                </div>
            {{ Form::close() }}
        </div>
    </div>
@stop   