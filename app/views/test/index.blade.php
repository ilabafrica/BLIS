@extends("layout")
@section("content")
    <div>
        <ol class="breadcrumb">
          <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
          <li class="active">{{ Lang::choice('messages.test',2) }}</li>
        </ol>
    </div>
    @if (Session::has('message'))
        <div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
    @endif

    <div class='container-fluid'>
        {{ Form::open(array('route' => array('test.index'))) }}
            <div class='row'>
                <div class='col-md-3'>
                    <div class='col-md-2'>
                        {{ Form::label('date_from', trans('messages.from')) }}
                    </div>
                    <div class='col-md-10'>
                        {{ Form::text('date_from', Input::get('date_from'), 
                            array('class' => 'form-control standard-datepicker')) }}
                    </div>
                </div>
                <div class='col-md-3'>
                    <div class='col-md-2'>
                        {{ Form::label('date_to', trans('messages.to')) }}
                    </div>
                    <div class='col-md-10'>
                        {{ Form::text('date_to', Input::get('date_to'), 
                            array('class' => 'form-control standard-datepicker')) }}
                    </div>
                </div>
                <div class='col-md-3'>
                    <div class='col-md-5'>
                        {{ Form::label('test_status', trans('messages.test-status')) }}
                    </div>
                    <div class='col-md-7'>
                        {{ Form::select('test_status', $testStatus,
                            Input::get('test_status'), array('class' => 'form-control')) }}
                    </div>
                </div>
                <div class='col-md-2'>
                        {{ Form::label('search', trans('messages.search'), array('class' => 'sr-only')) }}
                        {{ Form::text('search', Input::get('search'),
                            array('class' => 'form-control', 'placeholder' => 'Search')) }}
                </div>
                <div class='col-md-1'>
                        {{ Form::submit(trans('messages.search'), array('class'=>'btn btn-primary')) }}
                </div>
            </div>
        {{ Form::close() }}
    </div>

    <br>

    <div class="panel panel-primary tests-log">
        <div class="panel-heading ">
            <div class="container-fluid">
                <div class="row less-gutter">
                    <div class="col-md-11">
                        <span class="glyphicon glyphicon-filter"></span>{{trans('messages.list-tests')}}
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
                    <div class="col-md-1">
                        <a class="btn btn-sm btn-primary pull-right" href="#" onclick="window.history.back();return false;"
                            alt="{{trans('messages.back')}}" title="{{trans('messages.back')}}">
                            <span class="glyphicon glyphicon-backward"></span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover table-condensed">
                <thead>
                    <tr>
                        <th>{{trans('messages.date-ordered')}}</th>
                        <th>{{trans('messages.patient-number')}}</th>
                        <th>{{trans('messages.visit-number')}}</th>
                        <th class="col-md-2">{{trans('messages.patient-name')}}</th>
                        <th class="col-md-1">{{trans('messages.specimen-id')}}</th>
                        <th>{{ Lang::choice('messages.test',1) }}</th>
                        <th>{{trans('messages.visit-type')}}</th>
                        <th>{{trans('messages.test-status')}}</th>
                        <th class="col-md-3">{{trans('messages.test-status')}}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($testSet as $key => $test)
                    <tr 
                        @if(Session::has('activeTest'))
                            {{ in_array($test->id, Session::get('activeTest'))?"class='info'":""}}
                        @endif
                        >
                        <td>{{ date('d-m-Y H:i', strtotime($test->time_created));}}</td>  <!--Date Ordered-->
                        <td>{{ empty($test->visit->patient->external_patient_number)?
                                $test->visit->patient->patient_number:
                                $test->visit->patient->external_patient_number
                            }}</td> <!--Patient Number -->
                        <td>{{ empty($test->visit->visit_number)?
                                $test->visit->id:
                                $test->visit->visit_number
                            }}</td> <!--Visit Number -->
                        <td>{{ $test->visit->patient->name.' ('.($test->visit->patient->getGender(true)).',
                            '.$test->visit->patient->getAge('Y'). ')'}}</td> <!--Patient Name -->
                        <td>{{ $test->getSpecimenId() }}</td> <!--Specimen ID -->
                        <td>{{ $test->testType->name }}</td> <!--Test-->
                        <td>{{ $test->visit->visit_type }}</td> <!--Visit Type -->
                        <td id="test-status-{{$test->id}}" class='test-status'>
                            <!-- Test Statuses -->
                            <div class="container-fluid">
                            
                                <div class="row">

                                    <div class="col-md-12">
                                        @if($test->isNotReceived())
                                            @if(!$test->isPaid())
                                                <span class='label label-default'>
                                                    {{trans('messages.not-paid')}}</span>
                                            @else
                                            <span class='label label-default'>
                                                {{trans('messages.not-received')}}</span>
                                            @endif
                                        @elseif($test->isPending())
                                            <span class='label label-info'>
                                                {{trans('messages.pending')}}</span>
                                        @elseif($test->isStarted())
                                            <span class='label label-warning'>
                                                {{trans('messages.started')}}</span>
                                        @elseif($test->isCompleted())
                                            <span class='label label-primary'>
                                                {{trans('messages.completed')}}</span>
                                        @elseif($test->isVerified())
                                            <span class='label label-success'>
                                                {{trans('messages.verified')}}</span>
                                        @endif
                                    </div>
    
                                    </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- Specimen statuses -->
                                        @if($test->specimen->isNotCollected())
                                         @if(($test->isPaid()))
                                            <span class='label label-default'>
                                                {{trans('messages.specimen-not-collected-label')}}</span>
                                            @endif
                                        @elseif($test->specimen->isReferred())
                                            <span class='label label-primary'>
                                                {{trans('messages.specimen-referred-label') }}
                                                @if($test->specimen->referral->status == Referral::REFERRED_IN)
                                                    {{ trans("messages.in") }}
                                                @elseif($test->specimen->referral->status == Referral::REFERRED_OUT)
                                                    {{ trans("messages.out") }}
                                                @endif
                                            </span>
                                        @elseif($test->specimen->isAccepted())
                                            <span class='label label-success'>
                                                {{trans('messages.specimen-accepted-label')}}</span>
                                        @elseif($test->specimen->isRejected())
                                            <span class='label label-danger'>
                                                {{trans('messages.specimen-rejected-label')}}</span>
                                        @endif
                                        </div></div></div>
                        </td>
                        <!-- ACTION BUTTONS -->
                        <td>
                            <a class="btn btn-sm btn-success"
                                href="{{ URL::route('test.viewDetails', $test->id) }}"
                                id="view-details-{{$test->id}}-link" 
                                title="{{trans('messages.view-details-title')}}">
                                <span class="glyphicon glyphicon-eye-open"></span>
                                {{trans('messages.view-details')}}
                            </a>
                            
                        @if ($test->isNotReceived()) 
                            @if(Auth::user()->can('receive_external_test') && $test->isPaid())
                                <a class="btn btn-sm btn-default receive-test" href="javascript:void(0)"
                                    data-test-id="{{$test->id}}" data-specimen-id="{{$test->specimen->id}}"
                                    title="{{trans('messages.receive-test-title')}}">
                                    <span class="glyphicon glyphicon-thumbs-up"></span>
                                    {{trans('messages.receive-test')}}
                                </a>
                            @endif
                        @elseif ($test->specimen->isNotCollected())
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
                        @if ($test->specimen->isAccepted() && !($test->isVerified()))
                            @if(Auth::user()->can('reject_test_specimen') && !($test->specimen->isReferred()))
                                <a class="btn btn-sm btn-danger" id="reject-{{$test->id}}-link"
                                    href="{{URL::route('test.reject', array($test->specimen_id))}}"
                                    title="{{trans('messages.reject-title')}}">
                                    <span class="glyphicon glyphicon-thumbs-down"></span>
                                    {{trans('messages.reject')}}
                                </a>
                            @endif
                            @if ($test->isPending())
                                @if(Auth::user()->can('start_test'))
                                    <a class="btn btn-sm btn-warning start-test" href="javascript:void(0)"
                                        data-test-id="{{$test->id}}" data-url="{{ URL::route('test.start') }}"
                                        title="{{trans('messages.start-test-title')}}">
                                        <span class="glyphicon glyphicon-play"></span>
                                        {{trans('messages.start-test')}}
                                    </a>
                                @endif
                                @if(Auth::user()->can('refer_specimens') && !($test->isExternal()) && !($test->specimen->isReferred()))
                                    <a class="btn btn-sm btn-info" href="{{ URL::route('test.refer', array($test->specimen_id)) }}">
                                        <span class="glyphicon glyphicon-edit"></span>
                                        {{trans('messages.refer-sample')}}
                                    </a>
                                @endif
                            @elseif ($test->isStarted())
                                @if(Auth::user()->can('enter_test_results'))
                                    <a class="btn btn-sm btn-info" id="enter-results-{{$test->id}}-link"
                                        href="{{ URL::route('test.enterResults', array($test->id)) }}"
                                        title="{{trans('messages.enter-results-title')}}">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                        {{trans('messages.enter-results')}}
                                    </a>
                                @endif
                            @elseif ($test->isCompleted())
                                @if(Auth::user()->can('edit_test_results'))
                                    <a class="btn btn-sm btn-info" id="edit-{{$test->id}}-link"
                                        href="{{ URL::route('test.edit', array($test->id)) }}"
                                        title="{{trans('messages.edit-test-results')}}">
                                        <span class="glyphicon glyphicon-edit"></span>
                                        {{trans('messages.edit')}}
                                    </a>
                                @endif
                                @if(Auth::user()->can('verify_test_results') && Auth::user()->id != $test->tested_by)
                                    <a class="btn btn-sm btn-success" id="verify-{{$test->id}}-link"
                                        href="{{ URL::route('test.viewDetails', array($test->id)) }}"
                                        title="{{trans('messages.verify-title')}}">
                                        <span class="glyphicon glyphicon-thumbs-up"></span>
                                        {{trans('messages.verify')}}
                                    </a>
                                @endif
                            @endif
                        @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            
            {{ $testSet->links() }}
        {{ Session::put('SOURCE_URL', URL::full()) }}
        {{ Session::put('TESTS_FILTER_INPUT', Input::except('_token')); }}
        
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
                        <th>{{ Lang::choice('messages.name',2) }}</th>
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
    <div class="hidden pending-test-not-collected-specimen">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <span class='label label-info'>
                        {{trans('messages.pending')}}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <span class='label label-default'>
                        {{trans('messages.specimen-not-collected-label')}}</span>                
                </div>
            </div>
        </div>
    </div> <!-- /. pending-test-not-collected-specimen -->

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

    <div class="hidden accept-button">
        <a class="btn btn-sm btn-info accept-specimen" href="javascript:void(0)"
            title="{{trans('messages.accept-specimen-title')}}"
            data-url="{{ URL::route('test.acceptSpecimen') }}">
            <span class="glyphicon glyphicon-thumbs-up"></span>
            {{trans('messages.accept-specimen')}}
        </a>
    </div> <!-- /. accept-button -->

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

    <div class="hidden start-refer-button">
        <a class="btn btn-sm btn-info refer-button" href="#">
            <span class="glyphicon glyphicon-edit"></span>
            {{trans('messages.refer-sample')}}
        </a>
    </div> <!-- /. referral-button -->
@stop