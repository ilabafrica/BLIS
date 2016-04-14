@extends("layout")
@section("content")
<br />
<div>
  <ol class="breadcrumb">
    <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
    <li class="active">{{Lang::choice('messages.region-type',2)}}</li>
  </ol>
</div>
@if(Session::has('message'))
<div class="alert alert-info">{{Session::get('message')}}</div>
@endif
<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.region-type', 2) }} <span class="panel-btn">
      
      <a class="btn btn-sm btn-info" href="{{ URL::to("regiontype/create") }}" >
        <span class="glyphicon glyphicon-plus-sign"></span>
            {{ trans('messages.create-region-type') }}
          </a>
     
        </span>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped table-bordered table-hover search-table">
                    <thead>
                        <tr>
                            <th>{{ Lang::choice('messages.name', 1) }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($regionTypes as $regionType)
                        <tr>
                            <td>{{ $regionType->name }}</td>
                           
                            <td>
                              <a href="{{ URL::to("regiontype/" . $regionType->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i><span> View</span></a>
                              @if(Auth::user()->can('manage'))
                              <a href="{{ URL::to("regiontype/" . $regionType->id . "/edit") }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i><span> Edit</span></a>
                              <a href="{{ URL::to("regiontype/" . $regiontype->id . "/delete") }}" class="btn btn-warning btn-sm"><i class="fa fa-trash-o"></i><span> Delete</span></a>
                              @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="3">{{ Lang::choice('messages.no-records-found', 1) }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ Session::put('SOURCE_URL', URL::full()) }}
        </div>
      </div>
</div>
@stop