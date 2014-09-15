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

                        <!--Test Action Elements -->
                            <a class="btn btn-sm btn-success hidden"
                                href="{{ URL::to('test/'.$test->id.'/viewdetails') }}"
                                id="view-details-{{$test->id}}-link">
                                <span class="glyphicon glyphicon-eye-open"></span>
                                {{trans('messages.view-details')}}
                            </a>
                            <a class="btn btn-sm btn-danger hidden"
                                href="{{URL::to('test/'.$test->specimen_id.'/reject')}}"
                                id="reject-{{$test->id}}-link">
                                <span class="glyphicon glyphicon-thumbs-down"></span>
                                {{trans('messages.reject')}}
                            </a>
                            <a class="btn btn-sm btn-success start-test-link hidden"
                                href="javascript:startTest({{$test->id}}) " 
                                id="start-test-{{$test->id}}-link">
                                <span class="glyphicon glyphicon-eye-open"></span>
                                {{trans('messages.start-test')}}
                            </a>    
                            <a class="btn btn-sm btn-info hidden"
                                href="{{ URL::to('test/'.$test->id.'/enterresults') }}"
                                id="enter-results-{{$test->id}}-link">
                                <span class="glyphicon glyphicon-pencil"></span>
                                {{trans('messages.enter-results')}}
                            </a>
                            <a class="btn btn-sm btn-success hidden"
                                href="{{ URL::to('test/'.$test->id.'/viewdetails') }}"
                                id="verify-{{$test->id}}-link">
                                <span class="glyphicon glyphicon-thumbs-up"></span>
                                {{trans('messages.verify')}}
                            </a>
                            <a class="btn btn-sm btn-info hidden"
                                href="{{ URL::to('test/'.$test->id.'/edit') }}"
                                 id="edit-{{$test->id}}-link">
                                <span class="glyphicon glyphicon-edit"></span>
                                {{trans('messages.edit')}}
                            </a>
                        <!--Test Action Elements -->

                            <span class="action" id="view-details-{{$test->id}}"></span>
                        @if ($test->specimen->specimen_status_id != 2 && $test->test_status_id < 4)
                            <!-- NOT Rejected AND NOT Verified -->
                            <span class="action" id="reject-{{$test->id}}"></span>
                            @if ($test->test_status_id == 1)<!-- Pending -->
                                <span class="action" id="start-test-{{$test->id}}"></span>
                            @elseif ($test->test_status_id == 2)<!-- Started -->
                                <span class="action" id="enter-results-{{$test->id}}"></span>
                            @elseif ($test->test_status_id == 3)<!-- Completed -->
                                <span class="action" id="verify-{{$test->id}}"></span>
                                <span class="action" id="edit-{{$test->id}}"></span>
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