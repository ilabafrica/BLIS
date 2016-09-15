@extends("layout")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('messages.home') !!}</a></li>
            <li class="active"><i class="fa fa-database"></i> {!! trans('messages.test-catalog') !!}</li>
            <li><a href="{!! route('payment.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('messages.payment', 2) !!}</a></li>
            <li class="active">{!! trans('messages.edit').' '.trans_choice('messages.payment', 1) !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i> {!! trans('messages.edit').' '.trans_choice('messages.payment', 1) !!} 
            <span>
                <a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
                    <i class="fa fa-step-backward"></i>
                    {!! trans('messages.back') !!}
                </a>                
            </span>
        </div>
        <div class="card-block">
            <!-- if there are creation errors, they will show here -->
            @if($errors->all())
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('messages.close') !!}</span></button>
                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
            </div>
            @endif

            {!! Form::model($payment, array('route' => array('payment.update', $payment->id), 
                'method' => 'PUT', 'id' => 'form-edit-payment')) !!}
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
                <!-- ./ csrf token -->
                <div class="form-group row">
                    {!! Form::label('patient_id', trans_choice('messages.patient_id',1), array('class' => 'col-sm-2 form-control-label')) !!}
                    <div class="col-sm-6">
                        {!! Form::text('patient_id', old('patient_id'), array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('charge_id', trans_choice('messages.charge_id',1), array('class' => 'col-sm-2 form-control-label')) !!}
                    <div class="col-sm-6">
                        {!! Form::text('charge_id', old('charge_id'), array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('full_amount', trans_choice('messages.full_amount',1), array('class' => 'col-sm-2 form-control-label')) !!}
                    <div class="col-sm-6">
                        {!! Form::text('full_amount', old('full_amount'), array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('amount_paid', trans_choice('messages.amount_paid',1), array('class' => 'col-sm-2 form-control-label')) !!}
                    <div class="col-sm-6">
                        {!! Form::text('amount_paid', old('amount_paid'), array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="form-group row col-sm-offset-2">
                    {!! Form::button("<i class='fa fa-check-circle'></i> ".trans('messages.update'), 
                        array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
                    <a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('messages.cancel') !!}</a>
                </div>

            {!! Form::close() !!}
        </div>
	</div>
</div>
@endsection

