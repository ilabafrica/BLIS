@extends("app")
@section("content")
<div>
    <ol class="breadcrumb">
      <li><a href="{!! URL::route('user.home')!!}">{!! trans('menu.home') !!}</a></li>
      <li><a href="{!! URL::route('control.resultsIndex') !!}">{!! trans_choice('terms.controlresults',2) !!}</a></li>
      <li class="active">{!!trans('terms.show-results')!!}</li>
    </ol>
</div>
@if (Session::has('message'))
    <div class="alert alert-info">{!! Session::get('message') !!}</div>
@endif
<div class="panel panel-primary">
    <div class="panel-heading ">
        <span class="glyphicon glyphicon-adjust"></span>
        {!! trans('terms.list-results') .'  '. $control->name  !!}
    </div>
    <div class="panel-body">
        <table class="table table-striped table-hover table-condensed search-table">
            <thead>
                <tr>
                    <th> {!! trans_choice('terms.test-id', 1) !!} </th>
                    <th>{!! trans_choice('terms.created-at', 1) !!}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($control->controlTests as $controlResult)
                <tr>
                    <td>{!!$controlResult->id!!}</td>
                    <td>{!!$controlResult->created_at!!}</td>
                    <td>
                        <a class="btn btn-sm btn-info" href="{!! URL::to("controlresults/" . $controlResult->id . "/resultsEdit") !!}" >
                            <span class="glyphicon glyphicon-edit"></span>
                            {!! trans('action.edit') !!}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {!! Session::put('SOURCE_URL', URL::full()) !!}
    </div>
</div>
@stop