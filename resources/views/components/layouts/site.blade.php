<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>@yield('title')</title>
    <link rel="icon" href="favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">

    @yield('head')

    {{-- <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title> --}}

</head>
<body class="min-h-screen font-sans antialiased bg-base-200">

    {{  $slot }}
    {{--  TOAST area --}}
    <x-toast />
</body>
</html>
