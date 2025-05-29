<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>
    @livewireStyles

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
