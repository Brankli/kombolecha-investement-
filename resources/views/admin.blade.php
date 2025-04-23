<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Kombolcha Industry and Investement </title>
        <link rel="icon" href="{{ asset('images/logo.png') }}" sizes="256x256" type="image/png"/>


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
/>


        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    </head>
    <body >
        <div id="app"></div>
        <script src="{{mix('back.js')}}"></script>
    </body>
</html>
