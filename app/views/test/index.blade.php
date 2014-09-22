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
                <a class="btn btn-sm btn-info new-item-link" href="{{ URL::route('test.create') }}">
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
            <?php echo $testSet->links(); ?>
        </div>
    </div>
@stop