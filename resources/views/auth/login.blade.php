<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <meta charset="utf-8"/>
        <title>{!! Config::get('blis.organization') !!}</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <link href="{!! asset('css/vendor.css') !!}" rel="stylesheet">
        <link href="{!! asset('css/style.css') !!}" rel="stylesheet">
        <link href="{!! asset('css/bootstrap.css') !!}" rel="stylesheet">
        <link href="{!! asset('css/font.css') !!}" rel="stylesheet">
        <link href="{!! asset('css/custom.css') !!}" rel="stylesheet">
    </head>
    <body class="page-header-fixed page-quick-sidebar-over-content ">
    <div class="back">
        <div class="login-outer">
            <div class="login-wrap">
                <div class="login-right striped-bg">
                    <div class="row">
                        <div class="col-md-12 col-sm-offset-3">
                            <img src="{!! Config::get('blis.organization-logo') !!}" height="60px" align="center">
                        </div>
                    </div>
                    <div class="heading col-sm-offset-1">{!! Config::get('blis.organization') !!}</div>
                    <div class="row">
                        <div class="col-md-12 col-sm-offset-1">                            
                            @if($errors)
                                @if (count($errors) > 0)
                                <div class="alert alert-danger col-sm-10">
                                    <ul class="list-unstyled"> 
                                        @foreach ($errors->all() as $error)
                                            <li>{!! $error !!}</li>
                                        @endforeach
                                    </ul>
                                </div>
                              @endif
                            @endif
                            @if (session()->has('message'))
                                <div class="alert alert-danger">
                                    <p>{!! session('message') !!}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-offset-1">
                            <form class="form-horizontal" role="form" method="POST" action="{!! url('/user/login') !!}">
                                <!-- CSRF Token -->
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                <!-- ./ csrf token -->
                                <div class="form-group row">
                                    <label for="username" class="col-sm-2 form-control-label">Username</label>
                                    <div class="col-sm-8 input-group">
                                        <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-sm-2 form-control-label">Password</label>
                                    <div class="col-sm-8 input-group">
                                        <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"> Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <button type="submit" class="btn btn-belize-hole">Sign in</button>
                                    </div>
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <a href="{{ url('/register') }}">Register</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="rightFooter">
                        <a href="#">{!! Config::get('blis.c4g-credit') !!}</a>
                    </div>
                </div>
            </div>
        </div>
        <script src="{!! asset('js/vendor.js') !!}"></script>
    </body>
</html>