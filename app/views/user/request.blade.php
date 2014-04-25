<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css" />
        <link rel="stylesheet" type="text/css" href="/css/layout.css" />
        <title>{{ Config::get('kblis.name') }} {{ Config::get('kblis.version') }}</title>
    </head>
    <body>
        <div class="content login-page">
            <div class="container login-form">
                <div class="form-head">
                    <img src="/i/logo_300.png" alt="" height="90" width="90">
                    <h3>{{ Config::get('kblis.organization') }}</h3>
                    @if($error = $errors->first("password"))
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endif
                </div>
                <div class="smaller-text info">
                	<p>You will receive an email in the account specified below with a link
                		alllowing you to reset the password.</p>
                </div>
				{{ Form::open(array(
					"route"		   => "user.request",
					"autocomplete" => "off",
                    "role" => "form"
					)) }}
					<div class="form-group">
                        <span class="glyphicon glyphicon-envelope"></span>
						{{ Form::text("email", Input::get("email"), array(
						"placeholder" => "j.siku@example.com",
						"class" => "form-control"
					)) }}
					</div>
					<div class="form-row float-r">
                            {{ Form::button("Back",  ["name" => "back",  "value" => "1", "type" => "submit", "class" => "btn btn-success"]) }}
                            {{ Form::button("Reset", ["name" => "reset", "value" => "2", "type" => "submit", "class" => "btn btn-danger"]) }}
					</div>
				{{ Form::close() }}
                <div class="smaller-text alone foot">
                    <p><a href="#">User Guide</a> | <a href="#">Comments</a></p>
                    <p>
                        {{ Config::get('kblis.name') }} - a port of the Basic Laboratory Information System (BLIS) to Laravel by iLabAfrica.
                        BLIS was originally developed by C4G.
                    </p>
                </div>
            </div>
            @include("footer")
        </div>
    </body>
</html>
