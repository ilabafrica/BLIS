@extends("layout")
@section("content")
<div>
    <ol class="breadcrumb">
      <li><a href="{{{URL::route('user.home')}}}">Home</a></li>
      <li class="active">Access controls</li>
    </ol>
</div>
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<div class="panel panel-primary">
    <div class="panel-heading ">
        <span class="glyphicon glyphicon-user"></span>
        Permissions
        <div class="panel-btn">
            <a class="btn btn-sm btn-info" href="{{ URL::to('patient/create') }}">
                <span class="glyphicon glyphicon-plus-sign"></span>
                New Role
            </a>
        </div>
    </div>

</div>
@stop