<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="/css/layout.css" />
        <title>iBLIS 1.0</title>
    </head>
    <body>
        <div class="content login-page">
            <div class="container login-form">
                <div class="form-head">
                    <img src="/i/logo_300.png" alt="" height="90" width="90">
                    <h2>Bungoma District Hospital Laboratory </h2>
                    @if($error = $errors->first("password"))
                        <div class="error">
                            {{ $error }}
                        </div>
                    @endif
                </div>
                {{ Form::open(array(
                    "route"        => "user/login",
                    "autocomplete" => "off"
                )) }}
                    <div class="form-row"><i class="icon user"></i>
                    {{ Form::text("username", Input::old("username"), array(
                        "placeholder" => "Username",
                        "class" => "text-field"
                    )) }}</div>
                    <div class="form-row"><i class="icon pass"></i>
                    {{ Form::password("password", array(
                        "placeholder" => "Password",
                        "class" => "text-field"
                    )) }}
                    </div>
                    <div class="form-row"><i class="icon white right-arrow"></i>
                    {{ Form::submit("Login", array(
                        "class" => "btn-green"
                    )) }}
                    </div>
                {{ Form::close() }}
                <div class="smaller-text alone help">
                    <p><a href="{{ URL::route("user/request") }}">Need help?</a></p>
                </div>
                <div class="smaller-text alone foot">
                    <p><a href="#">User Guide</a> | <a href="#">Comments</a></p>
                    <p>
                        iBLIS - a port of the Basic Laboratory Information System (BLIS) to Laravel by iLabAfrica.
                        BLIS was originally developed by C4G.
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
