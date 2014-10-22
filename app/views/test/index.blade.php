@extends("layout")
@section("content")
    <div>
        <ol class="breadcrumb">
          <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
          <li class="active">{{trans('messages.tests')}}</li>
        </ol>
    </div>
    @if (Session::has('message'))
        <div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
    @endif

    {{ Form::open(array('route' => array('test.index'), 'class'=>'form-inline')) }}
            <div class="form-group">
                <label for="search" class="sr-only">search</label>
                <input class="form-control test-search" placeholder="{{trans('messages.search')}}" 
                value="{{isset($search) ? $search : ''}}" name="search" type="text" id="search">
            </div>

            <div class="form-group">
                <label for="testStatus" class="sr-only">testStatus</label>
                <select class="form-control" id="testStatus" name="testStatusId">
                    <option value="">{{trans('messages.all')}}</option>
                    @foreach ($testStatus as $status)
                        {{"<option value=\"".$status->id."\" "}}
                        {{( isset($testStatusId) && $status->id == $testStatusId) ? 'selected>': '>'}}
                        {{ trans("messages.$status->name").'</option>'}}
                    @endforeach
                </select>
            </div>

            {{trans('messages.from')}} 
            <div class="form-group">
                <label class="sr-only" for="date-from">{{trans('messages.from')}}</label>
                <input class="form-control standard-datepicker" name="dateFrom" type="text" 
                    value="{{ isset($dateFrom) ? $dateFrom : '' }}" id="date-from">
            </div>

            {{trans('messages.to')}} 
            <div class="form-group">
                <label class="sr-only" for="date-to">{{trans('messages.to')}}</label>
                <input class="form-control standard-datepicker" name="dateTo" type="text" 
                    value="{{ isset($dateTo) ? $dateTo : '' }}" id="date-to">
            </div>

            <div class="form-group">
                {{ Form::submit(trans('messages.search'), array('class'=>'btn btn-primary')) }}
            </div>
    {{ Form::close() }}

    <br>

    <div class="panel panel-primary test-create">
        <div class="panel-heading ">
            <span class="glyphicon glyphicon-filter"></span>
            {{trans('messages.list-tests')}}
            @if(Auth::user()->can('request_test'))
            <div class="panel-btn">
                <a class="btn btn-sm btn-info" href="javascript:void(0)"
                    data-toggle="modal" data-target="#new-test-modal">
                    <span class="glyphicon glyphicon-plus-sign"></span>
                    {{trans('messages.new-test')}}
                </a>
            </div>
            @endif
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover table-condensed">
                <thead>
                    <tr>
                        <th>{{trans('messages.date-ordered')}}</th>
                        <th>{{trans('messages.patient-name')}}</th>
                        <th>{{trans('messages.test')}}</th>
                        <th>{{trans('messages.visit-type')}}</th>
                        <th>{{trans('messages.test-phase')}}</th>
                        <th>{{trans('messages.test-status')}}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($testSet as $key => $test)
                    <tr>
                        <td>{{ $test->time_created }}</td>              <!--Date Ordered-->
                        <td>{{ $test->visit->patient->name }}</td>      <!--Patient Name -->
                        <td>{{ $test->testType->name }}</td>            <!--Test-->
                        <td>{{ $test->visit->visit_type }}</td>         <!--Visit Type -->
                        <td>{{ $test->testStatus->testPhase->name }}</td><!--Test Phase -->
                        <td id="test-status-{{$test->id}}" class='test-status'>
                            <!-- Test Statuses -->
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        @if($test->test_status_id == Test::NOT_RECEIVED)
                                            <span class='label label-default'>
                                                {{trans('messages.not-received')}}</span>
                                        @elseif($test->test_status_id == Test::PENDING)
                                            <span class='label label-info'>
                                                {{trans('messages.pending')}}</span>
                                        @elseif($test->test_status_id == Test::STARTED)
                                            <span class='label label-warning'>
                                                {{trans('messages.started')}}</span>
                                        @elseif($test->test_status_id == Test::COMPLETED)
                                            <span class='label label-primary'>
                                                {{trans('messages.completed')}}</span>
                                        @elseif($test->test_status_id == Test::VERIFIED)
                                            <span class='label label-success'>
                                                {{trans('messages.verified')}}</span>
                                        @endif
                                    </div></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- Specimen statuses -->
                                        @if($test->specimen->specimen_status_id == Specimen::NOT_COLLECTED)
                                            <span class='label label-info'>
                                                {{trans('messages.specimen-not-collected-label')}}</span>
                                        @elseif($test->specimen->specimen_status_id == Specimen::ACCEPTED)
                                            <span class='label label-success'>
                                                {{trans('messages.specimen-accepted-label')}}</span>
                                        @elseif($test->specimen->specimen_status_id == Specimen::REJECTED)
                                            <span class='label label-danger'>
                                                {{trans('messages.specimen-rejected-label')}}</span>
                                        @endif
                                        </div></div></div>
                        </td>
                        <!-- ACTION BUTTONS -->
                        <td>
                            <a class="btn btn-sm btn-success"
                                href="{{ URL::to('test/'.$test->id.'/viewdetails') }}"
                                id="view-details-{{$test->id}}-link" 
                                title="{{trans('messages.view-details-title')}}">
                                <span class="glyphicon glyphicon-eye-open"></span>
                                {{trans('messages.view-details')}}
                            </a>
                            
                        @if ($test->specimen->specimen_status_id == Specimen::NOT_COLLECTED)
                            @if(Auth::user()->can('accept_test_specimen'))
                            <a class="btn btn-sm btn-info accept-specimen" href="javascript:void(0)"
                                data-test-id="{{$test->id}}" data-specimen-id="{{$test->specimen->id}}"
                                title="{{trans('messages.accept-specimen-title')}}"
                                data-url="{{ URL::route('test.acceptSpecimen') }}">
                                <span class="glyphicon glyphicon-thumbs-up"></span>
                                {{trans('messages.accept-specimen')}}
                            </a>
                            @endif
                            @if(count($test->testType->specimenTypes) > 1 && Auth::user()->can('change_test_specimen'))
                                <!-- 
                                    If this test can be done using more than 1 specimen type,
                                    allow the user to change to any of the other eligible ones.
                                -->
                            <a class="btn btn-sm btn-danger change-specimen" href="#change-specimen-modal"
                                data-toggle="modal" data-url="{{ URL::route('test.changeSpecimenType') }}"
                                data-test-id="{{$test->id}}" data-target="#change-specimen-modal"
                                title="{{trans('messages.change-specimen-title')}}">
                                <span class="glyphicon glyphicon-transfer"></span>
                                {{trans('messages.change-specimen')}}
                            </a>
                            @endif
                        @endif
                        @if ($test->specimen->specimen_status_id == Specimen::ACCEPTED && $test->test_status_id != Test::VERIFIED)
                            @if(Auth::user()->can('reject_test_specimen'))
                            <a class="btn btn-sm btn-danger" id="reject-{{$test->id}}-link"
                                href="{{URL::to('test/'.$test->specimen_id.'/reject')}}"
                                title="{{trans('messages.reject-title')}}">
                                <span class="glyphicon glyphicon-thumbs-down"></span>
                                {{trans('messages.reject')}}
                            </a>
                            @endif
                            @if ($test->test_status_id == Test::PENDING)
                                @if(Auth::user()->can('start_test'))
                                <a class="btn btn-sm btn-warning start-test" href="javascript:void(0)"
                                    data-test-id="{{$test->id}}" data-url="{{ URL::route('test.start') }}"
                                    title="{{trans('messages.start-test-title')}}">
                                    <span class="glyphicon glyphicon-play"></span>
                                    {{trans('messages.start-test')}}
                                </a>
                                @endif
                            @elseif ($test->test_status_id == Test::STARTED)
                                @if(Auth::user()->can('enter_test_results'))
                                <a class="btn btn-sm btn-info" id="enter-results-{{$test->id}}-link"
                                    href="{{ URL::to('test/'.$test->id.'/enterresults') }}"
                                    title="{{trans('messages.enter-results-title')}}">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                    {{trans('messages.enter-results')}}
                                </a>
                                @endif
                            @elseif ($test->test_status_id == Test::COMPLETED)
                                @if(Auth::user()->can('verify_test_results') && Auth::user()->id != $test->tested_by)
                                <a class="btn btn-sm btn-success" id="verify-{{$test->id}}-link"
                                    href="{{ URL::to('test/'.$test->id.'/viewdetails') }}"
                                    title="{{trans('messages.verify-title')}}">
                                    <span class="glyphicon glyphicon-thumbs-up"></span>
                                    {{trans('messages.verify')}}
                                </a>
                                @endif
                                @if(Auth::user()->can('edit_test_results'))
                                <a class="btn btn-sm btn-info" id="edit-{{$test->id}}-link"
                                    href="{{ URL::to('test/'.$test->id.'/edit') }}"
                                    title="{{trans('messages.edit-test-results')}}">
                                    <span class="glyphicon glyphicon-edit"></span>
                                    {{trans('messages.edit')}}
                                </a>
                                @endif
                            @endif
                        @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$testSet->links()}}
        </div>
    </div>

    <!-- MODALS -->
    <div class="modal fade" id="new-test-modal">
      <div class="modal-dialog">
        <div class="modal-content">
        {{ Form::open(array('route' => 'test.create')) }}
          <input type="hidden" id="patient_id" name="patient_id" value="0" />
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">{{trans('messages.close')}}</span>
            </button>
            <h4 class="modal-title">{{trans('messages.create-new-test')}}</h4>
          </div>
          <div class="modal-body">
            <h4>{{ trans('messages.first-select-patient') }}</h4>
            <div class="row">
              <div class="col-lg-12">
                <div class="input-group">
                  <input type="text" class="form-control search-text" 
                    placeholder="{{ trans('messages.search-patient-placeholder') }}">
                  <span class="input-group-btn">
                    <button class="btn btn-default search-patient" type="button">
                        {{ trans('messages.patient-search-button') }}</button>
                  </span>
                </div><!-- /input-group -->
                <div class="patient-search-result form-group">
                    <table class="table table-condensed table-striped table-bordered table-hover hide">
                      <thead>
                        <th> </th>
                        <th>{{ trans('messages.patient-id') }}</th>
                        <th>{{ trans('messages.names') }}</th>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                </div>
              </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">
                {{trans('messages.close')}}</button>
            <button type="button" class="btn btn-primary next" onclick="submit();" disabled>
                {{trans('messages.next')}}</button>
          </div>
        {{ Form::close() }}
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="change-specimen-modal">
      <div class="modal-dialog">
        <div class="modal-content">
        {{ Form::open(array('route' => 'test.updateSpecimenType')) }}
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">{{trans('messages.close')}}</span>
            </button>
            <h4 class="modal-title">
                <span class="glyphicon glyphicon-transfer"></span>
                {{trans('messages.change-specimen-title')}}</h4>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
            {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'),
                array('class' => 'btn btn-primary', 'data-dismiss' => 'modal', 'onclick' => 'submit()')) }}
            <button type="button" class="btn btn-default" data-dismiss="modal">
                {{trans('messages.close')}}</button>
          </div>
        {{ Form::close() }}
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal /#change-specimen-modal-->

    <!-- OTHER UI COMPONENTS -->
    <div class="hidden pending-test-accepted-specimen">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <span class='label label-info'>
                        {{trans('messages.pending')}}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <span class='label label-success'>
                        {{trans('messages.specimen-accepted-label')}}</span>
                </div>
            </div>
        </div>
    </div> <!-- /. pending-test-accepted-specimen -->

    <div class="hidden started-test-accepted-specimen">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <span class='label label-warning'>
                        {{trans('messages.started')}}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <span class='label label-success'>
                        {{trans('messages.specimen-accepted-label')}}</span>
                </div>
            </div>
        </div>
    </div> <!-- /. started-test-accepted-specimen -->

    <div class="hidden reject-start-buttons">
        <a class="btn btn-sm btn-danger reject-specimen" href="#" title="{{trans('messages.reject-title')}}">
            <span class="glyphicon glyphicon-thumbs-down"></span>
            {{trans('messages.reject')}}</a>
        <a class="btn btn-sm btn-warning start-test" href="javascript:void(0)"
            data-url="{{ URL::route('test.start') }}" title="{{trans('messages.start-test-title')}}">
            <span class="glyphicon glyphicon-play"></span>
            {{trans('messages.start-test')}}</a>
    </div> <!-- /. reject-start-buttons -->

    <div class="hidden enter-result-buttons">
        <a class="btn btn-sm btn-info enter-result">
            <span class="glyphicon glyphicon-pencil"></span>
            {{trans('messages.enter-results')}}</a>
    </div> <!-- /. enter-result-buttons -->
@stop