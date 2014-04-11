@section ("header")
    <div class="header">
        <div class="container grid">
            <div class="grid-2"><h1 class="app-heading">iBLIS 1.0</h1></div>
            <div class="grid-2  user-profile">
                @if (Auth::check())
                    <a href="{{ URL::route("user/logout") }}">
                        Logout
                    </a>
                    |
                    <a href="{{ URL::route("user/profile") }}">
                        Profile
                    </a>
                @endif
            </div>
        </div>
    </div>
@show