@extends("layout")
@section("content")
	<div class="panel panel-primary">
		<div class="panel-heading "><h3>Edit Profile</h3></div>
		<div class="panel-body">
			{{ Form::open(array(
                    "route"        => "user/login",
                    "autocomplete" => "off"
                )) }}
                <div class="form-row">
                	{{ Form::label('username', 'Username: ') }}
                    {{ Form::text("username", Input::old("username"), array(
                        "placeholder" => "jsiku",
                        "class" => "text-field"
                    )) }}</div>
                <div class="form-row">
                	{{ Form::label('name', 'Full Names: ') }}
                    {{ Form::text("name", Input::old("name"), array(
                        "placeholder" => "Jay Siku",
                        "class" => "text-field"
                    )) }}</div>
                <div class="form-row">
                	{{ Form::label('email', 'Email Address: ') }}
                    {{ Form::text("email", Input::old("email"), array(
                        "placeholder" => "j.siku@ilabafrica.ac.ke",
                        "class" => "text-field"
                    )) }}</div>
                <div class="form-row">
                	{{ Form::label('designation', 'Designation: ') }}
                    {{ Form::text("designation", Input::old("designation"), array(
                        "placeholder" => "Lab Technologist",
                        "class" => "text-field"
                    )) }}</div>
                <div class="form-row">
                	{{ Form::label('gender', 'Gender: ') }}
                    {{ Form::text("gender", Input::old("gender"), array(
                        "class" => "text-field"
                    )) }}</div>
                <div class="form-row">
                	{{ Form::label('image', 'Photo: ') }}
                    {{ Form::text("image", Input::old("image"), array(
                        "class" => "text-field"
                    )) }}</div>
                <div class="form-row">
                    {{ Form::button("Change Password", [ "class" => "btn btn-primary", "type" => "submit"]) }}
                    {{ Form::button("Save", array(
                        "type" => "submit",
                        "class" => "btn btn-success"
                    )) }}
                    {{ Form::button("Cancel", [ "class" => "btn btn-default", "type" => "submit"]) }}
                </div>

            {{ Form::close() }}
		</div>
	</div>
@stop