@extends("app")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{!! URL::route('user.home')!!}}">{!!trans('messages.home')!!}</a></li>
	  <li class="active">{!!Lang::choice('messages.instrument',2)!!}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{!! trans(Session::get('message')) !!}</div>
@endif
@if($errors->all())
	<div class="alert alert-danger">
		{!! HTML::ul($errors->all()) !!}
	</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-cog"></span>
		{!!trans('messages.list-instruments')!!}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{!! URL::route('instrument.create') !!}" >
				<span class="glyphicon glyphicon-plus-sign"></span>
				{!!trans('messages.new-instrument')!!}
			</a>
			<a class="btn btn-sm btn-info" href="#import-driver-modal" data-toggle="modal">
				<span class="glyphicon glyphicon-cog"></span>
				{!!trans('messages.new-instrument-driver')!!}
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed search-table">
			<thead>
				<tr>
					<th>{!!Lang::choice('messages.name',1)!!}</th>
					<th>{!!trans('messages.ip')!!}</th>
					<th>{!!trans('messages.host-name')!!}</th>
					<th>{!!trans('messages.actions')!!}</th>
				</tr>
			</thead>
			<tbody>
			@foreach($instruments as $key => $value)
				<tr>
					<td>{!! $value->name !!}</td>
					<td>{!! $value->ip !!}</td>
					<td>{!! $value->hostname !!}</td>

					<td>

						<!-- show the instrument details -->
						<a class="btn btn-sm btn-success" href="{!! URL::route('instrument.show', array($value->id)) !!}">
							<span class="glyphicon glyphicon-eye-open"></span>
							{!!trans('messages.view')!!}
						</a>

						<!-- edit this instrument  -->
						<a class="btn btn-sm btn-info" href="{!! URL::route('instrument.edit', array($value->id)) !!}" >
							<span class="glyphicon glyphicon-edit"></span>
							{!!trans('messages.edit')!!}
						</a>
						<!-- delete this instrument -->
						<button class="btn btn-sm btn-danger delete-item-link"
							data-toggle="modal" data-target=".confirm-delete-modal"	
							data-id="{!! URL::route('instrument.delete', array($value->id)) !!}">
							<span class="glyphicon glyphicon-trash"></span>
							{!!trans('messages.delete')!!}
						</button>

					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		{!!$instruments->links()!!}
	</div>
</div>

<!-- MODALS -->
    <div class="modal fade" id="import-driver-modal">
      <div class="modal-dialog">
        <div class="modal-content">
        {!! Form::open(array('route' => 'instrument.importDriver', 'files' => true)) !!}
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">{!!trans('messages.close')!!}</span>
            </button>
            <h4 class="modal-title">
                <span class="glyphicon glyphicon-transfer"></span>
                {!!trans('messages.import-instrument-driver-title')!!}</h4>
          </div>
          <div class="modal-body">
				<div class="alert alert-danger" role="alert">
				  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				  <span class="sr-only">{!!trans('messages.error')!!}:</span>
				  {!!trans('messages.import-trusted-sources-only')!!}
				</div>
                <div class="form-group">
                	{!! Form::label('import_file', trans('messages.driver-file')) !!}
                    {!! Form::file("import_file") !!}
                </div>
          </div>
          <div class="modal-footer">
            {!! Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'),
                array('class' => 'btn btn-primary', 'data-dismiss' => 'modal', 'onclick' => 'submit()')) !!}
            <button type="button" class="btn btn-default" data-dismiss="modal">
                {!!trans('messages.close')!!}</button>
          </div>
        {!! Form::close() !!}
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal /#import-driver-modal-->
@stop