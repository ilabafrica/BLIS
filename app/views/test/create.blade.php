@extends("layout")
@section("content")

	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li>
		  	<a href="{{ URL::route('test.index') }}">{{ Lang::choice('messages.test',2) }}</a>
		  </li>
		  <li class="active">{{trans('messages.new-test')}}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
            <div class="container-fluid">
                <div class="row less-gutter">
                    <div class="col-md-11">
						<span class="glyphicon glyphicon-adjust"></span>{{trans('messages.new-test')}}
                    </div>
                    <div class="col-md-1">
                        <a class="btn btn-sm btn-primary pull-right" href="#" onclick="window.history.back();return false;"
                            alt="{{trans('messages.back')}}" title="{{trans('messages.back')}}">
                            <span class="glyphicon glyphicon-backward"></span></a>
                    </div>
                </div>
            </div>
		</div>
		<div class="panel-body">
		<!-- if there are creation errors, they will show here -->
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif

			{{ Form::open(array('route' => 'test.saveNewTest', 'id' => 'form-new-test')) }}
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-info">
								<div class="panel-heading">
									<h3 class="panel-title">{{trans("messages.patient-details")}}</h3>
								</div>
								<div class="panel-body inline-display-details">
									<span><strong>{{trans("messages.patient-number")}}</strong> {{ $patient->patient_number }}</span>
									<span><strong>{{ Lang::choice('messages.name',1) }}</strong> {{ $patient->name }}</span>
									<span><strong>{{trans("messages.age")}}</strong> {{ $patient->getAge() }}</span>
									<span><strong>{{trans("messages.gender")}}</strong>
										{{ $patient->gender==0?trans("messages.male"):trans("messages.female") }}</span>
								</div>
							</div>
							<div class="form-group">
								{{ Form::hidden('patient_id', $patient->id) }}
								{{ Form::label('visit_type', trans("messages.visit-type")) }}
								{{ Form::select('visit_type', [trans("messages.out-patient"),trans("messages.in-patient")], null,
									 array('class' => 'form-control')) }}
							</div>
							<div class="form-group">
								{{ Form::label('physician', trans("messages.physician")) }}
								{{Form::text('physician', Input::old('physician'), array('class' => 'form-control'))}}
							</div>
							<div class="form-group">
								{{ Form::label('tests', trans("messages.select-tests")) }}
								<div class="form-pane panel panel-default">
									<div class="container-fluid">
										<?php 
											$cnt = 0;
											$zebra = "";
										?>
									@foreach($testtypes as $key=>$value)
										{{ ($cnt%4==0)?"<div class='row $zebra'>":"" }}
										<?php
											$cnt++;
											$zebra = (((int)$cnt/4)%2==1?"row-striped":"");
										?>
										<div class="col-md-3">
											<label  class="checkbox">
												<input type="checkbox" name="testtypes[]" value="{{ $value->id}}" />{{$value->name}}
											</label>
										</div>
										{{ ($cnt%4==0)?"</div>":"" }}
									@endforeach
									</div>
								</div>
							</div>
							<div class="form-group actions-row">
								{{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save-test'), 
									array('class' => 'btn btn-primary', 'onclick' => 'submit()', 'alt' => 'save_new_test')) }}
							</div>
						</div>
					</div>
				</div>

			{{ Form::close() }}
		</div>
	</div>
@stop	