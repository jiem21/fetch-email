<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Email Fetching</title>

        <!-- Style -->
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="container">
        @yield( 'content' )
    </body>
</html>
