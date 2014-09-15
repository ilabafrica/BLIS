<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/ui-lightness/jquery-ui-min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-theme.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/layout.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-datetimepicker.min.css') }}" />
        <script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/jquery-ui-min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/moment.js') }}    "></script>
        <script type="text/javascript" src="{{ URL::asset('js/bootstrap-datetimepicker.min.js') }}    "></script>
        <script type="text/javascript" src="{{ URL::asset('js/script.js') }}    "></script>
        <!-- Datatables Scripts -->
        {{ HTML::style('datatables/jquery.dataTables.css') }}
        {{ HTML::script('datatables/jquery.js') }}
        {{ HTML::script('datatables/jquery.dataTables.min.js') }}
        {{ HTML::style('datatables/dataTables.bootstrap.css') }}
        {{ HTML::script('datatables/dataTables.bootstrap.js') }}
        <!-- End datatables scripts -->
        <title>{{ Config::get('kblis.name') }} {{ Config::get('kblis.version') }}</title>
    </head>
    <body>
        <div id="wrap">
            @include("header")
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2 sidebar">
                        @include("sidebar")
                    </div>
                    <div class="col-md-10 col-md-offset-2 main" id="the-one-main">
                        @yield("content")
                    </div>
                </div>
            </div>
        </div>
        @include("footer")
    </body>
</html>