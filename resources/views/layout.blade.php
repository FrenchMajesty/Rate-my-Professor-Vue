<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Victron Tech</title>
        <link rel="stylesheet" type="text/css" href="{{asset('public/css/app.css')}}">
    </head>
    <body>
        <div id="app">
            <router-view></router-view>
        </div>
        <script type="text/javascript">
        </script>
        <script type="text/javascript" src="{{asset('public/js/app.js')}}"></script>
        
    </body>
</html>
