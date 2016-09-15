@extends("layout")
@section("content")
<div>
    <ol class="breadcrumb">
      <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
      <li>
        <a href="{{ URL::route('role.index') }}">{{ trans_choice('messages.role',1) }}</a>
      </li>
      <li class="active">{{trans('messages.new-role')}}</li>
    </ol>
</div>
<div class="panel panel-primary">
    <div class="panel-heading ">
        <span class="glyphicon glyphicon-user"></span>
        {{trans('messages.new-role')}}
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
                {{ Form::label('name', trans_choice('messages.name',1)) }}
                {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
            </div>
            <div class="form-group">
                {{ Form::label('description', trans('messages.description')) }}
                {{ Form::textarea('description', Input::old('description'), 
                    array('class' => 'form-control', 'rows' => '2')) }}
            </div>
            <div class="form-group actions-row">
                    {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
                        array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
            </div>
        {{ Form::close() }}
    </div>
</div>
@stop