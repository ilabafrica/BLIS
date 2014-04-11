<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="/css/layout.css" />
        <title>iBLIS 1.0</title>
    </head>
    <body>
        @include("header")
        <div class="main-body grid">
            <div class="left-side-bar grid-3">
                @include("sidebar")
            </div>
            <div class="content grid-3-2">
                <div class="container">
                    @yield("content")
                </div>
            </div>
        </div>
        @include("footer")
    </body>
</html>