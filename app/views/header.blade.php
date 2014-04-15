@section ("header")
    <div class="header">
        <div class="container grid">
            <div class="grid-2"><h1 class="app-heading">iBLIS 1.0</h1></div>
            <div class="grid-2  user-profile">
                @if (Auth::check())
                    <div class="user-link">
                        <span class="icon-2 white user"></span>
                        <a href="javascript:void()">
                            <strong>{{ Auth::user()->username }}</strong>
                        </a>
                    </div>
                    <div class="user-settings">
                        <div><span class="icon-2 white user-edit"></span><a href="{{ URL::route("user/profile") }}">Edit Profile</a></div>
                        <div><span class="icon-2 white user-logout"></span><a href="{{ URL::route("user/logout") }}">Logout</a></div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@show