<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="@yield('htmlClass')">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }} @yield('title')</title>

        <meta content="@yield('description')" name="description"/>
        <meta content="@yield('keywords')" name="keywords"/>
        <meta content="{{ config('app.author') }}" name="author"/>

        <!-- Icon -->
        <link rel="shortcut icon" href="{{ config('app.favicon') }}">

        <!-- Styles -->
        @yield('headImport.styles.prepend')

        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/icons.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/font.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css"/>

        @yield('headImport.styles.append')

        <!-- Scripts -->
        @yield('headImport.scripts.prepend')

        <script src="{{ asset('js/modernizr.min.js') }}"></script>

        @yield('headImport.scripts.append')

        <!-- Imports -->
        @yield('headImport')

    </head>
    <body class="@yield('bodyClass')">

        @yield('content')

        <!-- jQuery  -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>

        <!-- Popper for Bootstrap -->
        <script src="{{ asset('js/popper.min.js') }}"></script>

        <!-- Tether for Bootstrap -->
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>

        <!-- Plugins -->
        @yield('bodyImport.plugin.prepend')

        <script src="{{ asset('js/waves.js') }}"></script>

        @yield('bodyImport.plugin.append')

        <!-- App js -->
        @yield('bodyImport.prepend')

        <script src="{{ asset('js/main.js') }}"></script>

        @yield('bodyImport.append')

        <!-- Imports -->
        @yield('bodyImport')

    </body>
</html>
