@extends("layout")
@section("content")
    {{ Form::open(array(
        "route"        => "user/login",
        "autocomplete" => "off"
    )) }}
        {{ Form::label("username", "Username") }}
        {{ Form::text("username", Input::old("username"), array("placeholder" => "jay.ciku")) }}
        {{ Form::label("password", "Password") }}
        {{ Form::password("password", array("placeholder" => "**********")) }}
        @if($error = $errors->first("password"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
        {{ Form::submit("login") }}
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="//polyfill.io"></script>
@stop