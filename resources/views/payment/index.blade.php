@extends("layout")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('messages.home') !!}</a></li>
            <li class="active"><i class="fa fa-database"></i> {!! trans('messages.test-catalog') !!}</li>
            <li><a href="{!! route('payment.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('messages.payment', 2) !!}</a></li>
            <li class="active">{!! trans('messages.view').' '.trans_choice('messages.payment', 1) !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="card">
		<div class="card-header">
		    <i class="fa fa-file-text"></i> <strong>{!! trans('messages.details-for').': '.$payment->id !!}</strong>
		    <span>
		    	<a class="btn btn-sm btn-belize-hole" href="{!! url("payment/create") !!}" >
					<i class="fa fa-plus-circle"></i>
					{!! trans('messages.new').' '.trans_choice('messages.payment', 1) !!}
				</a>
				<a class="btn btn-sm btn-info" href="{!! url("payment/" . $payment->id . "/edit") !!}" >
					<i class="fa fa-edit"></i>
					{!! trans('messages.edit') !!}
				</a>
				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
					<i class="fa fa-step-backward"></i>
					{!! trans('messages.back') !!}
				</a>				
			</span>
		</div>	  		
		<!-- if there are creation errors, they will show here -->
		@if($errors->all())
			<div class="alert alert-danger">
				{!! HTML::ul($errors->all()) !!}
			</div>
		@endif
		<ul class="list-group list-group-flush">
		    <li class="list-group-item"><h5>{!! trans('messages.patient_id').': ' !!}<small>{!! $payment->patient_id !!}</small></h5></li>
		    <li class="list-group-item"><h5>{!! trans('messages.charge_id').': ' !!}<small>{!! $payment->charge_id !!}</small></h5></li>
		    <li class="list-group-item"><h5>{!! trans('messages.full_amount').': ' !!}<small>{!! $payment->full_amount !!}</small></h5></li>
		    <li class="list-group-item"><h5>{!! trans('messages.amount_paid').': ' !!}<small>{!! $payment->amount_paid !!}</small></h5></li>
	  	</ul>
	</div>
</div>
@endsection
