@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li class="active"><i class="fa fa-cubes"></i> {!! trans('menu.inventory') !!}</li>
            <li class="active"><i class="fa fa-cube"></i> {!! trans('specific-terms.stock-usage') !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
				    <i class="fa fa-book"></i> <strong>{!! trans('specific-terms.stock-usage').':'.$item->name !!}</strong>
				    <span>
						<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
							<i class="fa fa-step-backward"></i>
							{!! trans('action.back') !!}
						</a>				
					</span>
				</div>
			  	<div class="card-block">	  		
					@if (Session::has('message'))
						<div class="alert alert-info">{!! Session::get('message') !!}</div>
					@endif
					@if($errors->all())
		            <div class="alert alert-danger alert-dismissible" role="alert">
		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
		            </div>
		            @endif
				 	<table class="table table-bordered table-sm search-table">
						<thead>
							<tr>
								<th>{!! trans('specific-terms.lot-no') !!}</th>
								<th>{!! trans('specific-terms.quantity') !!}</th>
								<th>{!! trans('specific-terms.unit') !!}</th>
								<th>{!! trans('specific-terms.expiry') !!}</th>
								<th>{!! trans('specific-terms.manufacturer') !!}</th>
								<th>{!! trans_choice('menu.supplier', 1) !!}</th>
								<th>{!! trans('specific-terms.date-received') !!}</th>
								<th>{!! trans('general-terms.remarks') !!}</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						@foreach($item->stocks as $key => $value)
							<tr @if(session()->has('active_stock'))
				                    {!! (session('active_stock') == $value->id)?"class='warning'":"" !!}
				                @endif
				                >
								<td>{!! $value->lot !!}</td>
								<td>{!! $value->quantity() !!}</td>
								<td>{!! $item->unit !!}</td>
								<td>{!! Carbon::parse($value->expiry_date)->toDateString() !!}</td>
								<td>{!! $value->manufacturer !!}</td>
								<td>{!! $value->supplier->name !!}</td>
								<td>{!! $value->date_of_reception !!}</td>
								<td>{!! $value->remarks !!}</td>
								
								<td>

								<!-- show the test category (uses the show method found at GET /stock/{id} -->
									<a class="btn btn-sm btn-success" href="{!! url("stock/" . $value->id) !!}" style="display:none;">
										<i class="fa fa-folder-open-o"></i>
										{!! trans('action.view') !!}
									</a>
								<!-- Update dtock button -->
							    <a class="btn btn-sm btn-belize-hole" href="{!! url("stock/" . $value->id."/usage") !!}" >
									<i class="fa fa-lemon-o"></i>
									{!! trans('action.update-stock') !!}
								</a>

								<!-- edit this test category (uses edit method found at GET /stock/{id}/edit -->
									<a class="btn btn-sm btn-info" href="{!! url("stock/" . $value->id . "/edit") !!}">
										<i class="fa fa-edit"></i>
										{!! trans('action.edit') !!}
									</a>

								<!-- Usage for this lot -->
									<a class="btn btn-sm btn-midnight-blue" href="{!! url("stock/" . $value->id . "/show") !!}">
										<i class="fa fa-history"></i>
										{!! trans('action.usage') !!}
									</a>

								<!-- show barcode generation button -->
									<a class="btn btn-sm btn-asbestos" href="{!! url("stock/" . $value->id . "/edit") !!}" >
										<i class="fa fa-barcode"></i>
										{!! trans('action.barcode') !!}
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