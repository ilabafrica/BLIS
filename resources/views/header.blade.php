@section ("header")
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand">{{ Config::get('blis.name') }} {{ Config::get('blis.version') }}</a>
            </div>
            <div class="grid-2  user-profile">
                @if (Auth::check())
                    <ul class="nav navbar-nav navbar-right">
                        <li class="user-link">
                            <a href="javascript:void(0);">
                                <strong>{{ Auth::user()->name }}</strong>
                            </a>
                        </li>
                    </ul>
                    <div class="user-settings">
                        <div>
                            <span class="glyphicon glyphicon-edit"></span>
                            <a href='{{ URL::to("user/".Auth::user()->id."/edit") }}'>{{trans('messages.edit-profile')}}</a>
                        </div>
                        <div>
                            <span class="glyphicon glyphicon-log-out"></span>
                            <a href="{{ URL::route("user.logout") }}">{{trans('messages.logout')}}</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@show