<!DOCTYPE html>
<html lang="en" ng-app="iBlis">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="{{ Config::get('kblis.favicon') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/ui-lightness/jquery-ui-min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-theme.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/dataTables.bootstrap.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/layout.css') }}" />
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-multiselect.css') }}" />
        <script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/jquery-ui-min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/jquery.dataTables.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/bootstrap-timepicker.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/dataTables.bootstrap.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/script.js') }} "></script>
        <script type="text/javascript" src="{{ URL::asset('js/html.sortable.min.js') }} "></script>
        <!-- jQuery barcode script -->
        <script type="text/javascript" src="{{ asset('js/jquery-barcode-2.0.2.js') }} "></script>
        <title>{{ Config::get('kblis.name') }} {{ Config::get('kblis.version') }}</title>
    </head>
    <body  class="ng-cloak">
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
    <script src="{{ URL::asset('bower_components/angular/angular.js')}}"></script>
    <script src="{{ URL::asset('bower_components/angular-route/angular-route.js')}}"></script>
    <script src="{{ URL::asset('js/app.js')}}"></script>
    <script src="{{ URL::asset('js/ReportsController.js')}}"></script>
    <script src="{{ URL::asset('js/ReportsFactory.js')}}"></script>
    <script src="{{ URL::asset('js/bootstrap-multiselect.js')}}"></script>
</html>
