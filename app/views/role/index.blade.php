@extends("layout")
@section("content")
<div>
    <ol class="breadcrumb">
      <li><a href="{{{URL::route('user.home')}}}">Home</a></li>
      <li class="active">Roles</li>
    </ol>
</div>
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<div class="panel panel-primary">
    <div class="panel-heading ">
        <span class="glyphicon glyphicon-user"></span>
        Roles
        <div class="panel-btn">
            <a class="btn btn-sm btn-info" href="{{ URL::to("role/create") }}" >
                <span class="glyphicon glyphicon-plus-sign"></span>
                New role
            </a>
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-hover table-condensed">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @forelse($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->description }}</td>
                    <td>
                        <a class="btn btn-sm btn-info" href="{{ URL::to("role/" . $role->id . "/edit") }}" >
                            <span class="glyphicon glyphicon-edit"></span>
                            Edit
                        </a>
                        <button class="btn btn-sm btn-danger delete-item-link" 
                            data-toggle="modal" data-target=".confirm-delete-modal" 
                            data-id='{{ URL::to("role/" . $role->id . "/delete") }}'>
                            <span class="glyphicon glyphicon-trash"></span>
                            Delete
                        </button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="2">No roles found</td></tr>
            @endforelse
            </tbody>
        </table>
        <?php echo $roles->links(); ?>
    </div>
</div>
@stop