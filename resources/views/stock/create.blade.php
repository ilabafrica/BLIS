@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li class="active"><i class="fa fa-cubes"></i> {!! trans('menu.inventory') !!}</li>
            <li><a href="{!! route('stock.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.stock', 2) !!}</a></li>
            <li class="active">{!! trans('action.new').' '.trans_choice('menu.stock', 1) !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="card">
		<div class="card-header">
		    <i class="fa fa-pencil"></i> {!! trans('action.new').' '.trans_choice('menu.stock', 1) !!} 
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
				{!! Form::open(array('route' => 'stock.store', 'id' => 'form-create-stock')) !!}
					<!-- CSRF Token -->
	                <input type="hidden" name="_token" value="{!! csrf_token() !!}}" />
	                <!-- ./ csrf token -->
	                {!! Form::hidden('item_id', $item->id) !!}
					<div class="form-group row">
						{!! Form::label('lot-no', trans('terms.lot-no'), array('class' => 'col-sm-3 form-control-label')) !!}
						<div class="col-sm-8">
							{!! Form::text('lot', old('lot'), array('class' => 'form-control')) !!}
						</div>
					</div>
	                <div class="form-group row">
	                    {!! Form::label('expiry', trans('terms.expiry'), array('class' => 'col-sm-3 form-control-label')) !!}
	                    <div class="col-sm-8 input-group date datepicker"  style="padding-left:15px;">
	                        {!! Form::text('expiry_date', old('expiry_date'), array('class' => 'form-control')) !!}
	                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
	                    </div>
	                </div>
	                <div class="form-group row">
						{!! Form::label('manufacturer', trans('terms.manufacturer'), array('class' => 'col-sm-3 form-control-label')) !!}
						<div class="col-sm-8">
							{!! Form::text('manufacturer', old('manufacturer'), array('class' => 'form-control')) !!}
						</div>
					</div>
					<div class="form-group row">
						{!! Form::label('supplier', trans_choice('menu.supplier', 1), array('class' => 'col-sm-3 form-control-label')) !!}
						<div class="col-sm-8">
							{!! Form::select('supplier_id', $suppliers, '', array('class' => 'form-control c-select')) !!}
						</div>
					</div>
	                <div class="form-group row">
						{!! Form::label('quantity-supplied', trans('terms.supplied'), array('class' => 'col-sm-3 form-control-label')) !!}
						<div class="col-sm-8">
							{!! Form::text('quantity_supplied', old('quantity_supplied'), array('class' => 'form-control')) !!}
						</div>
					</div>
	                <div class="form-group row">
						{!! Form::label('cost-per-unit', trans('terms.cost-per-unit'), array('class' => 'col-sm-3 form-control-label')) !!}
						<div class="col-sm-8">
							{!! Form::text('cost_per_unit', old('cost_per_unit'), array('class' => 'form-control')) !!}
						</div>
					</div>
	                <div class="form-group row">
	                    {!! Form::label('date-received', trans('terms.date-received'), array('class' => 'col-sm-3 form-control-label')) !!}
	                    <div class="col-sm-8 input-group date datepicker"  style="padding-left:15px;">
	                        {!! Form::text('date_of_reception', old('date_of_reception'), array('class' => 'form-control')) !!}
	                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
	                    </div>
	                </div>
					<div class="form-group row">
						{!! Form::label('remarks', trans("terms.remarks"), array('class' => 'col-sm-3 form-control-label')) !!}</label>
						<div class="col-sm-8">
							{!! Form::textarea('remarks', old('remarks'), array('class' => 'form-control', 'rows' => '2')) !!}
						</div>
					</div>
					<div class="form-group row col-sm-offset-3">
						{!! Form::button("<i class='fa fa-plus-circle'></i> ".trans('action.save'), 
							array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
						<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
					</div>

				{!! Form::close() !!}
				</div>
				<div class="col-md-4">
					<ul class="list-group">
						<li class="list-group-item"><strong>{!! trans_choice('menu.item', 1).': '.$item->name !!}</strong></li>
						<li class="list-group-item"><h6>{!! trans("terms.unit") !!}<small> {!! $item->unit !!}</small></h6></li>
						<li class="list-group-item"><h6>{!! trans('terms.min-level') !!}<small> {!! $item->min_level !!}</small></h6></li>
						<li class="list-group-item"><h6>{!! trans('terms.max-level') !!}<small> {!! $item->max_level !!}</small></h6></li>						
					</ul>
				</div>
			</div>
	  	</div>
	</div>
</div>
@endsection	