@extends("layout")
@section("content")
    <div>
        <ol class="breadcrumb">
          <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
          <li><a href="{{ URL::route('test.index') }}">{{ Lang::choice('messages.test', 2) }}</a></li>
          <li class="active">{{trans('messages.billing')}}</li>
        </ol>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading ">
            <div class="container-fluid">
                <div class="row less-gutter">
                    <div class="col-md-11">
                        <span class="glyphicon glyphicon-filter"></span> {{trans('messages.billing')}}
                        <div class="panel-btn">
                            <a class="btn btn-sm btn-info" href="javascript:void(0)"
                                data-toggle="modal" data-target="#new-test-modal">
                                <span class="glyphicon glyphicon-print"></span>
                                {{trans('messages.print')}}
                            </a>
                        </div>
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
            <strong>
                <p>
                    {{ trans('messages.bill-for').$visit->patient->name }}
                </p>
            </strong>
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th>{{ trans('messages.date-ordered') }}</th>
                        <th>{{ trans_choice('messages.test', 1) }}</th>
                        <th>{{ trans_choice('messages.specimen', 1) }}</th>
                        <th>{{ trans('messages.cost-to-patient') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($visit->tests as $test)
                    <tr>
                        <td>{{ $test->time_created }}</td>
                        <td>{{ $test->testType->name }}</td>
                        <td>{{ $test->specimen->specimenType->name }}</td>
                        <td>{{ $test->testType->cost() }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3"><strong>{{ trans_choice('messages.total', 1) }}</strong></td>
                        <td><strong>{{ $visit->cost() }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop