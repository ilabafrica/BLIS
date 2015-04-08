@extends("layout")
@section("content")
<div>
    <ol class="breadcrumb">
      <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
      <li class="active">{{trans('messages.show-results')}}</li>
    </ol>
</div>
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<div class="panel panel-primary">
    <div class="panel-heading ">
        <span class="glyphicon glyphicon-adjust"></span>
        {{ trans('messages.list-results') }}
    </div>
    <div class="panel-body">
        <table class="table table-striped table-hover table-condensed search-table">
          @foreach($control->controlMeasures as $key => $controlMeasure)
            {{ Form::label("m_".$controlMeasure->id , $control->name) }}
            @endforeach
            <thead>
                <tr>
                    <th>{{ Lang::choice('messages.result-id', 1) }}</th>
                    <th>{{ Lang::choice('messages.result-name', 1) }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach($result as $result)
                    <td>{{ $result->id }}</td>
                    <td>{{ $result->results}}</td>
                    <td>
                        <a class="btn btn-sm btn-info" href="{{ URL::to("controlresults/" . $control->id . "/resultsedit") }}" >
                            <span class="glyphicon glyphicon-edit"></span>
                            {{ trans('messages.edit') }}
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ Session::put('SOURCE_URL', URL::full()) }}
    </div>
</div>
@stop