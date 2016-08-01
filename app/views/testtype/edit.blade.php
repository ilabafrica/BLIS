@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{ URL::route('testtype.index') }}">{{ Lang::choice('messages.test-type',1) }}</a></li>
	  <li class="active">{{trans('messages.edit-test-type')}}</li>
	</ol>
</div>
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-edit"></span>
		{{trans('messages.edit-test-type')}}
	</div>
	{{ Form::model($testtype, array(
			'route' => array('testtype.update', $testtype->id), 'method' => 'PUT',
			'id' => 'form-edit-testtype'
		)) }}
		<div class="panel-body">
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
					array('class' => 'form-control', 'rows' => '2' )) }}
			</div>
			<div class="form-group">
				{{ Form::label('test_category_id', Lang::choice('messages.test-category',1)) }}
				{{ Form::select('test_category_id', array(0 => '')+$testcategory->lists('name', 'id'),
					Input::old('test_category_id'), array('class' => 'form-control')) }}
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
									<input type="checkbox" name="specimentypes[]" value="{{ $value->id}}" 
										{{ in_array($value->id, $testtype->specimenTypes->lists('id'))?"checked":"" }} />
										{{$value->name }}
								</label>
							</div>
							{{ ($cnt%4==0)?"</div>":"" }}
						@endforeach
						</div>
					</div>
				</div>
			</div>
			<ul class="nav nav-tabs" data-tabs="tabs">
				<li role="presentation" class="active"><a href="#measure"  data-toggle="tab">{{Lang::choice('messages.measure',2)}}</a></li>
				<li role="presentation"><a href="#reorder" data-toggle="tab">{{trans('messages.reorder')}}</a></li>
			</ul>
			
			<div id="my-tab-content" class="tab-content">
				<div class="tab-pane active" id="measure">
					<div class="form-group">
						<br/>
						<div class="form-pane panel panel-default">
							<div class="container-fluid measure-container">
								@include("measure.edit")
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
						<?php if(count($testtype->organisms)>0){$checked=true;} else{$checked=false;} ?>
						{{ Form::checkbox(trans('messages.show-culture-worksheet'), "1", $checked, array('onclick'=>'toggle(".organismsClass", this)')) }}
					</div>
					<div class="form-group organismsClass" <?php if($checked==true){ ?>style="dispaly:block;"<?php }else{ ?>style="display:none;"<?php } ?>>
						{{ Form::label('organisms', trans('messages.select-organisms')) }}
						<div class="form-pane panel panel-default">
							<div class="container-fluid">
								<?php 
									$counter = 0;
									$alternator = "";
								?>
								@foreach($organisms as $key=>$val)
									{{ ($counter%4==0)?"<div class='row $alternator'>":"" }}
									<?php
										$counter++;
										$alternator = (((int)$counter/4)%2==1?"row-striped":"");
									?>
									<div class="col-md-3">
										<label  class="checkbox">
											<input type="checkbox" name="organisms[]" value="{{ $val->id}}" 
												{{ in_array($val->id, $testtype->organisms->lists('id'))?"checked":"" }} >
												{{ $val->name }}
										</label>
									</div>
									{{ ($counter%4==0)?"</div>":"" }}
								@endforeach
								</div>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('orderable_test', trans('messages.orderable-test')) }}
						{{ Form::checkbox('orderable_test', 1, Input::old('orderable_test')) }}
					</div>
					<div class="form-group">
						{{ Form::label('accredited', trans('messages.accredited')) }}
						{{ Form::checkbox('accredited', "1", $testtype->isAccredited(), array()) }}
					</div>
				</div>
				<div class="tab-pane col-md-6" id="reorder">
					</br>
					<ul class="list-group list-group-sm sortable">
					@foreach($testtype->measures as $key=>$measure)
						@if($measure->pivot->ordering == null)
							<li class="list-group-item" value="{{$key}}">{{$key}}. {{$measure->name}}</li>
						@else
							<li class="list-group-item" value="{{$measure->pivot->ordering}}">{{$key+1}}. {{$measure->name}}</li>
						@endif
					@endforeach
					</ul>
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
