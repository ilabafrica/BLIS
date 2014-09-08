@extends("layout")
@section("content")
<div>
    <ol class="breadcrumb">
      <li><a href="{{{URL::route('user.home')}}}">Home</a></li>
      <li>
        <a href="{{ URL::route('role.index') }}">Role</a>
      </li>
      <li class="active">Create Role</li>
    </ol>
</div>
<div class="panel panel-primary">
    <div class="panel-heading ">
        <span class="glyphicon glyphicon-user"></span>
        Create Role
    </div>
    <div class="panel-body">
    <!-- if there are creation errors, they will show here -->
        @if($errors->all())
            <div class="alert alert-danger">
                {{ HTML::ul($errors->all()) }}
            </div>
        @endif

        {{ Form::open(array('url' => 'role', 'id' => 'form-create-role')) }}

            <div class="form-group">
                {{ Form::label('name', 'Name') }}
                {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
            </div>
            <div class="form-group">
                {{ Form::label('description', 'Description') }}
                {{ Form::textarea('description', Input::old('description'), 
                    array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group actions-row">
                {{ Form::button(
                    '<span class="glyphicon glyphicon-save"></span> Save',
                    ['class' => 'btn btn-primary', 'onclick' => 'submit()'] 
                ) }}
            </div>

        {{ Form::close() }}
    </div>
</div>
@stop