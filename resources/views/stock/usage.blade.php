@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li class="active"><i class="fa fa-cubes"></i> {!! trans('menu.inventory') !!}</li>
            <li><a href="{!! route('stock.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.stock', 2) !!}</a></li>
            <li class="active">{!! trans('specific-terms.stock-usage') !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="card">
		<div class="card-header">
		    <i class="fa fa-edit"></i> {!! trans('specific-terms.stock-usage') !!} 
		    <span>
				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
					<i class="fa fa-step-backward"></i>
					{!! trans('action.back') !!}
				</a>				
			</span>
		</div>
	  	<div class="card-block">	  		
			<!-- if there are creation errors, they will show here -->
			@if($errors->all())
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
            </div>
            @endif
            <div class="row">
	            <div class="col-md-8">
				{!! Form::open(array('route' => array('stock.saveUsage', $stock->id), 'method' => 'POST')) !!}
					<!-- CSRF Token -->
	                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	                <!-- ./ csrf token -->
	                {!! Form::hidden('stock_id', $stock->id) !!}
					<div class="form-group row">
						{!! Form::label('signed-out', trans('specific-terms.signed-out'), array('class' => 'col-sm-4 form-control-label')) !!}
						<div class="col-sm-8">
							{!! Form::text('quantity_used', old('quantity_used'), array('class' => 'form-control')) !!}
						</div>
					</div>
	                <div class="form-group row">
	                    {!! Form::label('date-of-usage', trans('specific-terms.date-of-usage'), array('class' => 'col-sm-4 form-control-label')) !!}
	                    <div class="col-sm-8 input-group date datepicker"  style="padding-left:15px;">
	                        {!! Form::text('date_of_usage', old('date_of_usage'), array('class' => 'form-control')) !!}
	                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
	                    </div>
	                </div>
					<div class="form-group row">
						{!! Form::label('remarks', trans("general-terms.remarks"), array('class' => 'col-sm-4 form-control-label')) !!}</label>
						<div class="col-sm-8">
							{!! Form::textarea('remarks', old('remarks'), array('class' => 'form-control', 'rows' => '2')) !!}
						</div>
					</div>
					<div class="form-group row col-sm-offset-4">
						{!! Form::button("<i class='fa fa-plus-circle'></i> ".trans('action.save'), 
							array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
						<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
					</div>

				{!! Form::close() !!}
				</div>
				<div class="col-md-4">
					<ul class="list-group">
						<li class="list-group-item"><strong>{!! trans_choice('menu.item', 1).': '.$stock->item->name !!}</strong></li>
						<li class="list-group-item"><h6>{!! trans("specific-terms.unit") !!}<small> {!! $stock->item->unit !!}</small></h6></li>
						<li class="list-group-item"><h6>{!! trans('specific-terms.lot-no') !!}<small> {!! $stock->lot !!}</small></h6></li>
						<li class="list-group-item"><h6>{!! trans('specific-terms.available-qty') !!}<small> {!! $stock->quantity() !!}</small></h6></li>						
					</ul>
				</div>
			</div>
	  	</div>
	</div>
</div>
@endsection	