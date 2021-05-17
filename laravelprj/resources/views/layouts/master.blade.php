<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="route" content="{{ $currentRouteName }}" />

    <title>Laravel 5 Essential</title>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ mix("css/app.css") }}" rel="stylesheet">
@yield('style')

    <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
</head>
<body style="background: #ffffff;">
@include('layouts.partial.navigation')

@include('layouts.partial.flash_message')

<div class="container">
    @yield('content')
</div>

@include('layouts.partial.footer')

<script src="{{ mix("js/app.js") }}"></script>
@yield('script')
</body>

</html>
