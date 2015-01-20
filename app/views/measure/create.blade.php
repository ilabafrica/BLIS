@section("edit")
	{{ Form::open(array('url' => 'measure', 'id' => 'form-create-measure')) }}
		<div class="form-group">
			{{ Form::label('name', Lang::choice('messages.name',1)) }}
			{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
		</div>
		<div class="form-group">
			{{ Form::label('measure_type_id', Lang::choice('messages.measure-type',1)) }}
			{{ Form::select('measure_type_id', array(0 => '')+$measuretype->lists('name', 'id'), 
				Input::old('measure_type_id'), array('class' => 'form-control measuretype-input-trigger',
				'id' => 'measuretype')) 
			}}
		</div>
		<div class="form-group">
			{{ Form::label('unit', trans('messages.unit')) }}
			{{ Form::text('unit', Input::old('unit'), array('class' => 'form-control')) }}
		</div>
		<div class="form-group">
			{{ Form::label('description', trans('messages.description')) }}
			{{ Form::textarea('description', Input::old('description'), array('class' => 'form-control', 'rows'=>'2')) }}
		</div>
		<div class="form-group">
			<label for="measurerange">{{trans('messages.measure-range-values')}}</label>				
			<div class="form-pane panel panel-default">
				<div class="panel-body">
					<div class="measurevalue"></div>
				</div>
			</div>
		</div>
		<div class="form-group actions-row">
			<a class="btn btn-default add-another-range" href="javascript:void(0);">
					<span class="glyphicon glyphicon-plus-sign"></span>{{trans('messages.add-new-measure-range')}}</a>
			{{ Form::button('<span class="glyphicon glyphicon-save"></span>'.trans('messages.save-measure'), 
				array('class' => 'btn btn-default', 'onclick' => 'submit()')) }}
		</div>
	{{ Form::close() }}
@show