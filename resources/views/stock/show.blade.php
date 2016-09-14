@extends("layout")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('messages.home') !!}</a></li>
            <li class="active"><i class="fa fa-cubes"></i> {!! trans('messages.inventory') !!}</li>
            <li><a href="{!! url('stock/'.$stock->item->id.'/log') !!}"><i class="fa fa-cube"></i> {!! trans('messages.stock-usage') !!}</a></li>
            <li class="active">{!! trans('messages.view').' '.trans('messages.lot') !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="card">
		<div class="card-header">
		    <i class="fa fa-file-text"></i> <strong>{!! trans('messages.details-for').': '.$stock->item->name.' '.trans('messages.lot').' '.$stock->lot !!}</strong>
		    <span>
			    <a class="btn btn-sm btn-belize-hole" href="{!! url("stock/" . $stock->id."/usage") !!}" >
					<i class="fa fa-lemon-o"></i>
					{!! trans('messages.update-stock') !!}
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
		<div class="card-block">
			<div class="row">
				<div class="col-md-12">
					<ul class="list-group" style="padding-bottom:5px;">
					  	<li class="list-group-item"><strong>{!! trans('messages.details-for').': '.$stock->item->name !!}</strong></li>
					  	<li class="list-group-item">
					  		<h6>
					  			<span>{!! trans("terms.lot-no") !!}<small> {!! $stock->lot !!}</small></span>
					  			<span>{!! trans("terms.available-qty") !!}<small> {!! $stock->quantity() !!}</small></span>
					  			<span>{!! trans("terms.min-level") !!}<small> {!! $stock->item->min_level !!}</small></span>
					  		</h6>
					  	</li>
					</ul>
				</div>
				<div class="col-md-12">
					<table class="table table-bordered table-sm search-table">
						<thead>
							<tr>
								<th>{!! trans('messages.id') !!}</th>
								<th>{!! trans('messages.signed-out') !!}</th>
								<th>{!! trans('messages.date-of-usage') !!}</th>
								<th>{!! trans('messages.remarks') !!}</th>
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
										{!! trans('messages.edit') !!}
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