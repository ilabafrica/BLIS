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
                    <a class="btn btn-sm btn-info" href="{{ URL::to('role/create') }}">
                        <span class="glyphicon glyphicon-plus-sign"></span>
                        New Role
                    </a>
                </div>
            </div>
            <div class="panel-body" >
            {{ Form::open(array('route'=>'permission.store'))}}
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Permissions</th>
                        <th colspan="{{ count($roles)}}">Roles</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td></td>
                    @forelse($roles as $role)
                        <td>{{$role->name}}</td>
                    @empty
                        <td>No roles found</td>
                    @endforelse
                </tr>
                @forelse($permissions as $permissionKey => $permission)
                    <tr>
                        <td>{{$permission->display_name}}</td>
                        @forelse($roles as $roleKey => $role)
                        <td>
                            {{ Form::checkbox('permissionRoles['.$permissionKey.']['.$roleKey.']', 'value', $permission->hasRole($role->name)) }}
                        </td>
                        @empty
                            <td>[-]</td>
                        @endforelse
                    </tr>
                @empty
                <tr><td colspan="2">No permissions assigned</td></tr>
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