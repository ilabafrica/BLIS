@extends("layout")
@section("content")
<div>
    <ol class="breadcrumb">
      <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
      <li class="active">{{trans('messages.roles')}}</li>
    </ol>
</div>
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<div class="panel panel-primary">
    <div class="panel-heading ">
        <span class="glyphicon glyphicon-user"></span>
        {{trans('messages.roles')}}
        <div class="panel-btn">
            <a class="btn btn-sm btn-info" href="{{ URL::to("role/create") }}" >
                <span class="glyphicon glyphicon-plus-sign"></span>
                {{trans('messages.new-role')}}
            </a>
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-hover table-condensed">
            <thead>
                <tr>
                    <th>{{trans('messages.name')}}</th>
                    <th>{{trans('messages.description')}}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @forelse($roles as $role)
                <tr @if(Session::has('activerole'))
                            {{(Session::get('activerole') == $role->id)?"class='info'":""}}
                        @endif>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->description }}</td>
                    <td>
                        <a class="btn btn-sm btn-info {{($role == Role::getAdminRole()) ? 'disabled': ''}}" 
                            href="{{ URL::to("role/" . $role->id . "/edit") }}" >
                            <span class="glyphicon glyphicon-edit"></span>
                            {{ trans('messages.edit') }}
                        </a>
                        <button class="btn btn-sm btn-danger delete-item-link {{($role == Role::getAdminRole()) ? 'disabled': ''}}" 
                            data-toggle="modal" data-target=".confirm-delete-modal" 
                            data-id='{{ URL::to("role/" . $role->id . "/delete") }}'>
                            <span class="glyphicon glyphicon-trash"></span>
                            {{ trans('messages.delete') }}
                        </button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="2">{{ trans('messages.no-roles-found') }}</td></tr>
            @endforelse
            </tbody>
        </table>
        <?php echo $roles->links(); 
        Session::put('SOURCE_URL', URL::full());?>
    </div>
</div>
@stop