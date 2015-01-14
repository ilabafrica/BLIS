@extends("layout")
@section("content")
    <div>
        <ol class="breadcrumb">
          <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
          <li><a href="{{ URL::route('test.index') }}">{{ Lang::choice('messages.test', 2) }}</a></li>
          <li class="active">{{trans('messages.referrals')}}</li>
        </ol>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading ">
            <div class="container-fluid">
                <div class="row less-gutter">
                    <div class="col-md-11">
                        <span class="glyphicon glyphicon-filter"></span> {{trans('messages.referrals')}}
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
        {{ Form::open(array('route' => 'test.referAction')) }}
            {{ Form::hidden('specimen_id', $specimen->id) }}
            <div class="panel-body">
                <div class="display-details">
                    <p><strong>{{trans('messages.specimen-type-title')}}</strong>
                        {{$specimen->specimenType->name}}</p>
                    <p>
                    <p><strong>{{ Lang::choice('messages.test-type',1) }}</strong>
                        {{$specimen->test->testType->name}}</p>
                    </p>
                </div>
                <br>
                <div class="form-group">
                    {{ Form::label('refer', trans('messages.refer')) }}
                    <div>{{ Form::radio('referral-status', '0', true) }}<span class='input-tag'>
                        {{trans('messages.in')}}</span></div>
                    <div>{{ Form::radio('referral-status', '1', false) }}<span class='input-tag'>
                        {{trans('messages.out')}}</span></div>
                </div>
                <div class="form-group">
                    {{ Form::label('facility', Lang::choice("messages.facility",2)) }}
                    {{ Form::select('facility_id', $facilities->lists('name', 'id'), Input::old('facility_id'),
                        array('class' => 'form-control')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('person', trans("messages.person")) }}
                    {{Form::text('person', Input::old('person'),
                        array('class' => 'form-control'))}}
                </div>
                <div class="form-group">
                    {{ Form::label('contacts', trans("messages.contacts")) }}
                    {{Form::textarea('contacts', Input::old('contacts'),
                        array('class' => 'form-control'))}}
                </div>
                <div class="form-group actions-row">
                    {{ Form::button("<span class='glyphicon glyphicon-thumbs-up'></span> ".trans('messages.refer'),
                        ['class' => 'btn btn-danger', 'onclick' => 'submit()']) }}
                </div>
            </div>
        {{ Form::close() }}
        </div>
    </div>
@stop