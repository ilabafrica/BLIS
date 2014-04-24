<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css" />
        <link rel="stylesheet" type="text/css" href="/css/layout.css" />
        <title>lara BLIS 1.0</title>
    </head>
    <body>
        <div class="container login-page">
            <div class="login-form">
                <div class="form-head">
                    <img src="/i/logo_300.png" alt="" height="90" width="90">
                    <h3>Bungoma District Hospital Laboratory </h3>
                    @if($error = $errors->first("password"))
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endif
                </div>
                {{ Form::open(array(
                    "route"        => "user.login",
                    "autocomplete" => "off",
                    "class" => "form-signin",
                    "role" => "form"
                )) }}
                    <div class="form-group">
                        <span class="glyphicon glyphicon-user"></span>
                        {{ Form::text("username", Input::old("username"), array(
                            "placeholder" => "Username",
                            "class" => "form-control"
                        )) }}
                    </div>
                    <div class="form-group">
                        <span class="glyphicon glyphicon-lock"></span>
                        {{ Form::password("password", array(
                            "placeholder" => "Password",
                            "class" => "form-control"
                        )) }}
                    </div>
                    <div class="form-group">
                        <div>
                            {{ Form::button("Login", array(
                                "type" => "submit",
                                "class" => "btn btn-primary btn-block"
                            )) }}
                        </div>
                    </div>
                {{ Form::close() }}
                <div class="smaller-text alone help">
                    <p><a href="{{ URL::route("user.request") }}">Need help?</a></p>
                </div>
                <div class="smaller-text alone foot">
                    <p><a href="userguide/" target="_blank">User Guide</a> | <a href="#">Comments</a></p>
                    <p>
                        iBLIS - a port of the Basic Laboratory Information System (BLIS) to Laravel by iLabAfrica.
                        BLIS was originally developed by C4G.
                    </p>
                </div>
            </div>
            @include("footer")
        </div>
    </body>
</html>
