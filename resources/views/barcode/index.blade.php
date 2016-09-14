@extends("layout")
@section("content")

	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{ URL::route('user.home')}}}">{{trans('messages.home') }}</a></li>
		  <li><a href="{{ URL::route('barcode.index') }}">{{trans('messages.barcode-settings') }}</a></li>
		</ol>
	</div>	
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-edit"></span>
			{{ trans('messages.configure-barcode-settings') }}
		</div>
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
			@if (Session::has('message'))
				<div class="alert alert-info">{{ Session::get('message') }}</div>
			@endif
			<div class="row">
				<div class="col-md-7"> 
				{{ Form::model($barcode, array('route' => array('barcode.update', $barcode->id), 
					'method' => 'PUT', 'id' => 'form-edit-barcode')) }}
					<div class="form-group">
						{{ Form::label('encoding_format', trans('messages.encoding-format')) }}
						{{ Form::select('encoding_format', $encoding_format,
							Input::old('encoding_format'), array('class' => 'form-control')) }}
					</div>
					<div class="form-group">
						{{ Form::label('barcode_width', trans('messages.barcode-width')) }}
						{{ Form::select('barcode_width', $barcode_width,
							Input::old('barcode_width'), array('class' => 'form-control')) }}
					</div>
					<div class="form-group">
						{{ Form::label('barcode_height', trans('messages.barcode-height')) }}
						{{ Form::select('barcode_height', $barcode_height,
							Input::old('barcode_height'), array('class' => 'form-control')) }}
					</div>
					<div class="form-group">
						{{ Form::label('text_size', trans('messages.text-size')) }}
						{{ Form::select('text_size', $text_size,
							Input::old('text_size'), array('class' => 'form-control')) }}
					</div>
					<div class="form-group actions-row">
						{{ Form::button('<span class="glyphicon glyphicon-save"></span> '. trans('messages.save'), 
							['class' => 'btn btn-primary', 'onclick' => 'submit()']) }}
					</div>

				{{ Form::close() }}
				</div>
				<div class="col-md-5">
					<ul class="list-group">
						<li class="list-group-item disabled"><strong>Page Help</strong></li>
						<li class="list-group-item">Configure your settings for barcode formats</li>
						<li class="list-group-item">Width and Height are the dimensions of the bars</li>
						<li class="list-group-item">Text size os the for the code printed underneath the barcodes</li>
					</ul>
				</div>
			</div>
		</div>
		{{ Session::put('SOURCE_URL', URL::full()) }}
	</div>
@stop	