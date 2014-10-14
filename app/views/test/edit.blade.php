@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		  <li><a href="{{ URL::route('test.index') }}">{{ trans('messages.tests') }}</a></li>
		  <li class="active">{{ trans('messages.edit') }}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-filter"></span>
			{{ trans('messages.edit') }}
		</div>
		<div class="panel-body">
		<!-- if there are creation errors, they will show here -->
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
			{{ Form::open(array('url' => 'test/'.$test->id.'/saveresults', 'method' => 'POST')) }}
				@foreach($test->testType->measures as $measure)
					<div class="form-group">
						<?php
						$ans = "";
						foreach ($test->testResults as $res) {
							if($res->measure_id == $measure->id)$ans = $res->result;
						}
						 ?>
					<?php
					$fieldName = "m_".$measure->id;
					switch($measure->measureType->id){
						case 1:
						?>
							{{ Form::label($fieldName , $measure->name) }}
							{{ Form::text($fieldName, $ans, array('class' => 'form-control'))}}
							<span class='units'>{{$measure->unit}}</span>
						<?php
						break;
						case 2:
							$values = explode("/", $measure->measure_range);
							$measure_values = array_combine($values, $values);
						?>
							{{ Form::label($fieldName , $measure->name) }}
							{{ Form::select($fieldName, $measure_values, array_search($ans, $measure_values),
								array('class' => 'form-control')) }}
						<?php
						break;
						case 3:
						break;
						case 4:
							?>
							{{ Form::label($fieldName, $measure->name) }}
							{{Form::text($fieldName, $ans, array('class' => 'form-control'))}}
							<?php
						break;
					?>
					<?php } ?>
					</div>
				@endforeach
				<div class="form-group">
					{{ Form::label('interpretation', trans('messages.interpretation')) }}
					{{ Form::textarea('interpretation', $test->interpretation, 
						array('class' => 'form-control', 'rows' => '2')) }}
				</div>
				<div class="form-group actions-row">
					{{ Form::button('<span class="glyphicon glyphicon-save"></span> '.trans('messages.update-test-results'),
						array('class' => 'btn btn-default', 'onclick' => 'submit()')) }}
				</div>
			{{ Form::close() }}
		</div>
	</div>
@stop