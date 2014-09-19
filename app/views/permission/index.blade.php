@extends("layout")
@section("content")
<div>
    <ol class="breadcrumb">
      <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
      <li class="active">{{trans('messages.access-controls')}}</li>
    </ol>
</div>
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<div class="panel panel-primary">
            <div class="panel-heading ">
                <span class="glyphicon glyphicon-user"></span>
                {{ Lang::choice('messages.permission', 2) }}
                <div class="panel-btn">
                    <a class="btn btn-sm btn-info" href="{{ URL::to('role/create') }}">
                        <span class="glyphicon glyphicon-plus-sign"></span>
                        {{trans('messages.new-role')}}
                    </a>
                </div>
            </div>
            <div class="panel-body" >
            {{ Form::open(array('route'=>'permission.store'))}}
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>{{ Lang::choice('messages.permission', 2) }}</th>
                        <th colspan="{{ count($roles)}}">{{ Lang::choice('messages.role', 2) }}</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td></td>
                    @forelse($roles as $role)
                        <td>{{$role->name}}</td>
                    @empty
                        <td>{{trans('messages.no-roles-found')}}</td>
                    @endforelse
                </tr>
                @forelse($permissions as $permissionKey => $permission)
                    <tr>
                        <td>{{$permission->display_name}}</td>
                        @forelse($roles as $roleKey => $role)
                        <td>
                            @if($role->id == 1)
                                <span class="glyphicon glyphicon-lock"></span>
                                {{ Form::checkbox('permissionRoles['.$permissionKey.']['.$roleKey.']', '1',
                                $permission->hasRole($role->name), array('style'=>'display:none') )}}
                            @else
                                {{ Form::checkbox('permissionRoles['.$permissionKey.']['.$roleKey.']', '1',
                                $permission->hasRole($role->name))}}
                            @endif
                            
                        </td>
                        @empty
                            <td>[-]</td>
                        @endforelse
                    </tr>
                @empty
                <tr><td colspan="2">{{trans('messages.no-permissions-found')}}</td></tr>
                @endforelse 
                </tbody>
            </table>
            <div class="form-group actions-row">
                    {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
                        array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
            </div>
            {{Form::close()}}
        </div>
    </div>
@stop