@extends("layout")
@section("content")
	<div class="panel panel-primary user-profile">
		<div class="panel-heading ">
            <span class="glyphicon glyphicon-edit"></span>
            Edit Profile
        </div>
		<div class="panel-body">
			{{ Form::open(array(
                    "route"        => "user.login",
                    "autocomplete" => "off"
                )) }}
                <div class="form-group">
                	{{ Form::label('username', 'Username: ') }}
                    {{ Form::text("username", Input::old("username"), array(
                        "placeholder" => "jsiku",
                        "class" => "form-control"
                    )) }}</div>
                <div class="form-group">
                	{{ Form::label('name', 'Full Names: ') }}
                    {{ Form::text("name", Input::old("name"), array(
                        "placeholder" => "Jay Siku",
                        "class" => "form-control"
                    )) }}</div>
                <div class="form-group">
                	{{ Form::label('email', 'Email Address: ') }}
                    {{ Form::text("email", Input::old("email"), array(
                        "placeholder" => "j.siku@ilabafrica.ac.ke",
                        "class" => "form-control"
                    )) }}</div>
                <div class="form-group">
                	{{ Form::label('designation', 'Designation: ') }}
                    {{ Form::text("designation", Input::old("designation"), array(
                        "placeholder" => "Lab Technologist",
                        "class" => "form-control"
                    )) }}</div>
                <div class="form-group">
                    {{ Form::label('gender', 'Gender: ') }}
                    <div>{{ Form::radio('gender', 'm', true) }} Male</div>
                    <div>{{ Form::radio("gender", 'f', false) }} Female</div>
                </div>
                <div class="form-group">
                	{{ Form::label('image', 'Photo: ') }}
                    {{ Form::file("image") }}</div>
                <div class="form-group actions-row">
                    {{ Form::button("Change Password", [ "class" => "btn btn-primary", "type" => "submit"]) }}
                    {{ Form::button("Save", ["type" => "submit", "class" => "btn btn-success"]) }}
                    {{ Form::button("Cancel", [ "class" => "btn btn-default", "type" => "submit"]) }}
                </div>

            {{ Form::close() }}
		</div>
	</div>
@stop