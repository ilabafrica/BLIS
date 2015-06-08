@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="active">{{ Lang::choice('messages.test-type',1) }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif	
{{ Form::open(array('route' => 'testType.saveChoosenTestType', 'id' => 'form-new-testType')) }}					
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-cog"></span>
		{{trans('messages.list-test-types')}}
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::to("testtype/create") }}" >
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{trans('messages.new-test-type')}}
			</a>
		</div>
	</div>
	<div class="form-group">
			{{ Form::label('tests', trans("messages.select-tests")) }}
			<div class="form-pane">

					<table class="table table-striped table-hover table-condensed search-table">
					<thead>
						<tr>
							<th>{{ Lang::choice('Testtype',2) }}</th>
							<th>{{ Lang::choice('Active',2) }}</th>
										
						</tr>
					</thead>
					<tbody>
					@foreach($testtypes as $key => $value)
						<tr>
							<td>{{ $value->name }}</td>
							<td><label  class="editor-active">
								<input type="checkbox" name="testtypes[]" value="{{ $value->id}}" />
								</label>
							</td>
															
						</tr>
					@endforeach
					</tbody>
		            </table>

				<div class="form-group actions-row">
				{{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save-test'), 
					array('class' => 'btn btn-primary', 'onclick' => 'submit()', 'alt' => 'save_new_test')) }}
				</div>
		</div>
	</div>
</div>

{{ Form::close() }}
@stop