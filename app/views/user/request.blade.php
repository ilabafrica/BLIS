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
                <div class="smaller-text info">
                	<p>You will receive an email in the account specified below with a link
                		alllowing you to reset the password.</p>
                </div>
				{{ Form::open(array(
					"route"		   => "user/request",
					"autocomplete" => "off"
					)) }}
					<div class="form-row"><span class="icon user"></span>
						{{ Form::text("email", Input::get("email"), array(
						"placeholder" => "j.siku@example.com",
						"class" => "text-field"
					)) }}
					</div>
					<div class="form-row">
						<div class="btn-wrap">
							<span class="icon white right-arrow"></span>
							{{ Form::submit("Reset", ["class" => "btn-red"]) }}
						</div>
						<div class="btn-wrap icon-left">
							<span class="icon white left-arrow"></span>
							<a href="/" class="btn-green">Back</a>
						</div>
					</div>
				{{ Form::close() }}
                <div class="smaller-text alone foot">
                    <p><a href="#">User Guide</a> | <a href="#">Comments</a></p>
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
