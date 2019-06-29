<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700">
    <link rel="stylesheet" href="/css/app.css">
    <title>{{ config('app.name', 'Laravel-Vue-Spa') }}</title>
  </head>
  <body class="antialiased text-gray-900 h-screen bg-gray-200">
    <div id="app">
    	<router-view></router-view>
    	<portal-target name="modals"></portal-target>
    </div>
    <script src="/js/app.js"></script>
  </body>
</html>
