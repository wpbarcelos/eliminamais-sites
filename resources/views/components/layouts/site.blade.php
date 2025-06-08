<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>@yield('title')</title>

    @yield('head')

    {{-- <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title> --}}

</head>
<body class="min-h-screen font-sans antialiased bg-base-200">

    {{  $slot }}
    {{--  TOAST area --}}
    <x-toast />
</body>
</html>
