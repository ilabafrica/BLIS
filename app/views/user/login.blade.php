<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-theme.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/layout.css') }}" />
        <title>{{ Config::get('kblis.name') }} {{ Config::get('kblis.version') }}</title>
    </head>
    <body>
        <div class="container login-page">
            <div class="login-form">
                <div class="form-head">
                    <img src="{{ Config::get('kblis.organization-logo') }}" alt="" height="90" width="90">
                    <h3> {{ Config::get('kblis.organization') }} </h3>
                    @if($errors->all())
                        <div class="alert alert-danger">
                            {{ HTML::ul($errors->all()) }}
                        </div>
                    @elseif (Session::has('message'))
                        <div class="alert alert-danger">{{ Session::get('message') }}</div>
                    @endif
                </div>
                {{ Form::open(array(
                    "route"        => "user.login",
                    "autocomplete" => "off",
                    "class" => "form-signin",
                    "role" => "form"
                )) }}
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-user"></span>
                            {{ Form::text("username", Input::old("username"), array(
                                "placeholder" => trans('messages.username'),
                                "class" => "form-control"
                            )) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-lock"></span>
                            {{ Form::password("password", array(
                                "placeholder" => trans('messages.password'),
                                "class" => "form-control"
                            )) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            {{ Form::button(trans('messages.login'), array(
                                "type" => "submit",
                                "class" => "btn btn-primary btn-block"
                            )) }}
                        </div>
                    </div>
                {{ Form::close() }}
                <div class="smaller-text alone foot">
                    <p><a href="#">User Guide in progress</a></p>
                    <p>
                        {{ Config::get('kblis.name') }} - a port of the Basic Laboratory Information System
                         (BLIS) to Laravel by iLabAfrica. BLIS was originally developed by C4G.
                    </p>
                </div>
            </div>
            @include("footer")
        </div>
    </body>
</html>
