@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.item', 2) }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ Lang::choice('messages.item', 2) }}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::route('item.create') }}">
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{ trans('messages.add')}} {{ trans('messages.new')}} {{Lang::choice('messages.item', 1) }}
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed search-table">
			<thead>
				<tr>
					<th>{{ Lang::choice('messages.name', 1) }}</th>
					<th style="text-align: right;">{{ trans('messages.quantity') }}</th>
					<th style="text-align: center;">{{ trans('messages.actions') }}</th>
				</tr>
			</thead>
			<tbody>
			@foreach($items as $key => $value)
				<tr @if(Session::has('activeitem'))
                            {{(Session::get('activeitem') == $value->id)?"class='info'":""}}
                        @endif
                    >
                 	<td>{{ $value->name }}</td>
                 	<td style="text-align: right;">{{ $value->quantity() }} {{ $value->unit }}</td>
                 	
					<td style="text-align: right;">
					<!-- show the item (uses the show method found at GET /item/{id} -->
						<a class="btn btn-sm btn-success" href="{{ URL::to("item/" . $value->id) }}" >
							<span class="glyphicon glyphicon-eye-open"></span>
							{{ trans('messages.view') }}
						</a> 
						<!-- edit this commodity (uses the edit method found at GET /inventory/{id}/edit -->
						<a class="btn btn-sm btn-info" href="{{ URL::route('item.edit', array($value->id)) }}" >
								<span class="glyphicon glyphicon-edit"></span>
								{{ trans('messages.edit') }}
						</a>
	                    <!-- show button for logging stock usage -->
						<a class="btn btn-sm btn-wisteria" href="{{ URL::to("stock/" . $value->id)."/log" }}" >
							<span class="glyphicon glyphicon-bookmark"></span>
							{{ trans('messages.log-usage') }}
						</a>
						<!-- show button for adding stock -->
						<a class="btn btn-sm btn-sun-flower" href="{{ URL::to("stock/" . $value->id)."/create" }}" >
							<span class="glyphicon glyphicon-shopping-cart"></span>
							{{ trans('messages.receive') }} {{ Lang::choice('messages.stock',1) }}
						</a>
						<!-- Barcode -->
						<a class="btn btn-sm btn-midnight-blue barcode-button" onclick="print_barcode({{ "'".$value->id."'".', '."'".$barcode->encoding_format."'".', '."'".$barcode->barcode_width."'".', '."'".$barcode->barcode_height."'".', '."'".$barcode->text_size."'" }})" title="{{trans('messages.barcode')}}">
	                        <span class="glyphicon glyphicon-barcode"></span>
	                        {{ trans('messages.barcode') }}
	                    </a>
							<!-- delete this commodity (uses the delete method found at GET /inventory/{id}/delete -->
						<button class="btn btn-sm btn-danger delete-item-link" 
								data-toggle="modal" data-target=".confirm-delete-modal"	
								data-id="{{ URL::route('item.delete', array($value->id)) }}">
								<span class="glyphicon glyphicon-trash"></span>
								{{ trans('messages.delete') }}
						</button>
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