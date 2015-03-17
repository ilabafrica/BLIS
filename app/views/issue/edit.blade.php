@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{{URL::route('issue.index')}}}">{{Lang::choice('messages.issue',2)}}</a></li>
	  <li class="active">{{ trans('messages.edit-issue-details') }}</li>
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
         {{ Form::model($issue, array('route' => array('issue.update', $issue->id), 'method' => 'PUT', 'id' => 'form-edit-issue')) }}
           <div class="form-group">
                {{ Form::label('commodity', trans('messages.commodity')) }}
                 {{ Form::select('commodity', array(null => '')+ $commodities, $issue->topupRequest->commodity_id, 
                    array('class' => 'form-control')) }}
            </div>
             <div class="form-group">
                {{ Form::label('batch_no', trans('messages.batch-no')) }}
                {{ Form::select('batch_no', array(null => '')+ $batches, $issue->receipt->id,
                    array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('quantity_available', trans('messages.qty-avl')) }}
                {{ Form::text('quantity_available', $available ,array('class' => 'form-control', 'rows' => '2', 'disabled')) }}
            </div>
            <div class="form-group">
                {{ Form::label('quantity_required', trans('messages.quantity-required')) }}
                {{ Form::text('quantity_required', $available ,array('class' => 'form-control', 'rows' => '2', 'disabled')) }}
            </div>
            <div class="form-group">
                {{ Form::label('quantity_issued', trans('messages.qty-issued')) }}
                {{ Form::text('quantity_issued', Input::old('quantity_issued'),array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('lab_section ', trans('messages.destination')) }}
                {{ Form::select('lab_section', array(null => '')+ $sections, $issue->topupRequest->test_category_id,
                    array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('issued_to', trans('messages.receivers-name')) }}
                {{ Form::select('issued_to', array(null => '')+ $users, $issue->receiver->id,
                    array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group">
                {{ Form::label('remarks ', trans('messages.remarks')) }}
                {{ Form::textarea('remarks', $issue->remarks ,array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            {{ Form::hidden('topup_request_id', $issue->topup_request_id) }}
            <div class="form-group actions-row">
                    {{ Form::button('<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'),
                         array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
                </div>
            {{ Form::close() }}
        </div>
    </div>
@stop   