@extends("layout")
@section("content")

@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif

	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		  <li><a href="{{{URL::route('item.index')}}}">{{ Lang::choice('messages.item', 2) }}</a></li>
		  <li class="active">{{ Lang::choice('messages.item', 1).' '.trans('messages.details') }}</li>
		</ol>
	</div>
	<div class="panel panel-primary ">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-adjust"></span>
			{{ Lang::choice('messages.item', 1).' '.trans('messages.details') }}
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::route('item.edit', array($item->id)) }}">
					<span class="glyphicon glyphicon-edit"></span>
					{{ trans('messages.edit') }}
				</a>
				<!-- Barcode -->
				<a class="btn btn-sm btn-info" onclick="print_barcode({{ "'".$item->id."'".', '."'".$barcode->encoding_format."'".', '."'".$barcode->barcode_width."'".', '."'".$barcode->barcode_height."'".', '."'".$barcode->text_size."'" }})" title="{{trans('messages.barcode')}}">
                    <span class="glyphicon glyphicon-barcode"></span>
                    {{trans('messages.barcode')}}
                </a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3 class="view"><strong>{{ Lang::choice('messages.name', 1) }}:</strong>{{ $item->name }} </h3>
				<p class="view-striped"><strong>{{ trans('messages.unit') }}:</strong>
					{{ $item->unit }}</p>
				<p class="view-striped"><strong>{{ trans('messages.quantity') }}:</strong>
					{{ $item->quantity() }}</p>
				<p class="view-striped"><strong>{{ trans('messages.min-level') }}:</strong>
					{{ $item->min_level }}</p>
					<p class="view-striped"><strong>{{ trans('messages.max-level') }}:</strong>
					{{ $item->max_level }}</p>
					<p class="view-striped"><strong>{{ trans('messages.remarks') }}:</strong>
					{{ $item->remarks }}</p>
					<p class="view-striped"><strong>{{ trans('messages.storage') }}:</strong>
					{{ $item->storage_req }}</p>
				
			</div>

		</div>
	</div>
@stop