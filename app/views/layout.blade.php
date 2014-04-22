<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="/css/layout.css" />
        <link rel="stylesheet" type="text/css" href="/css/ui-lightness/jquery-ui-min.css" />
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css" />
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/jquery-ui-min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/script.js"></script>
        <title>iBLIS 1.0</title>
    </head>
    <body>
        @include("header")
        <div class="main-body grid">
            <div class="left-side-bar grid-3">
                @include("sidebar")
            </div>
            <div class="content grid-3-2 main-area">
                <div class="container">
                    @yield("content")
                </div>
            </div>
        </div>
        @include("footer")
    </body>
</html>