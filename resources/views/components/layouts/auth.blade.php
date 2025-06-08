<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>

    @livewireStyles

    <link rel="icon" href="favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">

    {{-- Add this  --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/imask"></script>


</head>

<body class="font-sans antialiased">



    {{-- The main content with `full-width` --}}
    <x-main with-nav full-width>
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{--  TOAST area --}}
    <x-toast />

    @livewireScripts

</body>

</html>
