@extends("layout")
@section("content")
	<div class="section">
		<div class="section-title"><span class="icon-2 white user-edit"></span>Edit Profile</div>
		<div class="user-profile-form">
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
                    <div class="btn-wrap">
                        {{ Form::submit("Change Password", array(
                            "class" => "btn-green"
                        )) }}
                    </div>
                    <div class="btn-wrap">
                        {{ Form::submit("Save", array(
                            "class" => "btn-green"
                        )) }}
                    </div>
                </div>

            {{ Form::close() }}
		</div>
	</div>
@stop