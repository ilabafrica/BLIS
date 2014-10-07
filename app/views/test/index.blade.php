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
    <div class="panel panel-primary test-create">
        <div class="panel-heading ">
            <span class="glyphicon glyphicon-filter"></span>
            {{trans('messages.list-tests')}}
            <div class="panel-btn">
                <a class="btn btn-sm btn-info" href="javascript:void(0)"
                    data-toggle="modal" data-target="#new-test-modal">
                    <span class="glyphicon glyphicon-plus-sign"></span>
                    {{trans('messages.new-test')}}
                </a>
            </div>
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
                        <td id="test-status-{{$test->id}}">              <!--Status-->
                            {{trans('messages.'.$test->testStatus->name)}}
                            @if($test->specimen->specimen_status_id == 2)
                                <br /><span class='label label-danger'>
                                    {{trans('messages.rejection-label')}}</span>
                            @endif
                        </td>
                        
                        <td>

                        <!--'Enter Result' button loaded via ajax in place of 'Start Test' button, on starting a Test-->
                        <!-- Serves the purpose of localisation, since it is generated at the back end -->
                        <a class="btn btn-sm btn-info hidden"
                            href="{{ URL::to('test/'.$test->id.'/enterresults') }}"
                            id="enter-results-{{$test->id}}-link">
                            <span class="glyphicon glyphicon-pencil"></span>
                            {{trans('messages.enter-results')}}
                        </a>
                        <!--'Enter Result' button loaded via ajax in place of 'Start Test' button, on starting a Test-->

                            <a class="btn btn-sm btn-success"
                                href="{{ URL::to('test/'.$test->id.'/viewdetails') }}"
                                id="view-details-{{$test->id}}-link">
                                <span class="glyphicon glyphicon-eye-open"></span>
                                {{trans('messages.view-details')}}
                            </a>
                        @if ($test->specimen->specimen_status_id != 2 && $test->test_status_id < 4)
                            <!-- NOT Rejected AND NOT Verified -->
                                <a class="btn btn-sm btn-danger"
                                    href="{{URL::to('test/'.$test->specimen_id.'/reject')}}"
                                    id="reject-{{$test->id}}-link">
                                    <span class="glyphicon glyphicon-thumbs-down"></span>
                                    {{trans('messages.reject')}}
                                </a>
                            @if ($test->test_status_id == 1)<!-- Pending -->
                                <a class="btn btn-sm btn-success start-test-link"
                                    href="javascript:void(0);" 
                                    onclick="startTest('{{ $test->id }}')"
                                    id="start-test-{{$test->id}}-link">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                    {{trans('messages.start-test')}}
                                </a>    
                            @elseif ($test->test_status_id == 2)<!-- Started -->
                                <a class="btn btn-sm btn-info"
                                    href="{{ URL::to('test/'.$test->id.'/enterresults') }}"
                                    id="enter-results-{{$test->id}}-link">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                    {{trans('messages.enter-results')}}
                                </a>
                            @elseif ($test->test_status_id == 3)<!-- Completed -->
                                <a class="btn btn-sm btn-success"
                                    href="{{ URL::to('test/'.$test->id.'/viewdetails') }}"
                                    id="verify-{{$test->id}}-link">
                                    <span class="glyphicon glyphicon-thumbs-up"></span>
                                    {{trans('messages.verify')}}
                                </a>
                                <a class="btn btn-sm btn-info"
                                    href="{{ URL::to('test/'.$test->id.'/edit') }}"
                                     id="edit-{{$test->id}}-link">
                                    <span class="glyphicon glyphicon-edit"></span>
                                    {{trans('messages.edit')}}
                                </a>
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
@stop