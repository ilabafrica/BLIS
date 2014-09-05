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
                        <td>{{ $test->testStatus->name }}</td>          <!--Status-->
                        
                        <td>
                            <a class="btn btn-sm btn-success" href="{{ URL::to('test/'.$test->id.'/viewdetails') }}">
                                <span class="glyphicon glyphicon-eye-open"></span>
                                View Details
                            </a>
                        @if ($test->specimen->specimen_status_id != 2 && $test->test_status_id < 4)
                            <!-- NOT Rejected AND NOT Verified -->
                            <a class="btn btn-sm btn-danger new-item-link" 
                                href="{{URL::to('test/'.$test->specimen_id.'/reject')}}">
                                <span class="glyphicon glyphicon-thumbs-down"></span>
                                Reject
                            </a>
                             @if ($test->test_status_id == 1)<!-- Pending -->
                                <a class="btn btn-sm btn-success new-item-link" href="{{ URL::to('test/'.$test->id.'/start') }}"
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                    Start Test
                                </a>    
                            @elseif ($test->test_status_id == 2)<!-- Started -->
                                <a class="btn btn-sm btn-info new-item-link" href="{{ URL::to('test/'.$test->id.'/enterresults') }}">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                    Enter Results
                                </a>
                            @elseif ($test->test_status_id == 3)<!-- Completed -->
                                <a class="btn btn-sm btn-success new-item-link" href="{{ URL::to('test/'.$test->id.'/viewdetails') }}">
                                    <span class="glyphicon glyphicon-thumbs-up"></span>
                                    Verify
                                </a>
                                <a class="btn btn-sm btn-info new-item-link" href="{{ URL::to('test/'.$test->id.'/edit') }}">
                                    <span class="glyphicon glyphicon-edit"></span>
                                    Edit
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