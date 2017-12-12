@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
      <li><a href="{{{URL::route('item.index')}}}">{{ Lang::choice('messages.item', 2) }}</a></li>
	  <li class="active">{{ Lang::choice('messages.stock', 2) }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-shopping-cart"></span>
		{{$item->name}} {{ Lang::choice('messages.stock', 2) }}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::to('stock/'.$item->id.'/create') }}">
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{ trans('messages.add')}} {{ trans('messages.new')}} {{Lang::choice('messages.stock', 1) }}
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed search-table">
			<thead>
				<tr>
					<th>{{ trans('messages.lot-no') }}</th>
					<th>{{ trans('messages.batch-no') }}</th>
					<th>{{ trans('messages.manufacturer') }}</th>
					<th>{{ trans('messages.supplied') }}</th>
					<th>{{ trans('messages.quantity') }} {{ trans('messages.issued') }}</th>
					<th>{{ trans('messages.balance') }}</th>
					<th>{{ trans('messages.expiry') }}</th>
					<th>{{ trans('messages.actions') }}</th>
				</tr>
			</thead>
			<tbody>
			@foreach($item->stocks as $key => $value)
				<tr @if(Session::has('activestock'))
                            {{(Session::get('activestock') == $value->id)?"class='info'":""}}
                        @endif
                    >
                 	<td>{{ $value->lot }}</td>
                 	<td>{{ $value->batch_no }}</td>
					<td>{{ $value->manufacturer }}</td>
					<td style="text-align: center;">{{ $value->quantity_supplied }} {{ $item->unit }}</td>
					<td style="text-align: center;">
						<?php $quantity_used = 0; ?>
						@foreach ($value->usage as $usage)
							<?php $quantity_used += $usage->quantity_used; ?>
						@endforeach
						{{ $quantity_used }} {{ $item->unit }}</td>
					<td style="text-align: center;">{{ $value->quantity() }} {{ $item->unit }}</td>
					<td>{{ $value->expiry_date }}</td>
                 	
					<td>
					<!-- show the stock (uses the show method found at GET /stock/{id} -->
						<a class="btn btn-sm btn-success" href="{{ URL::to("stock/" . $value->id) }}" >
							<span class="glyphicon glyphicon-eye-open"></span>
							{{ trans('messages.view') }}
						</a> 
						<!-- edit this commodity (uses the edit method found at GET /inventory/{id}/edit -->
						<a class="btn btn-sm btn-info hide" href="{{ URL::route('stock.edit', array($value->id)) }}" >
								<span class="glyphicon glyphicon-edit"></span>
								{{ trans('messages.edit') }}
						</a>
						@if($item->quantity()>0 && count($item->requests)>0)
						<!-- Update dtock button -->
					    <a class="btn btn-sm btn-sun-flower" href="{{ URL::to("stock/" . $value->id."/usage") }}" >
							<span class="glyphicon glyphicon-info-sign"></span>
							{{ trans('messages.update-stock') }}
						</a>
						@endif
						<!-- Usage for this lot -->
						<a class="btn btn-sm btn-wisteria hide" href="{{ URL::to("stock/" . $value->id . "/show") }}">
							<span class="glyphicon glyphicon-bookmark"></span>
							{{ trans('messages.usage') }}
						</a>

						<!-- show barcode generation button -->
						{{--*/ $barcode_separator = '$' /*--}}
						<a class="btn btn-sm btn-midnight-blue" href="#" onclick="print_barcode({{ "'".$value->id.$barcode_separator.$item->id."'".', '."'".$barcode->encoding_format."'".', '."'".$barcode->barcode_width."'".', '."'".$barcode->barcode_height."'".', '."'".$barcode->text_size."'" }})">
							<span class="glyphicon glyphicon-barcode"></span>
							{{ trans('messages.barcode') }}
						</a>
					</td>
				</tr>
				@endforeach
			</tbody>
			</table>
		{{ Session::put('SOURCE_URL', URL::full()) }}
	</div>
</div>
<!-- Barcode begins -->
    
<div id="count" style='display:none;'>0</div>
<div id ="barcodeList" style="display:none;"></div>
<!-- jQuery barcode script -->
<script type="text/javascript" src="{{ asset('js/barcode.js') }} "></script>
@stop