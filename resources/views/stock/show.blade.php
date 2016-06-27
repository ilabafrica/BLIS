@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li class="active"><i class="fa fa-cubes"></i> {!! trans('menu.inventory') !!}</li>
            <li><a href="{!! url('stock/'.$stock->item->id.'/log') !!}"><i class="fa fa-cube"></i> {!! trans('specific-terms.stock-usage') !!}</a></li>
            <li class="active">{!! trans('action.view').' '.trans('specific-terms.lot') !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="card">
		<div class="card-header">
		    <i class="fa fa-file-text"></i> <strong>{!! trans('general-terms.details-for').': '.$stock->item->name.' '.trans('specific-terms.lot').' '.$stock->lot !!}</strong>
		    <span>
			    <a class="btn btn-sm btn-belize-hole" href="{!! url("stock/" . $stock->id."/usage") !!}" >
					<i class="fa fa-lemon-o"></i>
					{!! trans('action.update-stock') !!}
				</a>
				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
					<i class="fa fa-step-backward"></i>
					{!! trans('action.back') !!}
				</a>				
			</span>
		</div>	  		
		<!-- if there are creation errors, they will show here -->
		@if($errors->all())
			<div class="alert alert-danger">
				{!! HTML::ul($errors->all()) !!}
			</div>
		@endif
		<div class="card-block">
			<div class="row">
				<div class="col-md-12">
					<ul class="list-group" style="padding-bottom:5px;">
					  	<li class="list-group-item"><strong>{!! trans('general-terms.details-for').': '.$stock->item->name !!}</strong></li>
					  	<li class="list-group-item">
					  		<h6>
					  			<span>{!! trans("specific-terms.lot-no") !!}<small> {!! $stock->lot !!}</small></span>
					  			<span>{!! trans("specific-terms.available-qty") !!}<small> {!! $stock->quantity() !!}</small></span>
					  			<span>{!! trans("specific-terms.min-level") !!}<small> {!! $stock->item->min_level !!}</small></span>
					  		</h6>
					  	</li>
					</ul>
				</div>
				<div class="col-md-12">
					<table class="table table-bordered table-sm search-table">
						<thead>
							<tr>
								<th>{!! trans('general-terms.id') !!}</th>
								<th>{!! trans('specific-terms.signed-out') !!}</th>
								<th>{!! trans('specific-terms.date-of-usage') !!}</th>
								<th>{!! trans('general-terms.remarks') !!}</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						@foreach($stock->usage as $key => $value)
							<tr @if(session()->has('active_usage'))
				                    {!! (session('active_usage') == $value->id)?"class='warning'":"" !!}
				                @endif
				                >
								<td>{!! $value->id !!}</td>
								<td>{!! $value->quantity_used !!}</td>
								<td>{!! Carbon::parse($value->date_of_usage)->toDateString() !!}</td>
								<td>{!! $value->remarks !!}</td>
								
								<td>

								<!-- edit this test category (uses edit method found at GET /stock/{id}/edit -->
									<a class="btn btn-sm btn-info" href="{!! url("stock/" . $value->id . "/lot") !!}">
										<i class="fa fa-edit"></i>
										{!! trans('action.edit') !!}
									</a>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	{!! session(['SOURCE_URL' => URL::full()]) !!}
</div>
@endsection	