@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{ URL::route('testtype.index') }}">{{ Lang::choice('messages.test-type',1) }}</a></li>
	  <li class="active">{{trans('messages.create-test-type')}}</li>
	</ol>
</div>
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-cog"></span>
		{{trans('messages.create-test-type')}}
	</div>
	{{ Form::open(array('route' => array('testtype.index'), 'id' => 'form-create-testtype')) }}
	<div class="panel-body">
	<!-- if there are creation errors, they will show here -->
		
		@if($errors->all())
			<div class="alert alert-danger">
				{{ HTML::ul($errors->all()) }}
			</div>
		@endif

			<div class="form-group">
				{{ Form::label('name', Lang::choice('messages.name',1)) }}
				{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('description', trans('messages.description')) }}
				{{ Form::textarea('description', Input::old('description'), 
					array('class' => 'form-control', 'rows' => '2')) }}
			</div>
			<div class="form-group">
				{{ Form::label('test_category_id', Lang::choice('messages.test-category',1)) }}
				{{ Form::select('test_category_id', array(0 => '')+$testcategory->lists('name', 'id'),
					Input::old('test_category_id'),	array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('specimen_types', trans('messages.select-specimen-types')) }}
				<div class="form-pane panel panel-default">
					<div class="container-fluid">
						<?php 
							$cnt = 0;
							$zebra = "";
						?>
						@foreach($specimentypes as $key=>$value)
							{{ ($cnt%4==0)?"<div class='row $zebra'>":"" }}
							<?php
								$cnt++;
								$zebra = (((int)$cnt/4)%2==1?"row-striped":"");
							?>
							<div class="col-md-3">
								<label  class="checkbox">
									<input type="checkbox" name="specimentypes[]" value="{{ $value->id}}" />{{$value->name}}
								</label>
							</div>
							{{ ($cnt%4==0)?"</div>":"" }}
						@endforeach
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('measures', Lang::choice('messages.measure',2)) }}
				<div class="form-pane panel panel-default">
					<div class="container-fluid measure-container">
					</div>
		        	<a class="btn btn-default add-another-measure" href="javascript:void(0);" data-new-measure="1">
		         		<span class="glyphicon glyphicon-plus-sign"></span>{{trans('messages.add-new-measure')}}</a>
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('targetTAT', trans('messages.target-turnaround-time')) }}
				{{ Form::text('targetTAT', Input::old('targetTAT'), array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('prevalence_threshold', trans('messages.prevalence-threshold')) }}
				{{ Form::text('prevalence_threshold', Input::old('prevalence_threshold'), 
					array('class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('culture-worksheet', trans('messages.show-culture-worksheet')) }}
				{{ Form::checkbox(trans('messages.show-culture-worksheet'), "1", '', array('onclick'=>'toggle(".organismsClass", this)')) }}
			</div>
			<div class="form-group organismsClass" style="display:none;">
				{{ Form::label('organisms', trans('messages.select-organisms')) }}
				<div class="form-pane panel panel-default">
					<div class="container-fluid">
						<?php 
							$counter = 0;
							$alternator = "";
						?>
						@foreach($organisms as $key=>$value)
							{{ ($counter%4==0)?"<div class='row $alternator'>":"" }}
							<?php
								$counter++;
								$alternator = (((int)$counter/4)%2==1?"row-striped":"");
							?>
							<div class="col-md-3">
								<label  class="checkbox">
									<input type="checkbox" name="organisms[]" value="{{ $value->id}}" />
										{{$value->name }}
								</label>
							</div>
							{{ ($counter%4==0)?"</div>":"" }}
						@endforeach
						</div>
					</div>
				</div>
			</div>
		<div class="form-group">
			{{ Form::label('orderable_test', trans('messages.orderable-test')) }}
			{{ Form::checkbox('orderable_test', 1, Input::old('orderable_test')) }}
		</div>
		</div>

		<div class="panel-footer">
			<div class="form-group actions-row">
				{{ Form::button(
					'<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'),
					['class' => 'btn btn-primary', 'onclick' => 'submit()']
				) }}
				{{ Form::button(trans('messages.cancel'), 
					['class' => 'btn btn-default', 'onclick' => 'javascript:history.go(-1)']
				) }}
			</div>
		</div>
	{{ Form::close() }}
</div>
@include("measure.measureinput")
@stop